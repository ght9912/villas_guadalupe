<?php

namespace App\Http\Controllers;

use App\Imports\PagosImport;
use App\Models\proyectos;
use App\Models\clientes;
use App\Models\lote;
use App\Models\Pagos;
use App\Models\User;
use App\Mail\ReciboMail;
use App\Models\Contratos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use DateTime;
use NumberFormatter;
use Carbon\Carbon;


class PagosController extends Controller
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
        $clientes=clientes::where("tipo","comprador")->get();
        $contratos = Contratos::where("estatus","activo")->get()->map(function($e){
            return $e->id_lote;
        });
        $lotes = lote::whereIn('id',$contratos)->get()->map(function($e){
            $e->proyecto;
            $e->cliente;
            $e->etapa;
            return $e;
        });
        $lotesDis = lote::where('estado', '=', 1)->get()->map(function($e){
            $e->proyecto;
            $e->etapa;
            return $e;
        });

        $proyectos = proyectos::select('id','nombre','clave')->get();
        $data=[
            "recursos"=>[
                "clientes"=>$clientes,
                "lotes"=>$lotes,
                "lotesDis"=>$lotesDis,
                "proyectos"=>$proyectos
                ]
        ];
        return view("pagos", $data);
    }

    public function tabla(Request $request) {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Rows display per page
        $columnIndex = $request->get('order')[0]['column'] ?? 0; // Column index
        $columnName = $request->get('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->get('order')[0]['dir'] ?? "asc"; // asc or desc
        $searchValue = $request->get('search')['value']; // Search value

        // Filtro de búsqueda
        $query = Pagos::with(["lote" , "lote.proyecto","cliente"]);
        if($searchValue != ''){
            $query->where(function($q) use ($searchValue) {
                $q->where('referencia_pago', 'like', '%'.$searchValue.'%')
                  ->orwhere('concepto', 'like', '%'.$searchValue.'%')
                  ->orwhere('id', 'like', '%'.$searchValue.'%')
                  ->orwhere('total_pago', 'like', '%'.$searchValue.'%')
                  ->orwhere('fechas', 'like', '%'.$searchValue.'%')
                  ->orWhereHas('cliente', function($q) use ($searchValue){
                    $q->where('nombre', 'like', '%'.$searchValue.'%');
                  })
                  ->orWhereHas('lote.proyecto', function($q) use ($searchValue){
                    $q->where('nombre', 'like', '%'.$searchValue.'%');
                  });
            });
        }

        $totalRecords = $query->count();
        $totalRecordwithFilter = $query->count();

        // Ordenar y paginar
        $pagos = $query->orderBy($columnName, $columnSortOrder)
                       ->skip($start)
                       ->take($rowperpage)
                       ->get();

        $data = [];

        foreach($pagos as $p){
            $data[] =[
                'id' => $p->id,
                'cliente' => '<a href="#" onclick="ver(event,'.$p->cliente->id.',this)">'.$p->cliente->nombre.'</a>',
                'lote' => $p->lote->proyecto->nombre . '/Z' . $p->lote->etapa->e_name . '/M' . $p->lote->manzana . '/L' . $p->lote->lote,
                'total_pago' => $p->total_pago,
                'referencia_pago' => $p->referencia_pago,
                'concepto' => $p->concepto,
                'tipo' => $p->tipo,
                'fechas' => $p->fechas,
                'acciones' => '<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="editPagos('.$p->id.',this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deletePagos('.$p->id.',this)">Eliminar</button>
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
            'cliente' => 'required',
            'lote' => 'required',
            'total_pago' => 'required',
            'referencia_pago' => 'required',
            'concepto' => 'required',
            'tipo' => 'required',
            'fechas' => 'required',

        ]);

        $total_pago = $r->total_pago;
        $pago_original = $r->total_pago;
        $concepto = $r->concepto;
        $lote = $r->id_lote;

        $p=new Pagos();
        $p->id_cliente=$r->cliente;
        $p->id_lote=$r->lote;
        $p->referencia_pago=$r->referencia_pago;
        $p->tipo=$r->tipo;
        $p->fechas=$r->fechas;
        $p->concepto=$concepto;


        // if ($concepto == "Mensualidad") {

        //     $c = Contratos::where('id_lote', $r->lote)->first();
        //     $objeto = json_decode((string)$c->objeto);
        //     $mensualidad = floatval($objeto->l_mensualidad);
        //     $anualidad = floatval($objeto->l_anualidad);

        //     if ($total_pago > $mensualidad){
        //         $pago_extra = round($r->total_pago - $mensualidad, 2);
        //         $total_pago = round($mensualidad,2);

        //         $e=new Pagos();
        //         $e->id_cliente=$r->cliente;
        //         $e->id_lote=$r->lote;
        //         $e->referencia_pago=$r->referencia_pago;
        //         $e->tipo=$r->tipo;
        //         $e->fechas=$r->fechas;
        //         $e->total_pago=$pago_extra;
        //         $e->concepto="Otros: Extras";
        //         $e->save();
        //         $e->cliente;
        //         $e->lotes;
        //         $e->lotes->proyecto;
        //         $e->lotes->etapa;
        //         $e->lotes->contrato;
        //         $e->proyectoLote($e->lotes->proyecto_id)->proyecto;
        //         $e->etapaLote($e->lotes->etapa_id)->etapa;

        //         $nombreEtapa = optional($e->lotes->etapa->nombre)->e_name ?? ($e->lotes->etapa)->etapa;

        //         $user = auth()->user()->name;

        //         $fecha = $e->fechas;

        //         $partesFecha = explode("-", $fecha);

        //         $mes = $partesFecha[1];
        //         $dia = $partesFecha[2];
        //         $year = $partesFecha[0];


        //         $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        //         $data =[
        //             "id"=> $e->id,
        //             "proyecto" => $e->lotes->proyecto->nombre,
        //             "etapa" => $nombreEtapa,
        //             "manzana" => $e->lotes->manzana,
        //             "lote" => $e->lotes->lote,
        //             "nombre" => $e->clientes->nombre,
        //             "saldo" =>  $pago_extra,
        //             "l_fecha" => $fecha,
        //             "referencia" =>  $e->referencia_pago,
        //             "concepto" => $e->concepto,
        //             "tipo" => $e->tipo,
        //             "recibido" => $user,
        //             "formater" => $formatterES,
        //             "dia" =>$dia,
        //             "mes" =>$mes,
        //             "year" =>$year,
        //             "extra" =>1,
        //             "pago_ori" => $pago_original,
        //             "mensualidad" => $mensualidad,

        //             ];

        //         $pdf = Pdf::loadView('pdf.Recibo', $data);
        //         $archivo = $pdf->output();

        //         Mail::to($e->clientes->email)->send(new ReciboMail
        //         ($archivo,$data));

        //     }
        // }

        // if ($concepto == "Anualidad") {

        //     $c = Contratos::where('id_lote', $r->lote)->first();
        //     $objeto = json_decode((string)$c->objeto);
        //     $mensualidad = floatval($objeto->l_mensualidad);
        //     $anualidad = floatval($objeto->l_anualidad);

        //     if ($total_pago > $anualidad){
        //         $pago_extra = round($r->total_pago - $anualidad, 2);
        //         $total_pago = round($anualidad,2);

        //         $e=new Pagos();
        //         $e->id_cliente=$r->cliente;
        //         $e->id_lote=$r->lote;
        //         $e->referencia_pago=$r->referencia_pago;
        //         $e->tipo=$r->tipo;
        //         $e->fechas=$r->fechas;
        //         $e->total_pago=$pago_extra;
        //         $e->concepto="Otros: Extras";
        //         $e->save();
        //         $e->cliente;
        //         $e->lotes;
        //         $e->lotes->proyecto;
        //         $e->lotes->etapa;
        //         $e->lotes->contrato;
        //         $e->proyectoLote($e->lotes->proyecto_id)->proyecto;
        //         $e->etapaLote($e->lotes->etapa_id)->etapa;

        //         $nombreEtapa = optional($e->lotes->etapa->nombre)->e_name ?? ($e->lotes->etapa)->etapa;

        //         $user = auth()->user()->name;

        //         $fecha = $e->fechas;

        //         $partesFecha = explode("-", $fecha);

        //         $mes = $partesFecha[1];
        //         $dia = $partesFecha[2];
        //         $year = $partesFecha[0];


        //         $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        //         $data =[
        //             "id"=> $e->id,
        //             "proyecto" => $e->lotes->proyecto->nombre,
        //             "etapa" => $nombreEtapa,
        //             "manzana" => $e->lotes->manzana,
        //             "lote" => $e->lotes->lote,
        //             "nombre" => $e->clientes->nombre,
        //             "saldo" =>  $pago_extra,
        //             "l_fecha" => $fecha,
        //             "referencia" =>  $e->referencia_pago,
        //             "concepto" => $e->concepto,
        //             "tipo" => $e->tipo,
        //             "recibido" => $user,
        //             "formater" => $formatterES,
        //             "dia" =>$dia,
        //             "mes" =>$mes,
        //             "year" =>$year,
        //             "extra" =>2,
        //             "pago_ori" => $pago_original,
        //             "anualidad" => $anualidad,

        //             ];

        //         $pdf = Pdf::loadView('pdf.Recibo', $data);
        //         $archivo = $pdf->output();

        //         Mail::to($e->clientes->email)->send(new ReciboMail
        //         ($archivo,$data));

        //     }
        // }

        if ($concepto == 'Apartado') {
            $l = lote::find($r->lote);
            $l->estado = 2;
            $l->save();
        }

        $p->total_pago=$total_pago;
        $p->save();
        $p->cliente;
        $p->lotes;
        $p->lotes->proyecto;
        $p->lotes->etapa;
        $p->lotes->contrato;
        $p->proyectoLote($p->lotes->proyecto_id)->proyecto;
        $p->etapaLote($p->lotes->etapa_id)->etapa;


        $nombreEtapa = optional($p->lotes->etapa->nombre)->e_name ?? ($p->lotes->etapa)->etapa;

        $user = auth()->user()->name;

        $fecha = $p->fechas;

        $partesFecha = explode("-", $fecha);

        $mes = $partesFecha[1];
        $dia = $partesFecha[2];
        $year = $partesFecha[0];


        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        $data =[
            "id"=> $p->id,
            "proyecto" => $p->lotes->proyecto->nombre,
            "etapa" => $nombreEtapa,
            "manzana" => $p->lotes->manzana,
            "lote" => $p->lotes->lote,
            "nombre" => $p->clientes->nombre,
            "saldo" =>  $p->total_pago,
            "l_fecha" => $fecha,
            "referencia" =>  $p->referencia_pago,
            "concepto" => $p->concepto,
            "tipo" => $p->tipo,
            "recibido" => $user,
            "formater" => $formatterES,
            "dia" =>$dia,
            "mes" =>$mes,
            "year" =>$year,
            "extra" =>0,

            ];

        $pdf = Pdf::loadView('pdf.Recibo', $data);
           $archivo = $pdf->output();

        Mail::to($p->clientes->email)->send(new ReciboMail
        ($archivo,$data));

        return response()->json([
             'message' => 'Creado con exito',
             'data' => $p,
             'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function show(Pagos $pagos, $id)
    {
        return  $pagos::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'total_pago' => 'required',
            'referencia_pago' => 'required',
            'concepto' => 'required',

        ]);

        $p = Pagos::find($id);
        $p->id_cliente=$r->cliente;
        $p->id_lote=$r->lote;
        $p->total_pago=$r->total_pago;
        $p->referencia_pago=$r->referencia_pago;
        $p->concepto=$r->concepto;
        $p->tipo=$r->tipo;
        $p->save();
        $p->cliente;
        $p->lote;
        $p->lote->proyecto;
        return response()->json([
            'message' => 'Actualizado con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p=Pagos::find($id);
        $p->delete();
        return response()->json([
            'message' => 'Eliminado con exito',
            'data' => [],
            'status' => 200,
        ],200);
    }

    public function findCliente(Request $r, $id)
    {
        $cliente=clientes::all();
        $cliente= clientes::find($id);
        $cliente->nombre = $r->nombre;
        $cliente->email = $r->email;
        $cliente->direccion = $r->direccion;
        $cliente->celular = $r->celular;
        return view("pagos");
    }

    public function importData(Request $re) {
        $re->validate([
            "proyecto_id" => 'required',
            "archivo" => 'required'
        ]);
        $pId = $re['proyecto_id'];
        $project = Proyectos::where('id', '=', $pId)->first();
        $inputData = $re->file('archivo')->isvalid() ? Excel::toCollection(new PagosImport, $re->file('archivo')): null;
        $rows = isset($inputData) ? $inputData[0] : null;
        foreach ($rows as $key => $r) {
            $content = 0;
            foreach ($r as $k => $v) {
                if($r['lote'] === "-"){$r['lote'] = null;}
                if($r['manzana'] === "-"){$r['manzana'] = null;}
                $$k = isset($r[$k])? $r[$k]: null;
                if(isset($$k) && $$k !== ''){
                    $content += 1;
                }
            }
            if($content < 2){unset($rows[$key]);}
        }
        $pagos = [];
        $rejected = [];
        foreach($rows as $r){
            $hasContract = isset($r['num_cont']) ? $r['num_cont'] : false;
            $hasLot = $r['lote'] == "-" ? false : (isset($r['lote']) ? $r['lote'] : false);
            $hasBlock = $r['manzana'] == "-" ? false : (isset($r['manzana']) ? $r['manzana'] : false);
            $searchable = $hasContract || ($hasLot && $hasBlock) ? true : false;
            $hasTotal = isset($r['total_pago']) ? $r['total_pago'] : false;
            $hasReference = isset($r['referencia_pago']) ? $r['referencia_pago'] : false;
            $hasConcept = isset($r['concepto']) ? $r['concepto'] : false;
            $hasOther = isset($r['otro_concepto']) ? $r['otro_concepto'] : false;
            $hasMethod = isset($r['tipo']) ? $r['tipo'] : false;
            $hasDate = !isset($r['fechas']) ? false : (is_numeric($r['fechas']) ? $r['fechas'] : false);
            $recurrence = isset($r['recurrencia']) ? $r['recurrencia'] : 1;

            $procesable = ($searchable && $hasTotal && ($hasConcept != "Otro" || ($hasConcept == "Otro" && $hasOther)) && $hasDate && $recurrence) ? true : false;
            if(!$procesable){
                !$searchable ? $r['notSearchable'] = true : '';
                !$hasTotal ? $r['noTotal'] = true : '';
                !$hasConcept ? $r['noConcept'] = true : '';
                !$hasDate ? $r['noDate'] = true: '';
            }
            $multiLot = false;
            if($hasLot && (count(explode(',',$hasLot)) > 1 || count(explode('y',$hasLot)) > 1)){
                $multiLot = true;
            }

            $importable = false;
            if($multiLot){
                $lots = explode(", ", str_replace([', ',' y '],',',$hasLot));
                $blocks = explode(",",str_replace([', ',' y '],',',$hasBlock));
                $Lot = Lote::where('proyecto_id', '=', $pId)
                    ->where('manzana', '=', $blocks[0])
                    ->where('lote', '=', $lots[0])
                    ->first();
            }else{
                $Lot = Lote::where('proyecto_id', '=', $pId)
                    ->where('manzana', '=', $hasBlock)
                    ->where('lote', '=', $hasLot)
                    ->first();
            }
            if(isset($Lot)){
                $lotId = $Lot['id'];
                $buyerId = $Lot['comprador_id'];
            }else{
                $r['lotNotFound'] = true;
                $importable = false;
            }
            $contract = Contratos::where('id_cliente', '=', $buyerId)
                    ->where('id_lote', '=', $lotId)
                    ->first();
            if(isset($contract)){
                $object = json_decode($contract['objeto'], true);
                $numCont = $object['numcont'];
                if($numCont == $hasContract){
                    $importable = true;
                }else{
                    $r['numberNotMatch'] = true;
                    $importable = false;
                }
            }else{
                $r['contractNotFound'] = true;
                $importable = false;
            }
            //* Comprobar la preexistencia de un pago de la misma fecha, monto y concepto asociado al mismo lote.
            $inputDate = Carbon::createFromTimestamp(($hasDate - 25569) * 86400);
            $date = $inputDate->format('Y-m-d');
            if (isset($lotId)) {
                $payment = Pagos::where('id_lote', '=', $lotId)
                        ->where('fechas', '=', $date)
                        ->where('total_pago', '=', $hasTotal)
                        ->where('concepto', '=', $hasConcept)
                        ->first();
            }
            if(isset($payment)) {
                $r['repeated'] = true;
                $r['date'] = $date;
                $importable = false;
            }

            if(!$procesable || ($procesable && !$importable)){
                $rejected[] = $r;
            }
            if($importable){
                $baseDate = Carbon::createFromTimestamp(($hasDate - 25569) * 86400);
                for($i = 1; $i <= $recurrence; $i++){
                    $p = new Pagos;
                    $p->id_cliente = $buyerId;
                    $p->id_lote = $lotId;
                    $p->total_pago = $hasTotal;
                    $p->referencia_pago = isset($hasReference) ? $hasReference : "";
                    if($hasConcept === "Otro" && isset($hasOther)){
                        $p->concepto = $hasOther;
                    }elseif($hasConcept === "Otro" && !isset($hasOther)){
                        $p->concepto = $hasConcept;
                    }else{
                        $p->concepto = $hasConcept;
                    }
                    $p->tipo = $r['tipo'];
                    $p->fechas = $baseDate->format('Y-m-d');
                    $p->save();
                    $p->contrato = $hasContract;
                    $pagos['stored'][] = $p;
                    $baseDate->addMonth();
                }
            }
        }
        $payments = isset($pagos['stored']) ? $pagos['stored'] : null;
        $fails = isset($rejected) ? $rejected : null;
        $data = [
            "project" => $project,
            "payments" => $payments,
            "fails" => $fails
        ];
        //*Redirección al reporte final:
        return view("importPagosReport", $data);
        //* Fin de la tarea.

    }

}
