<?php

namespace App\Http\Controllers;

use App\Models\etapas;
use App\Models\proyectos;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ProyectosController;

class EtapasController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //* Muestra la lista de las etapas
        $usuarios = User::all();
        $proyectos = proyectos::all();
        $etapas = etapas::all()->map(function($e){
            $e->proyecto;
            return $e;
        });
        $data = [
            "etapa" => $etapas,
            "proyecto" => $proyectos,
            "usuario" => $usuarios
        ];
        // return $data;
        return view("etapas",$data);
    }



    public function store(Request $r)
    {
        //* Crear una nueva etapa.
        $r->validate([
            'proyecto_id' => 'required',
        ]);
        //*Define los valores a enviar a la DB.
        $lastEtapa = Etapas::where('proyecto_id', '=', $r->proyecto_id)->max('etapa');
        $lastEtapa++;

        $e = new etapas();
        $e->etapa = $lastEtapa;
        $e->e_name = $r->e_name;
        $e->proyecto_id = $r->proyecto_id;
        $e->ubicacion = $r->ubicacion;
        $e->precio_cont = $r->precio_cont;
        $e->precio_fin = $r->precio_fin;
        //*Define las variables de comparación:
        $zoneExist = Etapas::where('proyecto_id', '=', $r->proyecto)
            ->where('etapa','=', $r->etapa)
            ->where('etapa', '=', $r->e_name)
            ->first();
        // $projectAsigned = Etapas::where('proyecto_id','=',$r->proyecto)->get();
        // $indexUsed = Etapas::where('etapa', '=', $r->etapa)->get();
        // $nameUsed = Etapas::where('e_name', '=', $r->e_name)->get();
        //*Establece la condición para proceder a guardar la etapa:
        // if(count($projectAsigned) == 0 && count($indexUsed) == 0  && count($nameUsed) == 0) {
        if(!isset($zoneExist)) {
            //*Guarda y define los valores a retornar
            $e->save();
            $e->proyecto;
            $e->usuario;
            return response()->json([
                'message' => 'Etapa creada con éxito',
                'data' => $e,
                'status' => 200
            ],200);
        } else {
            //*Retorna error
            return response()->json([
                'message' => 'La Etapa ya existe o el nombre de la etapa ya ha sido utilizado',
                'status' => 400
            ],400);
        }
    }


    public function update(Request $r, $id)
    {
        //* Modificar una etapa existente.
        $r->validate([
            'proyecto_id' => 'required',
            'etapa' => 'required'
        ]);

        $e = Etapas::find($id);
        $e->etapa = $r->etapa;
        $e->e_name = $r->e_name;
        $e->proyecto_id = $r->proyecto_id;
        $e->ubicacion = $r->ubicacion;
        $e->precio_cont = $r->precio_cont;
        $e->precio_fin = $r->precio_fin;

        $e->save();
        $e->proyecto;

        return response()->json([
            'message' => 'Etapa actualizada con exito',
            'data' => $e,
            'status' => 200,
        ],200);
    }


    public function destroy($id)
    {
        //* Eliminar una etapa existente.
        $e = Etapas::find($id);
        $e->delete();
        return response()->json([
            'message' => 'Etapa eliminada exitosamente',
            'data' => [],
            'status' => 200,
        ],200);

    }


    public function projectEtapas($id)
    {
        $q = Etapas::where('proyecto_id', '=', $id)->get();
        if(count($q) > 0){
            return response()->json([
            'data' => $q,
            'status' => 200,
            ],200);
        }else{
            return response()->json([
                'message' => 'El proyecto no tiene zonas registradas.',
                'data' => []
            ]);
        }
    }

    public  function getInfo($id)
    {
        $q = Etapas::where('id', '=', $id)->get();
        if(count($q) > 0){
            return response()->json([
                'data' => $q,
                'status' => 200,
            ],200);
        }else{
            return response()->json([
                'message' => 'No se encontró coincidencia.',
                'data' => [],
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\etapas  $etapas
     * @return \Illuminate\Http\Response
     */
    public function show(etapas $etapas)
    {
        //
    }
    public function getPrecios($id)
    {
        $e = etapas::find($id);

        if ($e) {
            $precioCont = $e->precio_cont;
            $precioFin = $e->precio_fin;

            return response()->json(['precio_cont' => $precioCont, 'precio_fin' => $precioFin]);
        }

        return response()->json(['error' => 'Etapa no encontrada'], 404);
    }



}
