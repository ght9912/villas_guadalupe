<?php

use App\Http\Controllers\VendedoresController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\EtapasController;
use App\Http\Controllers\LoteController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Vendedores;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\CaracteristicaEmpresaController;
use App\Http\Controllers\AnaliticasController;
use App\Http\Controllers\CalendarioTareasController;
use App\Http\Controllers\ProcesoVentaController;
use App\Http\Controllers\ProspectosController;
use App\Http\Controllers\EmbudosController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\AppController;
use App\Models\clientes;
use App\Models\Ofertas;
use App\Models\Pagos;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Amortization;
use App\Http\Controllers\AmortizacionController;
use App\Http\Controllers\FotosLotesController;
use App\Http\Controllers\HomeController;
use App\Models\Documentos;
use App\Models\fotos_lotes;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//* HOME
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/analitika/{fecha_ini}/{fecha_fin}', [HomeController::class, 'analitika']);
Route::get('/analitika/{proyecto_id}/{fecha_ini}/{fecha_fin}', [HomeController::class, 'analitikaPro']);
Route::get('/documentos/{id_contrato}', [HomeController::class,'documentos']);
Route::post('/documentos/actualizados/{id_contrato}', [HomeController::class,'saveDocumentos']);
Route::post('/documentos/revisado/{id_contrato}', [HomeController::class,'saveDocumentosRev']);
Route::get('/storage/{ruta}', function ($ruta) {$rutaArchivo = storage_path('app/' . $ruta);if (file_exists($rutaArchivo)) {return response()->file($rutaArchivo);} else {abort(404);}})->where('ruta', '.*');



//* PROYECTOS
Route::get('/proyectos', function(){return view('proyectos');});
Route::get('/proyectos/{id}/{nombre}', [ProyectosController::class, 'showProyecto'])->name('proyecto.view');
Route::get('proyectos/getProjects/', [ProyectosController::class, 'getProjects']);
Route::put('proyectos/updateEtapa/',[ProyectosController::class, 'updateEtapa']);
Route::resources(['proyectos' => ProyectosController::class]);
Route::post('proyectos/uploadImage', [ProyectosController::class,'uploadImage']);
Route::post('proyectos/storeEtapa/',[ProyectosController::class, 'storeEtapa']);
Route::post('proyectos/storeLotes/',[ProyectosController::class, 'storeLotes']);
Route::post('proyectos/updateLote/',[ProyectosController::class, 'updateLote']);
Route::get('proyecto/imagenes/{id}', [ProyectosController::class,'imagenes']);
Route::post('proyecto/imagenes', [ProyectosController::class,'imagenesSave']);
Route::post('proyecto/imagenesUpdate/{id}', [ProyectosController::class,'imagenesUpdate']);
Route::delete('proyecto/imagenesDelete/{id}', [ProyectosController::class,'imagenesDelete']);
Route::post('proyecto/detallesUpdate/{id}', [ProyectosController::class,'detallesProyecto']);


//* ETAPAS
Route::get('etapas/projectEtapas/{id}',[EtapasController::class,'projectEtapas']);
Route::get('etapas/getInfo/{id}', [EtapasController::class,'getInfo']);
Route::resource('etapas', EtapasController::class);


//*LOTES
Route::post('lotes/description/{id}',[LoteController::class,'updateDescription']);
Route::get('lotes/projectLotes/{id}',[LoteController::class, 'projectLotes']);
Route::delete('lotes/deleteSpecs',[LoteController::class, 'deleteSpecs']);
Route::get('lotes/zoneLotes/{id}',[LoteController::class, 'zoneLotes']);
Route::post('lotes/importData', [LoteController::class, 'importData']);
Route::get('lotes/create', [LoteController::class, 'create']);
Route::get('lotes/edit/{id}',[LoteController::class, 'edit']);
Route::post('lotes/createSpecs',[LoteController::class,'storeSpecs']);
Route::post('lotes/updateSpecs',[LoteController::class,'updateSpecs']);
Route::resource('lotes', LoteController::class);
Route::get('prospectos/lotes', [LoteController::class, 'lotesDis']);


//*FOTOS-LOTES
Route::post('fotos_lotes/upload', [FotosLotesController::class, 'upload']);
Route::get('fotos_lotes/tabla', [FotosLotesController::class, 'tabla']);
Route::resource('fotos_lotes',FotosLotesController::class,);



Route::get('/pdf', [App\Http\Controllers\pdfController::class, 'pdf'])->name('pdf');


//* USER
Route::post('users/search', [UserController::class,'search']);
Route::post('users/search2', [UserController::class,'search2']);



//* VENDEDORES
Route::post('vendedores/search', [VendedoresController::class,'search'])->name('vendedor.search');
Route::post('vendedores/formUser',[VendedoresController::class,'saveFromUser']);
Route::resources(['vendedores' => VendedoresController::class]);
Route::get('vendedores/detalles/{id}', [VendedoresController::class,'detallesCliente']);
Route::post('vendedores/detallesEdit/{id}', [VendedoresController::class,'detallesRedes']);
Route::post('vendedores/detallesAbout/{id}', [VendedoresController::class,'detallesAbout']);
Route::post('vendedores/detallesImagen/{id}', [VendedoresController::class,'detallesImagen']);
Route::post('vendedores/detallesNombre/{id}', [VendedoresController::class,'detallesNombre']);

//* PAGOS
Route::post('pagosImport/', [PagosController::class, 'importData']);
Route::resources(['pagos' => PagosController::class]);
Route::get('tablas/pagos', [PagosController::class,'tabla']);

