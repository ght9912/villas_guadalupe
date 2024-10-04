    @extends('layouts.app')

@section('content')
<!-- Tabla -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Administrador de proyectos</h1>
                <button class="btn btn-success fw-bold" id="btnAdd">
                    Añadir proyecto
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-primary" id="mainTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Proyecto</th>
                            <th scope="col">Clave</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Ubicación</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Creado por:</th>
                            <th scope="col" style="text-align:center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proyecto as $p)
                        <tr>
                            <td style="font-size: small;">{{$p->id}}</td>
                            <td class="text-center"><div class="btn btn-primary btn-sm" onclick="ver({{ $p->id }},this)"><em>{{$p->nombre}}</em></div></td>
                            <td style="font-size: small;">{{$p->clave}}</td>
                            <td style="font-size: small;">{{$p->descripcion}}</td>
                            <td style="font-size: small;">{{$p->ubicacion}}</td>
                            <td style="font-size: small;">{{$status[$p->estado]}}</td>
                            <td style="font-size: small;">{{$p->user->name}}</td>
                            <td class="text-center">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-info btn-sm me-1 fw-bold" onclick="imagenesProyecto({{ $p->id }},this)">
                                        Detalles del proyecto
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editProyecto({{ $p->id }},this)">
                                        Editar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="borrarProyecto({{ $p->id }},this)">
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
<!-- Modal ver, crear y editar -->
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="mainModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" aria-hidden="true" style="max-width:90% !important;">
        <div class="modal-content">
            <div class="modal-header sticky-top bg-light">
                <h3 class="modal-tittle fw-bold" id="mainModalTitle">Nuevo proyecto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="formVer" >
                        <div class="row row-proyecto"> <!-- información  inicial-->
                            <div class="col-lg-6" id="left-col"> <!-- Datos no gráficos-->
                                <div class="d-none">
                                    <label for="user_id" class="form-label fw-bold">Id de usuario</label>
                                    <input type="text" name="user_id" id="user_id" class="form-control reset update disableOnStore">
                                </div>

                                <div class="">
                                    <label for="user_name" class="form-label fw-bold">Nombre de usuario creador</label>
                                    <input type="text" name="user_name" id="usuario" class="form-control reset see update">
                                </div>

                                <div class="d-none">
                                    <label for="id" class="form-label fw-bold mb-0">Id de proyecto</label>
                                    <input readonly type="text" name="id" id="idProyecto" class="form-control reset create update">
                                </div>

                                <div class="row"><!--Nombre y clave-->
                                    <div class="col-10">
                                        <label for="nombre" class="form-label fw-bold mb-0">Proyecto</label>
                                        <input required type="text" name="nombre" id="project-name" placeholder="Nombre del proyecto" class="form-control reset create editable update">
                                    </div>
                                    <div class="col-2">
                                        <label for="clave" class="form-label fw-bold mb-0">Clave</label>
                                        <input required type="text" name="clave" id="project-clave" maxlength="5" title="Un acrónimo de entre 3 y 5 caracteres" class="form-control reset create editable update flagable">
                                    </div>
                                </div>

                                <label for="descripcion" class="form-label fw-bold mb-0">Descripción</label>
                                <input required type="text" name="descripcion" id="description" placeholder="Breve descripción del proyecto" class="form-control reset create editable update ">

                                <label for="enanjenante" class="form-label fw-bold mb-0" placeholder="Enajenante del predio">Enajenante</label>
                                <input required type="text" name="enajenante" id="enajenante" placeholder="Enajenante del predio" class="form-control create reset editable update">

                                <label for="estado" class="form-label fw-bold mb-0">Estado actual del proyecto:</label>
                                <select required name="estado" id="project-status" class="form-select mb-0 mt-0 reset editable update flagable">
                                    <option value="0">No disponible</option>
                                    <option value="1" selected>Ventas abiertas</option>
                                    <option value="2">Terminado</option>
                                </select>

                                <div class="row mt-1 sTSee hideToCreate showOnStore"> <!-- Etapas y lotes-->
                                    <div class="col-6">
                                        <label for="etapas" class="form-label fw-bold mb-0">Zonas del proyecto:</label>
                                        <input readonly type="number" name="etapas" id="etapas" class="form-control reset"  min=0 placeholder="Todavía no se crean etapas" step="0.01">
                                    </div>
                                    <div class="col-6">
                                        <label for="lotes" class="form-label fw-bold mb-0">Lotes del proyecto:</label>
                                        <input readonly type="text" name="lotes" id="lotes" class="form-control reset" min=0 placeholder="Todavía no se capturan lotes">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-6" id="right-col"> <!-- Portada y ubicación-->
                                <div class="row">
                                    <label for="portada" class="form-label fw-bold mb-0">Portada</label>
                                    <div>
                                        <img id="imgPortada" class="img-fluid create see" alt="Portada del proyecto no disponible">
                                        <input type="file" name="portada" id="portada" placeholder="Portada del proyecto" class="form-control reset flagable">
                                        <button id="btnDelPortada" onclick="delPortada()" class="btn btn-danger float-end my-2">Eliminar portada</button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <label for="ubicacion" class="form-label fw-bold mb-0">Ubicación:</label>
                                    <div class="col-10 mx-0">
                                        <input required type="text" name="ubicacion" id="ubicacion" pattern="^((\-?|\+?)?\d+(\.\d+)?),\s*((\-?|\+?)?\d+(\.\d+)?)$" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000" class="form-control mb-2 mt-0 reset create editable update flagable geo">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" id="btnGo" title="Ver en Google Maps" class="btn btn-primary btn-sm fw-bold see edit">Ver...</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4" id="importacion"> <!-- Importación de lotes y etapas desde un archivo.-->
                            <div class="row">
                                <h5 id="importTitle"><b>Importar lotes y manzanas</b></h5>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-8">
                                    <h6 class="mb-1">Aquí se puede importar información de lotes ya contenida en un archivo de Excel.</h6>
                                    <p class="mb-1">Es necesario vaciar los datos a importar en el archivo de Excel que se puede descargar desde <a href="{{ asset('form_import_to_new_project.xlsx') }}" download class="btn btn-primary btn-sm fw-bold">aquí</a>.</p>
                                    <p class="mb-1">Una vez que se hayan llenado los datos, se puede proceder a cargar el archivo del que se van a extraer los datos...</p>
                                    <label for="importFile" class="form-label fw-bold mb-0">Archivo</label>
                                    <input disabled type="file" name="importFile" id="importFile"  class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 edit" id="adiciones"> <!-- Adición de etapas y lotes-->
                            <div class="row px-1 mx-1">
                                <p><b>Nota:</b> Los lotes aquí creados solo cubren los requisitos mínimos para agregarlos al listado. Los datos de venta, así como las dimensiones, colindancias y ubicaciones han de ser llenados desde su tabla correspondiente.</p>
                            </div>
                            <div class="row px-1 mx-1 my-2" id="addZoneCtrl">
                                <div class="col-md-2 fw-bold">
                                    <h5>Agregar zonas (<span Title="Conteo de zonas agregadas en el formulario." class="resetToCreate" id="eCount" value=0></span>)</h5>
                                </div>
                                <div class="col-auto">
                                    <span class="fw-bold">Agregar </span>
                                </div>
                                <div class="col-auto">
                                    <input type="number" name="addnZonas" id="addnZonas" class="form-control form-control-sm" min=0 placeholder="No. de zonas">
                                </div>
                                <div class="col-auto">
                                    <span class="fw-bold"> zonas  </span>
                                    <button type="button" class="btn btn-success fw-bold btn-sm" id="btnAddEtapa" title="Agrega una zona a la vez si no indica un número específico.">Agregar</button>
                                </div>
                            </div>
                            <div class="row mb-2 mx-1" name="newEtapas" id="newEtapas">
                            </div>
                            <br/><br/>
                            <div class="row px-1 mx-1 my-2" id="addLoteCtrl">
                                <div class="col-md-2 fw-bold">
                                <h5>Agregar lotes (<span class="resetToCreate" id="loteCount" value=0 Title="Conteo de zonas agregadas en el formulario."></span>)</h5>
                                </div>
                                    <div class="col-auto">
                                        <span class="fw-bold">Agregar </span>
                                    </div>
                                    <div class="col-auto">
                                        <input type="number" name="addnLotes" id="addnLotes" class="form-control form-control-sm" min=0 placeholder="No. de lotes">
                                    </div>
                                    <div class="col-auto">
                                        <span class="fw-bold"> lotes a la zona </span>
                                    </div>
                                    <div class="col-auto">
                                        <select name="zoneToAdd" id="zoneToAdd" class="form-select form-select-sm" title="Es necesario especificar a cuál zona se agregan los lotes.">
                                            <option value="0" selected>A ninguna</option>
                                        </select>
                                    </div>
                                <div class="col-auto">
                                    <button disabled type="button" class="btn btn-success fw-bold btn-sm " id="btnAddLote">Agregar</button>
                                </div>
                            </div>
                            <div class="row mb-2" name="newlotes" id="newLotes">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" id="footer"> <!-- Botones-->
                <button type="button" id="btnEditar" Title="Editar datos del proyecto." class="btn btn-warning fw-bold see">Editar</button>
                <button type="button" id="btnEliminar" title="Eliminar el proyecto, así como las zonas y lotes asociados." class="btn btn-danger see fw-bold">Eliminar</button>
                <button type="button" id="btnImport" title="Importar lotes y manzanas desde un archivo de excel." class="btn btn-primary create">Importar lotes y manzanas</button>
                <button type="button" id="btnSaveProject" title="Guardar el proyecto" class="btn btn-success create">Guardar proyecto</button>
                <button type="button" id="btnSaveChanges" title="Guardar los cambios en la información del proyecto." class="btn btn-primary reset edit">Guardar cambios</button>
                <button type="button" id="btnSaveAddings" title="Guardar los cambios en la información del proyecto." class="btn btn-primary add">Guardar cambios</button>
                <button type="button" id="btnDismiss" data-bs-dismiss="modal" title="Los lotes y zonas creados, así como los cambios no guardados del proyecto se eliminarán." class="btn btn-danger edit">Descartar y cerrar</button>
                <button type="button" id="btnCerrar" data-bs-dismiss="modal" class="btn btn-secondary fw-bold reset see create">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal borrar -->
