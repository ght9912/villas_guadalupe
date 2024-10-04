<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcesoVenta;
use App\Models\User;
use App\Models\Actividades;
use App\Models\ActividadesDatos;
use App\Models\Vendedores;
use App\Models\Prospectos;
use App\Http\Controllers\Controller;
use App\Models\Embudos;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanelController extends Controller
{
    public function index($embudoId)
    {
        $embudo = Embudos::findOrFail($embudoId);
        $embudos = Embudos::all();

        $data = [
            "embudo" => $embudo,
            "embudos" => $embudos
        ];
        return view('panel', $data);
    }

    public function showPros($id)
    {
        $procesos = ProcesoVenta::where('id_embudo', $id)
            ->orderByRaw('ISNULL(orden), orden ASC')
            ->with('prospectos')
            ->get();

        return response()->json($procesos);
    }

    public function updateProspectoStatus(Request $request)
    {
        $prospectoId = $request->input('prospecto_id');
        $newProcesoId = $request->input('new_proceso_id');

        $prospecto = Prospectos::find($prospectoId);
        $oldData = $prospecto->status;

        if ($prospecto) {
            $prospecto->status = $newProcesoId;
            $prospecto->updated_at = now();
            $prospecto->save();

            $datosProspecto = "{$prospecto->id}, {$prospecto->nombre}";

            $dataUpdate = [
                "old_status" => $oldData,
                "new_status" => $newProcesoId,
            ];

            $this->registrarActividad("Cambio de status, {$datosProspecto}", $dataUpdate);

            return response()->json([
                'success' => true,
                'message' => 'Prospecto actualizado correctamente.',
                'updated_at' => $prospecto->updated_at->format('Y-m-d H:i:s')
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Prospecto no encontrado.']);
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

}
