@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Pagos</h1>
                <div class=" d-flex gap-1">
                    <button class="btn btn-success fw-bold" id="addBtn" >Añadir</button>
                    <button class="btn btn-primary" id="addLote" >Apartar lote</button>
                    <button class="btn btn-primary fw-bold" id="btnImport" >Importar pagos</button>
                </div>

            </div>
            <div class="table-responsive">
                 <table id="firstTable" class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Total de pago</th>
                            <th scope="col">Referencia de pago</th>
                            <th scope="col">Concepto de pago</th>
                            <th scope="col">Tipo de pago</th>
                            <th scope="col">Fecha de Pago</th>
                            <th scope="col">Fechas</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                 </table>
            </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="#" id="formAdd">
                            <div>
                                <div class="mb-3" id="searchCliente" style="display: none">
                                    <label for="cliente" class="form-label">Cliente</label>
                                    <input type="text" name="" id="busqueda" class="form-control" placeholder="Escribe el nombre o el correo del cliente">
                                    @csrf
                                    <button class="btn btn-primary" id="btnSearch" >Buscar</button>
                                </div>
                            </div>
                            <div id="tableIndice" style="display: none">
                                <table id="tableCliente">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </thead>
                                </table>
                            </div>
                            <div class="mb-3" style="display: none" id=clienteSelect>
                                <label for="cliente" class="form-label">Cliente Seleccionado</label>
                                <input type="text" class="form-control" name="clienteShow" id="clienteShow" readonly>
                            </div>
                            <div class="mb-3" style="display: none">
                                <label for="cliente" class="form-label">Cliente</label>
                                <input type="text" class="form-control" name="cliente" id="cliente">
                            </div>
                            <div class="mb-3">
                                <label for="cliente" class="form-label">Lote</label>
                                <select class="form-select" name="lote" id="lote" required>
                                    <option value="" selected disabled>Seleciona el lote</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="referencia_pago" class="form-label">Referencia de pago</label>
                                <input type="text" class="form-control" name="referencia_pago" id="referencia_pago" placeholder="Aqui escribe la referencia de pago" required>
                            </div>
                            <div class="mb-3">
                                <label for="concepto" class="form-label">Concepto de pago</label>
                                <select class="form-select" name="concepto" id="concepto" required>
                                    <option value="" selected disabled>Selecciona el concepto de pago</option>
                                    <option value="Apartado">Apartado</option>
                                    <option value="Enganche">Enganche</option>
                                    <option value="Mensualidad">Mensualidad</option>
                                    <option value="Anualidad">Anualidad</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="mb-3" style="display: none;">
                                <label for="otro" class="form-label">Que otro pago es</label>
                                <input type="text" class="form-control" name="otro" id="otro" placeholder="Escribe el tipo de pago que es" required>
                            </div>
                            <div class="mb-3">
                                <label for="concepto" class="form-label">Tipo de pago</label>
                                <select class="form-select" name="tipo" id="tipo" required>
                                    <option value="" selected disabled>Selecciona el tipo de pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="total_pago" class="form-label">Total de pago</label>
                                <input type="number" class="form-control" name="total_pago" id="total_pago" placeholder="Aqui escribe el total de pago" step="any" required>
                            </div>
                            <div class="mb-3">
                                <label for="fechas" class="form-label">Fecha del pago</label>
                                <input type="date" class="form-control" name="fechas" id="fechas" placeholder="Aqui escribe la fecha"required>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" style="display: none;" id="addPago" class="btn btn-primary">Guardar</button>
                    </div>
        </div>
    </div>
