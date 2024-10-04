@extends('layouts.app')

@section('content')

    <style>
            #nombrePro, #clavePro, #enajenantePro, #descripcionPro {
            background-color: #f2f2f2;
            border: 2px solid #007bff;
        }
    </style>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex mb-2 justify-content-between" >
                    <h1 id="tituloProyecto">Detalles del proyecto de {{ $recursos['proyecto']->nombre }}</h1>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center; height: 75px; overflow: hidden; font-size: 20px; font-weight: bold;" >
                        Datos del proyecto
                        </div>
                        <div class="card-body" id="redes">
                            <div class="mb-3">
                                <label for="nombrePro" class="form-label fw-bold mb-0">Nombre</label>
                                <input type="text" class="form-control mt-1" name="nombrePro" id="nombrePro"  placeholder="" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="clavePro" class="form-label fw-bold mb-0">Clave</label>
                                <input type="text" class="form-control mt-1" name="clavePro" id="clavePro"  placeholder="" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="enajenantePro" class="form-label fw-bold mb-0">Enajenante</label>
                                <input type="text" class="form-control mt-1" name="enajenantePro" id="enajenantePro"  placeholder="" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="descripcionPro" class="form-label fw-bold">Descripción</label>
                                <textarea class="form-control" name="descripcionPro" id="descripcionPro" rows="3" maxlength="500" oninput="adjustTextarea(this)" placeholder="" readonly></textarea>
                                <small class="form-text text-muted" >Máximo 500 caracteres.</small>
                            </div>
                            <br>
                            <div class="d-flex justify-content-end mt-auto">
                                <button type="button" class="btn btn-primary" onclick="editProyecto({{$recursos['proyecto']->id }},this)" id="btnEditProyecto">Editar datos del proyecto</button>
                                <button type="button" style="display: none" class="btn btn-success" id="btnConfi">Confirmar</button>
                                <button type="button" style="display: none" class="btn btn-danger" id="btnCancelar">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br><br>
                <div class="d-flex mb-2 justify-content-between">
                    <h1  id="tituloProyecto2">Imagenes del proyecto de {{ $recursos['proyecto']->nombre }}</h1>
                </div>

                <div class="botones text-end">
                    <button class="btn btn-success mb-2" id="addBtn" >Añadir Imagenes al proyecto</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-primary text-center" id=imagenesTabla>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="text-center">Id</th>
                                <th scope="col" class="text-center">Nombre del proyecto</th>
                                <th scope="col" class="text-center">Imagen</th>
                                <th scope="col" class="text-center">Descripción alternativa</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($imagenes as $i)
                            <tr>
                                <td >{{ $i->id }}</td>
                                <td >{{ $i->proyecto->nombre }}</td>
                                <td >
                                    @if($i->url)
                                        <img src="{{ asset('storage/' . $i->url) }}" alt="Imagen" style="width: 100px; height: 100px; object-fit: cover;">
                                    @endif
                                </td>
                                <td >{{ $i->alternativo }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-primary me-1" onclick="editImagenes({{$i->id}},this)">Editar</button>
                                        <button type="button" class="btn btn-danger" onclick="deleteImagenes({{$i->id}},this)">Eliminar</button>
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
                                    <label for="proyectos" class="form-label fw-bold mb-0">Proyecto</label>
                                    <select class="form-control" name="proyectos" id="proyectos" required></select>
                                </div>

                                <form id="imageUploadForm" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Seleccionar Imágenes</label>
                                        <input type="file" class="form-control" id="images" name="images[]"  accept="image/*" multiple required>
                                    </div>
                                </form>

                                <div id="preview" class="row mt-3"></div>

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
                        Seguro que deseas guardar las imagenes del proyecto?
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
                    Seguro que deseas Eliminar la imagen?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmDelete">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Imagenes-->
    <div class="modal fade" id="modalEditImg" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:80% !important">
            <div class="modal-content" >
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleEditImg"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="#" id="formAddImg">
                                <div class="mb-3" style="display: none">
                                    <label for="id" style="display: none"class="form-label fw-bold mb-0">id</label>
                                    <input type="text" style="display: none" class="form-control" name="id" id="id">
                                </div>
                                <div class="mb-3">
                                    <label for="proyectosImg" class="form-label fw-bold mb-0">Proyecto</label>
                                    <input type="text" class="form-control" name="proyectosImg" id="proyectosImg" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="proyectoSelect" class="form-label fw-bold mb-0">Proyecto</label>
                                    <input type="hidden" class="form-control" name="proyectoSelect" id="proyectoSelect">
                                </div>
                                <div class="mb-3">
                                    <label for="imgEdit" class="form-label fw-bold mb-0">Imagen</label>
                                    <div>
                                        <img id="imgEdit" class="img-fluid create see" alt="">
                                        <input type="file" name="imagenP" style="display: none" id="imagenP" placeholder="Imagen a mostrar" class="form-control reset flagable" accept="image/*">
                                        <button id="btnDeleteImg" style="display: none" type="button" onclick="deleteImg(event)" class="btn btn-danger float-end my-2">Seleccionar otra Imagen</button>
                                    </div>
                                </div>

                                <br>

                                <div class="mb-3">
                                <label for="des_alt" class="form-label fw-bold mb-0">Descripción alternativa</label>
                                <input type="text" class="form-control" name="des_alt" id="des_alt" placeholder="Aqui escribe una descripción alternativa">
                                </div>

                            </form>
                        </div>

                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="confirmEditar" class="btn btn-primary">Guardar</button>
                        </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Edicion-->
    <div class="modal fade" id="modalConfirEd" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalConfirTitleEd"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seguro que deseas guardar los cambios en la imagene del proyecto?
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveEditar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal confimacion de edicion de datos de proyecto -->
     <div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title" id="modalSaveTitle"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    Seguro que deseas guardar los cambios de los datos del proyecto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarProyecto">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("scripts")
    <script >
        const mainData = {{ Js::from($imagenes)}}
        const mainRecursos = {{ Js::from($recursos)}}
        const proyectoId = mainRecursos.proyecto.id;
        console.log(mainRecursos);

        let nombreProOriginal = "";
        let claveProOriginal = "";
        let enajenantePro = "";
        let descripcionPro = "";

        function adjustTextarea(el) {
            el.style.height = "auto";
            el.style.height = (el.scrollHeight) + "px";
        }

        // const initSelects = () => {
        //     $("#proyectos").empty();
        //     $("#proyectos").append(`
        //         <option value = ''> Seleccione un Proyecto </option>
        //         `)
        //         mainRecursos.proyectosAll.forEach( (e) => {
        //         $("#proyectos").append(
        //             `<option value = '${e.id}'> ${e.nombre} </option>`
        //         )
        //     })
        // }

        const updateImagenes = (id,data) =>{
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

        const editImagenes = (id,el) =>{
            const pImg = findImagenes(id);
                if(pImg==undefined){return}
                console.log(pImg);

                if (!pImg.url) {
                    $("#imagenP").show();
                    $("#btnDeleteImg").hide();
                } else {
                    $("#imagenP").hide();
                    $("#btnDeleteImg").show();
                }

                $("#id").val(pImg.id);
                $("#proyectosImg").val(mainRecursos.proyecto.nombre);
                $("#proyectoSelect").val(pImg.id_proyecto);
                $("#des_alt").val(pImg.alternativo);

                const imagenUrl = pImg.url ? '/storage/' + pImg.url : '';
                $("#imgEdit").attr("src", imagenUrl);

                $("#formAddImg").data("update",1)
                $("#formAddImg").data("id",pImg.id);
                $("#modalTitleEditImg").html("Editar Imagen")
                $("#modalEditImg").modal("show");

                $(el).parent().parent().parent().addClass("update-"+id);
        }

        const findImagenes = (id) => {
            return mainData.find(e => e.id == id);
        }

        const deleteImagenes=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar imagen?");
            $(el).parent().parent().parent().addClass("remove-"+id)
        }

        function deleteImg(event) {
            event.preventDefault();

            $("#imgEdit").prop("src", '');
            $("#imagenP").val("");

            $("#btnDeleteImg").hide();
        }

        const editProyecto = (id,el) =>{
            const proData = mainRecursos.proyecto;

            nombreProOriginal = $("#nombrePro").val();
            claveProOriginal = $("#clavePro").val();
            enajenantePro = $("#enajenantePro").val();
            descripcionPro = $("#descripcionPro").val();

            $("#nombrePro").prop("readonly", false).attr("placeholder","Aquí coloca el nombre del proyecto");
            $("#clavePro").prop("readonly", false).attr( "placeholder","Aquí coloca la clave del proyecto");
            $("#enajenantePro").prop("readonly", false).attr("placeholder","Aquí coloca al enajenante");
            $("#descripcionPro").prop("readonly", false).attr("placeholder","Aqui escribe la descripción del proyecto");

            $("#btnConfi").show();
            $("#btnCancelar").show();
            $("#btnEditProyecto").hide();
        }

    </script>

    <script type="module" >

        $(document).ready(()=>{
            $(".table").DataTable()
            // initSelects()
        });

        $("#addBtn").click(() => {
            $("#formAdd").trigger("reset");
            $("#proyectos").prop("disabled", false);
            $("#addSave").prop("disabled", false);

            if (proyectoId !== null) {
                $("#proyectos").append(`<option value = '${proyectoId}'> ${mainRecursos.proyecto.nombre} </option>`)
                $("#proyectos").val(proyectoId).change().prop("disabled", true);
            }

            $("#preview").empty();

            $("#images").val(null);

            $("#modalTitleId").html("Añadir Imágenes del proyecto {{ $recursos['proyecto']->nombre }}");
            $("#formAdd").data("update", 0);
            $("#modalAdd").modal("show");
        });

        $(document).ready(function () {

            let selectedFiles = [];

            $('#images').change(function (event) {
                const files = event.target.files;
                const previewContainer = $('#preview');
                previewContainer.empty();
                selectedFiles = Array.from(files);

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const previewItem = $(`
                            <div class="col-md-6 mb-3 preview-item" data-index="${index}">
                                <div class="card position-relative">
                                    <img src="${e.target.result}" class="card-img-top" alt="Imagen ${index + 1}">
                                    <button type="button" class="btn btn-danger position-absolute top-0 end-0 m-2" onclick="removeImage(${index})">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    <div class="card-body">
                                        <input type="text" name="imageText[]" class="form-control image-description" placeholder="Descripción de la imagen (alternativo)">
                                    </div>
                                </div>
                            </div>
                        `);
                        previewContainer.append(previewItem);
                    };

                    reader.readAsDataURL(file);
                });
            });

            window.removeImage = function (indexToRemove) {
                selectedFiles.splice(indexToRemove, 1);

                const previewContainer = $('#preview');
                previewContainer.empty();

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const previewItem = $(`
                            <div class="col-md-6 mb-3 preview-item" data-index="${index}">
                                <div class="card position-relative">
                                    <img src="${e.target.result}" class="card-img-top" alt="Imagen ${index + 1}">
                                    <button type="button" class="btn btn-danger position-absolute top-0 end-0 m-2" onclick="removeImage(${index})">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    <div class="card-body">
                                        <input type="text" name="imageText[]" class="form-control image-description" placeholder="Descripción de la imagen ${index + 1}">
                                    </div>
                                </div>
                            </div>
                        `);
                        previewContainer.append(previewItem);
                    };

                    reader.readAsDataURL(file);
                });

                updateFileInput();
            };

            function updateFileInput() {
                const fileInput = document.getElementById('images');
                const dataTransfer = new DataTransfer();

                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                fileInput.files = dataTransfer.files;
            }

            $("#confirm").click(function (){
                const inputImagen = document.getElementById("images");

                if (inputImagen.files.length === 0) {
                    alert("Debe seleccionar al menos una imagen.");
                    event.preventDefault();
                    return;
                }
                $("#modalAdd").modal("hide");
                $("#modalConfir").modal("show");
                $("#addSave").data("id", proyectoId);
            });

            $('#addSave').click(function () {
                $("#addSave").prop("disabled", true);
                const proyectoIdModal = $('#proyectos').val();
                const inputImagen = document.getElementById('images');

                if (inputImagen.files.length === 0) {
                    console.error("No se ha seleccionado ninguna imagen.");
                    return;
                }

                const formData = new FormData();
                formData.append("_token", $("input[name='_token']").val());
                formData.append("id_proyecto", proyectoIdModal);

                Array.from(inputImagen.files).forEach((file, index) => {
                    formData.append(`images[${index}]`, file);

                    const description = $(`.preview-item[data-index="${index}"] .image-description`).val();
                    formData.append(`descriptions[${index}]`, description);
                });

                $.ajax({
                    type: "POST",
                    url: `/proyecto/imagenes`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        console.log("Imágenes subidas con éxito:", response);

                        $("#modalConfir").modal("hide");
                        $('#formAdd')[0].reset();
                        $('#preview').empty();

                        const dt = $('#imagenesTabla').DataTable();

                        const imagenesSave = response.data;

                        imagenesSave.forEach(is => {
                            let buttons = `<div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-primary me-1" onclick="editImagenes(${is.id}, this)">Editar</button>
                                                <button type="button" class="btn btn-danger" onclick="deleteImagenes(${is.id}, this)">Eliminar</button>
                                        </div>`;

                            let imagen = is.url ? `<img class"text-center" src="/storage/${is.url}" alt="Imagen" style="width: 100px; height: 100px; object-fit: cover;">` : '';

                            dt.row.add([is.id,is.proyecto.nombre,imagen,is.alternativo,buttons]).draw();
                        });
                        mainData.push(...imagenesSave);
                    },
                    error: function (error) {
                        console.error("Error al subir las imágenes:", error);
                    }
                });
            });
        });

        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete("/proyecto/imagenesDelete/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$("#imagenesTabla").DataTable();
                dt.rows('.remove-'+id).remove().draw();

            }).catch((e)=>{
                console.log(e);
            })

        });

        $(document).ready(function() {

            function deleteImg(event) {
                event.preventDefault();

                $("#imagenP").show();

                $("#imgEdit").prop("src", '');
                $("#imagenP").val("");

                $("#btnDeleteImg").hide();
            }

            $("#btnDeleteImg").on("click", deleteImg);

            $("#imagenP").on("change", function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $("#imgEdit").prop("src", e.target.result);
                        $("#btnDeleteImg").show();
                    }

                    reader.readAsDataURL(file);

                    $("#imagenP").hide();

                } else {
                    $("#imgEdit").prop("src", '');
                    $("#btnDeleteImg").hide();
                }
            });
        });


        $("#confirmEditar").click(()=>{
            let form=document.getElementById("formAddImg");
                if(!form.checkValidity()){
                    form.reportValidity();
                    return
                }

            $("#modalConfirEd").modal("show");
            $("#modalConfirTitleEd").html("Confirmar edición de imagen");
            $("#modalEditImg").modal("hide");
        });


        $("#saveEditar").click(function (e) {

            $("#modalConfirEd").modal("hide");

            const button = $(this);
            button.prop("disabled", true);
            let form = document.getElementById("formAddImg");

            if (!form.checkValidity()) {
                form.reportValidity();

                setTimeout(function () {
                    button.prop("disabled", false);
                }, 2000);

                return;
            }

            $("#modalEditImg").trigger("reset")

            let inputs = $("#formAddImg").serializeArray();
            const data = new FormData(document.getElementById("formAddImg"));

            if($("#formAddImg").data("update")==1){
                let id=$("#formAddImg").data("id");
                $("#modalEditImg").modal("hide")
                $("#formAddImg").trigger("reset")
                axios.post("/proyecto/imagenesUpdate/"+id,data).then((e)=>{
                if( !updateImagenes(id,e.data.data)){console.log("error al actualizar local")}

                    const dt=$("#imagenesTabla").DataTable();
                    const is = e.data.data
                    let buttons = `<div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-primary me-1" onclick="editImagenes(${is.id}, this)">Editar</button>
                                                <button type="button" class="btn btn-danger" onclick="deleteImagenes(${is.id}, this)">Eliminar</button>
                                    </div>`;
                    let imagen = is.url ? `<img class"text-center" src="/storage/${is.url}" alt="Imagen" style="width: 100px; height: 100px; object-fit: cover;">` : '';

                    dt.row($('.update-'+id)).data([is.id,is.proyecto.nombre,imagen,is.alternativo,buttons]).draw()
                    button.prop("disabled", false);

                }).catch((e)=>{
                    console.log(e);
                    button.prop("disabled", false);
                })
            };
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('nombrePro').value = mainRecursos.proyecto.nombre || '';
            document.getElementById('clavePro').value = mainRecursos.proyecto.clave|| '';
            document.getElementById('enajenantePro').value = mainRecursos.proyecto.enajenante || '';
            document.getElementById('descripcionPro').value = mainRecursos.proyecto.descripcion || '';

        });

        $("#btnCancelar").click(function () {

            $("#nombrePro").val(nombreProOriginal);
            $("#clavePro").val(claveProOriginal);
            $("#enajenantePro").val(enajenantePro);
            $("#descripcionPro").val(descripcionPro);

            $("#nombrePro").prop("readonly", true).attr("placeholder","");
            $("#clavePro").prop("readonly", true).attr( "placeholder","");
            $("#enajenantePro").prop("readonly", true).attr("placeholder","");
            $("#descripcionPro").prop("readonly", true).attr("placeholder","");
            $("#btnConfi").hide();
            $("#btnCancelar").hide();
            $("#btnEditProyecto").show();

        });

        $("#btnConfi").click(function (){
            $("#modalSave").modal("show");
            $("#btnGuardarProyecto").data("id", proyectoId);
        });

        $("#btnGuardarProyecto").click(function () {
            const proId = $(this).data("id");
            const nombrePro = $("#nombrePro").val();
            const clavePro = $("#clavePro").val();
            const enajenantePro = $("#enajenantePro").val();
            const descripcionPro = $("#descripcionPro").val();

            const datosPro = {
                _token: $("input[name='_token']").val(),
                nombre: nombrePro,
                clave: clavePro,
                enajenante: enajenantePro,
                descripcion: descripcionPro,
                id:proId
            };

            $.ajax({
            type: "POST",
            url: "/proyecto/detallesUpdate/"+proId,
            data: datosPro,
            dataType: "json",
            success: function (response) {
                console.log("datos de proyecto actualizado con éxito:", response);

                const proyectoActualizado = response.data;

                mainRecursos.proyecto.nombre = proyectoActualizado.nombre;
                mainRecursos.proyecto.clave = proyectoActualizado.clave;
                mainRecursos.proyecto.enajenante = proyectoActualizado.enajenante;
                mainRecursos.proyecto.descripcion = proyectoActualizado.descripcion;

                $("#tituloProyecto").text("Detalles del proyecto de " + proyectoActualizado.nombre);
                $("#tituloProyecto2").text("Imagenes del proyecto de " + proyectoActualizado.nombre);

                $('#imagenesTabla tbody tr').each(function () {
                    const proyectoNombreCell = $(this).find('td').eq(1);
                    proyectoNombreCell.text(mainRecursos.proyecto.nombre);
                });

            },
            error: function (error) {
                console.error("error al guardar los datos:", error);
            }
            });

            $("#nombrePro").prop("readonly", true).attr("placeholder","");
            $("#clavePro").prop("readonly", true).attr( "placeholder","");
            $("#enajenantePro").prop("readonly", true).attr("placeholder","");
            $("#descripcionPro").prop("readonly", true).attr("placeholder","");
            $("#modalSave").modal("hide");
            $("#btnConfi").hide();
            $("#btnCancelar").hide();
            $("#btnEditProyecto").show();

        });

    </script>
@endsection

