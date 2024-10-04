<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\calendarioTareas;
use App\Models\Actividades;
use App\Models\ActividadesDatos;
use App\Models\CalendarioTareasVendedores;
use App\Models\CalendarioTareasRecursion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalendarioTareasController extends Controller
{
    public function index()
    {
        $calendarioTareas = calendarioTareas::all();


            $data=[
                "calendario"=>$calendarioTareas,
                 "recursos"=>[

                    ]
            ];

        return view("calendariosTareas",$data);
    }

    public function tablaCalendario(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Filas mostradas por página
        $columnIndex = $request->get('order')[0]['column'] ?? 0; // Índice de columna
        $columnName = $request->get('columns')[$columnIndex]['data']; // Nombre de la columna
        $columnSortOrder = $request->get('order')[0]['dir'] ?? "asc"; // asc o desc
        $searchValue = $request->get('search')['value']; // Valor de búsqueda

        $query = calendarioTareas::query();

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('id', 'like', '%'.$searchValue.'%')
                  ->orWhere('nombre_tarea', 'like', '%'.$searchValue.'%')
                  ->orWhere('descripcion_tarea', 'like', '%'.$searchValue.'%')
                  ->orWhere('fecha_inicio', 'like', '%'.$searchValue.'%')
                  ->orWhere('fecha_fin', 'like', '%'.$searchValue.'%');
            });
        }

        $totalRecords = calendarioTareas::count();
        $totalRecordwithFilter = $query->count();

        $calendarioTareas =   $query->with('vendedores')
                                    ->orderBy($columnName, $columnSortOrder)
                                    ->skip($start)
                                    ->take($rowperpage)
                                    ->get();

        $data = [];

        foreach ($calendarioTareas as $cT) {
            $vendedores = $cT->vendedores()->get();
            $vendedoresList = '<ul class="list-unstyled">';

            foreach ($vendedores as $v) {
                $vendedoresList .= '<li>' . $v->nombre . ' / ' . $v->email . '</li>';
            }

            $vendedoresList .= '</ul>';

            $data[] = [
                'id' => $cT->id,
                'nombre_tarea' => $cT->nombre_tarea,
                'descripcion_tarea' => $cT->descripcion_tarea,
                'fecha_inicio' => $cT->fecha_inicio,
                'fecha_fin' => $cT->fecha_fin,
                'vendedores' => $vendedoresList,
                'acciones' => '<div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $cT->id }}">
                        <li><a class="dropdown-item" onclick="editTarea('.$cT->id.',this)">Editar</a></li>
                        <li><a class="dropdown-item" onclick="deleteTarea('.$cT->id.',this)">Eliminar</a></li>
                    </ul>
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
            'vendedores' => 'required|array',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'repeticion' => 'nullable|integer',
            'fecha_fin_recursion' => 'nullable|date',
        ]);

        $cT = new CalendarioTareas();
        $cT->nombre_tarea = $r->nombre;
        $cT->descripcion_tarea = $r->descripcion;
        $cT->fecha_inicio = $r->fecha_inicio;
        $cT->fecha_fin = $r->fecha_fin;
        $cT->save();

        foreach ($r->vendedores as $vendedorId) {
            $cTV = new CalendarioTareasVendedores();
            $cTV->id_tarea = $cT->id;
            $cTV->id_vendedor = $vendedorId;
            $cTV->save();

            $this->registrarActividad('Vendedor asignado a tarea', $cTV);
        }

        if ($r->filled('repeticion') && $r->repeticion > 0) {

                $recu = new CalendarioTareasRecursion();
                $recu->id_tarea = $cT->id;
                $recu->repeticion = $r->repeticion;
                $recu->fecha_inicio = $r->fecha_inicio;
                $recu->fecha_fin = $r->fecha_fin_recursion;
                $recu->save();

                $this->registrarActividad('Creación de tarea recurrente', $recu);
        }


        $this->registrarActividad('Creación de tarea', $cT);

        return response()->json([
            'message' => 'Tarea generada con éxito',
            'data' => $cT,
            'status' => 200,
        ], 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\calendarioTareas  $calendarioTareas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tarea = calendarioTareas::find($id);

        return response()->json($tarea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\calendarioTareas  $calendarioTareas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'vendedor' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ]);

        $cT = calendarioTareas::find($id);

        $oldData = $cT->toArray();

        $cT->id_vendedor = $r->vendedor;
        $cT->nombre_tarea = $r->nombre;
        $cT->descripcion_tarea = $r->descripcion;
        $cT->fecha_inicio = $r->fecha_inicio;
        $cT->fecha_fin = $r->fecha_fin;
        $cT->save();

        $dataUpdate = [ "old" => $oldData,
                        "new" => $cT,
        ];

        $this->registrarActividad('Edición del tarea', $dataUpdate);

        return response()->json([
            'message' => 'Actualizado con exito',
            'data' => $cT,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\calendarioTareas  $calendarioTareas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cT = calendarioTareas::find($id);

        if (!$cT) {
            return response()->json([
                'message' => 'Tarea no encontrada',
                'status' => 404,
            ], 404);
        }

        $oldData = $cT->toArray();

        $vendedoresAsignados = CalendarioTareasVendedores::where('id_tarea', $id)->get();

        if ($vendedoresAsignados->isNotEmpty()) {
            foreach ($vendedoresAsignados as $vendedor) {
                $this->registrarActividad('Vendedor eliminado de tarea', $vendedor);
            }
            CalendarioTareasVendedores::where('id_tarea', $id)->delete();
        }

        $cT->delete();

        $this->registrarActividad('Eliminación de tarea', $oldData);

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

    public function getEventos(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $eventos = calendarioTareas::where(function ($query) use ($start, $end) {
            $query->where('fecha_inicio', '<=', $end)
                  ->where('fecha_fin', '>=', $start);
        })->get();

        $data = [];

        foreach($eventos as $evento) {
            $data[] = [
                'id' => $evento->id,
                'title' => $evento->nombre_tarea,
                'description' => $evento->descripcion_tarea,
                'start' => $evento->fecha_inicio,
                'end' => $evento->fecha_fin
            ];
        }

        return response()->json($data);
    }

}