//* CLIENTES
Route::post('clientes/search', [ClientesController::class,'search'])->name('cliente.search');
Route::post('clientes/formUser',[ClientesController::class,'saveFromUser']);
Route::get('clientes', [ClientesController::class, 'impoexpo'])->name('clientes.index');
Route::get('clientes/ofertas/{id}', [ClientesController::class,'getOfertasCliente']);
Route::put('clientesUpdate', [ClientesController::class, 'updateCliente']);
Route::post('clientes/importar', [ClientesController::class, 'importar']);
Route::get('clientes/cont', [ClientesController::class, 'cont']);
Route::get('clientes/ofertas/{id}', [ClientesController::class,'getOfertasCliente']);
Route::get('clientes/estado-cuenta/{id}/{id_lote}', [ClientesController::class,'estadoCuenta']);
Route::post('clientes/ofertas/mail', [ClientesController::class,'sendEmail'])->name('email');
Route::resources(['clientes'=>ClientesController::class]);
Route::get('prospectos/clientes', [ClientesController::class, 'show']);


//* OFERTAS
Route::get('/ofertas/pdf/amortizacion', function(){return view('pdf/amortizacion');});
Route::post('/ofertas/amortizacion', [OfertasController::class,'generarPDF'])->name('amortizacion');
Route::resources(['ofertas' => OfertasController::class]);
Route::get('ofertas/etapas/{proyecto}', [OfertasController::class , 'getEtapas']);
Route::get('ofertas/lotes/{etapa}', [OfertasController::class , 'getManzanaLotes']);
Route::post('ofertas/search', [ClientesController::class,'search']);
Route::post('ofertas/cliente/{id}', [ClientesController::class,'update']);
Route::get('ofertas/precios/{id}', [EtapasController::class,'getPrecios']);
Route::get('ofertas/superficie/{id}', [LoteController::class,'getSuperficie']);
Route::post('ofertas/guardaroferta', [OfertasController::class,'store']);
Route::delete('/ofertas/delete/{id}', [OfertasController::class,'destroy']);


//*CONTRATOS
Route::get("contratos/oferta/{id}",[pdfController::class,'contratOferta']);
Route::post('contratos/vistaprevia', [pdfController::class,'vistaPrevia']);
Route::post('contratos/importContracts',[pdfController::class, 'importContracts']);
Route::delete('contratos/delete/{id}', [pdfController::class,'eliminarContrato']);
Route::resources(['contratos' => pdfController::class]);

//*DOCUMENTOS
Route::resources(['documentos' => Documentos::class]);

//*CARACTERISTICAS
Route::resources(['caracteristicas' => CaracteristicaEmpresaController::class]);

//*ANALITICA
Route::resources(['analiticas' => AnaliticasController::class]);

//*PROSPECTOS
Route::get('prospectos/previewOferta', [ProspectosController::class, 'previewOferta']);
Route::resources(['prospectos' => ProspectosController::class]);
Route::post('prospectos/emailUsers',[ProspectosController::class, 'validarCorreo']);
Route::post('prospectos/cliente/{id}',[ProspectosController::class, 'Cliente']);
Route::post('prospectos/search', [ProspectosController::class,'search']);
Route::post('prospectos/oferta/{id}', [ProspectosController::class,'sendOferta']);
Route::get('tablas/prospecto', [ProspectosController::class,'tablaProspecto']);
// Route::get('procesoVenta/showProcesoVenta', [ProspectosController::class, 'showProcesoVenta']);
Route::get('prospecto/formulario/exists', [ProspectosController::class,'embudosConFormulario']);
Route::get('prospecto/formulario/notexists', [ProspectosController::class,'embudosSinFormulario']);

//*PROCESOVENTA
Route::resources(['procesoVenta' => ProcesoVentaController::class]);
Route::get('tablas/ProcesoVenta', [ProcesoVentaController::class,'tablaProcesoVenta']);
Route::post('procesoVenta/orden', [ProcesoVentaController::class, 'guardarNuevoOrden']);
Route::get('procesoVenta/show', [ProcesoVentaController::class, 'show']);


//*CALENDARIOTAREAS
Route::resources(['calendarioTareas' => CalendarioTareasController::class]);
Route::get('tablas/calendarioTareas', [CalendarioTareasController::class,'tablaCalendario']);
Route::get('eventos', [CalendarioTareasController::class, 'getEventos']);

//*EMBUDOS
Route::resources(['embudos' => EmbudosController::class]);
Route::get('tablas/embudos', [EmbudosController::class,'tablaEmbudo']);
Route::get('embudos/procesos/{id}', [EmbudosController::class,'showPros']);
Route::post('embudos/procesos/orden', [EmbudosController::class,'ordenProcesos']);
Route::post('embudos/formulario', [EmbudosController::class,'guardarCamposEmbudo']);

//*PANEL
Route::get('/panel/{embudo}', [PanelController::class, 'index'])->name('panel.index');
Route::get('panel/prospectos/{id}', [PanelController::class,'showPros']);
Route::post('panel/prospecto/update-status', [PanelController::class, 'updateProspectoStatus']);


//*RUTAS DE INFO
Route::get('/info/caracteristicas', [CaracteristicaEmpresaController::class, 'infoCaracteristicasEmpresa']);
Route::get('/info/imagenes/proyectos', [ProyectosController::class, 'infoImagenes']);
Route::get('/info/proyectos', [ProyectosController::class, 'info']);
Route::get('/info/vendedores', [VendedoresController::class, 'infoVendedores']);
