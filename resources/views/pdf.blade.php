<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    <style>
        .header{
            position:fixed;
            text-align: right;
            top: 10cm;
            left: 0cm;
            padding:30px 50px,
        }
        body {
            font-family: Arial, sans-serif;
            padding:30px 50px,
            margin: 0;
        }
        h3 {
            position: fixed;
            text-align: right;
            top: 0px;
            right: 0cm;
        }
        @media print {
            @page {
                size: A4;
                margin: 1.5cm 1.5cm 1.5cm 1.5cm;
            }
            .content {
                margin-right: 2.2cm;
            }
            header {
                position: fixed;
                top: 0;
                right: 0;
            }
            p {
                page-break-inside: avoid;
            }
            html, body {
                width: 210mm;
                height: 297mm;
            }
           .firmas {
            break-after:page;
            }
        }

    </style>
    {{-- <div id="header" stile="margin-bottom:20px;">
        <h3><b>{{$numcont}}</h3>
    </div> --}}
</head>


<body style="text-align: justify">
    <header>
        <h3><b>{{$numcont}}</h3>
    </header>
    <div class="content">
         <!--mensaje que se muestra en pdf-->
    <br>
    <img src="img/logo.png">
    <br>
    <br>
    <br>
    <br>
    <h1>Villas de Saltillo</h1>
    <p>
        CONTRATO DE <u><b>ENAJENACIÓN ONEROSA DE DERECHOS PARCELARIOS</u></b> QUE CELEBRAN POR UNA PARTE EL <b> {{$nombreena}}</b>,A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <b>“LA PARTE ENAJENANTE”</b>, Y POR LA OTRA, <b>{{$nombread}}</b> A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ COMO <b>“LA PARTE ADQUIRENTE”</b>, DE CONFORMIDAD CON LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS.
    </p>
    <br>
    <h2><u>Declaraciones</u></h2>
    <br>
    <p><u>PRIMERA.</u> - Manifiesta “LA PARTE ENAJENANTE”:</p>
    <p> a).- Que es Titular y/o Representante Legal de la Parcela número 129 Z10 P1/1, del Ejido “Ojo de la Casa”, Municipio de Juárez, Estado de Chihuahua, con una superfície total de 60-00-19.62 Ha. (Sesenta Hectãreas, Diecinueve punto setenta y dos <b>centiáreas</b>; dicha parcela se encuentra amparada con el <u><b>Certificado Parcelario</u> <u>{{$cerparce}}</u>, con las siguientes medidas y colindancias:
    </p>
    <br>
    <p><b>{{$despro}}

        {{-- 000000111189 --}}

        {{-- NORESTE : 437.15 MTS. CON PARCELA 102, 2 FRACCIONES DE 300.00 Y 243.98
        MTS. EN LINEA QUEBRADA CON PARCELA 69, 2 FRACCIONES DE 35.00 Y
        422.68 MTS. EN LINEA QUEBRADA CON C.F.E.
        SURESTE: 3 FRACCIONES	DE 250.g0, 414.01 Y 344.93 MTS. EN LINEA
        QUEBRADA CON PARCELA 111.
        SURESTE: 978.21 MTS. CON PARCELA 102. NOROESTE : 526.15 MTS. CON PARCELA 102. --}}
        </b>
    </p>
    <br>
    <p>
        b).	- Que el <u>objeto</u> material de este contrato es la enajenación de una <u>fracción de terreno</u> de la Parcela; que cuenta con una superficie de <u>{{$superf}}</u> mts’.
    </p>
    <p> lote(s): {{$lote}}  manzana(s): {{$manza}}  </p>
    <br>
    <p>
        c).	- Que actualmente se encuentra en los trámites correspondientes para adoptar el dominio pleno ante el <u><b>R.A.N. (Registro Agrario Nacional)</u> identificado con el número de {{$RAN}}, y consecuentemente la expedición del título de propiedad para su inscripción en el Registro Público de la Propiedad para el Distrito Judicial Bravos, a fin de que se pueda realizar en su momento correspondiente la escritura de compraventa definitiva del Inmueble.
    </p>
    <br>
    <p>
        d).	- Que ha decidido hacer enajenación onerosa de derechos parcelarios, en favor de:
          <u><b>{{$nombread}}</u>

    </p>
    <br>
    <p>
        <u><b>SEGUNDA.</u> - Manifiesta <b>“LA PARTE ADQUIRENTE”</b>, que desea adquirir los derechos sobre el Inmueble, en los términos y bajo las condiciones que se precisan en este memorial.
        Tomando en cuenta lo antes expuesto las partes otorgan las siguientes:

    </p>
    <br>
    <h2> <u>Clausura</u></h2>
    <br>
    <p>
        <u>PRIMERA.</u> -   <b>C. {{$nombreena}}</b>; <u>ENAJENANTE {{$nombread}}; AQUIRENTE</u>, los derechos sobre el Inmueble, con todo cuanto de hecho y por derecho les corresponde, al corriente en el pago de sus contribuciones, libres de toda responsabilidad o gravamen, a satisfacción de “LA PARTE ADQUIRENTE”, “el inmueble”, CON RESERVA DE DOMINIO, en los términos de los Artículos 2187, 2207, 2210, 2211 y 2213 del Código Civil del Estado de Chihuahua. Su superficie.
    </p>
    <br>
    <div>
        <p>
            <u><b>SEGUNDA.</u> - <u><b>PRECIO.</u> - El <u>precio total financiado</u> de la operación lo constituye la cantidad de <u>${{number_format($preto,2)}}</u>, que se obliga “LA PARTE ADQUIRENTE” a pagar a “LA PARTE ENAJENANTE”, de la siguiente forma:
        </p>
        <p>
            a).- La cantidad de <u><b>${{number_format($total_enganche,2)}}</u> por concepto de enganche, pagandose de la siguiente manera:
                @foreach ( $enganches as $i => $e )
                 @php
                    setlocale(LC_TIME, 'es_MX.utf8');

                    $date = date_create($e["fecha"])
                 @endphp
                @if (count($enganches) == $i+1)
                    y el resto ${{number_format($e["cantidad"],2)}} ({{ $formater->format((int)$e["cantidad"])}} 00/100 m.n.) el dia {{ strftime("%d de %B de %Y", $date->getTimestamp()) }}
                @else
                ${{number_format($e["cantidad"],2)}} ({{ $formater->format((int)$e["cantidad"])}}{{substr(explode(".",(string)$e["cantidad"])[1] ?? '00',0,2)}}/100 m.n.) el dia {{ strftime("%d de %B de %Y", $date->getTimestamp()) }},
                @endif
                @endforeach
                , los cuales se pagarán en  la cuenta descrita en el inciso (c) de este apartado, expidiendo “LA PARTE ENAJENANTE” a favor de “LA PARTE ADQUIRENTE”, por medio de la presente cláusula el recibo más eficaz que en derecho corresponda por las cantidades antes citadas.
            </p>
        <br>
        @if ($anualidad == "0")
        <p>
            @php
                setlocale(LC_TIME, 'es_MX.utf8');

                $dateInicio = date_create($l_fecha);
            @endphp
            b).-El resto, es decir, la cantidad de ${{number_format($preres,2)}} pesos ({{ $formater->format((int)$preres)}} {{substr(explode(".",(string)$preres)[1] ?? '00',0,2)}}/100 Moneda Nacional),
                se pagará mediante {{$mens}} pagos mensuales por la cantidad ${{number_format($monmens,2)}} Pesos ({{ $formater->format((int)$monmens)}} {{substr(explode(".",(string)$monmens)[1] ?? '00',0,2)}}/100 Moneda Nacional),
                pagándose en la cuenta descrita en el inciso (c), de este apartado. Dichas mensualidades se pagarán cada día {{$dia}} de cada mes,
                comenzando a pagar el dia {{ strftime("%d de %B de %Y", $dateInicio->getTimestamp()) }}.
        </p>
        @else
        <p>
            @php
                setlocale(LC_TIME, 'es_MX.utf8');
                $dateInicio = date_create($l_fecha);

                $stringFecha = $l_fecha;
                $fecha = new DateTime($stringFecha);
                $fecha->add(new DateInterval('P1Y'));
                $nuevaFecha = $fecha;
                $newAno = floor($ano) + floor($Mesesa);
            @endphp
            b).-El resto, es decir, la cantidad de ${{number_format($preres,2)}} pesos ({{ $formater->format((int)$preres)}} {{substr(explode(".",(string)$preres)[1] ?? '00',0,2)}}/100 Moneda Nacional),
                se pagará mediante {{$mens}} pagos mensuales por la cantidad ${{number_format($monmens,2)}} Pesos ({{ $formater->format((int)$monmens)}} {{substr(explode(".",(string)$monmens)[1] ?? '00',0,2)}}/100 Moneda Nacional),
                realizando {{ $formater->format((int)$Mesesa)}} anualidades por la cantidad de ${{number_format($anualidadt,2)}} ({{ $formater->format((int)$anualidadt)}} pesos {{substr(explode(".",(string)$anualidadt)[1] ?? '00',0,2)}}/100 m.n), pagándolos en los días {{ strftime("01 de %B de %Y", $nuevaFecha->getTimestamp()) }} al {{$newAno}},
                pagándose en la cuenta descrita en el inciso (c), de este apartado. Dichas mensualidades se pagarán cada día {{$dia}} de cada mes,
                comenzando a pagar el dia {{ strftime("%d de %B de %Y", $dateInicio->getTimestamp()) }}.
        </p>
        @endif
        <p>
                1.- Se respetara el precio de ${{number_format($preresof,2)}} ({{ $formater->format((int)$preresof)}} pesos {{substr(explode(".",(string)$preresof)[1] ?? '00',0,2)}}/100 m.n) si el pago total es efectuado en un año a partir de la fecha de firma del contrato.
        </p>
        <p>
                2.- Se respetara el precio de ${{number_format($preres2,2)}} ({{ $formater->format((int)$preres2)}} pesos {{substr(explode(".",(string)$preres2)[1] ?? '00',0,2)}}/100 m.n) si el pago total es efectuado en un plazo de dos años a partir de la fecha de firma del contrato.
        </p>
        <p>
                3.- Se respetara el precio de ${{number_format($preres3,2)}} ({{ $formater->format((int)$preres3)}} pesos {{substr(explode(".",(string)$preres3)[1] ?? '00',0,2)}}/100 m.n) si el pago total es efectuado en un plazo de tres años a partir de la fecha de firma del contrato.
        </p>
        <br>
        <p>
            c).- La cuenta a la que se referirán los pagos descritos anteriormente es la siguiente:
        </p>
        <br>
        <p>
            •	Nombre: <b>SANTIAGO PINEDO IRIGOYEN (REPRESENTANTE DE VILLAS DE GUADALUPE CONTRATADO POR EL SEÑOR {{$nombread}} ).</b>
        </p>
        <p>
            •	Banco: <b>AFIRME</b>
        </p>
        <p>
            •   Número de cuenta: <b>17 71 39 947</b>
        </p>
        <p>
            •	Clave interbancaria: <b>06 2164 0017 7139 9473</b>
        </p>
        <p>
            •	Número de Tarjeta: <b>4320 4901 0138 1364</b>
        </p>
        <p>
            Sirviendo los comprobantes que expida el Banco por los referidos depósitos como el comprobante de pago más eficiente que en derecho corresponda	es esto a la mensualidad correspondiente, mismos que habrán de llevar la siguiente referencia: <b>{{$referencia}}</b>,  del cual mandara su recibo de pago de la mensualidad a el siguiente número <b>(656)532 59 57.</b>
        </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>TERCERA.</u> - <u><b>INTERESES.</u>- La suma adeudada no causará intereses ordinarios, no así las mensualidades que eventualmente se llegaran a vencer, las cuales causaran el 3% (tres por ciento) mensual del pago vencido, los cuales serán denominados como <b>INTERESES MORATORIOS</b>, se cobrara dicho porcentaje a partir de la 4ta(cuarta) mensualidad vencida consecutiva.
    </p>
        </div>
        <br>
    <div>
        <p>
            <u><b>CUARTA. - OBLIGACIONES DE “LA PARTE ADQUIRENTE”.</u>- “LA PARTE
            ADQUIRENTE” se obliga a lo siguiente:
        </p>
    <p>
        a).- A pagar oportunamente las cantidades adeudadas, tal y como se establece en el presente contrato.
    </p>
    <p>
        b).- A pagar las contribuciones, derechos por servicios públicos que son agua y luz demás cargas fiscales que tenga la parcela a partir de la fecha del presente Contrato.
    </p>
    <p>
        c).- A no traspasar sus derechos sobre este Contrato a terceros, sin el previo consentimiento de “LA PARTE ENAJENANTE”, dado por escrito.
     </p>
     <p>
        d).- Se obliga “LA PARTE ADQUIRENTE” a proteger y conservar el medio ambiente natural de la zona, por lo que queda prohibido en este predio su uso para, yonkes,
        marraneras, fosas sépticas, ni cualquier otra actividad que dañe el medio ambiente y la buena vecindad.
     </p>
     <p>
        e). - Se obliga “LA PARTE ADQUIRENTE” en cumplimiento con el Principio de Conservación de la Ley de Equilibrio Ecológico y Protección al Ambiente del Estado de Chihuahua a realizar construcciones hasta por 500 metros cuadrados por lote adquirido, protegiendo la biodiversidad de la región, así mismo únicamente se permitirá la instalación de Biodigestores como sistema de saneamiento o drenaje.
     </p>
     <p>
        f) Cumplir con los reglamentos residenciales y acuerdos de convivencia que se expidan por parte del Desarrollo Inmobiliario y del Comité de Vecinos. Mismos que se otorgaran una vez realizado el proceso de urbanización.
     </p>
     <p>
        g} Para cumplir con su obligación de escriturar el Inmueble en un periodo de 12 meses posteriores en el momento que quede totalmente liquidado el adeudo referido en la cláusula segunda de este contrato y se tramite el protocolo correspondiente.
     </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>QUINTA.</u>- <b>OBLIGACIONES DE “LA PARTE ENAJENANTE”</b>, se obliga a lo siguiente:
    </p>
    <br>
    <p>
        a).- A realizar las gestiones necesarias y suficientes para garantizar la legal propiedad y posesión sin perturbación alguna para “LA PARTE ADQUIRENTE”, para tales efectos “LA PARTE ENAJENANTE” declara que inicio ante el <u><b>Reaistro Agrario Nacional</u> la solicitud de DOMINIO PLENO para su posterior INSCRIPCION del TITULO DE PROPIEDAD ante Registro Público de la Propiedad para proceder a escrituras la segregación de la parcela, la cual se encuentra sujeta los plazos de las autoridades correspondientes.
    </p>
    <p>
        b). - A iniciar los trámites que sean necesarios para gestionar el suministro de electricidad a un plazo de 36 meses a reserva de los tiempos que marca la autoridad Comisión Federal de Electricidad (CFE) y agua en el predio adquirido en un lapso de
        24 meses, a partir de la fecha de firma del presente contrato, y a dar oportuno seguimiento durante el plazo que establezcan los prestadores de dichos suministros.
    </p>
    <p>
        c).- A otorgar la Escritura definitiva de compra-venta a favor de “LA PARTE ADQUIRENTE” o de quien esta designen, todos los gastos que esto genere serán por cuenta exclusiva de “LA PARTE ADQUIRENTE”, lo anterior una vez realizada las condiciones suspensivas relacionadas anteriormente y el precio haya sido liquidado.
    </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>SEXTA.</u>- <u><b>POSESIÓN.</u>- La posesión del Inmueble, la entrega “LA PARTE ENAJENANTE” a “LA PARTE ADQUIRENTE” a la firma del presente contrato, autorizándola expresamente a realizar edificaciones siempre y cuando notifique al desarrollador, con el objetivo de garantizar el adecuado desarrollo del complejo por lo que en caso de ser necesario deberá agendar visita con el agente inmobiliario para que este realice las gestiones o facilite la información necesaria en caso de iniciar un proyecto arquitectónico ejecutivo o instalaciones menores antes del plazo pactado.
    </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>SÉPTIMA.</u> - <u><b>TRASPASO DEFINITIVO.</u> - El pleno dominio del Inmueble pasará a ‘LA PARTE ADQUIRENTE” al momento de que el precio pactado quede totalmente liquidado y firmado.
    </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>OCTAVA.</u> - <u><b>CAUSAS DE RESCISIÓN.</u> - Serán causas de rescisión de este contrato, las siguientes
    </p>
    <br>
    <p>
        a).- Después de omitir el pago de 3 (tres) mensualidades continuas y discontinuas de las cantidades adeudadas por “LA PARTE ADQUIRENTE”.
    </p>
    <p>
        b).- Por el traspaso hecho a terceros de los derechos de “LA PARTE ADQUIRENTE”, antes de terminar de pagar el precio, y sin el previo consentimiento de “LA PARTE ENAJENANTE”, dado por escrito.
    </p>
    <p>
        c).- Incumplimiento de cualquiera de las cláusulas establecidas en el presente contrato.
    </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>NOVENA.</u>- <u><b>TESTAMENTO SIMPLIFICADO.</u>- Manifiesta “LA PARTE ADQUIRIENTE”
        que en caso de fallecimiento los derechos y obligaciones contratados en el presente quedan a favor de:<u><b>{{$falleci}}</u>
    </p>
    </div>
    <br>
    <div>
    <p>
    <u><b>DÉCIMA.</u> - <u><b>PENA CONVENCIONAL.</u> - Las partes acuerdan en que, si por cualquier causa se rescinde el presente contrato, la parte responsable de la rescisión pagará a favor de la parte inocente, como pena convencional, la siguiente:
    </p>
    <br>
    <p>
        a).- En caso de que “LA PARTE ADQUIRENTE” fuera la responsable de la rescisión, ésta pagará a “LA PARTE ENAJENANTE”, un equivalente en efectivo al 10% (diez por ciento) del total del valor del precio de la presente operación, sin sus intereses o accesorios; así mismo los pagos realizados al precio de la presente operación quedarán por concepto de arrendamiento a favor de “LA PARTE ENAJENANTE”.
    </p>
    <p>
        b).- En caso de que “LA PARTE ENAJENANTE” fuera la responsable de la rescisión, ésta pagará a “LA PARTE ADQUIRENTE”, los abonos realizados como abono al precio de la presente operación, más el 10% (diez por ciento) del total del valor del precio de la presente operación, adicionalmente “LA PARTE ENAJENANTE”, pagará a favor de “LA PARTE ADQUIRENTE”, todas y cada una de las construcciones, instalaciones o infraestructura que se hubiese hecho en el Inmueble.
        Las obligaciones antes referidas deberán ser cumplidas en un plazo no mayor de 180 (ciento ochenta) días a partir de la recisión.
    </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>DÉCIMA PRIMERA.</u> - Todos los gastos, honorarios notariales e impuestos, que cause el presente contrato de enajenación onerosa de derechos parcelarios, así como su formalización, serán por cuenta exclusiva de “LA PARTE ADQUIRENTE”.
    </p>
    </div>
    <br>
    <div>
    <p>
        <u><b>DÉCIMA SEGUNDA.</u> - Los comparecientes señalan como sus domicilios convencionales, para notificaciones y/o cobros los siguientes:
    </p>
    </div>
    <br>
    <p>
        <b>“LA ENAJENANTE”:{{$nombread}}</b> <u><b>{{$direccionad}}<b></u>, TEL/CEL: <u><b>{{$cellad}}</u>, dirección de correo electrónico <u>{{$emailad}}</u>
        <b>Clave electoral: {{$elecad}}.</b>
    </p>
    <br>
    <p>

        <b>“LA PARTE ADQUIRENTE”:{{$nombreena}}</b> <u><b>{{$direccionena}}<b></u>, TEL/CEL: <u><b>{{$cellad}}</u> dirección de correo electrónico:{{$emailena}}

    </p>
    <br>
    <div>
    <p>
        <u><b>DÉCIMA TERCERA.</u> - Para la interpretación y cumplimiento de los pactos del presente contrato, las partes reconocen como aplicables las Leyes, y competentes los tribunales de esta Ciudad Juárez, Chihuahua, renunciando al fuero que por razón de su domicilio o por cualquier otra causa pudiese corresponderles.
    </p>
    </div>
    <br>
    <p>
        <b>LEIDO QUE FUE EL PRESENTE INSTRUMENTO POR LAS PARTES QUE EN EL INTERVINIERON Y APROBARON, LO FIRMAN DE CONFORMIDAD EN CIUDAD JUAREZ, CHIHUAHUA EL DIA <u><b>{{date_format($date,"d F Y")}}</u> ANTE LOS TESTIGOS QUE DE IGUAL MANERA FIRMAN AL CALCE.</b>
    </p>
