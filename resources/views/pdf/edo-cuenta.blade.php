@extends('layouts.pdf')

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: right;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    img {
        float: left;
        margin-right: 10px;
    }

    h2 + hr {
        border: 0;
        border-top: 2px solid rgba(128, 128, 128, 1);
        margin-top: 10px;
    }

    .table1 {
        border-collapse: collapse;
        width: 100%;
    }

    .table1 td, .table1 th {
        border: 2px solid #313131;
        text-align: center;
        padding: 2px;
        font-size: 11px;
    }

    .table1 th {
        background-color: #f2f2f2;
    }

    .table-container1 {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
    }

    .table1 .fondo-amarillo {
        background-color: #ffffcc;
        text-align: left;

    }

    .table1 .fondo-gris {
        background-color: rgba(0, 0, 0, 0.15);
        text-align: left;
    }

    .fondo-verde {
        background-color: rgba(0, 128, 0, 0.15);
    }

    .fondo-rojo {
        background-color: rgba(255, 0, 0, 0.15);
    }

    .table1 {
        font-size: 14px;
    }

    .table1 td, .table1 th {
        font-size: 11px;
    }

    .table2 {
        border-collapse: collapse;
        border: 2px solid #313131;
        font-size: 9px;
    }

    .table2 th, .table2 td {
        padding: 2px;
        text-align: center;
        font-size: 9px;
    }

    .table2 th {
        background-color: rgba(0, 0, 0, 0.15);
    }

    .table2 th[colspan="5"],
    .table2 th[colspan="5"] + tr {
        border-bottom: 2px solid #333;
        text-align: center;

    }

    .table3 {
        border-collapse: collapse;
        border: 2px solid #313131;
        font-size: 9px;

    }

    .table3 th, .table3 td {
        padding: 3px;
        text-align: center;
        font-size: 9px;

    }

    .table3 th {
        background-color: rgba(0, 0, 0, 0.15);
    }

    .table3 th[colspan="5"],
    .table3 th[colspan="5"] + tr {
        border-bottom: 2px solid #333;
    }


</style>

