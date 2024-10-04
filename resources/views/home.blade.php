@extends('layouts.app')
<style>

    /* Ocultar el contenedor de la búsqueda */
    #saldo_length  {
        display: none;
    }

    /* Ocultar el apartado de "Show" */
    #saldo_filter {
        display: none;
    }

    /* Colores status*/
    .estado-gris {
        color: gray;
    }

    .estado-naranja {
        color: orange;
    }

    .estado-verde {
        color: green;
    }

    .estado-rojo {
        color: red;
    }
</style>

@section('content')
    <div class="align-items-center flex-column d-flex">
        @if($admin)
        <div class="col-10 bg-white p-4 my-4" >
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h1>{{ __('Analitica de Negocio') }}</h1>
            </div>

            <div>
                <div>
                    <div>
                        <label for="proyecto" class="form-label">Proyecto</label>
                        <select class="form-select" name="proyecto" id="proyecto" required>
                            <option value="" selected disabled>Selecciona un proyecto</option>
                            @foreach ($proyectos as $p)
                                <option value="{{$p->id}}">{{$p->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_ini" class="form-label">Fecha inicial</label>
                        <input type="date" class="form-control" name="fecha_ini" id="fecha_ini" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin" class="form-label">Fecha final</label>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" onclick="obtenerDatos()" id=datos>Obtener datos</button>
                </div>
                <div class="row mt-2" style="display: none;" id="proyectoSelect">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style="text-align: center; height: 100px; overflow: hidden; font-size: 24px; font-weight: bold;" >
                                    Proyecto
                                </div>
                                <div class="card-body" id="proyecto_select" style="font-size: 45px; text-align: center;">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row mt-2" style="display: none;" id="analitkaRes">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header" style="text-align: center; height: 100px; overflow: hidden; font-size: 24px; font-weight: bold;">
                                Nuevos usuarios
                            </div>
                            <div class="card-body" id="newUsers" style="font-size: 45px; text-align: center;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" style="text-align: center; height: 100px; overflow: hidden; font-size: 24px; font-weight: bold;" >
                                Total en Pagos
                            </div>
                            <div class="card-body" id="totPag" style="font-size: 45px; text-align: center;">
                             </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header" style="text-align: center; height: 100px; overflow: hidden; font-size: 24px; font-weight: bold;">
                                Cantidad de pagos recibidos
                            </div>
                            <div class="card-body" id="canPag" style="font-size: 45px; text-align: center;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" style="display: none;" id="analitkaGra">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" style="text-align: center; font-size: 24px; font-weight: bold; " >
                                Pagos por concepto
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <canvas id="conceptoGra" ></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" style="text-align: center; font-size: 24px; font-weight: bold; " >
                                Pagos por tipo
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <canvas id="tipoGra"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="d-inline-flex gap-1">
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                             Ver pagos
                            </a>
                        </p>
                          <div class="collapse overflow-auto" id="collapseExample">
                            <table id="datosPagos" class="mt-4">
                            </table>
                          </div>
                    </div>
                </div>


            </div>

            <p><br></p>
            <p><br></p>

            <h2>Clientes con saldo pendiente</h2>
            <div class="overflow-auto">
            <table class="table display" id="saldo">
                <thead>
                <tr>
                    <th scope="col">Cliente</th>
                    <th scope="col">proyecto</th>
                    <th scope="col">Manzana</th>
                    <th scope="col">Lote</th>
                    <th scope="col">Menusalidades Vencidas</th>
                    <th scope="col">Menusalidades Pagadas</th>
                    <th scope="col">Mensualidades Pendientes</th>
                    <th scope="col">Enganche</th>
                    <th scope="col">Enganche Pagado</th>
                    <th scope="col">Enganche Pendiente</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($pendientesAdmin as $p)
                    <tr>
                        <th scope="row">{{$p["cliente"]}} Tel: {{$p["cliente_telefono"]}}</th>
                        <td>{{$p["proyecto"]}}</td>
                        <td>{{$p["manzana"]}}</td>
                        <td>{{$p["lote"]}}</td>
                        <td>${{number_format($p["mensualidades_vencidas"],2)}}</td>
                        <td>${{number_format($p["mensualidades_pagadas"],2)}}</td>
                        <td>${{number_format($p["mensualidades_pendientes"],2)}}</td>
                        <td>${{number_format($p["enganche"],2)}}</td>
                        <td>${{number_format($p["enganche_pagado"],2)}}</td>
                        <td>${{number_format($p["enganche_pendiente"],2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            <p><br></p>
            <p><br></p>

            <h2>Clientes con documentos por revisar</h2>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">id_contrato</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Lote</th>
                    <th scope="col">Acciones</th>


                </tr>
                </thead>
                <tbody>
                    @foreach ($documentosRevisar as $p)
                    <tr>
                        <td>{{$p["id"]}}</td>
                        <td>{{$p["id_contrato"]}}</td>
                        <td>{{$p["cliente"]}}</td>
                        <td>Proyecto: {{$p["proyecto"]}} <br>
                            Lote: {{$p["lote"]}} <br>
                            Manzana: {{$p["manzana"]}}
                        </td>
                        <td>
                            <button class="btn btn-primary" onclick="RevDocumentos({{$p['id_contrato']}})">Revisar documentos</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endif

        @if($cliente)
            {{-- {{auth()->user()->isClient}} --}}
            <div class="col-10 bg-white p-4 my-4" >
                <h2>Mis datos</h2>
                <form action="#" id="formEdit">
                    <div class="mb-3">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text" class="form-control" name="nombre" id="nombre" value="{{auth()->user()->isClient->nombre}}" placeholder="Aqui Escribe el Nombre del usuario" required readonly>
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="mail" class="form-control" name="email" id="email" value="{{auth()->user()->isClient->email}}" placeholder="Aqui Escribe el Email de Cliente" required readonly>
                    </div>

                    <div class="mb-3">
                      <label for="direccion" class="form-label">Direccion</label>
                      <input type="text" class="form-control" name="direccion" id="direccion" value="{{auth()->user()->isClient->direccion}}" placeholder="Aqui Escribe la Direccion de Cliente " required readonly>
                    </div>
                    <div class="mb-3">
                      <label for="celular" class="form-label">Numero de Celular</label>
                      <input type="tel" class="form-control" name="celular" id="celular" value="{{auth()->user()->isClient->celular}}" placeholder="Aqui Escribe el Numero Celular de Cliente " required readonly>
                    </div>
                    <input type="submit" value="Guardar" class="btn btn-success d-none">
                </form>
                    <button class="btn btn-primary" id="editarBtn">Editar</button>
            </div>

            @if($comprador)
                <div class="col-10 bg-white p-4 d-flex flex-column" >
                    <h1>
                        Tus compras
                    </h1>
                </div>
                @foreach ($contratos as $i => $c)
                <div class="col-10 bg-white p-4 my-4 d-flex flex-column" >
                    <h2>{{$c["proyecto"]}}</h2>
                    <div class="d-flex my-2">
                        <span class="me-1">Lote:</span>
                        <span class="me-1">{{$c["lote"]}}</span>
                        <span class="me-1">Manzana:</span>
                        <span class="me-1">{{$c["manzana"]}}</span>
                    </div>
                    <div class="d-flex my-2">
                        <span class="me-1">Saldo Vencido</span>
                        <span class="me-1">${{number_format($c["saldo_vencido"],2)}}</span>
                        <span class="me-1">Total Pagado</span>
                        <span class="me-1">${{number_format($c["total_pago"],2)}}</span>
                    </div>

                    <div class="d-flex gap-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                            Mostrar pagos
                        </button>
                        <button class="btn btn-primary" onclick="verEstadoCuenta({{$c['id_cliente']}},{{$c['id_lote']}})">
                           Ver Estado de Cuenta
                        </button>
                        <button class="btn btn-primary" onclick="VerDocumentos({{$c['id_contrato']}})">
                            Ver Documentos
                         </button>
                    </div>


                    <div class="collapse my-2" id="collapse{{$i}}">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Total</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Referencia</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($c["pagos"] as $p)
                                <tr>
                                    <th scope="row">{{$p["id"]}}</th>
                                    <td>{{number_format($p["total_pago"],2)}}</td>
                                    <td>{{$p["fechas"]}}</td>
                                    <td>{{$p["concepto"]}}</td>
                                    <td>{{$p["referencia_pago"]}}</td>
                                  </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>

                </div>


                @endforeach
            @endif

        @else
        @endif

    </div>

    <!-- Modal Ver Documentos -->
    <div class="modal fade modal-xl" id="docModal" tabindex="-1" role="dialog" aria-labelledby="docModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="docModallLabel">Documentos del contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" id="formDocModal">
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table class="table" id="docModalTable">
                                    <thead>
                                        <th style="text-align: left;"><h3>Documento</h3></th>
                                        <th style="text-align: right;"><h3>Estatus</h3></th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="display: none;">
                <div class="mb-3" >
                    <label for="resultIneAn" class="form-label">resultIneAn</label>
                    <input type="number" class="form-control" name="resultIneAn" id="resultIneAn"  pattern="[0-9]+">
                </div>
                <div class="mb-3">
                    <label for="resultIneRe" class="form-label">resultIneRe</label>
                    <input type="number" class="form-control" name="resultIneRe" id="resultIneRe"  pattern="[0-9]+">
                </div>
                <div class="mb-3">
                    <label for="resultComDom" class="form-label">resultComDom</label>
                    <input type="number" class="form-control" name="resultComDom" id="resultComDom"  pattern="[0-9]+">
                </div>
                <div class="mb-3">
                    <label for="resultFirma" class="form-label">resultFirma</label>
                    <input type="number" class="form-control" name="resultFirma" id="resultFirma"  pattern="[0-9]+">
                </div>
            </div>
                    <div class="modal-footer" style="display: none;" id="btnDoc">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abandonar</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="saveDocs" style="display: none;">Guardar Archivos</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="saveDocsRev" style="display: none;">Enviar Revision</button>
                    </div>


            </div>
        </div>
    </div>

@endsection
@section("scripts")
<script>

@if($admin)
     var ctx = document.getElementById('conceptoGra').getContext('2d');

     var datosConceptoGra = {
         labels: ['Anualidad', 'Mensualidad', 'Enganche','Apartado', 'Otros'],
         datasets: [{
             data: [],
             backgroundColor: ['red', 'blue', 'green','purple', 'orange'],
         }]
     };

     var conceptoGra = new Chart(ctx, {
         type: 'pie',
         data: datosConceptoGra,
         options: {
         }
     });

     var ctx = document.getElementById('tipoGra').getContext('2d');

     var datosTipoGra = {
         labels: ['Efectivo', 'Transferencia'],
         datasets: [{
             data: [],
             backgroundColor: ['green', 'blue'],
         }]
     };

     var tipoGra = new Chart(ctx, {
         type: 'pie',
         data: datosTipoGra,
         options: {
         }
     });

     @endif

     let pagosDatatble = $("#datosPagos").DataTable(
        {
            layout: {
                topStart: {
                    buttons: ['excelHtml5']
                }
            },
            searching: true,
            data : [],
            columns : [
                {
                    title : "ID",
                    data : "id"
                },
                {
                    title : "Total",
                    data : "total_pago"
                },
                {
                    title : "Referencia",
                    data : "referencia_pago"
                },
                {
                    title : "Proyecto",
                    data : "lote.proyecto.nombre"
                },
                {
                    title : "Lote",
                    data : "lote.lote"
                },
                {
                    title : "Manzana",
                    data : "lote.manzana"
                },
                {
                    title : "Concepto",
                    data : "concepto"
                },
                {
                    title : "Tipo",
                    data : "tipo"
                },
                {
                    title : "Fecha",
                    data : "fechas"
                },
                {
                    title : "Nombre",
                    data : "cliente.nombre"
                },
                {
                    title : "Email",
                    data : "cliente.email"
                }
            ],
            columnDefs: [
            {
                targets: 1,
                render: $.fn.dataTable.render.number(',', '.', 2, '$')
            }
            ],

        }
    )

    const obtenerDatos = () => {
        const proyecto_id = document.getElementById('proyecto').value;
        const fechaIni = document.getElementById('fecha_ini').value;
        const fechaFin = document.getElementById('fecha_fin').value;

        const fecha_ini = fechaIni + ' 00:00:00';
        const fecha_fin = fechaFin + ' 23:59:59';

        if (!proyecto_id) {
            axios.get(`analitika/${fecha_ini}/${fecha_fin}`)
            .then(response => {
                console.log('Datos obtenidos:', response.data);
                let data = response.data;

                let pagosTotalFormatted = Number(data.pagos_total).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });

                document.getElementById('newUsers').innerText = `${data.usuarios}`;
                document.getElementById('totPag').innerText = `${pagosTotalFormatted}`;
                document.getElementById('canPag').innerText = `${data.pagos}`;

                conceptoGra.data.datasets[0].data = [data.pagos_Anu, data.pagos_mens, data.pagos_eng,data.pagos_apart, data.pagos_otros];
                conceptoGra.update();

                tipoGra.data.datasets[0].data = [data.pagos_efe, data.pagos_Trans];
                tipoGra.update();


                pagosDatatble.clear()
                pagosDatatble.rows.add(data.pagosArr);
                pagosDatatble.draw();

                $("#analitkaRes").show();
                $("#analitkaGra").show();


            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
            });

        }else{
            axios.get(`analitika/${proyecto_id}/${fecha_ini}/${fecha_fin}`)
                .then(response => {
                    console.log('Datos obtenidos2:', response.data);
                    let data = response.data;

                    let pagosTotalFormatted = Number(data.pagos_total).toLocaleString('es-MX', {
                        style: 'currency',
                        currency: 'MXN'
                    });

                    document.getElementById('proyecto_select').innerText = `${data.proyecto_nombre}`;
                    document.getElementById('newUsers').innerText = `${data.usuarios}`;
                    document.getElementById('totPag').innerText = `${pagosTotalFormatted}`;
                    document.getElementById('canPag').innerText = `${data.pagos}`;

                    conceptoGra.data.datasets[0].data = [data.pagos_Anu, data.pagos_mens, data.pagos_eng,data.pagos_apart, data.pagos_otros];
                    conceptoGra.update();

                    tipoGra.data.datasets[0].data = [data.pagos_efe, data.pagos_Trans];
                    tipoGra.update();

                    pagosDatatble.clear()
                    pagosDatatble.rows.add(data.pagosArr);
                    pagosDatatble.draw();

                    $("#analitkaRes").show();
                    $("#analitkaGra").show();
                    $("#proyectoSelect").show();

                })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                });
        }


    }


    $("#editarBtn").click(function (e) {
        console.log("ad")
        e.preventDefault();
        $("#formEdit input").prop("readonly", false);
        $("#formEdit input[type='submit']").removeClass("d-none");
        $("#editarBtn").addClass("d-none");

    });

    $("#formEdit").submit(function (e) {
        e.preventDefault();
        let req = new FormData(document.getElementById("formEdit"));
        req.append("_method","PUT")
        axios.post("/clientesUpdate",req).then((e)=>{
            $("#formEdit input[type='submit']").addClass("d-none");
            $("#editarBtn").removeClass("d-none");
        })

    });
    const verEstadoCuenta = (id,lote) => {
        window.open("clientes/estado-cuenta/"+id+"/"+lote);
        }

    let id_documento;

    const VerDocumentos = (id_contrato) => {

        $("#saveDocs").show();
        $("#saveDocsRev").hide();
        $("#docModallLabel").html("Documentos del contrato");
        $("#docModal").modal("show");
        id_documento = id_contrato;

        axios.get(`/documentos/${id_contrato}`)
            .then(response => {
                const documentos = response.data;
                const s_ine_anverso = documentos.s_ine_anverso;
                const s_ine_reverso = documentos.s_ine_reverso;
                const s_com_dom = documentos.s_com_dom;
                const s_firma = documentos.s_firma;

                if (s_ine_anverso === 2 && s_ine_reverso === 2 && s_com_dom === 2 && s_firma === 2) {
                    $("#btnDoc").hide();
                } else {
                    $("#btnDoc").show();
                }

                $('#docModalTable tbody').empty();

                const getColorClass = (estado) => {
                    switch (estado) {
                        case 0:
                            return "estado-gris";
                        case 1:
                            return "estado-naranja";
                        case 2:
                            return "estado-verde";
                        case 3:
                            return "estado-rojo";
                        default:
                            return "estado-gris";
                    }
                };

                $('#docModalTable tbody').append(`
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>INE anverso</h5></p><br>
                        ${documentos.ine_anverso ? `<img src="/storage/${documentos.ine_anverso}" alt="Documento" style="max-width: 800px;">` : `<input type="file" id="ine_anverso" accept="image/*">`}
                    </td>
                    <td class="${getColorClass(documentos.s_ine_anverso)}" style="text-align: right; vertical-align: middle;"><p class="${getColorClass(documentos.s_ine_anverso)}"><b>${documentos.s_ine_anverso === 0 ? 'Sin documento' : documentos.s_ine_anverso === 1 ? 'Revision' : documentos.s_ine_anverso === 2 ? 'Aceptado' : documentos.s_ine_anverso === 3 ? 'Rechazado' : 'Estado no definido'}</p></td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>INE reverso</h5></p><br>
                        ${documentos.ine_reverso ? `<img src="/storage/${documentos.ine_reverso}" alt="Documento" style="max-width: 800px;">` : `<input type="file" id="ine_reverso" accept="image/*">`}
                    </td>
                    <td class="${getColorClass(documentos.s_ine_reverso)}" style="text-align: right; vertical-align: middle;"><p class="${getColorClass(documentos.s_ine_reverso)}"><b>${documentos.s_ine_reverso === 0 ? 'Sin documento' : documentos.s_ine_reverso === 1 ? 'Revision' : documentos.s_ine_reverso === 2 ? 'Aceptado' : documentos.s_ine_reverso === 3 ? 'Rechazado' : 'Estado no definido'}</p></td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>Comprobante de domicilio</h5></p><br>
                        ${documentos.com_dom ? `<img src="/storage/${documentos.com_dom}" alt="Documento" style="max-width: 800px;">` : `<input type="file" id="com_dom" accept="image/*">`}
                    </td>
                    <td class="${getColorClass(documentos.s_com_dom)}" style="text-align: right; vertical-align: middle;"><p class="${getColorClass(documentos.s_com_dom)}"><b>${documentos.s_com_dom === 0 ? 'Sin documento' : documentos.s_com_dom === 1 ? 'Revision' : documentos.s_com_dom === 2 ? 'Aceptado' : documentos.s_com_dom === 3 ? 'Rechazado' : 'Estado no definido'}</p></td>
                </tr>
                <tr>
                    <td style="text-align: left; ">
                        <p><h5><b>Firma</h5></p><br>

                            <div class="d-flex flex-column">
                                ${documentos.firma ? `<img src="${documentos.firma}" alt="Documento" style="max-width: 400px;">` : `<input type="hidden" id="firma" accept="image/*">
                                <canvas id="draw-canvas" style="width: 400px; border: 1px solid;">
                                    Nopodras guardar tu firma desde este navegadro
                                </canvas>
                                <img id="draw-image" src="" alt="" style="width: 400px;"/>
                                <div>
                                    <input type="button" class="button" id="draw-submitBtn" value="Guardar Firma"></input>
                                    <input type="button" class="button" id="draw-clearBtn" value="Borrar Firma"></input>
                                </div>
                            </div>

                        `}
                    </td>
                    <td class="${getColorClass(documentos.s_firma)}" style="text-align: right; vertical-align: middle;"><p class="${getColorClass(documentos.s_firma)}"><b>${documentos.s_firma === 0 ? 'Sin documento' : documentos.s_firma === 1 ? 'Revision' : documentos.s_firma === 2 ? 'Aceptado' : documentos.s_firma === 3 ? 'Rechazado' : 'Estado no definido'}</p></td>
                </tr>
            `);
            if ($("#draw-canvas")) {
                (function() { // Comenzamos una funcion auto-ejecutable

                // Obtenenemos un intervalo regular(Tiempo) en la pamtalla
                window.requestAnimFrame = (function (callback) {
                    return window.requestAnimationFrame ||
                                window.webkitRequestAnimationFrame ||
                                window.mozRequestAnimationFrame ||
                                window.oRequestAnimationFrame ||
                                window.msRequestAnimaitonFrame ||
                                function (callback) {
                                    window.setTimeout(callback, 1000/60);
                        // Retrasa la ejecucion de la funcion para mejorar la experiencia
                                };
                })();

                // Traemos el canvas mediante el id del elemento html
                var canvas = document.getElementById("draw-canvas");
                var ctx = canvas.getContext("2d");


                // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
                var drawText = document.getElementById("firma");
                var drawImage = document.getElementById("draw-image");
                var clearBtn = document.getElementById("draw-clearBtn");
                var submitBtn = document.getElementById("draw-submitBtn");
                clearBtn.addEventListener("click", function (e) {
                    // Definimos que pasa cuando el boton draw-clearBtn es pulsado
                    clearCanvas();
                    drawImage.setAttribute("src", "");
                    $("#draw-image").hide()
                    $("#draw-canvas").show()
                }, false);
                    // Definimos que pasa cuando el boton draw-submitBtn es pulsado
                submitBtn.addEventListener("click", function (e) {
                var dataUrl = canvas.toDataURL();
                drawText.value = dataUrl;
                drawImage.setAttribute("src", dataUrl);
                    $("#draw-image").show()
                    $("#draw-canvas").hide()
                }, false);

                // Activamos MouseEvent para nuestra pagina
                var drawing = false;
                var mousePos = { x:0, y:0 };
                var lastPos = mousePos;
                canvas.addEventListener("mousedown", function (e)
                {
                /*
                Mas alla de solo llamar a una funcion, usamos function (e){...}
                para mas versatilidad cuando ocurre un evento
                */

                    console.log(e);
                    drawing = true;
                    lastPos = getMousePos(canvas, e);
                }, false);
                canvas.addEventListener("mouseup", function (e)
                {
                    drawing = false;
                }, false);
                canvas.addEventListener("mousemove", function (e)
                {
                    mousePos = getMousePos(canvas, e);
                }, false);

                // Activamos touchEvent para nuestra pagina
                canvas.addEventListener("touchstart", function (e) {
                    $("*").css("overflow", "hidden");
                    mousePos = getTouchPos(canvas, e);
                console.log(mousePos);
                e.preventDefault(); // Prevent scrolling when touching the canvas
                    var touch = e.touches[0];
                    var mouseEvent = new MouseEvent("mousedown", {
                        clientX: touch.clientX,
                        clientY: touch.clientY
                    });
                    canvas.dispatchEvent(mouseEvent);
                }, false);
                canvas.addEventListener("touchend", function (e) {
                    $("*").css("overflow", "auto");
                e.preventDefault(); // Prevent scrolling when touching the canvas
                    var mouseEvent = new MouseEvent("mouseup", {});
                    canvas.dispatchEvent(mouseEvent);
                }, false);
                canvas.addEventListener("touchleave", function (e) {
                    $("*").css("overflow", "auto");
                // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
                e.preventDefault(); // Prevent scrolling when touching the canvas
                var mouseEvent = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(mouseEvent);
                }, false);
                canvas.addEventListener("touchmove", function (e) {
                e.preventDefault(); // Prevent scrolling when touching the canvas
                    var touch = e.touches[0];
                    var mouseEvent = new MouseEvent("mousemove", {
                        clientX: touch.clientX,
                        clientY: touch.clientY
                    });
                    canvas.dispatchEvent(mouseEvent);
                }, false);

                // Get the position of the mouse relative to the canvas
                function getMousePos(canvasDom, mouseEvent) {
                    var rect = canvasDom.getBoundingClientRect();
                /*
                Devuelve el tamaño de un elemento y su posición relativa respecto
                a la ventana de visualización (viewport).
                */
                    return {
                        x: mouseEvent.clientX - rect.left,
                        y: mouseEvent.clientY - rect.top
                    };
                }

                // Get the position of a touch relative to the canvas
                function getTouchPos(canvasDom, touchEvent) {
                    var rect = canvasDom.getBoundingClientRect();
                console.log(touchEvent);
                /*
                Devuelve el tamaño de un elemento y su posición relativa respecto
                a la ventana de visualización (viewport).
                */
                    return {
                        x: touchEvent.touches[0].clientX - rect.left, // Popiedad de todo evento Touch
                        y: touchEvent.touches[0].clientY - rect.top
                    };
                }

                // Draw to the canvas
                function renderCanvas() {
                    if (drawing) {
                ctx.strokeStyle = "#0000ff";
                ctx.beginPath();
                        ctx.moveTo(lastPos.x, lastPos.y);
                        ctx.lineTo(mousePos.x, mousePos.y);

                    ctx.lineWidth = 2;
                        ctx.stroke();
                ctx.closePath();
                        lastPos = mousePos;
                    }
                }

                function clearCanvas() {
                    canvas.width = canvas.width;
                }

                // Allow for animation
                (function drawLoop () {
                    requestAnimFrame(drawLoop);
                    renderCanvas();
                })();

                })();
            }
        })
        .catch(error => {
            console.error("Error al obtener los documentos:", error);
        });
    };

    const RevDocumentos = (id_contrato) => {

        $("#saveDocs").hide();
        $("#saveDocsRev").show();
        $("#docModallLabel").html("Revisar documentos");
        $("#docModal").modal("show");
        id_documento = id_contrato;

        axios.get(`/documentos/${id_contrato}`)
            .then(response => {
                const documentos = response.data;
                const s_ine_anverso = documentos.s_ine_anverso;
                const s_ine_reverso = documentos.s_ine_reverso;
                const s_com_dom = documentos.s_com_dom;
                const s_firma = documentos.s_firma;

                if (s_ine_anverso === 2 && s_ine_reverso === 2 && s_com_dom === 2 && s_firma === 2) {
                    $("#btnDoc").hide();
                } else {
                    $("#btnDoc").show();
                }

                $('#docModalTable tbody').empty();

                const getColorClass = (estado) => {
                    switch (estado) {
                        case 0:
                            return "estado-gris";
                        case 1:
                            return "estado-naranja";
                        case 2:
                            return "estado-verde";
                        case 3:
                            return "estado-rojo";
                        default:
                            return "estado-gris";
                    }
                };

                const sinDocumento = (documentoUrl, firma = false) => {
                    if (firma) {
                        return `<img src="${documentoUrl}" alt="Documento" style="max-width: 400px;">`;
                    }
                    if (documentoUrl !== null) {
                        return `<img src="/storage/${documentoUrl}" alt="Documento" style="max-width: 800px;">`;
                    } else {
                        return `No se ha agregado ningún documento.`;
                    }
                };

                const mostrarBotonesIneAn = (documentoUrl,status) => {
                    if (documentoUrl !== null) {
                        if (status == 2) {
                            return '<span  style="color: green; text-align: right; vertical-align: middle;" >Aceptado</span>';

                            } else {
                                return `<button type="button" class="btn btn-success" id="aceptarIneAn">Aceptar</button>
                            <button type="button" class="btn btn-danger" id="rechazarIneAn">Rechazar</button>`;
                            }
                        return `
                            <button type="button" class="btn btn-success" id="aceptarIneAn">Aceptar</button>
                            <button type="button" class="btn btn-danger" id="rechazarIneAn">Rechazar</button>
                        `;
                    } else {
                        return ``;
                    }
                };

                const mostrarBotonesIneRe = (documentoUrl,status) => {
                    if (documentoUrl !== null) {
                        if (status == 2) {
                            return '<span  style="color: green; text-align: right; vertical-align: middle;" >Aceptado</span>';

                            } else {
                                return `<button type="button" class="btn btn-success" id="aceptarIneRe">Aceptar</button>
                                        <button type="button" class="btn btn-danger" id="rechazarIneRe">Rechazar</button>`;
                            }
                        return `
                            <button type="button" class="btn btn-success" id="aceptarIneRe">Aceptar</button>
                            <button type="button" class="btn btn-danger" id="rechazarIneRe">Rechazar</button>
                        `;
                    } else {
                        return ``;
                    }
                };

                const mostrarBotonesComDom = (documentoUrl,status) => {
                    if (documentoUrl !== null) {
                        if (status == 2) {
                            return '<span  style="color: green; text-align: right; vertical-align: middle;" >Aceptado</span>';

                            } else {
                                return `<button type="button" class="btn btn-success" id="aceptarComDom">Aceptar</button>
                                        <button type="button" class="btn btn-danger" id="rechazarComDom">Rechazar</button>`;
                            }
                        return `
                            <button type="button" class="btn btn-success" id="aceptarComDom">Aceptar</button>
                            <button type="button" class="btn btn-danger" id="rechazarComDom">Rechazar</button>
                        `;
                    } else {
                        return ``;
                    }
                };

                const mostrarBotonesFirma = (documentoUrl,status) => {
                    if (documentoUrl !== null) {
                        if (status == 2) {
                            return '<span  style="color: green; text-align: right; vertical-align: middle;">Aceptado</span>';

                            } else {
                                return `<button type="button" class="btn btn-success" id="aceptarFirma">Aceptar</button>
                                        <button type="button" class="btn btn-danger" id="rechazarFirma">Rechazar</button>`;
                            }
                        return `
                            <button type="button" class="btn btn-success" id="aceptarFirma">Aceptar</button>
                            <button type="button" class="btn btn-danger" id="rechazarFirma">Rechazar</button>
                        `;
                    } else {
                        return ``;
                    }
                };

                $('#docModalTable tbody').append(`
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>INE anverso</h5></p><br>
                        ${sinDocumento(documentos.ine_anverso)}
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        ${mostrarBotonesIneAn(documentos.ine_anverso,documentos.s_ine_anverso)}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>INE reverso</h5></p><br>
                        ${sinDocumento(documentos.ine_reverso)}
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        ${mostrarBotonesIneRe(documentos.ine_reverso,documentos.s_ine_reverso)}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>Comprobante de domicilio</h5></p><br>
                        ${sinDocumento(documentos.com_dom)}
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        ${mostrarBotonesComDom(documentos.com_dom,documentos.s_com_dom)}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p><h5><b>Firma</h5></p><br>
                        ${sinDocumento(documentos.firma, true)}
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        ${mostrarBotonesFirma(documentos.firma,documentos.s_firma)}
                    </td>
                </tr>
            `);
        })
        .catch(error => {
            console.error("Error al obtener los documentos:", error);
        });
    };

</script>
<script type="module">


    $("#saveDocs").click(function (e) {
        e.preventDefault();

        const docData = new FormData();

        const ineAnversoFile = $('#ine_anverso')[0] ? $('#ine_anverso')[0].files[0] : null;
        const ineReversoFile = $('#ine_reverso')[0] ? $('#ine_reverso')[0].files[0] : null;
        const comDomFile = $('#com_dom')[0] ? $('#com_dom')[0].files[0] : null;
        const firmaFile = $('#firma').val();

        if (ineAnversoFile) {
            docData.append('ine_anverso', ineAnversoFile);
        }
        if (ineReversoFile) {
            docData.append('ine_reverso', ineReversoFile);
        }
        if (comDomFile) {
            docData.append('com_dom', comDomFile);
        }
        if (firmaFile != "") {
            docData.append('firma', firmaFile);
        }

            axios.post(`/documentos/actualizados/${id_documento}`,docData)
        .then(response => {
        })
        .catch(error => {

        });

    });

    $(document).on('click', '#aceptarIneAn', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span  style="color: green; text-align: right; vertical-align: middle;" >Aceptado</span>');
        $('#resultIneAn').val('2');
    });

    $(document).on('click', '#rechazarIneAn', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span style="color: red; text-align: right; vertical-align: middle;">Rechazado</span>');
        $('#resultIneAn').val('3');
    });

    $(document).on('click', '#aceptarIneRe', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span  style="color: green; text-align: right; vertical-align: middle;" >Aceptado</span>');
        $('#resultIneRe').val('2');
    });

    $(document).on('click', '#rechazarIneRe', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span style="color: red; text-align: right; vertical-align: middle;" >Rechazado</span>');
        $('#resultIneRe').val('3');
    });

    $(document).on('click', '#aceptarComDom', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span  style="color: green; style="text-align: right; vertical-align: middle;">Aceptado</span>');
        $('#resultComDom').val('2');
    });

    $(document).on('click', '#rechazarComDom', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span style="color: red; text-align: right; vertical-align: middle;">Rechazado</span>');
        $('#resultComDom').val('3');
    });

    $(document).on('click', '#aceptarFirma', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span  style="color: green; text-align: right; vertical-align: middle;">Aceptado</span>');
        $('#resultFirma').val('2');
    });

    $(document).on('click', '#rechazarFirma', function() {
        $(this).closest('tr').find('button').hide();
        $(this).closest('tr').find('td:eq(0)').append('<span style="color: red; text-align: right; vertical-align: middle;">Rechazado</span>');
        $('#resultFirma').val('3');
    });

    $("#saveDocsRev").click(function (e) {
        e.preventDefault();

        const resultIneAn = $("#resultIneAn").val();
        const resultIneRe = $("#resultIneRe").val();
        const resultComDom = $("#resultComDom").val();
        const resultFirma = $("#resultFirma").val();

        const docData = new FormData();
        docData.append('resultIneAn', resultIneAn);
        docData.append('resultIneRe', resultIneRe);
        docData.append('resultComDom', resultComDom);
        docData.append('resultFirma', resultFirma);

            axios.post(`/documentos/revisado/${id_documento}`,docData)
        .then(response => {
        })
        .catch(error => {

        });

    });

    $(document).ready(function () {
        $('#saldo').DataTable({
            initComplete: function () {
                var table = this.api();
                table.columns().every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.header()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });

</script>
@endsection
