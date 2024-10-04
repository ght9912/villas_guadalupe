@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex mb-2 justify-content-between">
                <h1>Contratos</h1>
                <div class="botones">
                    {{-- <button class="btn btn-success" id="Addcont" >Genarar Contrato</button> --}}
                    <button class="btn btn-success" id="Addcont" >Vender Terreno</button>
                    <button id="btnImport" class="btn btn-success">Importar contratos</button>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-primary" id="tablaContratos">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Proyecto</th>
                            <th scope="col">Lote/Manzana</th>
                            <th scope="col">Superficie</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Total</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($contratos as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{$c->cliente->nombre}}</td>
                                <td>{{$c->lote->proyecto->nombre}}</td>
                                <td>{{$c->lote->lote}}/{{$c->lote->manzana}}</td>
                                <td>{{$c->lote->superficie}}</td>
                                <td>{{$c->estatus}}</td>
                                <td>{{$c->total}}</td>
                                <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="verPDF({{$c->id}})">Ver Contrato</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteContrato({{$c->id}},this)">Eliminar</button>

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
                        <label for="numero de celular" class="form-label">Numero de Celular</label>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelarOferta" >Cancelar</button>
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
                        <h5 class="modal-title" id="modalTitleId">Importar/Exportar -Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                    <form action="{{url('clientes/importar')}}" method="POST" id="formAddData" enctype="multipart/form-data">
                        @csrf
                        <div class="clo-md-6">
                            <input type="file" name="documento" required>
                        </div>
                        <div class="clo-md-6">
                           <button class="btn btn-primary" type="submit">Importar</button>
                        </div>


                    </form>
                    </div>
                    </div>

                    {{-- <div class="col-md-2">
                        <button class="btn btn-success"> Exportar</button>
                    </div> --}}
        </div>
       </div>
</div>

