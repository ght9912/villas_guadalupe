@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Clientes</h1>
                <div class="botones">
                    <button class="btn btn-success" id="addBtn" >Añadir Cliente</button>
                    <button class="btn btn-success" id="adduser" >Buscar Usuario</button>
                    <button class="btn btn-success" id="addData" >Importar Clientes</button>
                    <button class="btn btn-success" id="Addcont" >Generar Contrato</button>
                    <button class="btn btn-success" id="btnImport" >Importar Contratos</button>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-primary" id="clientesTabla">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Id Usuario</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Email</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Numero de Celular</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($clientes as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{$c->user_id}}</td>
                                <td>{{$c->nombre}}</td>
                                <td>{{$c->tipo}}</td>
                                <td>{{$c->email}}</td>
                                <td>{{$c->direccion}}</td>
                                <td>{{$c->celular}}</td>
                                <td>
                                <div class="d-flex">
                                    @if ($c->tipo != "Prospecto" && count($c->lotesid) >= 1)
                                    <button type="button" class="btn btn-primary" onclick="verEstadoCuenta({{$c->id}},{{$c->lotesid}})">Estados de Cuenta</button>
                                    @endif
                                    <button type="button" class="btn btn-primary" onclick="verOfertas({{$c->id}})">Ver Ofertas</button>
                                    <button type="button" class="btn btn-primary" onclick="editclientes({{$c->id}},this)">Editar</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes({{$c->id}},this)">Eliminar</button>

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
                        <h5 class="modal-title" id="modalTitleId">Añadir cliente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                    <form action="#" id="formAdd">

                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aqui Escribe el Nombre del usuario" required>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="mail" class="form-control" name="email" id="email" placeholder="Aqui Escribe el Email de Cliente" required>
                      </div>

                      <div class="mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Aqui Escribe la Direccion de Cliente " required>
                      </div>
                      <div class="mb-3">
                        <label for="celular" class="form-label">Numero de Celular</label>
                        <input type="tel" class="form-control" name="celular" id="celular" placeholder="Aqui Escribe el Numero Celular de Cliente " required>
                      </div>


                      </form>
                    </div>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="addSave">Guardar</button>
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
<div class="modal fade modal-lg" id="modalfinduser" tabindex="-1" role="dialog" aria-labelledby="modalTitleUsers" aria-hidden="true">
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
                            <th>Actions</th>
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

<!-- Modal Agregar cliente -->
<div class="modal fade modal-lg" id="modalAgregarCliente" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                ¿Seguro que deseas agregar a clientes este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="BtnAgregarCliente">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Importar/Exportar -Data -->
<div class="modal fade" id="modalAddData" tabindex="-1" role="dialog" aria-labelledby="modalTitleIdAddData" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Importar Clientes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
             <div class="row">
                <div class="col-1"></div>
                    <div class="col-10 col-md-8">
                                <h6>Aquí se puede importar información personal de los Clientes, ya contenida en un archivo de Excel.</h6>
                                <p>Es necesario descargar y vaciar los datos a importar en el archivo de Excel que se puede descargar desde <a href="{{ asset('form_import_clientes.xlsx')}}" download class="btn btn-info btn-sm fw-bold">aquí</a>.</p>
                                <p>Una vez que se hayan llenado los datos se puede proceder a lo siguiente<p>
                            @csrf
                        <form action="{{url('clientes/importar')}}" method="POST" id="formAddData" enctype="multipart/form-data">
                            <div class="row mt-2 mb-2">
                                <div class="col-1"></div>
                                <div class="col-10 col-md-8">
                                    @csrf
                                    <br>
                                    <p class="mb-2">
                                        <span class="fw-bold">Primero,</span> teniendo conocimiento del ejemplo antes mencinado ahora podemos seleccionar un archivo Excel(.xlsx), solo encuentra archivos (.xlsx), desde el explorador de archivos.
                                    </p>
                                    <div class="col-9">
                                        <input type="file" name="documento" accept=".xlsx" required>
                                    </div>
                                    <br>
                                    <p class="mb-2">
                                        <span class="fw-bold">Segundo,</span> una vez seleccionado el archivo Excel(.xlsx), se mostrara el nombre del mismo enseguida, por ultimo solo falta emplear el boton "Importar" que esta enseguida.
                                    </p>
                                    <div class="col-3">
                                        <button class="btn btn-dark" type="submit" id="btnImportar">Importar</button>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-1 col-md-2"></div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="col-md-2">
                        <button class="btn btn-success"> Exportar</button>
                    </div> --}}
             </div>
        </div>
    </div>
    </div>