<div >
    <div>
        <div>
            <img src="img/logo.png" alt="Logo" />
            <h2>Estado de Cuenta</h2>
            <hr />
            <p>

            </p>
            <p>

            </p>
            <p>

            </p>
                <div class="table-container1">
                    <div class="table-wrapper" style="float: left; width: 45%;">
                        <table class="table1">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="fondo-amarillo">NO.CONTRATO</td>
                                    <td colspan="2"><span style=" font-weight: bold;">{{ $id_con }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fondo-amarillo">CLIENTE</td>
                                    <td colspan="2"><span style="font-weight: bold;">{{ $nombre }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fondo-amarillo">LOTE</td>
                                    <td><span style=" font-weight: bold;">{{ $lote }}</span></td>
                                    <td class="fondo-amarillo">MANZANA</td>
                                    <td><span style=" font-weight: bold;">{{ $manzana }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fondo-amarillo">DESARROLLO</td>
                                    <td colspan="2"><span style=" font-weight: bold;">{{ $proyecto }}</span></td>
                                </tr>
                                @php
                                    setlocale(LC_TIME, 'spanish');
                                    $SFechaInicio = $l_fecha;
                                    $fechaInicio = new DateTime($SFechaInicio);
                                @endphp
                                <tr>
                                    <td colspan="2" class="fondo-amarillo">FECHA DE INICIO</td>
                                    <td colspan="2"><span style=" font-weight: bold;">{{ strftime('%d de %B del %Y', $fechaInicio->getTimestamp()) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="float: right; width: 45%;">
                        <table class="table1">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($EngTotalCon <= $EngTotalPag)
                                <tr>
                                    <td colspan="2"><span style="font-weight: bold;">{{ $plazo}} - $ {{number_format ($mensualidad, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fondo-gris"><span style=" font-weight: bold;" >COSTO</span></td>
                                    <td>$ {{ number_format($precio, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fondo-gris"><span style=" font-weight: bold;" >ENGANCHE</span></td>
                                    <td >$ {{ number_format($EngTotalCon, 2) }}</td>
                                </tr>
                                @if ($EngTotalCon <= $Total_eng_apar)
                                    <tr>
                                        <td class="fondo-gris"><span style=" font-weight: bold;" >ENGANCHE PAGADO</span></td>
                                        <td class="fondo-verde">$ {{ number_format($Total_eng_apar, 2) }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="fondo-gris"><span style=" font-weight: bold;" >ENGANCHE PAGADO</span></td>
                                        <td class="fondo-verde">$ {{ number_format($EngTotalCon, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="fondo-gris"><span style=" font-weight: bold;" >SALDO A FINANCIAR</span></td>
                                    <td>$ {{ number_format($TotalPagar, 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2"><span style="font-weight: bold;">{{ $plazo}} - $ {{number_format ($mensualidad, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fondo-gris"><span style=" font-weight: bold;" >COSTO</span></td>
                                    <td>$ {{ number_format($precio, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fondo-gris"><span style=" font-weight: bold;" >ENGANCHE</span></td>
                                    <td >$ {{ number_format($EngTotalCon, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fondo-gris"><span style="font-weight: bold;">ENGANCHE FALTANTE</span></td>
                                    <td class="fondo-rojo">$ {{ number_format($eng_faltante, 2) }}</td>
                                </tr>

                                <tr>
                                    <td class="fondo-gris"><span style=" font-weight: bold;" >SALDO A FINANCIAR</span></td>
                                    <td>$ {{ number_format($TotalPagar, 2) }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div>


                    </div>

                </div>

                <div >
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>

                    <hr />
                </div>
                <div>
                    <table  class="table-wrapper table2" style="float: left; width: 55%;">
                        <thead>
                            <tr>
                                <th colspan="5">MENSUALIDADES</th>
                            </tr>
                            <tr>
                                <th>MES</th>
                                <th>IMPORTE</th>
                                <th>FECHA</th>
                                <th>TIPO</th>
                                <th>FOLIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pagosPorMesAnio = [];
                                $ultimoMesAnio = null;
                                $ultimoMesAnioAc = null;
                                foreach ($mensualidades as $p) {
                                    $fechaPago = date('Y-m', strtotime($p->fechas));
                                    $pagosPorMesAnio[$fechaPago][] = $p;

                                    if ($ultimoMesAnio == null) {
                                        $ultimoMesAnio = $fechaPago;
                                    }
                                    $ultimoMesAnioAc = $fechaPago;

                                    if ($ultimoMesAnioAc > $ultimoMesAnio) {
                                        $ultimoMesAnio = $ultimoMesAnioAc;
                                    }
                                }
                                ksort($pagosPorMesAnio);
                            @endphp

                            @foreach ($pagosPorMesAnio as $fecha => $pagos)
                                @php
                                    $totalPagoMes = 0;
                                    foreach ($pagos as $pago) {
                                        $totalPagoMes += $pago->total_pago;
                                        setlocale(LC_TIME, 'spanish');
                                        $stringFecha = $fecha;
                                        $fechas = new DateTime($stringFecha);
                                        $claseFondoRojo = ($totalPagoMes < $mensualidad) ? 'fondo-rojo' : '';

                                    }
                                @endphp
                                <tr class="{{ $claseFondoRojo }} ">
                                    <td>{{ strftime('01 %b %Y', $fechas->getTimestamp()) }}</td>
                                    <td>${{ number_format($totalPagoMes, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                @foreach ($pagos as $pago)
                                    @php
                                        $fechasMen = new DateTime($pago->fechas);
                                    @endphp
                                    <tr >
                                        <td></td>
                                        <td>${{ number_format($pago->total_pago, 2) }}</td>
                                        <td>{{ strftime('%d %b %Y',$fechasMen->getTimestamp()) }}</td>
                                        <td>{{ $pago->tipo }}</td>
                                        <td>{{ $pago->id }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5"><hr style="height: 1px; margin: 5px; padding: 0px;"></td>
                                </tr>
                            @endforeach

                            @if ($ultimoMesAnio == null )

                                @php
                                    setlocale(LC_TIME, 'spanish');
                                    $stringFechaUM = $l_fecha;
                                    $fechaUM = new DateTime($stringFechaUM);
                                    $intervalo = new DateInterval('P1M');
                                @endphp
                                @for ($i = 0; $i < 2; $i++)
                                    <tr>
                                        <td>{{ strftime('01 %b %y', $fechaUM->getTimestamp()) }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @php
                                        $fechaUM->add($intervalo);
                                    @endphp
                                @endfor
                            @else
                                @php
                                    setlocale(LC_TIME, 'spanish');
                                    $stringFechaUM = $ultimoMesAnio;
                                    $fechaUM = new DateTime($stringFechaUM . '-01');
                                    $intervalo = new DateInterval('P1M');
                                    $fechaUM->add($intervalo);
                                @endphp
                                @for ($i = 0; $i < 2; $i++)
                                    <tr>
                                        <td>{{ strftime('01 %b %y', $fechaUM->getTimestamp()) }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @php
                                        $fechaUM->add($intervalo);
                                    @endphp
                                @endfor
                            @endif

                        </tbody>
                    </table>

                    @if ($anualidadPag != 0)
                        <table class="table3" style="float: right; width: 42.5%;">
                            <thead>
                                <tr>
                                    <th colspan="5">ANUALIDADES - $ {{number_format ($anualidadPag, 2) }}</th>
                                </tr>
                                <tr>
                                    <th>AÑO</th>
                                    <th>IMPORTE</th>
                                    <th>FECHA</th>
                                    <th>TIPO</th>
                                    <th>FOLIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pagosPorMesAnioAnu = [];
                                    $ultimoMesAnioAnu = null;
                                    $ultimoMesAnioAnuAc = null;
                                    foreach ($anualidades as $a) {
                                        $fechaPagoAnu = date('Y', strtotime($a->fechas));
                                        $pagosPorMesAnioAnu[$fechaPagoAnu][] = $a;

                                        if ($ultimoMesAnioAnu == null) {
                                            $ultimoMesAnioAnu = $fechaPagoAnu;
                                        }
                                        $ultimoMesAnioAnuAc = $fechaPagoAnu;

                                        if ($ultimoMesAnioAnuAc > $ultimoMesAnioAnu) {
                                            $ultimoMesAnioAnu = $ultimoMesAnioAnuAc;
                                        }
                                    }
                                    ksort($pagosPorMesAnioAnu);
                                @endphp

                                @foreach ($pagosPorMesAnioAnu as $fecha => $anu)
                                    @php
                                        $totalPagoMesAnu = 0;
                                        foreach ($anu as $a) {
                                            $totalPagoMesAnu += $a->total_pago;
                                            setlocale(LC_TIME, 'spanish');

                                            $fecha_inicio = new DateTime($l_fecha);
                                            $numeroMes = $fecha_inicio->format('n');

                                            $stringFechaAnu = "$fecha-$numeroMes";
                                            $fechasAnu = new DateTime($stringFechaAnu);
                                            $claseFondoRojo = ($totalPagoMesAnu < $anualidadPag) ? 'fondo-rojo' : '';

                                        }
                                    @endphp
                                    <tr class="{{ $claseFondoRojo }} ">
                                        <td>{{ strftime('01 %b %Y', $fechasAnu->getTimestamp()) }}</td>
                                        <td>${{ number_format($totalPagoMesAnu, 2) }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach ($anu as $a)
                                        @php
                                            $fechasMenAnu = new DateTime($a->fechas);
                                        @endphp
                                        <tr >
                                            <td></td>
                                            <td>${{ number_format($a->total_pago, 2) }}</td>
                                            <td>{{ strftime('%d %b %Y',$fechasMenAnu->getTimestamp()) }}</td>
                                            <td>{{ $a->tipo }}</td>
                                            <td>{{ $a->id }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5"><hr style="height: 1px; margin: 5px; padding: 0px;"></td>
                                    </tr>
                                @endforeach

                                @if ($ultimoMesAnioAnu == null )

                                    @php
                                        setlocale(LC_TIME, 'spanish');
                                        $stringFechaUMAnu = $l_fecha;
                                        $fechaUMAnu = new DateTime($stringFechaUMAnu);
                                        $intervaloAnu = new DateInterval('P1Y');
                                        $fechaUMAnu->add($intervaloAnu);

                                    @endphp
                                    @for ($i = 0; $i < 2; $i++)
                                        <tr>
                                            <td>{{ strftime('01 %b %y', $fechaUMAnu->getTimestamp()) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        @php
                                            $fechaUMAnu->add($intervaloAnu);
                                        @endphp
                                    @endfor
                                @else
                                    @php
                                        setlocale(LC_TIME, 'spanish');

                                        $fecha_inicio = new DateTime($l_fecha);
                                        $numeroMes = $fecha_inicio->format('n');

                                        $stringFechaUMAnu = "$ultimoMesAnioAnu-$numeroMes-01";

                                        $fechaUMAnu = new DateTime($stringFechaUMAnu);
                                        $intervaloAnu = new DateInterval('P1Y');
                                        $fechaUMAnu->add($intervaloAnu);
                                    @endphp
                                    @for ($i = 0; $i < 2; $i++)
                                        <tr>
                                            <td>{{ strftime('01 %b %y', $fechaUMAnu->getTimestamp()) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        @php
                                            $fechaUMAnu->add($intervaloAnu);
                                        @endphp
                                    @endfor
                                @endif
                            </tbody>
                        </table >
                        @if (!empty($otros))
                            <div style="clear: both;" >
                                <table class="table3" style="float: right; width: 42.5%;">
                                    <thead>
                                        <tr>
                                            <th colspan="5">OTROS</th>
                                        </tr>
                                        <tr>
                                            <th>IMPORTE</th>
                                            <th>FECHA</th>
                                            <th>CONCEPTO</th>
                                            <th>TIPO</th>
                                            <th>FOLIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($otros as $i => $o)
                                            @php
                                                setlocale(LC_TIME, 'spanish');
                                                $fechasPag = new DateTime($o->fechas);
                                                $claseFondo = ($o->concepto === 'Otros: Extras') ? 'fondo-verde' : '';
                                            @endphp
                                                <tr class="{{ $claseFondo }}">
                                                    <td>${{ number_format($o->total_pago, 2) }}</td>
                                                    <td>{{ strftime('%d %b %y', $fechasPag->getTimestamp()) }}</td>
                                                    <td>{{ $o->concepto }}</td>
                                                    <td>{{ $o->tipo }}</td>
                                                    <td>{{ $o->id }}</td>
                                                </tr>
                                        @endforeach
                                    </tbody>
                                </table >
                            </div>
                        @endif
                    @else
                        @if (!empty($otros))
                            <table class="table3" style="float: right; width: 42.5%;">
                                <thead>
                                    <tr>
                                        <th colspan="5">OTROS</th>
                                    </tr>
                                    <tr>
                                        <th>IMPORTE</th>
                                        <th>FECHA</th>
                                        <th>CONCEPTO</th>
                                        <th>TIPO</th>
                                        <th>FOLIO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($otros as $i => $o)
                                        @php
                                            setlocale(LC_TIME, 'spanish');
                                            $fechasPag = new DateTime($o->fechas);
                                            $claseFondo = ($o->concepto === 'Otros: Extras') ? 'fondo-verde' : '';
                                        @endphp
                                        <tr class="{{ $claseFondo }}">
                                            <td>${{ number_format($o->total_pago, 2) }}</td>
                                            <td>{{ strftime('%d %b %y', $fechasPag->getTimestamp()) }}</td>
                                            <td>{{ $o->concepto }}</td>
                                            <td>{{ $o->tipo }}</td>
                                            <td>{{ $o->id }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table >
                        @endif
                    @endif
                </div>

                <div style="clear: both;" >

                    <hr>
                    <p><br></p>
                    <p><br></p>

                    {{-- <table style="float: right; width: 30%;">
                        <thead>
                        </thead>
                        <tbody>
                            <td colspan="2"><img src="img/Proyecto.png" alt="Proyecto"/></td>
                        </tbody>
                    </table> --}}

                    <p style="float: left; width: 30%;">SALDO <span style="font-weight: bold; text-decoration: underline;">   $ {{ number_format($saldo, 2) }}</span></p>
                    {{-- <p style="text-align:center; margin-bottom: 10px;"><img style="width: 40%; border-bottom: 2px solid black;" src="img/Firma.png" alt="Firma"/></p>
                    <p><br></p>
                    <p><br></p>

                    <p style="text-align:center;">Jesus Garcia<br>Genrente de Cobranza</p> --}}

                    @if (!empty($generales))
                        <br><p style="float: left; width: 30%;">OTROS <span style="font-weight: bold; text-decoration: underline;">   $ {{ number_format($sumaGen, 2) }}</span></p>
                     @endif

                </div>
        </div>
    </div>
</div>

@endsection
