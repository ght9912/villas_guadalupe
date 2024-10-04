<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospectos;
use App\Models\User;
use App\Models\Vendedores;
use App\Models\Actividades;
use App\Models\ActividadesDatos;
use App\Models\lote;
use App\Models\ProcesoVenta;
use App\Models\Embudos;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientesMail;
use App\Mail\WelcomeClienteMail as MailW;
use App\Models\clientes;
use App\Mail\OfertasMail;
use Barryvdh\DomPDF\Facade\Pdf;





class ProspectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            "admin" => false
        ];

        if (auth()->user()->isAdmin) {
            $data["admin"] = true;
        }

        $prospectos = Prospectos::all();
        $data["prospectos"] = $prospectos;
        $embudos = Embudos::all();
        $data["embudos"] = $embudos;

        return view('prospectos', $data);
    }


    public function tablaProspecto(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Filas mostradas por página
        $columnIndex = $request->get('order')[0]['column'] ?? 0; // Índice de columna
        $columnName = $request->get('columns')[$columnIndex]['data']; // Nombre de la columna
        $columnSortOrder = $request->get('order')[0]['dir'] ?? "asc"; // asc o desc
        $searchValue = $request->get('search')['value']; // Valor de búsqueda
        $id_Embudo = $request->get('id_Embudo'); // Valor del embudo seleccionado

        $query = Prospectos::with('procesoVenta');

        if ($id_Embudo) {
            $query->whereHas('procesoVenta', function($q) use ($id_Embudo) {
                $q->where('id_embudo', $id_Embudo);
            });
        }

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('id', 'like', '%'.$searchValue.'%')
                ->orWhere('nombre', 'like', '%'.$searchValue.'%')
                ->orWhere('telefono', 'like', '%'.$searchValue.'%')
                ->orWhere('email', 'like', '%'.$searchValue.'%')
                ->orWhereHas('procesoVenta', function($q2) use ($searchValue) {
                    $q2->where('status', 'like', '%'.$searchValue.'%');
                });
            });
        }

        $totalRecords = Prospectos::where('status', 0)->count();
        $totalRecordwithFilter = $query->count();

        $prospecto = $query->orderBy($columnName, $columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data = [];

        foreach($prospecto as $p) {
            $data[] = [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'telefono' => $p->telefono,
                'email' => $p->email,
                'status' => $p->procesoVenta ? $p->procesoVenta->status : 'Sin proceso asignado',
                'acciones' =>   '<div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton'. $p->id .'">
                                        <li><a class="dropdown-item" onclick="editProspecto('.$p->id.', this)">Editar</a></li>
                                        <li><a class="dropdown-item" onclick="deleteProspecto('.$p->id.', this)">Eliminar</a></li>
                                        <li><a class="dropdown-item" onclick="volverCliente('.$p->id.', this)">Conversión de prospecto a cliente</a></li>
                                        <li><a class="dropdown-item" onclick="crearOferta('.$p->id.', this)">Crear oferta a prospecto</a></li>
                                    </ul>
                                </div>',
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at
            ];
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $p=new Prospectos();
        $p->nombre = $r->nombre;
        $p->telefono = $r->telefono;
        $p->email = $r->email;
        $p->data =$r->data;

        $proceso = ProcesoVenta::where('id_embudo', $r->id_embudo)
                ->where('orden', 1)
                ->first();

        if ($proceso) {
            $p->status = $proceso->id;
        } else {
            $p->status = 0;
        }

        $p->save();

        $this->registrarActividad('Creación de prospecto', $p);

        return response()->json([
            'message' => 'Prospecto guardado con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prospectos  $ProcesoVenta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prospecto = Prospectos::find($id);

        if (!$prospecto) {
            return response()->json(['message' => 'Prospecto no encontrado'], 404);
        }

        return response()->json($prospecto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prospectos  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $p = Prospectos::find($id);

        $oldData = $p->toArray();

        $p->nombre = $r->nombre;
        $p->telefono = $r->telefono;
        $p->email = $r->email;
        $p->data = $r->data;
        $p->save();

        $dataUpdate = [ "old" => $oldData,
                        "new" => $p,
        ];

        $this->registrarActividad('Edición del prospecto', $dataUpdate);


        return response()->json([
            'message' => 'Informacion de prospecto modificada con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prospectos  $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $p = Prospectos::find($id);
            $oldData = $p->toArray();
            $p->delete();

            $this->registrarActividad('Eliminación de prospecto', $oldData);


           return response()->json([
                'message' => 'CaracteristicaE eliminada con exito',
                'data' => [],
                'status' => 200,
            ],200);
    }

    protected function registrarActividad($movimiento, $data)
    {
        $userId = Auth::id();

        $actividad = new Actividades();
        $actividad->id_user = $userId;
        $actividad->movimiento = $movimiento;
        $actividad->save();

        $actividadDatos = new ActividadesDatos();
        $actividadDatos->id_actividad = $actividad->id;
        $actividadDatos->data = $data;
        $actividadDatos->save();
    }

    public function validarCorreo(Request $r)
    {
        $exists = User::where('email', $r->email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function Cliente(Request $r, $id)
    {
        $status = (int) $r->status;

        $r->validate([
            'nombrePro' => 'required',
            'telefonoPro' => 'required',
            'emailPro' => 'required|email|unique:users,email',
        ]);

        $idProspecto = intval($id);

        $newData = [
            'id' => $idProspecto,
            'nombre' => $r->nombrePro,
            'telefono' => $r->telefonoPro,
            'email' => $r->emailPro,
            'status' => $status,
        ];

        $contrasenaAlt = $this->contrasenaAlt();

        $user=User::create([
            'name' =>  $r->nombrePro,
            'email' => $r->emailPro,
            'password' => Hash::make($contrasenaAlt),
        ]);

        // Mail::to($user->email)->send(new ClientesMail($r->nombrePro, $contrasenaAlt));

        $c= new clientes();
        $c->user_id = $user->id;
        $c->nombre = $r->nombrePro;
        $c->tipo = "Prospecto";
        $c->email = $r->emailPro;
        $c->celular = $r->telefonoPro;
        $c->save();

        $p = Prospectos::find($id);
        $p->id = $id;
        $p->nombre = $r->nombrePro;
        $p->telefono = $r->telefonoPro;
        $p->email = $r->emailPro;
        $p->status = $status;
        $p->update();

        $UserEmail = Auth::user()->email;
        $vendedor = Vendedores::where('email', $UserEmail)->first();
        $vendedorId = $vendedor ? $vendedor->id : null;

        $a = new Actividades();
        $a->id_vendedor = $vendedorId;
        $a->movimiento = 'Conversión de prospecto a cliente';
        $a->save();

        $aD = new ActividadesDatos();
        $aD->id_actividad = $a->id;
        $aD->data = ($newData);
        $aD->save();

        return response()->json([
            'message' => 'Cliente creado con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

        /**
     * Genera una contrasena aleatoria.
     *
     * @param  Integer  $longitud
     * @return String
     */
    public function contrasenaAlt($longitud = 10)
    {

        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}[]|';
        $contrasena = '';

        // Añadir al menos una letra mayúscula
        $contrasena .= $caracteres[rand(26, 51)];

        // Añadir al menos una letra minúscula
        $contrasena .= $caracteres[rand(0, 25)];

        // Añadir al menos un carácter especial
        $contrasena .= $caracteres[rand(52, strlen($caracteres) - 1)];

        // Completar la longitud de la contraseña
        while (strlen($contrasena) < $longitud) {
            $contrasena .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Mezclar los caracteres para mayor aleatoriedad
        $contrasena = str_shuffle($contrasena);

        return $contrasena;



    }

    public function sendOferta(Request $r, $id)
    {
        $r->validate([
            'nombreProspecto' => 'required',
            'telefonoProspecto' => 'required',
            'emailProspecto' => 'nullable|email|unique:users,email,' . $id,
        ]);

        $p = Prospectos::find($id);
        $oldData = $p->toArray();

        $idProspecto = intval($id);

        $newData = [
            'id' => $idProspecto,
            'nombre' => $r->nombreProspecto,
            'telefono' => $r->telefonoProspecto,
            'email' => $r->emailProspecto,
        ];

        $updated = false;
        foreach ($newData as $key => $value) {
            if ($oldData[$key] !== $value) {
                $p->$key = $value;
                $updated = true;
            }
        }

        if ($updated) {
            $dataUpdate = [ "old" => $oldData,
                            "new" => $newData,

            ];

            $p->save();

            $UserEmail = Auth::user()->email;
            $vendedor = Vendedores::where('email', $UserEmail)->first();
            $vendedorId = $vendedor ? $vendedor->id : null;

            $a = new Actividades();
            $a->id_vendedor = $vendedorId;
            $a->movimiento = 'Edición de prospecto';
            $a->save();

            $aD = new ActividadesDatos();
            $aD->id_actividad = $a->id;
            $aD->data = $dataUpdate;
            $aD->save();
        }

        $lote = Lote::find($r->loteId);

        $user = auth()->user()->name;

        $data =[
            "precio" => $r->precio,
            "pago" => $r->pago,
            "anualidad" =>$r->anualidad,
            "meses" => $r->plazo,
            "proyecto" => $lote->proyecto->nombre,
            "etapa" => $lote->etapa->e_name,
            "manzana" => $lote->manzana,
            "lote" => $lote->lote,
            "nombre" => $r->nombreProspecto,
            "enganche" => $r->enganche,
            ];

        $pdf = Pdf::loadView('pdf.amortizacion', $data);
        $archivo = $pdf->output();

        Mail::to($r->emailProspecto)->send(new OfertasMail ($user,$archivo,$data));

        $UserEmail = Auth::user()->email;
        $vendedor = Vendedores::where('email', $UserEmail)->first();
        $vendedorId = $vendedor ? $vendedor->id : null;

        $a = new Actividades();
        $a->id_vendedor = $vendedorId;
        $a->movimiento = 'Creación de oferta a prospecto';
        $a->save();

        $aD = new ActividadesDatos();
        $aD->id_actividad = $a->id;
        $aD->data = ($data);
        $aD->save();

        return response()->json([
            'message' => 'Oferta creada con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

    public function previewOferta(Request $r)
    {
        $lote = Lote::find($r->loteId);

        $data = [
            "precio" => $r->precio,
            "pago" => $r->pago,
            "anualidad" => $r->anualidad,
            "meses" => $r->plazo,
            "proyecto" => $lote->proyecto->nombre,
            "etapa" => $lote->etapa->e_name,
            "manzana" => $lote->manzana,
            "lote" => $lote->lote,
            "nombre" => $r->nombreProspecto,
            "enganche" => $r->enganche,
        ];

        $pdf = Pdf::loadView('pdf.amortizacion', $data);

        return $pdf->stream('amortizacion.pdf');
    }

    // public function showProcesoVenta()
    // {
    //     $procesoVenta = ProcesoVenta::orderByRaw('ISNULL(orden), orden ASC')->get();
    //     return response()->json($procesoVenta);
    // }

    public function embudosSinFormulario()
    {
        $embudosSinFormulario = Embudos::whereNull('formulario')
            ->orWhere('formulario', '=', '[]')
            ->orWhere('formulario', '=', '')
            ->orWhere('formulario', null)
            ->get();

        return response()->json($embudosSinFormulario);
    }

    public function embudosConFormulario()
    {
        $embudosConFormulario = Embudos::whereNotNull('formulario')
                    ->orwhere('formulario', '!=', '[]')
                    ->orWhere('formulario', '!=', '{}')
                    ->orWhere('formulario', '!=', null)
                    ->get();

        return response()->json($embudosConFormulario);
    }

}
