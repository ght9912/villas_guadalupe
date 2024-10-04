<?php

namespace App\Http\Controllers;

use App\Imports\ContratosImport;
use App\Models\clientes;
use App\Models\Contratos;
use App\Models\Cuentas;
use App\Models\Enajenantes;
use App\Models\etapas;
use App\Models\lote;
use App\Models\Ofertas;
use App\Models\proyectos;
use App\Models\User;
use App\Models\Documentos;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use NumberFormatter;
use Carbon\Carbon;

class pdfController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pdf(Request $r){
        $pdf = Pdf::loadView('pdf', ["nombrena"=>"", "nombread"=>"", "despro"=>"", "cerparce"=>"", "superf"=>"",
                                        "lote"=>"", "manza"=>"","preto"=>"", "tablaeng"=>"", "monres"=>"",
                                        "mens"=>"", "monmens"=>"","fechin"=>"","cuentavi"=>"", "falleci"=>"",
                                        "numcont"=>"", "infoena"=>"", "infoad"=>"", "fechaac"=>""]);
        return $pdf->stream();
    }
    public function index($oferta=null)
    {

            $usuarios= User::all();
            $contratos = Contratos::all()->map(function($e){
                $e->cliente;
                $e->lote;
                $e->lote->proyecto;
                $e->lote->etapa;
                return $e;
            });;
            $etapas= etapas::all();
            $lotes= lote::all()->map(function($e){
                $e->etapa;
                return $e;
            });
            $proyectos= proyectos::all();
            $clientes = clientes::all()->map(function($e){
                $e->usuario;
                $e->ofertas;
                $e->proyectos;
                $e->etapas;
                $e->lotes;
                return $e;
            });

            $enajenantes = Enajenantes::all();
            $cuentas = Cuentas::all();

            $data=["clientes"=>$clientes,
                    "contratos"=>$contratos,
            "recursos"=>[
                "usuarios"=>$usuarios,
                "oferta"=>$oferta,
                "proyectos"=>$proyectos,
                "etapas"=>$etapas,
                "lotes"=>$lotes,
                "enajenantes"=>$enajenantes,
                "cuentas"=>$cuentas
                ]
            ];
            //return $data;
            return view("contratos",$data);
    }
    public function vistaPrevia (Request $r){
        // return $r;
        $total_enganche = 0;

        foreach ($r->enganches as $e) {
            $total_enganche+= (float)$e["cantidad"];
            $precio_res= (float)$r->l_total - (float)$total_enganche;
            $precio_resof= ((float)$precio_res)*(1.004273);
            $precio_res2= ((float)$precio_res)*(1.03988);
            $precio_res3= ((float)$precio_res)*(1.07549);
            $Mesesa= ((float)$r->Meses)/(12);
            $anualidadt=((float)$r->l_anualidad)*((float)$Mesesa);
        }

        $fecha = $r->l_fecha;

        $partesFecha = explode("-", $fecha);

        $year = $partesFecha[0];
        $mes = $partesFecha[1];
        $dia = $partesFecha[2];

        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        setlocale(LC_ALL,"es_Es");

        $data = ["nombreena"=>mb_strtoupper($r->e_nombre),
                "direccionena"=>$r->e_direccion,
                "cellena"=>$r->e_celular,
                "emailena"=>$r->e_email,
                "RAN"=>$r->e_ran,
                "nombread"=>mb_strtoupper($r->c_nombre),
                "direccionad"=>$r->c_direccion,
                "cellad"=>$r->c_celular,
                "emailad"=>$r->c_email,
                "elecad"=>$r->c_electoral,
                "despro"=>$r->DesPro,
                "cerparce"=>$r->cerparce,
                "superf"=>$r->l_superficie,
                "lote"=>$r->l_lote,
                "manza"=>$r->l_manzana,
                "preto"=>$r->l_total,
                "monres"=>$mes,
                "mens"=>$r->Meses,
                "monmens"=>$r->l_mensualidad,
                "dia"=>$dia,
                "fechin"=>$r->enganches,
                "cuentavi"=>$r->select_cuentas,
                "falleci"=>$r->c_fallecido,
                "fechaac"=>$r->fecha,
                "enganches"=>$r->enganches,
                "total_enganche" => $total_enganche,
                "formater" => $formatterES,
                "preres"=> $precio_res,
                "preresof"=> $precio_resof,
                "preres2"=> $precio_res2,
                "preres3"=> $precio_res3,
                "referencia"=>$r->referencia,
                "l_fecha" =>$r->l_fecha,
                "numcont"=>$r->numcont,
                "anualidad"=>$r->l_anualidad,
                "anualidadt"=>$anualidadt,
                "Mesesa"=>$Mesesa,
                "ano" => $year,

            ];
                return view("pdf",$data);
    }
    public function vistaPrevia2 ($id){
        return $id;
        $contrato =  Contratos::find($id);
        return $contrato;
        $total_enganche = 0;

        foreach ($r->enganches as $e) {
            $total_enganche+= (float)$e["cantidad"];
            $precio_res= (float)$r->l_total - (float)$total_enganche;
            $precio_resof= ((float)$precio_res)*(1.004273);
            $precio_res2= ((float)$precio_res)*(1.03988);
            $precio_res3= ((float)$precio_res)*(1.07549);
            $Mesesa= ((float)$r->Meses)/(12);
            $anualidadt=((float)$r->l_anualidad)*((float)$Mesesa);
        }

        $fecha = $r->l_fecha;

        $partesFecha = explode("-", $fecha);

        $year = $partesFecha[0];
        $mes = $partesFecha[1];
        $dia = $partesFecha[2];

        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        setlocale(LC_ALL,"es_Es");

        $data = ["nombreena"=>mb_strtoupper($r->e_nombre),
                "direccionena"=>$r->e_direccion,
                "cellena"=>$r->e_celular,
                "emailena"=>$r->e_email,
                "RAN"=>$r->e_ran,
                "nombread"=>mb_strtoupper($r->c_nombre),
                "direccionad"=>$r->c_direccion,
                "cellad"=>$r->c_celular,
                "emailad"=>$r->c_email,
                "elecad"=>$r->c_electoral,
                "despro"=>$r->DesPro,
                "cerparce"=>$r->cerparce,
                "superf"=>$r->l_superficie,
                "lote"=>$r->l_lote,
                "manza"=>$r->l_manzana,
                "preto"=>$r->l_total,
                "monres"=>$mes,
                "mens"=>$r->Meses,
                "monmens"=>$r->l_mensualidad,
                "dia"=>$dia,
                "fechin"=>$r->enganches,
                "cuentavi"=>$r->select_cuentas,
                "falleci"=>$r->c_fallecido,
                "fechaac"=>$r->fecha,
                "enganches"=>$r->enganches,
                "total_enganche" => $total_enganche,
                "formater" => $formatterES,
                "preres"=> $precio_res,
                "preresof"=> $precio_resof,
                "preres2"=> $precio_res2,
                "preres3"=> $precio_res3,
                "referencia"=>$r->referencia,
                "l_fecha" =>$r->l_fecha,
                "numcont"=>$r->numcont,
                "anualidad"=>$r->l_anualidad,
                "anualidadt"=>$anualidadt,
                "Mesesa"=>$Mesesa,
                "ano" => $year,

            ];
                return view("pdf",$data);
    }

    public function store(Request $r) {
        $r->validate([
            'l_lote_val' => 'required',
            'c_cliente_val' => 'required',
            'l_total' => 'required',
        ]);

        $c = new Contratos();
        $c->id_cliente = $r->c_cliente_val;
        $c->id_lote = $r->l_lote_val;
        $c->estatus = "activo";
        $c->total = $r->l_total;
        $objeto = $r->all();
        if (!isset($objeto["enganches"])) {
            $objeto["enganches"] = [];
        }
        $c->objeto = json_encode($r->all());
        $c->save();

        $l = lote::find($r->l_lote_val);
        $l->comprador_id = (int)$r->c_cliente_val;
        if($r->l_tipo_pago_val == "contado")
            $l->estado = 3;
        else
            $l->estado = 4;

        $cl = clientes::find($r->c_cliente_val);
        $cl->tipo = "Comprador";

        $d= new Documentos();
        $d->id_contrato = $c->id;
        $d->status_ine_anverso = 0;
        $d->status_ine_reverso = 0;
        $d->status_com_dom = 0;
        $d->status_firma = 0;

        $l->save();
        $cl->save();
        $d->save();

        return response()->json([
            'message' => 'Contrato generado con exito',
            'data' => $c,
            'status' => 200,
       ],200);
    }

    public function contratOferta($id) {
        return $this->index( Ofertas::find($id));
        }

    public function eliminarContrato($id){
        $c = Contratos::find($id);
        $c->delete();
        return response()->json([
            'message' => 'Contrato eliminado con exito',
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

    public function importContracts(Request $re) {
        $re->validate([
            "proyecto_id" => 'required',
            "archivo" => 'required'
        ]);
        $pId = $re['proyecto_id'];
        $project = Proyectos::where('id', '=', $pId)->first();
        $zId = $re['etapa_id'];
        $inputData = $re->file('archivo')->isvalid() ? Excel::toCollection(new ContratosImport, $re->file('archivo')): null;
        $rows = isset($inputData) ? $inputData[0] : null;
        //*Revisar si la fila viene vacía
        foreach ($rows as $key => $r) {
            $content = 0;
            foreach ($r as $k => $v) {
                if($r['l_lote'] === "-"){$r['l_lote'] = null;}
                if($r['l_manzana'] === "-"){$r['l_manzana'] = null;}
                $$k = isset($r[$k])? $r[$k]: null;
                if(isset($$k) && $$k !== ''){
                    $content += 1;
                }
            }
            if($content < 2){unset($rows[$key]);}
        }
        $contratos = [];
        $rejected = [];
        foreach($rows as $r){
            //*Validar las presencia de datos.
            if(isset($r['num_cont'])){
                if($r['num_cont'] == "-"){
                    $hasNumber = false;
                }elseif(ctype_alpha(substr($r['num_cont'],-1))){
                    $hasNumber = ltrim($r['num_cont'], '0');
                }else{
                    $hasNumber = $r['num_cont'];
                }
            }else{
                $hasNumber = false;
            }
            $hasDate = $r['l_fecha'] == "-" ? false : (isset($r['l_fecha']) ? $r['l_fecha'] : false);
            $hasLot = $r['l_lote'] == "-" ? false : (isset($r['l_lote']) ? $r['l_lote'] : false);
            $hasBlock = $r['l_manzana'] == "-" ? false : (isset($r['l_manzana']) ? $r['l_manzana'] : false);
            $hasEmail = isset($r['email']) ? $r['email'] : false;
            $hasTotal = isset($r['l_total']) ? $r['l_total'] : false;
            $hasDownPayment = (isset($r['total_enganche']) || $r['total_enganche'] == 0) ? $r['total_enganche'] : false;
            $hasMonthly = isset($r['l_mensualidad']) ? $r['l_mensualidad'] : false;
            $hasAnnuity = (isset($r['l_anualidad']) || $r['l_anualidad'] == 0) ?  $r['l_anualidad'] : false;
            $hasTerm = isset($r['meses']) ? $r['meses'] : false;
            if ($r['total_enganche'] == '0') {
                $hasDownPayment = true;
            }
            if ($r['l_anualidad'] == '0') {
                $hasAnnuity = true;
            }

           // dd($hasAnnuity, $hasDownPayment);
            $multiMail = false;
            if($hasEmail && count(explode(" ",$hasEmail)) > 1){
                $multiMail = true;
            }
            $procesable = ($hasNumber && $hasDate && $hasLot && $hasBlock && ($hasEmail && !$multiMail) && $hasTotal && $hasDownPayment && $hasMonthly && $hasTerm) ? true : false;
            $multiLot = false;
            if($hasLot && count(explode(',',$hasLot)) > 1){
                $multiLot = true;
            }
            //*Flagear las ausencias de datos según corresponda.
            if(!$procesable){
                !$hasLot ? $r['noLot'] = true : '';
                !$hasBlock ? $r['noBlock'] = true : '';
                !$hasNumber ? $r['noNumber'] = true : '';
                !$hasDate ? $r['noDate'] = true : '';
                !$hasEmail ? $r['noMail'] = true : '';
                !$hasTotal ? $r['noTotal'] = true : '';
                !$hasDownPayment ? $r['noDown'] = true : '';
                !$hasMonthly ? $r['noMonthly'] = true : '';
                !$hasAnnuity ? $r['noAnnuity'] = true : '';
                !$hasTerm ? $r['noTerm'] = true : '';
                $multiMail ? $r['multiMail'] = true : '';
            }
            $importable =false;
            $eqLotsNBlocks;
            $lotsNotFound = [];
            $lotNotFound = false;
            //*Validar los datos de lote y manzana y que no estén ya vendidos.
            if($multiLot) {
                $lots = explode(",",str_replace([', ',' y '],',',$hasLot));
                $blocks = explode(",",str_replace([', ',' y '],',',$hasBlock));
                $eqCount = count($lots) == count($blocks);
                if($eqCount){
                    $lotes = [];
                    for ($i=0; $i < count($lots); $i++) {
                        $qLote = Lote::where('proyecto_id', '=', $pId)
                        // ->where('etapa_id', '=', $zId)
                        ->where('manzana', '=', $blocks[$i])
                        ->where('lote', '=', $lots[$i])
                        ->first();
                        if(isset($qLote)) {
                            $lotes[] = $qLote;
                        }else{
                            $lotsNotFound[] = "lote " . $lots[$i] . " manzana " . $blocks[$i];
                        }
                    }
                    $r['lotes'] = $lotes;
                    if(count($lotsNotFound) > 0 ){
                        $r['lotsNotFound'] = $lotsNotFound;
                        $importable = false;
                    }
                }else{
                    $r['lotsDifferBlocks'] = true;
                    $importable = false;
                }
            } else if(!$multiLot && $hasLot && $hasBlock) {
                $qLote = Lote::where('proyecto_id', '=', $pId)
                    // ->where('etapa_id', '=', $zId)
                    ->where('manzana', '=', $hasBlock)
                    ->where('lote', '=', $hasLot)
                    ->first();
                if(isset($qLote)){
                    $r['lotes'] = $qLote;
                }else{
                    $r['lotNotFound'] = "lote " . $hasLot . " manzana " . $hasBlock;
                    $lotNotFound = true;
                    $importable = false;
                }
            }
            //*Validar que los lotes no estén ya vendidos
            $soldLots = [];
            $soldLot = false;
            if ($multiLot && count($lotsNotFound) == 0) {
                $lots = $r['lotes'];
                for ($i = 0; $i < count($lots); $i++) {
                    $lot = $lots[$i];
                    $qContract = Contratos::where('id_lote', '=', $lot['id'])->first();
                    if (isset($qContract)) {
                        $contractObject = json_decode($qContract['objeto'], true);
                        $numCont = $contractObject['numcont'];
                        $soldLots[] = "El lote " . $lot['lote'] . " de la manzana " . $lot['manzana'] . ", ya fue vendido en el contrato número " . $numCont . ".";
                    }
                }
                if (count($soldLots) > 0 ) {
                    $r['soldLots'] = $soldLots;
                    $importable = false;
                }
            }else if (!$multiLot && $hasLot && $hasBlock && !$lotNotFound) {
                $lot = $r['lotes'];
                $qContract = Contratos::where('id_lote', "=", $lot['id'])->first();
                if(isset($qContract)) {
                    $contractObject = json_decode($qContract['objeto'], true);
                    $numCont = $contractObject['numcont'];
                    $r['soldLot'] = "El lote " . $lot['lote'] . " de la manzana " . $lot['manzana'] . ", ya fue vendido en el contrato número " . $numCont . ".";
                    $soldLot = true;
                    $importable = false;
                }
            }

            // //*Consulta de cliente
            if($hasEmail){
                $qClient = Clientes::where('email', '=', $hasEmail)->first();
                if(isset($qClient)){
                    $r['cliente'] = $qClient;
                }else{
                    $r['clientNotFound'] = true;
                    $importable = false;
                }
            }
            //*Comparar el id de cliente con los id de comprador
            $clientNotMatched = [];
            $clientId = isset($r['cliente']) ? $r['cliente']['id'] : null;
            if (isset($r['cliente']) && !$multiLot && !$lotNotFound) {
                if (!isset($r['lotes']['comprador_id'])) {
                    $importable = $procesable ? true : false;
                } else if(!$multiLot && $r['lotes']['comprador_id'] == $clientId){
                    $importable = $procesable ? true : false;
                }elseif(!$multiLot && $r['lotes']['comprador_id'] != $clientId){
                    $importable = false;
                    $r['clientNotMatch'] = true;
                }
            } else if (isset($r['lotes']) && isset($clientId) && $multiLot) {
                $matchingIds = 0;
                $buyerIds = [];
                for ($i=0; $i < count($r['lotes']); $i++) {
                    $buyerId = isset($r['lotes'][$i]['comprador_id']) ? $r['lotes'][$i]['comprador_id'] : "0";
                    $buyerIds[] = $buyerId;
                    if($buyerId == $clientId){
                        $matchingIds += 1;
                    }elseif($buyerId != 0 && $buyerId != $clientId){
                        $clientNotMatched[] = "lote " . $r['lotes'][$i]['lote'] . " manzana " . $r['lotes'][$i]['manzana'];
                    }elseif($buyerId == 0){
                        $matchingIds += 1;
                    }
                }
                if(count($buyerIds) == $matchingIds && !isset($r['lotsNotFound'])){
                    $importable = true;
                }
                if(count($clientNotMatched) > 0 ){
                    $importable = false;
                    $r['clientNotMatched'] = $clientNotMatched;
                }
            }
            if(count($soldLots) > 0 || $soldLot == true){
                $importable = false;
            }

            //*Volcado de filas no importables en array.
            if(!$procesable || ($procesable && !$importable)){
                $rejected[] = $r;
            }
            if($importable){
                //*Procesamiento de datos pre-importación
                $hasDate = intval($hasDate);
                $cDate = Carbon::createFromTimestamp(($hasDate - 25569) * 86400);
                $idLote = $multiLot ? $r['lotes'][0]['id'] : $r['lotes']['id'];
                $lote = lote::where('id', '=', $idLote)->first();
                $etapa_id = $lote['etapa_id'];
                $etapa = etapas::where('id', '=', $etapa_id)->first('etapa');
                $enganches = [];
                $enganches[0]['cantidad'] = $hasDownPayment === true ? 0.00 : $hasDownPayment;
                $enganches[0]['fecha'] = $cDate->format('Y-m-d');
                $object = [
                    'enganches' => $enganches,
                    'numcont' => $hasNumber,
                    'l_zona' => $etapa['etapa'],
                    'l_manzana' => $hasBlock,
                    'l_lote' => $hasLot,
                    'l_total' => $hasTotal,
                    'l_anualidad' => $hasAnnuity === true ? 0.00 : ($hasAnnuity ? $hasAnnuity : "0.00"),
                    'Meses' => $hasTerm . " meses",
                    'l_mensualidad' => $hasMonthly,
                    'l_fecha' => $cDate->format('Y-m-d'),
                ];
                //*Creación de contrato.
                $c = new Contratos();
                $c -> id_cliente = $clientId;
                $c -> id_lote = $idLote;
                $c -> estatus = "activo";
                $c -> total = $hasTotal;
                $c -> objeto = json_encode($object);
                $c -> contrato_url = 1;
                $c -> save();
                //*Asignación de id de comprador a los lotes y cambio de estado a vendido a crédito.
                if(!$multiLot){
                    $l = Lote::where('id', '=', $r['lotes']['id'])->first();
                    $l -> comprador_id = (int)$r['cliente']['id'];
                    $l -> estado = 4;
                    $l -> save();
                }elseif($multiLot){
                    $lots = explode(",",str_replace([', ',' y '],',',$hasLot));
                    for($i = 0; $i < count($lots); $i++){
                        $l = Lote::where('id', '=', $r['lotes'][$i]['id'])->first();
                        $l -> comprador_id = (int)$r['cliente']['id'];
                        $l -> estado = 4;
                        $l -> save();
                    }
                }

                //*Creación de lista de documentos del contrato

                //*Cambio de estado del cliente.
                $cl = clientes::where('id', '=', $r['cliente']['id'])->first();
                $cl -> tipo = "Comprador";
                $cl -> save();

                $contract = $hasNumber;
                $contratos['stored'][] = $contract;
            }
            $clientId = null;
            //*Fin de la importación...
        }
        //*Preparación de la respuesta.
        $contracts = isset($contratos['stored']) ? $contratos['stored'] : null;
        $fails = isset($rejected) ? $rejected : null;
        $data = [
            "project" => $project,
            "contracts" => $contracts,
            "fails" => $fails
        ];
        //*Redirección al reporte final:
        return view("importContratosReport", $data);
        //* Fin de la tarea.
    }

}
