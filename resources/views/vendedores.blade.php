@extends('layouts.app')

@section('content')
    <style>
        textarea {
            resize: none;
        }
    </style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Vendedores </h1>
                <div class="botones">
                    <button class="btn btn-success" id="addBtn" >Añadir Vendedor</button>
                    <button class="btn btn-success" id="adduser" >Añadir desde usuarios</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-primary text-center" id=vendedoresTabla>
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Id</th>
                            <th scope="col" class="text-center">Id de usuario</th>
                            <th scope="col" class="text-center">Nombre</th>
                            <th scope="col" class="text-center">Email</th>
                            <th scope="col" class="text-center">Celular</th>
                            {{-- <th scope="col">Clientes</th>
                            <th scope="col">Comisiones pagadas</th>
                            <th scope="col">Proyectos en los que participa</th> --}}
                            <th scope="col" class="text-center">Imagen</th>
                            <th scope="col" class="text-center">Puesto</th>
                            {{-- <th scope="col">Acerca de</th>
                            <th scope="col">likedIn</th>
                            <th scope="col">X</th>
                            <th scope="col">Instagram</th>
                            <th scope="col">Facebook</th> --}}
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($vendedores as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->user_id}}</td>
                            <td>{{$v->nombre}}</td>
                            <td>{{$v->email}}</td>
                            <td>{{$v->celular}}</td>
                            {{-- <td>{{$v->clientes}}</td>
                            <td>{{$v->comisiones}}</td>
                            <td>{{$v->proyectos_participa}}</td> --}}
                            <td>
                                @if($v->imagen)
                                    <img src="{{ asset('storage/' . $v->imagen) }}" alt="Imagen" style="width: 100px; height: 150px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{$v->puesto}}</td>
                            {{-- <td >
                                <div style="width: 500px; height: 100px; overflow-y: auto;">
                                    {{$v->about}}
                                </div>
                            </td>
                            <td>{{$v->linkedin}}</td>
                            <td>{{$v->x}}</td>
                            <td>{{$v->instagram}}</td>
                            <td>{{$v->facebook}}</td> --}}
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button type="button" name="" id="" class="btn btn-info me-1" onclick="detalles({{$v->id}},this)">Detalles</button>
                                    <button type="button" class="btn btn-primary me-1" onclick="editVendedores({{$v->id}},this)">Editar</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores({{$v->id}},this)">Eliminar</button>
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
                            <div class="mb-3">
                                <label for="vendedores" class="form-label fw-bold mb-0">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aqui escribe el nombre del vendedor"required>
                            </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold mb-0">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Aqui escribe el email"required>
                                </div>
                                <div class="mb-3">
                                    <label for="celular" class="form-label fw-bold mb-0">Celular</label>
                                    <input type="number" class="form-control" name="celular" id="celular" placeholder="Aqui escribe el numero de celular"required>
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="proyectos_participa" class="form-label fw-bold mb-0">Proyectos en los que participa</label>
                                    <input type="text" class="form-control" name="proyectos_participa" id="proyectos_participa" placeholder="Aqui escribe los proyectos en los que participa">
                                </div> --}}
                                <div class="mb-3">
                                    <label for="imagen" class="form-label fw-bold mb-0">Imagen del vendedor</label>
                                    <div>
                                        <img id="imgVen" class="img-fluid create see" alt="">
                                        <input type="file" name="imagen" style="display: none" id="imagen" placeholder="Icono a mostrar" class="form-control reset flagable" accept="image/*">
                                        <input type="hidden" id="imagenOriginal" value="">
                                        <button id="btnDeleteImg" style="display: none" type="button" onclick="deleteIco(event)" class="btn btn-danger float-end my-2">Seleccionar otra imagen</button>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="mb-3">
                                    <label for="puesto" class="form-label fw-bold mb-0">Puesto</label>
                                    <input type="text" class="form-control" name="puesto" id="puesto" placeholder="Aqui coloca el puesto del vendedor">
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label fw-bold">Acerca de</label>
                                    <textarea class="form-control" name="about" id="about" placeholder="Aquí escribe acerca del vendedor" rows="3" maxlength="500" oninput="adjustTextarea(this)"></textarea>
                                    <small class="form-text text-muted">Máximo 500 caracteres.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="linkedin" class="form-label fw-bold mb-0">LinkedIn</label>
                                    <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="Aqui coloca el link del LinkedIn del vendedor">
                                </div>
                                <div class="mb-3">
                                    <label for="x" class="form-label fw-bold mb-0">X</label>
                                    <input type="text" class="form-control" name="x" id="x" placeholder="Aqui coloca el link del X del vendedor">
                                </div>
                                <div class="mb-3">
                                    <label for="insta" class="form-label fw-bold mb-0">Instagram</label>
                                    <input type="text" class="form-control" name="insta" id="insta" placeholder="Aqui coloca el link del Instagram del vendedor">
                                </div>
                                <div class="mb-3">
                                    <label for="facebook" class="form-label fw-bold mb-0">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Aqui coloca el link del facebook del vendedor">
                                </div>
                                <div class="mb-3">
                                    <label for="emailAlt" class="form-label fw-bold mb-0">Email alternativo</label>
                                    <input type="text" class="form-control" name="emailAlt" id="emailAlt" placeholder="Aqui escribe si el vendedor tiene algun otro correo que quiera agregar">
                                </div>
                            </form>
                        </div>

                    </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