</div>


<!-- Modal Ver Ofertas -->
<div class="modal fade modal-xl" id="ModalVerOfer" tabindex="-1" role="dialog" aria-labelledby="ModalVerOferTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="VerOferModalLabel">Información de Oferta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="formVerOfer">
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table class="table" id="table3">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Proyecto</th>
                                            <th>Zona</th>
                                            <th>Manzana</th>
                                            <th>Lote</th>
                                            <th>Pago</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abandonar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Delete oferta -->
<div class="modal fade" id="modalDeleteOferta" tabindex="-1" role="dialog" aria-labelledby="modalDeleteOfertaTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteOfertaTitle">Eliminar Oferta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Seguro que deseas Eliminar la oferta?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelarOferta" >Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmDeleteOferta">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pdf -->
<form action="{{route('amortizacion')}}" method="post" target="_blank" class="d-none" id="formAmortizacion">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id=proyecto name="proyecto" value="">
    <input type="hidden" id=selectorEtapa name="selectorEtapa" value="">
    <input type="hidden" id=selectorManzana name="selectorManzana" value="">
    <input type="hidden" id=selectorLote name="selectorLote" value="">
    <input type="hidden" id=nombre name="nombre" value="">
    <input type="hidden" id=Pago name="Pago" value="">
    <input type="hidden" id=PrecioNum name="PrecioNum" value="">
    <input type="hidden" id=Meses name="Meses" value="1">
    <input type="hidden" id=AnualidadNum name="AnualidadNum" value="0">
    <input type="hidden" id=Email name="Email" value="0">
    <input type="hidden" id=EngancheNum name="EngancheNum" value="0">
</form>

