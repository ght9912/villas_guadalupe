<?php

namespace App\Http\Controllers;

use App\Imports\ClientesImport;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\clientes;
use App\Models\proyectos;
use App\Models\etapas;
use App\Models\lote;
use App\Models\User;
use App\Models\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientesMail;
use App\Mail\WelcomeClienteMail as MailW;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OfertasMail;
use App\Models\Contratos;
use App\Models\Pagos;

class ClientesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $usuarios= User::all();
            $ofertas= Ofertas::all();
            $etapas= etapas::all();
            $lotes= lote::all();
            $proyectos= proyectos::all();
            $clientes = clientes::all()->map(function($e){
                $e->lotes;
                $e->contratos;
                $e["lotesid"] =$e->contratos->map(function($e){
                    return $e->id_lote;
                });

                return $e;
            });

            $data=["clientes"=>$clientes,"recursos"=>[
                "usuarios"=>$usuarios,
                "ofertas"=>$ofertas,
                "proyectos"=>$proyectos,
                "etapas"=>$etapas,
                "lotes"=>$lotes
                ]
            ];
            return view("clientes",$data);
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

            'email' => 'required|email|unique:users,email',
            'celular' => 'required',
        ]);
        //validar que el email no se haya registrado antes

        $contrasenaAlt = $this->contrasenaAlt();

        $user=User::create([
            'name' =>  $r->nombre,
            'email' => $r->email,
            'password' => Hash::make($contrasenaAlt),
        ]);

        Mail::to($user->email)->send(new ClientesMail($r->nombre, $contrasenaAlt));

        $c= new clientes();
        $c->id = $r->id;
        $c->user_id = $user->id;
        $c->nombre = $r->nombre;
        $c->tipo = "Prospecto";
        $c->email = $r->email;
        $c->direccion = $r->direccion;
        $c->celular = $r->celular;
        $c->save();
        $c->usuario;


        return response()->json([
            'message' => 'cliente y usuario agregado',
            'data' => $c,
            'status' => 200,
        ],200);

    }
    /**
     * Genera una contrasena aleatoria.
     *
     * @param  Integer  $longitud
     * @return String
     */
    public function contrasenaAlt($longitud = 10) {

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
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(clientes $clientes)
    {
       $clientes = clientes::all();

        return response()->json($clientes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'nombre' => 'required',
            'email' => 'required',
            'celular' => 'required',

        ]);

        $c = clientes::find($id);
        $c->nombre = $r->nombre;
        $c->tipo = $r->tipo;
        $c->email = $r->email;
        $c->direccion = $r->direccion;
        $c->celular = $r->celular;
        $c->update();
        $c->usuario;

        return response()->json([
            'message' => 'Informacion de cliente actualizada',
            'data' => $c,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = clientes::find($id);
        $c->delete();
        return response()->json([
            'message' => 'Cliente eliminado con exito',
            'data' => [],
            'status' => 200,
        ],200);
    }

    public function saveFromUser(Request $r)
    {
        $r->validate([
            'id' => 'required',
        ]);

        $user = User::find($r->id);
        $c = new clientes();
        $c->user_id= $user->id;
        $c->nombre= $user->name;
        $c->tipo = "Prospecto";
        $c->email = $user->email;
        $c->save();

        Mail::to($user->email)->send(new MailW($r->nombre));

        return response()->json([
            'message' => 'cliente agregado',
            'data' => $c,
            'status' => 200,
        ],200);
    }

    public function search(Request $request) {
        $busqueda = $request->busqueda;

        $clientes = Clientes::where('nombre', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('email', 'LIKE', '%' . $busqueda . '%')
            ->get();

        return $clientes;
    }



    public function impoexpo() {
        $usuarios= User::all();
        $clientes = clientes::all()->map(function($e){
            $e->usuario;
            return $e;
        });

        $data=["clientes"=>$clientes,"recursos"=>["usuarios"=>$usuarios]];
        return view("clientes",$data);
    }

    public function importar(Request $re) {

        $re->validate([
            "documento" => 'required'
        ]);

        if ($re->file('documento')->isValid()){
            $path = $re->file('documento')->getRealPath();
            $datos = Excel::toCollection(new ClientesImport, $re->file('documento'));


            $Completos = [];
            $Incompletos = [];
            $CorreoUsados = [];
            $CorreoDuplicados = [];
            $datosSinDuplicados =[];
            $GravesRaw =[];
            $Graves =[];
            $emails = [];
            $noSonEmail = [];

            foreach ($datos[0] as $i => $row) {
                if ($i >= 8) {
                    if ($i > 0 && isset($row[2])) {
                        $email = $row[2];
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            if (!isset($emails[$email])) {
                                $emails[$email] = [];
                            }
                            $emails[$email][] = $row;
                        } else {
                            $noSonEmail[] = (object) $row;
                        }
                    } else {
                        if ($i > 0) {
                            $datosSinDuplicados[] = $row;
                        }
                    }
                }
            }

            foreach ($emails as $email => $rows) {
                if (count($rows) > 1) {
                    $CorreoDuplicados = array_merge($CorreoDuplicados, $rows);
                } else {
                    $datosSinDuplicados = array_merge($datosSinDuplicados, $rows);
                }
            }

            foreach ($datosSinDuplicados as $i => $row) {
                if ($row != null && $i > 0) {
                    if ($row != null && isset($row[4])) {
                        $columnasCompletas = true;
                        foreach ($row as $columna) {
                            if ($columna === null || $columna === '') {
                                $columnasCompletas = false;
                                break;
                            }
                        }

                        $correo = User::where('email', $row[2])->first();

                        if ($correo) {
                            $CorreoUsados[] = $row;
                        } else {
                            if ($columnasCompletas) {
                                $Completos[] = $row;
                            } else {
                                $Incompletos[] = $row;
                            }
                        }
                    } else {
                        $GravesRaw[] = $row;
                    }
                }
            }

            foreach ($GravesRaw as $row) {
                $datoEncontrado = false;
                for ($i = 0; $i < 5; $i++) {
                    if (isset($row[$i]) && ($row[$i] !== null && $row[$i] !== '')) {
                        $datoEncontrado = true;
                        break;
                    }
                }
                if ($datoEncontrado) {
                    $Graves[] = $row;
                }
            }

            foreach ($Incompletos as $in) {
                if (empty($in[0])) {
                    $in[0] = 'Falta Nombre';
                }
                if (empty($in[1])) {
                    $in[1] = 'Falta Tipo';
                }
                if (empty($in[2])) {
                    $in[2] = 'Falta Email';
                }
                if (empty($in[3])) {
                    $in[3] = 'Falta Dirección';
                }
                if (empty($in[4])) {
                    $in[4] = 'Falta Numero';
                }
            }

            foreach ($Graves as $gr) {
                if (empty($gr[0])) {
                    $gr[0] = 'Falta Nombre';
                }
                if (empty($gr[1])) {
                    $gr[1] = 'Falta Tipo';
                }
                if (empty($gr[2])) {
                    $gr[2] = 'Falta Email';
                } if (empty($gr[3])) {
                    $gr[3] = 'Falta Dirección';
                } if (empty($gr[4])) {
                    $gr[4] = 'Falta Celular';
                }
            }

            foreach ($noSonEmail as $ne) {
                if (empty($ne[0])) {
                    $ne[0] = 'Falta Nombre';
                }
                if (empty($gr[1])) {
                    $ne[1] = 'Falta Tipo';
                }
                if (empty($gr[2])) {
                    $ne[2] = 'Falta Email';
                } if (empty($gr[3])) {
                    $ne[3] = 'Falta Dirección';
                } if (empty($gr[4])) {
                    $ne[4] = 'Falta Celular';
                }
            }

            foreach ($Completos as $c) {

                $contrasenaAltImp = $this->contrasenaAlt();

                $user = new User([
                    'name'     => $c[0],
                    'email'    => $c[2],
                    'password' => Hash::make($contrasenaAltImp),
                ]);
                $user->save();
                //  Mail::to($user->email)->send(new ClientesMail($user->name, $contrasenaAltImp));

                $cliente = new clientes();
                $cliente->user_id = $user->id;
                $cliente->nombre = $c[0];
                $cliente->tipo = $c[1];
                $cliente->email = $c[2];
                $cliente->direccion = $c[3];
                $cliente->celular = $c[4];
                $cliente->save();
            }

            $completosTotal = count($Completos);
            $incompletosTotal = count($Incompletos)+count($Graves);
            $correoUsadosTotal = count($CorreoUsados);
            $correoDuplicadosTotal = count($CorreoDuplicados);
            $noSonEmailTotal = count($noSonEmail);


            return view("importClientesReport", [
                    'completos' => $Completos,
                    'incompletos' => $Incompletos,
                    'correoUsados' => $CorreoUsados,
                    'graves' => $Graves,
                    'correoDuplicados' => $CorreoDuplicados,
                    'no_son_correo' => $noSonEmail,
                    'completos_total' => $completosTotal,
                    'incompletos_total' => $incompletosTotal,
                    'correoUsados_total' => $correoUsadosTotal,
                    'correoDuplicados_total' => $correoDuplicadosTotal,
                    'no_son_correo_total' => $noSonEmailTotal,

            ]);

            }
    }

    public function cont() {
        $usuarios= User::all();
        $clientes = clientes::all()->map(function($e){
            $e->usuario;
            return $e;
        });

        $data=["clientes"=>$clientes,"recursos"=>["usuarios"=>$usuarios]];
        return view("clientes",$data);
    }

    public function getOfertasCliente($id) {
        $ofertas = Ofertas::with('proyecto', 'etapa', 'lote','cliente')
                    ->where('cliente_id', $id)
                    ->get();

        $ofertas = $ofertas->map(function ($oferta) {
            $nombreEtapa = optional($oferta->etapa)->e_name ?? ($oferta->etapa)->etapa;

            $tipoPago = $oferta->pago === 'FinanciadoPE' ? 'Financiado' : (
                $oferta->pago === 'Financiado' ? 'Financiado' : (
                    $oferta->pago === 'ContadoPE' ? 'Contado' : (
                    $oferta->pago === 'FinanciadoPEA' ? 'Financiado con Anualidad' : (
                    $oferta->pago === 'FinanciadoA' ? 'Financiado con Anualidad' : 'Contado'
                )
                )
                )
            );

            $precioFor = number_format($oferta->precio, 2);

            $nombre = $oferta->cliente->nombre;
            $email = $oferta->cliente->email;
            $celular = $oferta->cliente->celular;

            return [
                'id' => $oferta->id,
                'proyecto' => $oferta->proyecto->id,
                'zona' => $oferta->etapa->id,
                'manzana' => $oferta->lote->manzana,
                'lote' => $oferta->lote,
                'pago' => $tipoPago,
                'precio' => "$".$precioFor,
                'precioNum' => $oferta->precio,
                'plazo' => $oferta->plazo,
                'anualidadNum' => $oferta->anualidad,
                'nombre' => $nombre,
                'email' => $email,
                'cel' => $celular,
                'engancheNum' =>$oferta->enganche,
                'proyecto_id'=> $oferta->proyecto->nombre,
                'zona_id'=> $nombreEtapa,
                'lote_id'=> $oferta->lote->lote,
            ];
        });

        return response()->json(['ofertas' => $ofertas]);
    }

        /**
         * Ofertas del cliente.
        *
        * @param  string $cliente
        * @return any
        */
    public function sendEmail(Request $r)
    {
        $user = auth()->user()->name;
        $data = [
            "precio" => $r->precio,
            "pago" => $r->pago,
            "anualidad" =>$r->anualidad,
            "meses" => $r->plazo,
            "proyecto" => $r->proyecto_id,
            "etapa" => $r->zona_id,
            "manzana" => $r->manzana,
            "lote" => $r->lote_id,
            "nombre" => $r->nombre,
            "enganche" => $r->enganche,
            ];

        $pdf = Pdf::loadView('pdf.amortizacion', $data);
        $archivo = $pdf->output();

        $response = $this::sendWhatsapp($r->celular);

        Mail::to($r->email)->send(new OfertasMail
        ($user,$archivo,$data));

        return response()->json([
             'message' => 'Correo enviado con exito',
             'data' => $data,
             'status' => 200,
             'WA response' => $response
        ],200);
    }
        /**
         * Email Ofertas del cliente.
        *
        * @param  string $cliente
        * @return any
        */

        public function estadoCuenta($id, $id_lote)
        {

            $total_pagado = 0;
            $p = Pagos::where("id_cliente",$id)->where("id_lote",$id_lote)->get()->map(function($e) {
                return $e;
            });
            $c = Contratos::where("id_lote",$id_lote)->first();
            $cl = clientes::where("id",$id)->first();
            $l = lote::where("id",$id_lote)->first();
            $l->proyecto;
            $l->etapa;
            $datos = json_decode((string)$c->objeto);
            //return [$l,$c,$cl];

            $mensualidades = [];
            $anualidades = [];
            $enganches = [];
            $otros = [];
            $extras = [];
            $generales = [];
            $apartados = [];

            foreach ($p as $pago) {
                $concepto = strtolower($pago['concepto']);

                    if (strpos($concepto, 'mensualidad') !== false) {
                        $mensualidades[] = $pago;
                    } elseif (strpos($concepto, 'anualidad') !== false) {
                        $anualidades[] = $pago;
                    } elseif (strpos($concepto, 'enganche') !== false) {
                        $enganches[] = $pago;
                    } elseif (strpos($concepto, 'apartado') !== false) {
                        $apartados[] = $pago;
                    } elseif (strpos($concepto, 'otros') !== false) {
                        $otros[] = $pago;
                    }
                }

                foreach ($otros as $o) {
                    $concepto = strtolower($o['concepto']);

                    if (strpos($concepto, 'otros: extras') !== false) {
                        $extras[] = $o;
                    } elseif (strpos($concepto, 'otros: extras') === false) {
                        $generales[] = $o;
                    }
                }

            $sumaMensualidades = array_sum(array_column($mensualidades, 'total_pago'));
            $sumaAnualidades = array_sum(array_column($anualidades, 'total_pago'));
            $sumaEnganches = array_sum(array_column($enganches, 'total_pago'));
            $sumaGenerales = array_sum(array_column($generales, 'total_pago'));
            $sumaExtras = array_sum(array_column($extras, 'total_pago'));
            $sumaApartados = array_sum(array_column($apartados, 'total_pago'));


            $objetoArray = json_decode($c->objeto, true);

            $plazo = $objetoArray["Meses"];
            $anualidad = floatval($objetoArray["l_anualidad"]);
            $mensualidad = floatval($objetoArray["l_mensualidad"]);
            $engancheArray = $objetoArray["enganches"] ?? [];
            $sumaEnganchesCon = 0;
            $sumaEnganchesPag = 0;

                foreach ($engancheArray as $eng) {
                    $cantidad = floatval($eng["cantidad"]);
                    $sumaEnganchesCon += $cantidad;
                }

                foreach ($enganches as $eng) {
                    $cantidad = floatval($eng["total_pago"]);
                    $sumaEnganchesPag += $cantidad;
                }

                $eng_faltante = ($sumaEnganchesCon) - ($sumaEnganchesPag);
                $Total_a_pagar = ($c->total)-($sumaEnganchesCon);

                $total_pagado = $sumaMensualidades + $sumaAnualidades + $sumaEnganches + $sumaApartados + $sumaExtras;
                $saldo = $c->total-$total_pagado;

                $Total_eng_apar = ($sumaApartados) + ($sumaEnganches);


                $meses = explode(" ", $plazo)[0];


                $plazoConPalabra = $meses . " MENSUALIDADES";

            $data =[
                "precio" => $c->total,
                "pago" => 2,
                "anualidad" => 12,
                "meses" => 12,
                "proyecto" => $l->proyecto->nombre,
                "etapa" => $l->etapa->e_name,
                "manzana" => $l->manzana,
                "lote" => $l->lote,
                "nombre" => $cl->nombre,
                "saldo" =>  $saldo,
                "pagado" => $total_pagado,
                "id_con" => $objetoArray["numcont"],
                "mensualidades" => $mensualidades,
                "anualidades" => $anualidades,
                "enganches" => $enganches,
                "otros" => $otros,
                "generales" =>$generales,
                "plazo" => $plazoConPalabra,
                "mensualidad" => $mensualidad,
                "anualidadPag" => $anualidad,
                "EngTotalCon" => $sumaEnganchesCon,
                "EngTotalPag" => $sumaEnganchesPag,
                "TotalPagar" => $Total_a_pagar,
                "eng_faltante" => $eng_faltante,
                "l_fecha" => $objetoArray["l_fecha"],
                "sumaMen" => $sumaMensualidades,
                "sumaAnu" => $sumaAnualidades,
                "sumaEng" => $sumaEnganches,
                "sumaExc" => $sumaExtras,
                "sumaGen" => $sumaGenerales,
                "Total_eng_apar" => $Total_eng_apar,

                ];

            $pdf = Pdf::loadView('pdf.edo-cuenta', $data);
            return $pdf->stream();
            return view('pdf.edo-cuenta', $data);

            // return ($data);


        }

        public static function sendWhatsapp($numero) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://graph.facebook.com/v18.0/247444538453835/messages',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "52'.$numero.'",
                "type": "template",
                "template": {
                    "name": "cotizacion_recibida",
                    "language": {
                        "code": "ES"
                    }
                }
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKRFMJhXFoBOZCYltmQaZAUaZAMTKm9CCYVHFD5Q27cf5UVE610NNFyIe6ZBU9PeQppJOZAPdVoA7adawbLw4JZCPfTH0kRXtdx7jf9Oc5RMoVCBZA5AZCVqtUSKoz12ZCPx3By6LtrbgAN72TdgUNTQ6THwYj1N2Vi6r6Pjexsp5eqx37fQBBfmf4w8IcNxOskqEZBY3M5Hk05I2skoZD',
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = [
                "response" => $response,
                "numero" =>$numero
            ];

            return $res;
        }

        public function updateCliente(Request $r) {
            //return $r;
            $c = clientes::find(auth()->user()->isClient->id);
            $c->nombre = $r->nombre;
            $c->tipo = $r->tipo;
            $c->email = $r->email;
            $c->direccion = $r->direccion;
            $c->celular = $r->celular;

            $c->save();

            return response()->json([
                'message' => 'Cliente Actualizado con exito',
                'data' => $c,
                'status' => 200,
            ],200);
        }
}
