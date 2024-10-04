@extends('layouts.app')

@section('content')
<!--Encabezado-->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div id="report-header" class="d-flex mb-2 justify-content-between">
        <h1>Importación de pagos al proyecto <b>{{$project->nombre}}</b>.</h1>
      </div>
    </div>
  </div>
  <!--Cuerpo-->
  <div class="row justify-content-center">
    <div class="container">
      <h3>Se concluyó el análisis y el procesamiento del archivo proporcionado.</h3>
      <br/>
      <div id="report-body">

      </div>
        <h4>Se recomienda hacer una revisión de los errores señalados e intentar importar nuevamente solo aquellos pagos que hayan sido señalados con error.</h4>
      <br/>
      <h4>Se recomienda revisar la tabla de pagos a fin de verificar que se hayan hecho los registros esperados.</h4>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script>
    const project = {{Js::from($project)}}
  </script>
  @if($payments != null)
  <script>
    const mainPayments = {{Js::from($payments)}}
    const paymentsHead = `<h4>Se realizó la importación de <b>${mainPayments.length} pagos</b> a la base de datos:</h4>`;
    $(paymentsHead).appendTo($("#report-body"));
      const paymentsList = `<ul id="payments-list" ></ul>`;
      $(paymentsList).appendTo($("#report-body"));
      for(let i = 0; i < mainPayments.length; i++){
        const e = mainPayments[i];
        let row = `<li>Se agregó un pago por <b>$${e.total_pago}</b> con fecha de <b>${e.fechas}</b> al contrato número <b>${e.contrato}</b>.`;
        $(row).appendTo($("#payments-list"))
      }
      $("#report-body").append(`<br>`);
  </script>
  @endif
  @if($fails != null)
    <script>
      const mainFails = {{Js::from($fails)}};
      const failsHead = `<h4>No se realizó la importación de las siguientes filas incluidas en el archivo:</h4>`;
      $(failsHead).appendTo($("#report-body"));
      const rowsList = `<ul id="fails-list"></ul>`;
      $(rowsList).appendTo($("#report-body"));
      for (let i = 0; i < mainFails.length; i++) {
        const e = mainFails[i];
        let row = `<li><b>Fila ${e.fila}</b>:<ul id="e-list${i}"></ul></li>`;
        $(row).appendTo($("#fails-list"))
        if(e['notSearchable']){
          $(`#e-list${i}`).append(`<li>No se puede rastrear en la base de datos, ya que no cuenta con número de contrato y falta dato de lote y/o manzana.</li>`);
        }
        if(e['noTotal']){
          $(`#e-list${i}`).append(`<li>No contiene información del monto del pago.</li>`);
        }
        if(e['noConcept']){
          $(`#e-list${i}`).append(`<li>No tiene concepto de pago.</li>`);
        }
        if(e['noDate']){
          $(`#e-list${i}`).append(`<li>No contiene fecha de pago.</li>`);
        }
        if(e['lotNotFound']){
          $(`#e-list${i}`).append(`<li>No se localizó el lote de referencia.</li>`);
        }
        if(e['numberNotMatch']){
          $(`#e-list${i}`).append(`<li>El número de contrato ingresado no coincide con el número de contrato registrado para el lote.</li>`);
        }
        if(e['contractNotFound']){
          $(`#e-list${i}`).append(`<li>No se localizó el contrato asociado al lote.</li>`);
        }
        if(e['repeated']) {
            $(`#e-list${i}`).append(`Ya existe un pago de <b>${e.total_pago}</b> con fecha <b>${e.date}</b> asociado al primer lote señalado en el contrato número <b>${e.num_cont}</b>.`);
        }
      }
      $("#report-body").append(`<br><br>`);
    </script>
  @endif
@endsection
