@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Caracteristicas</h1>
                <div class="botones">
                    <button class="btn btn-success" id="addBtn" >Añadir características</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-primary text-center" id=vendedoresTabla>
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Icono</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Descripción Corta</th>
                            <th scope="col">Descripción larga</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($caracteristicas as $c)
                        <tr>
                            <td>{{$c->id}}</td>
                            <td>
                            @if($c->icono)
                                <img src="{{ asset('storage/' . $c->icono) }}" alt="Icono" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                            No disponible
                            @endif
                            </td>
                            <td>{{$c->titulo}}</td>
                            <td>{{$c->descripcion_cor}}</td>
                            <td>{{$c->descripcion_lar}}</td>
                            <td>{{$c->tipo}}</td>
                            <td>
                                <div class="d-flex">

                                    <button type="button" class="btn btn-primary me-1" onclick="editVendedores({{$c->id}},this)">Editar</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores({{$c->id}},this)">Eliminar</button>

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
                            <div class="mb-3" style="display: none">
                                <label for="id" style="display: none"class="form-label fw-bold mb-0">id</label>
                                <input type="text" style="display: none" class="form-control" name="id" id="id">
                            </div>
                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-bold mb-0">Titulo</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Aqui escribe el Titulo" required>

                            </div>
                            <div class="mb-3">
                                <label for="icono" class="form-label fw-bold mb-0">Icono</label>
                                <div>
                                    <img id="imgIcono" class="img-fluid create see" alt="">
                                    <input type="file" name="icono" style="display: none" id="icono" placeholder="Icono a mostrar" class="form-control reset flagable" accept="image/*" required>
                                    <button id="btnDeleteIco" style="display: none" type="button" onclick="deleteIco(event)" class="btn btn-danger float-end my-2">Seleccionar otro Icono</button>
                                </div>
                            </div>

                            <br>

                            <div class="mb-3">
                            <label for="des_corta" class="form-label fw-bold mb-0">Descripción corta</label>
                            <input type="text" class="form-control" name="des_corta" id="des_corta" placeholder="Aqui escribe una descripción sencilla"required>
                            </div>

                            <div class="mb-3">
                            <label for="des_larga" class="form-label fw-bold mb-0">Descripción larga</label>
                            <input type="text" class="form-control" name="des_larga" id="des_larga" placeholder="Aqui escribe una descripción mas extensa"required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo" class="form-label fw-bold mb-0">Tipo</label>
                                <select class="form-control" name="tipo" id="tipo" required>
                                    <option value="" disabled selected>Selecciona el tipo</option>
                                    <option value="Empresa">Empresa</option>
                                    <option value="Servicio">Servicio</option>
                                </select>
                            </div>

                        </form>
                    </div>

                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="confirm" class="btn btn-primary">Guardar</button>
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
                    Seguro que deseas Guardar la caracteristica de la empresa?
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

@endsection

