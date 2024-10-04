@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex mb-2 justify-content-between">
                    <h1>Proceso de venta</h1>
                    <div class="botones">
                        <button class="btn btn-secondary" id="addOrden">Cambiar orden de procesos</button>
                        <button class="btn btn-success" id="addBtn">Añadir proceso</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-primary text-center" id="procesoVentaTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Embudo</th>
                                <th scope="col" class="text-center">Orden</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Descripción</th>
                                <th scope="col" class="text-center">Seguimiento</th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal proceso-->
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
                                <div class="mb-3" style="display: none">
                                    <label for="id" style="display: none"class="form-label fw-bold mb-0">id</label>
                                    <input type="hidden" style="display: none" class="form-control" name="id" id="id">
                                </div>
                                <div class="mb-3">
                                    <label for="id_embudo" class="form-label fw-bold mb-0">Embudo</label>
                                    <select class="form-select" name="id_embudo" id="id_embudo" required>
                                        <option value="" selected disabled>Seleccione el embudo</option>
                                        @foreach ($embudos as $em)
                                            <option value="{{ $em->id }}">{{ $em->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold mb-0">Status</label>
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Aquí el nombre del proceso" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descrip" class="form-label fw-bold"> Descripción del proceso</label>
                                    <textarea class="form-control" name="descrip" id="descrip" rows="3" maxlength="500" oninput="adjustTextarea(this)" placeholder="Aquí describe el proceso"></textarea>
                                    <small class="form-text text-muted">Máximo 500 caracteres.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="seg" class="form-label fw-bold mb-0">Seguimiento</label>
                                    <input type="text" class="form-control" name="seg" id="seg" placeholder="Seguimiento">
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="confi" class="btn btn-primary">Guardar</button>
                    </div>

            </div>
        </div>
    </div>

    <!-- Modal Confirmar-->
    <div class="modal fade" id="modalConfir" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalConfirTitle"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seguro que deseas guardar el proceso?
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

    <!-- Modal Orden-->
    <div class="modal fade" id="modalAddsub" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:80% !important">
            <div class="modal-content" >
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleOrdenId"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="#" id="formAddOrden">
                                <div>
                                    <b>Para poder modificar el orden de los procesos de un embudo debes seleccionar el embudo</b>
                                    <br><br>
                                </div>
                                <div class="mb-3">
                                    <label for="id_embudo" class="form-label fw-bold mb-0">Embudo</label>
                                    <select class="form-select" name="idEmb" id="idEmb" required>
                                        <option value="" selected disabled>Seleccione el embudo</option>
                                        @foreach ($embudos as $em)
                                            <option value="{{ $em->id }}">{{ $em->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <br><br><br>
                                </div>
                                <ol class="list-group" style="display:none">
                                </ol>
                            </form>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="confiOrden" class="btn btn-primary">Establecer orden de procesos</button>
                    </div>

            </div>
        </div>
    </div>

    <!-- Modal Confirmar orden-->
    <div class="modal fade" id="modalConfirOrden" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalConfirOrdenTitle"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seguro que deseas guardar el orden de los procesos?
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="addSaveOrden" class="btn btn-primary">Guardar Orden</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("scripts")
    <script >

        function adjustTextarea(el) {
            el.style.height = "auto";
            el.style.height = (el.scrollHeight) + "px";
        }

        const deleteProcesoVenta=(id)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar proceso");
        }

        const editProcesoVenta = (id) =>{
            let proceso;
            axios.get("procesoVenta/" + id).then(data => {
                proceso = data.data;
                if(proceso==undefined){return}
                console.log(proceso);
                $("#id").val(proceso.id);
                $("#orden").val(proceso.orden);
                $("#id_embudo").val(proceso.id_embudo);
                $("#status").val(proceso.status);
                $("#descrip").val(proceso.descripcion);
                $("#seg").val(proceso.seguimiento);

                $("#formAdd").data("update",1)
                $("#formAdd").data("id",proceso.id);
                $("#modalTitleId").html("Editar del proceso")
                $("#modalAdd").modal("show");
            });
        }

        // function loadModalData() {
        //     axios.get('/procesoVenta/showProcesoVenta')
        //         .then(response => {
        //             console.log(response.data);
        //             let items = response.data;
        //             if (Array.isArray(items)) {
        //                 let listGroup = $("#modalAddOrden .list-group");
        //                 listGroup.empty();

        //                 items.forEach(pv => {
        //                     let ordenText = pv.orden === null ? '' : pv.orden;

        //                     listGroup.append(`
        //                         <li class="list-group-item d-flex justify-content-between align-items-start mb-4" style="background-color: #e9ecef; color: #000000;" data-id="${pv.id}">
        //                             <div class="ms-2 me-auto">
        //                                 <div class="fw-bold">${pv.status}</div>
        //                                 ${pv.descripcion}
        //                             </div>
        //                             <span class="badge bg-primary rounded-pill">${ordenText}</span>
        //                         </li>
        //                     `);
        //                 });

        //                 $("#modalAddOrden .list-group").sortable();
        //                 $("#modalAddOrden .list-group").disableSelection();
        //             } else {
        //                 console.error('La respuesta no contiene una lista válida de procesoVenta.');
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error al cargar los datos:', error);
        //         });
        // }

        //Carga de procesos
        function  loadModalPro(id) {
            axios.get(`/embudos/procesos/${id}`)
                .then(response => {
                    let items = response.data;
                    let listGroup = $("#modalAddsub .list-group");
                    listGroup.empty();

                    if (Array.isArray(items) && items.length > 0) {
                        items.forEach(sub => {

                            let subOrdenText = sub.orden === null ? '' : sub.orden;

                            let listItem = $(`
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-4" style="background-color: #e9ecef; color: #000000;" data-id="${sub.id}">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">${sub.status}</div>
                                        ${sub.descripcion}
                                    </div>
                                    <span class="badge bg-secondary rounded-pill">${subOrdenText}</span>
                                </li>
                            `);

                            listGroup.append(listItem);
                        });
                        $("#modalAddsub .list-group").sortable();
                        $("#modalAddsub .list-group").disableSelection();
                    } else {
                        listGroup.append(`
                            <li class="list-group-item d-flex justify-content-center align-items-center" style="background-color: #f8d7da; color: #721c24;">
                                No hay procesos agregados a este embudo.
                            </li>
                        `);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los procesos:', error);
                });
        }

    </script>

    <script type="module" >

        //tabla Procesos
        $(document).ready(()=>{
            let procesoVentaTable = $("#procesoVentaTable").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('tablas/ProcesoVenta') }}",
                    "type": "GET"
                },
                "columns": [
                    { "data": "id_embudo" },
                    { "data": "orden" },
                    { "data": "status" },
                    { "data": "descripcion" },
                    { "data": "seguimiento" },
                    { "data": "acciones", "orderable": false, "searchable": false }
                ]
            });
        });

        $("#addBtn").click(()=>{

            const dt= $("#procesoVentaTable").DataTable()
            dt.clear().draw();

            $("#formAdd").trigger("reset")
            $("#modalTitleId").html("Agregar proceso")
            $("#modalAdd").modal("show"),
            $("#formAdd").data("update",0)
        });

        $("#confi").click(function() {
            let form = document.getElementById("formAdd");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $("#modalConfir").modal("show");
            $("#modalAdd").modal("hide");
        });

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
                $("#modalConfir").modal("hide")
                $("#formAdd").trigger("reset")
                axios.post("procesoVenta/"+id,data).then((e)=>{

                const dt=$(".table").DataTable();
                    dt.ajax.reload();
                    }).catch((e)=>{
                    console.log(e);

                    })
                    $("#addSave").prop("disabled", false);

            } else{
                axios.post("procesoVenta",data).then((e)=>{
                    $("#modalConfir").modal("hide")
                    $("#formAdd").trigger("reset")
                    const dt=$(".table").DataTable();

                // mainData.push(e.data.data)
                dt.ajax.reload();
                }).catch((e)=>{
                console.log(e);
                })
                $("#addSave").prop("disabled", false);

            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete("procesoVenta/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$(".table").DataTable();
                // dt.rows('.remove-'+id).remove().draw();
                dt.ajax.reload();
            }).catch((e)=>{
                console.log(e);
            })

        });

        $(document).ready(function () {

            $("#modalAddsub .list-group").sortable();
            $("#modalAddsub .list-group").disableSelection();

            $("#addOrden").click(() => {
                $("#modalTitleOrdenId").html("Cambiar orden de procesos");
                $("#modalAddsub").modal("show");
                $("#formAddOrden").trigger("reset");
                $("#modalAddsub .list-group").empty();
                $("#modalAddsub .list-group").hide();
            });

            $("#idEmb").change(function() {
                let embudoId = $(this).val();
                if (embudoId) {
                    $("#modalAddsub .list-group").show();
                    loadModalPro(embudoId);
                }
            });

            $("#confiOrden").click(() => {
                let form = document.getElementById("formAddOrden");

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                $("#modalAddsub").modal("hide");
                $("#modalConfirOrden").modal("show");
            });

            $("#addSaveOrden").click(function() {
                $("#addSaveOrden").prop("disabled", true);

                let orden = [];

                $("#modalAddsub .list-group-item").each(function(index, element) {
                    let id = $(element).data('id');
                    orden.push({
                        id: id,
                        orden: index + 1
                    });
                });

                let data = {
                    orden: orden,
                    id_embudo: $("#idEmb").val()
                };

                axios.post('/embudos/procesos/orden', data)
                    .then(response => {
                        $("#modalConfirOrdenSub").modal("hide");
                        const dt=$(".table").DataTable();
                        dt.ajax.reload();

                        $("#formAddOrden").trigger("reset");
                        $("#modalAddsub .list-group").hide();
                        $("#modalAddsub .list-group").empty();
                        $("#modalAddsub .list-group").hide();
                        $("#modalConfirOrden").modal("hide");
                        $("#addSaveOrden").prop("disabled", false);
                    })
                    .catch(error => {
                        console.error('Error al guardar el orden de los subprocesos:', error);
                        $("#addSaveOrden").prop("disabled", false);

                    });
                $("#addSaveOrden").prop("disabled", false);
            });

        });

    </script>
@endsection