<!-- Modal importar -->
<div id="modalImport" role="dialog" aria-labelledby="modalImportTitleId" aria-hidden="true" tabindex="-1" class="modal fade">
    <div role="document" class="modal-dialog" style="max-width:80%  !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalImportTitle" class="modal-title fw-bold">Importar datos</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10 col-md-8">
                        <h6>Aquí se puede importar información de contratos ya contenida en un archivo de Excel.</h6>
                        <p>Es necesario descargar y vaciar los datos a importar en el archivo de Excel que se puede descargar desde <a href="{{ asset('form_import_contratos.xlsx')}}" download class="btn btn-primary btn-sm fw-bold">aquí</a>
                        .</p>
                        <p>Una vez que se hayan llenado los datos se puede proceder a lo siguiente:</p>
                    </div>
                    <div class="col-1 col-md-2"></div>
                </div>
                <form action="{{ url('contratos/importContracts') }}" id="formImport" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-2 mb-2"> <!-- Paso 1 -->
                        <div class="col-1"></div>
                        <div class="col-10 col-md-8">
                            <p class="mb-2">
                                <span class="fw-bold">Primero,</span> hay que definir a cuál proyecto corresponden lo contratos a importar.
                            </p>
                            <select name="proyecto_id" id="importToProject" class="form-select mb-2">
                                <option value="0">Seleccionar proyecto</option>
                            </select>
                        </div>
                        <div class="col-1 col-md-2"></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <p class="mb-2">
                                <span class="fw-bold">Segundo,</span> carga el archivo del que se van a extraer los datos.
                            </p>
                            <input type="file" name="archivo" id="archivo" disabled="disabled" required="required" class="form-control">
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="col-1 col-md-2"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnReqImport" disabled="disabled" class="btn btn-primary">Importar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section("scripts")
    <script >
        const mainData = {{ Js::from($clientes)}}
        const mainRecursos = {{ Js::from($recursos)}}
        const mainProjects = mainRecursos.proyectos;

        const findclientes = (id) =>{
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
        const updateclientes = (id,data) =>{
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
        const editclientes = (id,el) =>{
            const clientes = findclientes(id);
            if(clientes==undefined){return}
            console.log(clientes);
            $("#id").val(clientes.id);
            $("#user_id").val(clientes.user_id);
            $("#nombre").val(clientes.nombre).prop("readonl", false);
            $("#email").val(clientes.email).prop("readonly", false);
            $("#direccion").val(clientes.direccion).prop("readonly", false);
            $("#celular").val(clientes.celular).prop("readonly", false);

            $("#formAdd").data("update",1)
            $("#formAdd").data("id",clientes.id);
            $("#modalTitleId").html("Actualizar cliente "+clientes.nombre)
            $("#modalAdd").modal("show");
            $(el).parent().parent().parent().addClass("update-"+id)
        }
        const deleteclientes=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $("#modalDeleteTitle").html("Eliminar Cliente "+findclientes(id).nombre);
            $(el).parent().parent().parent().addClass("remove-"+id)
           // console.log();
        }
        const AgregarCliente=(id,el)=>{
            $("#modalAgregarCliente").modal("show");
            $("#modalAgregarCliente").data("id",id);
            $("#modalfinduser").modal("hide");
           // console.log();
        }

        let ofertasData = [];
        const verOfertas = (cliente_id) => {
            const dt = $('#table3').DataTable();
                    dt.clear().draw();

            axios.get(`clientes/ofertas/${cliente_id}`)
            .then(response => {

                const ofertas = response.data.ofertas;
                    console.log('ofertas', ofertas);

                    ofertasData = ofertas;

                ofertas.forEach(oferta => {
                    const nombreProyecto = oferta.proyecto;
                    const nombreZona = oferta.zona;
                    const nombreManzana = oferta.manzana;
                    const nombreLote = oferta.lote_id;
                    const pago = oferta.pago;
                    const precio = oferta.precio;

                let buttons = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="verAmor(${oferta.id},this)">Ver cotización</button>
                                    <button type="button" class="btn btn-secondary" onclick="sendMail(${oferta.id},this)">Reenviar cotización</button>
                                    <button type="button" class="btn btn-success" onclick="GenContra(${oferta.id},this)">Generar contrato</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteOferta(${oferta.id},this)">Eliminar Oferta</button>
                                </div>`



                dt.row.add([oferta.id, nombreProyecto, nombreZona,nombreManzana, nombreLote,pago,precio, buttons]).draw();
            });
            })
            .catch(error => {
                console.error(error);
            });

            $('#ModalVerOfer').modal('show');
        };

        const deleteOferta=(id,el)=>{
            $("#modalDeleteOferta").modal("show");
            $("#modalDeleteOferta").data("id",id);
            $("#ModalVerOfer").modal("hide");
            $(el).parent().parent().parent().addClass("remove-"+id);
        };

        const verAmor = (id, el) => {
            let proyecto = $("#proyecto").val();
            let selectorEtapa = $("#selectorEtapa").val();
            let selectorManzana = $("#selectorManzana").val();
            let selectorLote = $("#selectorLote").val();
            let PagoSeleccionado = $("#Pago").val();
            let nombre = $("#nombre").val();
            let PrecioNum = $("#PrecioNum").val();
            let AnualidadNum = $("#AnualidadNum").val();
            let meses = $("#Meses").val();
            let email = $("#Email").val();
            let EngancheNum = $("#EngancheNum").val();
            const ofertaSeleccionada = ofertasData.find(oferta => oferta.id === id);

            if (ofertaSeleccionada) {

                $("#formAmortizacion input[name='proyecto']").val(ofertaSeleccionada.proyecto_id);
                $("#formAmortizacion input[name='selectorEtapa']").val(ofertaSeleccionada.zona_id);
                $("#formAmortizacion input[name='selectorManzana']").val(ofertaSeleccionada.manzana);
                $("#formAmortizacion input[name='selectorLote']").val(ofertaSeleccionada.lote_id);
                $("#formAmortizacion input[name='nombre']").val(ofertaSeleccionada.nombre);
                $("#formAmortizacion input[name='Pago']").val(ofertaSeleccionada.pago);
                $("#formAmortizacion input[name='PrecioNum']").val(ofertaSeleccionada.precioNum);
                $("#formAmortizacion input[name='Meses']").val(ofertaSeleccionada.plazo);
                $("#formAmortizacion input[name='AnualidadNum']").val(ofertaSeleccionada.anualidadNum);
                $("#formAmortizacion input[name='EngancheNum']").val(ofertaSeleccionada.engancheNum);

                console.log('Oferta encontrada:', ofertaSeleccionada);
            } else {
                console.log('Oferta no encontrada');
            }
                $("#formAmortizacion input[name='proyecto']").val(ofertaSeleccionada.proyecto_id);
                $("#formAmortizacion input[name='selectorEtapa']").val(ofertaSeleccionada.zona_id);
                $("#formAmortizacion input[name='selectorManzana']").val(ofertaSeleccionada.manzana);
                $("#formAmortizacion input[name='selectorLote']").val(ofertaSeleccionada.lote_id);
                $("#formAmortizacion input[name='nombre']").val(ofertaSeleccionada.nombre);
                $("#formAmortizacion input[name='Pago']").val(ofertaSeleccionada.pago);
                $("#formAmortizacion input[name='PrecioNum']").val(ofertaSeleccionada.precioNum);
                $("#formAmortizacion input[name='Meses']").val(ofertaSeleccionada.plazo);
                $("#formAmortizacion input[name='AnualidadNum']").val(ofertaSeleccionada.anualidadNum);
                $("#formAmortizacion input[name='EngancheNum']").val(ofertaSeleccionada.engancheNum);
                $("#formAmortizacion").submit();
                return;
        };

        const sendMail = async (id, el) => {
            const button = $(el);
            button.prop('disabled', true);

            const ofertaSeleccionada = ofertasData.find(oferta => oferta.id === id);

            if (ofertaSeleccionada) {
                const oferta = {
                    proyecto_id: ofertaSeleccionada.proyecto_id,
                    zona_id: ofertaSeleccionada.zona_id,
                    lote_id: ofertaSeleccionada.lote_id,
                    manzana: ofertaSeleccionada.manzana,
                    nombre: ofertaSeleccionada.nombre,
                    pago: ofertaSeleccionada.pago,
                    plazo: ofertaSeleccionada.plazo,
                    precio: ofertaSeleccionada.precioNum,
                    anualidad: ofertaSeleccionada.anualidadNum,
                    email: ofertaSeleccionada.email,
                    celular: ofertaSeleccionada.cel,
                    enganche: ofertaSeleccionada.engancheNum,
                    _token: $('meta[name="csrf-token"]').attr("content")
                };

                try {
                    const response = await $.ajax({
                        type: "post",
                        url: `clientes/ofertas/mail`,
                        data: oferta,
                        dataType: "json"
                    });

                    console.log("Oferta enviada con éxito", response);
                } catch (error) {
                    console.error("Error al enviar correo", error);
                } finally {
                    button.prop('disabled', false);
                }
            } else {
                console.log('Oferta no encontrada');
                button.prop('disabled', false);
            }
        };
        const verEstadoCuenta = (id,lotes) => {
            lotes.forEach((e)=> {
                    window.open("clientes/estado-cuenta/"+id+"/"+e);
            })
        }

        const GenContra = (id,el) =>{
            const button = $(el);
            button.prop('disabled', true);

                window.location.href = `contratos/oferta/${id}`;
        };

        const resetImportModal = () => {
            $("select").prop("disabled",false);
            for(let i = 0; i < mainProjects.length; i++){
                let option = `<option value="${mainProjects[i].id}" class="remove">${mainProjects[i].nombre} ${mainProjects[i].clave}</option>`;
                $(option).appendTo($("#importToProject"));
            }
            $("select.option[value=0]").prop("selected",true);
        };

         //* Abre y setea el modal para importar
        $("#btnImport").click((e) => {
            console.log("Click en boton importar");
            $("#formImport").trigger("reset");
            resetImportModal();
            $("#modalImport").modal("show");
        });

        //* Cambia el estado del input archivo, según la opciónd de proyecto seleccionada.
        $("#importToProject").change((e) => {
            $("#importToProject :selected").val() == 0
                ? $("#archivo").prop("disabled",true)
                : $("#archivo").prop("disabled",false);
        });

        //*Habilita el botón de importar cuando se seleciona el archivo desde el que se va a importar la información
        $("#archivo").change((e) => {
            $("#archivo").val() != null
            ? $("#btnReqImport").prop("disabled",false)
            : $("#btnReqImport").prop("disabled",true);
        });

    </script>
    <script type="module">
        $(document).ready(()=>{
            $("#clientesTabla").DataTable()
            });

        $("#addBtn").click(()=>{
            $("#formadd").trigger("reset")
            $("#modalAdd").trigger("reset")
            $("#modalTitleId").html("Añadir Cliente")
            $("#modalAdd").modal("show")
            $("#id").val("");
            $("#nombre").val("").prop("readonly", false);
            $("#email").val("").prop("readonly", false);
            $("#direccion").val("");
            $("#celular").val("");
             $("#formAdd").data("update",0);
        });

        $("#addSave").click(function (e) {
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
            const data = new FormData(form);

            if($("#formAdd").data("update")==1){
                let id=$("#formAdd").data("id");
                data.append("_method","PUT")
                $("#modalAdd").modal("hide")
                $("#formAdd").trigger("reset")
                axios.post("clientes/"+id,data).then((e)=>{
                   if( !updateclientes(id,e.data.data)){console.log("error al actualizar local")}

                const dt=$("#clientesTabla").DataTable();
                    const r = e.data.data
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="verOfertas(${r.id},this)">Ver Ofertas</button>
                                <button type="button" class="btn btn-primary" onclick="editclientes(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes(${r.id},this)">Eliminar</button>
                                </div>`
                    dt.row($('.update-'+id)).data([r.id,r.user_id,r.nombre,r.tipo,r.email,r.direccion,r.celular,buttons]).draw()
                    button.prop("disabled", false);

            }).catch((e)=>{
                if (e.response.status == 422) {
                    let errors = e.response.data.errors;
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                        $(`#formAdd input[name=${key}]`).after(`<span class="text-danger">${value}</span>`);
                    }
                }
                console.log(e);
                button.prop("disabled", false);
            })
            }else{
                axios.post("",data).then((e)=>{
                    $("#modalAdd").modal("hide")
                    $("#formAdd").trigger("reset")
                    const dt=$("#clientesTabla").DataTable();
                    const r = e.data.data
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="verOfertas(${r.id},this)">Ver Ofertas</button>
                                <button type="button" class="btn btn-primary" onclick="editclientes(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes(${r.id},this)">Eliminar</button>
                                </div>`
                    dt.row.add([r.id,r.user_id,r.nombre,r.tipo,r.email,r.direccion,r.celular,buttons ]).draw()
                    button.prop("disabled", false);

                mainData.push(e.data.data)

            }).catch((e ,)=>{
                if (e.response.status == 422) {
                    let errors = e.response.data.errors;
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                        $(`#formAdd input[name=${key}]`).after(`<span class="text-danger">${value}</span>`);
                    }
                }
                console.log(e);
                button.prop("disabled", false);
            })
            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const button = $(this);
            button.prop("disabled", true);
            const id= $("#modalDelete").data("id");
            axios.delete("clientes/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$("#clientesTabla").DataTable();
                dt.rows('.remove-'+id).remove().draw();
                button.prop("disabled", false);

            }).catch((e)=>{
                console.log(e);
                button.prop("disabled", false);
            })
        });

        $(document).ready(()=>{
        $("#clientesTabla").DataTable()
        });


    $("#adduser").click(()=>{
        const dt= $("#table2").DataTable()
        dt.clear().draw();
        $("#formfinduser").trigger("reset")
        $("#modalTitleUsers").html("Buscar Usuario ")
        $("#modalfinduser").modal("show")
    });

    $("#btnSearch").click(function (e) {
        const dt= $("#table2").DataTable()
        dt.clear().draw();
        e.preventDefault();
        const busqueda=$("#busqueda").val();

        $.ajax({
            type: "post",
            url: "users/search",
            data: {busqueda:busqueda, _token:$("input[name='_token']").val()},
            dataType: "json",
            success: function (response) {
                $("#searchResults").empty();
                response.forEach(function (result) {

                const dt= $("#table2").DataTable()
                const btn = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="AgregarCliente(${result.id}, this)">Agregar cliente</button>
                                </div>`
                dt.row.add([result.id,result.name,result.email,btn]).draw()

            });
        },
        error: function (error) {
            console.error(error);
        }
    });
});


    $("#BtnAgregarCliente").click(function (e) {
        const button = $(this);
        button.prop("disabled", true);
        const id= $("#modalAgregarCliente").data("id");
        const data = {id: id};
                axios.post("clientes/formUser",data).then(function(response){
                    $("#modalfinduser").modal("hide")
                    $("#modalfinduser").trigger("reset")
                    $("#modalAgregarCliente").modal("hide")
                    const dt=$("#clientesTabla").DataTable();
                    const r = response.data.data;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="verOfertas(${r.id},this)">Ver Ofertas</button>
                                <button type="button" class="btn btn-primary" onclick="editclientes(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes(${r.id},this)">Eliminar</button>
                                </div>`
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                                dt.row.add([r.id,r.user_id,r.nombre,r.email,"","",buttons]).draw()

                mainData.push(response.data.data)
                button.prop("disabled", false);

            }).catch((error)=>{
                console.error(error);
                button.prop("disabled", false);
                $("#modalAgregarCliente").modal("hide")

            })
    });


    $("#addData").click(()=>{
        $("#formaddData").trigger("reset")
        $("#modalTitleIdAddData").html("Importar/Data ")
        $("#modalAddData").modal("show")
    });


    $("#Addcont").click(()=>{
        window.location ="/contratos"
        // $("#formcont").trigger("reset")
        // $("#modalTitleIdAddcont").html("Generar Contrato")
        // $("#modalAddcont").modal("show")
    });


    $("#").click(()=>{
        $("#formVerOfer").trigger("reset")
        $("#ModalVerOferTitle").html("Buscar Usuario ")
        $("#modalfinduser").modal("show")
    });

    $("#btnConfirmDeleteOferta").click(function (e) {
        const button = $(this);
        button.prop("disabled", true);

        const id = $("#modalDeleteOferta").data("id");

        $.ajax({
            type: "DELETE",
            url: `/ofertas/delete/${id}`,
            data: {
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            dataType: "json",

        success: function (response) {
            const dt= $('#table3').DataTable();
                dt.rows('.remove-' + id).remove().draw();
                button.prop("disabled", false);
                $("#modalDeleteOferta").modal("hide");
                $("#ModalVerOfer").modal("show");

            console.log("Elemento eliminado con éxito");
        },
        error: function (error) {
            button.prop("disabled", false);
            console.error("Error al eliminar el elemento", error);
        }
        });
    });

    $("#btnCancelarOferta").click(function (e) {
        const id = $("#modalDeleteOferta").data("id");

        $("#ModalVerOfer").modal("show");
        $("#modalDeleteOferta").modal("hide");
        $(".remove-" + id).removeClass("remove-" + id);

    });

    document.getElementById('formAddData').addEventListener('submit', function() {
        document.getElementById('btnImportar').disabled = true;
    });
    </script>

@endsection
