@extends('layouts.app')

@section('content')

<style>
        .fc {
            background-color: white; /* Fondo del calendario */
        }
        .fc-daygrid-day-number {
            color: black !important; /* Color de los números de los días */
        }
        .fc-col-header-cell-cushion {
            color: black !important; /* Color del texto en los encabezados de las columnas */
        }
        .fc-day {
            background-color: #fff !important; /* Fondo de los días */
            border: 1px solid #f0e68c !important; /* Borde sutil en amarillo */
        }
        .fc-event {
            background-color: #fce6b2; /* Color de fondo de los eventos */
            border: 1px solid #f0b500; /* Borde de los eventos */
            color: #333; /* Color del texto de los eventos */
        }
        .fc-event-title,
        .fc-sticky,
        .fc-event-time {
            color: black !important; /* Color negro para el texto dentro del evento */
        }
        .fc-event:hover {
            background-color: #f0b500; /* Color de fondo al pasar el ratón */
            color: white; /* Color del texto al pasar el ratón */
        }
        .fc-button {
            background-color: black; /* Color de fondo de los botones */
            color: white; /* Color del texto de los botones */
            border: none; /* Sin borde */
        }
        .fc-button:hover {
            background-color: #444; /* Color de fondo al pasar el ratón */
            color: white; /* Color del texto al pasar el ratón */
        }

        .list-unstyled {
            padding-left: 0; /* Sin sangría a la izquierda */
            list-style-type: disc; /* Tipo de viñeta: disc, circle, square, etc. */
        }

        .list-unstyled li {
            margin-bottom: 5px; /* Espacio entre los elementos de la lista */
        }

        .multiselect-container.dropdown-menu.show {
            width: 100% !important; /* Asegura que el menú desplegable ocupe todo el ancho */
            min-width: 300px; /* Ajusta el ancho mínimo, o personalízalo según tus necesidades */
            max-width: 100%; /* Evita que el menú se expanda más allá del contenedor */
        }

        .multiselect-container.dropdown-menu.show li {
            width: 100%; /* Cada opción dentro del dropdown ocupa todo el ancho */
        }

        .multiselect.dropdown-toggle.btn {
            border: 1px solid #ced4da; /* Cambia este color al que prefieras */
            box-shadow: none; /* Elimina cualquier sombra si no es deseada */
        }

        .multiselect.dropdown-toggle.btn:focus {
            box-shadow: none; /* Elimina la sombra cuando el botón esté en foco */
            border-color: #80bdff; /* Puedes personalizar el borde en foco también */
        }
</style>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="d-flex mb-2 justify-content-between">
                        <h1>Tareas</h1>
                        <div class="botones">
                            <button class="btn btn-primary" id="calendarioBtn">Calendario</button>
                            <button class="btn btn-primary" style="display: none" id="tablaBtn">Tabla</button>
                            <button class="btn btn-success" id="addBtn">Añadir Tarea</button>
                        </div>
                    </div>

                    <div>
                        <br></br>
                    </div>

                    <!-- tabla -->
                    <div class="table-responsive" id="tableView">
                        <table class="table table-primary text-center" id="calentarioTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">id</th>
                                    <th scope="col" class="text-center">Tarea</th>
                                    <th scope="col" class="text-center">Vendedores asignados</th>
                                    <th scope="col" class="text-center">Descripción</th>
                                    <th scope="col" class="text-center">Fecha de inicio</th>
                                    <th scope="col" class="text-center">Fecha final</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- calendario -->
                    <div id="calendarView" style="display: none">
                        <div id="calendar"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal tarea-->
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
                                        <label for="vendedores" class="form-label fw-bold mb-0">Vendedores que realizarán la tarea</label>
                                        <select id="vendedores" name="vendedores[]" multiple required class="form-control">
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nombre" class="form-label fw-bold mb-0">Nombre de la tarea</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aquí escribe el nombre de la tarea" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label fw-bold"> Descripción de la tarea</label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" maxlength="500" oninput="adjustTextarea(this)" placeholder="Aquí describe la tarea" required></textarea>
                                        <small class="form-text text-muted">Máximo 500 caracteres.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_inicio" class="form-label fw-bold mb-0">Fecha y hora de inicio</label>
                                        <input type="datetime-local" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Selecciona la fecha y la hora de inicio" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecha_fin" class="form-label fw-bold mb-0">Fecha y hora límite</label>
                                        <input type="datetime-local" class="form-control" name="fecha_fin" id="fecha_fin"  placeholder="Selecciona la fecha y la hora limite" required>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button class="btn btn-secondary" id="addBtnRecu">Es una tarea que se repite?</button>
                                    </div>
                                    <div id="recursiones" style="display: none">
                                        <div class="mb-3">
                                            <br><br>
                                            <h5>Tareas recurrentes</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="repeticion" class="form-label fw-bold mb-0">Cada cuando se debe repetir</label>
                                            <select class="form-select" name="repeticion" id="repeticion">
                                                <option value="" selected disabled>Selecciona cada cuando se debe repetir</option>
                                                <option value="1">Diariamente</option>
                                                <option value="7">Semanal </option>
                                                <option value="30">Mensualmente</option>
                                                <option value="365">Anualmente</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fecha_fin_recursion" class="form-label fw-bold mb-0">Hasta cuando se debe repetir</label>
                                            <br>
                                            <input type="datetime-local" class="form-control" name="fecha_fin_recursion" id="fecha_fin_recursion"  placeholder="Selecciona la fecha">
                                        </div>

                                        <div id="alertContainer" style="display:none;" class="alert alert-info" role="alert"></div>

                                    </div>

                                </form>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="confi">Guardar</button>
                        </div>

                </div>
            </div>
        </div>

        <!-- Modal tarea Confirmar-->
        <div class="modal fade" id="modalConfir" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalConfirTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Seguro que deseas generar esta tarea?
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="addSave" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal tarea Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalDeleteTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <a>
                            Seguro que deseas Eliminar la tarea?
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>


