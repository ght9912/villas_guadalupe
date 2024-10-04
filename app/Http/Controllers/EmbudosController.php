<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcesoVenta;
use App\Models\User;
use App\Models\Actividades;
use App\Models\ActividadesDatos;
use App\Models\Vendedores;
use App\Http\Controllers\Controller;
use App\Models\Embudos;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class EmbudosController extends Controller
{
    public function index()
    {
        $embudos = Embudos::all();

        $data = [
            "embudos" => $embudos,
            "recursos" => []
        ];

        return view("embudos", $data);
    }

    public function tablaEmbudo(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Filas mostradas por página
        $columnIndex = $request->get('order')[0]['column'] ?? 0; // Índice de columna
        $columnName = $request->get('columns')[$columnIndex]['data']; // Nombre de la columna
        $columnSortOrder = $request->get('order')[0]['dir'] ?? "asc"; // asc o desc
        $searchValue = $request->get('search')['value']; // Valor de búsqueda

        // Filtro de búsqueda
        $query = Embudos::query();

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('id', 'like', '%'.$searchValue.'%')
                ->orWhere('nombre', 'like', '%'.$searchValue.'%')
                ->orWhere('descripcion', 'like', '%'.$searchValue.'%');
            });
        }

        $totalRecords = Embudos::count();
        $totalRecordwithFilter = $query->count();

        $procesosVenta = $query->orderBy($columnName, $columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
        $data = [];

        foreach($procesosVenta as $p){
            $data[] =[
                'id' => $p->id,
                'nombre' => $p->nombre,
                'descripcion' => $p->descripcion,
                'acciones' =>   '<div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $p->id }}">
                                        <li><a class="dropdown-item" onclick="editEmbudo('.$p->id.',this)">Editar</a></li>
                                        <li><a class="dropdown-item"  onclick="deleteEmbudo('.$p->id.',this)">Eliminar</a></li>
                                        <li><a class="dropdown-item"  onclick="orderPro('.$p->id.',this)">Organizar procesos</a></li>                            </ul>
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
        $r->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $em=new Embudos();
        $em->nombre = $r->nombre;
        $em->descripcion = $r->descripcion;
        $em->save();

        $this->registrarActividad('Creación de embudo', $em);

        return response()->json([
            'message' => 'Embudo generado con exito',
            'data' => $em,
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Embudos  $Embudos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $embudo = Embudos::find($id);

        return response()->json($embudo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Embudos  $Embudos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $em = Embudos::find($id);
        $oldData = $em->toArray();
        $em->nombre = $r->nombre;
        $em->descripcion = $r->descripcion;
        $em->save();

        $dataUpdate = [ "old" => $oldData,
                        "new" => $em,
        ];

        $this->registrarActividad('Edición del embudo', $dataUpdate);

        return response()->json([
            'message' => 'Actualizado con exito',
            'data' => $em,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Embudos  $Embudos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procesosExistentes = ProcesoVenta::where('id_embudo', $id)->get();
        foreach ($procesosExistentes as $pros) {
            $oldPro = $pros->toArray();
            $pros->delete();

            $this->registrarActividad('Eliminación de proceso', [$oldPro]);
        }

        $em = Embudos::find($id);
        $oldData = $em->toArray();

        if (!$em) {
            return response()->json([
                'message' => 'Embudo no encontrado',
                'status' => 404,
            ], 404);
        }

        $em->delete();

        $this->registrarActividad('Eliminación de embudo', $oldData);

        return response()->json([
            'message' => 'Eliminado con éxito',
            'status' => 200,
        ], 200);
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


    public function showPros($id)
    {
        $procesos = ProcesoVenta::where('id_embudo', $id)
            ->orderByRaw('ISNULL(orden), orden ASC')
            ->get();

        return response()->json($procesos);
    }

    public function ordenProcesos(Request $r)
    {
        $idEmb = $r->id_embudo;

        $procesos = ProcesoVenta::where('id_embudo', $idEmb)
            ->orderBy('orden', 'ASC')
            ->get();

        $oldPros = $procesos->toArray();

        $ordenesMap = [];
        foreach ($r->orden as $o) {
            $ordenesMap[$o['id']] = $o['orden'];
        }

        foreach ($procesos as $proceso) {
            if (isset($ordenesMap[$proceso->id])) {
                $proceso->orden = $ordenesMap[$proceso->id];
                $proceso->save();
            }
        }

        $NewPro = ProcesoVenta::where('id_embudo', $idEmb)
            ->orderBy('orden', 'ASC')
            ->get();

        $newPros = $NewPro->toArray();

        $dataUpdate = [
            "old" => $oldPros,
            "new" => $newPros,
        ];

        $this->registrarActividad('Cambio de orden de procesos', $dataUpdate);

        return response()->json(['message' => 'Orden actualizado exitosamente'
                                    ,'data' => $idEmb,
        ], 200);
    }

    public function guardarCamposEmbudo(Request $r)
    {
        $embudo = Embudos::find($r->embudo_id);
        $datosEmbudo = "{$embudo->id}";

        $embudo->formulario = json_encode($r->campos_personalizados);
        $embudo->save();

        $accion = ($r->movimiento === 'create') ? "Formulario creado" : "Formulario editado";
        $this->registrarActividad("{$accion}, {$datosEmbudo}", $embudo);

        return response()->json(['success' => true]);
    }


}
