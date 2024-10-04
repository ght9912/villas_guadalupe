@extends('layouts.app')

@section('content')
<!--Encabezado-->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div id="report-header" class="d-flex mb-2 justify-content-between">
        <h1>Importación de contratos al proyecto <b>{{$project->nombre}}</b>.</h1>
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
      <h4>Se recomienda hacer una revisión de los errores señalados e intentar importar nuevamente solo aquellos contratos que hayan sido señalados con error.</h4>
      <br/>
      <h4>Se recomienda revisar la tabla de contratos a fin de verificar que se hayan hecho los registros esperados.</h4>
      <br/>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script>
    const project = {{Js::from($project)}}
  </script>
  @if($contracts !== null && count($contracts) > 0 )
    <script>
      const mainContracts = {{ js::from($contracts)}}
      const contractsHead = `<h4>Se realizó la importación de <b>${mainContracts.length} contratos</b> a la base de datos:</h4>`;
      $(contractsHead).appendTo($("#report-body"));
      const contractsList = `<ul id="contracts-list" ></ul>`;
      $(contractsList).appendTo($("#report-body"));
      for(let i = 0; i < mainContracts.length; i++){
        const e = mainContracts[i];
        let row = `<li>Se agregó el contrato número <b>${e}</b>.`;
        $(row).appendTo($("#contracts-list"))
      }
      $("#report-body").append(`<br>`);
    </script>
  @endif
  @if($fails !== null && count($fails) > 0)
    <script>
      const mainFails = {{ js::from($fails) }}
      console.log(mainFails);
      const failsHead = `<h4>No se realizó la importación de las siguientes filas incluidas en el archivo:</h4>`;
      $(failsHead).appendTo($("#report-body"));
      const rowsList = `<ul id="fails-list"></ul>`;
      $(rowsList).appendTo($("#report-body"));
      for (let i = 0; i < mainFails.length; i++) {
        const e = mainFails[i];
        let row = `<li><b>Fila ${e.fila}</b>:<ul id="e-list${i}"></ul></li>`;
        $(row).appendTo($("#fails-list"))
        if(e['noNumber']){
          $(`#e-list${i}`).append(`<li>No tiene número de contrato.</li>`);
        }
        if(e['noLot']){
          $(`#e-list${i}`).append(`<li>No contiene información de lote.</li>`);
        }
        if(e['noBlock']){
          $(`#e-list${i}`).append(`<li>No contiene información de la manzana.</li>`);
        }
        if(e['noDate']){
          $(`#e-list${i}`).append(`<li>No contiene fecha de inicio de contrato.</li>`);
        }
        if(e['noMail']){
          $(`#e-list${i}`).append(`<li>No contiene dirección de correo electrónico.</li>`);
        }
        if(e['multiMail']){
          $(`#e-list${i}`).append(`<li>Contiene más de una dirección de correo electrónico.</li>`);
        }
        if(e['noTotal']){
          $(`#e-list${i}`).append(`<li>No contiene Monto total del contrato.</li>`);
        }
        if(e['noDown']){
          $(`#e-list${i}`).append(`<li>No contiene Importe de enganche del contrato.</li>`);
        }
        if(e['noMonthly']){
          $(`#e-list${i}`).append(`<li>No contiene Importe de mensualidad del contrato.</li>`);
        }
        if(e['noAnnuity']){
          $(`#e-list${i}`).append(`<li>No contiene Importe de anualidad del contrato.</li>`);
        }
        if(e['noTerm']){
          $(`#e-list${i}`).append(`<li>No contiene plazo de duración del contrato.</li>`);
        }
        if(e['lotsDifferBlocks']){
          $(`#e-list${i}`).append(`<li>El número de lotes y clientes no coincide.</li>`);
        }
        if(e['lotNotFound']){
          $(`#e-list${i}`).append(`<li>No se localizó el ${e['lotNotFound']}.</li>`);
        }
        if(e['lotsNotFound']){
          for(let j = 0; j < e['lotsNotFound'].length; j++){
            $(`#e-list${i}`).append(`<li>No se localizó el ${e['lotsNotFound'][j]}.</li>`);
          }
        }
        if(e['soldLot']){
          $(`#e-list${i}`).append(`<li>${e['soldLot']}</li>`);
        }
        if(e['soldLots']){
          for(let k = 0; k < e['soldLots'].length; k++){
            $(`#e-list${i}`).append(`<li>${e['soldLots'][k]}</li>`);
          }
        }
        if(e['clientNotFound']){
          $(`#e-list${i}`).append(`<li>No se localizó un cliente con el correo electrónico <b>${e['email']}</b>.</li>`);
        }
        if(e['clientNotMatch']){
          $(`#e-list${i}`).append(`<li>El lote ${e['l_lote']} manzana ${e['l_manzana']} tiene asociado un cliente distinto al incluido en el archivo (email: <b>${e['email']}</b>).</li>`);
        }
        if(e['clientNotMatched']){
          for(let k = 0; k < e['clientNotMatched'].length; k++){
            $(`#e-list${i}`).append(`<li>El cliente del contrato no coincide con el comprador asociado al ${e['clientNotMatched'][k]}.</li>`);
          }
        }
      }
      $("#report-body").append(`<br><br>`);
    </script>
  @endif
@endsection
