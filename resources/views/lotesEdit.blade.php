@extends('layouts.app')

@section('content')
<div class="container-fluid"> <!-- Contenedor general -->
    <h1 id="viewProject" class="fw-bold">Proyecto {{ $lote->proyecto->nombre }}</h1>
    <h1 id="viewLote" class="fw-bold">Lote {{$lote->lote }}, manzana {{ $lote->manzana }}</h1>
    <div id="general-info" class="container-fluid"> <!-- Contenedor de la información general del lote -->
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold mt-2 mb-0">Información general del lote</h4>
            </div>
            {{-- <div class="col-6">
                <button id="btnLoad" class="btn btn-primary">Cargar imagen</button>
            </div> --}}
        </div>
        <div id="lote-generals" class="container-fluid">
            <form action="" id="loteForm">
                <div class="row" id="row-lote">
                    <div class="row pe-0 me-0 mb-2"> <!--Id, clave y estado-->
                        <div class="col-2 col-md-2 ps-0 pe-2 ">
                            <label for="id" class="fw-bold">Id</label>
                            <input readonly type="number" name="id" id="id" class="form-control  form-control-sm reset " value="{{ $lote->id }}">
                        </div>
                        <div class="col-3 ps-0 pe-2">
                            <label for="clave" class="fw-bold">Clave</label>
                            <input readonly type="text" name="clave" id="clave" class="form-control form-control-sm reset " placeholder="Autogenerado" value="{{ "L" . $lote->lote . "M" . $lote->manzana . $lote->proyecto->clave }}">
                        </div>
                        <div class="col-7 ps-0 pe-2">
                            <label for="estado" class="fw-bold">Estado</label><br/>
                            <select name="estado" id="estado" class="form-select form-select-sm reset fillable">
                                <option value="0" {{ $lote->estado == 0 ? 'selected' : '' }}>No disponible</option>
                                <option value="1" {{ $lote->estado == 1 ? 'selected' : '' }}>Disponible</option>
                                <option value="2" {{ $lote->estado == 2 ? 'selected' : '' }}>Apartado</option>
                                <option value="3" {{ $lote->estado == 3 ? 'selected' : '' }}>Vendido al contado</option>
                                <option value="4" {{ $lote->estado == 4 ? 'selected' : '' }}>Vendido a crédito</option>
                                <option value="5" {{ $lote->estado == 5 ? 'selected' : '' }}>Liquidado</option>
                                <option value="6" {{ $lote->estado == 6 ? 'selected' : '' }}>En recuperación</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pe-0 me-0 mb-2"> <!--Proyecto y etapa -->
                        <div class="col-lg-6 ps-0 pe-2">
                            <label for="proyecto_id" class="fw-bold" value="{{ $lote->proyecto->id }}">Pertenece al proyecto:</label>
                            <select name="proyecto_id" id="proyecto" class="form-select form-select-sm reset selectSearch-trigger">
                                <option value="0">Seleccionar proyecto</option>
                                <option value="{{ $lote->proyecto->nombre }}" selected class="removable" data-id="{{ $lote->proyecto->id }}">{{ $lote->proyecto->nombre }}</option>
                            </select>
                        </div>
                        <div class="col-lg-6 ps-0 pe-2 selectSearch-container">
                            <label for="etapa_id" class="fw-bold">Zona:</label>
                            <input type="text" list="etapas" name="etapa_id" id="etapa" class="form-control form-control-sm d-List" placeholder="Buscar zona" value="{{ $lote->etapa->e_name }}" data-id="{{ $lote->etapa->id }}">
                            <datalist id="etapas">
                                <option value="Seleccionar zona">Seleccionar zona</option>
                                <option selected value="{{ $lote->etapa->e_name }}">Seleccionar zona</option>
                            </datalist>
                        </div>
                    </div>
                    <div class="row pe-0 mb-2"><!--Lote, manzana, superficie y ubicación-->
                        <div class="col-6 col-md-3 px-0">
                            <label for="lote" class="fw-bold">Lote</label>
                            <input type="number" name="lote" id="lote" class="form-control form-control-sm reset fillable editable" placeholder="Lote No." value="{{ $lote->lote }}">
                        </div>
                        <div class="col-6 col-md-3 px-1">
                            <label for="manzana" class="fw-bold">Manzana</label>
                            <input type="number" name="manzana" id="manzana" class="form-control form-control-sm reset fillable editable" placeholder="Manzana No." value="{{ $lote->manzana }}">
                        </div>
                        <div class="col-6 col-md-3 ps-0 pe-1">
                            <label for="superficie" class="fw-bold">Superficie</label>
                            <input type="number" name="superficie" id="Superficie" placeholder="m2"  class="form-control form-control-sm reset fillable editable" value="{{ isset($lote->superficie) ? $lote->superficie : '' ; }}">
                        </div>
                        <div class="col-6 col-md-3 ps-0 pe-2">
                            <label for="ubicacion" class="fw-bold">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" pattern="^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6},\s?-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000" class="form-control form-control-sm reset fillable editable geo" value="{{ isset($lote->ubicacion) ? $lote->ubicacion : '' ; }}">
                        </div>
                    </div>
                    <div class="row pe-0 me-0 mb-1"> <!--Vertices, medidas y colindancias-->
                        <div class="col-xl-3 col-lg-6 col-sm-12 ps-0 pe-1 mb-2"><!--Vertices-->
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
                                @if(isset( $lote->vertices ))
                                    @php
                                        $v = json_decode( $lote->vertices );
                                    @endphp
                                    @foreach ($v as $key => $value)
                                        <div class="row ms-0 ps-0 mb-1 row-pair">
                                            <div class="col-4 ps-0 pe-1">
                                                <input type="text" name="clave" id="" class="form-control form-control-sm key" value="{{ $key }}">
                                            </div>
                                            <div class="col-7 ps-0 pe-1">
                                                <input type="text" name="valor" id="" class="form-control form-control-sm val" value="{{ $value }}">
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" title="Borrar esta entrada" class="btn btn-secondary btn-sm fw-bold py-0 delPair">-</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-sm-12 ps-0 pe-1 mb-2"><!--Medidas-->
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
                                @if(isset( $lote->medidas ))
                                    @php
                                    $m = json_decode( $lote->medidas );
                                    @endphp
                                    @foreach ( $m as $key => $value )
                                        <div class="row ms-0 ps-0 mb-1 row-pair">
                                            <div class="col-4 ps-0 pe-1">
                                                <input type="text" name="clave" id="" class="form-control form-control-sm key" value="{{ $key }}">
                                            </div>
                                            <div class="col-7 ps-0 pe-1">
                                                <input type="text" name="valor" id="" class="form-control form-control-sm val"value="{{ $value }}">
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" title="Borrar esta entrada" class="btn btn-secondary btn-sm fw-bold py-0 delPair">-</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
                                @if(isset( $lote->colindancias ))
                                    @php
                                        $c = json_decode( $lote->colindancias );
                                    @endphp
                                    @foreach ( $c as $key => $value )
                                        <div class="row ms-0 ps-0 mb-1 row-pair">
                                            <div class="col-4 ps-0 pe-1">
                                                <input type="text" name="clave" id="" class="form-control form-control-sm key" value="{{ $key }}">
                                            </div>
                                            <div class="col-7 ps-0 pe-1">
                                                <input type="text" name="valor" id="" class="form-control form-control-sm val" value="{{ $value }}">
                                            </div>
                                            <div class="col-1 px-0 text-center">
                                                <button type="button" title="Borrar esta entrada" class="btn btn-secondary btn-sm fw-bold py-0 delPair">-</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row pe-0 me-0 mb-1 editable"> <!--Comprador y vendedor -->
                        <div class="col-6 ps-0 pe-2">
                            <label for="comprador_id" class="fw-bold">Comprador</label>
                            <button id="btnSearchClient" class="btn btn-primary btn-sm ms-2 mb-1 fw-bold callSearch editable clientes">Buscar</button>
                            <input readonly type="hidden" name="comprador_id" id="comprador_id" class="editable" value="{{ $lote->comprador_id }}">
                            <input readonly type="text" name="compradorName" id="comprador" placeholder="No proporcionado" class="form-control reset editable" value="{{ isset($comprador) ? $comprador->nombre : ''; }}">
                        </div>
                        <div class="col-6 ps-0 pe-2">
                            <label for="vendedor_id" class="fw-bold">Vendedor</label>
                            <button id="btnSearchSeller" class="btn btn-primary btn-sm ms-2 mb-1 fw-bold callSearch editable">Buscar</button>
                            <input readonly type="hidden" name="vendedor_id" id="vendedor_id" class="editable" value="{{ $lote->vendedor_id}}">
                            <input readonly type="text" name="vendedorName" id="vendedor" placeholder="No proporcionado" class="form-control reset editable" value="{{ isset($vendedor) ? $vendedor->nombre : '' ; }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="lote-controls" class="container-fluid mt-3"> <!-- Controles de la información general del lote -->
            {{-- <button type="button" id="btnEditData"  hidden title="Editar datos del lote" class="btn btn-warning btn-sm fw-bold see">Editar datos del lote</button>
            <button type="button" id="btnDismiss" title="Los cambios no guardados del lote se eliminarán." class="btn btn-danger editable">Descartar cambios</button>
            <button type="button" id="btnSaveChanges" title="Guardar cambios a la información del lote." class="btn btn-success editable" >Guardar cambios</button> --}}
        </div>
    </div>

    <div id="aditional-info"" class="container-fluid mt-3"> <!-- Contenedor de la descripción y características -->
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold mt-2 mb-0">Información adicional</h4>
            </div>
            {{-- <div class="col-6">
                <button id="btnLoad" class="btn btn-primary">Cargar imagen</button>
            </div> --}}
        </div>
        <div id="desc-n-specs" class="container-fluid">
            <div class="row">
                <div class="col-6 col-xs-12"> <!-- Descripción del lote -->
                    <label for="descripcion" class=" form-label fw-bold">Descripción del lote:</label>
                    <textarea readonly name="descripcion" id="descripcion" class="form-control reset fillable editable" rows="3" placeholder="Datos que ayuden a identificar mejor el lote o que resalten sus  características positivas.">{{ isset($lote->descripcion) ? $lote->descripcion : '' ; }}</textarea>
                </div>
                <div class="col-6 col-xs-12"> <!-- Características adicionales -->
                    <div class="row mx-0">
                        <label for="spec" class="form-label fw-bold">Características:</label>
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
                            <div class="col-1 px-0 py-0 text-center">
                                <button type="button" class="btn btn-primary btn-sm fw-bold py-0 fillable addPair s" title="Agregar una característica">+</button>
                            </div>
                        </div>
                        @if(isset($specs))
                            @php
                                $spec = json_decode($specs);
                            @endphp
                            @foreach ($spec as $s )
                            <div class="row ms-0 ps-0 mb-1 row-pair">
                                <input readonly type="hidden" name="spec_id" id="" class="specIdCont editable" value="{{ $s->id }}">
                                <div class="col-4 ps-0 pe-1">
                                    <input type="text" name="clave" id="" class="form-control form-control-sm key" value="{{ $s->nombre }}">
                                </div>
                                <div class="col-7 ps-0 pe-1">
                                    <input type="text" name="valor" id="" class="form-control form-control-sm val" value="{{ $s->valor }}">
                                </div>
                                <div class="col-1 px-0 text-center">
                                    <button type="button" title="Borrar esta entrada" class="btn btn-secondary btn-sm fw-bold py-0 delPair">-</button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="aditional-controls" class="container-fluid mt-3 text-end">
            <button type="button" id="btnEditExtra" title="Editar información adicional del lote" class="btn btn-primary btn-sm  see">Editar información adicional</button>
            <button type="button" id="btnDismissExtra" title="Los cambios no guardados se eliminarán." class="btn btn-secondary btn-sm editable">Descartar cambios</button>
            <button type="button" id="btnSaveExtra" title="Guardar cambios a la información adicional del lote." class="btn btn-primary btn-sm editable" >Guardar cambios</button>
        </div>
    </div>
    <div id="picsContainer" class="containerfluid mt-3"><!-- Contenedor de la sección de  fotos del lote -->
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold mt-2 mb-0">Imágenes del lote</h4>
            </div>
            <div class="col-6 text-end">
                <button id="btnLoad" class="btn btn-primary btn-sm">Cargar imagen</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <table id="mainTable" class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Título</th>
                            <th scope="col">Texto alterno</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Modal de carga de imágenes-->
