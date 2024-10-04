<?php

namespace App\Http\Controllers;

use App\Models\proyectos;
use App\Models\etapas;
use App\Models\lote;
use App\Models\clientes;
use App\Models\User;
use App\Models\specslotes;
use App\Http\Controllers\Controller;
use App\Imports\LotesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Undefined;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //* Muestra la lista de lotes

        $proyectos = proyectos::all();
        //$etapas = etapas::all();
        $lotes = lote::all()->map(function($e){
            $e->proyecto;
            $e->etapa;
            $e->comprador;
            $e->vendedor;
            return $e;
        });
        $loteStatus = [
            '0' => 'No disponible',
            '1' => 'Disponible',
            '2' => 'Apartado',
            '3' => 'Vendido al contado',
            '4' => 'Vendido a crédito',
            '5' => 'Liquidado',
            '6' => 'En recuperación',
        ];
        $data = [
            'lote' => $lotes,
            "proyecto" => $proyectos,
            'status' => $loteStatus
            // "recursos" => [
            //     "proyecto" => $proyectos,
            //     "etapa" => $etapas,
            // ]
        ];
        // return $data;
        return view("lotes",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        // return $r;
        $r->validate([
            'proyecto_id' =>'required',
            'etapa_id' => 'required',
            'lote' => 'required',
            'manzana' => 'required'
        ]);
        // return $r;
        $l = new lote();
        $l->lote = $r->lote;
        $l->manzana = $r->manzana;
        $l->proyecto_id = $r->proyecto_id;
        $l->etapa_id = $r->etapa_id;
        $l->ubicacion = $r->ubicacion;
        $l->superficie = $r->superficie;
        $l->descripcion = $r->descripcion;
        $l->vertices = $r->vertices;
        $l->medidas = $r->medidas;
        $l->colindancias = $r->colindancias;
        $l->estado = $r->estado;
        $l->comprador_id = $r->comprador_id;
        $l->vendedor_id = $r->vendedor_id;
        // if($r->comprador!="null")
        //     $l->comprador_id = $r->comprador_id;
        // if($r->vendedor!="null")
        //     $l->vendedor_id = $r->vendedor_id;
        $exists = lote::where('lote', '=', $r->lote)
            ->where('manzana', '=', $r->manzana)
            ->where('proyecto_id', '=', $r->proyecto_id)
            ->get();
        if (count($exists) == 0) {
            $data = [];

            $l->save();
            $l->proyecto;
            $l->etapa;
            $l->comprador;
            $l->vendedor;

            $data['lote'] = $l;

            if (isset($r->specs)) {
                $data['specs'] = [];

                $specs = json_decode($r->specs,true);
                foreach($specs as $sp){
                    $s = new specslotes();
                    $s->id_lote = $l->id;
                    $s->nombre = $sp['titulo'];
                    $s->valor = $sp['value'];
                    $s->save();
                    $data['specs'][] = $s;
                }
            }
            // return $data;
            return response()->json([
                'message' => 'Lote agregado con éxito',
                'data' => $data,
                'status' => 200,
            ],200);
        }else {
            return response()->json([
                'message' => 'El lote ya existe',
                'status' => 400,
            ],400);
        }
    }

    public function storeSpecs (Request $r)
    {

        $r->validate([
            'items' => 'required|array',
            'items.*.id_lote' => 'required',
            'items.*.nombre' => 'required',
        ]);

        $data = [];

        foreach($r->items as $sp){
            $s = new specslotes();
            $s->id_lote = $sp['id_lote'];
            $s->nombre = $sp['nombre'];
            if ( isset( $sp['valor'] )) {
                $s-> valor = $sp['valor'];
            }
            $s->save();
            $data[] = $s;
        }
        return response()->json([
            'message' => 'Características agregadas con éxito',
            'data' => $data,
            'status' => 200,
        ],200);

    }

    public function updateSpecs (Request $r)
    {

        $r->validate([
            'items' => 'required|array',
            'items.*.id' => 'required',
            'items.*.id_lote' => 'required',
            'items.*.nombre' => 'required',
        ]);

        $data = [];

        foreach($r->items as $sp) {
            $id = $sp['id'];
            $s = specslotes::find($id);

            $s->id_lote = $sp['id_lote'];
            $s->nombre = $sp['nombre'];
            $s-> valor = $sp['valor'];
            $s->save();
            $data[] = $s;
        }
        return response()->json([
            'message' => 'Características actualizadas con éxito',
            'data' => $data,
            'status' => 200,
        ],200);

    }

    public function deleteSpecs (Request $r)
    {

        $r->validate([
            'items' => 'required|array',
        ]);

        foreach( $r->items as $id ) {
            $s = specslotes::where('id', '=', $id)->delete();
        }

        return response()->json([
            'message' => 'Características eliminadas con éxito',
            'data' => [],
            'status' => 200,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        // return $r;
        $r->validate([
            'proyecto_id' =>'required',
            'etapa_id' => 'required',
            'lote' => 'required',
            'manzana' => 'required'
        ]);

        $l = Lote::find($id);

        if($l->lote != $r->lote || $l->manzana != $r->manzana ){
            $exists = lote::where('lote', '=', $r->lote)->where('manzana', '=', $r->manzana)->where('proyecto_id', '=', $r->proyecto)->get();
            if (count($exists) != 0) {
                return response()->json([
                    'message' => 'El lote ya existe',
                    'status' => 400,
                ],400);
            }
        }

        $l->lote = $r->lote;
        $l->manzana = $r->manzana;
        $l->proyecto_id = $r->proyecto_id;
        $l->etapa_id = $r->etapa_id;
        $l->ubicacion = $r->ubicacion;
        $l->superficie = $r->superficie;
        $l->vertices = $r->vertices;
        $l->medidas = $r->medidas;
        $l->colindancias = $r->colindancias;
        $l->estado = $r->estado;
        $l->comprador_id = $r->comprador_id;
        $l->vendedor_id = $r->vendedor_id;
        // if($r->comprador!="null")
        //     $l->comprador_id = $r->comprador_id;
        // if($r->vendedor!="null")
        //     $l->vendedor_id = $r->vendedor_id;

        $l->save();
        $l->proyecto;
        $l->etapa;

        return response()->json([
            'message' => 'Lote actualizado con éxito',
            'data' => $l,
            'status' => 200,
        ],200);

    }


    public function updateDescription(Request $r, $id)
    {
        return $r;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //* Elimminar un lote existente.
        $l = lote::find($id);
        $l->delete();
        return response()->json([
            'message' => 'Lote eliminado con éxito',
            'data' => [],
            'status' => 200,
        ],200);
    }

    public function projectLotes($id)
    {
        $q = lote::where('proyecto_id', '=', $id)->get()->count();
        if($q > 0){
            return response()->json([
                'data' => $q,
                'status' => 200,
                ],200);
        }else {
            return response()->json([
                'message' => 'El proyecto no tiene lotes registrados',
                // 'data' => 0,
                'status' => 400,
            ]);
        }
    }

    public function zoneLotes($id)
    {
           $q = lote::where('etapa_id', '=', $id)->get()->count();

            return response()->json([
            'data' => $q,
            'status' => 200,
            ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = proyectos::all();
        $data = [
            'projects' => $projects
        ];
        return view('lotesEdit', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(lote $lote)
    {
    $lote->proyecto;
    $lote->etapa;
    $lote->comprador;
    $lote->vendedor;
    // $projects = proyectos::all();
    $specs = specslotes::where('id_lote', '=', $lote->id)->get();
    // return $specs;
    $data = [
        // 'projects' => $projects,
        'lote' => $lote,
        'specs' => $specs,
        'view' => true
    ];
    // return $data;
    return view('lotesEdit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lote = Lote::findOrFail($id);
        $edit = true;
        // $fotos = FotoLote::where('lote_id', $id)->get(); // Cargar las fotos asociadas al lote si es necesario

        $data = [
            'lote' => $lote,
            'edit' => $edit
            // 'fotos' => $fotos
        ];
        // return view('lotes.edit', compact('lote', 'fotos'));
        // return $data;
        return view('lotesEdit', $data);
    }

    public function getSuperficie($id)
    {
        $l = lote::find($id);

        if ($l) {
            $superficie = $l->superficie;

            return response()->json(['superficie' => $superficie]);
        }

        return response()->json(['error' => 'Lote no encontrada'], 404);
    }

    public function importData(Request $re)
    {
        $re->validate ([
            "proyecto_id" => 'required',
            "archivo" => 'required'
        ]);

        $pId = $re['proyecto_id'];
        $project = Proyectos::where('id', '=', $pId)->first();
        $zId = $re['etapa_id'] ? $re['etapa_id'] : null;
        $stage = $zId ? Etapas::where('id', '=', $zId)->first() : null;

        $inputData = $re->file('archivo')->isvalid() ? Excel::toCollection(new LotesImport, $re->file('archivo')): null;
        $rows = isset($inputData) ? $inputData[0] : null;
        foreach ($rows as $key => $r) {
            $content = 0;
            foreach ($r as $k => $v) {
                if($r['lote'] === "-"){$r['lote'] = null;}
                if($r['manzana'] === "-"){$r['manzana'] = null;}
                $$k = isset($r[$k]) ? $r[$k] : null;
                if(isset($$k) && $$k  !== ''){$content += 1;}
            }
            if($content <= 2){ unset($rows[$key]);}
        }
        $zonas = [];
        $lotes = [];
        $rejected = [];
        foreach($rows as $r) {
            $hasLot = isset($r['lote']) ? $r['lote'] : false;
            $hasBlock = isset($r['manzana']) ? $r['manzana'] : false;
            $hasZone = isset($r['zona']) ? $r['zona'] : ($zId ? $zId : false);
            $hasSpotPrice = isset($r['precio_contado']) ? $r['precio_contado'] : false;
            $hasCreditPrice = isset($r['precio_credito']) ? $r['precio_credito'] : false;
            $hasLocation = isset($r['ubicacion']) ? $r['ubicacion'] : false;
            $hasArea = isset($r['superficie']) ? $r['superficie'] : false;
            $hasStatus = isset($r['status']) ? $r['estado'] : 1;
            $hasEmail = isset($r['correo_cliente']) ? $r['correo_cliente'] : false;
            $multiLot = false;
            if(count(explode('Y',$hasLot)) > 1|| count(explode('y',$hasLot)) > 1 || count(explode(', ',$hasLot)) > 1){$multiLot = true;}
            if($zId){
                $procesable = ($hasLot && !$multiLot && $hasBlock && $hasStatus) ? true : false;
            }elseif(!$zId){
                $procesable = ($hasLot && !$multiLot && $hasBlock && $hasZone && ($hasSpotPrice || $hasCreditPrice) && $hasStatus) ? true : false;
            }
            if(!$procesable){
                !$hasLot ? $r['noLot'] = true : '';
                !$hasBlock ? $r['noBlock'] = true : '';
                $multiLot ? $r['multiLot'] = true : '';
                if(!$zId && !$hasZone){$r['noZone'] = true;}
                if(!$zId && $hasZone && (!$hasSpotPrice && !$hasCreditPrice)){$r['noPrices'] = true;}
                $rejected[] = $r;
            }
            $importable = false;
            if($procesable){
                if($hasEmail){
                    $client = clientes::where('email', '=', $hasEmail)->first('id');
                    isset($client) ? $r['cliente'] = $client : $r['noClient'] = true;
                }

                if(isset($zId)){
                    $lot = lote::where('proyecto_id', '=', $pId)
                            ->where('etapa_id', '=',$zId)
                            ->where('lote', '=', $hasLot)
                            ->where('manzana', '=', $hasBlock)
                            ->first();
                    if(!isset($lot)){
                        $importable = true;
                    }else{
                        $importable = false;
                        $r['repeated'] = true;
                        $rejected[] = $r;
                    }
                }else{
                    $zone = etapas::where('proyecto_id', '=', $pId)
                        ->where('e_name', '=', $hasZone)
                        ->first();
                    if(isset($zone)){
                        $lot = lote::where('proyecto_id', '=', $pId)
                        ->where('etapa_id', '=',$zone['id'])
                        ->where('lote', '=', $hasLot)
                        ->where('manzana', '=', $hasBlock)
                        ->first();
                        if(!isset($lot)){
                            $importable = true;
                        }else{
                            $importable = false;
                            $r['repeated'] = true;
                            $rejected[] = $r;
                        }
                    }else{
                        $lastZone = Etapas::where('proyecto_id', '=', $pId)->max('etapa');
                        $lastZone++;
                        $e = new etapas();
                        $e->etapa = $lastZone;
                        $e->e_name = $hasZone;
                        $e->proyecto_id = $pId;
                        if($hasSpotPrice){$e->precio_cont = $hasSpotPrice;}
                        if($hasCreditPrice){$e->precio_fin = $hasCreditPrice;}
                        $e->save();
                        $zonas['stored'][] = $e;
                        $importable = true;
                    }
                }

            }

            if($importable){
                $l = new lote();
                $l->lote = $hasLot;
                $l->manzana = $hasBlock;
                $l->proyecto_id = $pId;
                $l->etapa_id = $zId ? $zId : $e['id'];
                if($hasLocation){$l->ubicacion = $hasLocation;}
                if($hasArea){$l->superficie = $hasArea;}
                $l->estado = $hasStatus;
                if(isset($client)){$l->comprador_id = $client['id'];}
                $l->save();
                $l->etapa;
                if(isset($r['noClient'])){
                    $l->missingClient = true;
                    $l->email = $r['correo_cliente'];
                }
                $lotes['stored'][] = $l;
            }elseif($procesable && !$importable){
                $rejected[] = $r;
            }
            $client = null;
        }
        $zones = isset($zonas['stored']) ? $zonas['stored'] : null;
        $lots = isset($lotes['stored']) ? $lotes['stored'] : null;
        $fails = isset($rejected) ? $rejected : null;
        $data = [
            "project" => $project,
            "zones" => $zones,
            "lots" => $lots,
            "fails" => $fails
        ];
        return view("importLotesReport",$data);
    }

    public function lotesDis()
    {
        $lotes = lote::where('estado', '=', 1)->get()->map(function($e) {
            $e->proyecto;
            $e->etapa;
            return $e;
        });

        return response()->json($lotes);
    }

}
