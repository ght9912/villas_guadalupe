<!DOCTYPE html>
<html>
<head>
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
     <!-- Scripts -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
     <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
     <script src="{{ asset('js/app.js') }}" defer></script>
     <script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>
<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    /* Estilos personalizados */
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f3f5;
        padding: 20px;
        color: #333;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        background-color: #FFFF00;
        color: black;
        padding: 10px;
        text-align: center;
        font-size: 24px;
    }

    .content {
        margin-top: 20px;
        text-align: justify;
    }

    .footer {
        margin-top: 20px;
        font-size: 12px;
        color: #888;
    }
    .logo-container {
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        margin-bottom: 10px;
    }

    .logo-img {
        max-width: 200px;
    }
    </style>
    </head>
<body>


    <div class="container">
        <div class="logo-container">
            <img src="{{asset('img/logo.png')}}" alt="";>
        </div>
        <div class="header">
            ¡Pago Realizado Con exito!
        </div>
        <div class="container">

            @if ($data['extra'] === 1)
                <p>Su pago de mensualidad ha sido mayor que el establecido en el contrato, por lo que se han generado dos pagos. Uno con la mensualidad establecida en el contrato por la cantidad de ${{ number_format($data['mensualidad'], 2) }}, y otro con el excedente del pago original recibido de ${{ number_format($data['pago_ori'], 2) }}. Ambos pagos se tomarán en consideración en el total de pago.</p>
            @elseif ($data['extra'] === 2)
                <p>Su pago de anualidad ha sido mayor que el establecido en el contrato, por lo que se han generado dos pagos. Uno con el pago establecido en el contrato por la cantidad de ${{ number_format($data['anualidad'], 2) }}, y otro siendo este con el excedente del pago original recibido de ${{ number_format($data['pago_ori'], 2) }}. Ambos pagos se tomarán en consideración en el total de pago.</p>
            @else
                <p>Su pago ha sido recibido con éxito. Se adjunta un recibo con la información relevante del pago.</p>
            @endif

        </div>
        </div>
        <div class="footer">
            Este correo electrónico es automático, por favor no lo respondas.
        </div>
    </div>

</body>
</html>