</div>


                    <!-- Modal Confirmar pago-->
                    <div class="modal fade" id="modalConfirPago" tabindex="-1" role="dialog" aria-labelledby="modalPagoTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <h5 class="modal-title" id="modalPagoTitle"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="addSave" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <h5 class="modal-title" id="modalDeleteTitle"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                <div class="modal-body">
                                    Seguro que deseas Eliminar?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>


       <!-- Modal cliente -->
    <div class="modal fade" id="modalAddCliente" tabindex="-1" role="dialog" aria-labelledby="ModalClienteTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteModalLabel">Información del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
        <div class="modal-body">
            <div class="container-fluid">
                <form action="#" id="formAddCliente">
                    <div class="mb-3">
                            <div class="col-20 d-flex flex-column py-4">
                                <p >ID:<br>{{$c->id ?? ""}}</p>
                                <p >Nombre:<br>{{$c->nombre  ?? ""}}</p>
                                <p >Email:<br>{{$c->email ?? ""}}</p>
                                <p >Dirección:<br>{{$c->direccion ?? ""}}</p>
                                <p >Celular:<br>{{$c->celular ?? ""}}</p>
                            </div>
                    </div>
                </form>
            </div>
        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abandonar</button>
                </div>
          </div>
        </div>
    </div>

<!-- Modal importar -->
<div id="modalImport" role="dialog" aria-labelledby="modalImportTitleId" aria-hidden="true" tabindex="-1" class="modal fade">
    <div role="document" class="modal-dialog" style="max-width:80%  !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalImportTitle" class="modal-title fw-bold">Importar datos</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10 col-md-8">
                        <h6>Aquí se puede importar información de pagos ya contenida en un archivo de Excel.</h6>
                        <p>Es necesario descargar y vaciar los datos a importar en el archivo de Excel que se puede descargar desde <a href="{{ asset('form_import_pagos.xlsx')}}" download class="btn btn-primary btn-sm fw-bold">aquí</a>
                        .</p>
                        <p>Una vez que se hayan llenado los datos se puede proceder a lo siguiente:</p>
                    </div>
                    <div class="col-1 col-md-2"></div>
                </div>
                <form action="{{ url('pagosImport/') }}" id="formImport" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-2 mb-2"> <!-- Paso 1 -->
                        <div class="col-1"></div>
                        <div class="col-10 col-md-8">
                            <p class="mb-2">
                                <span class="fw-bold">Primero,</span> hay que definir a cuál proyecto corresponden lo pagos a importar.
                            </p>
                            <select name="proyecto_id" id="importToProject" class="form-select mb-2">
                                <option value="0">Seleccionar proyecto</option>
                            </select>
                        </div>
                        <div class="col-1 col-md-2"></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <p class="mb-2">
                                <span class="fw-bold">Segundo,</span> carga el archivo del que se van a extraer los datos.
                            </p>
                            <input type="file" name="archivo" id="archivo" disabled="disabled" required="required" class="form-control">
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="col-1 col-md-2"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnReqImport" disabled="disabled" class="btn btn-primary">Importar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
    <script>
       const mainRecursos = {{ Js::from($recursos)}}
        const mainProjects = mainRecursos.proyectos;

        let clienteBusqueda = null;

        const SeleccionarCliente=(index)=>{
            clienteSelecionado = clienteBusqueda[index];
            console.log(clienteSelecionado);
            $("#tableIndice").hide();
            $("#clienteSelect").show();
            $("#searchCliente").hide();
            $("#clienteShow").val(clienteSelecionado.nombre);
            $("#cliente").val(clienteSelecionado.id);
            $("#cliente").change();
        }

        const findCliente = (id) =>{
            let el;
            mainRecursos.clientes.every((e)=>{
                if(e.id==id){
                    el=e;
                    return false
                }
                return true;
            })
            return el;
        }

        const updatePagos = (id,data) =>{
            let updated=false;
            mainData.every((e,i)=>{
                if(e.id==id){
                    mainData[i]=data;
                    updated=true;
                    return false
                }
                return true;
            })
            return updated;
        }


        const editPagos = (id,el) =>{
            let pagos;
            axios.get("pagos/" + id).then(data => {
                pagos = data.data;
                if(pagos==undefined){return}
                $("#formAdd").trigger("reset")
                $("#concepto").prop("disabled", false);
                $("#addPago").show();
                $("#cliente").val(pagos.id_cliente);
                $("#cliente").change();
                $("#lote").val(pagos.id_lote);
                $("#lote").change();
                $("#total_pago").val(pagos.total_pago);
                $("#referencia_pago").val(pagos.referencia_pago);
                $("#concepto").val(pagos.concepto);
                $("#concepto").change();
                $("#tipo").val(pagos.tipo);
                $("#fechas").val(pagos.fechas);
                $("#fechas").change();
                $("#formAdd").data("update",1)
                $("#formAdd").data("id",pagos.id);
                $("#modalTitleId").html("Actualizar Pago del cliente ");
                $("#modalAdd").modal("show");
                $(el).parent().parent().parent().addClass("update-"+id);
                $("#modalConfirPago .modal-body").html(`
                    <p>Seguro que deseas cambiar los datos del pago del cliente <span id="confirm_cliente"></span>, por el lote <span id="confirm_lote"></span>, con la referencia <span id="confirm_referencia"></span>, por el concepto de <span id="confirm_concepto"></span> siendo pagado por <span id="confirm_tipo"></span> por el monto total de <span id="confirm_total"></span>, el día <span id="confirm_fecha"></span></p>
                `);
            }
            );

        }

        const deletePagos=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar pago del cliente");
            $(el).parent().parent().parent().addClass("remove-"+id)
           // console.log();
        }
        const ver=(e,id,el)=>{
            e.preventDefault();
            const clientes = findCliente(id);
            if(clientes==undefined){return}
            console.log(clientes);

            $("#formAddCliente").data("id_usuario",clientes.id);
            $("#modalAddCliente").modal("show");
            $('#formAddCliente').html(`
                  <p>ID:<br>${clientes.id}</p>
                  <p>Nombre:<br>${clientes.nombre}</p>
                  <p>Email:<br>${clientes.email}</p>
                  <p>Dirección:<br>${clientes.direccion}</p>
                  <p>Celular:<br>${clientes.celular}</p>
                  `);
        }

        const resetImportModal = () => {
            $("select").prop("disabled",false);
            for(let i = 0; i < mainProjects.length; i++){
                let option = `<option value="${mainProjects[i].id}" class="remove">${mainProjects[i].nombre} ${mainProjects[i].clave}</option>`;
                $(option).appendTo($("#importToProject"));
            }
            $("select.option[value=0]").prop("selected",true);
        };

         //* Abre y setea el modal para importar
        $("#btnImport").click((e) => {
            console.log("Click en boton importar");
            $("#formImport").trigger("reset");
            resetImportModal();
            $("#modalImport").modal("show");
        });

        //* Cambia el estado del input archivo, según la opciónd de proyecto seleccionada.
        $("#importToProject").change((e) => {
            $("#importToProject :selected").val() == 0
                ? $("#archivo").prop("disabled",true)
                : $("#archivo").prop("disabled",false);
        });

        //*Habilita el botón de importar cuando se seleciona el archivo desde el que se va a importar la información
        $("#archivo").change((e) => {
            $("#archivo").val() != null
            ? $("#btnReqImport").prop("disabled",false)
            : $("#btnReqImport").prop("disabled",true);
        });

    </script>
    <script type="module">
    $(document).ready(()=>{
        let mainTable = $("#firstTable").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('tablas/pagos') }}",
                "type": "GET"
            },
            "columns": [
                { "data": "id" },
                { "data": "cliente", "orderable": false, "searchable": true },
                { "data": "lote" },
                { "data": "total_pago" },
                { "data": "referencia_pago" },
                { "data": "concepto" },
                { "data": "tipo" },
                { "data": "fechas" },
                { "data": "created_at" },
                { "data": "acciones", "orderable": false, "searchable": false }
            ]
        });
    });

    $("#addBtn").click(()=>{

        const dt= $("#tableCliente").DataTable()
        dt.clear().draw();
        $("#tableIndice").hide();
        $("#cliente").val("");
        $("#cliente").change();

        $("#searchCliente").show();
        $("#clienteSelect").hide();
        $("#addPago").show();
        $("#concepto").prop("disabled", false);
        $("#concepto option[value='Apartado']").hide();
        $("#formAdd").trigger("reset")
        $("#modalTitleId").html("Agregar pago")
        $("#modalAdd").modal("show"),
        $("#formAdd").data("update",0)
        $("#modalConfirPago .modal-body").html(`
            <p>Seguro que deseas generar el pago del cliente <span id="confirm_cliente"></span> ,por el lote <span id="confirm_lote"></span> ,con la referencia <span id="confirm_referencia"></span> ,por el concepto de <span id="confirm_concepto"></span> siendo pagado por <span id="confirm_tipo"></span> por el monto total de <span id="confirm_total"></span> ,el día <span id="confirm_fecha"></span></p>
        `);
    });

    $("#addPago").click(()=>{
        let form=document.getElementById("formAdd");
            if(!form.checkValidity()){
                form.reportValidity();
                return
            }
        $("#modalConfirPago").modal("show");
        $("#modalPagoTitle").html("Confirmar pago");
        var clienteSeleccionado = $("#clienteShow").val();
        var loteSeleccionado = $("#lote option:selected").text();
        var referenciaPago = $("#referencia_pago").val();
        var conceptoPago = $("#concepto option:selected").text();
        var tipoPago = $("#tipo option:selected").text();
        var totalPago = $("#total_pago").val();
        var fechaPago = $("#fechas").val();

        $("#confirm_cliente").html(clienteSeleccionado);
        $("#confirm_lote").html(loteSeleccionado);
        $("#confirm_referencia").html(referenciaPago);
        $("#confirm_concepto").html(conceptoPago);
        $("#confirm_tipo").html(tipoPago);
        $("#confirm_total").html(totalPago);
        $("#confirm_fecha").html(fechaPago);

        $("#modalAdd").modal("hide");
    });

    var opcionesOriginales = $("#concepto option").clone();

        $("#addSave").click(function (e) {
            $("#addSave").prop("disabled", true);
            let form=document.getElementById("formAdd");
            if(!form.checkValidity()){
                form.reportValidity();
                return
            }
            let inputs = $("#formAdd").serializeArray();
            const data = new FormData(document.getElementById("formAdd"));

            if($("#formAdd").data("update")==1){
                let id=$("#formAdd").data("id");
                data.append("_method","PUT")
                $("#modalConfirPago").modal("hide")
                $("#formAdd").trigger("reset")
                axios.post("pagos/"+id,data).then((e)=>{
                   if( !updatePagos(id,e.data.data)){console.log("error al actualizar local")}

                const dt=$(".table").DataTable();
                    dt.ajax.reload();
                    }).catch((e)=>{
                    console.log(e);

                    })
            } else{
                axios.post("",data).then((e)=>{
                    $("#modalConfirPago").modal("hide")
                    $("#formAdd").trigger("reset")
                    const dt=$(".table").DataTable();
                    $("#addSave").prop("disabled", false);

                    $("#concepto").html(opcionesOriginales);
                    $("#concepto option[value='Apartado']").hide();

                // mainData.push(e.data.data)
                dt.ajax.reload();
                }).catch((e)=>{
                console.log(e);
                })
            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete("pagos/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$(".table").DataTable();
                // dt.rows('.remove-'+id).remove().draw();
                dt.ajax.reload();
            }).catch((e)=>{
                console.log(e);
            })

        });


        $("#addData").click(()=>{
        $("#formAddData").trigger("reset")
        $("#modalTitleIdAddData").html("Importar/Data ")
        $("#modalAddData").modal("show")
        });

        $("#addLote").click(()=>{
            const dt= $("#tableCliente").DataTable()
            dt.clear().draw();
            $("#tableIndice").hide();
            $("#cliente").val("");
            $("#cliente").change();

            $("#searchCliente").show();
            $("#clienteSelect").hide();

            $("#addPago").show();
            $("#formAdd").trigger("reset")
            $("#modalTitleId").html("Apartar lote")
            $("#modalAdd").modal("show"),
            $("#formAdd").data("update",3)

            $("#concepto").val("Apartado").change()
            $("#modalConfirPago .modal-body").html(`
                <p>Seguro que deseas generar el pago para el apartado del lote <span id="confirm_lote"></span> para el cliente <span id="confirm_cliente"></span>,con la referencia <span id="confirm_referencia"></span> ,por el concepto de <span id="confirm_concepto"></span> siendo pagado por <span id="confirm_tipo"></span> por el monto total de <span id="confirm_total"></span> ,el día <span id="confirm_fecha"></span></p>
            `);

        });

        $("#cliente").change(function() {
            let concepto = $("#concepto").val();
            let cliente = $("#cliente").val();

            let selectLote = $("#lote");
            let selectedOption = selectLote.find(":selected").clone();

            selectLote.empty();

            selectLote.append('<option value="" selected disabled>Seleciona el lote</option>');

            if (concepto == "Apartado") {

                let lotesDis = mainRecursos.lotesDis;

                    lotesDis.forEach(lote => {
                        let optionText = `${lote.proyecto.nombre}/Z${lote.etapa.etapa}/M${lote.manzana}/L${lote.lote}`;
                        $("#lote").append(`<option value="${lote.id}">${optionText}</option>`);
                });
            } else {
                let lotesFiltrados = mainRecursos.lotes.filter(lotes => lotes.comprador_id == cliente);

                lotesFiltrados.forEach(lote => {
                    let optionText = `${lote.proyecto.nombre}/Z${lote.etapa.etapa}/M${lote.manzana}/L${lote.lote}`;
                    $("#lote").append(`<option value="${lote.id}">${optionText}</option>`);
                });

            }
            selectLote.val(selectedOption.val());
        });

        $("#concepto").change(function() {
            var concepto = $(this).val();
            var otroInput = $("#otro");

        if (concepto == "Otros") {
            $("#otro").parent().show();
            otroInput.prop("required", true);
            otroInput.prop("disabled", false);
        } else {
            $("#otro").parent().hide();
            otroInput.prop("required", false);
            otroInput.prop("disabled", true);
        }
        });

        $("#otro").change(function() {
        var otro = $(this).val();
        var concepto = $("#concepto").val();

            if (concepto == "Otros") {
                var nuevoConcepto = concepto + ": " + otro;

                var nuevaOpcion = $("<option>").val(nuevoConcepto).text(nuevoConcepto);

                $("#concepto").change();
                $("#concepto").append(nuevaOpcion);
                $("#concepto").val(nuevoConcepto);
                $("#otro").parent().hide();

            } else {
                $("#concepto option[value='Apartado']").hide();
                otroInput.prop("required", false);
            }
        });

        $("#btnSearch").click(function (e) {
            e.preventDefault();
            const busqueda=$("#busqueda").val();
            const dt= $("#tableCliente").DataTable()
            dt.clear().draw();
            $.ajax({
                type: "post",
                url: "ofertas/search",
                data: {busqueda:busqueda, _token:$("input[name='_token']").val()},
                dataType: "json",
                success: function (response) {
                    clienteBusqueda = response;
                    $("#searchResults").empty();
                    response.forEach(function (result,i) {
                    const btn = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="SeleccionarCliente(${i})">Seleccionar Cliente</button>
                                </div>`
                    dt.row.add([result.id,result.nombre,result.email,btn]).draw()
                });
                },
                error: function (error) {
                    console.error(error);
                }
                });
                $("#tableIndice").show();
        });

    </script>
@endsection