<div class="modal fade" id="modalBorrar" tabindex="-1" role="dialog" aria-labelledby="modalBorrarTitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBorrarTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este proyecto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")

<script>

    const mainData = {{ Js::from($proyecto)}};
    const mainResources = {{ Js::from($recursos)}};
    const user = {{JS::from(Auth::user())}};
    const etapas = mainResources.etapas;
    const lotes = mainResources.lotes;
    const projectStatus = {
        0 : 'No disponible',
        1 : 'Ventas abiertas',
        2 : 'Terminado'
    };

    //* Reinicia las configuraciones de los inputs y elementos del formulario.
    const resetModal = function () {
        $("#mainModalTitle").html('');
        $("select").prop("disabled",false);
        $("input.reset").val('');
        $("select.reset option[value=0]").prop("selected",true);
        $("#formVer").data("update",0);
        $("#formVer").data("borraPortada",false);
        $("#footer button, #btnDelPortada, #adiciones, #btnGo").prop("hidden",true);
        $(".watch").removeClass("watch");
        $("#portada").removeClass("update");
        $(".newEContainer, .newLoteCont, .zoneForm, .zoneRow, .row-lote, .zonesContainer, .nestedLoteCont").remove();
        $("select, :file").prop("disabled",true);
        $(":text").prop("readonly",true);
        $("#importacion").prop("hidden",false);
        $("#addLoteCtrl").prop("hidden",false);
        $("#newEtapas").prop("hidden",false)
        $("#addZoneCtrl").prop("hidden",false);
        $("#newLotes").prop("hidden",false)
        $("#adiciones").prop("hidden",true);
    };

    //* Busca el proyecto por su id en la data del view.
    const findProject = (id) => {
        let el;
        mainData.every((e) => {
            if(e.id == id) {
                el = e;
                return false;
            }
            return true;
        });
        return el;
    };

    //* Coloca los datos del proyecto en cada uno de los inputs correspondientes.
    const setInputsData = async function (data) {
        console.log(data);
        const idP = data.id;
        const usuario = mainResources.usuario.find(i => i.id == data.user_id);
        const etapas = await getZones(idP);
        const lotes = await getLotes(idP);
        $("select").prop("disabled",false);
        $("#user_id").val(data.user_id);
        $("#usuario").val(usuario.name);
        $("#idProyecto").val(data.id);
        $("#project-name").val(data.nombre);
        $("#project-clave").val(data.clave);
        $("#description").val(data.descripcion);
        $("#enajenante").val(data.enajenante);
        $(`#project-status option[value=${data.estado}]`).prop("selected",true);
        $("#etapas").val(etapas.length > 0 ? etapas.length : '');
        $("#lotes").val(lotes);
        $("#ubicacion").val(data.ubicacion);
        if(data.portada) {
            $("#imgPortada").attr("src","/storage/"+data.portada);
            $("#imgPortada").prop("hidden",false);
            $("#imgPortada").addClass("hasFile");
        }
        $("select").prop("disabled",true);
    };

    //* Abre el modal y carga los datos del proyecto seleccionado en el formulario para verlos.
    const ver = async (id,el) => {
        //*Procesos preliminares
        const proyecto = findProject(id);
        if(proyecto == undefined){return}
        $("#mainModal").modal("show");
        resetModal();
        $("#mainModalTitle").html(`Vista del proyecto: <b>${proyecto.nombre}</b>`);
        setToSee();
        $("select").prop("disabled",false);
        setInputsData(proyecto);
        $("#project-status").prop("disabled",true);
    };

    //* Consulta las zonas asociadas al proyecto en la base de datos.
    const getZones = (id) => {
        return axios.get("etapas/projectEtapas/"+id).then((e) => {
            const response = e.data.data;
            return response;
        }).catch((e) => {
            console.log(e);
        });
    };

    //* Consulta los lotes asociados al proyecto en la base de datos.
    const getLotes = (id) => {
        return axios.get("lotes/projectLotes/"+id).then((e) => {
            const response = e.data.data;
            // console.log(e.data.message);
            return response;
        }).catch((e) => {
            console.log(e['message']);
        });
    };

    //* Cambia las configuraciones de los inputs y elementos del formulario para crear un nuevo proyecto.
    const setToCreate = () => {
        $("#mainModalTitle").html('Nuevo proyecto');
        $("#user_id").val(user.id);
        $("#usuario").val(user.name);
        $("button.create").prop("hidden",false);
        $(":text.create").prop("readonly",false);
        $("select, :file").prop("disabled",false);
        $("#project-status option[value=1]").prop("selected",true);
        $("#imgPortada").prop("alt","No se ha elegido portada.");
        $("#imgPortada").prop("hidden",true);
        $("#importacion").prop("hidden",true);
        $("#btnSaveProject").prop("disabled",false);
    };

    //* Cambia las configuraciones de los inputs y elementos del formulario tras guardar el proyecto.
    const setOnStore = () => {
        $("button.create, #btnDelPortada, #portada").prop("hidden",true);
        $("button.see, #btnGo").prop("hidden",false);
        $(":text, input [type='number']").prop("readonly",true);
        $("select").prop("disabled",true);
    };

    //* Cambia las configuraciones de los inputs y elementos del formulario para ver el proyecto.
    const setToSee = () => {
        $("button.see").prop("hidden",false);
        $(":file").prop("hidden",true);
        $("#importacion").prop("hidden",true);
    };

    //* Cambia las configuraciones de los inputs y elementos del formulario para editar el proyecto.
    const setToEdit = () => {
        $(":text.editable").prop("readonly",false);
        $("select, :file").prop("disabled",false);
        $(".flagable").addClass("watch");
        $("button.see, button.create, button.add").prop("hidden",true);
        $(".edit").prop("hidden",false);
        if ($("#imgPortada").hasClass("hasFile")) {
            $("#imgPortada, #btnDelPortada").prop("hidden", false);
            $("#portada").prop("hidden",true);
        }else{
            $("#imgPortada, #btnDelPortada").prop("hidden", true);
            $("#portada").prop("hidden",false);
        }
        $("#adiciones").prop("hidden",false);
    };

    //* Cambia la información del proyecto, dentro de la data del view, tras su edición.
    const updateProyecto = (id,data) => {
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

    //* Al presionar  el botón "editar" que se encuentra en cada fila de la tabla principal, abre el modal principal, carga los datos del proyecto en el mismo y modifica las configuraciones de los elementos del modal para editar el proyecto.
    const editProyecto = async (id,el) => {
        const proyecto = findProject(id);
        if(proyecto == undefined){return}
        $("#mainModal").modal("show");
        $("#mainModalTitle").html(`Edición del proyecto: <b>${proyecto.nombre}</b>`);
        setInputsData(proyecto);
        setToEdit();
        $("#formVer").data("update",1);
        $("#formVer").data("id",proyecto.id);
        $(el).parent().parent().parent().addClass("update-"+id);
        $("#mainModal").data("borraPortada",false);
        $("#mainModal").addClass("dismiss");
        $(".flagable").addClass("watch");
        await setZoneOptions(proyecto.id);
    };

    //* Hace cambios a las configuraciones de los elementos de la portada al hacer click en el botón eliminar portada.
    const delPortada = () => {
        event.preventDefault();
        $("#portada").prop("hidden",false);
        if($("#imgPortada").prop("src").length > 1) {
            $("#formVer").data("borraPortada",true);
            $("#btnDelPortada").addClass("updateProject");
            $("#imgPortada").prop("src",'');
            $("#imgPortada").prop("alt","Editando portada");
        }else if($("#portada").val() != null) {
            $("#portada").val("");
            $("#imgPortada").prop("alt","Portada del proyecto no disponible");
        }
        $("#btnDelPortada").prop("hidden",true);
    };

    //* Al hacer click en el botón "eliminar" en cada fila de la tabla principal, abre el modal borrar y hace los preparativos para eliminar el registro de la tabla pricipal.
    const borrarProyecto = (id, el) => {
        $("#modalBorrar").modal("show");
        $("#modalBorrar").data("id",id);
        $("#modalBorrarTitulo").html(`Eliminar proyecto <b>${findProject(id).nombre}</b>`);
        $(el).parent().parent().parent().addClass("remove-"+id);
    };

    //* Guarda las nuevas etapas creadas en la base de datos.
    const storeEtapas = (method,data) => {
        return axios.post(`proyectos/${method}`,data,{
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then((e) => {
            const data = JSON.stringify(e.data.data);
            return data;
        }).catch((error) => {
            console.log('Error consolidar datos de la zona.', error);
        });
    };

    //* Actualiza los datos en la base de datos, de las etapas creadas desde el modal principal.
    const updateEtapas = async (formData) => {
        return axios.post("proyectos/updateEtapa/",formData,{
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then((e) =>{
            const response = (e.data);
            return response;
        }).catch ((error) =>{
            console.log("Error al consolidar datos de la zona",error);
        });
    };

    //* Guarda los nuevos lotes creadas en la base de datos.
    const storeLotes = (data) => {
        return axios.post('proyectos/storeLotes', data,{
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then((e) => {
            const response = (e.data);
            return response;
        }).catch((response) => {
            console.log(response.data);
        });
    };

    //* Crea un JSON a partir de los datos incluidos en los inputs del elemento seleccionado.
    const packData = (selector) => {
        let data = [];
        $(selector).each((i, e) => {
            let array1 = {};
            $(e).find("input").each((i1, e1) => {
                array1[$(e1).attr("name")] = $(e1).val();
            });
            $(e).find("select").each((i2, e2) => {
                array1[$(e2).attr("name")] = $(e2).find(":selected").val();
            });
            data.push(array1);
        });
        return data;
    };

    //* Crea un FormData a partir de los datos incluidos en los inputs del elemento seleccionado.
    const packFormData = (selector) => {
        let formData = new FormData();
        $(selector).each((i, e) => {
            $(e).find("input").each((i1, e1) => {
                if($(e1).attr("type") == "file")
                    formData.append($(e1).attr("name"), $(e1).prop("files")[0]);
                else
                    formData.append($(e1).attr("name"), $(e1).val());
            });
            $(e).find("select").each((i2, e2) => {
                formData.append($(e2).attr("name"), $(e2).find(":selected").val());
            });
        });
        return formData;
    };

    //* Crea los elementos option a partir de las zonas de un proyecto seleccionado.
    const setZoneOptions = async (id) => {
        const etapas = await getZones(id);
        const zones = etapas.filter(i => i.proyecto_id == id);
        for(let i = 0; i < zones.length; i++) {
            let option = `<option value="${zones[i].id}">${zones[i].etapa} ${zones[i].e_name}</option>`;
            $(option).appendTo($("#zoneToAdd"));
        }
    };

    //* Recopila la información del proyecto, procesa la transacción a la base de datos y actualiza lso elementos del view.
    const updateProject = function () {
        const form = $("#formVer");
        const inputs = form.find(".update");
        const data = new FormData();
        inputs.each((i, e) => {
            if ($(e).attr("type") === "file")
            data.append($(e).attr("name"),$(e).prop("files")[0]);
            else
            data.append($(e).attr("name"),$(e).val());
        });
        data.append("_method","PUT");
        $("#portada").val() != ""? $("#formVer").data("borraPortada",false) : $("#formVer").data("borraPortada",true);
        data.append("borraPortada",$("#formVer").data("borraPortada"));
        const id = $("#idProyecto").val();
        // console.log(...data);
        axios.post("proyectos/"+id,data,{headers: {
            'Content-Type': 'multipart/form-data'
        }}).then ((e) => {
        if(!updateProyecto(id,e.data.data)){console.log("Error al actualizar el proyecto")}
        const dt = $(".table").DataTable();
        const r = e.data.data;
        // console.log(r);
        let button = `<div class="d-flex btn btn-primary btn-sm" onclick="ver(${r.id},this)"><em>${r.nombre}</em></div>`;
        let actions = `<div class="d-flex">
            <button type="button" class="btn btn-info btn-sm me-1 fw-bold" onclick="imagenesProyecto(${r.id},this)">Detalles del proyecto</button>
            <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editProyecto(${r.id},this)">Editar</button>
            <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="borrarProyecto(${r.id},this)">Eliminar</button>
        </div>`;
        dt.row($('.update-'+id)).data([r.id,button,r.clave,r.descripcion,r.ubicacion,projectStatus[r.estado],r.user.name,actions]).draw();
        $("#imgPortada").prop("alt","Portada del proyecto no disponible");
        $("#imgPortada").removeClass("hasFile");
        $("#formVer").data("borraPortada",false);
        $(".flagable").removeClass("updateProject");
        $(".flagable").removeClass("watch");
        $(`.update-${id}`).removeClass(`update-${id}`);
        }).catch ((e) => {
            console.log(e);
        });
    };

    //* Hace la socilictud a la base de datos para actualizar el registro del proyecto y recibe la respuesta.
    const updateEtapa = (data) => {
        return axios.post('proyectos/updateEtapa',data,{
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then((e) => {
            const data = JSON.stringify(e.data.data);
            return data;
        }).catch((error) => {
            console.log('Error almacenar la nueva zona.', error);
            throw error;
        });
    };

    //*Redirecciona a proyectoImagenes
    const imagenesProyecto = (id) => {
            const url = `proyecto/imagenes/${id}`;

            window.open(url, '_blank');
    };
</script>

<script type="module" >

    //* Carga los atributos de DataTable a la tabla principal.
    $(document).ready(() => {
        $(".table").DataTable()
    });

    //* Modifica los valores introducidos
    $(".geo").on('input', function() {
        this.value = this.value.replace(/[^0-9.\-\s]/g, '');
    });

    //* Abre el modal principal y preapara los elementos del mismo para la creadión de un nuevo proyecto.
    $("#btnAdd").click(() => {
        $("#mainModal").modal("show");
        resetModal();
        setToCreate();
    });

    //* Cambia los elementos asociados a la portada al introducir información al input.
    $("#portada").on("input", function () {
        $("#imgPortadaa").prop("hidden",false);
        $("#imgPortadaa").attr("alt",`${$("#portada").val()}`);
        $("#portada").addClass("update");
        $("#btnDelPortada").prop("hidden",false);
    });

    //*
    $("#btnGo").click((e) =>{
        let ubicacion = $.trim($("#ubicacion").val().replace(', ', ','));
        // console.log(ubicacion);
        let url = `https://www.google.com/maps/search/${ubicacion}`;
        // console.log(url);
        window.open(url, '_blank');
    });

    //* Flagea cualquier elemento de la clase watch con la clase updateProject si se modifica la información que contiene originalmente.
    $(document).on("change", ".watch", function () {
        if (!$(this).hasClass("updateProject")) {
            $(this).addClass("updateProject");
        }
    });

    //* Cierra el modal principal al presinar la tecla "scape".
    $(document).on("keydown", function () {
        if(event.which ===27) {
            $("#mainModal").modal("hide");
        }
    });

    $("#btnEliminar").click((e) => {
        const id = $("#idProyecto").val();
        const el = $(`#mainTable td:contains(${id})`).nextAll(':has(button)').first().find("button");
        borrarProyecto(id,el);
    });

    //* Quita la clase "cancel" al presionar el boton Cerrar.
    $("#btnCerrar").click((e) => {
        $("#mainModal").removeClass("cancel");
    });

    //* Muestra la sección para la importación de lotes y manzanas.
    $("#btnImport").click(function (e) {
        $("#importacion").prop("hidden",false);
    });

    //* Recopila la información del nuevo proyecto, procesa la transacción a la base de datos y actualiza lso elementos del view.
    $("#btnSaveProject").click(function (e) {
        try {
            let form = document.getElementById('formVer');
            if(!form.checkValidity()){
                form.reportValidity();
                return
            }
            let inputs = $("#formVer").serializeArray;
            const data = new FormData(document.getElementById("formVer"));
            data.delete("user_name");
            data.delete("id");
            data.delete("etapas");
            data.delete("lotes");
            data.delete("addnZonas")
            data.delete("addnLotes")
            data.delete("ZonetoAdd")
            $("#btnSaveProject").prop("disabled",true);
            axios.post("", data).then((e) => {
                console.log(e);
                if(data.importFile != ""){
                    $('body').html(e.data);
                    $("body").css('overflow', 'auto');
                }else{
                const dt = $(".table").DataTable();
                const r = e.data.data;
                let button = `<div class="d-flex btn btn-primary btn-sm" onclick="ver(${r.id},this)"><em>${r.nombre}</em></div>`;
                let actions = `<div class="d-flex">
                    <button type="button" class="btn btn-info btn-sm me-1 fw-bold" onclick="imagenesProyecto(${r.id},this)">Detalles del proyecto</button>
                    <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editProyecto(${r.id},this)">Editar</button>
                    <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="borrarProyecto(${r.id},this)">Eliminar</button>
                    </div>`
                dt.row.add([r.id,button,r.clave,r.descripcion,r.ubicacion,projectStatus[r.estado],user.name,actions]).draw();
                mainData.push(e.data.data);
                alert(e.data.message);
                $("#mainModalTitle").html(`Vista del proyecto <b>${r.nombre}</b>`);
                setOnStore();
                $("#idProyecto").val(r.id);
                $("#creador").val(r.user_id);
                if(r.portada != null && r.portada != "") {
                $("#imgPortada").attr("src","/storage/"+r.portada);
                $("#imgPortada").prop("hidden",false);
                $("#imgPortada").addClass("hasFile");
                }else if(r.portada == null || r.portada ==""){
                $("#mainModal").data("borraPortada",false);
                };
                $("#formVer").data(r);
                }
            }).catch((e) => {
                console.log(e);
            });
        } catch (error) {
            console.log(error)
        }

    });

    //* Cambia las configuraciones de los elementos del modal principal para editar los datos del proyecto que ya se muestra.
    $("#btnEditar").click( async function (e) {
        const d = $("#formVer").data();
        const idP = $("#idProyecto").val();
        const nP = $("#project-name").val();
        await setToEdit();
        $("#importacion").prop("hidden",true);
        $("#mainModalTitle").html(`Edición del proyecto <b>${nP}</b>`);
        $(`#mainTable td:contains(${idP})`).parent('tr').addClass(`update-${idP}`);
        await setZoneOptions(idP);
    });

    //* Agrega un conjunto de inputs para la creación de una nueva etapa asociada al proyecto que se muestra en el modal principal.
    $("#btnAddEtapa").click(async function (e) {
        $("#newLotes").prop("hidden",true);
        $("#addLoteCtrl").prop("hidden",true);
        const d = $("#formVer").data().id;
        let zi =  $("#addnZonas").val() > 0 && $("#addnZonas").val() != 0 && $("#addnZonas").val() != undefined ? $("#addnZonas").val() : 1;
        const idP = $("#idProyecto").val();
        for(let i = zi; i > 0; i-- ){
            let ec = $("#eCount").val();
            ec++;
            let nvaEtapa =`
                <div id="etapa${ec}Container" class="row row-etapa mx-1 mb-2 px-1 w-100 border-top border-start border-primary zoneForm">
                    <div class="row d-none"><!--Ids-->
                        <label class="fw-bold" for="proyecto_id">proyecto_id</label>
                        <input readonly class="form-control form-control-sm px-1 pIdContainer" name="proyecto_id" id="p_idEtapa${ec}" value="${idP}">
                        <label for="id" class="fw-bold">Id</label>
                        <input readonly class="form-control form-control-sm createZone px-1" type="number" name="id" id="idEtapa${ec}">
                    </div>
                    <div class="row w-100 mx-0 px-0"><!--Datos y botones-->
                        <div class="col-12 col-lg-6 mx-0 px-0">
                            <div class="row mx-0 px-0">
                                <div class="col-1 col-lg-1 px-0 mx-0"><!--Conteo-->
                                    <label for="loteC" class="form-label-sm fw-bold">${ec}</label>
                                    <input readonly class="form-control form-control-sm px-1 createZone" type="number" name="loteC" id="e${ec}LoteC">
                                </div>
                                <div class="col-10 col-lg-10 px-0 ms-1 me-0"><!--Zona, Nombre y ubicación-->
                                    <div class="row mx-0">
                                        <div class="col-2 px-0 me-1">
                                            <label for="etapa" class="form-label small fw-bold mb-0">Zona</label>
                                            <input readonly class="form-control form-control-sm createZone px-1" type="number" name="etapa" id="etapa${ec}E">
                                        </div>
                                        <div class="col-5 px-0 me-1">
                                            <label for="e_name" class="form-label small fw-bold mb-0">Nombre (opcional)</label><br/>
                                            <input  type="text" name="e_name" id="etapa${ec}Name" placeholder="Nombre" title="A cada zona se le asigna automáticamente un identificador numérico independiente de su nombre." class="form-control form-control-sm createZone">
                                        </div>
                                        <div class="col-4 px-0">
                                            <label for="ubicacion" class="form-label small fw-bold mb-0">Ubicación:</label><br/>
                                            <input type="text" name="ubicacion" id="etapa${ec}Ubic" pattern="^((\-?|\+?)?\d+(\.\d+)?),\s*((\-?|\+?)?\d+(\.\d+)?)$" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000" class="form-control form-control-sm createZone geo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mx-0 px-0">
                            <div class="row mx-0 px-0">
                                <div class="col-8 col-sm-9 col-lg-8 px-0 mx-0"><!--Precios-->
                                    <div class="row px-0 mx-0">
                                        <div class="col-6 px-1 mx-0">
                                            <label for="precio_cont" class="form-label small fw-bold mb-0">Precio de contado</label>
                                            <input type="number" name="precio_cont" id="etapa${ec}PCont" placeholder="Por m2" class="form-control form-control-sm createZone zoneInput">
                                        </div>
                                        <div class="col-6 px-1">
                                            <label for="precio_fin" class="form-label small fw-bold mb-0">Precio financiado</label>
                                            <input type="number" name="precio_fin" id="etapa${ec}PFin" placeholder="Por m2" class="form-control  form-control-sm createZone zoneInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-3 col-lg-4 px-0 mx-0"><!--Acciones-->
                                    <p class="mb-0 small fw-bold">Acciones</p><button type="button" title="Borrar esta zona del formulario" class="btn btn-danger btn-sm btnCancelEtapa me-1" id="btnCancelEtapa${ec}">- Zona</button><button disabled type="button" title="Agregar un lote a esta zona" class="btn btn-primary btn-sm btnNestLote" id="btnNestLote${ec}">+ Lote</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            $("#newEtapas").append(nvaEtapa);
            $("#eCount").val(ec).html(ec);
        }
        await $("#addnZonas").val("");
    });

    $(document).on("blur", ".zoneInput", async function (e) {
        let i = parseInt(($(this).attr("id").match(/\d+/g)));
        console.log(i);
        if(!$(this).hasClass(`nestable${i}`)) {
            $(this).val() != '' ? $(this).addClass(`nestable${i}`) : $(this).removeClass(`nestable${i}`);
        }else if($(this).hasClass(`nestable${i}`) &&  $(this).val() == ''){
            $(this).removeClass(`nestable${i}`);
        }else {
            $(this).addClass(`nestable${i}`)
        }
        $(`.nestable${i}`).length >= 1 ? $(`#btnNestLote${i}`).prop("disabled",false) : $(`#btnNestLote${i}`).prop("disabled",true);
    });

    //* Consolida los datos de la etapa que ya se llena y agrega a esa sección del formulario un conjunto de inputs necesarios para la creacion de un nuevo lote asociado a la etapa.
    $(document).on("click", ".btnNestLote", async function (e) {
        let i = parseInt(($(this).attr("id").match(/\d+/g))[0]);
        if($(this).parent().parent().parent().parent().parent().hasClass("zoneForm")) {
            let datos_etapas = packData(`#etapa${i}Container`);
            const eMethod = "storeEtapa";
            const dataE = JSON.stringify(datos_etapas);
            const storedEtapa = await storeEtapas(eMethod,dataE);
            let ne = JSON.parse(storedEtapa);
            let e = ne[0];
            $(`#p_idetapa${i}`).val(e.proyecto_id);
            $(`#idEtapa${i}`).val(e.id);
            $(`#idEtapa${i}`).html(e.id);
            $(`#etapa${i}E`).val(e.etapa);
            $(`#etapa${i}E`).html(e.etapa);
            $(this).parent().parent().parent().parent().parent().addClass("zoneRow");
            $(this).parent().parent().parent().parent().parent().removeClass("zoneForm");
        };
        const idP = $("#idProyecto").val();
        let eId = $(`#idEtapa${i}`).val();
        let ii = $(`#e${i}LoteC`).val();
        ii++;
        $(`#e${i}LoteC`).val(ii);
        $(`#e${i}LoteC`).html(ii)
        let nestedLote = `
            <div class="row pt-0 pb-1 mt-0 mb-1 mx-0 border-bottom border-end e${i}NestedLote row-lote" id="e${i}NestedLote${ii}">
                <div class="col-lg-3 col-sm-11 px-1 mx-0" name="ids lote y manzana">
                    <div class="row px-0 mx-0">
                        <div class="col-2 px-0 ms-0 me-1" name="count">
                            <label for="E_${i}L_${ii}Index">${ii}</label>
                            <input readonly type="number" id="E_${i}L_${ii}Index" class="form-control form-control-sm px-1">
                        </div>
                        <div class="d-none">
                            <label for="proyecto_id" class="fw-bold">P_Id</label>
                            <input readonly name="proyecto_id" id="E_${i}L_${ii}P_id" value="${idP}" class="form-control form-control-sm px-1 pIdContainer">
                        </div>
                        <div class="d-none">
                            <label for="etapa_id" class="fw-bold">E_Id</label><br/>
                            <input readonly type="number" name="etapa_id" id="E_${i}L_${ii}E_id" value="${eId}" class="form-control form-control-sm createZone">
                        </div>
                        <div class="col-4 px-0 ms-0 me-1">
                            <label class="fw-bold" for="lote">Lote</label>
                            <br/><input required class="form-control form-control-sm" type="number" name="lote" id="E_${i}L_${ii}Lote" Placeholder="L No.">
                        </div>
                        <div class="col-5 px-0 mx-0">
                            <label class="fw-bold" for="manzana">Manzana</label>
                            <br/><input required class="form-control form-control-sm" type="number" name="manzana" id="E_${i}L_${ii}Manzana" Placeholder="M No.">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-7 col-sm-12 px-0 mx-0" name="ubicacion y superficie">
                    <div class="row px-0 mx-0">
                        <div class="col-md-6 col-sm-7 ms-0 me-1">
                            <label class="fw-bold" for="ubicacion">Ubicación:</label>
                            <br/><input class="form-control form-control-sm" type="text" name="ubicacion" id="E_${i}L_${ii}Ubicacion" placeholder="Georreferencia">
                        </div>
                        <div class="col-md-5 col-sm-4 px-0 mx-0">
                            <label for="superficie"  class="fw-bold">Superficie</label>
                            <br/><input class="form-control form-control-sm" type="number" name="superficie" id="E_${i}L_${ii}Superficie" Placeholder="Metros cuadrados">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12 px-0 mx-0" name="estado y boton">
                    <div class="row px-0 py-0">
                        <div class="col-md-7 col-sm-6 px-0 ms-0 me-1">
                            <label for="estado" class="fw-bold">Estado</label><br/>
                            <select name="estado" id="E_${i}L_${ii}Estado" class="form-select form-select-sm">
                                <option value="0">No Disponible</option>
                                <option value="1" selected>Disponible</option>
                                <option value="2">Apartado</option>
                                <option value="3">Vendido al contado</option>
                                <option value="4">Vendido a crédito</option>
                                <option value="5">Liquidado</option>
                                <option value="6">En recuperación</option>
                            </select>
                        </div>
                        <div class="col-4 px-0 mx-0"
                            <label class="fw-bold" style="font-weight: bold;">Eliminar</label>
                            <br/><button type="button" class="btn btn-danger btn-sm btnCancelLote mt-0" id="E_${i}L_${ii}btnCancelLote">Eliminar</button>
                        </div>
                    </div>
                </div>

            </div>`;
        $(nestedLote).appendTo($(`#etapa${i}Container`));
        await $(`#E_${i}L_${ii}P_id`).val(idP);
    });

    //* Observa la selección de la zona de entre las asociadas al proyecto que se muestra en el modal principal para habilitar el agregado de lotes a la zona que se seleccione.
    $("#zoneToAdd").change((e) => {
        $("#btnAddLote").prop('disabled', $("#zoneToAdd :selected").val() == 0 ? true : false);
    });

    //* Agrega un grupo de inputs para la creación de un nuevo lote asociado al proyecto que se muestra en el modal principal y a la zona que fue seleccionada de entre las ya creadas.
    $("#btnAddLote").click(function (e) {
        $("#newEtapas").prop("hidden",true);
        $("#addZoneCtrl").prop("hidden",true);
        $("#btnSaveChanges").prop("hidden",true);
        $("#btnSaveAddings").prop("hidden",false);
        const id = $("#idProyecto").val();
        const proyecto = findProject(id);
        let nLotes = $("#addnLotes").val() != 0 && $("#addnLotes").val() != undefined ? $("#addnLotes").val() : 1;
        for(let i = nLotes; i > 0; i--) {
            let lc = $("#loteCount").val();
            lc++;
            let zs = $("#zoneToAdd").val() > 0 ? $("#zoneToAdd").val() : "";
            let nvoLote = `
                <div class="row no-gutters px-0 mx-0 pb-1 row-lote"  id="newLoteCont${lc}" style="max-width:100% !important">
                    <div class="col-lg-3 col-sm-12 px-0 mx-0" name="ids">
                        <div class="row px-0 mx-0">
                            <div class="col-lg-2 col-sm-2 px-0 ms-2 me-1" name="count">
                                <label class="fw-bold" for="proyecto_id">${lc}</label>
                                <input readonly class="form-control form-control-sm px-1" type="number" name="proyecto_id" id="L${lc}P_id" value="${$('#idProyecto').val()}">
                            </div>
                            <div class="col-lg-2 col-sm-3 px-0 ms-2 me-1">
                                <label for="etapa_id" class="fw-bold">E_id</label>
                                <input readonly class="form-control form-control-sm ps-1 pe-0 createLote" type="number" name="etapa_id" id="L${lc}E_id" value="${$('#zoneToAdd :selected').val()}">
                            </div>
                            <div class="col-lg-5 col-sm-3 px-0 ms-2 me-1">
                                <label class="fw-bold" for="Zona">Zona</label>
                                <input readonly type="text" class="form-control form-control-sm" name="Zona" id="L${lc}Zona" value="${$('#zoneToAdd :selected').html()}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mx-0 px-0" name="lote y manzana">
                        <div class="row px-0 mx-0">
                            <div class="col-lg-5 px-0 me-1">
                                <label for="lote" class="fw-bold">Lote</label><br/><input class="form-control form-control-sm" type="number" name="lote" id="L${lc}Lote" Placeholder="L No.">
                            </div>
                            <div class="col-lg-5 px-0 me-1">
                                <label for="manzana${lc}M" class="fw-bold">Manzana</label>
                                <br/><input class="form-control form-control-sm" type="number" name="manzana" id="L${lc}Manzana" Placeholder="M No.">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mx-0 px-0">
                        <div class="row mx-0 px-0">
                            <div class="col-lg-4 px-0 me-1">
                                <label for="ubicacion" class="fw-bold">Ubicación:</label>
                                <br/><input class="form-control form-control-sm geo" type="text" name="ubicacion" id="L${lc}Ubicacion" pattern="^((\-?|\+?)?\d+(\.\d+)?),\s*((\-?|\+?)?\d+(\.\d+)?)$" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000">
                            </div>
                            <div class="col-lg-3 px-0 me-1">
                                <label for="superficie" class="fw-bold">Superficie</label>
                                <br/><input class="form-control form-control-sm" type="number" name="superficie" id="L${lc}Superficie" placeholder="m2">
                            </div>
                            <div class="col-lg-4 px-0 me-1">
                                <label for="estado" class="fw-bold">Estado</label><br/>
                                <select name="estado" id="L${lc}Estado" class="form-select form-select-sm">
                                    <option value="0" selected>No disponible</option>
                                    <option value="1" selected>Disponible</option>
                                    <option value="2">Apartado</option>
                                    <option value="3">Vendido al contado</option>
                                    <option value="4">Vendido a crédito</option>
                                    <option value="5">Liquidado</option>
                                    <option value="6">En recuperación</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 mx-0 px-0 ">
                        <div class="row">
                            <button type="button" class="btn btn-danger btn-sm btnDelLote" id="btnDelLote${lc}">Eliminar</button>
                        </div>
                    </div>
                </div>`;
            $("#newLotes").append(nvoLote);
            $("#loteCount").val(lc).html(lc);
        }
        $("#zoneToAdd option[value=0]").prop("selected",true)
        $("#btnAddLote").attr("disabled",true);
    });

    //* Consolida la eliminación del proyecto de la base de datos y cambia los datos respectivos en la view.
    $("#btnConfirmDelete").click(function (e) {
        const id = $("#modalBorrar").data("id");
        axios.delete("proyectos/"+id).then((e) => {
            $("#modalBorrar").modal("hide");
            $("#modalBorrar").data("id","");
            const dt = $(".table").DataTable();
            dt.rows('.remove-'+id).remove().draw();
            $("#mainModal").modal("hide");
        }).catch((e) => {
            console.log(e.response.data.message);
        })
    });//* Listo

    //* Elimina el conjunto de inputs de la zona correspondiente, incluyendo los de los lotes que se le agregaron y se consolida la eliminación en la base de datos.
    $(document).on("click", ".btnCancelEtapa", function (e) {
        const index = ($(this).attr("id")).match(/\d+/g);
        let i = parseInt(index[0]);
        let ec = $("#eCount").val();
        if ($(`#idEtapa${i}`).val() != "" || $(`#idEtapa${i}`).val() != null) {
            const id = $(`#idEtapa${i}`).val();
            axios.delete("etapas/"+id).then((e) => {
            })
        }
        $(`#etapa${i}Container`).remove();
        ec--;
        $("#eCount").val(ec).html(ec);
    });//* Listo

    //* Elimina el conjunto de inputs del lote correspondiente.
    $(document).on("click", ".btnCancelLote", function (e) {
        const index = ($(this).attr("id")).match(/\d+/g);
        let i = parseInt(index[0]);
        let ii = parseInt(index[1]);
        let nlc = $(`#e${i}LoteC`).val();
        $(`#e${i}NestedLote${ii}`).remove();
        nlc--;
        $(`#e${i}LoteCount`).val(nlc).html(nlc);
    });//* Listo

    //* Elimina el conjunto de inputs del lote correspondiente.
    $(document).on("click", ".btnDelLote", function (e) {
        let i = $(this).attr("id").slice(11 - $(this).length);
        let lc = $("#loteCount").val();
        $(`#newLoteCont${i}`).remove();
        lc--;
        $("#loteCount").val(lc).html(lc);
    });//* Listo

    //* Guarda todos los datos modificados del proyecto, así como las zones y lotes que se le hayan anexado.
    $("#btnSaveChanges").click( async function (e) {
        // console.log($(".updateProject").length);
        // console.log($(".zoneForm").length);
        // console.log($(".zoneRow").length);
        // console.log($(".row-lote").length);
        if($(".updateProject").length > 0) {
            updateProject();
        }
        //  ----    ----    ----    Etapas  ----    ----    ----
        if($(".zoneForm").length > 0) {
            let zoneDataStore = packData(`.zoneForm`);
            const eMethod = "storeEtapa";
            const storedEtapa = await storeEtapas(eMethod,zoneDataStore);
        }
        if($(".zoneRow").length > 0) {
            let zoneDataUpdate = await packFormData(".zoneRow");
            zoneDataUpdate.append("_method","PUT");
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            zoneDataUpdate.append("_token",csrfToken);
            const updatedEtapas = await updateEtapas(zoneDataUpdate);
        }
        //  ----    ----    ----    Lotes   ----    ----    ----
        if($(".row-lote").length > 0) {
            let datos_lotes = await packData(".row-lote");
            const dataL = JSON.stringify(datos_lotes);
            let storedLotes = await storeLotes(dataL);
        }
            $(".zoneForm").remove();
            $(".zoneRow").remove();
            $("#mainModal").modal("hide");
    });//* Listo

    //* Guarda todos los datos modificados del proyecto, así como los lotes que se le hayan anexado.
    $("#btnSaveAddings").click(async function () {
        if($(".updateProject").length > 0) {
            updateProject();
        }
        //  ----    ----    ----    Lotes   ----    ----    ----
        if($(".row-lote").length > 0) {
            let datos_lotes = await packData(".row-lote");
            const dataL = JSON.stringify(datos_lotes);
            let storedLotes = await storeLotes(dataL);
        }
        $(".row-lote").remove();
        $("#mainModal").modal("hide");
    });//* Listo

    //* Cierra el modal principal y elimina las zonas que ya se hayan consolidado
    $("#btnDismiss").click( async function (e) {
        $(".row-lote").remove();
        $(".zonesContainer").each(function () {
            const index = ($(this).attr("id")).match(/\d+/g);
            let i = parseInt(index[0]);
            if ($(`#idEtapa${i}`).val() !== "" && $(`#idEtapa${i}`).val() !== null) {
            const id = $(`#idEtapa${i}`).val();
            axios.delete("etapas/"+id).then((e) => {
            })
            }
            $(`#etapa${i}Container`).remove();
       });
        $(".flagable").removeClass("updateProject");
        $(".flagable").removeClass("watch");
       const idP = $("#idProyecto").val();
       $(`.update-${idP}`).removeClass(`update-${idP}`);
       $("#mainModal").hasClass("dismiss")
       $("#mainModal").modal("hide");
    });//* Listo

</script>

@endsection
