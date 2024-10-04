@extends('layouts.pdf')

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Estilos para el contenedor de la tabla */
    .table-container {
    margin: 0 auto;
    max-width: 800px;
    padding: 0 10px;
    box-sizing: border-box;
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

    /* Estilos para la tabla */
    table {
        max-width: 100%;
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    table th,
    table td {
        border: 1px solid rgba(128, 128, 128, 0.5);
        padding: 6px;
    }

    tbody tr:nth-child(even) {
        background-color: #ffffcc;
    }

    thead {
        background-color: #ffffcc;
    }

    /* Estilos específicos para dispositivos móviles */
    @media only screen and (max-width: 600px) {
        .table-container {
            padding: 0 10px;
            margin: 0 auto;
        }

        table {
            max-width: 100%;
            width: calc(100% - 20px);
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table th,
        table td {
            padding: 6px;
        }

        h2 {
            text-align: left;
            margin-top: 20px;
        }

        img {
            float: none;
            margin-right: 0;
            margin-bottom: 10px;
        }
    }

</style>

<div class="table-container">
    <div>
        <div>
            <img src="img/logo.png" alt="Logo" />
            <h2>Detalle de cuotas</h2>
            <hr />
            @if ($anualidad == 0)

                <div>
                    @if ($meses === 1)

                    <div>
                        <p> </p><br>
                        <p>
                            Proyecto <span style=" font-weight: bold;">{{ $proyecto }}</span><br>
                            Zona <span style="font-weight: bold;">{{ $etapa }}</span><br>
                            Manzana <span style="font-weight: bold;">{{ $manzana }}</span><br>
                            Lote <span style="font-weight: bold;">{{ $lote }}</span>
                        </p>
                            <p>Cliente <span style="font-weight: bold;">{{ $nombre }}</span></p>
                            <p>Precio del lote<span style="font-weight: bold;"> $ {{ number_format($precio, 2) }}</span></p>

                    </div>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Pago Numero</th>
                                    <th>Interés</th>
                                    <th>IVA</th>
                                    <th>Pago Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $saldoDeuda = $precio;
                                @endphp
                                @for ($i = 1; $i <= $meses; $i++)
                                @php
                                    $capAmor = ($precio / $meses);
                                    $interes = 0;
                                    $iva = 0;

                                    $pagoTotal = $capAmor + $interes + $iva;
                                    $saldoDeuda -= $capAmor;
                                @endphp
                                    <tr>
                                        <td>Pago unico</td>
                                        <td>${{ number_format($interes, 2) }}</td>
                                        <td>${{ number_format($iva, 2) }}</td>
                                        <td>${{ number_format($pagoTotal, 2) }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                        </div>
                    @else
                        @if ($enganche == 0)
                            <div>
                                <p> </p><br>
                                <p>
                                    Proyecto <span style=" font-weight: bold;">{{ $proyecto }}</span><br>
                                    Zona <span style="font-weight: bold;">{{ $etapa }}</span><br>
                                    Manzana <span style="font-weight: bold;">{{ $manzana }}</span><br>
                                    Lote <span style="font-weight: bold;">{{ $lote }}</span>
                                </p>
                                    <p>Cliente <span style="font-weight: bold;">{{ $nombre }}</span></p>
                                    <p>Precio del lote<span style="font-weight: bold;"> $ {{ number_format($precio, 2) }}</span></p>
                                    <p>plazo <span style="font-weight: bold;">{{ $meses }} Meses</span></p>

                            </div>
                                <table>
                                <thead>
                                    <tr>
                                    <th>Pago Numero</th>
                                    <th>Pago del periodo</th>
                                    <th>Interés del pago</th>
                                    <th>IVA</th>
                                    <th>Pago Total</th>
                                    <th>Saldo Deuda</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php

                                        $saldoDeuda = $precio;

                                    @endphp
                                    @for ($i = 1; $i <= $meses; $i++)
                                    @php
                                        $capAmor = ($precio / $meses);
                                        $interes = 0;
                                        $iva = 0;

                                        $pagoTotal = $capAmor + $interes + $iva;
                                        $saldoDeuda -= $capAmor;
                                    @endphp
                                        <tr>
                                            <td>No. {{ $i }}</td>
                                            <td>${{ number_format($capAmor, 2) }}</td>
                                            <td>${{ number_format($interes, 2) }}</td>
                                            <td>${{ number_format($iva, 2) }}</td>
                                            <td>${{ number_format($pagoTotal, 2) }}</td>
                                            <td>${{ number_format($saldoDeuda, 2) }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        @else
                                @php
                                    $engancheTotal = $enganche;
                                    $precioTotal = (($precio)-($engancheTotal));
                                    $saldoDeuda = $precioTotal;
                                @endphp
                            <div>
                                <p> </p><br>
                                <p>
                                    Proyecto <span style=" font-weight: bold;">{{ $proyecto }}</span><br>
                                    Zona <span style="font-weight: bold;">{{ $etapa }}</span><br>
                                    Manzana <span style="font-weight: bold;">{{ $manzana }}</span><br>
                                    Lote <span style="font-weight: bold;">{{ $lote }}</span>
                                </p>
                                    <p>Cliente <span style="font-weight: bold;">{{ $nombre }}</span></p>
                                    <p>Precio del lote<span style="font-weight: bold;"> $ {{ number_format($precio, 2) }}</span></p>
                                    <p>Enganche<span style="font-weight: bold;"> $ {{ number_format($engancheTotal, 2) }}</span></p>
                                    <p>plazo <span style="font-weight: bold;">{{ $meses }} Meses</span></p>


                            </div>
                                <table>
                                <thead>
                                    <tr>
                                    <th>Pago Numero</th>
                                    <th>Pago del periodo</th>
                                    <th>Interés del pago</th>
                                    <th>IVA</th>
                                    <th>Pago Total</th>
                                    <th>Saldo Deuda</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @for ($i = 1; $i <= $meses; $i++)
                                    @php
                                        $capAmor = ($precioTotal / $meses);
                                        $interes = 0;
                                        $iva = 0;

                                        $pagoTotal = $capAmor + $interes + $iva;
                                        $saldoDeuda -= $capAmor;
                                    @endphp
                                        <tr>
                                            <td>No. {{ $i }}</td>
                                            <td>${{ number_format($capAmor, 2) }}</td>
                                            <td>${{ number_format($interes, 2) }}</td>
                                            <td>${{ number_format($iva, 2) }}</td>
                                            <td>${{ number_format($pagoTotal, 2) }}</td>
                                            <td>${{ number_format($saldoDeuda, 2) }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        @endif

                    </div>
                @endif
            @else
                @if ($enganche == 0)
                        <div>

                            <div>
                                <p> </p><br>
                                <p>
                                Proyecto <span style=" font-weight: bold;">{{ $proyecto }}</span><br>
                                Zona <span style="font-weight: bold;">{{ $etapa }}</span><br>
                                Manzana <span style="font-weight: bold;">{{ $manzana }}</span><br>
                                Lote <span style="font-weight: bold;">{{ $lote }}</span>
                                </p>
                                <p>Cliente <span style="font-weight: bold;">{{ $nombre }}</span></p>
                                <p>Precio del lote<span style="font-weight: bold;"> $ {{ number_format($precio, 2) }}</span></p>
                                <p>Anualidad<span style="font-weight: bold;"> $ {{ number_format($anualidad, 2) }}</span></p>
                                <p>plazo <span style="font-weight: bold;">{{ $meses }} Meses</span></p>

                            </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Pago Numero.</th>
                                    <th>Pago del periodo</th>
                                    <th>Interés del Periodo</th>
                                    <th>IVA</th>
                                    <th>Anualidad</th>
                                    <th>Pago Total</th>
                                    <th>Saldo Deuda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $saldoDeuda = $precio;
                                @endphp
                                @for ($i = 1; $i <= $meses; $i++)
                                @php

                                    $capAmor = (($precio - (($anualidad) * (floor($meses / 12)))) / $meses);
                                    $interes = 0;
                                    $comision = 0;
                                    $iva = 0;
                                    $anualidadPago = 0;

                                    $pagoTotal = $capAmor + $interes + $comision + $iva + $anualidadPago;
                                    $saldoDeuda -= $pagoTotal;

                                    if ($i % 12 === 0 && $anualidad !== 0) {
                                        $anualidadPago = $anualidad;
                                        $saldoDeuda -= $anualidadPago;
                                        $pagoTotal = $capAmor + $interes + $comision + $iva + $anualidadPago;

                                    }
                                @endphp
                                    <tr>
                                        <td>No. {{ $i }}</td>
                                        <td>${{ number_format($capAmor, 2) }}</td>
                                        <td>${{ number_format($interes, 2) }}</td>
                                        <td>${{ number_format($iva, 2) }}</td>
                                        <td>${{ number_format($anualidadPago, 2) }}</td>
                                        <td>${{ number_format($pagoTotal, 2) }}</td>
                                        <td>${{ number_format($saldoDeuda, 2) }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                    </div>
                    @else
                        <div>
                                @php
                                    $engancheTotal = $enganche;
                                    $precioTotal = (($precio)-($engancheTotal));
                                    $saldoDeuda = $precioTotal;
                                @endphp
                            <div>
                                <p> </p><br>
                                <p>
                                Proyecto <span style=" font-weight: bold;">{{ $proyecto }}</span><br>
                                Zona <span style="font-weight: bold;">{{ $etapa }}</span><br>
                                Manzana <span style="font-weight: bold;">{{ $manzana }}</span><br>
                                Lote <span style="font-weight: bold;">{{ $lote }}</span>
                                </p>
                                <p>Cliente <span style="font-weight: bold;">{{ $nombre }}</span></p>
                                <p>Precio del lote<span style="font-weight: bold;"> $ {{ number_format($precio, 2) }}</span></p>
                                <p>Anualidad<span style="font-weight: bold;"> $ {{ number_format($anualidad, 2) }}</span></p>
                                <p>Enganche<span style="font-weight: bold;"> $ {{ number_format($engancheTotal, 2) }}</span></p>
                                <p>plazo <span style="font-weight: bold;">{{ $meses }} Meses</span></p>


                            </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Pago Numero.</th>
                                    <th>Pago del periodo</th>
                                    <th>Interés del Periodo</th>
                                    <th>IVA</th>
                                    <th>Anualidad</th>
                                    <th>Pago Total</th>
                                    <th>Saldo Deuda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= $meses; $i++)
                                @php

                                    $capAmor = (($precioTotal - (($anualidad) * (floor($meses / 12)))) / $meses);
                                    $interes = 0;
                                    $comision = 0;
                                    $iva = 0;
                                    $anualidadPago = 0;

                                    $pagoTotal = $capAmor + $interes + $comision + $iva + $anualidadPago;
                                    $saldoDeuda -= $pagoTotal;

                                    if ($i % 12 === 0 && $anualidad !== 0) {
                                        $anualidadPago = $anualidad;
                                        $saldoDeuda -= $anualidadPago;
                                        $pagoTotal = $capAmor + $interes + $comision + $iva + $anualidadPago;

                                    }
                                @endphp
                                    <tr>
                                        <td>No. {{ $i }}</td>
                                        <td>${{ number_format($capAmor, 2) }}</td>
                                        <td>${{ number_format($interes, 2) }}</td>
                                        <td>${{ number_format($iva, 2) }}</td>
                                        <td>${{ number_format($anualidadPago, 2) }}</td>
                                        <td>${{ number_format($pagoTotal, 2) }}</td>
                                        <td>${{ number_format($saldoDeuda, 2) }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                        </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection
