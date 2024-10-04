@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex mb-2 justify-content-between">
                    <h1>Prospectos</h1>
                    @if ($admin)
                        <div class="botones">
                            <button class="btn btn-success" id="addBtn">Añadir prospecto</button>
                            <div class="dropdown mt-3">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Formularios
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" id="addBtnFormulario">Crear formulario</a></li>
                                    <li><a class="dropdown-item" id="editBtnFormulario">Editar formulario</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="id_Embudo" class="form-label fw-bold mb-0">Buscar por embudos</label>
                        <select class="form-select" name="id_Embudo" id="id_Embudo">
                            <option value="" selected>Todos los prospectos</option>
                            @foreach ($embudos as $em)
                                <option value="{{ $em->id }}">{{ $em->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-primary text-center" id="prospectosTabla">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col" class="text-center">Nombre</th>
                                <th scope="col" class="text-center">Celular</th>
                                <th scope="col" class="text-center">Email</th>
                                <th scope="col" class="text-center">status</th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                        {{-- <tbody class="text-center">
                            @foreach ($prospectos as $p)
                            <tr>
                                <td >{{ $p->id }}</td>
                                <td class="text-center">{{ $p->nombre }}</td>
                                <td class="text-center">{{ $p->telefono }}</td>
                                <td class="text-center">{{ $p->email }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $p->id }}">
                                            <li><a class="dropdown-item" onclick="editProspecto({{ $p->id }}, this)">Editar</a></li>
                                            <li><a class="dropdown-item" onclick="deleteProspecto({{ $p->id }}, this)">Eliminar</a></li>
                                            <li><a class="dropdown-item" onclick="volverCliente({{ $p->id }}, this)">Conversión de prospecto a cliente</a></li>
                                            <li><a class="dropdown-item" onclick="crearOferta({{ $p->id }}, this)">Crear oferta a prospecto</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Prospecto-->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:80% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="#" id="formAdd">
                                    <div class="mb-3" style="display: none">
                                        <label for="id" style="display: none"class="form-label fw-bold mb-0">id</label>
                                        <input type="text" style="display: none" class="form-control" name="id"
                                            id="id">
                                    </div>
                                    <div class="mb-3">
                                        <a id="textPro"></a>
                                    </div>
                                    <div class="mb-3">
                                        <label for="EmbudosDis" class="form-label fw-bold mb-0">Embudo</label>
                                        <input class="form-control" list="datalistProyecto5" id="EmbudosDis" placeholder="Buscar embudo" required>
                                        <datalist id="datalistProyecto5">
                                            @foreach ($embudos as $em)
                                                <option data-id="{{ $em->id }}" value="{{ $em->nombre }}"></option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" id="EmbudosDisId" name="EmbudosDisId" required>
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="nombre" class="form-label fw-bold mb-0">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Aquí escribe el nombre del prospecto">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="telefono" class="form-label fw-bold mb-0">Celular</label>
                                        <input type="tel" class="form-control" name="telefono" id="telefono"
                                            placeholder="Aquí coloca el celular del prospecto" pattern="\d{10}"
                                            maxlength="10" oninput="validateTelefono(this)">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="email" class="form-label fw-bold mb-0">Correo electrónico</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Aquí escribe el correo electrónico"
                                            oninput="validateCorreo(this)">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="direccion" class="form-label fw-bold mb-0">Dirección actual</label>
                                        <input type="text" class="form-control" name="direccion" id="direccion"
                                            placeholder="Aquí escribe la dirección">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="contacto" class="form-label fw-bold mb-0">Canal de contacto preferido</label>
                                        <select class="form-select" name="contacto" id="contacto">
                                            <option value="" selected disabled>Selecciona el canal de contacto preferido</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                            <option value="Correo">Correo</option>
                                            <option value="Telefono">Teléfono </option>
                                        </select>
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="medio" class="form-label fw-bold mb-0">Por qué medio se enteró de nosotros</label>
                                        <input type="text" class="form-control" name="medio" id="medio"
                                            placeholder="Aquí escribe el medio por el que se enteró de nosotros">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="ingresos" class="form-label fw-bold mb-0">Ingresos Mensuales</label>
                                        <input type="number" class="form-control" name="ingresos" id="ingresos"
                                            placeholder="Aquí escribe los ingresos del prospecto">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="motivo" class="form-label fw-bold mb-0">Motivo de compra</label>
                                        <input type="text" class="form-control" name="motivo" id="motivo"
                                            placeholder="Aquí escribe el motivo de compra">
                                    </div>
                                    <div class="mb-3" style="display: none">
                                        <label for="tiempo" class="form-label fw-bold mb-0">Tiempo en el que quiere comprar</label>
                                        <input type="date" class="form-control" name="tiempo" id="tiempo">
                                    </div>
                                    <div class="mb-3"  style="display: none">
                                        <label for="necesidad" class="form-label fw-bold mb-0">Necesidades</label>
                                        <input type="text" class="form-control" name="necesidad" id="necesidad"
                                            placeholder="Aquí escribe las necesidades">
                                    </div>
                                    <div class="mb-3"  style="display: none">
                                        <label for="pago" class="form-label fw-bold mb-0">Forma de pago preferido</label>
                                        <select class="form-select" name="pago" id="pago">
                                            <option value="" selected disabled>Selecciona la forma de pago preferido</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="trans">Transferencia bancaria</option>
                                        </select>
                                    </div>
                                    <div class="mb-3"  style="display: none">
                                        <label for="mensualidades" class="form-label fw-bold mb-0">Mensualidad que puede pagar</label>
                                        <input type="number" class="form-control" name="mensualidades" id="mensualidades"
                                            placeholder="Aquí escribe la mensualidad que puede pagar">
                                    </div>
                                    <div class="mb-3"  style="display: none">
                                        <label for="vendedor" class="form-label fw-bold mb-0">Vendedor que lo recomendó</label>
                                        <input class="form-control" list="datalistProyecto2" id="vendedor" name="vendedor" placeholder="Buscar vendedor">
                                        <datalist id="datalistProyecto2"></datalist>
                                        <input type="hidden" id="vendedorId" name="vendedorId">
                                    </div>
                                    <div class="mb-3"  style="display: none">
                                        <label for="cliente" class="form-label fw-bold mb-0">Cliente que lo recomendó</label>
                                        <input class="form-control" list="datalistProyecto3" id="cliente" name="cliente" placeholder="Buscar Cliente">
                                        <datalist id="datalistProyecto3"></datalist>
                                        <input type="hidden" id="clienteId" name="clienteId" required>
                                    </div>
                                    <div class="alert alert-warning" id="noFormulario" role="alert"  style="display: none">
                                        No hay formulario creado para este embudo.
                                    </div>
                        </form>
                    </div>

                </div>

                <div class="modal-footer" id="footer" >
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="confi"
                        class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar-->
    <div class="modal fade" id="modalConfir" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Seguro que deseas guardar al prospecto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="addSave"
                        class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle"
        aria-hidden="true">
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

    <!-- Modal Cliente-->
    <div class="modal fade" id="modalAddCliente" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:80% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleClienteId"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="#" id="formAddCliente">
                            <div class="mb-3">
                                <div><br></div>
                                <a>Para poder crear una cuenta de cliente a partir de un prospecto es necesario que estén
                                    completos todos los campos (nombre, celular y el correo), a partir del correo
                                    electrónico se creará la cuenta con la que el prospecto podrá acceder a todos los
                                    beneficios que ofrece Villas de Guadalupe.</a>
                                <div><br></div>
                            </div>
                            <div class="mb-3" style="display: none">
                                <label for="idPro" style="display: none"class="form-label fw-bold mb-0">id</label>
                                <input type="text" style="display: none" class="form-control" name="idPro"
                                    id="idPro">
                            </div>
                            <div class="mb-3">
                                <label for="nombrePro" class="form-label fw-bold mb-0">Nombre</label>
                                <input type="text" class="form-control" name="nombrePro" id="nombrePro"
                                    placeholder="Aqui escribe el nomber del prospecto" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefonoPro" class="form-label fw-bold mb-0">Celular</label>
                                <input type="tel" class="form-control" name="telefonoPro" id="telefonoPro"
                                    placeholder="Aquí coloca el celular del prospecto" required pattern="\d{10}"
                                    maxlength="10" oninput="validateTelefono(this)">
                            </div>
                            <div class="mb-3">
                                <label for="emailPro" class="form-label fw-bold mb-0">Correo electrónico</label>
                                <input type="email" class="form-control" name="emailPro" id="emailPro"
                                    placeholder="Aqui escribe el correo electrónico" required
                                    oninput="validateCorreo(this)">
                            </div>
                        </form>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="confiCliente" class="btn btn-primary">Crear
                        Cliente</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Confirmar cliente-->
    <div class="modal fade" id="modalConfirCliente" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirClienteTitle">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Seguro que deseas crear la cuenta del cliente, una vez creada la cuenta se borra al prospecto para dar
                    paso a la cuenta de cliente, deseas continuar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="addSaveCliente"
                        class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Oferta-->
    <div class="modal fade" id="modalAddOferta" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:80% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleOfertaId"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="#" id="formAddOferta">
                            <div class="mb-3">
                                <div><br></div>
                                <a>
                                    Para poder crear una oferta a un prospecto es necesario que exista un correo asignado al
                                    prospecto, la oferta será enviada por correo electrónico al prospecto.
                                </a>
                                <div><br></div>
                            </div>
                            <div class="mb-3" style="display: none">
                                <label for="idProspecto" style="display: none" class="form-label fw-bold mb-0">id</label>
                                <input type="hidden" style="display: none" class="form-control" name="idProspecto"
                                    id="idProspecto">
                            </div>
                            <div class="mb-3" style="display: none">
                                <label for="telefonoProspecto" class="form-label fw-bold mb-0">Celular</label>
                                <input type="tel" class="form-control" name="telefonoProspecto"
                                    id="telefonoProspecto" placeholder="Aquí coloca el celular del prospecto">
                            </div>
                            <div class="mb-3">
                                <label for="nombreProspecto" class="form-label fw-bold mb-0">Nombre</label>
                                <input type="text" class="form-control" name="nombreProspecto" id="nombreProspecto"
                                    placeholder="Aqui escribe el nombre del prospecto" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailProspecto" class="form-label fw-bold mb-0">Correo electrónico</label>
                                <input type="email" class="form-control" name="emailProspecto" id="emailProspecto"
                                    placeholder="Aqui escribe el correo electrónico" required
                                    oninput="validateCorreo(this)">
                            </div>
                            <div class="mb-3">
                                <label for="proyecto" class="form-label fw-bold mb-0">Lote</label>
                                <input class="form-control" list="datalistProyecto" id="proyecto"
                                    placeholder="Buscar lote" required>
                                <datalist id="datalistProyecto"></datalist>
                                <input type="hidden" id="loteId" name="loteId" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label fw-bold mb-0">Precio</label>
                                <input type="number" class="form-control" name="precio" id="precio"
                                    placeholder="Aqui escribe el valor del lote" required>
                            </div>
                            <div class="mb-3">
                                <label for="pago" class="form-label fw-bold mb-0">Forma de pago</label>
                                <select class="form-select" name="pago" id="pago" required>
                                    <option value="" selected disabled>Seleccione la forma de pago</option>
                                    <option value="Contado">Contado</option>
                                    <option value="Financiado">Financiado</option>
                                </select>
                            </div>
                            <div class="mb-3" style="display: none" id=engancheContainer>
                                <label for="enganche" class="form-label fw-bold mb-0">Enganche</label>
                                <input type="number" class="form-control" name="enganche" id="enganche"
                                    placeholder="Aqui escribe el valor del engache" required>
                            </div>
                            <div class="mb-3" style="display: none" id=anualidadContainer>
                                <label for="anualidad" class="form-label fw-bold mb-0">Anualidad</label>
                                <input type="number" class="form-control" name="anualidad" id="anualidad"
                                    placeholder="Aqui escribe el valor de la anualidad" required>
                            </div>
                            <div class="mb-3" style="display: none" id=plazoContainer>
                                <label for="plazo" class="form-label fw-bold mb-0">Plazo</label>
                                <input type="number" class="form-control" name="plazo" id="plazo"
                                    placeholder="Aqui escribe la cantidad de meses para hacer el pago" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-info" id="previewOferta">Preview</button>
                    <button type="button" class="btn btn-primary" id="confiOferta">Crear Oferta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar oferta-->
    <div class="modal fade" id="modalConfirOferta" tabindex="-1" role="dialog" aria-labelledby="modalConfirTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirOfertaTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Seguro que deseas enviar la oferta creada al prospecto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="sendOferta" class="btn btn-primary">Enviar
                        Oferta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para seleccionar campos -->
    <div class="modal fade" id="modalCampos" tabindex="-1" role="dialog" aria-labelledby="modalCamposTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:50%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCamposTitleId"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCampos">
                        <div id="mensajeCrear" class="mb-3" style="display: none;">
                            <a>
                                Debes seleccionar un embudo antes de poder crear un formulario,
                                selecciona todas las opciones que consideres necesarias.
                            </a>
                        </div>
                        <div id="mensajeEditar" class="mb-3" style="display: none;">
                            <a>
                                Para modificar un formulario, debes seleccionar un embudo y agregar o quitar campos.
                            </a>
                        </div>

                        <div class="mb-3" id="selectEdit" style="display: none">
                            <label for="Embudo" class="form-label fw-bold mb-0">Selecciona un embudo</label>
                            <input class="form-control" list="datalistProyecto4" id="Embudo" placeholder="Selecciona un embudo">
                            <datalist id="datalistProyecto4"></datalist>
                            <input type="hidden" id="embudo_select" name="embudo_select" required>
                        </div>
                        <div class="mb-3" id="selectEdit2" style="display: none">
                            <label for="EmbudoEdi" class="form-label fw-bold mb-0">Buscar un embudo</label>
                            <input class="form-control" list="datalistProyectoEd" id="EmbudoEdi" placeholder="Buscar un embudo">
                            <datalist id="datalistProyectoEd"></datalist>
                            <input type="hidden" id="embudo_selectEd" name="embudo_selectEd" required>
                        </div>
                        <div id=checks style="display: none">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkNombre" value="nombre">
                                <label class="form-check-label" for="checkNombre">Nombre</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkTelefono" value="telefono">
                                <label class="form-check-label" for="checkTelefono">Celular</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkEmail" value="email">
                                <label class="form-check-label" for="checkEmail">Correo electrónico</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkDireccion" value="direccion">
                                <label class="form-check-label" for="checkDireccion">Dirección</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkContacto" value="contacto">
                                <label class="form-check-label" for="checkContacto">Canal de contacto</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkMedio" value="medio">
                                <label class="form-check-label" for="checkMedio">Medio de contacto</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkIngresos" value="ingresos">
                                <label class="form-check-label" for="checkIngresos">Ingresos</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkMotivo" value="motivo">
                                <label class="form-check-label" for="checkMotivo">Motivo de compra</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkTiempo" value="tiempo">
                                <label class="form-check-label" for="checkTiempo">Tiempo en el que quiere comprar</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkNecesidad" value="necesidad">
                                <label class="form-check-label" for="checkNecesidad">Necesidad</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPago" value="pago">
                                <label class="form-check-label" for="checkPago">Forma de pago</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkMensualidades"
                                    value="mensualidades">
                                <label class="form-check-label" for="checkMensualidades">Mensualidades que puede pagar</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkVendedor" value="vendedor">
                                <label class="form-check-label" for="checkVendedor">Vendedor con el que compra</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkCliente" value="cliente">
                                <label class="form-check-label" for="checkCliente">Cliente que lo recomendo</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" style="display: none" id="saveFormFields">Guardar formulario</button>
                    <button type="button" class="btn btn-primary" style="display: none" id="editFormFields">Guardar cambios formulario</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const mainData = {{ Js::from($prospectos) }}

        const editProspecto = (id, el) => {
            axios.get("prospectos/" + id).then(response => {
                let prospecto = response.data;

                if (prospecto == undefined) {
                    return;
                }

                let embudoId = prospecto.data.id_embudo;
                $("#EmbudosDis").val($("#datalistProyecto5 option[data-id='" + embudoId + "']").text());
                $("#EmbudosDisId").val(embudoId);

                $("#id").val(prospecto.id);
                $("#nombre").val(prospecto.nombre);
                $("#telefono").val(prospecto.telefono);
                $("#email").val(prospecto.email);


                $("#formAdd").data("update", 1);
                $("#formAdd").data("id", prospecto.id);
                $("#modalTitleId").html("Editar del prospecto " + prospecto.nombre);
                $("#modalAdd").modal("show");
                $(el).parent().parent().parent().addClass("update-" + id);
            }).catch(error => {
                console.error(error);
            });
        };

        const deleteProspecto = (id, el) => {
            $("#modalDelete").modal("show");
            $("#modalDelete").data("id", id);
            $("#modalDeleteTitle").html("Eliminar prospecto?");
            $(el).parent().parent().parent().addClass("remove-" + id)
            // console.log();
        }

        const volverCliente = (id, el) => {
            let prospecto;
            axios.get("prospectos/" + id).then(data => {
                prospecto = data.data;
                if (prospecto == undefined) {
                    return
                }
                console.log(prospecto);

                $("#formAddCliente").trigger("reset")
                $("#idPro").val(prospecto.id);
                $("#nombrePro").val(prospecto.nombre);
                $("#telefonoPro").val(prospecto.telefono);
                $("#emailPro").val(prospecto.email);

                $("#formAddCliente").data("update", 1)
                $("#formAddCliente").data("id", prospecto.id);
                $("#modalTitleClienteId").html("Crear Cliente")
                $("#modalAddCliente").modal("show");
                $(el).parent().parent().parent().addClass("update-" + id);
            });
        }

        const crearOferta = (id, el) => {
            $("#formAddOferta").trigger("reset")

            cargarLotes();

            let prospecto;
            axios.get("prospectos/" + id).then(data => {
                prospecto = data.data;
                if (prospecto == undefined) {
                    return
                }
                console.log(prospecto);

                $("#idProspecto").val(prospecto.id);
                $("#nombreProspecto").val(prospecto.nombre);
                $("#emailProspecto").val(prospecto.email);
                $("#telefonoProspecto").val(prospecto.telefono);


                $('#enganche').val();
                $('#anualidad').val();
                $('#plazo').val();
                $('#engancheContainer').hide();
                $('#anualidadContainer').hide();
                $('#plazoContainer').hide();
                $("#formAddOferta").data("id", prospecto.id);
                console.log($("#formAddCliente").data("id"));
                $("#modalTitleOfertaId").html("Crear Oferta")
                $("#modalAddOferta").modal("show");
                $(el).parent().parent().parent().addClass("update-" + id);
            });
        }

        function validateTelefono(input) {
            const pattern = /^\d{10}$/;

            if (!pattern.test(input.value)) {
                input.setCustomValidity("El número de celular debe ser de 10 dígitos sin espacios, guiones, letras, etc.");
            } else {
                input.setCustomValidity("");
            }
        }

        function validateCorreo(input) {
            let email = input.value;

            axios.post('/prospectos/emailUsers', {
                    email: email
                })
                .then(function(response) {
                    if (response.data.exists) {
                        input.setCustomValidity("Ya existe un usuario que posee este correo, pruebe con otro.");
                    } else {
                        input.setCustomValidity("");
                    }

                    input.reportValidity();
                })
                .catch(function(error) {
                    console.error("Error al verificar el correo:", error);
                    input.setCustomValidity("Hubo un problema al verificar el correo. Inténtelo de nuevo.");
                    input.reportValidity();
                });
        }

        function cargarLotes() {
            $.ajax({
                url: '/prospectos/lotes',
                method: 'GET',
                success: function(data) {
                    let datalist = $('#datalistProyecto');
                    datalist.empty();
                    data.forEach(function(lotes) {
                        let lote = lotes.lote.trim();
                        let optionText = lotes.proyecto.nombre + ' /Z ' + lotes.etapa.e_name + ' /M ' +
                            lotes.manzana + ' /L ' + lote;
                        datalist.append('<option data-id="' + lotes.id + '" value="' + optionText +
                            '">');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los proyectos:', error);
                }
            });
        }

        function cargarClientes() {
            $.ajax({
                url: '/prospectos/clientes',
                method: 'GET',
                success: function(data) {
                    let datalist = $('#datalistProyecto3');
                    datalist.empty();
                    data.forEach(function(clientes) {
                        let cliente = clientes.nombre.trim();
                        let correo = clientes.email.trim();

                        let optionText = cliente + ' / ' + correo;
                        datalist.append('<option data-id="' + clientes.id + '" value="' + optionText +
                            '">');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los proyectos:', error);
                }
            });
        }

        function cargarVendedotes() {
            $.ajax({
                url: '/vendedores/info',
                method: 'GET',
                success: function(data) {
                    let datalist = $('#datalistProyecto2');
                    datalist.empty();
                    data.forEach(function(vendedores) {
                        let vendedor = vendedores.nombre.trim();
                        let correo = vendedores.email.trim();

                        let optionText = vendedor + ' / ' + correo;
                        datalist.append('<option data-id="' + vendedores.id + '" value="' + optionText +
                            '">');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los proyectos:', error);
                }
            });
        }

        function saveFormFields(embudoId, fields) {
            axios.post('/prospectos/formulario/embudo', {
                    embudo_id: embudoId,
                    campos: fields
                })
                .then(function(response) {
                    if (response.data.success) {
                    } else {
                        console.error("Ocurrió un error al guardar los campos.");
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                });
        }
    </script>

    <script type="module">
        $(document).ready(() => {
            let procesoVentaTable = $("#prospectosTabla").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('tablas/prospecto') }}",
                    "type": "GET",
                    "data": function(d) {
                        d.id_Embudo = $('#id_Embudo').val();
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "nombre"
                    },
                    {
                        "data": "telefono"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "acciones",
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });

            $('#id_Embudo').change(function() {
                procesoVentaTable.ajax.reload();
            });
        });

        $(document).ready(() => {
            $(".table").DataTable()
        });

        $("#addBtn").click(() => {
            $("#noFormulario").hide();
            $("#textPro").html("Para ver las opciones disponibles del formulario debes seleccionar el embudo");
            $('#footer').hide();

            $("#formAdd").trigger("reset");
            $("#modalAdd").trigger("reset");

            $("#EmbudosDis").val('');
            $("#EmbudosDisId").val('');
            $("#formAdd input, #formAdd select").closest('.mb-3').hide();
            $('#EmbudosDis').closest('.mb-3').show();

            $("#modalTitleId").html("Añadir prospecto");

            $("#modalAdd").modal("show");

            $("#id").val("");
            $("#formAdd").data("update", 0);
        });

        $("#confi").click(function() {
            let form = document.getElementById("formAdd");
            let email = $("#email").val();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $("#modalConfir").modal("show");
            $("#modalAdd").modal("hide");
        });

        $("#addSave").click(function(e) {
            e.preventDefault();
            const button = $(this);
            button.prop("disabled", true);
            let form = document.getElementById("formAdd");

            if (!form.checkValidity()) {
                form.reportValidity();

                setTimeout(function() {
                    button.prop("disabled", false);
                }, 2000);

                return;
            }
            const data = new FormData();

            let nombre = $("#nombre").val();
            let telefono = $("#telefono").val();
            let email = $("#email").val();
            let id_embudo = $("#EmbudosDisId").val();

            let additionalData = {
                id_emNombre: $("#EmbudosDis").val(),
                id_embudo: $("#EmbudosDisId").val(),
                direccion: $("#direccion").val(),
                contacto: $("#contacto").val(),
                medio: $("#medio").val(),
                ingresos: $("#ingresos").val(),
                motivo: $("#motivo").val(),
                tiempo: $("#tiempo").val(),
                necesidad: $("#necesidad").val(),
                pago: $("#pago").val(),
                mensualidades: $("#mensualidades").val(),
                vendedor: $("#vendedorId").val(),
                cliente: $("#clienteRId").val()
            };

            data.append('nombre', nombre);
            data.append('telefono', telefono);
            data.append('email', email);
            data.append('id_embudo', id_embudo);
            data.append('data', JSON.stringify(additionalData));

            const dt = $("#prospectosTabla").DataTable();

            if ($("#formAdd").data("update") == 1) {

                let id = $("#formAdd").data("id");
                data.append("_method", "PUT")
                $("#modalAdd").modal("hide")
                $("#modalConfir").modal("hide")
                $("#formAdd").trigger("reset")
                axios.post("prospectos/" + id, data).then((e) => {

                    const dt = $(".table").DataTable();
                    dt.ajax.reload();
                }).catch((e) => {
                    console.log(e);

                })
            } else {
                axios.post("prospectos", data).then((e) => {
                    $("#modalAdd").modal("hide")
                    $("#modalConfir").modal("hide")
                    $("#formAdd").trigger("reset")
                    $("#noFormulario").hide();

                    const dt = $(".table").DataTable();
                    $("#addSave").prop("disabled", false);

                    dt.ajax.reload();
                }).catch((e) => {
                    console.log(e);
                })
            }
        });

        $("#btnConfirmDelete").click(function(e) {
            e.preventDefault();
            const button = $(this);
            button.prop("disabled", true);
            const id = $("#modalDelete").data("id");
            axios.delete("prospectos/" + id).then((e) => {
                $("#modalDelete").modal("hide");
                $("#modalDelete").data("id", "");
                const dt = $(".table").DataTable();
                dt.ajax.reload();
            }).catch((e) => {
                console.log(e);
            })
        });

        $("#confiCliente").click(function() {
            let form = document.getElementById("formAddCliente");
            let email = $("#emailPro").val();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $("#modalConfirCliente").modal("show");
            $("#modalAddCliente").modal("hide");
        });

        $("#addSaveCliente").click(function(e) {
            e.preventDefault();
            const button = $(this);
            button.prop("disabled", true);
            let form = document.getElementById("formAddCliente");

            if (!form.checkValidity()) {
                form.reportValidity();

                setTimeout(function() {
                    button.prop("disabled", false);
                }, 2000);

                return;
            }

            const data = new FormData(document.getElementById("formAddCliente"));
            data.append("status", 1);

            const dt = $("#prospectosTabla").DataTable();

            if ($("#formAddCliente").data("update") == 1) {

                let id = $("#formAddCliente").data("id");
                $("#formAddCliente").trigger("reset");

                axios.post("/prospectos/cliente/" + id, data).then((e) => {

                    const dt = $(".table").DataTable();
                    dt.ajax.reload();
                }).catch((e) => {
                    console.log(e);
                })
            }
            $("#modalConfirCliente").data("id", "");
            $("#modalAddCliente").modal("hide");
            $("#modalConfirCliente").modal("hide");
        });

        $(document).ready(function() {
            $('#proyecto').on('input', function() {
                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyecto option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $('#loteId').val(selectedId);
                } else {
                    $('#loteId').val('');
                }
            });
        });

        $(document).ready(function() {
            $('#pago').on('change', function() {
                let selectedValue = $(this).val();

                if (selectedValue === 'Financiado') {
                    $('#enganche').val("");
                    $('#anualidad').val("");
                    $('#plazo').val("");
                    $('#engancheContainer').show();
                    $('#anualidadContainer').show();
                    $('#plazoContainer').show();
                } else {
                    $('#enganche').val(0);
                    $('#anualidad').val(0);
                    $('#plazo').val(1);
                    $('#engancheContainer').hide();
                    $('#anualidadContainer').hide();
                    $('#plazoContainer').hide();
                }
            });
        });

        $("#confiOferta").click(function() {
            let form = document.getElementById("formAddOferta");
            let email = $("#emailProspecto").val();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $("#modalConfirOferta").modal("show");
            $("#modalAddOferta").modal("hide");
        });

        $("#sendOferta").click(function(e) {
            e.preventDefault();
            const button = $(this);
            button.prop("disabled", true);
            let form = document.getElementById("formAddOferta");


            if (!form.checkValidity()) {
                form.reportValidity();

                setTimeout(function() {
                    button.prop("disabled", false);
                }, 2000);

                return;
            }

            const data = new FormData(form);
            let id = $("#formAddOferta").data("id");
            const dt = $("#prospectosTabla").DataTable();
            $("#formAddOferta").trigger("reset")

            axios.post("/prospectos/oferta/" + id, data).then((e) => {

                const dt = $(".table").DataTable();
                dt.ajax.reload();
            }).catch((e) => {
                console.log(e);
            })

            button.prop("disabled", false);
            $("#formAddOferta").trigger("reset");
            $("#modalAddOferta").modal("hide");
            $("#modalConfirOferta").modal("hide");
            $('#engancheContainer').hide();
            $('#anualidadContainer').hide();
            $('#plazoContainer').hide();
        });

        $("#previewOferta").click(function() {
            let form = document.getElementById("formAddOferta");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const data = new FormData(form);
            let id = $("#formAddOferta").data("id");

            let url = `prospectos/previewOferta?${new URLSearchParams(data).toString()}`;
            window.open(url, '_blank');
        });

        $(document).ready(function() {
            $('#vendedor').on('input', function() {
                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyecto2 option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $('#vendedorId').val(selectedId);
                } else {
                    $('#vendedorId').val('');
                }
            });
        });

        $(document).ready(function() {
            $('#cliente').on('input', function() {
                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyecto3 option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $('#clienteId').val(selectedId);
                } else {
                    $('#clienteId').val('');
                }
            });
        });

        $("#addBtnFormulario").click(function() {
            $('#checks').hide();

            $('#formCampos input[type="checkbox"]').prop('checked', false);
            $('#Embudo').val('');
            $('#embudo_select').val('');

            $("#EmbudoEdi").prop('required', false);
            $("#Embudo").prop('required', true);
            $("#modalCamposTitleId").html("Selecciona los campos para el formulario");
            $("#mensajeCrear").show();
            $("#mensajeEditar").hide();
            $("#saveFormFields").html("Guardar formulario");
            $("#selectEdit").show();
            $("#selectEdit2").hide();
            $("#saveFormFields").show();
            $("#editFormFields").hide();

            $.ajax({
                url: '/prospecto/formulario/notexists',
                method: 'GET',
                success: function(data) {
                    let datalist = $('#datalistProyecto4');
                    datalist.empty();
                    data.forEach(function(embudos) {

                        let optionText = embudos.nombre;
                        datalist.append('<option data-id="' + embudos.id + '" value="' + optionText + '">');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los proyectos:', error);
                }
            });

            $('#Embudo').on('input', function() {

                $('#checks').show();

                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyecto4 option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $('#embudo_select').val(selectedId);
                } else {
                    $('#embudo_select').val('');
                }
            });

            $("#modalCampos").modal("show");
        });

        $("#editBtnFormulario").click(function() {

            $('#checks').hide();
            $('#formCampos input[type="checkbox"]').prop('checked', false);
            $('#EmbudoEdi').val('');
            $('#embudo_selectEd').val('');

            $("#Embudo").prop('required', false);
            $("#EmbudoEdi").prop('required', true);
            $("#modalCamposTitleId").html("Editar campos de un formulario");
            $("#mensajeCrear").hide();
            $("#mensajeEditar").show();
            $("#saveFormFields").html("Guardar cambios formulario");
            $("#selectEdit").hide();
            $("#selectEdit2").show();
            $("#saveFormFields").hide();
            $("#editFormFields").show();

            axios.get('/prospecto/formulario/exists')
                .then(function(response) {
                    let datalist = $('#datalistProyectoEd');
                    datalist.empty();
                    response.data.forEach(function(embudo) {
                        let optionText = embudo.nombre;
                        datalist.append('<option data-id="' + embudo.id + '" value="' + optionText + '">');
                    });
                })
                .catch(function(error) {
                    console.error('Error al cargar los embudos:', error);
                });

            $('#EmbudoEdi').on('input', function() {
                let inputValue = $(this).val().trim();

                let selectedOption = $('#datalistProyectoEd option').filter(function() {
                    return $(this).val().trim() === inputValue;
                });

                if (selectedOption.length) {
                    let selectedId = selectedOption.data('id');
                    $("#embudo_selectEd").val(selectedId);
                    $('#checks').show();


                    axios.get('/embudos/' + selectedId)
                        .then(function(response) {
                            let embudo = response.data;
                            let fields;

                            try {
                                fields = JSON.parse(embudo.formulario);
                            } catch (e) {
                                console.error('Error al parsear el JSON:', e);
                                return;
                            }

                            if (Array.isArray(fields)) {
                                $('#formCampos input[type="checkbox"]').prop('checked', false);

                                fields.forEach(function(field) {
                                    $('#formCampos input[value="' + field + '"]').prop('checked', true);
                                });
                            } else {
                                console.error('La columna "formulario" no es un array:', fields);
                            }
                        })
                        .catch(function(error) {
                            console.error('Error al cargar los campos:', error);
                            $('#checks').hide();
                        });
                } else {
                    $('#embudo_selectEd').val('');
                }
            });

            $("#modalCampos").modal("show");
        });

        $("#saveFormFields").click(function() {
            let form = document.getElementById("formCampos");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let embudoId = $("#embudo_select").val();

            const checkboxes = document.querySelectorAll('#formCampos input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                alert("Debes seleccionar al menos un campo.");
                return;
            }

            let selectedFields = [];
            checkboxes.forEach(function(checkbox) {
                selectedFields.push(checkbox.value);
            });

            saveFormFields(embudoId, selectedFields);

            $("#modalCampos").modal("hide");
            $('#checks').hide();

        });

        $("#editFormFields").click(function() {
            let form = document.getElementById("formCampos");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let embudoId = $("#embudo_selectEd").val();

            const checkboxes = document.querySelectorAll('#formCampos input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                alert("Debes seleccionar al menos un campo.");
                return;
            }

            let selectedFields = [];
            checkboxes.forEach(function(checkbox) {
                selectedFields.push(checkbox.value);
            });

            saveFormFields(embudoId, selectedFields);

            $("#modalCampos").modal("hide");
            $('#checks').hide();
        });

        $('#EmbudosDis').on('input', function() {
            let inputValue = $(this).val().trim();

            let selectedOption = $('#datalistProyecto5 option').filter(function() {
                return $(this).val().trim() === inputValue;
            });

            if (selectedOption.length) {
                let selectedId = selectedOption.data('id');
                $('#formAdd input:not(#EmbudosDis), #formAdd select:not(#EmbudosDis)').val('').prop('required', false);
                $('#formAdd .mb-3').hide();
                $('#EmbudosDis').closest('.mb-3').show();

                axios.get('/embudos/' + selectedId)
                    .then(function(response) {
                        $('#footer').show();
                        $('#noFormulario').hide();
                        let embudo = response.data;
                        $('#EmbudosDisId').val(embudo.id);

                        if (embudo.formulario) {
                            let formulario = JSON.parse(embudo.formulario);

                            formulario.forEach(function(campo) {
                                if (campo === "vendedor") {
                                    cargarVendedotes();
                                }
                                if (campo === "cliente") {
                                    cargarClientes();
                                }
                                let campoElement = $(`#formAdd [name="${campo}"]`).closest('.mb-3');
                                campoElement.show();
                                $(`#formAdd [name="${campo}"]`).prop('required', true);
                            });
                        } else {
                            $('#formAdd input, #formAdd select').closest('.mb-3').hide();
                            $('#EmbudosDis').closest('.mb-3').show();
                            $("#noFormulario").show()
                            $('#footer').hide();
                        }
                    })
                    .catch(function(error) {
                        console.error('Error al cargar el embudo:', error);
                    });
            } else {
                $('#EmbudosDisId').val('');
                $('#formAdd input:not(#EmbudosDis), #formAdd select:not(#EmbudosDis)').val('').prop('required', false);
                $('#formAdd .mb-3').hide();
                $('#EmbudosDis').closest('.mb-3').show();
            }
        });

    </script>
@endsection
