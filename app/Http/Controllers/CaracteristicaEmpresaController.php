<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaracteristicaEmpresa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class CaracteristicaEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caracteristicas= CaracteristicaEmpresa::all();


            $data=[
                "caracteristicas"=>$caracteristicas,
                 "recursos"=>[

                    ]
            ];

        return view("caracteristicasEmpresa",$data);
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
             'titulo' => 'required',
             'tipo' => 'required',
             'des_corta' => 'required',
             'des_larga' => 'required',

         ]);


        $c=new CaracteristicaEmpresa();
        $id = $r->id;
        $c->id = $id;
        $icono = $r->file('icono')->store('caracteristicasEmpresa/','public');
        $c->icono =$icono;
        $c->titulo=$r->titulo;
        $c->descripcion_cor=$r->des_corta;
        $c->descripcion_lar=$r->des_larga;
        $c->tipo=$r->tipo;
        $c->save();


        return response()->json([
            'message' => 'caracteristica Creado con exito',
            'data' => $c,
            'status' => 200,
        ],200);
    }
/**
     *
     * @param  Integer  $longitud
     * @return String
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaracteristicaEmpresa  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'titulo' => 'required',
            'tipo' => 'required',
            'des_corta' => 'required',
            'des_larga' => 'required',

        ]);

        $c = CaracteristicaEmpresa::find($id);
        $c->id = $id;
        $c->titulo=$r->titulo;
        $c->descripcion_cor=$r->des_corta;
        $c->descripcion_lar=$r->des_larga;
        $c->tipo=$r->tipo;
        if ($r->hasFile('icono')) {
            $icono = $r->file('icono')->store('caracteristicasEmpresa/' . $id,'public');
            $c->icono =$icono;
        }
        $c->update();

        return response()->json([
            'message' => 'Informacion Actualizado con exito',
            'data' => $c,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaracteristicaEmpresa  $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = CaracteristicaEmpresa::find($id);
        if ($c->icono) {
            Storage::delete($c->icono);
            File::delete($c->icono);
        }
        $c->delete();
        return response()->json([
            'message' => 'CaracteristicaE eliminada con exito',
            'data' => [],
            'status' => 200,
        ],200);

    }

    public function infoCaracteristicasEmpresa ()
    {
        $CaracEmpresa = CaracteristicaEmpresa::all();
        return response()->json($CaracEmpresa);
    }
}
