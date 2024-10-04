@extends('layouts.app')

@section('content')

        <style>
            #kanban-board {
                display: flex;
                overflow-x: auto;
                padding: 20px;
                gap: 20px;
            }
            .kanban-column {
                width: 400px;
                margin-right: 20px;
                min-height: 250px;
                background: linear-gradient(180deg, #ffffff, #f1f1f1);
                border-radius: 10px;
                padding: 5px;
                border: 2px solid #ddd;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: background 0.3s ease-in-out;
            }
            .kanban-column:hover {
                background: linear-gradient(180deg, #f7f7f7, #e1e1e1);
            }
            .kanban-column h3 {
                font-size: 1.4em;
                color: #333;
                padding: 10px;

            }
            .kanban-task {
                width: 100%;
                padding: 15px;
                margin-bottom: 5px;
                background-color: #ffffff;
                border: 2px solid #ddd;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s ease-in-out;
                cursor: move;
            }
            .kanban-task:hover {
                transform: scale(1.02);
            }
            .kanban-task p {
                margin: 0;
                font-size: 1em;
                color: #555;
            }
            .kanban-task strong {
                color: #333;
            }

            .dragging {
                opacity: 0.6;
                border: 2px dashed #ccc;
            }
        </style>

        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h2>{{$embudo->nombre}}</h2>
                </div>
                <div class="col-md-3">
                    <div class="mb-3" style="display: none">
                        <label for="id_embudo" class="form-label fw-bold mb-0">Embudos</label>
                        <select class="form-select " name="id_Embudo" id="id_Embudo">
                            @foreach ($embudos as $em)
                                <option value="{{ $em->id }}">{{ $em->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="botones text-end mb-3" style="display: none" id="prospectoBtn">
                <button class="btn btn-success" id="addBtn">Añadir prospecto</button>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="kanban-board" class="d-flex flex-row"></div>
                </div>
            </div>
        </div>

        <!-- Modal Prospecto-->
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width:80% !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="#" id="formAdd">
                                <div class="mb-3" style="display: none">
                                    <label for="id_prospectos_hidden" class="form-label fw-bold mb-0">id prospecto</label>
                                    <input type="hidden" class="form-control" name="id_prospectos_hidden" id="id_prospectos_hidden">
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label fw-bold mb-0">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aquí escribe el nombre del prospecto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label fw-bold mb-0">Celular</label>
                                    <input type="tel" class="form-control" name="telefono" id="telefono"
                                        placeholder="Aquí coloca el celular del prospecto" pattern="\d{10}"
                                        maxlength="10" oninput="validateTelefono(this)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold mb-0">Correo electrónico</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Aquí escribe el correo electrónico"
                                        oninput="validateCorreo(this)" required>
                                </div>
                            </form>
                            <form id="formNewData">

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer" id="footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="confi">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar-->
        <div class="modal fade" id="modalConfir" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seguro que deseas guardar al prospecto?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="addSave"
                            class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar los detalles del prospecto -->
        <div id="prospectoModal" class="modal fade" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Detalles del Prospecto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                        <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
                        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <div id="modalData">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="editBtn">Editar</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section("scripts")
    <script >

        function renderKanbanBoard(procesos) {
            let kanbanBoard = $("#kanban-board");
            kanbanBoard.empty();

            if (procesos.length === 0) {
                let noProcesosCard = `
                    <div class="kanban-column">
                        <div class="kanban-task">
                            <p>No hay ningún proceso creado o asignado a este embudo.</p>
                        </div>
                    </div>
                `;
                kanbanBoard.append(noProcesosCard);
            } else {
                procesos.sort((a, b) => a.orden - b.orden);

                procesos.forEach(proceso => {
                    let column = $(`<div class="kanban-column" data-proceso-id="${proceso.id}">
                                    <h3><b>${proceso.status}</b></h3>
                                    <div class="kanban-tasks"></div>
                                </div>`);

                    let tasksContainer = column.find('.kanban-tasks');

                    proceso.prospectos.forEach(prospecto => {
                        let formattedUpdatedDate = moment(prospecto.updated_at).format('DD/MM/YYYY');

                        let task = $(`<div class="kanban-task" data-id="${prospecto.id}">
                                        <div class="prospecto-header">
                                            <p><strong>${prospecto.nombre}</strong></p>
                                            <p><small>Última actualización: ${formattedUpdatedDate}</small></p>
                                        </div>
                                    </div>`);

                        task.on('click', () => {
                            $("#modalNombre").text(prospecto.nombre);
                            $("#modalTelefono").text(prospecto.telefono);
                            $("#modalEmail").text(prospecto.email);

                            let modalDataList = $("#modalData");
                            modalDataList.empty();

                            if (typeof prospecto.data === 'string') {
                                try {
                                    prospecto.data = JSON.parse(prospecto.data);
                                } catch (error) {
                                    console.error("Error al parsear los datos:", error);
                                    prospecto.data = {};
                                }
                            }

                            if (prospecto.data && typeof prospecto.data === 'object' && Object.keys(prospecto.data).length > 0) {
                                for (let key in prospecto.data) {
                                    if (prospecto.data.hasOwnProperty(key)) {
                                        let value = prospecto.data[key] || "No especificado";

                                        let regexFecha = /^\d{4}-\d{2}-\d{2}$/;
                                        if (regexFecha.test(value)) {
                                            let fecha = new Date(value);
                                            if (!isNaN(fecha.getTime())) {
                                                let options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                                                value = fecha.toLocaleDateString('es-ES', options);
                                            } else {
                                                value = "No especificado";
                                            }
                                        }

                                        modalDataList.append(`<p><strong>${key}:</strong> ${value}</p>`);
                                    }
                                }
                            } else {
                                modalDataList.append("<li>No hay datos adicionales disponibles.</li>");
                            }

                            $('#prospectoModal').modal('show');

                            $("#editBtn").data('prospecto_id', prospecto.id);
                        });

                        tasksContainer.append(task);
                    });

                    kanbanBoard.append(column);
                });
            }

            procesos.forEach(proceso => {
                let columnTasks = document.querySelector(`[data-proceso-id="${proceso.id}"] .kanban-tasks`);

                Sortable.create(columnTasks, {
                    group: "kanban",
                    animation: 150,
                    swapThreshold: 0.1,
                    dragoverBubble: true,
                    emptyInsertThreshold: 150,
                    onChoose: function(evt) {
                        evt.item.classList.add('dragging');
                    },
                    onUnchoose: function(evt) {
                        evt.item.classList.remove('dragging');
                    },
                    onEnd: function(evt) {
                        let oldProcesoId = evt.from.closest('.kanban-column').getAttribute('data-proceso-id');
                        let newProcesoId = evt.to.closest('.kanban-column').getAttribute('data-proceso-id');
                        let prospectoId = evt.item.getAttribute('data-id');

                        if (oldProcesoId !== newProcesoId) {
                            axios.post('/panel/prospecto/update-status', {
                                prospecto_id: prospectoId,
                                new_proceso_id: newProcesoId
                            })
                            .then(response => {
                                let newUpdatedAt = response.data.updated_at;

                                let formattedUpdatedDate = moment(newUpdatedAt).format('DD/MM/YYYY');

                                let movedProspecto = evt.item;

                                let fechaElemento = movedProspecto.querySelector('.prospecto-header small');
                                if (fechaElemento) {
                                    fechaElemento.textContent = `Última actualización: ${formattedUpdatedDate}`;
                                }
                            })
                            .catch(error => {
                                console.error('Error al actualizar el estado:', error);
                            });
                        }
                    }

                });
            });
        }

        function recargarKanban(id_embudo) {
            axios.get(`/panel/prospectos/${id_embudo}`).then((response) => {
                renderKanbanBoard(response.data);
                $("#addSave").prop("disabled", false);
            }).catch((error) => {
                console.error('Error al recargar el Kanban:', error);
                $("#addSave").prop("disabled", false);
            });
        }

        function cargarProspectos(embudoId) {
            axios.get(`/panel/prospectos/${embudoId}`)
                .then(function(response) {
                    let data = response.data;
                    renderKanbanBoard(data);
                    if (data && data.length > 0) {
                        $("#prospectoBtn").show();
                    } else {
                        $("#prospectoBtn").hide();
                    }
                })
                .catch(function(error) {
                    console.error('Error al cargar los procesos:', error);
                    $("#prospectoBtn").hide();
                });
        }

        function validateTelefono(input) {
            const pattern = /^\d{10}$/;

            if (!pattern.test(input.value)) {
                input.setCustomValidity("El número de celular debe ser de 10 dígitos sin espacios, guiones, letras, etc.");
            } else {
                input.setCustomValidity("");
            }
        }

        function validateCorreo(input) {
            let email = input.value;

            axios.post('/prospectos/emailUsers', {
                    email: email
                })
                .then(function(response) {
                    if (response.data.exists) {
                        input.setCustomValidity("Ya existe un usuario que posee este correo, pruebe con otro.");
                    } else {
                        input.setCustomValidity("");
                    }

                    input.reportValidity();
                })
                .catch(function(error) {
                    console.error("Error al verificar el correo:", error);
                    input.setCustomValidity("Hubo un problema al verificar el correo. Inténtelo de nuevo.");
                    input.reportValidity();
                });
        }

        function formAddNew(embudo) {
            let formHtml = '';

            let campos = JSON.parse(embudo.formulario);

            campos.forEach((campo, index) => {
                let fieldHtml = '';

                switch (campo.type) {
                    case 'text':
                    case 'number':
                    case 'date':
                        fieldHtml = `
                            <div class="mb-3">
                                <label for="campo_${campo.input}" class="form-label fw-bold mb-0">${campo.input}</label>
                                <input type="${campo.type}" class="form-control" name="${campo.input}" id="campo_${campo.input}"
                                    placeholder="${campo.placeholder}" ${campo.prop === 'required' ? 'required' : ''}>
                            </div>
                        `;
                        break;
                    case 'select':
                        let options = campo.options ? campo.options.split(',').map(opt => `<option value="${opt.trim()}">${opt.trim()}</option>`).join('') : '';
                        fieldHtml = `
                            <div class="mb-3">
                                <label for="campo_${campo.input}" class="form-label fw-bold mb-0">${campo.input}</label>
                                <select class="form-select" name="${campo.input}" id="campo_${campo.input}" ${campo.prop === 'required' ? 'required' : ''}>
                                    <option value="" selected disabled>${campo.placeholder}</option>
                                    ${options}
                                </select>
                            </div>
                        `;
                        break;
                    case 'string':
                        fieldHtml = `
                            <div class="mb-3">
                                <label for="campo_${campo.input}" class="form-label fw-bold mb-0">${campo.input}</label>
                                <input type="text" class="form-control currency-input" name="${campo.input}" id="campo_${campo.input}"
                                    placeholder="${campo.placeholder}" ${campo.prop === 'required' ? 'required' : ''}>
                            </div>
                        `;
                        break;
                    default:
                        console.error('Tipo de campo no soportado:', campo.type);
                        break;
                }

                formHtml += fieldHtml;
            });

            if (formHtml) {
                $("#formNewData").html(formHtml);

                $('.currency-input').on('blur', function() {
                    let value = $(this).val();
                    let formattedValue = currency(value, { precision: 0 }).format();
                    $(this).val(formattedValue);
                });

                $('.currency-input').on('input', function() {
                    let value = $(this).val().replace(/[^0-9]/g, '');
                    $(this).val(value);
                });
            }
        }
    </script>

    <script type="module" >

        $(document).ready(function() {
            if ($("#id_Embudo").length) {
                let pathArray = window.location.pathname.split('/');
                let embudoId = pathArray[pathArray.length - 1];

                if (embudoId) {
                    $("#id_Embudo").val(embudoId).trigger('change');
                    cargarProspectos(embudoId);
                } else {
                    console.error('No se pudo obtener el ID del embudo de la URL.');
                }

                $("#id_Embudo").on('change', function() {
                    let selectedEmbudoId = $(this).val();
                    if (selectedEmbudoId) {
                        cargarProspectos(selectedEmbudoId);
                    }
                });
            } else {
                console.error("El elemento con ID 'id_Embudo' no existe en el DOM.");
            }
        });

        $("#addBtn").click(() => {
            $("#formAdd").trigger("reset");
            $("#formNewData").empty();

            $("#modalTitleId").html("Añadir prospecto");
            $("#modalAdd").modal("show");

            let embudoId = $("#id_Embudo").val();

            if (embudoId) {
                axios.get(`/embudos/${embudoId}`)
                    .then(response => {
                        const data = response.data;
                        if (data.formulario && data.formulario.trim() !== '') {
                            formAddNew(data);
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los datos del embudo:', error);
                    });
            }
        });

        $("#confi").click(function() {

            let form1 = document.getElementById("formAdd");
            let form2 = document.getElementById("formNewData");

            if (!form1.checkValidity()) {
                form1.reportValidity();
                return;
            }
                 if (!form2.checkValidity()) {
                form2.reportValidity();
                return;
            }

            $("#modalConfir").modal("show");
            $("#modalAdd").modal("hide");
        });

        $("#addSave").click(function(e) {
            e.preventDefault();
            const button = $(this);
            button.prop("disabled", true);

            let form1 = document.getElementById("formAdd");
            let form2 = document.getElementById("formNewData");

            if (!form1 || !form2) {
                console.error("Formulario(s) 'formAdd' o 'formNewData' no encontrado(s).");
                button.prop("disabled", false);
                return;
            }

            if (!form1.checkValidity()) {
                form1.reportValidity();
                setTimeout(() => { button.prop("disabled", false); }, 2000);
                return;
            }
            if (!form2.checkValidity()) {
                form2.reportValidity();
                setTimeout(() => { button.prop("disabled", false); }, 2000);
                return;
            }

            const data = new FormData(form1);
            let newDataObj = {};
            const formData2 = new FormData(form2);
            formData2.forEach((value, key) => {
                newDataObj[key] = value;
            });
            data.append('data', JSON.stringify(newDataObj));

            let id_embudo = $("#id_Embudo").val();
            data.append('id_embudo', id_embudo);

            const dt = $("#prospectosTabla").DataTable();

            if ($("#formAdd").data("update") == 1) {
                let id = $("#id_prospectos_hidden").val();
                data.append("_method", "PUT");
                $("#modalAdd").modal("hide");
                $("#modalConfir").modal("hide");
                $("#formAdd").trigger("reset");
                $("#formNewData").trigger("reset");

                axios.post("/prospectos/" + id, data)
                    .then((e) => {
                        dt.ajax.reload();
                        recargarKanban(id_embudo);
                    })
                    .catch((e) => {
                        button.prop("disabled", false);
                    });
            } else {
                axios.post("/prospectos", data)
                    .then((e) => {
                        $("#modalAdd").modal("hide");
                        $("#modalConfir").modal("hide");
                        $("#formAdd").trigger("reset");
                        $("#formNewData").trigger("reset");
                        $("#noFormulario").hide();
                        recargarKanban(id_embudo);
                    })
                    .catch((e) => {
                        button.prop("disabled", false);
                    });
            }
        });

        $("#editBtn").click(() => {
            $("#prospectoModal").modal("hide");

            $("#formAdd").trigger("reset");
            $("#formNewData").empty();
            $("#modalTitleId").html("Editar prospecto");
            $("#modalAdd").modal("show");

            let embudoId = $("#id_Embudo").val();
            if (embudoId) {
                axios.get(`/embudos/${embudoId}`)
                    .then(response => {
                        const data = response.data;
                        if (data.formulario && data.formulario.trim() !== '') {
                            formAddNew(data);
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los datos del embudo:', error);
                    });
            }

            $("#formAdd").data("update", 1);
            let id_prospecto = $("#editBtn").data('prospecto_id');
            $("#id_prospectos_hidden").val(id_prospecto);

            if (id_prospecto) {
                setTimeout(() => {
                    axios.get(`/prospectos/${id_prospecto}`)
                        .then(response => {
                            const data = response.data;

                            $("#nombre").val(data.nombre);
                            $("#email").val(data.email);
                            $("#telefono").val(data.telefono);

                            let additionalData = data.data;

                            if (typeof additionalData === 'string') {
                                try {
                                    additionalData = JSON.parse(additionalData);
                                } catch (error) {
                                    console.error('Error al parsear data.data:', error);
                                    return;
                                }
                            }

                            if (additionalData && typeof additionalData === 'object') {
                                for (let key in additionalData) {
                                    if (additionalData.hasOwnProperty(key)) {
                                        let value = additionalData[key] || '';

                                        let input = $(`#campo_${key.replace(/ /g, "\\ ")}`);

                                        if (input.length) {
                                            if (input.is('select')) {
                                                input.val(value);
                                                input.change();
                                            } else {
                                                input.val(value);
                                            }
                                        } else {
                                        }
                                    }
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error al cargar los datos del prospecto:', error);
                        });
                }, 100);
            }
        });

    </script>
@endsection

