@extends('layouts.pdf')

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
    }

    h6 {
        text-align: right;

    }

    img {
        float: left;
        margin-right: 10px;
    }

    h6 + hr {
        border: 0;
        border-top: 2px solid rgba(128, 128, 128, 1);
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
    .fondo-amarillo {
        background-color: #ffffcc;
    }

    .table1 .fondo-gris {
        background-color: rgba(0, 0, 0, 0.15);
        text-align: left;
    }

    .table1 .fondo-verde {
        background-color: rgba(0, 128, 0, 0.15);
    }

    .table1 .fondo-rojo {
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
                <h6><b>VILLAS DE GUADALUPE</b></h6>
                <h6>RIO NILO # 4049, CORDOVA AMERICAS</h6>
                <h6>CD JUAREZ,CHIH. 32310</h6>
                <h6><b>TEL: (856)541 92 04</b></h6>
                <hr />

            <p>

            </p>
            <p>

            </p>
            <p>

            </p>
            @php
                setlocale(LC_TIME, 'es_MX.utf8', 'es_MX', 'es');
                $date = date_create($l_fecha);
            @endphp


            <p style="text-align: right;">NO.<span style="font-weight: bold; text-decoration: underline;">  {{$id}}  </span></p>
            <p>Forma de pago: <span style="font-weight: bold; text-decoration: underline;">  {{$tipo}}  </span></p>
            <p>Recibo de: <span style="font-weight: bold; text-decoration: underline;">  {{$nombre}}  </span></p><br>
            <p>La cantidad de: <span style="font-weight: bold; text-decoration: underline;">${{number_format($saldo, 2)}} <br>({{ $formater->format((int)$saldo)}} Pesos {{substr(explode(".",(string)$saldo)[1] ?? '00',0,2)}}/100 m.n)</span></p>
            <p>Por concepto de: <span style="font-weight: bold; text-decoration: underline;">  {{$concepto}}</span><span style="font-weight: bold; text-decoration: underline;">  {{ strftime("%B %Y", $date->getTimestamp()) }}</span></p>
            <p>Lote:<span style="font-weight: bold; text-decoration: underline;">  {{$lote}}  </span>        Manzana:<span style="font-weight: bold; text-decoration: underline;">  {{$manzana}}  </span></p>
            <p><br></p>
            <p><br></p>

                <div style="clear: both;" >

                    <table class="table table-primary" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 33.33%; text-align:center;"></td>
                                <td style="width: 33.33%; text-align:center;  padding-bottom: 45px;">
                                    <img style="max-width: 100%; border-bottom: 0.9px solid black;"  src="img/Firma.png" alt="Firma"/>
                                </td>
                                <td style="width: 33.33%; text-align:center;"></td>
                            </tr>
                            <tr>
                               <td style="width: 33.33%; text-align:center; text-decoration: underline;"><span style="font-weight: bold; text-decoration: underline;">{{ $recibido }}</span></td>
                               <td style="width: 33.33%; text-align:center; text-decoration: underline;  padding-bottom: 10px;"></td>
                               <td style="width: 33.33%; text-align:center; text-decoration: underline;"><span style="font-weight: bold; text-decoration: underline;">{{ $proyecto }}</span></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td style="width: 33.33%; text-align:center;">Recibido Por</td>
                                <td style="width: 33.33%; text-align:center;  padding-bottom: 10px;">Firma</td>
                                <td style="width: 33.33%; text-align:center;">Desarrollo</td>
                            </tr>
                            <tr>
                                <td class="fondo-amarillo" colspan="2" style="width: 66.66%; text-align:center;">NOTA: POR CANCELACION NO HAY DEVOLUCIONES</td>
                                <td style="width: 33.33%; text-align:center;"><span style="font-weight: bold; text-decoration: underline;">{{ strftime("%d de %B de %Y", $date->getTimestamp()) }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 66.66%; text-align:center;"></td>
                                <td style="width: 33.33%; text-align:center;">Fecha</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

@endsection
