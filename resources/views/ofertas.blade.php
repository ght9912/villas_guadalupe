@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Ofertas</h1>
            </div>
            <div class="table-responsive">
                <table class="table" id="TablaOfertas">
                    <thead>
                        <tr>
                            <th scope="col">Proyecto</th>
                            <th scope="col" id="etapath" style="display: none;">Zona</th>
                            <th scope="col" id="manzanath" style="display: none;">Manzana</th>
                            <th scope="col" id="loteth" style="display: none;">Lote</th>
                            <th scope="col" id="Accionesth" style="display: none;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div>
                                <select class="form-select" name="proyecto" id="proyecto">
                                    <option selected>Seleciona el proyecto</option>
                                    @foreach ($recursos["proyecto"] as $p)
                                        <option value="{{$p->id}}">{{$p->nombre}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <select class="form-select" style="display: none;" name="selectorEtapa" id="selectorEtapa">
                                        <option selected>Seleciona la Zona</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <select class="form-select" style="display: none;" name="selectorManzana" id="selectorManzana">
                                        <option selected>Seleciona la Manzana</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <select class="form-select" style="display: none;" name="selectorLote" id="selectorLote">
                                        <option selected>Seleciona el Lote</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex" >
                                    <button class="btn btn-success" id="addCliente"  >Seleccionar cliente</button>

                                </div>
                            </td>
                        </tr>
                        <tr style="display: none;" id="tableCliente">
                            <td colspan="2">
                                <div class="col-20 d-flex flex-column py-4 text-end">
                                    <p ><b>Nombre:</b></p>
                                    <p ><b>Email:</b></p>
                                    <p ><b>Dirección:</b></p>
                                    <p ><b>Celular:</b></p>
                                </div>
                            </td>
                            <td>
                                <form id="clienteForm" >
                                    @csrf
                                    <div class="col-20 d-flex flex-column py-4">
                                        <input type="text" class="form-control" id="nombre" name="nombre">
                                        <input type="email" class="form-control" id="email" name="email">
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                        <input type="tel" class="form-control" id="celular" name="celular">
                                    </div>
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-primary" id="btnEditarCliente">Editar</button><br>
                                <button type="button" class="btn btn-secondary" style="display: none;" id="btnCancelar">Cancelar</button>
                                <button class="btn btn-primary" style="display: none;" id="btnGuardarCon">Guardar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table" style="display: none;" id="TablAmortizacion">

                    <thead>
                        <tr>
                            <th scope="col" id="pagoth">Forma de pago</th>
                            <th scope="col" style="display: none;" id="precioth" >Precio del lote</th>
                            <th scope="col" style="display: none;" id="mesesth" >Plazo</th>
                            <th scope="col" style="display: none;" id="engancheth" >Enganche</th>
                            <th scope="col" style="display: none"  id="anualidadth">Anualidad</th>
                            <th scope="col" style="display: none;" id="accionesth" >Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                                <td>

                                    <div>
                                        <select class="form-select" name="Pago" id="Pago">
                                            <option selected>Seleccione una forma de pago</option>
                                            <option value="Contado">Contado</option>
                                            <option value="Financiado">Financiado</option>
                                            <option value="ContadoPE">Contado a Precio Especial</option>
                                            <option value="FinanciadoPE">Financiado a Precio Especial</option>
                                            <option value="FinanciadoA">Financiado con Anualidad</option>
                                            <option value="FinanciadoPEA">Financiado a Precio Especial con Anualidad</option>

                                        </select>
                                    </div>

                                </td>
                                <td>
                                    <div>
                                        <input type="string" style="display: none;" class="form-control" id="Precio" name="Precio" readonly>
                                    </div>
                                    <div>
                                        <input type="number" style="display: none;" id="PrecioNum" name="PrecioNum" readonly>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select class="form-select" style="display: none;" name="Meses" id="Meses">
                                            <option selected>Selecciona el plazo</option>
                                            <option value="6">6 meses</option>
                                            <option value="12">12 meses</option>
                                            <option value="18">18 meses</option>
                                            <option value="24">24 meses</option>
                                            <option value="30">30 meses</option>
                                            <option value="36">36 meses</option>
                                            <option value="42">42 meses</option>
                                            <option value="48">48 meses</option>
                                            <option value="54">54 meses</option>
                                            <option value="60">60 meses</option>
                                            <option value="66">66 meses</option>
                                            <option value="72">72 meses</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="string" style="display: none;" class="form-control" id="Enganche" name="Enganche" placeholder="Ingrese el Enganche" >
                                    </div>
                                    <div>
                                        <input type="number" style="display: none;" id="EngancheNum" name="EngancheNum" >
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="string" style="display: none;" class="form-control" id="Anualidad" name="Anualidad" >
                                    </div>
                                    <div>
                                        <input type="number" style="display: none;" id="AnualidadNum" name="Anualidad" >
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary" style="display: none;" id="BtnCrearPdf">Generar pdf</button><br>
                                    <button type="button" class="btn btn-success" style="display: none;" id="BtnModalOferta">Guardar oferta</button>

                                </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal Buscar Cliente -->
<div class="modal fade modal-lg" id="modalFindCliente" tabindex="-1" role="dialog" aria-labelledby="modalTitleCliente" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleCliente">Buscar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                <form action="#" id="formFindCliente">

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

<!-- Modal Seleccionar cliente -->
<div class="modal fade" id="modalSeleccionarCliente" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                Seguro que deseas seleccionar a este clientes?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clienteSelecionado = null; $('#modalFindCliente').modal('show');">Cancelar</button>
                <button type="button" class="btn btn-primary" id="BtnSeleccionarCliente">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal confimacion de edicion -->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalSaveTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                Seguro que deseas guardar los cambios de este cliente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarCliente">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal confimacion oferta -->
<div class="modal fade" id="modalSaveOferta" tabindex="-1" role="dialog" aria-labelledby="modalSaveTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalSaveTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body">
                Seguro que deseas guardar la oferta generada?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id=BtnGuardarOferta onclick="guardarOferta()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<form action="{{route('amortizacion')}}" method="post" target="_blank" class="d-none" id="formAmortizacion">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="proyecto" value="">
    <input type="hidden" name="selectorEtapa" value="">
    <input type="hidden" name="selectorManzana" value="">
    <input type="hidden" name="selectorLote" value="">
    <input type="hidden" name="nombre" value="">
    <input type="hidden" name="PrecioNum" value="">
    <input type="hidden" name="Meses" value="1">
    <input type="hidden" name="EngancheNum" value="0">
    <input type="hidden" name="AnualidadNum" value="0">
</form>

@endsection

@section("scripts")
    <script>
        const mainData = {{ Js::from($ofertas)}}
        const mainRecursos = {{ Js::from($recursos)}}

        let clienteSelecionado = null;
        let clienteBusqueda = null;
        let nombreOriginal = "";
        let emailOriginal = "";
        let direccionOriginal = "";
        let celularOriginal = "";
        let precioCont;
        let precioFin;
        let superficieLote;
        let number;

        function guardarOferta() {

            const proyectoSeleccionado = proyecto.value;
            const etapaSeleccionada = selectorEtapa.value;
            const loteSeleccionado = selectorLote.value;
            const PagoSeleccionado = Pago.value;
            let PlazoSeleccionado = Meses.value;
            let EngancheSeleccionado = parseFloat($("#EngancheNum").val());
            let anualidadOriginal = parseFloat($("#AnualidadNum").val());
            let precioOriginal = parseFloat($("#PrecioNum").val());
            const anualidadSeleccionado = anualidadOriginal;
            const precioSeleccionado = precioOriginal;

            const botonGuardar = document.getElementById("BtnGuardarOferta");
            botonGuardar.disabled = true;

            if (!clienteSelecionado) {
                alert("Por favor, selecciona un cliente antes de guardar la oferta.");
                botonGuardar.disabled = false;
                return;
            }

            if (PagoSeleccionado === "Contado") {
                PlazoSeleccionado = "1";
                precioTotal = precioCont * superficieLote;
                anualidadTotal = 0;
            } else if (PagoSeleccionado === "ContadoPE" && PlazoSeleccionado !== "Selecciona el plazo") {
                PlazoSeleccionado = "1";
                precioTotal = precioSeleccionado;
                anualidadTotal = 0;
            } else if (PagoSeleccionado === "Financiado" && PlazoSeleccionado !== "Selecciona el plazo") {
                precioTotal = precioFin * superficieLote;
                anualidadTotal = 0;
            } else if (PagoSeleccionado === "FinanciadoPE" && PlazoSeleccionado !== "Selecciona el plazo") {
                precioTotal = precioSeleccionado;
                anualidadTotal = 0;
            } else if (PagoSeleccionado === "FinanciadoA" && PlazoSeleccionado !== "Selecciona el plazo") {
                precioTotal = precioFin * superficieLote;
                anualidadTotal = anualidadSeleccionado;
            } else if (PagoSeleccionado === "FinanciadoPEA" && PlazoSeleccionado !== "Selecciona el plazo") {
                precioTotal = precioSeleccionado;
                anualidadTotal = anualidadSeleccionado;
            } else {
                console.error("Por favor, selecciona una forma de pago y un plazo válido.");
            return;
            }

            const oferta = {
                proyecto_id: proyectoSeleccionado,
                zona_id: etapaSeleccionada,
                lote_id: loteSeleccionado,
                cliente_id: clienteSelecionado.id,
                pago: PagoSeleccionado,
                plazo: PlazoSeleccionado,
                precio: precioTotal,
                anualidad: anualidadTotal,
                enganche: EngancheSeleccionado
            };

            axios.post("ofertas", oferta).then(response => {
                console.log('Oferta guardada exitosamente:', response.data);
                $("#modalSaveOferta").modal("hide");
                botonGuardar.disabled = false;

                const selectorProyecto = document.getElementById("proyecto");
                selectorProyecto.value = "Seleciona el proyecto";

                const selectorEtapa = document.getElementById("selectorEtapa");
                selectorEtapa.value = "Seleciona la zona";

                const selectorManzana = document.getElementById("selectorManzana");
                selectorManzana.value = "Seleciona la Manzana";

                const selectorLote = document.getElementById("selectorLote");
                selectorLote.value = "Seleciona el lote";

                selectorEtapa.style.display = 'none';
                etapath.style.display = 'none';
                selectorManzana.style.display = 'none';
                manzanath.style.display = 'none';
                selectorLote.style.display = 'none';
                loteth.style.display = 'none';
                TablAmortizacion.style.display = 'none';
                tableCliente.style.display = 'none';
            })
            .catch(error => {
                console.error('Error al guardar la oferta:', error);
                botonGuardar.disabled = false;
            });
        }

        const SeleccionarCliente=(index)=>{
            clienteSelecionado = clienteBusqueda[index];
            console.log(clienteSelecionado);
            $("#modalSeleccionarCliente").modal("show");
            $("#modalFindCliente").modal("hide");
            $("#btnEditarCliente").data("id", clienteSelecionado.id);

        }
        let setTimeoutv = null;
        $('#Precio').on('input', function() {
            let inputValor = $(this).val();
            if (setTimeoutv != null) {
                clearTimeout(setTimeoutv);
                setTimeoutv = null;
            }
            setTimeoutv = setTimeout(() => {
                $('#PrecioNum').val(currency(inputValor).value);
                const currencyFormatted = currency(inputValor).format();
                $(this).val(currencyFormatted);
             }, 1000);
        });

        let setTimeoutb = null;
        $('#Anualidad').on('input', function() {
            let inputAnualidad = $(this).val();

            let inputValor = $(this).val();
            if (setTimeoutb != null) {
            clearTimeout(setTimeoutb);
            setTimeoutb = null;
            }
            setTimeoutb = setTimeout(() => {
                $('#AnualidadNum').val(currency(inputValor).value);
                const currencyFormatted = currency(inputValor).format();
                $(this).val(currencyFormatted);
             }, 1000);

        });

        let setTimeoutc = null;
        $('#Enganche').on('input', function() {
            let inputEnganche = $(this).val();

            let inputValor = $(this).val();
            if (setTimeoutc != null) {
            clearTimeout(setTimeoutc);
            setTimeoutc = null;
            }
            setTimeoutc = setTimeout(() => {
                $('#EngancheNum').val(currency(inputValor).value);
                const currencyFormatted = currency(inputValor).format();
                $(this).val(currencyFormatted);
             }, 1000);

        });

    </script>
    <script type="module">

        const selectorProyecto = document.getElementById('proyecto');
        const selectorEtapa = document.getElementById('selectorEtapa');
        const selectorManzana = document.getElementById('selectorManzana');
        const selectorLote = document.getElementById('selectorLote');


        selectorProyecto.addEventListener('change', function() {
            const proyectoSeleccionado = this.value;

            selectorEtapa.style.display = 'none';
            etapath.style.display = 'none';
            selectorManzana.style.display = 'none';
            manzanath.style.display = 'none';
            selectorLote.style.display = 'none';
            loteth.style.display = 'none';
            TablAmortizacion.style.display = 'none';


            if (proyectoSeleccionado !== 'Seleciona el proyecto') {
                // consulta de etapas
                axios.get("/ofertas/etapas/"+proyectoSeleccionado).then((res) =>{
                    $("#selectorEtapa").html("")
                    $("#selectorEtapa").append("<option selected>Seleciona la Zona</option>");
                    res.data.forEach(e=>{
                        let nombreEtapa = e.e_name || e.etapa;

                        let html = `<option value="${e.id}">${nombreEtapa}</option>` ;
                        $("#selectorEtapa").append(html);
                    })
                })

                selectorEtapa.style.display = 'table-cell';
                etapath.style.display = 'table-cell';
            } else {
                selectorEtapa.style.display = 'none';
                etapath.style.display = 'none';
                selectorManzana.style.display = 'none';
                manzanath.style.display = 'none';
                selectorLote.style.display = 'none';
                loteth.style.display = 'none';
                TablAmortizacion.style.display = 'none';
                precioth.style.display = 'none';
                Precio.style.display = 'none';
                mesesth.style.display = 'none';
                engancheth.style.display = 'none';
                accionesth.style.display = 'none';
                Anualidad.style.display = 'none';
                $("#Meses").hide();
                $("#Enganche").hide();
                $("#BtnCrearPdf, #BtnModalOferta").hide();


            }
        });

        selectorEtapa.addEventListener('change', function() {
            const etapaSeleccionada = this.value;

            selectorManzana.style.display = 'none';
            manzanath.style.display = 'none';
            selectorLote.style.display = 'none';
            loteth.style.display = 'none';
            TablAmortizacion.style.display = 'none';


            if (etapaSeleccionada !== 'Seleccione la Etapa') {

                axios.get("/ofertas/lotes/"+etapaSeleccionada).then((res) =>{
                $("#selectorManzana").html("")
                $("#selectorLote").html("")
                $("#selectorManzana").append("<option selected>Seleciona la Manzana</option>");
                $("#selectorLote").append("<option selected>Seleciona el lote </option>");
                let manzanas = res.data.map(e => e.manzana);
                let unicasManzanas = new Set(manzanas);
                unicasManzanas =[...unicasManzanas];
                unicasManzanas.forEach(e =>{
                    let html = `<option value="${e}">${e}</option>` ;
                    $("#selectorManzana").append(html);
                })
                res.data.forEach(e=>{
                    let html = `<option value="${e.id}" data-manzana = '${e.manzana}'>${e.lote}</option>` ;
                    $("#selectorLote").append(html);
                })
                })

                selectorManzana.style.display = 'table-cell';
                manzanath.style.display = 'table-cell';

            } else {
                selectorManzana.style.display = 'none';
                manzanath.style.display = 'none';
                selectorLote.style.display = 'none';
                loteth.style.display = 'none';
                TablAmortizacion.style.display = 'none';
                precioth.style.display = 'none';
                Precio.style.display = 'none';
                mesesth.style.display = 'none';
                engancheth.style.display = 'none';
                accionesth.style.display = 'none';
                Anualidad.style.display = 'none';
                $("#Meses").hide();
                $("#Enganche").hide();
                $("#BtnCrearPdf, #BtnModalOferta").hide();


            }

            if (etapaSeleccionada !== 'Seleccione la Etapa') {
                axios.get(`ofertas/precios/${etapaSeleccionada}`).then((response) => {
                    precioCont = response.data.precio_cont;
                    precioFin = response.data.precio_fin;
                })
                .catch((error) => {
                    console.error('Error al cargar los datos de la etapa', error);
                });
            }
        });

        selectorManzana.addEventListener('change', function() {
            const manzanaSeleccionada = this.value;

                selectorLote.style.display = 'none';
                loteth.style.display = 'none';
                TablAmortizacion.style.display = 'none';


            if (manzanaSeleccionada !== 'Seleccione la Manzana') {
                $("#selectorLote option").hide();
                $("#selectorLote").prepend("<option selected>Seleciona el lote </option>");
                $("#selectorLote option[data-manzana ='"+manzanaSeleccionada+"']").show();
                selectorLote.style.display = 'table-cell';
                loteth.style.display = 'table-cell';
            } else {
                selectorLote.style.display = 'none';
                loteth.style.display = 'none';
                TablAmortizacion.style.display = 'none';
                precioth.style.display = 'none';
                Precio.style.display = 'none';
                mesesth.style.display = 'none';
                engancheth.style.display = 'none';
                accionesth.style.display = 'none';
                Anualidad.style.display = 'none';
                $("#Meses").hide();
                $("#Enganche").hide();
                $("#BtnCrearPdf, #BtnModalOferta").hide();
            }
        });

        selectorLote.addEventListener('change', function() {
            const loteSeleccionado = this.value;
            const TablAmortizacion = document.getElementById("TablAmortizacion");
            const Pago = document.getElementById("Pago");

            if (loteSeleccionado !== 'Seleciona el Lote') {

                axios.get(`ofertas/superficie/${loteSeleccionado}`).then((response) => {
                    superficieLote = response.data.superficie;
                })
                .catch((error) => {
                    console.error('Error al cargar los datos del lote', error);
                });

                TablAmortizacion.style.display = 'table-row';
                precioth.style.display = 'none';
                Precio.style.display = 'none';
                mesesth.style.display = 'none';
                engancheth.style.display = 'none';
                $("#Meses").hide();
                $("#Enganche").hide();
                $("#BtnCrearPdf, #BtnModalOferta").hide();
                Pago.value = "Seleccione una forma de pago";
                accionesth.style.display = 'none';
                Anualidad.style.display = 'none';
            } else {

                TablAmortizacion.style.display = 'none';

            }
        });

        $("#addCliente").click(()=>{

            const dt= $("#table2").DataTable()
            dt.clear().draw();

            $("#formFindCliente").trigger("reset")
            $("#modalTitleCliente").html("Buscar Cliente ")
            $("#modalFindCliente").modal("show")
        });

        $("#btnSearch").click(function (e) {
            e.preventDefault();
            const busqueda=$("#busqueda").val();
            const dt= $("#table2").DataTable()
            dt.clear().draw();
            $.ajax({
                type: "post",
                url: "ofertas/search",
                data: {busqueda:busqueda, _token:$("input[name='_token']").val()},
                dataType: "json",
                success: function (response) {
                    clienteBusqueda = response;
                    $("#searchResults").empty();
                    response.forEach(function (result,i) {
                    const btn = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="SeleccionarCliente(${i})">Seleccionar Cliente</button>
                                </div>`
                    dt.row.add([result.id,result.nombre,result.email,btn]).draw()
                });
                },
                error: function (error) {
                    console.error(error);
                }
                });

                $("#email").prop("readonly", true);
                $("#direccion").prop("readonly", true);
                $("#celular").prop("readonly", true);
                $("#btnGuardarCon").hide();
        });

        $("#BtnSeleccionarCliente").click(function () {
            $("#nombre").val(clienteSelecionado.nombre).prop("readonly", true);
            $("#email").val(clienteSelecionado.email).prop("readonly", true);
            $("#direccion").val(clienteSelecionado.direccion).prop("readonly", true);
            $("#celular").val(clienteSelecionado.celular).prop("readonly", true);
            $("#btnEditarCliente").data("id", clienteSelecionado.id);
            $("#tableCliente").show();
            $("#modalSeleccionarCliente").modal("hide");

        });

        $("#btnEditarCliente").click(function () {
            const clienteId = $(this).data("id");
            console.log("ID del cliente a editar:", clienteId);

            nombreOriginal = $("#nombre").val();
            emailOriginal = $("#email").val();
            direccionOriginal = $("#direccion").val();
            celularOriginal = $("#celular").val();

            $("#email").prop("readonly", false).attr("placeholder", "Ingrese el correo electrónico");
            $("#direccion").prop("readonly", false).attr("placeholder", "Ingrese la dirección");
            $("#celular").prop("readonly", false).attr("placeholder", "Ingrese el número de celular");
            $("#btnGuardarCon").show();
            $("#btnCancelar").show();
        });

        $("#btnCancelar").click(function () {

            $("#email").val(emailOriginal);
            $("#direccion").val(direccionOriginal);
            $("#celular").val(celularOriginal);

            $("#email").prop("readonly", true).attr("placeholder", "");
            $("#direccion").prop("readonly", true).attr("placeholder", "");
            $("#celular").prop("readonly", true).attr("placeholder", "");
            $("#btnGuardarCon").hide();
            $("#btnCancelar").hide();
        });

        $("#btnGuardarCon").click(function (){
            $("#modalSave").modal("show");
            $("#btnGuardarCliente").data("id", clienteSelecionado.id);
            console.log();
        });

        $("#btnGuardarCliente").click(function () {
            const clienteId = $(this).data("id");
            const nombre = $("#nombre").val();
            const email = $("#email").val();
            const direccion = $("#direccion").val();
            const celular = $("#celular").val();

            if (!clienteSelecionado) {
                alert("Por favor, selecciona un cliente antes de generar el PDF.");
                return;
            }

            const datosCliente = {
                _token: $("input[name='_token']").val(),
                nombre: nombre,
                email: email,
                direccion: direccion,
                celular: celular,
                id:clienteId
            };

            $.ajax({
            type: "POST",
            url: "ofertas/cliente/"+clienteId,
            data: datosCliente,
            dataType: "json",
            success: function (response) {
                console.log("Cliente actualizado con éxito:", response);
            },
            error: function (error) {
                console.error("Error al actualizar el cliente:", error);
            }
            });

            $("#direccion").prop("readonly", true);
            $("#celular").prop("readonly", true);
            $("#email").prop("readonly", true);
            $("#modalSave").modal("hide");
            $("#btnGuardarCon").hide();
            $("#btnCancelar").hide();


        });

        $("#BtnCrearPdf").click(function() {
            const proyecto = $("#proyecto option:selected").text();
            const selectorEtapa = $("#selectorEtapa option:selected").text();
            const selectorManzana = $("#selectorManzana option:selected").text();
            const selectorLote = $("#selectorLote option:selected").text();
            const PagoSeleccionado = $("#Pago").val();
            const nombre = $("#nombre").val();
            const PrecioNum = $("#PrecioNum").val();
            const AnualidadNum = $("#AnualidadNum").val();
            const Meses = $("#Meses").val();
            const EngancheNum = $("#EngancheNum").val();



            if (!clienteSelecionado) {
                alert("Por favor, selecciona un cliente antes de generar el PDF.");
            return;
            }
            $("#formAmortizacion input[name='proyecto']").val(proyecto);
            $("#formAmortizacion input[name='selectorEtapa']").val(selectorEtapa);
            $("#formAmortizacion input[name='selectorManzana']").val(selectorManzana);
            $("#formAmortizacion input[name='selectorLote']").val(selectorLote);
            $("#formAmortizacion input[name='nombre']").val(nombre);
            $("#formAmortizacion input[name='PrecioNum']").val(PrecioNum);
            $("#formAmortizacion input[name='AnualidadNum']").val(AnualidadNum);
            $("#formAmortizacion input[name='Meses']").val(Meses);
            $("#formAmortizacion input[name='EngancheNum']").val(EngancheNum);
            $("#formAmortizacion").submit();
            return;

        });

        $(document).ready(function() {
            $("#Pago").change(function() {
            const valorPago = $(this).val();

                $("#Meses").hide();
                $("#Enganche").hide();
                $("#BtnCrearPdf, #BtnModalOferta").hide();

            switch (valorPago) {
                case "Contado":
                    $("#BtnCrearPdf, #BtnModalOferta").show();
                    $("#Precio").show();
                    $("#Precio").prop("readonly", true);
                    $("#Meses").val("1");
                    $("#Enganche").val("0");
                    $("#EngancheNum").val(0);
                    $("#Anualidad").hide().val("0");
                    $("#AnualidadNum").hide().val(0);


                    break;
                case "Financiado":
                    $("#Meses").show();
                    $("#Meses").val("Selecciona el plazo");
                    $("#Meses option[value='6']").show();
                    $("#Precio").show();
                    $("#Precio").prop("readonly", true);
                    $("#BtnCrearPdf, #BtnModalOferta").show();
                    $("#Anualidad").hide().val("0");
                    $("#AnualidadNum").hide().val("0");
                    $("#Enganche").show();
                    $("#Enganche").val("").attr("placeholder", "Ingrese el Enganche");


                    break;
                case "ContadoPE":
                    $("#Precio").show();
                    $("#Precio").prop("readonly", false);
                    $("#Precio").val("").attr("placeholder", "Ingrese el precio");
                    $("#BtnCrearPdf, #BtnModalOferta").show();
                    $("#Meses").val("1");
                    $("#Enganche").val("0");
                    $("#EngancheNum").val(0);
                    $("#Anualidad").hide().val("0");
                    $("#AnualidadNum").hide().val(0);

                    break;
                case "FinanciadoPE":
                    $("#Meses").show();
                    $("#Meses").val("Selecciona el plazo");
                    $("#Meses option[value='6']").show();
                    $("#Precio").show();
                    $("#Precio").prop("readonly", false);
                    $("#Precio").val("").attr("placeholder", "Ingrese el precio");
                    $("#BtnCrearPdf, #BtnModalOferta").show();
                    $("#Anualidad").hide().val("0");
                    $("#AnualidadNum").hide().val(0);
                    $("#Enganche").show();
                    $("#Enganche").val("").attr("placeholder", "Ingrese el Enganche");


                    break;
                case "FinanciadoA":
                    $("#Meses").show();
                    $("#Meses").val("Selecciona el plazo");
                    $("#Meses option[value='6']").hide();
                    $("#Precio").show();
                    $("#Precio").prop("readonly", true);
                    $("#BtnCrearPdf, #BtnModalOferta").show();
                    $("#Anualidad").show();
                    $("#Anualidad").show().val("").attr("placeholder", "Ingrese la anualidad");
                    $("#Enganche").show();
                    $("#Enganche").val("").attr("placeholder", "Ingrese el Enganche");


                    break;
                case "FinanciadoPEA":
                    $("#Meses").show();
                    $("#Meses").val("Selecciona el plazo");
                    $("#Meses option[value='6']").hide();
                    $("#Precio").show();
                    $("#Precio").prop("readonly", false);
                    $("#Precio").val("").attr("placeholder", "Ingrese el precio");
                    $("#BtnCrearPdf, #BtnModalOferta").show();
                    $("#Anualidad").show();
                    $("#Anualidad").val("").attr("placeholder", "Ingrese la anualidad");
                    $("#Enganche").show();
                    $("#Enganche").val("").attr("placeholder", "Ingrese el Enganche");


                    break;
                default:
                    $("#Precio").hide();
                    $("#Precio").prop("readonly", true);
                    $("#Precio").val("")
                    $("#Anualidad").hide();
                    $("#Meses option[value='6']").show();

                    break;
            }
            });
        });

        document.getElementById("Pago").addEventListener('change', function() {
            const formaDePago = this.value;
            const precioInput = document.getElementById("Precio");
            const precioInputNum = document.getElementById("PrecioNum");




            if (formaDePago === 'Contado') {
                const precioTotal = precioCont * superficieLote;
                precioInput.value = currency(precioTotal.toFixed(2)).format();
                precioInputNum.value = precioTotal;

            } else if (formaDePago === 'Financiado' || formaDePago === 'FinanciadoA') {
                const precioTotal = precioFin * superficieLote;
                precioInput.value = currency(precioTotal.toFixed(2)).format();
                precioInputNum.value = precioTotal;

            }
            if (this.value === 'Seleciona la Forma de pago') {
                precioInput.value = "";

            }
        });

        $("#BtnModalOferta").click(()=>{
            $("#modalSaveOferta").modal("show")
        });


    </script>
@endsection