@section("scripts")
    <script >

    const mainData = {{ Js::from($caracteristicas)}}

    const findVendedores = (id) =>{
        let el;
        mainData.every((e)=>{
            if(e.id==id){
                el=e;
                return false
            }
            return true;
        })
        return el;
    }


    $(document).ready(function() {

        function deleteIco(event) {
            event.preventDefault();

            $("#icono").show();

            $("#imgIcono").prop("src", '');
            $("#icono").val("");

            $("#btnDeleteIco").hide();
        }

        $("#btnDeleteIco").on("click", deleteIco);

        $("#icono").on("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $("#imgIcono").prop("src", e.target.result);
                    $("#btnDeleteIco").show();
                }

                reader.readAsDataURL(file);

                $("#icono").hide();

            } else {
                $("#imgIcono").prop("src", '');
                $("#btnDeleteIco").hide();
            }
        });
    });

    function deleteIco(event) {
        event.preventDefault();

        $("#imgIcono").prop("src", '');
        $("#icono").val("");

        $("#btnDeleteIco").hide();
    }

    const editVendedores = (id,el) =>{

        const vendedores = findVendedores(id);
        if(vendedores==undefined){return}
        console.log(vendedores);
        $("#icono").prop("required", false);

        if (!vendedores.icono) {
            $("#icono").show();
            $("#btnDeleteIco").hide();
        } else {
            $("#icono").hide();
            $("#btnDeleteIco").show();
        }

        $("#id").val(vendedores.id);
        $("#titulo").val(vendedores.titulo);
        $("#des_corta").val(vendedores.descripcion_cor);
        $("#des_larga").val(vendedores.descripcion_lar);
        $("#tipo").val(vendedores.tipo);

        const iconoUrl = vendedores.icono ? '/storage/' + vendedores.icono : '';

        $("#imgIcono").attr("src", iconoUrl);

        $("#formAdd").data("update",1)
        $("#formAdd").data("id",vendedores.id);
        $("#modalTitleId").html("Actualizar caracteristica ")
        $("#modalAdd").modal("show");
        $(el).parent().parent().parent().addClass("update-"+id)
    }

    const updateVendedores = (id,data) =>{
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

    const deleteVendedores=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar característica ?");
            $(el).parent().parent().parent().addClass("remove-"+id)
           // console.log();
    }

    </script>

    <script type="module" >

        $(document).ready(()=>{
            $(".table").DataTable()
        });


        $("#addBtn").click(() => {


            $("#icono").show();
            $("#icono").prop("required", true);
            $("#btnDeleteIco").hide();

            $("#formAdd").trigger("reset");
            $("#imgIcono").attr("src", "");
            $("#btnDeleteIco").hide();
            $("#modalTitleId").html("Añadir caracteristica");
            $("#formAdd").data("update", 0);
            $("#modalAdd").modal("show");
        });


        $("#confirm").click(()=>{
            let form=document.getElementById("formAdd");
                if(!form.checkValidity()){
                    form.reportValidity();
                    return
                }

            $("#modalConfir").modal("show");
            $("#modalConfirTitle").html("Confirmar edicion");
            $("#modalAdd").modal("hide");
        });

        $("#addSave").click(function (e) {

            $("#modalConfir").modal("hide");

            const button = $(this);
            button.prop("disabled", true);
            let form = document.getElementById("formAdd");

            if (!form.checkValidity()) {
                form.reportValidity();

                setTimeout(function () {
                    button.prop("disabled", false);
                }, 2000);

                return;
            }

            $("#modalAdd").trigger("reset")

            let inputs = $("#formAdd").serializeArray();
            const data = new FormData(document.getElementById("formAdd"));

            if($("#formAdd").data("update")==1){
                let id=$("#formAdd").data("id");
                data.append("_method","PUT")
                $("#modalAdd").modal("hide")
                $("#formAdd").trigger("reset")
                axios.post("caracteristicas/"+id,data).then((e)=>{
                   if( !updateVendedores(id,e.data.data)){console.log("error al actualizar local")}

                const dt=$("#vendedoresTabla").DataTable();
                    const r = e.data.data
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary me-1" onclick="editVendedores(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores(${r.id},this)">Eliminar</button>
                                </div>`
                    let icono = `<img src="{{ asset('storage/${r.icono}') }}" alt="Icono" style="width: 100px; height: 100px; object-fit: cover;">`;

                    dt.row($('.update-'+id)).data([r.id,icono,r.titulo,r.descripcion_cor,r.descripcion_lar,r.tipo,buttons]).draw()
                    button.prop("disabled", false);
                    $("#icono").prop("required", true);

                    }).catch((e)=>{
                    console.log(e);
                    button.prop("disabled", false);
                    })
            }

            else{
                axios.post("",data).then((e)=>{

                    $("#modalAdd").modal("hide")
                    $("#formAdd").trigger("reset")

                    $("#imgIcono").attr("src", "");
                    $("#btnDeleteIco").hide();

                    const dt=$("#vendedoresTabla").DataTable();
                    const r = e.data.data
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary me-1" onclick="editVendedores(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores(${r.id},this)">Eliminar</button>
                                </div>`
                    let icono = `<img src="{{ asset('storage/${r.icono}') }}" alt="Icono" style="width: 100px; height: 100px; object-fit: cover;">`;

                    dt.row.add([r.id,icono,r.titulo,r.descripcion_cor,r.descripcion_lar,r.tipo,buttons]).draw()
                    button.prop("disabled", false);
                    $("#icono").prop("required", true);

                mainData.push(e.data.data)

                })
                .catch((e)=>{
                console.log(e);
                button.prop("disabled", false);
                })
            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete("caracteristicas/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$("#vendedoresTabla").DataTable();
                dt.rows('.remove-'+id).remove().draw();

            }).catch((e)=>{
                console.log(e);
            })

        });


    </script>
@endsection

