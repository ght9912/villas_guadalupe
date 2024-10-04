@extends('layouts.app')

@section('content')
    <style>
        #about, #insta, #x, #linkedin, #facebook, #emailAlt {
            background-color: #f2f2f2;
            border: 2px solid #007bff;
        }
    </style>


        <div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-lg w-100 mt-1 fw-bold" name="nombre" id="nombre"  placeholder="" readonly>
                            </div>
                            <div class="d-flex justify-content-end mt-auto">
                                <button type="button" class="btn btn-primary" onclick="editNombre({{$vendedor->id}},this)" id="btnEditNombre">Editar Nombre</button>
                                <button type="button" style="display: none" class="btn btn-success" id="btnConfiNombre">Confirmar</button>
                                <button type="button" style="display: none" class="btn btn-danger" id="btnCancelarN">Cancelar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="text-align: center; height: 75px; overflow: hidden; font-size: 20px; font-weight: bold;">
                            Imagen del vendedor
                        </div>
                        <div class="card-body" id="imagen" style=" text-align: center;">
                            <div>
                                <img id="imgVen" src="{{ $vendedor->imagen ? asset('storage/' . $vendedor->imagen) : asset('img/silueta.png') }}" alt="Imagen" style="width: 75%; height: 75%;">
                                <input type="file" name="imagenVendedor" style="display: none" id="imagenVendedor" placeholder="Imagen a mostrar" class="form-control reset flagable" accept="image/*">
                                <input type="hidden" id="imagenOriginal" value="{{ $vendedor->imagen ? asset('storage/' . $vendedor->imagen) : asset('img/silueta.png') }}">
                            </div>

                            <br>
                            <div class="d-flex justify-content-end mt-auto">
                                <button type="button" class="btn btn-primary" id="btnEditImagen">Cambiar Imagen</button>
                                <button type="button" style="display: none" class="btn btn-success" id="btnConfiImagen">Confirmar</button>
                                <button type="button" style="display: none" class="btn btn-danger" id="btnCancelarI">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="text-align: center; height: 75px; overflow: hidden; font-size: 20px; font-weight: bold;" >
                        Redes Sociales del vendedor
                        </div>
                        <div class="card-body" id="redes">
                            <div class="mb-3">
                                <br>
                                <br>
                                <label for="linkedin" class="form-label fw-bold mb-0 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-linkedin me-2" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                                    </svg>
                                    LinkedIn
                                </label>
                                <input type="text" class="form-control mt-1" name="linkedin" id="linkedin" placeholder="" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="x" class="form-label fw-bold mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-twitter-x me-2" viewBox="0 0 16 16">
                                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                                    </svg>
                                </label>
                                <input type="text" class="form-control mt-1" name="x" id="x"  placeholder="" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="insta" class="form-label fw-bold mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-instagram me-2" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                                    </svg>
                                    Instagram
                                </label>
                                <input type="text" class="form-control mt-1" name="insta" id="insta" placeholder="" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="facebook" class="form-label fw-bold mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-facebook me-2" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                                    </svg>
                                    Facebook
                                </label>
                                <input type="text" class="form-control mt-1" name="facebook" id="facebook" placeholder="" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="emailAlt" class="form-label fw-bold mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-envelope me-2" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                    </svg>
                                    Correo alternativo
                                </label>
                                <input type="text" class="form-control mt-1" name="emailAlt" id="emailAlt" placeholder="" readonly>
                            </div>
                            <br>
                            <div class="d-flex justify-content-end mt-auto">
                                <button type="button" class="btn btn-primary" onclick="editRedes({{$vendedor->id}},this)" id="btnEditRedes">Editar redes sociales</button>
                                <button type="button" style="display: none" class="btn btn-success" id="btnConfiRedes">Confirmar</button>
                                <button type="button" style="display: none" class="btn btn-danger" id="btnCancelarR">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style=" font-size: 20px; height: 75px; font-weight: bold; " >
                            Acerca del vendedor
                        </div>
                        <div class="card-body" style="text-align: center;">
                            <div class="mb-3">
                                <label for="about" class="form-label fw-bold"></label>
                                <textarea class="form-control" name="about" id="about" rows="3" maxlength="500" oninput="adjustTextarea(this)" placeholder="Aqui escribe el email" readonly></textarea>
                                <small class="form-text text-muted">Máximo 500 caracteres.</small>
                            </div>
                            <div class="d-flex justify-content-end mt-auto">
                                <button type="button" class="btn btn-primary" onclick="editAbout({{$vendedor->id}},this)" id="btnEditAbout">Editar información</button>
                                <button type="button" style="display: none" class="btn btn-success" id="BtnConfiAbout">Confirmar</button>
                                <button type="button" style="display: none" class="btn btn-danger" id="btnCancelarA">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal confimacion de edicion redes -->
        <div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalSaveTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    <div class="modal-body">
                        Seguro que deseas guardar los cambios de las redes del vendedor?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarRedes">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal confimacion de edicion About -->
        <div class="modal fade" id="modalSave2" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalSaveTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    <div class="modal-body">
                        Seguro que deseas guardar los cambios acerca del vendedor?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarAbout">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal confimacion imagen -->
        <div class="modal fade" id="modalSave3" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalSaveTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    <div class="modal-body">
                        Seguro que deseas guardar los cambios en la imagen del vendedor?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarImagen">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal confimacion nombre -->
        <div class="modal fade" id="modalSave4" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="modalSaveTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    <div class="modal-body">
                        Seguro que deseas guardar el cambio en el nombre del vendedor?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarNombre">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section("scripts")
    <script>
        const vendedor = @json($vendedor);
         console.log(vendedor);

        let nombreOriginal = "";
        let linkedinOriginal = "";
        let xOriginal = "";
        let instaOriginal = "";
        let facebookOriginal = "";
        let emailAltOriginal = "";
        let AboutOriginal = "";
        let imagenOriginal = "";

        function adjustTextarea(el) {
            el.style.height = "auto";
            el.style.height = (el.scrollHeight) + "px";
        }

        const editRedes = (id,el) =>{
            const vendedores = vendedor;

            linkedinOriginal = $("#linkedin").val();
            xOriginal = $("#x").val();
            instaOriginal = $("#insta").val();
            facebookOriginal = $("#facebook").val();
            emailAltOriginal = $("#emailAlt").val();

            $("#linkedin").prop("readonly", false).attr("placeholder","Aquí coloca el link del LinkedIn del vendedor");
            $("#x").prop("readonly", false).attr("placeholder","Aquí coloca el link del X del vendedor");
            $("#insta").prop("readonly", false).attr( "placeholder","Aquí coloca el link del Instagram del vendedor");
            $("#facebook").prop("readonly", false).attr("placeholder","Aquí coloca el link del facebook del vendedor");
            $("#emailAlt").prop("readonly", false).attr("placeholder","Aquí escribe la otra dirección de correo electrónico");
            $("#btnConfiRedes").show();
            $("#btnCancelarR").show();
            $("#btnEditRedes").hide();
        }

        const editAbout = (id,el) =>{
            const vendedores = vendedor;

            AboutOriginal = $("#about").val();

            $("#about").prop("readonly", false).attr("placeholder","Aquí escribe algo acerca del vendedor");
            $("#BtnConfiAbout").show();
            $("#btnCancelarA").show();
            $("#btnEditAbout").hide();
        }

        const editNombre = (id,el) =>{
            const vendedores = vendedor;

            nombreOriginal = $("#nombre").val();

            $("#nombre").prop("readonly", false).attr("placeholder","Aqui escribe el nombre del vendedor");
            $("#btnConfiNombre").show();
            $("#btnCancelarN").show();
            $("#btnEditNombre").hide();
        }

    </script>

    <script type="module"
    >
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('linkedin').value = vendedor.linkedin || '';
            document.getElementById('x').value = vendedor.x || '';
            document.getElementById('insta').value = vendedor.instagram || '';
            document.getElementById('facebook').value = vendedor.facebook || '';
            document.getElementById('about').value = vendedor.about || '';
            document.getElementById('emailAlt').value = vendedor.email_alt || '';
            document.getElementById('nombre').value = vendedor.nombre || '';

        });

        $(document).ready(function() {

            function deleteIco(event) {
                event.preventDefault();

                $("#imagenVendedor").show();

                if (vendedor.imagen == null || vendedor.imagen == "") {
                    $("#imgVen").hide();

                } else {
                    $("#imgVen").prop("src", '').hide();
                }

                $("#imagenVendedor").val("");
                $("#btnCancelarI").show();
                $("#btnEditImagen").hide();
            }

            $("#btnEditImagen").on("click", deleteIco);
            $("#imagenOriginal").val(vendedor.imagen);

            $("#imagenVendedor").on("change", function() {
                const file = this.files[0];
                if (file) {

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $("#imgVen").prop("src", e.target.result).show();
                        $("#btnEditImagen").show();
                        $("#btnConfiImagen").show();
                        $("#btnCancelarI").show();
                        $("#btnEditImagen").hide();
                    }

                    reader.readAsDataURL(file);

                    $("#imagenVendedor").hide();

                } else {
                    $("#imgVen").prop("src", '');
                    $("#btnEditImagen").hide();
                }
            });
        });

        $("#btnCancelarR").click(function () {

            $("#linkedin").val(linkedinOriginal);
            $("#x").val(xOriginal);
            $("#insta").val(instaOriginal);
            $("#facebook").val(facebookOriginal);
            $("#emailAlt").val(emailAltOriginal);

            $("#linkedin").prop("readonly", true).attr("placeholder", "");
            $("#x").prop("readonly", true).attr("placeholder", "");
            $("#insta").prop("readonly", true).attr("placeholder", "");
            $("#facebook").prop("readonly", true).attr("placeholder", "");
            $("#emailAlt").prop("readonly", true).attr("placeholder","");
            $("#btnConfiRedes").hide();
            $("#btnCancelarR").hide();
            $("#btnEditRedes").show();

        });

        $("#btnConfiRedes").click(function (){
            $("#modalSave").modal("show");
            $("#btnGuardarRedes").data("id", vendedor.id);
            console.log();
        });

        $("#btnGuardarRedes").click(function () {
            const vendedorId = $(this).data("id");
            const linkedin = $("#linkedin").val();
            const x = $("#x").val();
            const insta = $("#insta").val();
            const facebook = $("#facebook").val();
            const emailAlt = $("#emailAlt").val();

            const datosRedes = {
                _token: $("input[name='_token']").val(),
                linkedin: linkedin,
                x: x,
                insta: insta,
                facebook: facebook,
                emailAlt: emailAlt,
                id:vendedorId
            };

            $.ajax({
            type: "POST",
            url: "/vendedores/detallesEdit/"+vendedorId,
            data: datosRedes,
            dataType: "json",
            success: function (response) {
                console.log("datos de vendedor actualizado con éxito:", response);
            },
            error: function (error) {
                console.error("error al guardar los datos:", error);
            }
            });

            $("#linkedin").prop("readonly", true).attr("placeholder", "");
            $("#x").prop("readonly", true).attr("placeholder", "");
            $("#insta").prop("readonly", true).attr("placeholder", "");
            $("#facebook").prop("readonly", true).attr("placeholder", "");
            $("#emailAlt").prop("readonly", true).attr("placeholder","");
            $("#modalSave").modal("hide");
            $("#btnConfiRedes").hide();
            $("#btnCancelarR").hide();
            $("#btnEditRedes").show();

        });


        $("#btnCancelarA").click(function () {

            $("#about").val(AboutOriginal);

            $("#about").prop("readonly", true).attr("placeholder","");
            $("#BtnConfiAbout").hide();
            $("#btnCancelarA").hide();
            $("#btnEditAbout").show();

        });

        $("#BtnConfiAbout").click(function (){
            $("#modalSave2").modal("show");
            $("#btnGuardarAbout").data("id", vendedor.id);
            console.log();
        });

        $("#btnGuardarAbout").click(function () {
            const vendedorId = $(this).data("id");
            const about = $("#about").val();


            const datosAbout = {
                _token: $("input[name='_token']").val(),
                about: about,
                id:vendedorId
            };

            $.ajax({
            type: "POST",
            url: "/vendedores/detallesAbout/"+vendedorId,
            data: datosAbout,
            dataType: "json",
            success: function (response) {
                console.log("datos de vendedor actualizado con éxito:", response);
            },
            error: function (error) {
                console.error("error al guardar los datos:", error);
            }
            });

            $("#linkedin").prop("readonly", true).attr("placeholder", "");
            $("#about").prop("readonly", true).attr("placeholder","");
            $("#modalSave2").modal("hide");
            $("#BtnConfiAbout").hide();
            $("#btnCancelarA").hide();
            $("#btnEditAbout").show();

        });


        $("#btnCancelarI").click(function () {

            $("#imagenVendedor").hide();

            if (vendedor.imagen == null || vendedor.imagen == "") {
                $("#imgVen").prop("src", '{{ asset('img/silueta.png') }}').show();
            } else {
                imagenOriginal = $("#imagenOriginal").val();
                $("#imgVen").prop("src", "/storage/" + imagenOriginal).show();
            }

            $("#btnConfiImagen").hide();
            $("#btnCancelarI").hide();
            $("#btnEditImagen").show();
        });

        $("#btnConfiImagen").click(function (){
            $("#modalSave3").modal("show");
            $("#btnGuardarImagen").data("id", vendedor.id);
            console.log();
        });

        $("#btnGuardarImagen").click(function () {
            const vendedorId = $(this).data("id");
            const inputImagen = document.getElementById('imagenVendedor');

            if (inputImagen.files.length === 0) {
                console.error("No se ha seleccionado ninguna imagen.");
                return;
            }

            const formData = new FormData();
            formData.append("_token", $("input[name='_token']").val());
            formData.append("imagen", inputImagen.files[0]);
            formData.append("id", vendedorId);

            $.ajax({
                type: "POST",
                url: "/vendedores/detallesImagen/" + vendedorId,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    console.log("Imagen actualizada con éxito:", response);
                    const nuevaImagenURL = response.data.imagen;
                    $("#imagenOriginal").val(nuevaImagenURL);
                    vendedor.imagen=nuevaImagenURL
                },
                error: function (error) {
                    console.error("Error al guardar la imagen:", error);
                }
            });

            $("#modalSave3").modal("hide");
            $("#btnConfiImagen").hide();
            $("#btnCancelarI").hide();
            $("#btnEditImagen").show();
        });

        $("#btnCancelarN").click(function () {

            $("#nombre").val(nombreOriginal);

            $("#nombre").prop("readonly", true).attr("placeholder", "");
            $("#btnConfiNombre").hide();
            $("#btnCancelarN").hide();
            $("#btnEditNombre").show();

        });

        $("#btnConfiNombre").click(function (){
            $("#modalSave4").modal("show");
            $("#btnGuardarNombre").data("id", vendedor.id);
            console.log();
        });

        $("#btnGuardarNombre").click(function () {
            const vendedorId = $(this).data("id");
            const nombre = $("#nombre").val();

            const datosNombre = {
                _token: $("input[name='_token']").val(),
                nombre: nombre,
                id:vendedorId
            };

            $.ajax({
            type: "POST",
            url: "/vendedores/detallesNombre/"+vendedorId,
            data: datosNombre,
            dataType: "json",
            success: function (response) {
                console.log("datos de vendedor actualizado con éxito:", response);
            },
            error: function (error) {
                console.error("error al guardar los datos:", error);
            }
            });

            $("#nombre").prop("readonly", true).attr("placeholder", "");
            $("#modalSave4").modal("hide");
            $("#btnConfiNombre").hide();
            $("#btnCancelarN").hide();
            $("#btnEditNombre").show();

        });

    </script>


@endsection