</div>
        <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            height: 50%;
            break-after: page;
        }

        th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;

        }

        th {
            background-color: white;
        }

        .header-row td {
            border: none;
            background-color: transparent;
        }

        .page-break {
            page-break-before: always;
        }

         .table-container {
        page-break-inside: avoid;
    }

    </style>

<div  class="page-break table-container" style="clear: both;">
    <table >
        <tbody>
            <br>
            <br>
            <tr>
                <th colspan="3">“PARTE ENAJENANTE”</th>
                <th>     </th>
                <th>     </th>
                <th colspan="3">“PARTE ADQUIRENTE”</th>
            </tr>
            <tr HEIGHT="300" >
                <th colspan="3">                  </th>
                <th>     </th>
                <th>     </th>
                <th colspan="3">                  </th>
            </tr>
            <tr>
               <td colspan="3"><hr style="width:100%; noshade:noshade; color:black;">{{$nombreena}}<br></td>
               <td>     </td>
               <td>     </td>
               <td colspan="3"><hr style="width:100%; noshade:noshade; color:black;">{{$nombread}}<br> </td>
            </tr>
            <tr HEIGHT="300" >
                <th colspan="3">                  </th>
                <th>     </th>
                <th>     </th>
                <th colspan="3">                  </th>
            </tr>
            <tr>
                <td colspan="3"><hr style="width:100%; noshade:noshade; color:black;">TESTIGO<br></td>
                <td>     </td>
                <td>     </td>
                <td colspan="3"><hr style="width:100%; noshade:noshade; color:black;">TESTIGO<br> </td>
             </tr>
        </tbody>
    </table>
</div>
</body>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>
</html>
