<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcesoVenta;
use App\Models\User;
use App\Models\Actividades;
use App\Models\ActividadesDatos;
use App\Models\Vendedores;
use App\Models\Embudos;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class ProcesoVentaController extends Controller
{
    public function index()
    {
        $procesoVenta = ProcesoVenta::orderBy('id_embudo')
                                    ->orderByRaw('ISNULL(orden), orden ASC')
                                    ->get();

        // Obtener todos los embudos
        $embudos = Embudos::all();

        $data = [
            "procesoVenta" => $procesoVenta,
            "embudos" => $embudos
        ];

        return view("procesoVenta", $data);
    }


    public function tablaProcesoVenta(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Filas mostradas por página
        $columnIndex = $request->get('order')[0]['column'] ?? 0; // Índice de columna
        $columnName = $request->get('columns')[$columnIndex]['data']; // Nombre de la columna
        $columnSortOrder = $request->get('order')[0]['dir'] ?? "asc"; // asc o desc
        $searchValue = $request->get('search')['value']; // Valor de búsqueda

        $query = ProcesoVenta::with('embudo');

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('id', 'like', '%'.$searchValue.'%')
                    ->orWhere('id_embudo', 'like', '%'.$searchValue.'%')
                    ->orWhere('orden', 'like', '%'.$searchValue.'%')
                    ->orWhere('status', 'like', '%'.$searchValue.'%')
                    ->orWhere('descripcion', 'like', '%'.$searchValue.'%')
                    ->orWhere('seguimiento', 'like', '%'.$searchValue.'%');
            });
        }

        $totalRecords = ProcesoVenta::count();
        $totalRecordwithFilter = $query->count();

        $query->orderBy('id_embudo', 'asc')
              ->orderBy('orden', 'asc');

        if ($columnName != 'id_embudo' && $columnName != 'orden') {
            $query->orderBy($columnName, $columnSortOrder);
        }

        $procesosVenta = $query->skip($start)
                                ->take($rowperpage)
                                ->get();

        $data = [];
        foreach($procesosVenta as $p){
            $embudoNombre = $p->embudo ? $p->embudo->nombre : 'Sin embudo';

            $data[] = [
                'id' => $p->id,
                'id_embudo' => $embudoNombre,
                'orden' => $p->orden,
                'status' => $p->status,
                'descripcion' => $p->descripcion,
                'seguimiento' => $p->seguimiento,
                'acciones' =>   '<div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$p->id.'">
                                        <li><a class="dropdown-item" onclick="editProcesoVenta('.$p->id.',this)">Editar</a></li>
                                        <li><a class="dropdown-item"  onclick="deleteProcesoVenta('.$p->id.',this)">Eliminar</a></li>
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
            'id_embudo' => 'required',
            'status' => 'required',
            'descrip' => 'required',
        ]);

        $maxOrden = ProcesoVenta::where('id_embudo', $r->id_embudo)
                    ->max('orden');

        $nuevoOrden = $maxOrden ? $maxOrden + 1 : 1;

        $p = new ProcesoVenta();
        $p->id_embudo = $r->id_embudo;
        $p->status = $r->status;
        $p->descripcion = $r->descrip;
        $p->seguimiento = $r->seg;
        $p->orden = $nuevoOrden;
        $p->save();

        $this->registrarActividad('Creación de proceso', $p);

        return response()->json([
            'message' => 'Proceso generado con éxito',
            'data' => $p,
            'status' => 200,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProcesoVenta  $ProcesoVenta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proceso = ProcesoVenta::find($id);

        return response()->json($proceso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProcesoVenta  $ProcesoVenta
     * @return \Illuminate\Http\Response
     */

    public function update(Request $r, $id)
    {
        $r->validate([
            'id_embudo' => 'required',
            'status' => 'required',
            'descrip' => 'required',
        ]);

        $p = ProcesoVenta::find($id);
        $oldData = $p->toArray();

        $oldIdEmbudo = $p->id_embudo;
        $oldOrden = $p->orden;

        $ps = ProcesoVenta::where('id_embudo', $oldIdEmbudo)->orderByRaw('ISNULL(orden), orden ASC')->get();
        $oldDataAll = $ps->toArray();

        if ($p->id_embudo != $r->id_embudo) {
            $maxOrden = ProcesoVenta::where('id_embudo', $r->id_embudo)
                        ->max('orden');

            $nuevoOrden = $maxOrden ? $maxOrden + 1 : 1;
            $p->id_embudo = $r->id_embudo;
            $p->orden = $nuevoOrden;

            $procesosRestantes = ProcesoVenta::where('id_embudo', $oldIdEmbudo)
                                ->where('orden', '>', $oldOrden)
                                ->count();

            if ($procesosRestantes >= 1) {
                ProcesoVenta::where('id_embudo', $oldIdEmbudo)
                    ->where('orden', '>', $oldOrden)
                    ->orderBy('orden')
                    ->chunkById(100, function ($procesos) {
                        foreach ($procesos as $proceso) {
                            $proceso->orden -= 1;
                            $proceso->save();
                        }
                    });
                $psRestantes = ProcesoVenta::where('id_embudo', $oldIdEmbudo)
                ->where('id', '!=', $p->id)
                ->orderByRaw('ISNULL(orden), orden ASC')
                ->get();

                $NewDataAll = $psRestantes->toArray();

                $dataUpdate2 = [ 'old' =>  $oldDataAll,
                                'new' => $NewDataAll,
                ];

                $this->registrarActividad('Cambio de orden de procesos', $dataUpdate2);

            }
        }

        $p->status = $r->status;
        $p->descripcion = $r->descrip;
        $p->seguimiento = $r->seg;
        $p->save();

        $dataUpdate = [
            "old" => $oldData,
            "new" => $p,
        ];

        $this->registrarActividad('Edición de proceso', $dataUpdate);

        return response()->json([
            'message' => 'Actualizado con éxito',
            'data' => $p,
            'status' => 200,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcesoVenta  $ProcesoVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = ProcesoVenta::find($id);

        $id_embudo = $p->id_embudo;
        $procesoVenta = ProcesoVenta::where('id_embudo', $id_embudo)->orderByRaw('ISNULL(orden), orden ASC')->get();
        $oldDataAll = $procesoVenta->toArray();

        if (!$p) {
            return response()->json([
                'message' => 'Proceso no encontrado',
                'status' => 404,
            ], 404);
        }

        $oldData = $p->toArray();
        $p->delete();

        $this->registrarActividad('Eliminación de proceso', $oldData);

        if ($p->orden != null) {
            $procesosRestantes = ProcesoVenta::where('id_embudo', $p->id_embudo)->count();

            if ($procesosRestantes > 1) {
                ProcesoVenta::where('id_embudo', $p->id_embudo)
                    ->where('orden', '>', $p->orden)
                    ->decrement('orden');

                $procesoVentaNew = ProcesoVenta::where('id_embudo', $id_embudo)->orderByRaw('ISNULL(orden), orden ASC')->get();
                $newDataAll = $procesoVentaNew->toArray();

                $dataUpdate = [
                    "old" => $oldDataAll,
                    "new" => $newDataAll,
                ];

                $this->registrarActividad('Cambio de orden de procesos', $dataUpdate);

                return response()->json([
                    'message' => 'Eliminado con éxito y orden actualizado',
                    'status' => 200,
                ], 200);
            }

            return response()->json([
                'message' => 'Eliminado con éxito, sin necesidad de reorganizar',
                'status' => 200,
            ], 200);
        }

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

    public function guardarNuevoOrden(Request $request)
    {
        $procesoVenta = ProcesoVenta::orderByRaw('ISNULL(orden), orden ASC')->get();

        $oldData = $procesoVenta->toArray();


        $ordenes = $request->input('orden');
        foreach ($ordenes as $o) {
            $pv = ProcesoVenta::find($o['id']);
            if ($pv) {
                $pv->orden = $o['orden'];
                $pv->save();
            }
        }

        $procesoVentaNew = ProcesoVenta::orderByRaw('ISNULL(orden), orden ASC')->get();

        $dataUpdate = [
            "old" => $oldData,
            "new" => $procesoVentaNew,
        ];

        $this->registrarActividad('Cambio de orden de procesos', $dataUpdate);


        return response()->json(['message' => 'Orden actualizado exitosamente'], 200);
    }
}
