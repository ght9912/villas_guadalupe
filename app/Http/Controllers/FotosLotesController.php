<?php

namespace App\Http\Controllers;

use App\Models\fotos_lotes;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class FotosLotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {
        //
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
            'id_lote' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $f = new fotos_lotes();

        $f->lote_id = $r->id_lote;
        if ( $r->hasFile('image') ) {
            $file = $r->file('image');
            $file->hashName();
            $image_path = $file->store('img/lotes','public');
            $url = $image_path;
            $f->ruta = $url;
        }
        $f->descripcion = $r->descripcion;
        $f->alt = $r->alt;
        $f->save();

        return response()->json([
            'message' => 'Registro agregado con éxito',
            'data' => $f,
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fotos_lotes  $fotos_lotes
     * @return \Illuminate\Http\Response
     */
    public function show(fotos_lotes $fotos_lotes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\fotos_lotes  $fotos_lotes
     * @return \Illuminate\Http\Response
     */
    public function edit(fotos_lotes $fotos_lotes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\fotos_lotes  $fotos_lotes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {

        $r->validate([
            'id' => 'required|exists:fotoslotes,id',
        ]);

        $id = $r->id;
        $f = fotos_lotes::find($id);

        if ($r->hasFile('image')) {

            $file = $r->file('image');
            $file->hashName();
            $image_path = $file->store('img/lotes','public');
            $url = $image_path;
            $f->ruta = $url;
        }
        if(isset($r->titulo)){
            $f->descripcion = $r->titulo;
        }
        if(isset($r->alt)){
            $f->alt = $r->alt;
        }
        // return $f;
        $f->save();

        return response()->json([
            'message' => 'Registro modificado con éxito',
            'data' => $f,
            'status' => 200,
        ],200);
    }

    public function upload(Request $r)
    {
        //return $r;
        $r->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lote_id' => 'required|exists:lotes,id',
        ]);

        if ($r->hasFile('image')) {
            // Subir la imagen al almacenamiento público y obtener la URL
            $file = $r->file('image');
            $file->hashName();
            $image_path = $file->store('img/lotes','public');
            $url = $image_path;
            $f = new fotos_lotes();
            $f->lote_id = $r->input('lote_id');
            $f->ruta = $url;
            $f->save();
            // $path = $r->file('image')->store('images', 'public');
            // $url = Storage::url($path);
            // Retornar la URL de la imagen subida
            return response()->json(['url' => $url], 200);
        }

        return response()->json(['error' => 'No se pudo subir la imagen'], 400);
    }

    public function tabla(Request $r)
    {

        try {
            $draw = $r->get('draw');
            $start = $r->get('start');
            $rowperpage = $r->get('length');
            $columnIndex = $r->get('order')[0]['column'];
            $columnName = $r->get('columns')[$columnIndex]['data'];
            $columnSortOrder = $r->get('order')[0]['dir'];
            $searchValue = $r ->get('search')['value'];

            $lote_id = $r->input('lote_id');
            $query = fotos_lotes::where('lote_id', $lote_id);

            if($searchValue != ''){
                $query->where(function($q) use ($searchValue) {
                    $q->where('descripcion', 'like', '%'.$searchValue.'%')
                    ->orWhere('alt', 'like', '%'.$searchValue.'%')
                    ->orWhere('id', 'like', '%'.$searchValue.'%');
                });
            }

            $totalRecords = $query->count();
            $totalRecordwithFilter = $query->count();

            $fotos = $query->orderBy($columnName, $columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
            $data = [];

            foreach($fotos as $f){
                $data[] =[
                    'id' => $f->id,
                    'imagen' => '<img src="/storage/'.$f->ruta.'" alt="'.$f->alt.'" max-width="100" height="50">',
                    'titulo' => $f->descripcion,
                    'alt' => $f->alt,
                    'acciones' => '<div class="d-flex">
                                    <button type="button" class="btn btn-primary btn-sm me-1" onclick="editFoto('.$f->id.')">Editar</button>
                                    <button type="button" name="" id="" class="btn btn-danger btn-sm" onclick="deleteFoto('.$f->id.')">Eliminar</button>
                                </div>',
                ];
            }

            $response = [
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            ];

            return response()->json($response);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fotos_lotes  $fotos_lotes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //* Elimina un resgistro de foto de lote existente.
        $f = fotos_lotes::find($id);
        $f->delete();
        return response()->json([
            'message' => ' Registro de foto eliminado con éxito',
            'data' => [],
            'status' => 200,
        ],200);
    }
}
