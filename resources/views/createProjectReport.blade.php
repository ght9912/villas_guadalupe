@extends('layouts.app')

@section('content')
<!--Encabezado-->
<div class="container" id="report-container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div id="report-header" class="d-flex mb-2 justify-content-between">
        <h1>Reporte de creación de proyecto e importación de zonas y lotes.</h1>
      </div>
      
    </div>
  </div>
  <!--Cuerpo-->
  <div class="row justify-content-center">
    <div class="container">
      <h3>Se creó exitosamente el proyecto <b>{{$project->nombre}}</b>.</h3>
      <br>
      <div id="report-body">
      </div>
      <h4>Se recomienda revisar los errores señalados e intentar importar nuevamente solamente los que se hayan corregido. Esto con el fin de disminuir el riesgo de crear duplicidades.</h4>
      <h4>Se recomienda revisar las tablas de lotes y zonas a fin de verificar que se hayan hecho los registros contemplados.</h4>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>
  const project = {{Js::from($project)}};
  // $("body").css('overflow', 'auto');
</script>
  @if($zones !== null)
    <script>
      const mainZones = {{Js::from($zones)}};
      const zonesHead = `<h4>Se realizó la importación de <b>${mainZones.length} zonas</b> a la base de datos:</h4>`;
      $(zonesHead).appendTo($("#report-body"));
      const zonesList = `<ul id="zones-list"></ul>`;
      $(zonesList).appendTo($("#report-body"));
      for (let i = 0; i < mainZones.length; i++) {
        const e = mainZones[i];
        let listElement = `<li>Se agregó la zona <b>${e.etapa}</b>, con el nombre identificador: <b>"${e.e_name}"</b>.`;
        $(listElement).appendTo($("#zones-list"));
      }
      $("#report-body").append(`<br>`);
    </script>
  @endif
  @if($lots !== null)
    <script>
      const mainLots = {{Js::from($lots)}};
      const lotsHead = `<h4>Se realizó la importación de <b>${mainLots.length} lotes</b> a la base de datos:</h4>`;
      $(lotsHead).appendTo($("#report-body"));
      const lotsList = `<ul id="lots-list" ></ul>`;
      $(lotsList).appendTo($("#report-body"));
      for (let i = 0; i < mainLots.length; i++) {
        const e = mainLots[i];
        let listElement = `<li id="lote${i}">Se agregó el lote <b>${e.lote}</b> manzana <b>${e.manzana}</b> a la zona <b>${e.etapa.e_name}</b>.</li>`;
        $(listElement).appendTo($("#lots-list"))
      }
      $("#report-body").append(`<br>`);
    </script>
  @endif
  @if($fails !== null)
    <script>
      const mainFails = {{Js::from($fails)}};
      const failsHead = `<h4>No se realizó la importación de las siguientes filas incluidas en el archivo adjunto:</h4>`;
      $(failsHead).appendTo($("#report-body"));
      const rowsList = `<ul id="fails-list"></ul>`;
      $(rowsList).appendTo($("#report-body"));
      for (let i = 0; i < mainFails.length; i++) {
        const e = mainFails[i];
        let row = `<li><b>Fila ${e.fila}</b>:<ul id="e-list${i}"></ul></li>`;
        $(row).appendTo($("#fails-list"))
        if(e['noLot']){$(`#e-list${i}`).append(`<li>No contiene información de lote.</li>`);}
        if(e['multiLot']){$(`#e-list${i}`).append(`<li>Contiene más de un lote.</li>`);}
        if(e['noBlock']){$(`#e-list${i}`).append(`<li>No contiene información de la manzana.</li>`);}
        if(e['noZone']){$(`#e-list${i}`).append(`<li>No contiene información de la zona.</li>`);}
        if(e['noPrices']){$(`#e-list${i}`).append(`<li>No tiene precio de contado ni financiado.</li>`);}
        if(e['repeated']){$(`#e-list${i}`).append(`<li>El lote ${e.lote} manzana ${e.manzana}, de la zona ${e.zona}, ya existe en la base de datos.</li>`);}
      }
      $("#report-body").append(`<br><br>`);
    </script>
  @endif
@endsection