<?php

namespace App\Http\Controllers;

use App\Models\proyectos;
use App\Models\User;
use App\Models\etapas;
use App\Models\lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LotesImport;
use App\Models\proyectosImagenes;
use Facade\FlareClient\Stacktrace\File;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;




class ProyectosController extends Controller
{
     /*
     * Create a new controller instance.
     * @return void
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

     public function index()
    {
        $usuarios = User::all();
        $etapas = etapas::all();
        $lotes = lote::all();
        $proyectos = proyectos::all()->map(function($e) {
            $e->user;
            return $e;
        });
        $projectStatus = [
            '0' => 'No disponible',
            '1' => 'Ventas abiertas',
            '2' => 'Terminado'
        ];
        $data = [
            "proyecto" => $proyectos,
            "status" => $projectStatus,
            "recursos" =>["etapas"=>$etapas, "lotes"=>$lotes, "usuario" => $usuarios,],
            ];
        // return $data;
        return view("proyectos", $data);
    }

    public function store(Request $r)
    {
        $p = new proyectos();
        $p->user_id = $r->user_id;
        $p->nombre = $r->nombre;
        $p->clave = $r->clave;
        $p->descripcion = $r->descripcion;
        $p->ubicacion = $r->ubicacion;
        $p->enajenante = $r->enajenante;
        if($r->portada != ""){
            $r->validate(['portada' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048']);
            $file = $r->file('portada');
            $file->hashName();
            $image_path = $file->store('img/proyectos', 'public');
            $p->portada = $image_path;
        }else {
            $p->portada = "";
        }
        $p->estado = $r->estado;

        $nombreUsed = proyectos::where('nombre', '=', $r->nombre)->get();
        $claveUsed = proyectos::where('clave', '=', $r->clave)->get();
        if (count($nombreUsed) == 0 && count($claveUsed) == 0) {
            $p->save();
            $p->user;
            if($r->importFile != ""){
                $r->validate([ 'importFile' => 'file|mimes:xls,xlsx|max:2048']);
                $inputData = $r->file('importFile')->isvalid() ? Excel::toCollection(new LotesImport, $r->file('importFile')): null;
                $rows = isset($inputData) ? $inputData[0] : null;
                //*Revisar si la fila viene vacía
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
                    if($content <= 2){unset($rows[$key]);}
                }
                $zonas = [];
                $lotes = [];
                $rejected = [];
                foreach($rows as $r){
                    $hasLot = isset($r['lote']) ? $r['lote'] : false;
                    $hasBlock = isset($r['manzana']) ? $r['manzana'] : false;
                    $hasZone = isset($r['zona']) ? $r['zona'] : false;
                    $hasSpotPrice = isset($r['precio_contado']) ? $r['precio_contado'] : false;
                    $hasCreditPrice = isset($r['precio_credito']) ? $r['precio_credito'] : false;
                    $hasLocation = isset($r['ubicacion']) ? $r['ubicacion'] : false;
                    $hasArea = isset($r['superficie']) ? $r['superficie'] : false;
                    $multiLot = false;
                    if(count(explode('Y',$hasLot)) > 1 || count(explode('y',$hasLot)) > 1 ||count(explode(', 0',$hasLot)) > 1){$multiLot = true;}
                    $procesable = ($hasLot && !$multiLot && $hasBlock && $hasZone && ($hasSpotPrice || $hasCreditPrice)) ? true : false;

                    if(!$procesable){
                        !$hasLot ? $r['noLot'] = true : '';
                        !$hasBlock ? $r['noBlock'] = true : '';
                        $multiLot ? $r['multiLot'] = true : '';
                        !$hasZone ? $r['noZone'] = true: '';
                        !$hasSpotPrice && !$hasCreditPrice ? $r['noPrices'] = true : '';
                        $rejected[] = $r;
                    }
                    $importable = false;

                    if($procesable){
                        $zone = etapas::where('proyecto_id', '=', $p->id)
                            ->where('e_name', '=', $hasZone)
                            ->first();
                        if(isset($zone)){
                            $lot = lote::where('proyecto_id', '=', $p->id)
                                ->where('etapa_id', '=', $zone['id'])
                                ->where('lote', '=', $hasLot)
                                ->where('manzana', '=', $hasBlock)
                                ->first();
                            if(!isset($lot)){
                                $importable = true;
                            }else{
                                $importable = false;
                                $r['repeated'] = true;
                            }
                        }else{
                            $lastZone = etapas::where('proyecto_id', '=', $p->id)->max('etapa');
                            $lastZone ++;
                            $e = new etapas();
                            $e->etapa = $lastZone;
                            $e->e_name = $hasZone;
                            $e->proyecto_id = $p->id;
                            if($hasSpotPrice){$e->precio_cont = $hasSpotPrice;}
                            if($hasCreditPrice){$e->precio_fin = $hasCreditPrice;}
                            $e->save();
                            $zonas['stored'][] = $e;
                            $importable = true;
                        }
                    }

                    if($importable){
                        $l = new lote();
                        $l->lote = $hasLot;
                        $l->manzana = $hasBlock;
                        $l->proyecto_id = $p->id;
                        $l->etapa_id = isset($zone) ? $zone['id'] : $e['id'];
                        if($hasLocation){$l->ubicacion = $hasLocation;}
                        if($hasArea){$l->superficie = $hasArea;}
                        $l->estado = 1;
                        $l->save();
                        $l->etapa;
                        $lotes['stored'][] = $l;
                    }elseif($procesable && !$importable){
                        $rejected[] = $r;
                    }
                }
                $zones = isset($zonas['stored']) ? $zonas['stored'] : null;
                $lots = isset($lotes['stored']) ? $lotes['stored'] : null;
                $fails = isset($rejected) ? $rejected : null;
                $data = [
                    "project" => $p,
                    "zones" => $zones,
                    "lots" => $lots,
                    "fails" => $fails,
                    "report" => true
                ];

                return view("createProjectReport",$data);
            }else{
                return response()->json([
                    'message' => 'Proyecto creado.',
                    'data' => $p,
                    'status' => 200,
                ],200);
            }
        }else {
            return response()->json([
                'message' => 'El proyecto ya existe  o la clave ya ha sido utilizada. No se creó proyecto ni se importaron lotes y/o zonas',
                'status' => 400,
            ],400);
        }


    }

    public function storeEtapa(Request $r )
    {
        $data = $r->all();
        $data = json_decode($r->getContent(),true);
        $inserted_etapas = [];
        $error_etapas = [];
        foreach($data as $r) {
            $lastEtapa = etapas::where('proyecto_id', '=', $r['proyecto_id'])->max('etapa');
            $lastEtapa++;
            $usedName = etapas::where('proyecto_id', '=', $r['proyecto_id'])
                ->where('e_name', '=', $r['e_name'])
                ->get();
            if(count($usedName) == 0) {
                $e = new etapas();
                $e->etapa = $lastEtapa;
                $e->e_name = $r['e_name'];
                $e->proyecto_id = $r['proyecto_id'];
                $e->ubicacion = $r['ubicacion'];
                $e->precio_cont = $r['precio_cont'];
                $e->precio_fin = $r['precio_fin'];
                $e->save();
                $e->usuario;
                $inserted_etapas[] = $e;

            }else{
                $error_etapas = $usedName[0];
            }
        }
        return response()->json([
            'message' => 'Etapa creada',
            'data' => $inserted_etapas,
            'error' => $error_etapas,
            'status' => 200
        ],200);
    }

    public function storeLotes(Request $r)
    {
        $data = $r->all();
        $data = json_decode($r->getContent(),true);
        foreach($data as $r) {
            // $r->validate(['lote' => 'required','manzana' => 'required']);
            $exists = lote::where('lote', '=', $r['lote'])
                ->where('manzana', '=', $r['manzana'])
                ->where('proyecto_id', '=', $r['proyecto_id'])
                ->get();
            if(count($exists) == 0 ) {
                $l = new lote();
                $l->lote = $r['lote'];
                $l->manzana = $r['manzana'];
                $l->proyecto_id = $r['proyecto_id'];
                $l->etapa_id = $r['etapa_id'];
                $l->ubicacion = $r['ubicacion'];
                $l->superficie = $r['superficie'];
                $l->save();
            }else{
                return response()->json([
                    'message' => 'Uno o más de los lotes ya existe en la base de datos',
                    'status' => 400,
                ],400);
            }
        }
        return response()->json([
            'message' => 'Lotes creados',
            'status' => 200,
        ],200);
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'user_id' => 'required',
            'nombre' => 'required',
        ]);

        $p = proyectos::find($id);
        if($p->nombre != $r->nombre || $p->clave != $r->clave){
            $exists = proyectos::where('nombre', '=', $r->nombre)->where('clave', '=', $r->clave)->get();
            if (count($exists) != 0) {
                return response()->json([
                    'message' => 'El proyecto ya existe o la clave ya ha sido utilizada',
                    'status' => 400,
                ],400);
            }
        }
        $p->user_id = $r->user_id;
        $p->nombre = $r->nombre;
        $p->clave = $r->clave;
        $p->descripcion = $r->descripcion;
        $p->ubicacion = $r->ubicacion;
        $p->enajenante = $r->enajenante;
        if($r->borraPortada === "true"){
            if(!Storage::disk("public")->delete($p->portada)){
                return response()->json(["status" => 'fail',"data" => [],"message" => 'Error al eliminar imagen'],500);
            }
            $p->portada="";
        }
        if($r->portada != ""){
            $r->validate([
                'portada' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);
            $file = $r->file('portada');
            $file->hashName();
            $image_path = $file->store('img/proyectos', 'public');
            $p->portada = $image_path;
        }
        $p->estado = $r->estado;

        $p->save();
        $p->user;

        return response()->json([
            'message' => 'Proyecto actualizado con exito',
            'data' => $p,
            'status' => 200,
        ],200);

    }

    public function updateEtapa (Request $r)
    {   return "asdfasdf";
        $id = $r->id;
        $e = etapas::find($id);
        $e->etapa = $r->etapa;
        $e->e_name = $r->e_name;
        $e->proyecto_id = $r->proyecto_id;
        $e->ubicacion = $r->ubicacion;
        $e->precio_cont = $r->precio_cont;
        $e->precio_fin = $r->precio_fin;
        $e->save();
        return response()->json([
            'message' => 'Etapas actualizadas',
            'status' => 200,
        ],200);
    }

    public function destroy($id)
    {
        //* Eliminar un proyecto existente.
        $p = proyectos::find($id);
        $p->delete();
        return response()->json([
            'message' => 'Proyecto eliminado con éxito',
            'data' => [],
            'status' => 200,
        ],200);
    }

    public function info ()
    {
        $proyectos = proyectos::all()->map(function($proyecto) {
            $lotes = lote::where('proyecto_id', $proyecto->id)->get();

            $lotesPorEstado = $lotes->groupBy('estado')->map->count();

            return [
                'proyecto' => $proyecto,
                'total_lotes' => $lotes->count(),
                'lotes_por_estado' => $lotesPorEstado
            ];
        });
        return response()->json($proyectos);
    }

    public function imagenes($id)
    {
        $proyectos = Proyectos::all();
        $proyecto = Proyectos::find($id);

        if (!$proyecto) {
            return redirect()->back()->with('error', 'Proyecto no encontrado');
        }

        $imagenes = ProyectosImagenes::with('proyecto')->where("id_proyecto", $id)->get();

        $data = [
            "imagenes" => $imagenes,
            "recursos" =>[
                "proyecto" => $proyecto,
                "proyectosAll" => $proyectos,
            ]
        ];

        return view('proyectosImagenes', $data);
    }


    public function imagenesSave(Request $r)
    {
        $imagenesGuardadas = [];

        if ($r->hasFile('images')) {
            foreach ($r->file('images') as $index => $image) {

                $pi = new ProyectosImagenes();
                $pi->id_proyecto = $r->id_proyecto;

                $url = $image->store('imagenes_proyectos/' . $pi->id_proyecto, 'public');
                $pi->url = $url;

                $pi->alternativo = $r->input("descriptions.$index", '');

                $pi->save();
                $pi->load('proyecto');

                $imagenesGuardadas[] = $pi;
            }
        }

        return response()->json([
            'message' => 'Imágenes guardadas con éxito',
            'data' => $imagenesGuardadas,
            'status' => 200,
        ], 200);
    }

    public function imagenesUpdate(Request $r, $id)
    {
        $pi = ProyectosImagenes::find($id);
        $pi->id_proyecto = $r->proyectoSelect;
        $pi->alternativo = $r->des_alt;
        if ($r->hasFile('imagenP')){
            $url = $r->file('imagenP')->store('imagenes_proyectos/' . $r->proyectoSelect,'public');
            $pi->url =$url;
        }
        $pi->save();
        $pi->load('proyecto');

        return response()->json([
            'message' => 'Imágene edita con éxito',
            'data' => $pi,
            'status' => 200,
        ], 200);
    }

    public function imagenesDelete($id)
    {
        $pi = ProyectosImagenes::find($id);
        if ($pi) {
            $filePath = $pi->url;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }
                $pi->delete();
        return response()->json([
            'message' => 'imagen eliminada con exito',
            'data' => [],
            'status' => 200,
        ],200);

    }

    public function detallesProyecto(Request $r, $id)
    {
        $p = Proyectos::find($id);
        $p->nombre=$r->nombre;
        $p->clave=$r->clave;
        $p->descripcion=$r->descripcion;
        $p->enajenante=$r->enajenante;
        $p->update();

        return response()->json([
            'message' => 'Detalles de proyecto Actualizado con exito',
            'data' => $p,
            'status' => 200,
        ],200);
    }

    public function infoImagenes ()
    {
        $proyectosImg = Proyectos::all()->map(function($proyecto){
            $imagenes = ProyectosImagenes::where('id_proyecto', $proyecto->id)->get();

            return [
                'proyectos' => $proyecto,
                'imagenes' => $imagenes,
            ];

        });

        return response()->json($proyectosImg);
    }
}