<div id="loadModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document" aria-hidden="true" style="max-width:50% !important">
        <div class="modal-content">
            <div class="modal-header sticky-top bg-light">
                <h5 id="modalTittle" class="modal-tittle fw-bold">
                    Carga de imágenes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button:button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
            <div class="modal-body container-fluid">
                <div class="row">
                    <input type="hidden" id="loteId" name="lote_id" value="{{ $lote->id }}">
                    <div class="row">
                        <div class="row text-center">
                            <img src="" alt="Seleccionar archivo" id="imgLoading" class="img-fluid">
                        </div>
                        <div class="row">
                            <div class="col-8 pt-2">
                                <input type="file" name="image" id="imageInput" class="form-control" placeholder="Imagen por subir">
                            </div>
                            <div class="col-4">
                                <button id="btnDelImage" class="btn btn-danger btn-sm float-end my-2" title="Borra la imagen para su reemplazo.">Eliminar imagen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="titulo" class="fw-bold">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo o pequeña descripción de la imagen.">
                </div>
                <div class="row">
                    <label for="alt" class="fw-bold">Texto alterno</label>
                    <input type="text" name="alt" id="alt" class="form-control" placeholder="Texto que reemplaza a la imagen.">
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnDelete" class="btn btn-danger btn-sm" type="button" title="Elimina la imagen y su información.">Eliminiar</button>
                <button id="btnCancel" class="btn btn-secondary btn-sm" type="button" title="Cierra la ventana sin guardar los cambios al texto que acompaña a la imagen">Descartar información</button>
                <button id="btnAddData" type="button" class="btn btn-primary btn-sm" title="Guarda los cambios hechos a la información de la imagen.">Guardar cambios</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal borrar -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteTitle">Borrar imagen</h5>
                <button type="button" class="btn-close"data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="fotoId" name="fotoId" value="">
                ¿Está seguro de que desea eliminar esta imagen?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelDelete">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

    <script>

        const loteData = {{ Js::from($lote) }};
        const lId = loteData.id;
        const pId = loteData.proyecto_id;
        const eId = loteData.etapa_id;
        const pClave = loteData.proyecto.clave;
        // const dt= $("#mainTable").DataTable();

        let mainTable = $("#mainTable").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('fotos_lotes/tabla') }}",
                "type": "GET",
                // "data": "lote_id" = lId,
                "data": function (d) {
                    d.lote_id = lId;
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "imagen", "orderable": false, "searchable": true },
                { "data": "titulo" },
                { "data": "alt" },
                { "data": "acciones", "orderable": false, "searchable": false }
            ]
        });

        const pairCont =
            `<div class="row ms-0 ps-0 mb-1 row-pair">
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

        const loadData = (json,target) => {
            $.each(json, function(key,value) {
                $(`#box-${target}`).append(pairCont);
                $(`#box-${target} :last-Child`).find('.key').val(key);
                $(`#box-${target} :last-Child`).find('.val').val(value);
            });
        };

        const setClave = () => {
            const pId = $("#proyecto :selected").val();
            const lClave = `L${$("#lote").val()}M${$("#manzana").val()}${pClave}`;
            $("#clave").val(lClave);
        };

        const setToSee = () => {
            $(":button.see").prop("hidden",false);
            $(":button.callSearch").prop("hidden",true);
            $(":button.editable").prop("hidden",true);
            $("select").prop("disabled",true);
            $(":text, input[type='number']").prop("readonly",true);
            $(".addPair, .delPair").prop("hidden",true);
        };


        $("#btnEditData").click( function (e) {
            $("button.see").prop("hidden",true);
            $(".editable, .key, .val").prop("readonly",false);
            $(".addPair, .delPair").prop("hidden",false);
            $("div.editable").prop("hidden",false);
            $("button.editable").prop("hidden",false);
            $("input.editable").addClass("watch");
            $("select.editable").prop("disabled",false);
            $("#viewTitle").html(`Edición del lote ${$("#lote").val()}, manzana ${$("#manzana").val()}, del proyecto ${$("#proyecto").val()}`);
        });//* Listo

     /*    $(document).on("click", ".addPair", function (e) {
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
        }); */

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
            $(`#box-${string} > .row-pair`).each((i,e)=>{
                pack[$(e).find(".key").val()] = $(e).find(".val").val();
            });
            $(`#${string}`).val(JSON.stringify(pack));
            return pack;
        };//*

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
                    const r = e.data.data;
                    console.log(r);
                    const v = JSON.parse(r.vertices);
                    const m = JSON.parse(r.medidas);
                    const c = JSON.parse(r.colindancias);
                    loadData(v,"vertices");
                    loadData(m,"medidas");
                    loadData(c,"colindancias");
                    $("#id").val(r.id);
                    $("#lote").val(r.lote);
                    $("#manzana").val(r.manzana);
                    $(`#estado option[value=${r.estado}]`).prop("selected",true);
                    $("#Superficie").val(r.superficie);
                    $("#ubicacion").val(r.ubicacion);
                    setClave();
                    if(r.comprador_id){
                        $("#comprador_id").val(r.comprador_id);
                        // $("#comprador").val(r.comprador.nombre);
                    }
                    if(r.vendedor_id) {
                        $("#vendedor_id").val(r.vendedor_id);
                        // $("#vendedor").val(r.vendedor.nombre);
                    }
                    $(`#proyecto option[data-id=${pId}]`).prop('selected',true);
                    axios.get("/etapas/projectEtapas/"+pId).then( (e) => {
                        const r = e.data.data;
                        for(let i = 0; i < r.length; i++){
                            let option = `<option value="${r[i].e_name}" class="removable" data-id="${r[i].id}">${r[i].etapa}</option>`
                            $(option).appendTo($("#etapas"));
                        }
                        $("#etapas option[value=0]").html("Seleccionar zona");
                        const etapaOption = $(`#etapas option[data-id=${eId}]`);
                        if (etapaOption.length > 0) {
                            $("#etapa").val(etapaOption.val());
                            $("#etapa").prop("data_id", etapaOption.data('id'));
                        }
                        let clave = `L${r.lote}M${r.manzana}${r.proyecto.clave}`;
                        $(".watch").removeClass("watch");
                        $(":button.editable").prop("hidden",true);
                        updateLote(r.id,r);
                        setToSee(r);
                    }).catch((e)=>{
                        console.log(e);
                    });
                });
            };if($(".update").length > 0) {
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
                    const r = e.data.data;
                    console.log(r);
                    const v = JSON.parse(r.vertices);
                    const m = JSON.parse(r.medidas);
                    const c = JSON.parse(r.colindancias);
                    loadData(v,"vertices");
                    loadData(m,"medidas");
                    loadData(c,"colindancias");
                    $("#id").val(r.id);
                    $("#lote").val(r.lote);
                    $("#manzana").val(r.manzana);
                    $(`#estado option[value=${r.estado}]`).prop("selected",true);
                    $("#Superficie").val(r.superficie);
                    $("#ubicacion").val(r.ubicacion);
                    setClave();
                    if(r.comprador_id){
                        $("#comprador_id").val(r.comprador_id);
                        // $("#comprador").val(r.comprador.nombre);
                    }
                    if(r.vendedor_id) {
                        $("#vendedor_id").val(r.vendedor_id);
                        // $("#vendedor").val(r.vendedor.nombre);
                    }
                    $(`#proyecto option[data-id=${pId}]`).prop('selected',true);
                    axios.get("/etapas/projectEtapas/"+pId).then( (e) => {
                        const r = e.data.data;
                        for(let i = 0; i < r.length; i++){
                            let option = `<option value="${r[i].e_name}" class="removable" data-id="${r[i].id}">${r[i].etapa}</option>`
                            $(option).appendTo($("#etapas"));
                        }
                        $("#etapas option[value=0]").html("Seleccionar zona");
                        const etapaOption = $(`#etapas option[data-id=${eId}]`);
                        if (etapaOption.length > 0) {
                            $("#etapa").val(etapaOption.val());
                            $("#etapa").prop("data_id", etapaOption.data('id'));
                        }
                        let clave = `L${r.lote}M${r.manzana}${r.proyecto.clave}`;
                        $(".watch").removeClass("watch");
                        $(":button.editable").prop("hidden",true);
                        updateLote(r.id,r);
                        setToSee(r);
                    }).catch((e)=>{
                        console.log(e);
                    });
                });
            };
        });

        $("#btnDelImage").click(function (e) {
            $("#imgLoading").prop("hidden",true);
            $("#btnDelImage").prop("hidden",true);
            $("#imageInput").prop("hidden",false);
            $("#delImage").val(true);
        });

        const editFoto = (id,el) => {
            const row = $(`td:contains(${id})`).parent('tr');
            let rowData = {}
            rowData.id = $(row).find('td').eq(0).text();
            rowData.titulo = $(row).find('td').eq(2).text();
            rowData.alt = $(row).find('td').eq(3).text();
            let source = $(`td:contains(${id})`).parent('tr').find('img').attr('src');
            $("#loadModal").modal("show");
            $("#fotoId").val(id);
            $("#imgLoading").prop("hidden",false);
            $("#imgLoading").attr("src",source);
            $("#imgLoading").show();
            $("#titulo,#alt").prop("readonly",false);
            $("#titulo").val(rowData.titulo);
            $("#alt").val(rowData.alt);
            $("#btnDelImage").prop("hidden",false);
            $("#btnDismiss").prop("disabled",false);
            $("#imageInput").prop("hidden",true);
            $(`td:contains(${id})`).parent('tr').addClass(`update-${id}`);
        }

    //* Abre el modal para confirmar la eliminación del registro en la base de datos
        const deleteFoto = (id) => {
            let fotoId = id;
            $("#modalDelete").modal("show");
            $("#fotoId").val(id);
        }

    </script>

    <script>
        let originalDescripcion;
        let originalSpecs = [];

        $(document).ready(function () {
            setToSee();
            $(".dt-input").prop("disabled", false);
        });

        // Setea los cambios pertinentes para editar la descripción y las características del lote.
        $("#btnEditExtra").click(function (e) {
            //* Habilitar la edición de los inputs ya preexistentes
            $("#aditional-info .editable, .key, .val").prop("readonly",false);
            //* Almacena la información de #descripción y los specs cargados con la view
            originalDescripcion = $("#descripcion").val();
            let specs = $("#box-specs .row-pair");
            for ( let i = 0; i < specs.length; i++ ) {
                let spec = {};
                spec["id"] = $(specs[i]).find(":hidden").val();
                spec["key"] = $(specs[i]).find(".key").val();
                spec["val"] = $(specs[i]).find(".val").val();
                originalSpecs.push(spec);
            }
            //*Flaguear #descripción y los specs ya cargados
            $("#descripcion").addClass("watch");
            $("#box-specs .row-pair").addClass("watchU");
            $("#box-specs").find(".key").addClass("watchU");
            $("#box-specs").find(".val").addClass("watchU");
            //Esconder #btnEditExtra
            $("#btnEditExtra").prop("hidden",true);
            //* Mostrar los botones funcionales a la edición.
            $("#aditional-info .btn.editable").prop("hidden",false);
            $("#aditional-info .delPair").prop("hidden",false);
            $("#aditional-info .addPair").prop("hidden",false);

        });

        //Agrega pares de inputs a #box-specs
        $("#box-specs .addPair").on("click", function (e) {
            $(this).parent().parent().parent().append(pairCont);
            $("#box-specs .row-pair").last().addClass("watchC");
            $("#box-specs .row-pair").last().find(".key").addClass("watchC");
            $("#box-specs .row-pair").last().find(".val").addClass("watchC");
        });

        //Al cambiar los datos, flaguea los inputs de los specs preexistentes para hacer la modificación en la base de datos al guardar.
        $("#box-specs").on("input",".row-pair .watchU",function (e) {
            let row = $(this).closest(".row-pair");
            if ( !$(row).hasClass("update") ) {
                $(row).addClass("update");
            }
        });

        //Flaguea los inputs de nuevos specs para almacenarlos en la base de datos solo si se ha incluido el nombre del dato.
        $("#box-specs").on("input",".row-pair .watchC",function (e) {
            let row = $(this).closest(".row-pair");
            if( $(this).hasClass("key") && !$(row).hasClass("create") )
            $(row).addClass("create");
        });

        //Flaguea #descripcion si se ha hecho algún cambio para hacer la consolidación correspondiente.
        $(document).on('input',"#descripcion",function (e) {
            $("#descripcion").hasClass('watch') ? $("#descripcion").addClass('update') : '' ;
        })

        //Esconde los pares de los specs preexistentes y los flaguea para eliminarlos de la base de datos; y elimina los de los nuevos.
        $("#box-specs").on("click",".row-pair .delPair", function (e) {
            let rowPair = $(this).closest('.row-pair');
            if( $(rowPair).hasClass('watchU') ) {
                $(rowPair).prop('hidden',true);
                $(rowPair).removeClass("update");
                $(rowPair).removeClass("watchU");
                $(rowPair).addClass("delete");
            } else {
                $(rowPair).remove();
            }
        });

        //Flaguea #descripcion si se realiza algún cambio para modificar la entrada en la base de datos.
        $("#descripcion").on("change", function (e) {
           $("#descripcion").addClass('update');
        });

        //Devuelve los #descripción y #box-specs al estado previo a presionar #btnEditExtra
        $("#btnDismissExtra").on("click",function (e) {
            //*Quitar los flags 'watch' y 'update' a #descripcion.
            $("#descripcion").removeClass('watch');
            $("#descripcion").removeClass('update');
            //Mostrar nuevamente el texto anterior en #descripcion.
            $("#descripcion").html(originalDescripcion);
            //Hacer readonly a #descripcion.
            $("#descripcion").prop("readonly",true);
            //Quitar todos los pares de datos.
            $("#box-specs .row-pair").remove();
            //Cargar nuevamente los specs en el #box-specs
            for ( let i = 0; i < originalSpecs.length; i++ ) {
                let spec = originalSpecs[i];
                $("#box-specs").append(pairCont);
                let row = $("#box-specs .row-pair").last();
                let hidden = `<input readonly type="hidden" name="spec_id" id="" class="specIdCont editable">`;
                $(row).prepend(hidden);
                $(row).find(":hidden").val(`${spec.id}`);
                $(row).find(".key").val(`${spec.key}`);
                $(row).find(".val").val(`${spec.val}`);
                $(row).find(".key").prop("readonly",true);
                $(row).find(".val").prop("readonly",true);
            }
            //Mostrar #btnEditExtra
            $("#btnEditExtra").prop("hidden",false);
            //* Esconder los botones funcionales a la edición.
            $("#aditional-info .btn.editable").prop("hidden",true);
            $("#aditional-info .delPair").prop("hidden",true);
            $("#aditional-info .addPair").prop("hidden",true);
        })

        //Guarda los cambios que se hallan hecho en #descripción y los specs y vuelve a cargar la información para mostrarlos como refresh
        $("#btnSaveExtra").on("click", async function (e) {
            //* Verificar si la descripción se debe actualizar y actualizarla
            let descriptionData;
            if ( $("#descripcion").hasClass("update") ) {
                descriptionData = $("#descripcion").val();
                axios.post("/lotes/description/"+id,descriptionData).then( (e) => {
                    const r = e.data.data
                    $("#descripcion").val(`${r.descripcion}`);
                }).catch( (e) => {
                    console.log(e);
                });
            }

            let created = [];
            let updated = [];

            //* Verificar si hay specs para crear y crearlos
            let createSpecs = {};
            createSpecs.items = [];
            const createS = $(".row-pair.create");
            if (createS.length > 0 ) {
                for ( let i = 0; i < createS.length; i++ ) {
                    let create = {};
                    create.id_lote = $("#id").val();
                    create.nombre = $(createS[i]).find(".key").val();
                    create.valor = $(createS[i]).find(".val").val();
                    createSpecs.items.push(create);
                }
                createSpecs['_token'] = '{{ csrf_token() }}';
                await axios.post('/lotes/createSpecs',createSpecs).then( (e) => {
                    const r = e.data.data;
                    created['items'] = r;
                }).catch( (e) => {
                    console.log(e);
                });
            }
            //* Verificar si hay specs para actualizar y actualizarlos
            let updateSpecs = {};
            updateSpecs.items = [];
            const updateS = $(".row-pair.update");
            if ( updateS.length > 0 ) {
                for ( let i = 0; i < updateS.length; i++ ) {
                    let update = {};
                    update.id = $(updateS[i]).find(":hidden").val();
                    update.id_lote = $(id).val();
                    update.nombre = $(updateS[i]).find(".key").val();
                    update.valor = $(updateS[i]).find(".val").val();
                    updateSpecs.items.push(update);
                }
                updateSpecs['_token'] = '{{ csrf_token() }}';
                await axios.post('/lotes/updateSpecs',updateSpecs).then( (e) => {
                    const r = e.data.data;
                    updated['items'] = r;
                }).catch( (e) => {
                    console.log(e);
                });
            }
            //* Verificar si hay specs para eliminar y eliminarlos
            let deleteSpecs = {};
            deleteSpecs.items = [];
            const deleteS = $(".row-pair.delete");
            if ( deleteS.length > 0 ) {
                for ( let i = 0; i < deleteS.length; i++ ) {
                    let item = {};
                    item['id'] = $(deleteS[i]).find(":hidden").val();
                    deleteSpecs.items.push(item);
                }
                deleteSpecs['_token'] = '{{ csrf_token() }}';
                deleteSpecs['_method'] = 'DELETE';
                await axios.post('/lotes/deleteSpecs', deleteSpecs).then( (e) => {
                }).catch( (e) => {
                    console.log(e);
                });
            }
            //* Eliminar en la view los specs eliminados.
            if( deleteSpecs.items.length > 0 ) {
                $("#box-specs .row-pair.delete").remove();
            }
            //* Actualizar en la view los specs modificados.
            if(updated.items.length > 0) {
                for ( let i = 0; i < updated.items.length; i++ ) {
                    let spec = updated.items[i];
                    const row = $("#box-specs .row-pair.update").filter( (i,e) => $(e).find(":hidden").val() == spec.id );
                    $(row).find(".key").val(spec.nombre);
                    $(row).find(".val").val(spec.valor);
                    $(row).find(".key").prop("readonly",true);
                    $(row).find(".val").prop("readonly",true);
                }
                $("#box-specs .row-pair.update").removeClass("update");
            }
            //* Insertar los specs creados en el #box-specs
            if(created.items.length > 0) {
                for ( let i = 0; i < created.items.length; i++ ) {
                    let spec = created.items[i];
                    $("#box-specs").append(pairCont);
                    let row = $("#box-specs .row-pair").last();
                    let hidden = `<input readonly type="hidden" name="spec_id" id="" class="specIdCont editable">`;
                    $(row).prepend(hidden);
                    $(row).find(":hidden").val(`${spec.id}`);
                    $(row).find(".key").val(spec.nombre);
                    $(row).find(".val").val(spec.valor);
                    $(row).find(".key").prop("readonly",true);
                    $(row).find(".val").prop("readonly",true);
                }
            }
            //Hacer readonly a #descripcion.
            $("#descripcion").prop("readonly",true);
            //* Quitar los flags 'watch' y 'update' a #descripcion.
            $("#descripcion").removeClass("watch");
            $("#descripcion").removeClass("update");
            //Mostrar #btnEditExtra
            $("#btnEditExtra").prop("hidden",false);
            //* Esconder los botones funcionales a la edición.
            $("#aditional-info .btn.editable").prop("hidden",true);
            $("#aditional-info .delPair").prop("hidden",true);
            $("#aditional-info .addPair").prop("hidden",true);
        });

        // Abre el modal para cargar imagenes al lote
        $("#btnLoad").click(function (e) {
            $("#loadModal").modal("show");
            $("#imgLoading").prop("hidden",true);
            $("#imageInput").prop("hidden",false);
            $("#imageInput").prop("required",true);
            $("#imageInput").prop("accept","image/*");
            $("#imageInput").val('');
            $("#btnDelImage").prop("hidden",true);
            $("#titulo").prop("readonly",false);
            $("#titulo").val('');
            $("#alt").prop("readonly",false);
            $("#alt").val('');
        });

        //* Genera el registro de la imagen en la base de datos al cargar una imagen en el input image. Si ya existe, modifica el registro. Altera la data de la tabla según el caso.
        $("#imageInput").on("input",function (e) {

            let id = $("#fotoId").val()
            let formData = new FormData();
            let loteId = $('#id').val();
            formData.append('id_lote', loteId);
            formData.append('image', e.target.files[0]);
            formData.append('titulo',`${$("#titulo").val()}`);
            formData.append('alt',`${$("#alt").val()}`);
            formData.append('_token', '{{ csrf_token() }}')
            // console.log(...formData);

            if ( id < 1 ) {
                $.ajax({
                    url: '{{ url("/fotos_lotes/") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let r = response.data;
                        console.log(r);
                        $("#fotoId").val(r.id);
                        $("#imgLoading").prop("hidden",false);
                        $("#imgLoading").attr("src", "/storage/"+r.ruta);
                        $("#imgLoading").show();
                        $("#imageInput").prop("hidden",true);
                        $("#btnDelImage").prop("hidden",false);
                        dt.ajax.reload();

                    },
                    error: function(response) {
                        alert("Error al cargar la imagen al servidor.");
                    }
                });
            } else {
                formData.append('id',id);
                formData.append('_method', 'PUT');
                $.ajax({
                    url: `{{ url("fotos_lotes/") }}/${id}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response)
                        let r = response.data;
                        $("#fotoId").val(r.id);
                        if(r.url) {
                            $("#imgLoading").attr("src", "/storage/"+r.url);
                            $("#imgLoading").show();
                        }
                        $("#titulo").val(r.titulo);
                        $("#alt").val(r.alt);
                        $("#imgLoading").show();
                        $("#imageInput").prop("hidden",true);
                        $("#btnDelImage").prop("hidden",false);
                        dt.ajax.reload();
                    },
                    error: function(response) {
                        alert("Error al cargar la imagen al servidor.");
                    }
                });
            }

        });
        // Cancela la actualización de datos de la foto, resetea los campos y cierra el modal.
        $("#btnCancel").click(function (e) {
            $("#fotoId").val('');
            $("#titulo").val('');
            $("#alt").val('');
            $("#imgLoading").prop("src",'');
            $("#imgLoading").hide();
            $("#imageInput").prop("hidden",false);
            $("#btnDelImage").prop("hidden",true);
            $("#loadModal").modal("hide");
        })

        // Guarda los datos adicionales de la foto en la base de datos. Es indispensable que la foto tenga un id.
        $("#btnAddData").click(function (e) {
            let id = $("#fotoId").val();

            let formData = new FormData();
            formData.append('id',id);
            formData.append('id_lote', $('#id').val());
            // formData.append('image', e.target.files[0]);
            formData.append('titulo',`${$("#titulo").val()}`);
            formData.append('alt',`${$("#alt").val()}`);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            if (id > 0) {
                $.ajax({
                url: `{{ url("fotos_lotes/") }}/${id}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response)

                    dt.ajax.reload();
                    $("#fotoId").val('');
                    $("#titulo").val('');
                    $("#alt").val('');
                    $("#imgLoading").prop("src",'');
                    $("#imgLoading").hide();
                    $("#imageInput").prop("hidden",false);
                    $("#btnDelImage").prop("hidden",true);
                    $("#loadModal").modal("hide");
                },
                error: function(response) {
                        alert("Error al actualizar los datos en el servidor")
                    }
                });
            } else {
                alert("No se ha cargado ninguna imagen.");
            }
        });

        // Vacía los campos del modal de carga de imágenes y lo cierra.
        $("#btnCancel").click(function (e) {
            $("#titulo,#alt").empty();
            $("#fotoId").val('');
            $("#imgLoading").attr("src",'');
            $("#btnDelImage").prop("hidden",true);
            $("#imageInput").prop("hidden",false);
            $("#delImage").val(false);
            $("#loadModal").modal("hide");
        });

        //* Abre el modal para confirmar la eliminación del registro en la base de datos
        $("#btnDelete").click(function (e) {
            let id = $("#fotoId").val();
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar imagen");
            $(`td.id:contains(${id})`).parent('tr').addClass(`remove-${id}`);
        });

         //* Cancela la solicitud de eliminar el registro del lote.
         $("#btnCancelDelete").click(function (e) {
            const id = $("#fotoId").val();
            if ( $(`.remove-${id}`).length > 0 ) {
                $(`.remove-${id}`).removeClass(`remove-${id}`);
            }
            $("#modalDelete").modal("hide");
        });

        //* Elimina el registro de la foto en la base de datos y reseta el modal de carga. Oculta ambos modales.
        $("#btnConfirmDelete").click(function (e) {
            const id = $("#fotoId").val();
            axios.delete("/fotos_lotes/"+id).then( (e) => {
                mainTable.ajax.reload();
                $("#fotoId").val("");
                $("#modalDelete").modal("hide");
                $("#titulo,#alt").empty();
                $("#fotoId").val('');
                $("#imgLoading").attr("src",'');
                $("#btnDelImage").prop("hidden",true);
                $("#imageInput").prop("hidden",false);
                $("#delImage").val(false);
                $("#loadModal").modal("hide");
            }).catch( (e) => {
                console.log(e);
            });
        });

    </script>

@endsection