<script>
</script>


@endsection

@section("scripts")
    <script >

        function adjustTextarea(el) {
            el.style.height = "auto";
            el.style.height = (el.scrollHeight) + "px";
        }

        function cargarVendedores() {
            $.ajax({
                url: '/info/vendedores',
                method: 'GET',
                success: function(data) {
                    let selectVendedores = $('#vendedores');
                    selectVendedores.empty();

                    $('#vendedores').empty();

                    data.forEach(function(vendedor) {
                        let optionText = vendedor.nombre.trim() + ' / ' + vendedor.email.trim();
                        selectVendedores.append(new Option(optionText, vendedor.id));
                    });

                    selectVendedores.multiselect('rebuild');
                },
                error: function(error) {
                    console.error('Error al cargar los vendedores:', error);
                }
            });
        }

        let calendar;

        function initCalendar() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'es',
                editable: true,
                selectable: true,
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '/eventos',
                        dataType: 'json',
                        data: {
                            start: fetchInfo.startStr,
                            end: fetchInfo.endStr
                        },
                        success: function(data) {
                            successCallback(data);
                        },
                        error: function() {
                            failureCallback();
                        }
                    });
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                allDayText: 'hora del dia',
                noEventsText: 'No hay eventos para mostrar'
            });

            calendar.render();
        }

        const editTarea = (id) =>{
            let tarea;
            cargarVendedotes();

            axios.get("calendarioTareas/" + id).then(data => {
                tarea = data.data;
                if(tarea==undefined){return}
                $("#id").val(tarea.id);
                $("#vendedor").val(tarea.id_vendedor);
                $("#nombre").val(tarea.nombre_tarea);
                $("#descripcion").val(tarea.descripcion_tarea);
                $("#fecha_inicio").val(tarea.fecha_inicio);
                $("#fecha_fin").val(tarea.fecha_fin);


                $("#formAdd").data("update",1);
                $("#formAdd").data("id",tarea.id);
                $("#modalTitleId").html("Editar tarea "+ tarea.nombre)
                $("#modalAdd").modal("show");
            });
        }

        const deleteTarea=(id)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar tarea");
        }

    </script>

    <script type="module" >

        // tabla principal
        $(document).ready(() => {
            let calentarioTable = $("#calentarioTable").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('tablas/calendarioTareas') }}",
                    "type": "GET"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "nombre_tarea" },
                    { "data": "vendedores" },
                    { "data": "descripcion_tarea" },
                    { "data": "fecha_inicio" },
                    { "data": "fecha_fin" },
                    { "data": "acciones", "orderable": false, "searchable": false }
                ]
            });
        });

        $(document).ready(()=>{
            $('#vendedores').multiselect({
                nonSelectedText: 'Seleccionar vendedores',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '100%',
                includeSelectAllOption: true,
                selectAllText: 'Seleccionar todos',
                filterPlaceholder: 'Buscar...',
                allSelectedText: 'Todos seleccionados',
                nSelectedText: 'Seleccionados'
            });
            cargarVendedores();
        });

        $("#calendarioBtn").click(function() {

            $("#calendarView").show();
            $("#tableView").hide();

            $("#tablaBtn").show();
            $("#calendarioBtn").hide();
            initCalendar();
        });

        $("#tablaBtn").click(function() {
            $("#calendarView").hide();
            $("#tableView").show();

            $("#tablaBtn").hide();
            $("#calendarioBtn").show();
        });

        $("#addBtn").click(() => {
            $("#recursiones").hide();
            $("#repeticion").prop("required", false);
            $("#fecha_fin_recursion").prop("required", false);
            $('#vendedores').empty();
            cargarVendedores();

            $("#formAdd").trigger("reset");
            $("#modalTitleId").html("Agregar una tarea");
            $("#modalAdd").modal("show");
            $("#formAdd").data("update", 0);
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

        $("#addSave").click(function (e) {
            e.preventDefault();
            $("#addSave").prop("disabled", true);
            let form = document.getElementById("formAdd");

            if (!form.checkValidity()) {
                form.reportValidity();
                $("#addSave").prop("disabled", false);
                return;
            }

            const data = new FormData(form);
            const dt = $(".table").DataTable();

            const id = $("#formAdd").data("id");
            if (id) {
                data.append("_method", "PUT");
                axios.post("calendarioTareas/" + id, data).then((response) => {
                    $("#modalConfir").modal("hide");
                    $("#formAdd").trigger("reset");
                    dt.ajax.reload();
                    $("#addSave").prop("disabled", false);
                    if (typeof calendar !== 'undefined') {
                        calendar.refetchEvents();
                    }
                }).catch((error) => {
                    console.log(error);
                    $("#addSave").prop("disabled", false);
                });
            } else {
                axios.post("calendarioTareas", data).then((response) => {
                    $("#modalConfir").modal("hide");
                    $("#formAdd").trigger("reset");
                    dt.ajax.reload();
                    $("#addSave").prop("disabled", false);
                    if (typeof calendar !== 'undefined') {
                        calendar.refetchEvents();
                    }
                }).catch((error) => {
                    console.log(error);
                    $("#addSave").prop("disabled", false);
                });
            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const dt = $("#calentarioTable").DataTable();

            const id = $("#modalDelete").data("id");

            axios.delete("calendarioTareas/" + id).then((response) => {
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id", "");

                dt.ajax.reload(null, false);

                if (typeof calendar !== 'undefined') {
                    calendar.refetchEvents();
                }
            }).catch((error) => {
                console.error("Error al eliminar la tarea:", error);
            });
        });

        $(document).ready(function() {

            // Mostrar el campo de recursión cuando el botón "Es una tarea que se repite?" sea clickeado
            $("#addBtnRecu").on('click', function(event) {
                event.preventDefault();
                $("#recursiones").toggle(); // Muestra o esconde el bloque de recursión
            });

            // Función para ajustar la hora de la fecha fin de recurrencia
            function ajustarHoraFechaFinRecursion(fechaRecursion) {
                if (fechaRecursion.getHours() === 0 && fechaRecursion.getMinutes() === 0 && fechaRecursion.getSeconds() === 0) {
                    fechaRecursion.setHours(23, 59, 59); // Si no se especificó hora, ponemos 23:59:59
                }
                return fechaRecursion;
            }

            // Función para calcular la recurrencia basándose en la frecuencia seleccionada
            function calcularRepeticiones() {
                const fechaInicio = new Date($("#fecha_inicio").val());
                let fechaFinRecursion = new Date($("#fecha_fin_recursion").val());
                const repeticion = parseInt($("#repeticion").val());

                // Ajustar la fecha de fin de recurrencia al final del día si no se especifica hora
                fechaFinRecursion = ajustarHoraFechaFinRecursion(fechaFinRecursion);

                // Validación de fechas y frecuencia
                if (!isNaN(fechaInicio.getTime()) && !isNaN(fechaFinRecursion.getTime()) && repeticion) {
                    let cantidadRepeticiones = 0;
                    let siguienteFecha = new Date(fechaInicio);

                    while (siguienteFecha <= fechaFinRecursion) {
                        cantidadRepeticiones++;
                        siguienteFecha.setDate(siguienteFecha.getDate() + repeticion);
                    }

                    // Mostrar el resultado o alertar al usuario
                    if (cantidadRepeticiones > 1) {
                        $("#alertContainer").text(`La tarea se repetirá ${cantidadRepeticiones} veces hasta el ${fechaFinRecursion.toLocaleString()}`).show();
                    } else {
                        $("#alertContainer").text(`No hay repeticiones para la fecha seleccionada.`).show();
                    }
                }
            }

            // Evento cuando se selecciona el botón de guardar
            $("#confi").on('click', function() {
                calcularRepeticiones(); // Llama a la función de cálculo cuando se guarda
            });
        });


    </script>
@endsection

