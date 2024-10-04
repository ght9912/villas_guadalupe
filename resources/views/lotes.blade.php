@extends('layouts.app')

@section('content')
<!-- Tabla -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Administrador de lotes</h1>
                <div name="botones">
                    {{-- <a href="{{ url('lotes/create')}}"  target="blank" class="btn btn-success fw-bold">
                        Añadir lote
                    </a> --}}
                    <button class="btn btn-success fw-bold" id="btnAdd">
                        Añadir lote
                    </button>
                    <button class="btn btn-primary fw-bold" id="btnImport">
                        Importar lotes
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Clave</th>
                            <th scope="col">Proyecto</th>
                            <th scope="col">Zona</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Manzana</th>
                            <th scope="col">Área</th>
                            <th scope="col">Estado</th>
                            <th scope="col" style="text-align:center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($lote as $l)
                        <tr>
                            <td class="id"style="font-size: small;">{{$l->id}}</td>
                            <td class="text-center"><div class="btn btn-primary btn-sm " onclick="ver({{$l->id}},this)"><em>L{{$l->lote}}M{{$l->manzana}}{{$l->proyecto->clave}}</em></div></td>
                            <td style="font-size: small;">{{$l->proyecto->nombre}}</td>
                            <td style="font-size: small;">{{$l->etapa->etapa}} {{$l->etapa->e_name}}</td>
                            <td class="text-center" style="font-size: small;">{{$l->lote}}</td>
                            <td class="text-center" style="font-size: small;">{{$l->manzana}}</td>
                            <td class="text-center" style="font-size: small;">{{$l->superficie}} m<sup>2</sup></td>
                            <td style="font-size: small;">{{$status[$l->estado]}}</td>
                            <td >
                                <div class="d-flex">
                                    <a href="{{ url('lotes/' . $l->id) }}" target="_blank" class="btn btn-primary btn-sm me-1 fw-bold">Ver
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editLote({{ $l->id }},this)">
                                        Editar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="deleteLote({{ $l->id }},this)">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal ver, crear y editar-->
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document" aria-hidden="true" style="max-width:85% !important">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header sticky-top bg-light">
                    <h5 class="modal-tittle fw-bold" id="modalTitle">
                    Nuevo lote </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="formAdd">
                        <div class="row" id="row-lote">
                            <div class="row pe-0 me-0 mb-2"> <!--Id, clave y estado-->
                                <div class="col-2 col-md-2 ps-0 pe-2 ">
                                    <label for="id" class="fw-bold">id</label>
                                    <input readonly type="number" name="id" id="id" class="form-control reset ">
                                </div>
                                <div class="col-3 ps-0 pe-2">
                                    <label for="clave" class="fw-bold">Clave</label>
                                    <input readonly type="text" name="clave" id="clave" class="form-control reset " placeholder="Autogenerado">
                                </div>
                                <div class="col-7 ps-0 pe-2">
                                    <label for="estado" class="fw-bold">Estado</label><br/>
                                    <select name="estado" id="estado" class="form-select reset fillable">
                                        <option value="0">No disponible</option>
                                        <option value="1" selected>Disponible</option>
                                        <option value="2">Apartado</option>
                                        <option value="3">Vendido al contado</option>
                                        <option value="4">Vendido a crédito</option>
                                        <option value="5">Liquidado</option>
                                        <option value="6">En recuperación</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pe-0 me-0 mb-2"> <!--Proyecto y etapa -->
                                <div class="col-lg-6 ps-0 pe-2">
                                    <label for="proyecto_id" class="fw-bold">Pertenece al proyecto:</label>
                                    <select name="proyecto_id" id="proyecto" class="form-select reset selectSearch-trigger">
                                        <option value="0">Seleccionar proyecto</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 ps-0 pe-2 selectSearch-container">
                                    <label for="etapa_id" class="fw-bold">Zona:</label>
                                    <input type="text" list="etapas" name="etapa_id" id="etapa" class="form-control d-List" placeholder="Buscar zona" data-id="">
                                    <datalist id="etapas">
                                        <option value="Seleccionar zona">Seleccionar zona</option>
                                    </datalist>
                                </div>
                            </div>
                            <!--Lote, manzana, superficie y ubicación-->
                            <div class="row pe-0 mb-2">
                                <div class="col-6 col-md-3 px-0">
                                    <label for="lote" class="fw-bold">Lote</label>
                                    <input type="number" name="lote" id="lote" class="form-control reset fillable editable" placeholder="Lote No.">
                                </div>
                                <div class="col-6 col-md-3 px-1">
                                    <label for="manzana" class="fw-bold">Manzana</label>
                                    <input type="number" name="manzana" id="manzana" class="form-control reset fillable " placeholder="Manzana No.">
                                </div>
                                <div class="col-6 col-md-3 ps-0 pe-1">
                                    <label for="superficie" class="fw-bold">Superficie</label>
                                    <input type="number" name="superficie" id="Superficie" placeholder="m2"  class="form-control reset fillable editable" >
                                </div>
                                <div class="col-6 col-md-3 ps-0 pe-2">
                                    <label for="ubicacion" class="fw-bold">Ubicación</label>
                                    <input type="text" name="ubicacion" id="ubicacion" pattern="^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6},\s?-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000" class="form-control reset fillable editable geo">
                                </div>
                            </div>
                            <!-- Descripción y características adicionales del lote -->
                           {{--  <div class="row">
                                <div class="col-6 col-xs-12">
                                    <label for="descripcion" class=" form-label fw-bold">Descripción del lote</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control reset fillable editable" rows="2" placeholder="Datos que ayuden a identificar mejor el lote o que resalten sus  características positivas."></textarea>
                                </div>
                                <div class="col-6 col-xs-12">
                                    <div class="row mx-0">
                                        <label for="spec" class="form-label fw-bold">Características</label>
                                        <input hidden readonly type="text" name="specs" id="specs" class="form-control mx-0 reset fillable">
                                    </div>
                                    <div id="box-specs" class="row border border-start-0 border-top-0 border-primary px-0 py-1 mx-0">
                                        <div class="row ms-0 mb-2 ps-0 row-head">
                                            <div class="col-4 ps-0">
                                                <label for="" class="fw-bold">Nombre:</label>
                                            </div>
                                            <div class="col-7 ps-0">
                                                <label for="" class="fw-bold">Valor:</label>
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" class="btn btn-primary btn-sm fw-bold py-0 fillable addPair s" title="Agregar una característica">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!--Vertices, medidas y colindancias-->
                            <div class="row pe-0 me-0 mb-1">
                                <div class="col-xl-4 col-lg-6 col-sm-12 ps-0 pe-1 mb-2"><!--Vertices-->
                                    <div class="row mx-0">
                                        <label for="vertices" class="fw-bold">Vertices</label>
                                        <input hidden readonly type="text" name="vertices" id="vertices" class="form-control mx-0 reset fillable">
                                    </div>
                                    <div id="box-vertices" class="row border border-start-0 border-top-0 border-primary px-0 py-1 mx-0">
                                        <div class="row ms-0 mb-2 ps-0 row-head">
                                            <div class="col-4 ps-0">
                                                <label for="" class="fw-bold">Punto:</label>
                                            </div>
                                            <div class="col-7 ps-0">
                                                <label for="" class="fw-bold">Ubicación:</label>
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" class="btn btn-primary btn-sm fw-bold py-0 fillable addPair v" title="Agregar una entrada">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-12 ps-0 pe-1 mb-2"><!--Medidas-->
                                    <div class="row mx-0">
                                        <label for="medidas" class="fw-bold">Medidas</label>
                                        <input hidden readonly type="text" name="medidas" id="medidas" class="form-control reset">
                                    </div>
                                    <div id="box-medidas" class="row border border-start-0 border-top-0 border-primary px-0 py-1 mx-0">
                                        <div class="row ms-0 ps-0 mb-2 row-head">
                                            <div class="col-4 ps-0">
                                                <label for="" class="fw-bold">Segmento (x-y):</label>
                                            </div>
                                            <div class="col-7 ps-0">
                                                <label for="" class="fw-bold">Longitud:</label>
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" title="Agregar una entrada" class="btn btn-primary btn-sm fw-bold py-0 fillable addPair m">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-12 ps-1 pe-0 mb-2"><!--Colindancias-->
                                    <div class="row mx-0">
                                        <label for="colindancias" class="fw-bold">Colindancias</label>
                                        <input hidden readonly type="text" name="colindancias" id="colindancias" class="form-control reset fillable">
                                    </div>
                                    <div id="box-colindancias" class="row border border-start-0 border-top-0 border-primary px-0 py-1 mx-0">
                                        <div class="row ms-0 ps-0 mb-2 row-head">
                                            <div class="col-4 ps-0">
                                                <label for="" class="fw-bold">Colinda al:</label>
                                            </div>
                                            <div class="col-7 ps-0">
                                                <label for="" class="fw-bold">con:</label>
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" class="btn btn-primary btn-sm fw-bold py-0 fillable addPair c" title="Agregar una entrada">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pe-0 me-0 mb-1 editable"> <!--Comprador y vendedor -->
                                <div class="col-6 ps-0 pe-2">
                                    <label for="comprador_id" class="fw-bold">Comprador</label>
                                    <button id="btnSearchClient" class="btn btn-primary btn-sm ms-2 mb-1 fw-bold callSearch clientes">Buscar</button>
                                    <input readonly type="hidden" name="comprador_id" id="comprador_id" class="editable">
                                    <input readonly type="text" name="compradorName" id="comprador" placeholder="No proporcionado" readonly class="form-control reset editable">
                                </div>
                                <div class="col-6 ps-0 pe-2">
                                    <label for="vendedor_id" class="fw-bold">Vendedor</label>
                                    <button id="btnSearchSeller" class="btn btn-primary btn-sm ms-2 mb-1 fw-bold callSearch">Buscar</button>
                                    <input readonly type="hidden" name="vendedor_id" id="vendedor_id" class="editable">
                                    <input readonly type="text" name="vendedorName" id="vendedor" placeholder="No proporcionado" readonly class="form-control reset editable">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="modalFooter" class="modal-footer">
                <button type="button" id="btnSave" title="Guardar los datos del lote" class="btn btn-success create">Guardar</button>
                <button type="button" id="btnVerEditar" title="Editar datos del lote" class="btn btn-warning fw-bold see">Editar lote</button>
                <button type="button" id="btnDelete" class="btn btn-danger fw-bold see">Eliminar lote</button>
                <button type="button" id="btnClose" onclick=`${$('#mainModal').modal('hide')}` class="btn btn-secondary fw-bold create see">Cerrar</button>
                <button type="button" id="btnSaveChanges" title="Guardar cambios a la información del lote." class="btn btn-success fw-bold editable" >Guardar cambios</button>
                <button type="button" id="btnDismiss" title="Los cambios no guardados del lote se eliminarán." class="btn btn-danger fw-bold editable">Descartar y cerrar</button>
            </div>
            </div>
        </div>
    </div>
</div>

<!--Modal buscar cliente-->
<div tableindex="-1" role="dialog" aria-labelledby="searchModalTitle" aria-hidden="true" id="searchPeerModal" class="modal fade modal-lg">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-tittle fw-bold" id="searchModalTitle">
                    Nuevo lote </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="findClientForm">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" id="search" class="form-control">

                            </div>
                            <div class="col-3">
                                <button id="btnSearch" class="btn btn-primary fw-bold">Buscar</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="table2" class="table">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Actions</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal importar -->
<div tabindex="-1" role="dialog" aria-labelledby="modalImportTitle" aria-hidden="true" id="modalImport" class="modal fade">
    <div role="document" style="max-width:70%; !important" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalImportTitle" class="modal-title fw-bold">Importar datos</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="close" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10 col-md-8">
                        <h6>Aquí se puede importar información de lotes ya contenida en un archivo de Excel.</h6>
                        <p>Es necesario descargar y vaciar los datos a importar en el archivo de Excel que se puede descargar desde <a href="{{ asset('form_import_to_new_project.xlsx') }}" download class="btn btn-primary btn-sm fw-bold">aquí</a>.</p>
                        <p>Una vez que se hayan llenado los datos se puede proceder a lo siguiente:</p>
                    </div>
                    <div class="col-1 col-md-2"></div>
                </div>
                <form action="{{url('lotes/importData')}}" method="POST" enctype="multipart/form-data" id="formImport">
                    @csrf
                    <div class="row mt-2 mb-2"> <!-- Paso 1 -->
                        <div class="col-1"></div>
                        <div class="col-10 col-md-8">
                            <p class="mb-2"><span class="fw-bold">Primero,</span> hay que definir en cuál proyecto se va a insertar los lotes importados.</p>
                            <select name="proyecto_id" id="importToProject" class="form-select mb-2">
                                <option value="0">Seleccionar proyecto</option>
                            </select>
                        </div>
                        <div class="col-1 col-md-2"></div>
                    </div>
                    <div class="row mt-2 mb-2"> <!-- Paso 2 -->
                        <div class="col-1"></div>
                        <div class="col-10 col-md-8">
                            <p class="mb-2"><span class="fw-bold">Segundo,</span> hay que definir a cuál zona se van a agregar los lotes importados</p>
                            <input  type="radio" autocomplete="off" id="importZone" name="import" value="true" class="btn-check radios" title="Se creará una o más zonas al importar la información.">
                            <label for="importZone" title="Se creará una o más zonas al importar la información." class="btn btn-secondary">Crear zonas</label>
                            <input  type="radio" autocomplete="off" id="useZone" name="import" value="false" class="btn-check radios" title="Se importará  todos los lotes a una zona ya creada.">
                            <label for="useZone"  title="Se importará  todos los lotes a una zona ya creada." class="btn btn-primary">A zona existente</label>
                        </div>
                        <div class="col-1 col-md-2"></div>
                    </div>
                    <div class="row mt-2"> <!-- Selección de zona -->
                        <div class="col-1"></div>
                        <div class="col-10 col-md-8">
                            <select disabled name="etapa_id" id="importToZone" class="form-select reset">
                                <option value="0">Seleccionar zona</option>
                            </select>
                        </div>
                        <div class="col-1 col-md-2"></div>
                    </div>
                    <div class="row mt-2 mb-2"><!-- Paso 3 -->
                        <div class="col-1"></div>
                        <div class="col-8">
                            <p class="mb-2"><span class="fw-bold">Tercero,</span> carga el archivo del que se van a extraer los datos</p>
                            <input disabled type="file" name="archivo" id="archivo" required="required" class="form-control">
                        </div>
                        <div class="col-2"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button disabled type="submit" id="btnReqImport" class="btn btn-primary">Importar</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Modal borrar -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteTitle"></h5>
                <button type="button" class="btn-close"data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este lote?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="btnCancelDelete">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btnConfirmDelete">Confirmar</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script>

    const mainData = {{ Js::from($lote) }}
    const mainProjects = {{ Js::from($proyecto)}}

    const loteStatus = {
        0 : 'No disponible',
        1 : 'Disponible',
        2 : 'Apartado',
        3 : 'Vendido al contado',
        4 : 'Vendido a crédito',
        5 : 'Liquidado',
        6 : 'En recuperación'
    };

    const findLote = (id) => {
        let el;
        mainData.every((e) => {
            if(e.id == id) {
                el = e;
                return false;
            }
            return true;
        });
        return el;
    }

    const resetModal = () => {
        $("#modalTitle").html('');
        $(".remove, .row-pair").remove();
        $("select").prop("disabled",false);
        for(let i = 0; i < mainProjects.length; i++){
            let option = `<option value="${mainProjects[i].id}" class="remove">${mainProjects[i].nombre} ${mainProjects[i].clave}</option>`;
            $(option).appendTo($("#proyecto"));
        }
        $("select.option[value=0]").prop("selected",true);
        $(".update").removeClass("update");
        $(".watch").removeClass("watch");
        $("#modalFooter button").prop("hidden",true);
        $("input.reset").val('');
        $(":text").prop("readonly",true);
    };

    const resetImportModal = () => {
        $("select").prop("disabled",false);
        for(let i = 0; i < mainProjects.length; i++){
            let option = `<option value="${mainProjects[i].id}" class="remove">${mainProjects[i].nombre} ${mainProjects[i].clave}</option>`;
            $(option).appendTo($("#importToProject"));
        }
        $("select.option[value=0]").prop("selected",true);
        // $(".radios").prop("disabled",true);
        // $("#importToZone").prop("disabled",true);
    };

    const setToCreate = () => {
        $("#modalTitle").html("Registro de nuevo lote");
        $('input[type="number"], #btnSave, #etapa').prop("disabled",true);
        $(":text.fillable").prop("readonly",true);
        $("#btnSave").prop("disabled",false);
        $("#modalFooter button.create").prop("hidden",false);
    };

    const setClave = () => {
        const pId = $("#proyecto :selected").val();
        const pClave = (mainProjects.find((e) => e.id == pId)).clave;
        const lClave = `L${$("#lote").val()}M${$("#manzana").val()}${pClave}`;
        $("#clave").val(lClave);
    };

    const loadData = (json,target) => {
        $.each(json, function(key,value) {
            $(`#box-${target}`).append(pairCont);
            $(`#box-${target} :last-Child`).find('.key').val(key);
            $(`#box-${target} :last-Child`).find('.val').val(value);
        })
    };

    const setOnStore = () => {
        $(":text, input[type='number']").prop("readonly",true);
        $("select").prop("disabled",true);
        $(":button.create, .addPair, .delPair, .callSearch").prop("hidden",true);
        $(":button.see").prop("hidden",false);
    };//* Listo

    const setInputsData = (data) => {
        $("#id").val(data.id);
        $("#clave").val(`L${data.lote}M${data.manzana}${data.proyecto.clave}`);
        $("select").prop("disabled",false);
        $(`#estado option[value=${data.estado}]`).prop("selected",true);
        $(`#proyecto option[value=${data.proyecto_id}]`).prop("selected",true);
        axios.get("etapas/projectEtapas/"+data.proyecto_id).then((e) =>{
            const r = e.data.data;
            for(let i = 0; i < r.length; i++){
                let option = `<option value="${r[i].id}" class="remove">${r[i].etapa} ${r[i].e_name}</option>`
                $(option).appendTo($("#etapa"));
            }
            $("#etapa option[value=0]").html("Seleccionar zona");
            $(`#etapa option[value=${data.etapa_id}]`).prop("selected",true);
        }).catch((e) => {
            $("#etapa option[value=0]").html("Sin zonas registradas");
            console.log(e);
        });
        $("#lote").val(data.lote);
        $("#manzana").val(data.manzana);
        $("#Superficie").val(data.superficie);
        $("#ubicacion").val(data.ubicacion);
        if(data.comprador_id){
            $("#comprador_id").val(data.comprador_id);
            $("#comprador").val(data.comprador.nombre);
        }
        if(data.vendedor_id) {
            $("#vendedor_id").val(data.vendedor_id);
            $("#vendedor").val(data.vendedor.nombre);
        }
        if(data.vertices){
            $("#vertices").val(data.vertices);
            const v = JSON.parse(data.vertices);
            loadData(v,"vertices");
        }
        if(data.medidas){
            $("#medidas").val(data.medidas);
            const m = JSON.parse(data.medidas);
            loadData(m,"medidas");
        }
        if(data.colindancias){
            $("#colindancias").val(data.colindancias);
            const c = JSON.parse(data.colindancias);
            loadData(c,"colindancias");
        }
    };

    const setToSee = (data) => {
        $(":button.see").prop("hidden",false);
        $("select").prop("disabled",true);
        $(":text, input[type='number']").prop("readonly",true);
        $(".addPair, .delPair").prop("hidden",true);
        $("#modalTitle").html(`Vista del lote "L${data.lote}M${data.manzana}${data.proyecto.clave}"`);
    };

    const setToEdit = (data) => {
        $("select").prop("disabled",true);
        $("button.see").prop("hidden",true);
        $(".editable, .key, .val").prop("readonly",false);
        $(".addPair, .delPair").prop("hidden",false);
        $("div.editable").prop("hidden",false);
        $("button.editable").prop("hidden",false);
        $("input.editable").addClass("watch");
        $("select.editable").prop("disabled",false);
        $("#modalTitle").html(`Edición del lote "L${data.lote}M${data.manzana}${data.proyecto.clave}"`);
    };//* Listo

    const packFormData = () => {
        let data = new FormData();
        $("#row-lote").each((i,e) => {
            $(e).find("input").each((i1,e1) => {
                // data.append($(e1).attr("name"),$(e1).val());
                if($(e1).hasClass('d-List')) {
                    data.append($(e1).attr("name"), $(e1).data("id"));
                }else {
                    data.append($(e1).attr("name"), $(e1).val());
                }
            });
            $(e).find("textarea").each((i1,e1) => {
                // data.append($(e1).attr("name"),$(e1).val());
                if($(e1).hasClass('d-List')) {
                    data.append($(e1).attr("name"), $(e1).data("id"));
                }else {
                    data.append($(e1).attr("name"), $(e1).val());
                }
            });
            $(e).find("select").each((i2,e2) => {
                data.append($(e2).attr("name"),$(e2).find(":selected").val());
            });
        });
        return data;
    };//* Listo

    const packData = (selector) => {
        let data = [];
        $(selector).each((i, e) => {
            let array1 = {};
            $(e).find("input").each((i1, e1) => {
                if($(e1).hasClass('d-List')) {
                    array1[$($(e1).attr("name"))] = $(e1).attr("id");
                }else {
                    array1[$(e1).attr("name")] = $(e1).val();
                }
            });
            $(e).find("select").each((i2, e2) => {
                array1[$(e2).attr("name")] = $(e2).find(":selected").val();
            });
            data.push(array1);
        });
        return data;
    };//* Listo

    const packJson = (string) => {

        let pack = {};

        if (string == "specs") {
            pack = [];
        }

        $(`#box-${string} > .row-pair`).each((i,e)=>{
            if (string == "specs") {
                pack.push({
                    titulo:$(e).find(".key").val(),
                    value:$(e).find(".val").val()
                })
            } else {
                pack[$(e).find(".key").val()] = $(e).find(".val").val();
            }
        });
        $(`#${string}`).val(JSON.stringify(pack));
        return pack;
    };//*

    const step1 = function () {
        $("#btnAdd").trigger("click");
        // $("#proyecto").focus();
        $("#proyecto option[value=32]").prop("selected",true);
        $("#proyecto").trigger("change");
        $("#etapa").val("C");
    };

    const step2 = function () {
        $("#etapa").trigger("change");
        $("#lote").val(1);
        $("#manzana").val(1);
        $("#Superficie").val(200);
        $("#ubicacion").val("80.010203 101.908070");
        $("#descripcion").val("Lote ubicado en la zona más accesible del desarrollo.");
    };

    const step3 = function () {
        $("#box-specs .key:last").val("Tiempo de escrituración");
        $("#box-specs .val:last").val("3 a 12 meses");
        $("#box-specs .addPair").trigger("click");
        $("#box-specs .key:last").val("Cuenta con electricidad");
        $("#box-specs .val:last").val("No");

        $("#box-vertices .key:last").val("A");
        $("#box-vertices .val:last").val("");
        $("#box-vertices .addPair").trigger("click");
        $("#box-vertices .key:last").val("B");
        $("#box-vertices .val:last").val("");
        $("#box-vertices .addPair").trigger("click");
        $("#box-vertices .key:last").val("C");
        $("#box-vertices .val:last").val("");
        $("#box-vertices .addPair").trigger("click");
        $("#box-vertices .key:last").val("D");
        $("#box-vertices .val:last").val("");

        $("#box-medidas .key:last").val("AB");
        $("#box-medidas .val:last").val("10");
        $("#box-medidas .addPair").trigger("click");
        $("#box-medidas .key:last").val("BC");
        $("#box-medidas .val:last").val("20");
        $("#box-medidas .addPair").trigger("click");
        $("#box-medidas .key:last").val("CD");
        $("#box-medidas .val:last").val("10");
        $("#box-medidas .addPair").trigger("click");
        $("#box-medidas .key:last").val("DA");
        $("#box-medidas .val:last").val("20");

        $("#box-colindancias .key:last").val("Norte");
        $("#box-colindancias .val:last").val("L11M1");
        $("#box-colindancias .addPair").trigger("click");
        $("#box-colindancias .key:last").val("Sur");
        $("#box-colindancias .val:last").val("Calle 1");
        $("#box-colindancias .addPair").trigger("click");
        $("#box-colindancias .key:last").val("Oriente");
        $("#box-colindancias .val:last").val("L2M1");
        $("#box-colindancias .addPair").trigger("click");
        $("#box-colindancias .key:last").val("Poniente");
        $("#box-colindancias .val:last").val("Calle 2");

        $("#btnSave").trigger("click");
    }


    const pairCont = `<div class="row ms-0 ps-0 mb-1 row-pair">
                <div class="col-4 ps-0 pe-1">
                    <input type="text" name="clave" id="" class="form-control form-control-sm key">
                </div>
                <div class="col-7 ps-0 pe-1">
                    <input type="text" name="valor" id="" class="form-control form-control-sm val">
                </div>
                <div class="col-1 px-0 text-center">
                    <button type="button" title="Borrar esta entrada" class="btn btn-secondary btn-sm fw-bold py-0 delPair">-</button>
                </div>
            </div>`;

    const ver = async function (id,nombre) {
        const lote = findLote(id);
        if(lote == undefined){return}
        $("#mainModal").modal("show");
        resetModal();
        setInputsData(lote);
        setToSee(lote);
    };

    const updateLote = (id,data) => {
        let updated = false;
        mainData.every((e,i) => {
            if(e.id == id){
                mainData[i] = data;
                updated = true;
                return false;
            }
            return true;
        });
        return updated;
    };

    const editLote = async (id, el) => {
        const lote = findLote(id);
        if(lote == undefined){return}
        $("#mainModal").modal("show");
        resetModal();
        setInputsData(lote);
        setToEdit(lote);
        $(`td:contains(${id})`).parent('tr').addClass(`update-${id}`);
    };

    const deleteLote = (id, el) => {
        let lote = findLote(id);
        $("#modalDelete").modal("show");
        $("#modalDelete").data("id",id);
        $("#modalDeleteTitle").html(`Eliminar el lote <b>${lote.lote}</b> manzana <b>${lote.manzana}</b> del proyecto <b>${lote.proyecto.nombre}</b>`);
        $(`td.id:contains(${id})`).parent('tr').addClass(`remove-${id}`);
    };


</script>

<script type="module">

    $(document).ready(() => {
        $(".table").DataTable()

    });

    //* Modifica los valores introducidos
    $(".geo").on('input', function() {
        this.value = this.value.replace(/[^0-9.\-\s]/g, '');
    });

    //* Abre y setea el modal para crear un nuevo lote
    $("#btnAdd").click(() => {
        $("#mainModal").modal("show");
        resetModal();
        setToCreate();
    });

    //* Abre y setea el modal para importar
    $("#btnImport").click((e) => {
        $("#formImport").trigger("reset");
        resetImportModal();
        $("#modalImport").modal("show");
    });

    //* Obtiene las zonas correspondientes al seleccionar uno de los proyectos
    $("#importToProject").change( async function (e) {
        if($("#importToProject :selected").val() > 0){
            const pId = $("#importToProject :selected").val();
            console.log(pId);
            $("#importToZone .removable").remove();
            $("#importToZone").prop("disabled",false);
            axios.get("etapas/projectEtapas/"+pId).then((e) =>{
                const r = e.data.data;
                console.log(r);
                for(let i = 0; i < r.length; i++){
                    let option = `<option value="${r[i].id}" class="removable">${r[i].etapa} ${r[i].e_name}</option>`
                    $(option).appendTo($("#importToZone"));
                }
                r.length > 0 ? $("#importToZone option[value=0]").html("Seleccionar zona") : $("#importToZone option[value=0]").html("Sin zonas registradas");
                $("#importToZone").prop("disabled",true);
                $(".radios").prop("disabled",false);
            }).catch((e) => {
                $("#importToZone option[value=0]").html("Sin zonas registradas");
                console.log(e);
            });
        }else{
            $("#importToZone option[value=0]").prop("selected",true);
            $("#importToZone").prop("disabled",true);
        }
    });//* Listo

    //*Cambia las propiedades del botón alterno y el input de archivo al seleccionar entre importar zonas o crearlas.
    $(document).on("click",".radios", function (e) {
        if($("input[name=import]:checked").val() == "false") {
            $("#importToZone").prop("disabled",false);
            $("#archivo").prop("disabled",true);
        }else{
            $("#importToZone").prop("disabled",true);
            $("#archivo").prop("disabled",false);
        }
    });

    //* Inhabilita el input de archivo si no se selecciona ninguna zona y lo habilita si se selcciona una.
    $("#importToZone").change((e) => {
        // let pId = $("#importToProject :selected").val();
        $("#importToZone :selected").val != 0 ? $("#archivo").prop("disabled",false) : $("#archivo").prop("disabled",true);
    });

    //*Habilita el botón de importar cuando se seleciona el archivo desde el que se va a importar la información
    $("#archivo").change((e) =>{
        $("#archivo").val() != null ? $("#btnReqImport").prop("disabled",false) : $("#btnReqImport").prop("disabled",true);
    });

    //* Realiza los cambios pertinentes al seleccionar el proyecto en el que se va a crear un nuevo lote.
    $("#proyecto").change( async function (e) {
        if($("#proyecto :selected").val() > 0){
            const pId = $("#proyecto :selected").val();
            $("#etapa").prop("hidden",false);
            $("#etapa").prop("disabled",false);
            $("#etapa").prop("readonly",false);
            $("#etapa  .removable").remove();
            $(".fillable").attr("disabled",true);
            axios.get("etapas/projectEtapas/"+pId).then((e) =>{
                const r = e.data.data;
                for(let i = 0; i < r.length; i++){
                    // let option = `<option value="${r[i].id}" class="removable">${r[i].etapa} ${r[i].e_name}</option>`
                    let option = `<option value="${r[i].e_name}" class="removable" data-id="${r[i].id}">${r[i].etapa} ${r[i].e_name}</option>`
                    $(option).appendTo($("#etapas"));
                    // let zId = r[i].id;
                    // $("#etapa").data("data-id",`${r[i].id}`);
                }
                $("#etapa option[value=0]").html("Seleccionar zona");
            }).catch((e) => {
                $("#etapa option[value=0]").html("Sin zonas registradas");
                console.log(e);
            });
        }else{
            $("#etapa option[value=0]").prop("selected",true);
            $("#etapa").prop("disabled",true);
            $(".fillable").attr("disabled",true);
            $(".fillable").val("");
            $("#modalTitle").html("Nuevo lote");
        }
    });//* Listo


    //* Realiza los cambios pertinentes al seleccionar la zona en la que se va a crear un nuevo lote.
    $("#etapa").change(function () {
        const pId = $("#proyecto :selected").val();

        // if($("#etapa :selected").val() == 0){
        if($("#etapa").val() == 0 || $("#etapa").val() === null){
            $(".fillable, #btnSave").attr("disabled",true);
            $("button.delPair").click();
        }else{
            // const eId = $("#etapa :selected").val();
            const eId = $(`#etapas option[value='${$("#etapa").val()}']`).data("id");
            $("#etapa").data("id",eId);
            axios.get("etapas/getInfo/"+eId).then((e) => {
                // console.log(e);
                const zone = e.data.data[0];
                // console.log(zone);
                $("#modalTitle").html(`Agregar nuevo lote a la zona ${zone.etapa} ${zone.e_name != '' ? '"'+zone.e_name+'"' : ''} del proyecto ${mainProjects.find((e) => e.id == pId).nombre}`)
                $(".fillable, #btnSave").attr("disabled",false);
                $(".fillable").attr("readonly",false);
                $(".row-head>div>button").click();
            }).catch((e) => {
                console.log(e);
                alert("Error en la consulta de la zona");
            });
        }
    });


    //* Estructura la clave del proyecto tras haber introducido el dato de la manzana en la que se va a crear.
    $("#manzana").change(() => {
        const pId = $("#proyecto :selected").val();
        const pClave = (mainProjects.find((e) => e.id == pId)).clave;
        const lClave = `L${$("#lote").val()}M${$("#manzana").val()}${pClave}`;
        $("#clave").val(lClave);
    });

    //* Agrega un par de inputs para definir clave y valor que se ha de agregar al array del input.
    $(document).on("click", ".addPair", function (e) {
        $(this).parent().parent().parent().append(pairCont);
        if($(this).hasClass("v")){
            $("#box-vertices .row-pair:last .val").prop("placeholder","Coordenadas decimales");
            $("#box-vertices .row-pair:last .val").prop("pattern","^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6},\s?-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/");
            $("#box-vertices .row-pair:last .val").prop("title","Ejemplo: 80.000000, 100.000000");
            $("#box-vertices .row-pair:last .val").addClass("geo");
        }else if($(this).hasClass("m")){
            $("#box-medidas .row-pair:last .val").prop("placeholder","Metros");
        }else{
            $("#box-colindancias .row-pair:last .val").prop("placeholder","Calle, lote, domicilio...");
        }
    });

    //* Remueve el contenedor del para de inputs clave/valor correspondiente al botón que se clickea.
    $(document).on("click",".delPair",function (e) {
        $(this).parent().parent().remove();
    });

    //* Abre el modal de búsqueda de enajenantes.
    $(document).on("click", ".callSearch", function (e) {
        e.preventDefault();
        const peer = $(this).hasClass("clientes") ? "clientes" : "vendedores";
        $("#searchPeerModal").modal("show");
        $("#search").val('');
        $("#searchModalTitle").html(`Buscar en ${peer}`);
        $("#search").prop("readonly",false);
        $("#searchModalTitle").removeClass("clientes");
        $("#searchModalTitle").removeClass("vendedores");
        $("#searchModalTitle").addClass(`${peer}`);
        if($("#table2>tbody>tr").length > 1){
        $("#table2>tbody>tr").remove();
        $("#table2>tbody").append(`<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>`);
        }
    });

    //* Realiza la búsqueda de enajenantes.
    $("#btnSearch").click(function (e) {
        e.preventDefault();
        let search=$("#search").val();
        if(search.length > 1) {
            let peer = $("#searchModalTitle").hasClass("clientes") ? "clientes" : "vendedores";
            const dt= $("#table2").DataTable()
            dt.clear().draw();
            axios.post(`${peer}/search/`,search,{headers: { 'Content-Type': 'application/son','X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}}).then((e) => {
                const results = e.data;
                $("#searchResults").empty();
                results.forEach(function (result,i) {
                    const btn = `
                        <div class="d-flex">
                            <button type="button" class="btn btn-success btn-sm btnSelectC" data-rid="${result.id}" data-rname="${result.nombre}">Seleccionar</button>
                        </div>`;
                    dt.row.add([result.id,result.nombre,btn]).draw();
                });
            }).catch((e) => {
                console.log(e);
            });
        }
    });//* Listo

    //* Selecciona un enajenante de entre los obtenidos en la búsqueda.
    $(document).on("click",".btnSelectC",function (e) {
        let peer = $("#searchModalTitle").hasClass("clientes") ? "comprador" : "vendedor";
        $(`#${peer}_id`).val($(e.target).data("rid"));
        $(`#${peer}`).val($(e.target).data("rname"));
        if($(`#${peer}_id`).hasClass("watch")) {$(`#${peer}_id`).addClass("update")}
        if($(`#${peer}`).hasClass("watch")) {$(`#${peer}`).addClass("update")}
        $("#searchPeerModal").modal("hide");
    });//* Listo

    //* Realiza la consolidación de nuevos lotes en la base de datos.
    $("#btnSave").click(async function (e) {
        packJson("specs");
        packJson("vertices");
        packJson("medidas");
        packJson("colindancias");
        $(".row-pair").remove();
        let data = await packFormData();
        // console.log(...data);
        data.delete("id");
        data.delete("clave");
        data.delete("compradorName");
        data.delete("vendedorName");
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        data.append("_token",'{{ csrf_token() }}');
        // console.log(...data);
        $("#btnSave").prop("disabled", true);
        axios.post("",data).then((e) => {
            const dt = $(".table").DataTable();
            const r = e.data.data;
            // console.log(r);
            const lote = r.lote;
            console.log(lote);
            let specs = r.specs ? r.specs : '';
            // console.log(specs);
            console.log(`length = ${specs.length}`);
            if (specs) {
                const specIdCont = `<input readonly type="hidden" name="spec_id" id="" class="specIdCont editable">`;

                for ( let i = 0; i < specs.length; i++) {
                    let s = specs[i];
                    console.log(s);
                    console.log(` i = ${i}`)
                    $("#box-specs").append(pairCont);
                    $(`#box-specs :last-Child`).find('.key').val(s.nombre);
                    $(`#box-specs :last-Child`).find('.val').val(s.valor);
                    $(`#box-specs .row-pair`).last().append(specIdCont);
                    $(`#box-specs .row-pair .specIdCont`).last().val(s.id);
                }
            }
            const v = JSON.parse(lote.vertices);
            console.log(v);
            const m = JSON.parse(lote.medidas);
            console.log(m);
            const c = JSON.parse(lote.colindancias);
            console.log(c);
            // loadData(s,"specs");
            loadData(v,"vertices");
            loadData(m,"medidas");
            loadData(c,"colindancias");
            let clave = `L${lote.lote}M${lote.manzana}${lote.proyecto.clave}`;
            let actions = `<div class="d-flex">
                <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editLote(${lote.id},this)">Editar</button>
                <button type"button" class="btn btn-danger btn-sm fw-bold" onclick="deleteLote(${lote.id},this)">Eliminar</button>
                </div>`;
            dt.row.add([
                `<div style="font-size: small;">${lote.id}</div>`,
                `<div class="text-center"><div style="font-size: small;" class="btn btn-primary btn-sm" onclick="ver(${lote.id},this)"><em>${clave}</em></div></div>`,
                `<div style="font-size: small;">${lote.proyecto.nombre}</div>`,
                `<div style="font-size: small;">${lote.etapa.etapa} ${lote.etapa.e_name}</div>`,
                `<div class="text-center" style="font-size: small;">${lote.manzana}</div>`,
                `<div class="text-center" style="font-size: small;">${lote.lote}</div>`,
                `<div class="text-end" style="font-size:small;">${lote.superficie} m<sup>2</sup></div>`,
                `<div style="font-size: small;">${loteStatus[lote.estado]}</div>`,
                actions
            ]).draw();
            mainData.push(e.data.data.lote);
            $("#modalTitle").html(`Vista del lote ${clave}`);
            $("#id").val(lote.id);
            setOnStore();
        }).catch((e) => {
            console.log(e);
        });
    });

    //* Borra el registro del lote correspondiente de la base de datos.
    $("#btnDelete").click(() => {
        deleteLote($("#id").val());
        $("#modalDelete").addClass("close");
    });//* Listo

    //* Habilita la edición de la información del lote que se muestra en ese mmomento en el modal.
    $("#btnVerEditar").click( function (e) {
        const lote = findLote($("#id").val());
        if(lote == undefined){return}
        setToEdit(lote);
        $(`td.id:contains(${$("#id").val()})`).parent('tr').addClass(`update-${$("#id").val()}`);
    });//* Listo

    //* Flagea los inputs en los que se ha hecho alguna modificación del lote correspondiente.
    $(document).on("change", ".watch", function () {
        if (!$(this).hasClass("update")) {
            $(this).addClass("update");
        }
    });//* Listo

    //* Consolida los datos de la información del lote en la B de DD
    $("#btnSaveChanges").click(async function (e) {
        if($(".update").length > 0) {
            $("select").prop("disabled",false);
            packJson("vertices");
            packJson("medidas");
            packJson("colindancias");
            $(".row-pair").remove();
            let data = await packFormData();
            console.log(...data);
            data.delete("clave");
            data.delete("compradorName");
            data.delete("vendedorName");
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            data.append("_token",csrfToken);
            data.append("_method","PUT");
            console.log(...data);
            const id = $("#id").val();
            axios.post("lotes/"+id,data).then((e) => {
                const dt = $(".table").DataTable();
                const r = e.data.data;
                console.log(r);
                const v = JSON.parse(r.vertices);
                const m = JSON.parse(r.medidas);
                const c = JSON.parse(r.colindancias);
                loadData(v,"vertices");
                loadData(m,"medidas");
                loadData(c,"colindancias");
                let clave = `L${r.lote}M${r.manzana}${r.proyecto.clave}`;
                let btnSee = `<div class="dflex"><button type="button" onclick="ver(${r.id},this)" class="btn btn-primary btn-sm">${clave}</button></div>`;
                let actions = `<div class="d-flex">
                    <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editLote(${r.id},this)">Editar</button>
                    <button type"button" class="btn btn-danger btn-sm fw-bold" onclick="deleteLote(${r.id},this)">Eliminar</button>
                    </div>`;
                dt.row($('.update-'+id)).data([
                `<div style="font-size: small;">${r.id}</div>`,
                    btnSee,
                    `<div style="font-size: small;">${r.proyecto.nombre}</div>`,
                    `<div style="font-size: small;">${r.etapa.etapa} ${r.etapa.e_name}</div>`,
                    `<div class="text-center" style="font-size: small;">${r.manzana}</div>`,
                    `<div class="text-center" style="font-size: small;">${r.lote}</div>`,
                    `<div class="text-center" style="text-size:small;">${r.superficie} m<sup>2</sup></div>`,
                    `<div style="font-size: small;">${loteStatus[r.estado]}</div>`,
                    actions
                ]).draw();
                $(".watch").removeClass("watch");
                $(`.update-${id}`).removeClass(`update-${id}`);
                $(":button.editable").prop("hidden",true);
                updateLote(r.id,r);
                setToSee(r);
            }).catch((e)=>{
                console.log(e);
            });
        }
    });

    //* Cierra el modal y descarta los cambios que no se hayan guardado.
    $("#btnDismiss").click(function () {
        $(`tr.update-${$("#id").val()}`).removeClass(`update-${$("#id").val()}`);
        $("#mainModal").modal("hide");
    });

    //* Cancela la solicitud de eliminar el registro del lote.
    $("#btnCancelDelete").click(function () {
        const id = $("#modalDelete").data("id");
        $(`tr.remove-${id}`).removeClass(`remove-${id}`);
        $("#mainModal").modal("hide");
        $("#modalDelete").modal("hide");
    });

    //* Elimina el registro del lote correspondiente de manera definitiva.
    $("#btnConfirmDelete").click(function (e) {
        const id = $("#modalDelete").data("id");
        axios.delete("lotes/"+id).then( (e) => {
            $("#modalDelete").modal("hide");
            $("#modalDelete").data("id","");
            const dt = $(".table").DataTable();
            dt.rows('.remove-'+id).remove().draw();
        }).catch( (e) => {
            cosole.log(e);
        });
        if($("#modalDelete").hasClass("close")){
            $("#modalDelete").removeClass("close");
            $("#mainModal").modal("hide");
        }
    });

</script>
<script type="module">
    //* Empaquetado del selectSearch
    // $(document).ready(() =>{
    //     const container = $(".selectSearch-container");
    //     const searchBar = `<input type="text" name="" id="" placeholder="Buscar" class="form-control selectSearch-bar">`;
    //     $(container).each(function(){
    //         let select = $(this).find("select");
    //         let selectId = $(select).attr("id");
    //         $(searchBar).prependTo(select);
    //         let sBar = $(this).find(":text");
    //         $(sBar).attr("id", `${selectId}-sBar`);
    //         $(sBar).attr("name", `${selectId}-sBar`);
    //     })
    // });

    // //*Habilita la escritura en el input de texto
    // $(".selectSearch-trigger").on("change", function() {
    //     if($(this,'option[value="0"]').prop("selected",false)) {
    //         $(".selectSearch-bar").attr("readonly",false);
    //     }else {
    //       $(".selectSearch-bar").attr("readonly",true);
    //     }
    // });

    // $(".selectSearch-container").on("change", function() {
    //     console.log("Cambio detectado");
    // })
</script>

@endsection