<!-- Modal Buscar Usuario -->
<div class="modal fade modal-lg " id="modalfinduser" tabindex="-1" role="dialog" aria-labelledby="modalTitleUsers" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleUsers">Buscar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                <form action="#" id="formfinduser">
            <div>
                    <div class="mb-3">
                        <input type="text" name="" id="busqueda" class="form-control">
                        @csrf
                        <button class="btn btn-primary" id="btnSearch" >Buscar</button>
                    </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table " id="table2">
                        <thead>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
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

<!-- Modal Agregar vendedor -->
<div class="modal fade" id="modalAgregarVendedor" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                Seguro que deseas agregar a vendedores este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="BtnAgregarVendedor">Confirmar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section("scripts")
    <script>
      const mainData = {{ Js::from($vendedores)}}
      const mainRecursos = {{ Js::from($recursos)}}


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


        const editVendedores = (id,el) =>{
            const vendedores = findVendedores(id);
            if(vendedores==undefined){return}
           console.log(vendedores);

           if (!vendedores.imagen) {
                $("#imagen").show();
                $("#btnDeleteImg").hide();
            } else {
                $("#imagen").hide();
                $("#btnDeleteImg").show();
            }

            $("#user_id").val(vendedores.user_id);
            $("#nombre").val(vendedores.nombre);
            $("#email").val(vendedores.email).prop("readonly", true);
            $("#celular").val(vendedores.celular);
            $("#clientes").val(vendedores.clientes);
            $("#comisiones").val(vendedores.comisiones);

            $("#puesto").val(vendedores.puesto);
            $("#about").val(vendedores.about);
            $("#linkedin").val(vendedores.linkedin);
            $("#x").val(vendedores.x);
            $("#insta").val(vendedores.instagram);
            $("#facebook").val(vendedores.facebook);
            $("#emailAlt").val(vendedores.email_alt);

            const imagenUrl = vendedores.imagen ? '/storage/' + vendedores.imagen : '';

            $("#imgVen").attr("src", imagenUrl);
            $("#imagenOriginal").val(vendedores.imagen);

            $("#formAdd").data("update",1)
            $("#formAdd").data("id",vendedores.id);
            $("#modalTitleId").html("Actualizar vendedor "+vendedores.nombre)
            $("#modalAdd").modal("show");
            $(el).parent().parent().parent().addClass("update-"+id)
        }

        const deleteVendedores=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar Vendedor "+findVendedores(id).nombre);
            $(el).parent().parent().parent().addClass("remove-"+id)
           // console.log();
        }
        const AgregarVendedor=(id,el)=>{
            $("#modalAgregarVendedor").modal("show");
            $("#modalAgregarVendedor").data("id",id);
            $("#modalfinduser").modal("hide");
           // console.log();
        }

        $(document).ready(function() {

            function deleteIco(event) {
                event.preventDefault();

                $("#imagen").show();

                $("#imgVen").prop("src", '');
                $("#imagen").val("");

                $("#btnDeleteImg").hide();
            }

            $("#btnDeleteImg").on("click", deleteIco);

            $("#imagen").on("change", function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $("#imgVen").prop("src", e.target.result);
                        $("#btnDeleteImg").show();
                    }

                    reader.readAsDataURL(file);

                    $("#imagen").hide();

                } else {
                    $("#imgVen").prop("src", '');
                    $("#btnDeleteImg").hide();
                }
            });
        });

        function deleteIco(event) {
            event.preventDefault();

            $("#imgVen").prop("src", '');
            $("#imagen").val("");

            $("#btnDeleteImg").hide();
        }

        function adjustTextarea(el) {
            el.style.height = "auto";
            el.style.height = (el.scrollHeight) + "px";
        }

        const detalles = (id) => {
            const url = `vendedores/detalles/${id}`;

            window.open(url, '_blank');
        }

    </script>
    <script type="module">

     $(document).ready(function() {
         $('#vendedoresTabla').DataTable({
             responsive: true,
             autoWidth: false,

         });
     });


    $("#addBtn").click(()=>{

        $("#imagen").show();
        $("#btnDeleteImg").hide();

        $("#formadd").trigger("reset");
        $("#imgVen").attr("src", "");
        $("#modalAdd").trigger("reset");
        $("#modalTitleId").html("Añadir vendedor");
        $("#modalAdd").modal("show");
        $("#id").val("");
        $("#nombre").val("");
        $("#email").val("").prop("readonly", false);
        $("#celular").val("");
        $("#puesto").val("");
        $("#about").val("");
        $("#linkedin").val("");
        $("#x").val("");
        $("#insta").val("");
        $("#facebook").val("");
        $("#emailAlt").val("");
        $("#formAdd").data("update",0);
    });

    $("#addSave").click(function (e) {
        e.preventDefault();
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
        let inputs = $("#formAdd").serializeArray();
        const data = new FormData(document.getElementById("formAdd"));

        const imagenOriginal = $("#imagenOriginal").val();
        if ($("#imagen")[0].files.length === 0) {
            data.append('imagen_original', imagenOriginal);
        }

        if($("#formAdd").data("update")==1){

            let id=$("#formAdd").data("id");
            data.append("_method","PUT")
            $("#modalAdd").modal("hide")
            $("#formAdd").trigger("reset")
            axios.post("vendedores/"+id,data).then((e)=>{
                if( !updateVendedores(id,e.data.data)){console.log("error al actualizar local")}

            const dt=$("#vendedoresTabla").DataTable();
                const r = e.data.data
                let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                let buttons = `<div class="d-flex">
                            <button type="button" name="" id="" class="btn btn-info me-1" onclick="detalles(${r.id},this)">Detalles</button>
                            <button type="button" class="btn btn-primary me-1" onclick="editVendedores(${r.id},this)">Editar</button>
                            <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores(${r.id},this)">Eliminar</button>
                            </div>`
                let imagen = r.imagen ? `<img src="{{ asset('storage/${r.imagen}') }}" alt="Imagen" style="width: 100px; height: 150px; object-fit: cover;">` : '';

                dt.row($('.update-'+id)).data([r.id,r.user_id,r.nombre,r.email,r.celular,imagen,r.puesto,buttons]).draw()
                button.prop("disabled", false);

                }).catch((e)=>{
                console.log(e);
                button.prop("disabled", false);
                })
        }

        else{
            axios.post("",data).then((e)=>{
                $("#modalAdd").modal("hide")
                $("#formAdd").trigger("reset")

                $("#imgVen").attr("src", "");
                $("#btnDeleteImg").hide();

                const dt=$("#vendedoresTabla").DataTable();
                const r = e.data.data
                let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                let buttons = `<div class="d-flex">
                            <button type="button" name="" id="" class="btn btn-info me-1" onclick="detalles(${r.id},this)">Detalles</button>
                            <button type="button" class="btn btn-primary me-1" onclick="editVendedores(${r.id},this)">Editar</button>
                            <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores(${r.id},this)">Eliminar</button>
                            </div>`
                let imagen = r.imagen ? `<img src="{{ asset('storage/${r.imagen}') }}" alt="Imagen" style="width: 100px; height: 150px; object-fit: cover;">` : '';

                dt.row.add([r.id,r.user_id,r.nombre,r.email,r.celular,imagen,r.puesto,buttons]).draw();
                button.prop("disabled", false);
            mainData.push(e.data.data);

            })
            .catch((e)=>{
            console.log(e);
            button.prop("disabled", false);
            })
        }
    });

    $("#btnConfirmDelete").click(function (e) {
        const id= $("#modalDelete").data("id");
        axios.delete("vendedores/"+id).then((e)=>{
            $("#modalDelete").modal("hide");
            $("#modalDelete").data("id","");
            const dt=$("#vendedoresTabla").DataTable();
            dt.rows('.remove-'+id).remove().draw();

        }).catch((e)=>{
             console.log(e);
        })

    });

    $("#adduser").click(()=>{
        $("#formfinduser").trigger("reset")
        $("#modalTitleUsers").html("Buscar Usuario ")
        $("#modalfinduser").modal("show")
        const dt= $("#table2").DataTable()
        dt.clear().draw();
    });

    $("#btnSearch").click(function (e) {
        e.preventDefault();
        const busqueda=$("#busqueda").val();
        const dt= $("#table2").DataTable()
        dt.clear().draw();
        $.ajax({
            type: "post",
            url: "users/search2",
            data: {busqueda:busqueda, _token:$("input[name='_token']").val()},
            dataType: "json",
            success: function (response) {
                $("#searchResults").empty();
                response.forEach(function (result) {

                const dt= $("#table2").DataTable()
                const btn = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="AgregarVendedor(${result.id}, this)">Convertir a vendedor</button>
                                </div>`
                dt.row.add([result.id,result.name,result.email,btn]).draw()

                });
            },
            error: function (error) {
                console.error(error);
            }
        });
    });

    $("#BtnAgregarVendedor").click(function (e) {
        const button = $(this);
        button.prop("disabled", true);
        const id= $("#modalAgregarVendedor").data("id");
        const data = {id: id};
                    axios.post("vendedores/formUser",data).then(function(response){
                        $("#modalfinduser").modal("hide")
                        $("#modalfinduser").trigger("reset")
                        $("#modalAgregarVendedor").modal("hide")
                        const dt=$("#vendedoresTabla").DataTable();
                        const r = response.data.data;
                        let buttons = `<div class="d-flex">
                                    <button type="button" name="" id="" class="btn btn-info me-1" onclick="detalles(${r.id},this)">Detalles</button>
                                    <button type="button" class="btn btn-primary me-1" onclick="editVendedores(${r.id},this)">Editar</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteVendedores(${r.id},this)">Eliminar</button>
                                    </div>`
                        let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                                    dt.row.add([r.id,r.user_id,r.nombre,r.email,"","","",buttons]).draw()

                    mainData.push(response.data.data)
                    button.prop("disabled", false);

                }).catch((error)=>{
                    console.error(error);
                    $("#modalAgregarVendedor").modal("hide")
                    button.prop("disabled", false);
                })
    });

    </script>


@endsection

