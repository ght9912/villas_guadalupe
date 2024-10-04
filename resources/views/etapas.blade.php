@extends('layouts.app')

@section('content')
<!-- Tabla -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Administrador de zonas</h1>
                <button class="btn btn-success fw-bold" id="btnAgregar">
                Añadir Zona
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-primary" id="mainTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Proyecto</th>
                                <th class= "text-center text-wrap" scope="col">Zona No.</th>
                                <th class= "text-center" scope="col">Nombre de la zona</th>
                                <th scope="col">Ubicación</th>
                                <th class="text-wrap text-end" scope="col">Precio de contado</th>
                                <th class="text-wrap text-end" scope="col">Precio financiado</th>
                                <th class="text-center" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etapa as $e)
                            <tr>
                                <td>{{$e->id}}</td>
                                <td style="font-size: small;">{{$e->proyecto->nombre}}</td>
                                <td class="text-center"><div class="btn btn-primary btn-sm " onclick="ver({{$e->id}},this)"><em>{{$e->etapa}}</em></div></td>
                                <td class="text-center"><div class="btn btn-primary btn-sm " onclick="ver({{$e->id}},this)"><em>{{$e->e_name}}</em></div></td>
                                <td style="font-size: small;">{{$e->ubicacion}}</td>
                                <td style="font-size: small;" class="text-end">$ {{number_format($e->precio_cont, 2, ',', '.')}}</td>
                                <td style="font-size: small;" class="text-end">$ {{number_format($e->precio_fin, 2, ',', '.')}}</td>
                                <td class="text-center">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editEtapa({{ $e->id }},this)">
                                        Editar
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="deleteEtapa({{ $e->id }},this)">
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
<div class="modal fade" id="modalVer" tabindex="-1" role="dialog" aria-labelled-by="modVerTitulo" aria-hidden="true">
    <div class="modal-dialog" role="document" aria-hidden="true" style="max-width:90% !important;">
        <div class="modal-content">
            <div class="modal-header sticky-top bg-light">
                <h3 class="modal-title fw-bold" id="modVerTitulo">Nueva zona</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="formVer">
                        <div class="col-auto row-create"> <!--Datos no gráficos-->
                            <label for="proyecto_id" class="fw-bold">Pertenece al proyecto</label><br>
                            <select name="proyecto_id" id="projectToAdd" class="form-select create resetToCreate.">
                                <option value="0">Seleccionar proyecto</option>
                            </select>
                            <div class="row px-0 py-0 create">
                                <div class="col-sm-3 col-md-3 col-lg-2">
                                    <input type="hidden" name="etapa_id" id="etapa_id" readonly="readonly">
                                    <label for="etapa" class="fw-bold mt-2">Zona No.</label>
                                    <input readonly type="number" name="etapa" id="etapa" class="form-control mb-2 resetToCreate" placeholder="Autoasignado">
                                </div>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <label for="nombre" class="fw-bold mt-2">Nombre de la zona</label>
                                    <input type="text" name="e_name" class="form-control mb-2 mt-0 resetToCreate disableOnStore enableToCreate flagable" id="nombre" placeholder="Opcional">
                                </div>
                            </div>
                            <label for="ubicacion" class="fw-bold mt-2 mb-0">Ubicación:</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control mb-2 mt-0 resetToCreate disableOnStore enableToEdit flagable geo" pattern="^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6},\s?-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000">
                            <div class="row px-0 py-0">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <label for="precio_cont" class="fw-bold mt-2">Precio de contado</label>
                                    <input type="text" class="form-control mb-2 mt-0 text-end text-lg-start toCurrency resetToCreate disableOnStore enableToEdit flagable" name="precio-contado" id="precio-contado" placeholder="Por metro cuadrado">
                                    <input type="text" hidden="hidden" name="precio_cont" id="precio_cont" class="absoluteVal">
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <label for="precio_fin" class="fw-bold mt-2">Precio financiado</label>
                                    <input type="text" class="form-control mb-2 mt-0 text-end text-lg-start toCurrency resetToCreate disableOnStore enableToEdit flagable" name="precio-financiado" id="precio-financiado" placeholder="Por metro cuadrado">
                                    <input type="text" hidden="hidden" name="precio_fin" id="precio_fin" class="absoluteVal">
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 hideToCreate showOnStore showToSee showToEdit">
                                    <label for="lotes" class="form-label fw-bold mt-2 mb-0">Lotes de la zona:</label>
                                    <input readonly type="text" name="lotes" id="lotes" class="form-control" min=0 placeholder="Todavía no se capturan lotes">
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row px-1 mt-1 my-2 hideToCreate showToEdit hideToSee" id="addLoteCtrl"> <!--Adición de lotes -->
                            <div class="col-md-2 fw-bold">
                                <h5>Agregar lotes (<span class="resetToCreate" id="loteCount" value=0></span>)</h5>
                            </div>
                            <div class="col-auto">
                                <span class="fw-bold">Agregar</span>
                            </div>
                            <div class="col-auto">
                                <input type="number" name="addnLotes" id="addnLotes" class="form-control form-control-sm" min="0" placeholder="No. de lotes">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-success fw-bold btn-sm" id="btnAddLote">Agregar</button>
                            </div>
                        </div>
                        <div class="row mb-2 showToEdit" name="newlotes" id="newLotes">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer"> <!--Botones -->
                <button type="button" class="btn btn-warning fw-bold hideToCreate showOnStore showToSee hideToEdit" id="btnVerEditar" title="Editar datos de la zona">Editar zona</button>
                <button type="button" class="btn btn-primary showOnStore showToSee hideToCreate hideToEdit" id="btnAdd" title="Agregar lotes a la zona">Agregar lotes...</button>
                <button type="button" class="btn btn-danger hideToCreate hideToSee showToEdit" id="btnDismiss" title="Los lotes y los cambios no guardados del proyecto se eliminarán.">Descartar y cerrar</button>
                <button type="button" class="btn btn-success showToCreate hideOnStore hideToSee hideToEdit" id="btnSaveZone" title="Guardar los datos de la zona">Guardar zona</button>
                <button type="button" class="btn btn-success hideToCreate showToEdit hideToSee" id="btnSaveChanges" title="Guardar cambios a la información de la zona.">Guardar cambios</button>
                <button type="button" class="btn btn-secondary showToCreate hideToEdit showToSee" id="btnClose">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal crear/editar-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document" aria-hidden="true" style="max-width:80% !important">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-tittle" id="modalTitle">Añadir nueva zona al proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="addForm">
                        <div class="container row">
                            <div class="col-lg-6 mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <select name="usuario" id="usuario" class="form-select">
                                    <option selected>Selecciona el usuario:</option>
                                    @foreach ($usuario as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="proyecto" class="form-label">Proyecto</label>
                                <select name="proyecto" id="proyecto" class="form-select">
                                    <option selected>Selecciona el proyecto:</option>
                                    @foreach ($proyecto as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="etapa" class="form-label">Etapa del proyecto:</label>
                            <input type="number" maxlength="2" min="1" name="etapa" id="etapa" class="form-control" placeholder="Etapa del proyecto">
                        </div>
                        <div class="mb-3">
                            <label for="e_name" class="form-label">Etapa del proyecto:</label>
                            <input type="text" name="e_name" id="e_name" class="form-control" placeholder="Nombre de la etapa">
                        </div>
                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicación:</label>
                            <input type="text" name="ubicacion" class="form-control geo" id="ubicacion" pattern="^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6},\s?-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000">
                        </div>
                        <div class="mb-3">
                            <label for="precioC" class="form-label">Precio de contado:</label>
                            <input type="text" maxlength="9" step="0.01" name="precioC" class="form-control toCurrency" id="precioC">
                        </div>
                        <div class="mb-3">
                            <label for="precioF" class="form-label">Precio financiado:</label>
                            <input type="text" maxlength="9" step="0.01" name="precioF" class="form-control" id="precioF">
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal borrar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle"></h5>
                <button type="button" class="btn-close"data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar esta etapa?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="botonConfirmaBorrar">Confirmar</button>
            </div>
        </div>
    </div>

</div>
@endsection

@section("scripts")

<script>

    const mainData = {{ Js::from($etapa)}}
    const mainProjects = {{ Js::from($proyecto)}}


    const findEtapa = (id) => {
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

    const updateEtapa = (id,data) => {
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

    const editEtapa = (id,el) => {
        const zone = findEtapa(id);
        if(zone == undefined){return}
        $("#modalVer").modal("show");
        setInputsData(zone);
        $("#modVerTitulo").html(`Edición de la zona ${zone.etapa} "${zone.e_name}" del proyecto ${zone.proyecto.nombre}`);
        $(el).parent().parent().parent().addClass("update-"+id);
        setToEdit();
    };//*Listo

    const deleteEtapa = (id, el) =>{
        $("#deleteModal").modal("show");
        $("#deleteModal").data("id",id);
        $("#deleteModalTitle").html(`Eliminar etapa <b>${findEtapa(id).etapa}</b> del proyecto <b> ${findEtapa(id).proyecto.nombre}`);
        $(el).parent().parent().parent().addClass("remove-"+id);
    };//* Listo

    const setInputsData = async function (data) {
        $("#projectToAdd").prop("disabled",false);
        setProjectOptions();
        const idP = data.id;
        const pCont = `$ ${data.precio_cont}.00`;
        const pFin = `$ ${data.precio_fin}.00`;
        const lotes = await getLotes(data.id);
        $("#etapa_id").val(data.id)
        $("#etapa").val(data.etapa);
        $("#nombre").val(data.e_name);
        $("#ubicacion").val(data.ubicacion);
        $("#precio-contado").val(`$ ${data.precio_cont}.00`);
        $("#precio_cont").val(data.precio_cont);
        $("#precio-financiado").val(`$ ${data.precio_fin}.00`);
        $("#precio_fin").val(data.precio_fin);
        $(`#projectToAdd option[value=${data.proyecto_id}]`).prop("selected",true);
        if(lotes > 0) {$("#lotes").val(lotes)}
        $("#projectToAdd").prop("disabled",true);
    };//* Listo

    const ver = async function (id,nombre) {
        const zone = findEtapa(id);
        if(zone == undefined){return}
        $("#modalVer").modal("show");
        $("#modVerTitulo").html(`Vista de la zona ${zone.etapa} "${zone.e_name}" del proyecto ${zone.proyecto.nombre}`);
        setInputsData(zone);
        setToSee();
    };//*Listo
    
    const setToCreate = () => {
        $("#modVerTitulo").html("Crear nueva zona");
        $(".resetToCreate").val("").html("");
        $(".showToCreate").prop("hidden",false);
        $(".showToCreate").show();
        $(".set0ToCreate").val(0);
        $(".hideToCreate").prop("hidden",true);
        $("#projectToAdd").prop("disabled",false);
        $(".deleteToCreate").remove();
        $(".enableToCreate").prop("readonly",false);
        $("#btnSaveZone").prop("disabled",false);
        $("#modalVer").addClass("cancel");
    };//* Listo

    const setProjectOptions = () => {
        for(let i = 0; i < mainProjects.length; i++){
            let option = `<option value="${mainProjects[i].id}">${mainProjects[i].nombre} ${mainProjects[i].clave}<option>`;
            $(option).appendTo($("#projectToAdd"));
        }
    };//* Listo

    const setOnStore = () => {
        $(".showOnStore").prop("hidden",false);
        $(".hideOnStore").prop("hidden",true);
        $(".disableOnStore").prop("readonly",true);
        $(".resetOnStore").val("").html("");
        $("#projectToAdd").prop("disabled",true);
        $("#modalVer").removeClass("cancel");
    };//* Listo

    const setToSee = () => {
        $(".hideToSee").hide();
        $(".showToSee").prop("hidden",false);
        $(".showToSee").show();
        $(".disableOnStore").prop("readonly",true);
    };//* Listo

    const setToEdit = () => {
        $(".showToEdit").prop("hidden",false);
        $(".showToEdit").show();
        $(".enableToEdit").prop("readonly", false);
        $(".hideToEdit").prop("hidden",true);
        $(".flagable").addClass("watch");
    };//* Listo

    const setToAdd = () => {
        $(".resetToCreate select option[value=0]").prop("selected",true);
        $(".showToEdit").prop("hidden",false);
        $(".showToEdit").show();
        $(".hideToEdit").prop("hidden",true);
    };//* Listo

    const getLotes = (id) => {
        return axios.get("lotes/zoneLotes/"+id).then((e) => {
            const response = e.data.data;
            return response;
        }).catch((e) => {
            const response = e.data.message;
            return response;
        });
    };//* Listo

    const storeLotes = (data) => {
        return axios.post('proyectos/storeLotes', data,{
            headers: {
            'Content-Type': 'application.json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then((e) => {
            const response = (e.data);
            return response;
        }).catch((response) => {
            console.log(response.data);
        });
    };//* Listo

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
    };//* Listo

    const packFormData = (selector) => {
        let formData = new FormData();
        $(selector).each((i, e) => {
            $(e).find("input").each((i1, e1) => {
                formData.append($(e1).attr("name"), $(e1).val());
            });
            $(e).find("select").each((i2, e2) => {
                formData.append($(e2).attr("name"), $(e2).find(":selected").val());
            });
        });
        return formData;
    };//* Listo

    const tst1 = () => {
        $("#projectToAdd option:eq(1)").prop("selected",true);
        $("#nombre").val("Lombardía");
        $("#ubicacion").val(387.54);
        $("#precio-contado").focus();
        $("#precio-contado").val(450);
        $("#precio-contado").blur();
        $("#precio-financiado").focus();
        $("#precio-financiado").val(550);
        $("#precio-financiado").blur();

    };
</script>

<script type="module" >

    $(document).ready(() => {
        $(".table").DataTable()
    });

    //* Modifica los valores introducidos 
    $(".geo").on('input', function() {
        this.value = this.value.replace(/[^0-9.\-\s]/g, '');
    });

    $("#btnAgregar").click(() => {
        $("#modalVer").modal("show");
        setToCreate();
        for(let i = 0; i < mainProjects.length; i++){
            let newOption = `<option class="deleteToCreate" value="${mainProjects[i].id}">${mainProjects[i].nombre} (${mainProjects[i].clave})</option>`;
            $(newOption).appendTo($("#projectToAdd"));
        }
    });

    $("#projectToAdd").change((e) => {
        const pId = $("#projectToAdd :selected").val()
        $("#modVerTitulo").html(`Agregar nueva zona al proyecto: ${(mainProjects.find((e) => e.id == pId)).nombre}`);
        $("#proyecto_id").val(pId);
    });

    $(document).on("blur", ".toCurrency", function () {
        if($(this).val() != ""){
        const input = $(this).val().match(/\d+/g);
        let output = input[1] == null ? "$ "+input[0]+".00" : "$ "+input[0]+"."+input[1];
        $(this).val(output);
        let number = parseFloat((output.replace(/[^\d.-]/g, '')));
        $(this).siblings(".absoluteVal").val(number);
        }
    });//* Listo

    $("#btnSaveZone").click(async function (e) {
        let zoneData = await packFormData(".row-create");
        zoneData.delete("lotes");
        zoneData.delete("precio-contado");
        zoneData.delete("precio-financiado");
        $("#btnSaveZone").prop("disabled",true);
        axios.post("etapas",zoneData).then((e) => {
            console.log(e);
            const dt = $(".table").DataTable();
            const r = e.data.data;
            console.log(r);
            let button1 = `<div class="text-center"><div class="btn btn-primary btn-sm" onclick="ver(r.id,this)"><em>${r.etapa}</em></div></div>`;
            let button2 = `<div class="text-center"><div class="btn btn-primary btn-sm" onclick="ver(r.id,this)"><em>${r.e_name}</em></div></div>`;
            let actions = `<div class="d-flex">
                <button type="button" class="btn btn-warning btn-sm me-1 fw-bold" onclick="editEtapa(${r.id},this)">Editar</button>
                <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="deleteEtapa(${r.id},this)">Eliminar</button>
            </div>`;
            dt.row.add([
                r.id,
                `<div style="font-size: small;">${r.proyecto.nombre}</div>`,
                button1,
                button2,
                `<div style="font-size: small;" >${r.ubicacion}</div>`,
                `<div style="font-size: small;" class="text-end">$ ${r.precio_cont},00</div>`,
                `<div style="font-size: small;" class="text-end">$ ${r.precio_fin},00</div>`,
                actions
            ]).draw();
            mainData.push(e.data.data);
            alert(e.data.message);
            $("#modVerTitulo").html(`Vista de la zona ${r.etapa} "${r.e_name}" del proyecto ${r.proyecto.nombre}`);
            $("#etapa_id").val(r.id);
            setOnStore();
            $("#etapa").val(r.etapa);
        }).catch((e) => {
            console.log(e);
        });
        //* Habilitar los nuevos botones 
    });//* Listo

    $("#btnVerEditar").click(async function (e) {
        const idP = $("#projectToAdd :selected").val();
        const nP = mainProjects.find((e) => e.id == idP).nombre;
        await setToEdit(); //* línea 313
        $("#modVerTitulo").html(`Edición de la etapa ${$("#etapa").val()} "${$("#nombre").val()}" del proyecto ${nP}`);
        $(`#mainTable td:contains(${idP})`).parent('tr').addClass(`update-${idP}`);
    });//* Listo

    $(document).on("change", ".watch", function () {
        if (!$(this).hasClass("updateZone")) {
            $(this).addClass("updateZone");
        }
    });//* Listo

    $(document).on("keydown", function () {
        if(event.which === 27 && $("#modalVer").hasClass("dismiss")) {
            $("#btnDismiss").click();
        }else if(event.which === 27 && $("#modalVer").hasClass("cancel")) {
            $("#modalVer").removeClass("cancel");
        }
    });//* Listo

    $("#btnClose").click((e) => {
        $("#modalVer").removeClass("cancel");
        $("#modalVer").modal("hide");
    });//* Listo

    $("#btnAdd").click(async function (e) {
        const idP = $("#projectToAdd :selected").val();
        const nP = mainProjects.find((e) => e.id == idP).nombre;
        setToAdd();
        $("#modVerTitulo").html(`Adición de lotes a la etapa ${$("#etapa").val()} "${$("#nombre").val()}" del proyecto ${nP}`);
    });//* Listo

    $("#btnAddLote").click(function (e) {
        const idP = $("#projectToAdd :selected").val();
        const idE = $("#etapa_id").val();
        let nLotes = $("#addnLotes").val() != 0 && $("#addnLotes").val != undefined ? $("#addnLotes").val() : 1;
        for(let i = nLotes; i > 0; i--) {
            let lc = $("#loteCount").val();
            lc++;
            let zs = $("#zoneToAdd").val() > 0 ? $("#zoneToAdd") : "";
            let nvoLote = `
                <div class="row no-gutters px-0 mx-0 pb-1 row-lote" id="newLoteCont${lc}" style="max-width:100% !important">
                    <div hidden class="col px-0 mx-0" name="ids">
                        <div class="row px-0 mx-0">
                            <div class="col-lg-2 col-sm-2 px-0 ms-2 me-1" name="count">
                                <label for="proyecto_id" class="fw-bold"></label>
                                <input type="number" name="proyecto_id" id="L${lc}P_id" readonly="readonly" class="form-control form-control-sm px-1" value="${idP}">
                            </div>
                            <div class="col-lg-2 col-sm-2 px-0 ms-2 me-1">
                                <label for="etapa_id" class="fw-bold">E_id</label>
                                <input type="number" name="etapa_id" id="L${lc}E_id" readonly="readonly" class="form-control form-control-sm ps-1 pe-0" value="${idE}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-2 mx-0 px-0" name="lote y manzana">
                        <div class="row px-0 mx-0">
                            <div class="col-sm-5 col-md-5 col-lg-5 px-0 me-1">
                            <label for="lote" class="fw-bold">Lote</label>
                            <br/><input type="number" name="lote" id="L${lc}Lote" placeholder="L No." class="form-control form-control-sm">
                            </div>
                            <div class="col-sm-6 col-md-5 col-lg-5 px-0 me-1">
                                <label for="manzana" class="fw-bold">Manzana</label>
                                <br/><input type="number" name="manzana" id="L1Manzana" placeholder="M No." class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 mx-0 px-0">
                        <div class="row mx-0 px-0">
                            <div class="col-sm-12 col-md-6 col-lg-4 px-0 me-1">
                                <label for="ubicacion" class="fw-bold">Ubicación</label>
                                <br/><input type="text" name="ubicacion" id="L${lc}Ubicacion" class="form-control form-control-sm geo" placeholder="Coordenadas decimales" title="Ejemplo: 80.000000, 100.000000">
                            </div>
                            <div class="col-sm-4 col-md-2 col-lg-3 px-0 me-1">
                                <label for="superficie" class="fw-bold">Superficie</label>
                                <br/><input type="number" name="superficie" id="L${lc}Superficie" placeholder="m2" class="form-control form-control-sm">
                            </div>
                            <div class="col-sm-5 col-md-3 col-lg-4 px-0 me-1">
                                <label for="estado" class="fw-bold">Estado</label><br>
                                <select name="estado" id="L${lc}Estado" class="form-select form-select-sm">
                                    <option value="0">No disponible</option>
                                    <option value="1" selected>Disponible</option>
                                    <option value="2">Apartado</option>
                                    <option value="3">Vendido al contado</option>
                                    <option value="4">Vendido a credito</option>
                                    <option value="5">Liquidado</option>
                                    <option value="6">En recuperación</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 mx-0 px-0">
                        <div class="row">
                            <label for="btnDelLote" class="fw-bold">Acciones</label><br>
                            <button type="button" class="btn btn-danger btn-sm btnDelLote" id="btnDelLote${lc}" name="btnDelLote">Eliminar</button>
                        </div>
                    </div>
                </div>`;
            $("#newLotes").append(nvoLote);
            $("#loteCount").val(lc).html(lc);
        }
    });//* Listo    

    $(document).on("click", ".btnDelLote", function (e) {
        let i = (($(this).attr("id")).match(/\d+/g))[0];
        let lc = $("#loteCount").val();
        $(`#newLoteCont${i}`).remove();
        lc--;
        $("#loteCount").val(lc).html(lc);
    });//* Listo

    $("#btnSaveChanges").click(async function (e) {
        if($(".updateZone").length > 0) {
            $("#projectToAdd").prop("disabled",false);
            let zoneData = await packFormData(".row-create");
            console.log(...zoneData);
            zoneData.delete("precio-contado");
            zoneData.delete("precio-financiado");
            zoneData.delete("lotes");
            zoneData.append("_method","PUT");
            console.log(...zoneData);
            const id = $("#etapa_id").val();
            axios.post("etapas/"+id,zoneData).then((e) =>{
                if(!updateEtapa(id,e.data.data)){console.log("Error al actualizar la zona")}
                const dt = $(".table").DataTable();
                const r = e.data.data;
                console.log(r);
                let button1 = `<div class="text-center"><div class="btn btn-primary btn-sm" onclick="ver(r.id,this)"><em>${r.etapa}</em></div></div>`;
                let button2 = `<div class="text-center"><div class="btn btn-primary btn-sm" onclick="ver(r.id,this)"><em>${r.e_name}</em></div></div>`;
                let actions = `<div class="d-flex">
                <button type="button" class="btn btn-warning me-1 fw-bold" onclick="editEtapa(${r.id},this)">Editar</button>
                    <button type="button" class="btn btn-danger fw-bold" onclick="deleteEtapa(${r.id},this)">Eliminar</button>
                    </div>`;
                dt.row($('.update-'+id)).data([
                    r.id,
                    `<div style="font-size: small;">${r.proyecto.nombre}</div>`,
                    button1,
                    button2,
                    r.ubicacion,
                    `<div style="font-size: small;" class="text-end">$ ${r.precio_cont},00</div>`,
                    `<div style="font-size: small;" class="text-end">$ ${r.precio_fin},00</div>`,
                    actions
                ]).draw();
                $(".flagable").removeClass("updateProject");
                $(".flagable").removeClass("watch");
                $(`.update-${id}`).removeClass(`update-${id}`);
                alert(e.data.message);
            }).catch((e) => {
                console.log(e.data.message);
            });
            $("#projectToAdd").prop("disabled",true);
        }
        //  ----    ----    ----    Lotes   ----    ----    ----
        if($(".row-lote").length > 0) {
            let datos_lotes = await packData(".row-lote");
            const dataL = JSON.stringify(datos_lotes);
            axios.post('proyectos/storeLotes',dataL,{
                header:{
                    'content-type': 'application.json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then((e) => {
                    console.log(e.data);
                }).catch((e) => {
                    console.log(e.data);
                });
        }
            $("#addLoteCrl").remove();
            $("newLotes").empty();
            $("#newLotes").prop("hidden",true);
            $("#modalVer").modal("hide");
    });

    $("#btnDismiss").click( async function (e) {

        $(".row-lote").remove();
        $(".flagable").removeClass("updateProject");
        $(".flagable").removeClass("watch");
        const idP = $("#projectToAdd :selected").val();
        $(`.update-${idP}`).removeClass(`update-${idP}`);
        $("#lotes").val('');
        $("#modalVer").hasClass("dismiss");
        $("#modalVer").modal("hide");
    });//* Listo

    $("#botonConfirmaBorrar").click(function (e) {
        const id = $("#deleteModal").data("id");
        console.log(id);
        axios.delete("etapas/"+id).then((e) => {
            $("#deleteModal").modal("hide");
            $("#deleteModal").data("id","");
            const dt = $(".table").DataTable();
            dt.rows('.remove-'+id).remove().draw();
        }).catch((e) => {
            console.log(e);
        })
    });

</script>

@endsection
