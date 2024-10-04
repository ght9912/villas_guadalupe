<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\etapas;
use App\Models\proyectos;
use App\Models\Ofertas;
use App\Models\lote;
use App\Models\clientes;
use App\Models\Pagos;
use App\Mail\OfertasMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;

class OfertasController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = proyectos::all();
        $etapas = etapas::all();
        $lotes = lote::all();

        $ofertas = Ofertas::all()->map(function($e){
            $e->proyecto;
            $e->etapa;
            $e->lote;
            return $e;
        });

        $data=["ofertas"=>$ofertas,"recursos"=>[
            "proyecto" => $proyectos,
            "etapa" => $etapas,
            "lote" => $lotes
            ]
        ];
        return view("ofertas",$data);
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
            'proyecto_id' => 'required',
            'zona_id' => 'required',
            'lote_id' => 'required',
            'cliente_id' => 'required',

        ]);

        $o=new Ofertas();
        $o->proyecto_id=$r->proyecto_id;
        $o->zona_id=$r->zona_id;
        $o->lote_id=$r->lote_id;
        $o->cliente_id=$r->cliente_id;
        $o->pago=$r->pago;
        $o->precio=$r->precio;
        $o->anualidad=$r->anualidad;
        $o->plazo=$r->plazo;
        $o->enganche=$r->enganche;

        $o->save();

        $user = auth()->user()->name;

        $nombreEtapa = optional($o->etapa)->e_name ?? ($o->etapa)->etapa;

        $tiposPago = $r->pago === 'FinanciadoPE' ? 'Financiado' : (
            $r->pago === 'Financiado' ? 'Financiado' : (
                $r->pago === 'ContadoPE' ? 'Contado' : (
                    $r->pago === 'FinanciadoPEA' ? 'Financiado con Anualidad' : (
                        $r->pago === 'FinanciadoA' ? 'Financiado con Anualidad' : 'Contado'
                    )
                )
            )
        );

        $data =[
            "precio" => $o->precio,
            "pago" => $tiposPago,
            "anualidad" =>$o->anualidad,
            "meses" => $o->plazo,
            "proyecto" => $o->proyecto->nombre,
            "etapa" => $nombreEtapa,
            "manzana" => $o->lote->manzana,
            "lote" => $o->lote->lote,
            "nombre" => $o->cliente->nombre,
            "enganche" => $o->enganche,
            ];

           $pdf = Pdf::loadView('pdf.amortizacion', $data);
           $archivo = $pdf->output();

        Mail::to($o->cliente->email)->send(new OfertasMail
        ($user,$archivo,$data));
        ClientesController::sendWhatsapp($o->cliente->celular);
        return response()->json([
             'message' => 'Oferta creada con exito',
             'data' => $o,
             'status' => 200,
        ],200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function show(Ofertas $ofertas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ofertas $ofertas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $o = Ofertas::find($id);
        $o->delete();
        return response()->json([
            'message' => 'Cliente eliminado con exito',
            'data' => [],
            'status' => 200,
        ],200);
    }
     /**
     * Obrtner la estapas del proyecto
     *
     * @param  string  $ofertas
     * @return any
     */
    public function getEtapas($proyecto)
    {
        //return $proyecto;
        return etapas::where("proyecto_id", $proyecto)->get();
    }
    /**
     * Obrtner la estapas del proyecto
     *
     * @param  string  $ofertas
     * @return any
     */
    public function getManzanaLotes($etapa)
    {
        //return $proyecto;
        return lote::where("etapa_id", $etapa)->get();
    }
    /**
     * Obtener las manzanas del proyecto
     *
     * @param  string  $ofertas
     * @return any
     */
    public function generarPDF(Request $request)
    {
       $meses = $request->input('Meses') ?? 1;
       $precio = $request->input('PrecioNum') ?? "";
       $anualidad = $request->input('AnualidadNum') ?? 0;
       $proyecto = $request->input('proyecto') ?? "";
       $etapa = $request->input('selectorEtapa') ?? "";
       $manzana = $request->input('selectorManzana') ?? "";
       $lote = $request->input('selectorLote') ?? "";
       $nombre = $request->input('nombre') ?? "";
       $enganche = $request->input('EngancheNum') ?? "";

       $meses = !empty($meses) ? (float) $meses : 1;
       $enganche = !empty($enganche) ? (float) $enganche : 0;
       $precio = !empty($precio) ? (float) $precio : 0;



        $data =[
        "precio" => $precio,
        "anualidad" =>$anualidad,
        "meses" => $meses,
        "proyecto" => $proyecto,
        "etapa" => $etapa,
        "manzana" => $manzana,
        "lote" => $lote,
        "nombre" => $nombre,
        "enganche" => $enganche,
        ];

       $pdf = Pdf::loadView('pdf.amortizacion', $data);
       return $pdf->stream();

    }
     /**
     * data pdf amortizacion
     *
     * @param  string  $ofertas
     * @return any
     */

    public function verofer(clientes $cliente)
    {
    $oferta = $cliente->ofertas->first();
    return response()->json(['oferta' => $oferta]);
    }

    }
