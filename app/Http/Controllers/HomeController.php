<?php

namespace App\Http\Controllers;

use App\Models\Contratos;
use Illuminate\Http\Request;
use App\Models\proyectos;
use App\Models\clientes;
use App\Models\Documentos;
use App\Models\lote;
use App\Models\Pagos;
use App\Models\User;
use DateTime;
use Dflydev\DotAccessData\Data;
use Psy\Readline\Hoa\Protocol;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admins = [
            "luisfer_hdz9@hotmail.com","osheto04@hotmail.com","angroman2022@gmail.com","oscarhzts963@outlook.com"
        ];
        $data = [
            "comprador" => false,
            "vendedor" => false,
            "cliente" => false,
            "admin" => false
        ];

        if(auth()->user()->isClient){
            $data["cliente"] = true;
            if(auth()->user()->isClient->tipo == "Comprador") {
                $data["comprador"] = true;
                $data["contratos"] = $this->pagosPendientesCliente(auth()->user()->isClient->id);
            }
        }

        if(auth()->user()->isAdmin){
            $data["admin"] = true;
        }

        if(auth()->user()->isSeller){
            $data["vendedor"] = true;
        }

        $proyectos = proyectos::all();
        $data["pendientesAdmin"] = $this->pagosPendientes();
        $data["documentosRevisar"] = $this->documentosRevisar();
        $data["proyectos"] = $proyectos;
        //return $data;
        return view('home', $data);

    }

    public function pagosPendientes() {

        $contratos = Contratos::all()->map(function ($e) {
            $json = json_decode($e->objeto , true);
            $e->cliente;
            $e->lote;
            $e->lote->proyecto;
            $e->pagos;
            $e = array_merge($e->toArray(),$json);
            if (isset($e["enganches"])) {
                $enganches = array_column($e["enganches"], 'cantidad');
                $e["enganche_total"] = array_sum($enganches);
            } else {
                $e["enganche_total"] = 0;
            }


            $e["enganche_pagado"] = array_reduce($e["pagos"], function ($carry, $e) {
                $valid =['enganches','enganche','Enganches','Enganche'];
                if (in_array(strtolower($e["concepto"]),$valid)) {
                    return $carry + $e["total_pago"];
                }
                return $carry;
            });


            $e["mensualidades_pagadas"] = array_reduce($e["pagos"], function ($carry, $e) {
                $valid = ['mensualidad','anualidad'];
                if (in_array(strtolower($e["concepto"]),$valid)) {
                    return $carry + $e["total_pago"];
                }
                return $carry;
            });
            $e["mensualidades_vencidas"] = $this->saldoVencido($e);
            $data = [
                "enganche" => $e["enganche_total"],
                "enganche_pagado" => $e["enganche_pagado"],
                "enganche_pendiente" =>  $e["enganche_total"]-$e["enganche_pagado"],
                // "saldo_pendiente" =>  $e["saldo_vencido"]-$e["total_pagos"],
                "mensualidades_vencidas" => $e["mensualidades_vencidas"],
                "mensualidades_pagadas" => $e["mensualidades_pagadas"],
                "mensualidades_pendientes" =>  $e["mensualidades_vencidas"]-$e["mensualidades_pagadas"],
                "proyecto" => $e["lote"]["proyecto"]["nombre"],
                "cliente" => $e["cliente"]["nombre"],
                "cliente_telefono" => $e["cliente"]["celular"],
                "lote" => $e["lote"]["lote"],
                "id_lote" => $e["lote"]["id"],
                "manzana" => $e["lote"]["manzana"],
                "id_cliente" => $e["cliente"]["id"]
            ];

            return $data;
        })
        ->filter(function ($e) {
            return ($e["mensualidades_pendientes"] > 0) || ($e["enganche_pendiente"] > 0) ;
        });;
        return $contratos;
    }

    public function saldoVencido($e) {
        $fechaDada = new DateTime($e["l_fecha"]);
        // Fecha actual
        $fechaActual = new DateTime();
        // Calcula la diferencia entre las fechas
        $diferencia = $fechaActual->diff($fechaDada);
        // Obtiene la diferencia en meses
        $meses = (int)$diferencia->format('%m');
        $años = (int)$diferencia->format('%y');
        $saldo = $meses* (float)$e["l_mensualidad"] + $años* (float)$e["l_anualidad"];
        return $saldo;
    }
    public function pagosPendientesCliente($id_cliente) {
        $contratos = Contratos::where("id_cliente",$id_cliente)->get()->map(function ($e) {
            $json = json_decode($e->objeto , true);
            $id_contrato = $e->id;
            $e->cliente;
            $e->lote;
            $e->lote->proyecto;
            $e->pagos;
            $e = array_merge($e->toArray(),$json);
            $enganches = array_column($e["enganches"], 'cantidad');
            $e["enganche_total"] = array_sum($enganches);
            $pagosAplican = array_filter($e["pagos"], function($item) {
                $s = $item["concepto"];
                return str_contains($s, 'Mensualidad') || str_contains($s, 'Anualidad') || str_contains($s, 'Enganche') ||str_contains($s, 'Apartado');
            });
            $pagos = array_column($pagosAplican, 'total_pago');
            $e["total_pagos"] = array_sum($pagos);
            $e["saldo_vencido"] = $this->saldoVencido($e);
            $data = [
                "saldo_vencido" => $e["saldo_vencido"],
                "total_pago" => $e["total_pagos"],
                "proyecto" => $e["lote"]["proyecto"]["nombre"],
                "cliente" => $e["cliente"]["nombre"],
                "lote" => $e["lote"]["lote"],
                "manzana" => $e["lote"]["manzana"],
                "pagos" => $e["pagos"],
                "id_cliente" => $e["cliente"]["id"],
                "id_lote" => $e["lote"]["id"],
                "id_contrato" => $id_contrato,
            ];
            return $data;
        });
        return $contratos;
    }

    public function analitika($fecha_ini, $fecha_fin)
    {
        $usuarios = User::whereBetween('created_at', [$fecha_ini, $fecha_fin])->get()->count();
        $pagos = Pagos::whereBetween('fechas', [$fecha_ini, $fecha_fin])->get()
        ->map(function ($e) {
            $e->cliente;
            $e->lote;
            return $e;
        });
        $pagos_efe = $pagos->filter(function ($e) {
            return $e["tipo"] =="Efectivo";
        })->sum("total_pago");
        $pagos_Trans = $pagos->filter(function ($e) {
            return $e["tipo"] =="Transferencia";
        })->sum("total_pago");
        $pagos_mens = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Mensualidad",) ;
        })->sum("total_pago");
        $pagos_eng = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Enganche",) ;
        })->sum("total_pago");
        $pagos_Anu = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Anualidad",) ;
        })->sum("total_pago");
        $pagos_otros = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Otros",) ;
        })->sum("total_pago");
        $pagos_apart = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Apartado",) ;
        })->sum("total_pago");
        $data = [
            "pagos" => $pagos->count(),
            "pagosArr" => $pagos,
            "pagos_total" => $pagos->sum("total_pago"),
            "pagos_efe" => $pagos_efe,
            "pagos_Trans" => $pagos_Trans,
            "pagos_mens" => $pagos_mens,
            "pagos_eng" => $pagos_eng,
            "pagos_Anu" => $pagos_Anu,
            "pagos_otros" => $pagos_otros,
            "usuarios" => $usuarios,
            "pagos_apart" => $pagos_apart];
        return response()->json($data);
    }

    public function analitikaPro($proyecto_id,$fecha_ini, $fecha_fin)
    {
        $proyecto = proyectos::where('id', $proyecto_id)->first();
        $usuarios = User::whereBetween('created_at', [$fecha_ini, $fecha_fin])->get()->count();
        $pagos = Pagos::whereHas('lotes', function ($e) use ($proyecto_id) {
            $e->where('proyecto_id', $proyecto_id);
        })
        ->whereBetween('fechas', [$fecha_ini, $fecha_fin])
        ->get()->map(function ($e) {
            $e->cliente;
            $e->lote;
            $e->lote->proyecto;
            return $e;
        });

        $pagos_efe = $pagos->filter(function ($e) {
            return $e["tipo"] =="Efectivo";
        })->sum("total_pago");

        $pagos_Trans = $pagos->filter(function ($e) {
            return $e["tipo"] =="Transferencia";
        })->sum("total_pago");

        $pagos_mens = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Mensualidad",) ;
        })->sum("total_pago");

        $pagos_eng = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Enganche",) ;
        })->sum("total_pago");

        $pagos_Anu = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Anualidad",) ;
        })->sum("total_pago");

        $pagos_otros = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Otros",) ;
        })->sum("total_pago");

        $pagos_apart = $pagos->filter(function ($e) {
            return str_contains($e["concepto"] ,"Apartado",) ;
        })->sum("total_pago");

        $data = [
            "pagos" => $pagos->count(),
            "pagosArr" => $pagos,
            "pagos_total" => $pagos->sum("total_pago"),
            "pagos_efe" => $pagos_efe,
            "pagos_Trans" => $pagos_Trans,
            "pagos_mens" => $pagos_mens,
            "pagos_eng" => $pagos_eng,
            "pagos_Anu" => $pagos_Anu,
            "pagos_otros" => $pagos_otros,
            "usuarios" => $usuarios,
            "pagos_apart" => $pagos_apart,
            "proyecto_nombre" => $proyecto->nombre,
        ];
        return response()->json($data);
    }

    public function documentos($id_contrato)
    {
        $documentos = Documentos::where('id_contrato', $id_contrato)->first();
            $data = [
                'ine_anverso' => $documentos->ine_anverso,
                's_ine_anverso' => $documentos->status_ine_anverso,
                'ine_reverso' =>  $documentos->ine_reverso,
                's_ine_reverso' => $documentos->status_ine_reverso,
                'com_dom' => $documentos->com_dom,
                's_com_dom' => $documentos->status_com_dom,
                'firma' => $documentos->firma,
                's_firma' =>$documentos->status_firma,
                'id' => $documentos->id,
            ];

            return response()->json($data);
    }


    public function SaveDocumentos(Request $r,$id_contrato)
    {
        $d = Documentos::where('id_contrato', $id_contrato)->first();

        if ($r->hasFile('ine_anverso')) {
            $ine_anverso = $r->file('ine_anverso')->store('documentos/' . $id_contrato);
            $d->ine_anverso = $ine_anverso;
            $d->status_ine_anverso = 1;
        }

        if ($r->hasFile('ine_reverso')) {
            $ine_reverso = $r->file('ine_reverso')->store('documentos/' . $id_contrato);
            $d->ine_reverso = $ine_reverso;
            $d->status_ine_reverso = 1;
        }

        if ($r->hasFile('com_dom')) {
            $com_dom = $r->file('com_dom')->store('documentos/' . $id_contrato);
            $d->com_dom = $com_dom;
            $d->status_com_dom = 1;
        }

        if ($r->firma) {
            $d->firma = $r->firma;
            $d->status_firma = 1;
        }

        $d->save();

        return response()->json([
            'message' => 'Actualizado con exito',
            'data' => $d,
            'status' => 200,
       ],200);
    }


    public function documentosRevisar(){
        $documentosRevisar = Documentos::all()->filter(function ($e) {
            return $e->status_ine_anverso === 1 || $e->status_ine_reverso === 1 || $e->status_com_dom === 1 || $e->status_firma === 1;
        })->map(function ($e) {
            $e->contrato;
            $e->contrato->lote->proyecto;
            $e->contrato->lote;
            $e->contrato->cliente;
            return [
                'ine_anverso' => $e->ine_anverso,
                's_ine_anverso' => $e->status_ine_anverso,
                'ine_reverso' => $e->ine_reverso,
                's_ine_reverso' => $e->status_ine_reverso,
                'com_dom' => $e->com_dom,
                's_com_dom' => $e->status_com_dom,
                'firma' => $e->firma,
                's_firma' => $e->status_firma,
                'id' => $e->id,
                'id_contrato' => $e->id_contrato,
                'cliente' => $e["contrato"]["cliente"]["nombre"],
                'lote' => $e["contrato"]["lote"]["lote"],
                'proyecto' => $e["contrato"]["lote"]["proyecto"]["nombre"],
                'manzana' => $e["contrato"]["lote"]["manzana"],
            ];
        });

        return $documentosRevisar;
    }

    public function SaveDocumentosRev(Request $r,$id_contrato)
    {
        $d = Documentos::where('id_contrato', $id_contrato)->first();

        if ($r->resultIneAn == null){
            $d->status_ine_anverso = $d->status_ine_anverso;
        } else{
            $d->status_ine_anverso = $r->resultIneAn;
        }

        if ($r->resultIneAn == 3) {
            $d->ine_anverso = null;
        }

        if ($r->resultIneRe == null){
            $d->status_ine_reverso = $d->status_ine_reverso;
        } else{
            $d->status_ine_reverso = $r->resultIneRe;
        }

        if ($r->resultIneRe == 3) {
            $d->ine_reverso = null;
        }

        if ($r->resultComDom == null){
            $d->status_com_dom = $d->status_com_dom;
        } else{
            $d->status_com_dom = $r->resultComDom;
        }

        if ($r->resultComDom == 3) {
            $d->com_dom = null;
        }

        if ($r->resultFirma == null){
            $d->status_firma = $d->status_firma;
        } else{
            $d->status_firma = $r->resultFirma;
        }

        if ($r->resultFirma == 3) {
            $d->firma = null;
        }

        $d->save();

        if ($d->status_ine_anverso == 2 && $d->status_ine_reverso == 2 && $d->status_com_dom == 2 && $d->status_firma == 2) {
            $c = Contratos::where('id', $id_contrato)->first();
            $c->archivo_val = 1;
        }

        return response()->json([
            'message' => 'Actualizado con exito',
            'data' => $d,
            'status' => 200,
       ],200);
    }

}
