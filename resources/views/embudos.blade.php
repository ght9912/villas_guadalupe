@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="d-flex mb-2 justify-content-between">
                        <h1>Embudos</h1>
                        <div class="botones">
                            <button class="btn btn-success" id="addBtn">Añadir Embudo</button>
                            <div class="dropdown mt-3">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Formularios
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" id="addBtnFormulario">Crear formulario</a></li>
                                    <li><a class="dropdown-item" id="editBtnFormulario">Editar formulario</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-primary text-center" id="embudoTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">id</th>
                                    <th scope="col" class="text-center">nombre</th>
                                    <th scope="col" class="text-center">Descripción</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal embudo-->
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
                                        <input type="text" style="display: none" class="form-control" name="id" id="id">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label fw-bold mb-0">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aquí escribe el nombre del embudo" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label fw-bold"> Descripción del embudo</label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" maxlength="500" oninput="adjustTextarea(this)" placeholder="Aquí describe el embudo"></textarea>
                                        <small class="form-text text-muted">Máximo 500 caracteres.</small>
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

        <!-- Modal embudo Confirmar-->
        <div class="modal fade" id="modalConfir" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalConfirTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Seguro que deseas guardar este nuevo embudo?
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="addSave" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal embudo Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalDeleteTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <a>
                            SI EL EMBUDO TIENE PROCESOS ASIGNADOS ESTOS TAMBIEN SERAN ELIMINADOS
                            <br><br>
                            Seguro que deseas Eliminar el embudo?
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal proceso Orden-->
        <div class="modal fade" id="modalAddsub" tabindex="-1" role="dialog" aria-labelledby="modalTitleSubId" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width:80% !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleSubId">Subprocesos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="#" id="formAddSub">
                                <ol class="list-group">
                                </ol>

                                <div class="mb-3" style="display: none">
                                    <label for="idEmbudo" style="display: none" class="form-label fw-bold mb-0">id</label>
                                    <input type="hidden" style="display: none" class="form-control" name="idEmbudo" id="idEmbudo">
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="confiOrdenSub">Establecer orden de procesos</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar orden proceso-->
        <div class="modal fade" id="modalConfirOrdenSub" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalConfirOrdenSubTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Seguro que deseas guardar el orden de los subprocesos?
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="addSaveOrdenSub" class="btn btn-primary">Guardar Orden de subrprocesos</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para generar campos-->
        <div class="modal fade" id="modalCampos" tabindex="-1" role="dialog" aria-labelledby="modalCamposTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width:80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCamposTitleId"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div id="mensajeCrear" class="mb-3" style="display: none;">
                                <a>
                                    Debes seleccionar un embudo antes de poder crear un formulario,
                                    todos los formularios incluyen las opciones de NOMBRE, CELULAR Y CORREO de forma predeterminada por lo que no los tienes que agregar,
                                    puedes agregar todas las opciones que consideres necesarias.
                                </a>
                            </div>
                            <div id="mensajeEditar" class="mb-3" style="display: none;">
                                <a>
                                    Para modificar un formulario, debes seleccionar un embudo.
                                </a>
                            </div>
                            <div id="messageContainer" style="display: none;"></div>
                            <div class="mb-3" id="selectEdit" style="display: none">
                                <label for="Embudo" class="form-label fw-bold mb-0">Selecciona un embudo</label>
                                <input class="form-control" list="datalistProyecto4" id="Embudo" placeholder="Selecciona un embudo">
                                <input type="hidden" id="embudo_select" name="embudo_select">
                                <datalist id="datalistProyecto4"></datalist>
                            </div>
                            <div class="mb-3" id="selectEdit2" style="display: none">
                                <label for="EmbudoEdi" class="form-label fw-bold mb-0">Buscar un embudo</label>
                                <input class="form-control" list="datalistProyectoEd" id="EmbudoEdi" placeholder="Buscar un embudo">
                                <input type="hidden" id="embudo_selectEd" name="embudo_selectEd">
                                <datalist id="datalistProyectoEd"></datalist>
                            </div>
                            <div style="display: none">
                                <input type="hidden" id="formMode" value="create">
                            </div>
                        </div>
                        <div id="customFieldForm" class="mt-3">
                            <form id="formCustomField">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label fw-bold mb-0">Campos</label>

                                    <!-- Cards de campos predeterminados -->
                                    <div id="cards">
                                        <div class="card-body mb-3">
                                            <div class="mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Nombre del campo</label>
                                                        <input type="text" class="form-control" value="Nombre" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Descripción para el llenado</label>
                                                        <input type="text" class="form-control" value="Aquí escribe el nombre del prospecto" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Tipo de dato</label>
                                                        <select class="form-select" readonly>
                                                            <option value="text">Texto</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">¿Es obligatorio?</label>
                                                        <select class="form-select" readonly>
                                                            <option value="required">Obligatorio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body mb-3">
                                            <div class="mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Nombre del campo</label>
                                                        <input type="text" class="form-control" value="Celular" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Descripción para el llenado</label>
                                                        <input type="text" class="form-control" value="Aquí coloca el celular del prospecto" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Tipo de dato</label>
                                                        <select class="form-select" readonly>
                                                            <option value="tel">Teléfono</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">¿Es obligatorio?</label>
                                                        <select class="form-select" readonly>
                                                            <option value="required">Obligatorio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body mb-3">
                                            <div class="mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Nombre del campo</label>
                                                        <input type="text" class="form-control" value="Correo electrónico" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Descripción para el llenado</label>
                                                        <input type="text" class="form-control" value="Aquí escribe el correo electrónico" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">Tipo de dato</label>
                                                        <select class="form-select" readonly>
                                                            <option value="email">Correo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label fw-bold">¿Es obligatorio?</label>
                                                        <select class="form-select" readonly>
                                                            <option value="required">Obligatorio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="camposPerso" class="d-flex flex-column mb-1">
                                    </div>
                                    <div class="w-100 mb-2">
                                        <button class="btn btn-primary" type="button" id="addCampo">Añadir campo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" style="display: none" id="saveFormFields">Guardar formulario</button>
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

        const deleteEmbudo=(id)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar embudo");
        }

        const editEmbudo = (id) =>{
            let embudo;
            axios.get("embudos/" + id).then(data => {
                embudo = data.data;
                if(embudo==undefined){return}
                // console.log(embudo);
                $("#id").val(embudo.id);
                $("#nombre").val(embudo.nombre);
                $("#descripcion").val(embudo.descripcion);

                $("#formAdd").data("update",1);
                $("#formAdd").data("id",embudo.id);
                $("#modalTitleId").html("Editar embudo "+ embudo.nombre)
                $("#modalAdd").modal("show");
            });
        }

        //Carga modal de procesos
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
                                    <div class="dropdown me-3">
                                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton${sub.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${sub.id}">
                                            <li><a class="dropdown-item" href="#" onclick="editSub(${sub.id}, this)">Editar</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="deleteSub(${sub.id}, this)">Eliminar</a></li>
                                        </ul>
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

        const orderPro = (id) =>{
            $("#modalAddsub").modal("show");
            $("#idEmbudo").val(id);
            loadModalPro(id);
        }

        function getCustomFields() {
            let customFieldObjects = [];

            $('.campo-personalizado').each(function() {
                let campoId = $(this).attr('id').split('-')[1];
                let inputField = $(this).find(`input[name="nombre_${campoId}"]`).val().trim();
                let typeField = $(this).find(`select[name="tipo_${campoId}"]`).val();
                let requiredField = $(this).find(`select[name="required_${campoId}"]`).val();
                let optionsField = $(this).find(`input[name="opciones_${campoId}"]`).val().trim();
                let placeholderField = $(this).find(`input[name="placeholder_${campoId}"]`).val().trim();

                if (inputField && typeField) {
                    customFieldObjects.push({
                        input: inputField,
                        type: typeField,
                        placeholder: placeholderField || null,
                        options: optionsField || null,
                        prop: requiredField || null
                    });
                }
            });

            return customFieldObjects;
        }

        function saveFormFields(embudoId, movimiento, customFields) {
            axios.post('/embudos/formulario', {
                embudo_id: embudoId,
                movimiento: movimiento,
                campos_personalizados: customFields
            })
            .then(function(response) {
                if (response.data.success) {
                    $("#modalCampos").modal("hide");
                    $('#camposPerso').empty();
                } else {
                    console.error('Error en la respuesta:', response.data);
                    alert('Ocurrió un error al guardar los campos personalizados.');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Ocurrió un error al guardar los campos personalizados.');
            });
        }

        let campoCount = 0;

        function agregarCampo(nombre = '', placeholder = '', tipo = '', obligatorio = '', opciones = '') {
            campoCount++;

            let newCampo = `
                <div class="campo-personalizado mb-3 p-3 border rounded" id="campo-${campoCount}">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="nombre_${campoCount}" class="form-label fw-bold">Nombre del campo</label>
                            <input type="text" class="form-control" placeholder="Nombre del campo" name="nombre_${campoCount}" value="${nombre}" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="placeholder_${campoCount}" class="form-label fw-bold">Descripción para el llenado</label>
                            <input type="text" class="form-control" placeholder="Ej 'Escribe la dirección'" name="placeholder_${campoCount}" value="${placeholder}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="tipo_${campoCount}" class="form-label fw-bold">Tipo de dato</label>
                            <select class="form-select tipoDato" name="tipo_${campoCount}" required>
                                <option value="" selected disabled>Selecciona el tipo de dato con el que se llenará el campo</option>
                                <option value="text" ${tipo === 'text' ? 'selected' : ''}>Texto</option>
                                <option value="number" ${tipo === 'number' ? 'selected' : ''}>Número</option>
                                <option value="string" ${tipo === 'string' ? 'selected' : ''}>Moneda</option>
                                <option value="date" ${tipo === 'date' ? 'selected' : ''}>Fecha</option>
                                <option value="select" ${tipo === 'select' ? 'selected' : ''}>Opciones</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="required_${campoCount}" class="form-label fw-bold">¿Es obligatorio?</label>
                            <select class="form-select" name="required_${campoCount}" required>
                                <option value="" disabled ${obligatorio === '' ? 'selected' : ''}>Selecciona si el dato será necesario siempre que se use el formulario</option>
                                <option value="null" ${obligatorio === 'null' ? 'selected' : ''}>No obligatorio</option>
                                <option value="required" ${obligatorio === 'required' ? 'selected' : ''}>Obligatorio</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2 opciones-container" style="display: ${tipo === 'select' ? 'block' : 'none'};">
                            <label for="opciones_${campoCount}" class="form-label fw-bold">Opciones (separadas por comas)</label>
                            <input type="text" class="form-control opcionesCampo" placeholder="Opción 1, Opción 2, Opción 3" name="opciones_${campoCount}" value="${opciones}">
                        </div>
                    </div>

                    <button class="btn btn-danger eliminarCampos mt-2" type="button">Eliminar</button>
                </div>
            `;

            $('#camposPerso').append(newCampo);
        }

    </script>

    <script type="module" >

        // tabla principal
        $(document).ready(()=>{
            let embudoTable = $("#embudoTable").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('tablas/embudos') }}",
                    "type": "GET"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "nombre" },
                    { "data": "descripcion" },
                    { "data": "acciones", "orderable": false, "searchable": false }
                ]
            });
        });

        //boton de creacion
        $("#addBtn").click(()=>{

            const dt= $("#embudoTable").DataTable()
            dt.clear().draw();

            $("#formAdd").trigger("reset")
            $("#modalTitleId").html("Agregar un embudo")
            $("#modalAdd").modal("show"),
            $("#formAdd").data("update",0)
        });

        //confirmacion de creacion
        $("#confi").click(function() {
            let form = document.getElementById("formAdd");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $("#modalConfir").modal("show");
            $("#modalAdd").modal("hide");
        });

        //ejecucicion de creacion
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
                axios.post("embudos/"+id,data).then((e)=>{

                    const dt=$(".table").DataTable();
                    dt.ajax.reload();

                    }).catch((e)=>{
                        // console.log(e);
                    })
                    $("#addSave").prop("disabled", false);

            } else{
                axios.post("embudos",data).then((e)=>{
                    $("#modalConfir").modal("hide")
                    $("#formAdd").trigger("reset")
                    const dt=$(".table").DataTable();

                // mainData.push(e.data.data)
                dt.ajax.reload();
                }).catch((e)=>{
                // console.log(e);
                })
                $("#addSave").prop("disabled", false);

            }
        });

        //eliminacion
        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete("embudos/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$(".table").DataTable();
                dt.ajax.reload();
            }).catch((e)=>{
                // console.log(e);
            })

        });

        //guardado de orden de procesos
        $(document).ready(function () {

            $("#modalAddsub .list-group").sortable();
            $("#modalAddsub .list-group").disableSelection();

            $("#confiOrdenSub").click(()=>{
                $("#modalAddsub").modal("hide");
                $("#modalConfirOrdenSub").modal("show")
            });

            $("#addSaveOrdenSub").click(function() {
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
                    id_embudo: $("#idEmbudo").val()
                };

                axios.post('/embudos/procesos/orden', data)
                    .then(response => {
                        // console.log('Orden  de subprocesos guardado exitosamente');
                        const r = response.data.data
                        loadModalPro(r);
                        $("#modalConfirOrdenSub").modal("hide");
                        $("#modalAddsub").modal("show");
                    })
                    .catch(error => {
                        console.error('Error al guardar el orden de los subprocesos:', error);
                    });
            });
        });

        let isCreatingForm = false;

        $("#addBtnFormulario").click(function() {

            isCreatingForm = true;
            $('#camposPerso').empty();

            $('#customFieldForm').hide();
            $('#cards').hide();
            $("#formCustomField").trigger("reset");

            $('#Embudo').val('');
            $('#embudo_select').val('');

            $("#EmbudoEdi").prop('required', false);
            $("#Embudo").prop('required', true);
            $("#modalCamposTitleId").html("Creación de formulario");
            $("#mensajeCrear").show();
            $("#mensajeEditar").hide();
            $("#saveFormFields").html("Guardar formulario");
            $("#selectEdit").show();
            $("#selectEdit2").hide();
            $("#saveFormFields").hide();

            $('#formMode').val('create');

            $.ajax({
                url: '/prospecto/formulario/notexists',
                method: 'GET',
                success: function(data) {
                    let datalist = $('#datalistProyecto4');
                    datalist.empty();

                    if (data.length === 0) {
                        $('#selectEdit').hide();
                        $('#messageContainer').html(
                            '<div class="alert alert-info" role="alert">' +
                            ' Todos los Embudos tienen un formulario personalizado creado. Si deseas hacer cambios, selecciona la opción de editar formularios.' +
                            '</div>'
                        ).show();
                        $('#saveFormFields').hide();
                    } else {
                        $('#Embudo').show();
                        $('#messageContainer').hide();

                        data.forEach(function(embudo) {
                            let optionText = embudo.nombre;
                            datalist.append('<option data-id="' + embudo.id + '" value="' + optionText + '">');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los proyectos:', error);
                }
            });

            $('#Embudo').on('input', function() {
                $('#cards').show();
                $('#saveFormFields').show();
                $('#customFieldForm').show();

                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyecto4 option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $('#embudo_select').val(selectedId);
                    $("#embudo_selectEd").val('');
                } else {
                    $('#embudo_select').val('');
                }
            });

            $("#modalCampos").modal("show");
        });

        $("#editBtnFormulario").click(function() {
            $('#cards').hide();
            $('#customFieldForm').hide();
            $('#EmbudoEdi').val('');
            $('#embudo_selectEd').val('');
            $('#messageContainer').hide();

            $("#Embudo").prop('required', false);
            $("#EmbudoEdi").prop('required', true);
            $("#modalCamposTitleId").html("Editar campos de un formulario");
            $("#mensajeCrear").hide();
            $("#mensajeEditar").show();
            $("#saveFormFields").html("Guardar cambios formulario");
            $("#selectEdit").hide();
            $("#selectEdit2").show();
            $("#saveFormFields").hide();

            $('#formMode').val('edit');

            axios.get('/prospecto/formulario/exists')
                .then(function(response) {
                    let datalist = $('#datalistProyectoEd');
                    datalist.empty();

                    if (response.data.length === 0) {
                        $('#messageContainer').html(
                            '<div class="alert alert-info" role="alert">' +
                            'Ningún embudo tiene formulario creado. Antes de poder editarlo debes crearlo.' +
                            '</div>'
                        ).show();
                        $('#EmbudoEdi').hide();
                        $('#saveFormFields').hide();
                    } else {
                        $('#EmbudoEdi').show();
                        $('#messageContainer').hide();

                        response.data.forEach(function(embudo) {
                            let optionText = embudo.nombre;
                            datalist.append('<option data-id="' + embudo.id + '" value="' + optionText + '">');
                        });
                    }
            })
                .catch(function(error) {
                    console.error('Error al cargar los embudos:', error);
            });

            $('#EmbudoEdi').on('input', function() {
                $('#cards').show();

                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyectoEd option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $("#embudo_selectEd").val(selectedId);
                    $("#embudo_select").val('');
                    $('#saveFormFields').show();
                    $('#customFieldForm').show();

                    axios.get('/embudos/' + selectedId)
                        .then(function(response) {
                            $('#camposPerso').empty();

                            let formulario = response.data.formulario; // Asegúrate de que `formulario` contenga el JSON del formulario

                            try {
                                formulario = JSON.parse(formulario);
                            } catch (e) {
                                console.error('Error al parsear el formulario:', e);
                                return;
                            }

                            formulario.forEach(function(campo) {
                                let nombre = campo.input || '';
                                let placeholder = campo.placeholder || '';
                                let tipo = campo.type || '';
                                let obligatorio = campo.prop || '';
                                let opciones = campo.options || '';

                                agregarCampo(nombre, placeholder, tipo, obligatorio, opciones);
                            });
                        })
                        .catch(function(error) {
                            console.error('Error al cargar los datos del embudo:', error);
                        });
                } else {
                    $('#embudo_selectEd').val('');
                }
            });

            $("#modalCampos").modal("show");
        });

        $("#saveFormFields").click(function() {
            let form = document.getElementById("formCustomField");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let embudoIdCreate = $("#embudo_select").val();
            let embudoIdEdit = $("#embudo_selectEd").val();
            let embudoId = embudoIdCreate || embudoIdEdit;
            let movimiento = $("#formMode").val();

            let customFields = getCustomFields();

            let camposExistentes = $('#camposPerso .campo-personalizado').length;
            if (camposExistentes === 0) {
                alert('Debe agregar al menos un campo antes de guardar el formulario.');
                return;
            }

            if (!embudoId) {
                alert('Por favor, selecciona un embudo.');
                return;
            }

            saveFormFields(embudoId, movimiento, customFields);

            $("#modalCampos").modal("hide");
            $('#camposPerso').empty();
        });

        $(document).ready(function() {

            $('#modalCampos').on('show.bs.modal', function(event) {
                $('#camposPerso').empty();

                if (isCreatingForm) {
                    let datosPreexistentes = [
                        { nombre: 'Dirección', placeholder: 'Aquí escribe la dirección', tipo: 'text', obligatorio: '', opciones: '' },
                        { nombre: 'Canal de contacto preferido', placeholder: 'Selecciona el canal de contacto preferido', tipo: 'select', obligatorio: '', opciones: 'WhatsApp,Correo,Telefono' },
                        { nombre: 'Por qué medio se enteró de nosotros', placeholder: 'Aquí escribe el medio por el que se enteró de nosotros', tipo: 'text', obligatorio: '', opciones: '' },
                        { nombre: 'Ingresos Mensuales', placeholder: 'Aquí escribe los ingresos del prospecto', tipo: 'string', obligatorio: '', opciones: '' },
                        { nombre: 'Motivo de compra', placeholder: 'Aquí escribe el motivo de compra', tipo: 'text', obligatorio: '', opciones: '' },
                        { nombre: 'Tiempo en el que quiere comprar', placeholder: 'Selecciona la fecha', tipo: 'date', obligatorio: '', opciones: '' },
                        { nombre: 'Necesidades', placeholder: 'Aquí escribe las necesidades', tipo: 'text', obligatorio: '', opciones: '' },
                        { nombre: 'Forma de pago preferido', placeholder: 'Selecciona la forma de pago preferido', tipo: 'select', obligatorio: '', opciones: 'Efectivo,Cheque,Transferencia bancaria' },
                        { nombre: 'Mensualidad que puede pagar', placeholder: 'Aquí escribe la mensualidad que puede pagar', tipo: 'string', obligatorio: '', opciones: ''}
                    ];

                    datosPreexistentes.forEach(campo => {
                        agregarCampo(campo.nombre, campo.placeholder, campo.tipo, campo.obligatorio, campo.opciones);
                    });
                }
            });

            $('#modalCampos').on('hidden.bs.modal', function() {
                isCreatingForm = false;
            });

            $('#addCampo').on('click', function() {
                agregarCampo();
            });

            $(document).on('change', '.tipoDato', function() {
                let tipoCampo = $(this).val();
                let opcionesContainer = $(this).closest('.campo-personalizado').find('.opciones-container');
                let opcionesInput = opcionesContainer.find('.opcionesCampo');

                if (tipoCampo === 'select') {
                    opcionesContainer.show();
                    opcionesInput.attr('required', true);
                } else {
                    opcionesContainer.hide();
                    opcionesInput.removeAttr('required');
                }
            });

            $(document).on('click', '.eliminarCampos', function() {
                $(this).closest('.campo-personalizado').remove();
            });
        });

    </script>
@endsection