<!-- generar contrato backup
<div class="modal fade" id="modalAddcont" tabindex="-1" role="dialog" aria-labelledby="modalTitleIdAddcont" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Generar Contrato</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                    <form action="#" id="formCont">
                        <label for="">Cliente</label>
                        <div class="ms-2">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Selecciona Cliente</label>
                                <select class="form-select" id="select_clientes" name="c_cliente"></select>
                            </div>

                            {{-- <div class="mb-3">
                                <input type="text" class="form-control" name="" id="" placeholder="Aqui Escribe Nombre de parte Enajenante" required>
                            </div> --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="c_nombre" id="c_nombre" placeholder="Aqui Escribe el Nombre del Cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="c_direccion" id="c_direccion" placeholder="Aqui Escribe la direccion del Cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Celular</label>
                                <input type="text" class="form-control" name="c_celular" id="c_celular" placeholder="Aqui Escribe el Numero Celular del Cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Email</label>
                                <input type="text" class="form-control" name="c_email" id="c_email" placeholder="Aqui Escribe el Email del Cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Clave electoral</label>
                                <input type="text" class="form-control" name="c_electoral" id="c_electoral" placeholder="Aqui Escribe la Clave Electoral del Cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Responsable en caso de fallecer cliente</label>
                                <input type="text" class="form-control" name="c_fallecido" id="c_fallecido" placeholder="Aqui Escribe el Nombre del responsable en caso de fallecimiento" required>
                            </div>
                        </div>

                        <label for="">Enajenante</label>
                        <div class="ms-2">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Selecciona Enajenante</label>
                                <select class="form-select" id="select_enajenantes" name="e_enajenante"placeholder="Aqui Escribe el nombre del Enajenate" required></select>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="nombre" class="form-label">Indicie A Primer declaración</label>
                                <input type="text" class="form-control" name="indiceA" id="nombre" placeholder="Aqui Escribe el Nombre del usuario" required>
                            </div> --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Descripcion de Proyecto</label>
                                <input type="text" class="form-control" name="DesPro" id="nombre" placeholder="Aqui Escribe toda la informacion referentee a el proyecto" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Certificado Parcelario</label>
                                <input type="text" class="form-control" name="cerparce" id="nombre" placeholder="Aqui Escribe el numero de Certificado Parcelario" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Referencia Bancaria</label>
                                <input type="text" class="form-control" name="referencia" id="nombre" placeholder="Aqui Escribe la Referencia Bancaria" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Número de Contrato</label>
                                <input type="text" class="form-control" name="numcont" id="numcont" placeholder="Aqui Escribe el Número de Contrato" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="e_nombre" id="e_nombre" placeholder="Aqui Escribe el Nombre del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="e_direccion" id="e_direccion" placeholder="Aqui Escribe la direccion del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Email</label>
                                <input type="text" class="form-control" name="e_email" id="e_email" placeholder="Aqui Escribe el Email del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Clave Electoral</label>
                                <input type="text" class="form-control" name="e_electoral" id="e_electoral" placeholder="Aqui Escribe la Clave Electoral del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">R.A.N</label>
                                <input type="text" class="form-control" name="e_ran" id="e_ran" placeholder="Aqui Escribe el numero del Registro Nacinal Agrario" required>
                            </div>
                        </div>
                        <label for="">Datos del Lote</label>
                        <div class="ms-2">
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Proyectos</label>
                                <select class="form-select" id="select_proyectos" name="l_proyecto"></select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Zona</label>
                                <select class="form-select" id="select_zona"  name="l_zona">
                                    <option value = ''> Selecciona una Zona </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Manzana</label>
                                <select class="form-select" id="select_manzana"  name="l_manzana">
                                    <option value = ''> Selecciona una Manzana </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Lote</label>
                                <select class="form-select" id="select_lotes" name="l_lote">
                                    <option value = ''> Selecciona un Lote </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Tipo de Pago </label>
                                <select class="form-select" id="select_lotes_pago" name="l_tipo_pago">
                                    <option selected>Selecciona tipo de Pago</option>
                                    <option value="financiado">Financiado</option>
                                    <option value="contado">Contado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Superficie</label>
                                <input type="text" class="form-control" name="l_superficie" id="l_superficie" placeholder="Aqui Escribe la superficie en Metros Cuadrados" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Precio de Contado M2</label>
                                <input type="text" class="form-control" name="l_contado" id="l_contado" placeholder="Aqui Escribe el Precio de contado" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Precio Financiado M2 </label>
                                <input type="text" class="form-control" name="l_fin" id="l_fin" placeholder="Aqui Escribe el precio finaciado" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Precio Total </label>
                                <input type="text" class="form-control" name="l_total" id="l_total" placeholder="Aqui Escribe el Nombre del usuario" required>
                            </div>
                            <div id="form-financiado" style="display: none">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Anualidad por año</label>
                                    <input type="text" class="form-control" name="l_anualidad" id="l_anualidad" placeholder="Aqui Escribe el Nombre del usuario" required>
                                </div>
                                <div class="mb-3"  >
                                    <label for="nombre" class="form-label">Plazo </label>
                                    <select class="form-select" style="" name="Meses" id="Meses">
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
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Descripción de Engache </label>
                                    <div id="enganches" class="d-flex flex-column mb-1">
                                        <div class="w-100 ">
                                            <button class="btn btn-primary" type="button" id="addEnganche">Añadir Enganche</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Mensualidad</label>
                                    <input type="text" class="form-control" name="l_mensualidad" id="l_mensualidad" placeholder="Aqui Escribe el Pago de la Mansualidad" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fechas" class="form-label">Dia de Pago y Mes de arranque</label>
                                    <input type="date" class="form-control" name="l_fecha" id="l_fecha" required>
                                </div>
                            </div>




                        </div>
                        <label for="">Datos de la cuenta</label>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Selecciona Cuentas </label>
                            <select class="form-select" id="select_cuentas" name="select_cuentas"></select>
                        </div>
                        {{-- <label for="">Incisos a modificar</label>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Selecciona Lote</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aqui Escribe el Nombre del usuario" required>
                        </div> --}}



                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" >Vista Previa</button>
                        <button type="button" class="btn btn-success" id="descargarPDF">Generar Contrato</button>
                    </div>
                </form>
        </div>
       </div>
</div>
-->
<div class="modal fade" id="modalAddcont" tabindex="-1" role="dialog" aria-labelledby="modalTitleIdAddcont" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important">
        <div class="modal-content" >
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Vender Terreno</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                    <form action="#" id="formCont">
                        <label for="">Cliente</label>
                        <div class="ms-2">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Selecciona Cliente</label>
                                <select class="form-select" id="select_clientes" name="c_cliente"></select>
                            </div>

                            {{-- <div class="mb-3">
                                <input type="text" class="form-control" name="" id="" placeholder="Aqui Escribe Nombre de parte Enajenante" required>
                            </div> --}}
                            <div class="mb-3 d-none ">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="c_nombre" id="c_nombre" placeholder="Aqui Escribe el Nombre del Cliente" required>
                            </div>
                            <div class="mb-3 d-none">
                                <label for="nombre" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="c_direccion" id="c_direccion" placeholder="Aqui Escribe la direccion del Cliente" required>
                            </div>
                            <div class="mb-3 d-none">
                                <label for="nombre" class="form-label">Celular</label>
                                <input type="text" class="form-control" name="c_celular" id="c_celular" placeholder="Aqui Escribe el Numero Celular del Cliente" required>
                            </div>
                            <div class="mb-3 d-none">
                                <label for="nombre" class="form-label">Email</label>
                                <input type="text" class="form-control" name="c_email" id="c_email" placeholder="Aqui Escribe el Email del Cliente" required>
                            </div>
                            <div class="mb-3 d-none">
                                <label for="nombre" class="form-label">Clave electoral</label>
                                <input type="text" class="form-control" name="c_electoral" id="c_electoral" placeholder="Aqui Escribe la Clave Electoral del Cliente" required>
                            </div>
                            <div class="mb-3 d-none">
                                <label for="nombre" class="form-label">Responsable en caso de fallecer cliente</label>
                                <input type="text" class="form-control" name="c_fallecido" id="c_fallecido" placeholder="Aqui Escribe el Nombre del responsable en caso de fallecimiento" required>
                            </div>
                        </div>

                        <label for="" class= "d-none">Enajenante</label>
                        <div class="ms-2 d-none">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Selecciona Enajenante</label>
                                <select class="form-select" id="select_enajenantes" name="e_enajenante" placeholder="Aqui Escribe el nombre del Enajenate" ></select>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="nombre" class="form-label">Indicie A Primer declaración</label>
                                <input type="text" class="form-control" name="indiceA" id="nombre" placeholder="Aqui Escribe el Nombre del usuario" required>
                            </div> --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Descripcion de Proyecto</label>
                                <input type="text" class="form-control" name="DesPro" id="nombre" value="default" placeholder="Aqui Escribe toda la informacion referentee a el proyecto" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Certificado Parcelario</label>
                                <input type="text" class="form-control" name="cerparce" id="nombre" value="default" placeholder="Aqui Escribe el numero de Certificado Parcelario" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Referencia Bancaria</label>
                                <input type="text" class="form-control" name="referencia" id="nombre" value="default" placeholder="Aqui Escribe la Referencia Bancaria" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Número de Contrato</label>
                                <input type="text" class="form-control" name="numcont" id="numcont" value="default" placeholder="Aqui Escribe el Número de Contrato" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="e_nombre" id="e_nombre" value="default" placeholder="Aqui Escribe el Nombre del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="e_direccion" id="e_direccion" value="default" placeholder="Aqui Escribe la direccion del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Email</label>
                                <input type="text" class="form-control" name="e_email" id="e_email" value="default" placeholder="Aqui Escribe el Email del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Clave Electoral</label>
                                <input type="text" class="form-control" name="e_electoral" id="e_electoral" value="default" placeholder="Aqui Escribe la Clave Electoral del Enajenante" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">R.A.N</label>
                                <input type="text" class="form-control" name="e_ran" id="e_ran"  value="default" placeholder="Aqui Escribe el numero del Registro Nacinal Agrario" required>
                            </div>
                        </div>
                        <label for="">Datos del Lote</label>
                        <div class="ms-2">
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Proyectos</label>
                                <select class="form-select" id="select_proyectos" name="l_proyecto" required></select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Zona</label>
                                <select class="form-select" id="select_zona"  name="l_zona" required>
                                    <option value = ''> Selecciona una Zona </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Manzana</label>
                                <select class="form-select" id="select_manzana"  name="l_manzana" required>
                                    <option value = ''> Selecciona una Manzana </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Lote</label>
                                <select class="form-select" id="select_lotes" name="l_lote" required>
                                    <option value = ''> Selecciona un Lote </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lotes" class="form-label">Selecciona Tipo de Pago </label>
                                <select class="form-select" id="select_lotes_pago" name="l_tipo_pago" required>
                                    <option selected>Selecciona tipo de Pago</option>
                                    <option value="financiado">Financiado</option>
                                    <option value="contado">Contado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Superficie</label>
                                <input type="text" class="form-control" name="l_superficie" id="l_superficie" placeholder="Aqui Escribe la superficie en Metros Cuadrados" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Precio de Contado M2</label>
                                <input type="text" class="form-control" name="l_contado" id="l_contado" placeholder="Aqui Escribe el Precio de contado" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Precio Financiado M2 </label>
                                <input type="text" class="form-control" name="l_fin" id="l_fin" placeholder="Aqui Escribe el precio finaciado" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Precio Total </label>
                                <input type="text" class="form-control" name="l_total" id="l_total" placeholder="Aqui Escribe el Nombre del usuario" required>
                            </div>
                            <div id="form-financiado" style="display: none">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Anualidad por año</label>
                                    <input type="text" class="form-control" name="l_anualidad" id="l_anualidad" value="0" placeholder="Aqui Escribe el Nombre del usuario" required>
                                </div>
                                <div class="mb-3"  >
                                    <label for="nombre" class="form-label">Plazo </label>
                                    <select class="form-select" style="" name="Meses" id="Meses">
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
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Descripción de Engache </label>
                                    <div id="enganches" class="d-flex flex-column mb-1">
                                        <div class="w-100 ">
                                            <button class="btn btn-primary" type="button" id="addEnganche">Añadir Enganche</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Mensualidad</label>
                                    <input type="text" class="form-control" name="l_mensualidad" id="l_mensualidad" placeholder="Aqui Escribe el Pago de la Mansualidad" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fechas" class="form-label">Dia de Pago y Mes de arranque</label>
                                    <input type="date" class="form-control" name="l_fecha" id="l_fecha" required>
                                </div>
                            </div>




                        </div>
                        <label for="" class="d-none">Datos de la cuenta</label>
                        <div class="mb-3 d-none">
                            <label for="nombre" class="form-label">Selecciona Cuentas </label>
                            <select class="form-select" id="select_cuentas" name="select_cuentas"></select>
                        </div>
                        {{-- <label for="">Incisos a modificar</label>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Selecciona Lote</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aqui Escribe el Nombre del usuario" required>
                        </div> --}}



                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary d-none" >Vista Previa</button>
                        <button type="button" class="btn btn-success" id="descargarPDF">Vender</button>
                    </div>
                </form>
        </div>
       </div>
</div>


<!-- Modal Ver Ofertas -->
<div class="modal fade" id="ModalVerOfer" tabindex="-1" role="dialog" aria-labelledby="ModalVerOferTitle" aria-hidden="true">
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
                    <table class="table " id="table3">
                        <thead>
                            <th>Id</th>
                            <th>Proyecto</th>
                            <th>Zona</th>
                            <th>Manzana</th>
                            <th>Lote</th>
                            <th>Accionees</th>
                        </thead>
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
<div class="modal" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confirmas Generación de contrato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Seguro que deseas generar el contrato del terrono <span id="confirm_terreno"></span> en la manzana <span id="confirm_manzana"></span> en el proyecto <span id="confirm_proyecto"></span> para el cliente <span id="confirm_cliente"></span></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="confirmarContrato">Confirmar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancelarContrato">Cancelar</button>
        </div>
        </div>
    </div>
    </div>

@endsection


@section("scripts")
    <script >
        const mainData = {{ Js::from($clientes)}}
        const mainDataContratos = {{ Js::from($contratos)}}
        const mainRecursos = {{ Js::from($recursos)}}

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

        const findcontrato = (id) =>{
            let el;
            mainDataContratos.every((e)=>{
                if(e.id==id){
                    el=e;
                    return false
                }
                return true;
            })
            return el;
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
        const deleteContrato=(id,el)=>{
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id",id);
            $(el).parent().parent().parent().addClass("remove-"+id)
           // console.log();
        }

        const verPDF = (id, el) => {
            const contratos = findcontrato(id);

            if (contratos === undefined) {
                return;
            }
            console.log("Contrato", contratos);

            const objetoDelContrato = JSON.parse(contratos.objeto) ;

            console.log("Objeto completo:", objetoDelContrato);

            const data = {
                enganches: objetoDelContrato.enganches,
                e_nombre: objetoDelContrato.e_nombre,
                e_direccion: objetoDelContrato.e_direccion,
                e_celular: objetoDelContrato.e_celular,
                e_email: objetoDelContrato.e_email,
                e_ran: objetoDelContrato.e_ran,
                c_nombre: objetoDelContrato.c_nombre,
                c_direccion: objetoDelContrato.c_direccion,
                c_celular: objetoDelContrato.c_celular,
                c_email: objetoDelContrato.c_email,
                c_electoral: objetoDelContrato.c_electoral,
                DesPro: objetoDelContrato.DesPro,
                cerparce: objetoDelContrato.cerparce,
                l_superficie: objetoDelContrato.l_superficie,
                l_lote: objetoDelContrato.l_lote,
                l_manzana: objetoDelContrato.l_manzana,
                l_total: objetoDelContrato.l_total,
                l_fecha: objetoDelContrato.l_fecha,
                Meses: objetoDelContrato.Meses,
                l_mensualidad: objetoDelContrato.l_mensualidad,
                l_anualidad: objetoDelContrato.l_anualidad,
                select_cuentas: objetoDelContrato.select_cuentas,
                c_fallecido: objetoDelContrato.c_fallecido,
                fecha: objetoDelContrato.fecha,
                referencia: objetoDelContrato.referencia,
                numcont: objetoDelContrato.numcont,
            };

            data._token = $("input[name='_token']").val();

            $.ajax({
                type: "post",
                url: "/contratos/vistaprevia",
                data: data,
                dataType: "html",
                success: function (response) {
                    let nuevaVentana = window.open();
                    nuevaVentana.document.write(response);
                },
                error: function (error) {
                    console.error(error);
                }

            });
        };


        const AgregarCliente=(id,el)=>{
            $("#modalAgregarCliente").modal("show");
            $("#modalAgregarCliente").data("id",id);
            $("#modalfinduser").modal("hide");
           // console.log();
        }
        const verOfertas = (cliente_id) => {
            axios.get(`clientes/ofertas/${cliente_id}`)
            .then(response => {


                const dt = $('#table3').DataTable();
                    dt.clear().draw();

                const ofertas = response.data.ofertas;
                    console.log('ofertas', ofertas);

                ofertas.forEach(oferta => {
                    const nombreProyecto = oferta.proyecto_id;
                    const nombreZona = oferta.zona_id;
                    const nombreManzana = oferta.manzana;
                    const nombreLote = oferta.lote_id;

                let buttons = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="genCon(${oferta.id},this)">Generar contrato</button>
                                    <a href="{{route('pdf')}}" class="btn btn-success" target="_blank">Generar Contrato</a>
                                </div>`



                dt.row.add([oferta.id, nombreProyecto, nombreZona,nombreManzana, nombreLote, buttons]).draw();
            });
            })
            .catch(error => {
                console.error(error);
            });

            $('#ModalVerOfer').modal('show');
        };
        const findInArrayById = (arrar, id) => {
            let el;
            arrar.every((e)=>{
                if(e.id==id){
                    el=e;
                    return false
                }
                return true;
            })
            return el;
        }
        const calcularTotal = () => {
            let tipo_pago = $("#select_lotes_pago").val();

            if(tipo_pago == "financiado") {
                let precioM2 =  $("#l_fin").val() || 0;
                let superficie = $("#l_superficie").val() || 0;

                let l_total_actual = parseFloat($("#l_total").val()) || 0;
                let precioTotal = precioM2 * superficie;
                $("#l_total").val(precioTotal.toFixed(2));

                let plazo  = $("#Meses").val() == "" ? 1 : $("#Meses").val();
                let anualidad = parseFloat($("#l_anualidad").val()) || 0;

                let anualidadTotal = anualidad * Math.floor(plazo / 12);

                let totalEnganche = 0;
                $('input[type="text"][name*="enganche"]').each(function() { totalEnganche += parseFloat($(this).val())});

                let mensualidad = (precioTotal - totalEnganche-anualidadTotal)/plazo;
                $("#l_mensualidad").val(mensualidad);


            } else {
                let precioM2 = parseFloat($("#l_contado").val()) || 0;
                let superficie = parseFloat($("#l_superficie").val()) || 0;

                let l_total_actual = parseFloat($("#l_total").val()) || 0;
                let precioTotal = precioM2 * superficie;
                $("#l_total").val(precioTotal.toFixed(2));
                $("#l_anualidad").val(0);
                $("#l_mensualidad").val(0);

                var fechaActual = new Date();

                var formattedFechaActual = fechaActual.toISOString().split('T')[0];

                $("#l_fecha").val(formattedFechaActual);
            }
        }

        function getDistinctKeyValues(arrayOfObjects, key) {
            const distinctValues = new Set(arrayOfObjects.map(obj => obj[key]));
            return Array.from(distinctValues);
        }
        function recalcualte () {
            calcularTotal()
        }

    </script>
    <script type="module">
        let userInputs = [
            {
                id: "c_nombre",
                editable: false,
                campo: "nombre"
            },
            {
                id: "c_email",
                editable: false,
                campo: "email"
            },
            {
                id: "c_direccion",
                editable: true,
                campo: "direccion"
            },
            {
                id: "c_electoral",
                editable: true,
                campo: "nombre"
            },
            {
                id: "c_fallecido",
                editable: true,
                campo: "nombre"
            },
            {
                id: "c_celular",
                editable: true,
                campo: "celular"
            },
        ]
        let loteInputs = [
            {
                id: "l_superficie",
                editable: false,
                campo: "superficie"
            },
            {
                id: "l_lote",
                editable: false,
                campo: "lote"
            },
            {
                id: "l_manzana",
                editable: false,
                campo: "manzana"
            },
            {
                id: "l_fin",
                editable: true,
                campo: "etapa.precio_fin"
            },
            {
                id: "l_contado",
                editable: true,
                campo: "etapa.precio_cont"
            },
            {
                id: "c_celular",
                editable: true,
                campo: "celular"
            },
        ]

        const initSelects = () => {
            //clientes
            $("#select_clientes").empty();
            $("#select_clientes").append(`
                <option value = ''> Selecciona un Cliente </option>
                `)
            mainData.forEach( (e) => {
                $("#select_clientes").append(`
                <option value = '${e.id}'> ${e.nombre}(${e.celular}) </option>
                `)
            })
            $("#select_clientes").change((e)=>{
                let value = $(e.target).val();
                if(value == ""){
                    userInputs.forEach((e) => {
                        $("#"+e.id).val("");
                        $("#"+e.id).prop("readonly", e.editable);
                    })
                    return;
                }else {
                    let cliente = findclientes(value);
                    userInputs.forEach((e) => {
                        let select = "#"+e.id;
                        $(select).val(cliente[e.campo]);
                        $(select).prop("readonly", e.editable);
                    })
                }
            })
            //Proyectos
            $("#select_proyectos").empty();
            $("#select_proyectos").append(`
                <option value = ''> Selecciona un Proyecto </option>
                `)
            mainRecursos.proyectos.forEach( (e) => {
                $("#select_proyectos").append(`
                <option value = '${e.id}'> ${e.nombre} </option>
                `)
            })
            $("#select_proyectos").change((e)=>{
                let value = $(e.target).val();
                if(value == "") {
                    $("#select_zona").empty();
                    $("#select_zona").append(`
                        <option value = ''> Selecciona un Proyecto </option>
                        `)
                    $("#select_lotes").empty();
                    $("#select_lotes").append(`
                        <option value = ''> Selecciona un Proyecto </option>
                        `)
                    $("#select_manzana").empty();
                    $("#select_manzana").append(`
                        <option value = ''> Selecciona un Proyecto </option>
                        `)

                    return;
                } else {
                    $("#select_zona").empty();
                    $("#select_zona").append(`
                        <option value = ''> Selecciona una Zona </option>
                        `)
                    //console.log( mainRecursos.etapas.filter(e => e.proyecto_id == value));
                    mainRecursos.etapas.filter(e => e.proyecto_id == value).forEach((e) => {
                        $("#select_zona").append(`
                        <option value = '${e.id}'> ${e.e_name} </option>
                        `)
                    })
                    $("#select_lotes").empty();
                    $("#select_lotes").append(`
                        <option value = ''> Selecciona una Zona </option>
                        `)
                    $("#select_manzana").empty();
                    $("#select_manzana").append(`
                        <option value = ''> Selecciona una Zona </option>
                        `)
                    //Zonas/Etapas
                    $("#select_zona").change((e)=>{
                        let valueZ = $(e.target).val();
                        if(valueZ == "") {
                            $("#select_lotes").empty();
                            $("#select_lotes").append(`
                                <option value = ''> Selecciona una Manzana </option>
                            `)
                        } else {
                            $("#select_manzana").empty();
                            $("#select_manzana").append(`
                                <option value = ''> Selecciona una Manzana </option>
                            `)
                            $("#select_lotes").empty();
                            $("#select_lotes").append(`
                                <option value = ''> Selecciona una Manzana </option>
                                `)
                            //console.log( mainRecursos.lotes.filter(e => e.proyecto_id == value && e.etapa_id == valueZ));
                            let array = mainRecursos.lotes.filter(e => e.proyecto_id == value && e.etapa_id == valueZ)
                            getDistinctKeyValues(array,"manzana").forEach((e) => {
                                $("#select_manzana").append(`
                                    <option value = '${e}'> ${e} </option>
                                `)
                            })
                            let etapa = findInArrayById(mainRecursos.etapas,valueZ)
                            $("#l_fin").val(etapa.precio_fin);
                            $("#l_contado").val(etapa.precio_cont);
                            //Manzanas
                            $("#select_manzana").change((e) => {
                                let valueM = $(e.target).val();
                                if(valueM == "") {
                                    $("#select_lotes").empty();
                                    $("#select_lotes").append(`
                                        <option value = ''> Selecciona un Lote </option>
                                    `)
                                } else {
                                    $("#select_lotes").empty();
                                    $("#select_lotes").append(`
                                        <option value = ''> Selecciona un Lote </option>
                                    `)
                                    let lotesFiltrados = mainRecursos.lotes.filter(lote =>
                                        lote.proyecto_id == value && lote.etapa_id == valueZ && lote.manzana == valueM
                                    );

                                    let lotesSinContrato = lotesFiltrados.filter(lote =>
                                        !mainDataContratos.some(contrato => contrato.id_lote === lote.id)
                                    );

                                    lotesSinContrato.forEach((e) => {
                                        $("#select_lotes").append(`
                                            <option value='${e.id}'>${e.lote}</option>
                                        `);
                                    });

                                    //lotes
                                    $("#select_lotes").change((e) => {
                                        let valueL = $(e.target).val();
                                        if(valueL == "") return;
                                        else {
                                            let lote = findInArrayById(mainRecursos.lotes,valueL)
                                            $("#l_superficie").val(lote.superficie)
                                        }
                                    })
                                }
                            })
                        }
                    })
                }
            });
            $("#select_lotes_pago").change((e) => {
                let val = $(e.target).val();
                if (val != "financiado") {
                    $("#form-financiado").hide();
                    $("#enganches").parent().hide();
                    $("#l_anualidad").val("0");
                    $("#l_mensualidad").val("0");
                    let fechaActual = new Date();

                    let formattedFechaActual = fechaActual.toISOString().split('T')[0];

                    $("#l_fecha").val(formattedFechaActual);

                } else {
                    $("#form-financiado").show();
                    $("#enganches").parent().show()
                }
                calcularTotal();
            })
            $("#l_fecha").empty();
            $("#l_fecha").append(`
                <option value = ''> Selecciona la fecha de arranque </option>
                `)
            $("#select_enajenantes").empty();
            $("#select_enajenantes").append(`
                <option value = ''> Selecciona un Enajenante </option>
                `)
                mainRecursos.enajenantes.forEach( (e) => {
                    $("#select_enajenantes").append(`
                    <option value = '${e.id}'> ${e.nombre} </option>
                    `)
            })
            $("#select_enajenantes").change((e) => {
                let val = $(e.target).val();
                const el = findInArrayById(mainRecursos.enajenantes,val)
                console.log(el);
                if(!el) {
                    $("#e_nombre").val("");
                    $("#e_direccion").val("");
                    $("#e_email").val("");
                    $("#e_ran").val("");
                    $("#e_electoral").val("");
                    return;
                }

                $("#e_nombre").val(el.nombre);
                $("#e_direccion").val(el.direccion);
                $("#e_email").val(el.email);
                $("#e_ran").val(el.num_ran);
                $("#e_electoral").val(el.clave_electoral);
            })

            $("#select_cuentas").empty();
            $("#select_cuentas").append(`
                <option value = ''> Selecciona una Cuenta </option>
                `)
            mainRecursos.cuentas.forEach( (e,i) => {

                $("#select_cuentas").append(`
                <option value = '${e.id}' ${i == 0 ? "selected":""}> ${e.beneficiario}/${e.banco}/${e.clabe_inter} </option>
                `)
            })
        };
        $(document).ready(()=>{
            $(".table").DataTable()
            initSelects();
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
            let form=document.getElementById("formAdd");
            if(!form.checkValidity()){
                form.reportValidity();
                return
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

                const dt=$(".table").DataTable();
                    const r = e.data.data
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="verOfertas(${r.id},this)">Ver Ofertas</button>
                                <button type="button" class="btn btn-primary" onclick="editclientes(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes(${r.id},this)">Eliminar</button>
                                </div>`
                    dt.row($('.update-'+id)).data([r.id,r.user_id,r.nombre,r.email,r.direccion,r.celular,buttons]).draw()

            }).catch((e)=>{
                console.log(e);
            })
            }else{
                axios.post("",data).then((e)=>{
                    $("#modalAdd").modal("hide")
                    $("#formAdd").trigger("reset")
                    const dt=$(".table").DataTable();
                    const r = e.data.data
                    let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                    let buttons = `<div class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="verOfertas(${r.id},this)">Ver Ofertas</button>
                                <button type="button" class="btn btn-primary" onclick="editclientes(${r.id},this)">Editar</button>
                                <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes(${r.id},this)">Eliminar</button>
                                </div>`
                                dt.row.add([r.id,r.user_id,r.nombre,r.email,r.direccion,r.celular,buttons ]).draw()

                mainData.push(e.data.data)

            }).catch((e)=>{
                console.log(e);
            })
            }
        });

        $("#btnConfirmDelete").click(function (e) {
            const id= $("#modalDelete").data("id");
            axios.delete("contratos/delete/"+id).then((e)=>{
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id","");
                const dt=$(".table").DataTable();
                dt.rows('.remove-'+id).remove().draw();

            }).catch((e)=>{
                console.log(e);
            })
        });

        $(document).ready(()=>{
        $(".table").DataTable()
        });


    $("#adduser").click(()=>{
        $("#formfinduser").trigger("reset")
        $("#modalTitleUsers").html("Buscar Usuario ")
        $("#modalfinduser").modal("show")
    });

    $("#btnSearch").click(function (e) {
        e.preventDefault();
        const busqueda=$("#busqueda").val();
        const dt= $("#table2").DataTable()
        dt.clear().draw();
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

    const generateData = (target) => {
        let data = {};
        data["enganches"] = [];

        $(target).serializeArray().forEach(e => {
            if (e.name.includes("enganche")) {
                let en = e.name.split("_")
                if( data["enganches"][en[2]] == undefined) {
                    data["enganches"][en[2]] = {};
                    if (e.value !== null && e.value !== "") {
                        data["enganches"][en[2]][en[1]] = e.value;
                    }
                    } else {
                        if (e.value !== null && e.value !== "") {
                            data["enganches"][en[2]][en[1]] = e.value;
                        }
                    }
                } else {
                    data[e.name] = e.value;
                }
        });

        data["enganches"] = data["enganches"].filter(enganche => enganche !== null);

        $(target).find("select").each(function () {
            data[$(this).prop("name")+"_val"] = data[$(this).prop("name")];
            data[$(this).prop("name")] = $(this).find('option:selected').text()
        })
        //console.log(data);
        return data;
    }

    $("#formCont").submit(function (e) {
        e.preventDefault();
        const data = generateData(e.target);
        data._token = $("input[name='_token']").val();
        $.ajax({
            type: "post",
            url: "contratos/vistaprevia",
            data: data,
            dataType: "html",
            success: function (response) {
               //console.log(response);
                let nuevaVentana = window.open();
                nuevaVentana.document.write(response);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });

    $("#BtnAgregarCliente").click(function (e) {
        const id= $("#modalAgregarCliente").data("id");
        const data = {id: id};
                    axios.post("clientes/formUser",data).then(function(response){
                        $("#modalfinduser").modal("hide")
                        $("#modalfinduser").trigger("reset")
                        $("#modalAgregarCliente").modal("hide")
                        const dt=$(".table").DataTable();
                        const r = response.data.data;
                        let buttons = `<div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="editclientes(${r.id},this)">Editar</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteclientes(${r.id},this)">Eliminar</button>
                                    </div>`
                        let time= `Creado: ${r.created_at.split(".")[0]} <br>Actualizado: ${r.updated_at.split(".")[0]} `;
                                    dt.row.add([r.id,r.user_id,r.nombre,r.email,"","",buttons]).draw()

                    mainData.push(response.data.data)

                }).catch((error)=>{
                    console.error(error);
                    $("#modalAgregarCliente").modal("hide")
                })
                });


                $("#addData").click(()=>{
            $("#formaddData").trigger("reset")
            $("#modalTitleIdAddData").html("Importar/Data ")
            $("#modalAddData").modal("show")
            });


            $("#Addcont").click(()=>{
            $("#formcont").trigger("reset")
            $("#modalTitleIdAddcont").html("Generar Contrato")
            $("#modalAddcont").modal("show")
            });



            $("#").click(()=>{
            $("#formVerOfer").trigger("reset")
            $("#ModalVerOferTitle").html("Buscar Usuario ")
            $("#modalfinduser").modal("show")
    });


    let enganches = 0;
    $("#addEnganche").click((e) => {
        $("#enganches").append(`
        <div class="w-100 d-flex enganche my-1">
            <input type="text" class="form-control" placeholder="Cantidad del Enganche" name="enganche_cantidad_${enganches}" oninput="recalcualte()">
            <input type="date" class="form-control" name="enganche_fecha_${enganches}">
            <button class="btn btn-danger eliminarEnganche" type="button"> Eliminar</button>
        </div>
        `);
        enganches++;
    })
    $("#Meses").change(() => {
        calcularTotal()
    });
    $("#l_fin").on("input" , () => {
        if($("#Meses").val() != "" ) {
            console.log("as")
            calcularTotal();
        }
    });
    $("#l_contado").on("input", () => {
        if($("#select_lotes_pago").val() == "contado") {
            calcularTotal();
        }
    });

    $("#enganches").on("click", ".eliminarEnganche", (e) => {
        $(e.target).parent().remove();
        enganches--;
    });

    $("#descargarPDF").click(() => {
        if (!$("#formCont")[0].checkValidity()) {
            $("#formCont")[0].reportValidity()
            return;
        }
        const data = generateData("#formCont");

        $("#confirm_terreno").html(data.l_lote)
        $("#confirm_manzana").html(data.l_manzana)
        $("#confirm_proyecto").html(data.l_proyecto)
        $("#confirm_cliente").html(data.c_nombre)

        $("#modalAddcont").modal("hide")
        $("#modalConfirm").modal("show")
    })

    $("#confirmarContrato").click(() => {
        let data = generateData("#formCont");
        data._token = $("input[name='_token']").val();


        $.ajax({
            type: "post",
            url: "/contratos",
            data: data,
            dataType: "json",
            success: function (response) {
                let r = response.data;
                const dt= $("#tablaContratos").DataTable()
                const btn = `  <div class="d-flex"><button type="button" class="btn btn-primary" onclick="verPDF(${r.id})">Ver Contrato</button>
                                    <button type="button" name="" id="" class="btn btn-danger" onclick="deleteContrato(${r.id},this)">Eliminar</button>
                                    </div>`
                dt.row.add([
                    r.id,
                    data.c_nombre,
                    data.l_proyecto,
                    data.l_lote+"/"+data.l_manzana,
                    data.l_superficie,
                    "activo",
                    data.l_total,
                    btn
                ]).draw();

                $("#formCont")[0].reset();
                $("#form-financiado").hide();
                $("#enganches").parent().hide();
                $("#enganches .enganche").remove();
                //mainDataContratos.push(r);

                $("#modalAddcont").modal("hide");
                $("#modalConfirm").modal("hide");
            },
            error: function (error) {
                console.error(error);
            }
        });
    });

    $("#cancelarContrato").on("click", function () {
    $("#modalAddcont").modal("show");
    });


    $(document).ready(function () {
        @if (!is_null($recursos['oferta']))
            $("#modalAddcont").modal("show");

            $("#select_clientes").val({{ $recursos['oferta']['cliente_id'] }});
            $("#select_clientes").change();
            $("#select_proyectos").val({{ $recursos['oferta']['proyecto_id'] }});
            $("#select_proyectos").change();
            $("#select_zona").val({{ $recursos['oferta']['zona_id'] }});
            $("#select_zona").change();
            $("#select_manzana").val({{ $recursos['oferta']['lote_id'] }});
            $("#select_manzana").change();
            $("#select_lotes").val({{ $recursos['oferta']['lote_id'] }});
            $("#select_lotes").change();
            @if ($recursos['oferta']['pago'] == 'Contado' || $recursos['oferta']['pago'] == 'ContadoPE')
                $("#select_lotes_pago").val("contado");
                $("#select_lotes_pago").change();
            @elseif ($recursos['oferta']['pago'] == 'Financiado' || $recursos['oferta']['pago'] == 'FinanciadoPE' || $recursos['oferta']['pago'] == 'FinanciadoA' || $recursos['oferta']['pago'] == 'FinanciadoPEA')
                $("#select_lotes_pago").val("financiado");
                $("#select_lotes_pago").change();
                $("#l_total").val({{ $recursos['oferta']['precio'] }});
                $("#l_total").change();
                $("#l_anualidad").val({{ $recursos['oferta']['anualidad'] }});
                $("#l_anualidad").change();
                $("#Meses").val({{ $recursos['oferta']['plazo'] }});
                $("#Meses").change();
            @endif


        @endif
    });

    $("#btnCancelarOferta").click(function (e) {
        const id = $("#modalDelete").data("id");

        $("#modalDelete").modal("hide");
        $(".remove-" + id).removeClass("remove-" + id);

    });

    </script>

@endsection
