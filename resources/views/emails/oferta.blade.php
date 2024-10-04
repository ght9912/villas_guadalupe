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
            ¡Recibiste una oferta!
        </div>
        <div class="container">

        @php
        $enganche = $data['enganche'];
        @endphp

            @if ($data['meses'] == 1)
                <div class="content">

                    <p>
                        En Villas de Guadalupe nos interesamos en ofrecerle las mejores opciones inmobiliarias acorde a sus necesidades. Es por eso que tenemos a bien la siguiente oferta:
                        <br>De acuerdo a lo tratado con el vendedor <strong>{{$vendedor}}</strong> se le ofrece a <strong>{{$data['nombre']}}</strong> el lote <strong>{{$data['lote']}}</strong>, en la manzana <strong>{{$data['manzana']}}</strong>,de la zona <strong>{{$data['etapa']}}</strong>, del  del proyecto <strong>{{$data['proyecto']}}</strong> a un precio de <strong>{{$data['pago']}}</strong> de <strong>$ {{number_format($data['precio'], 2)}}</strong>.
                    </p>



                </div>
            @else
                @if ($data['anualidad'] != 0)
                    @if ($data['enganche'] !=0)

                        <div class="content">

                            <p>
                                En Villas de Guadalupe nos interesamos en ofrecerle las mejores opciones inmobiliarias acorde a sus necesidades. Es por eso que tenemos a bien la siguiente oferta:
                                <br>De acuerdo a lo tratado con el vendedor <strong>{{$vendedor}}</strong> se le ofrece a <strong>{{$data['nombre']}}</strong> el lote <strong>{{$data['lote']}}</strong>, en la manzana <strong>{{$data['manzana']}}</strong>,de la zona <strong>{{$data['etapa']}}</strong>, del proyecto <strong>{{$data['proyecto']}}</strong>
                                a un precio <strong>{{$data ['pago']}}</strong> de <strong>$ {{number_format($data['precio'], 2)}}</strong> con un enganche de <strong>$ {{number_format($enganche, 2)}}</strong>, a un plazo de <strong>{{$data['meses']}} meses</strong> con una anualidad de <strong>$ {{number_format($data['anualidad'],2)}}</strong>.
                            </p>

                        </div>
                    @else
                        <div class="content">

                            <p>
                                En Villas de Guadalupe nos interesamos en ofrecerle las mejores opciones inmobiliarias acorde a sus necesidades. Es por eso que tenemos a bien la siguiente oferta:
                                <br>De acuerdo a lo tratado con el vendedor <strong>{{$vendedor}}</strong> se le ofrece a <strong>{{$data['nombre']}}</strong> el lote <strong>{{$data['lote']}}</strong>, en la manzana <strong>{{$data['manzana']}}</strong>,de la zona <strong>{{$data['etapa']}}</strong>, del proyecto <strong>{{$data['proyecto']}}</strong>
                                a un precio <strong>{{$data ['pago']}}</strong> de <strong>$ {{number_format($data['precio'], 2)}}</strong>, a un plazo de <strong>{{$data['meses']}} meses</strong> con una anualidad de <strong>$ {{number_format($data['anualidad'],2)}}</strong>.
                            </p>

                        </div>

                    @endif
                @else
                    @if ($data['enganche'] !=0)
                        <div class="content">

                                <p>
                                    En Villas de Guadalupe nos interesamos en ofrecerle las mejores opciones inmobiliarias acorde a sus necesidades. Es por eso que tenemos a bien la siguiente oferta:
                                    <br>De acuerdo a lo tratado con el vendedor <strong>{{$vendedor}}</strong> se le ofrece a <strong>{{$data['nombre']}}</strong> el lote <strong>{{$data['lote']}}</strong>, en la manzana <strong>{{$data['manzana']}}</strong>,de la zona <strong>{{$data['etapa']}}</strong>, del proyecto <strong>{{$data['proyecto']}}</strong>
                                    a un precio <strong>{{$data ['pago']}}</strong> de <strong>$ {{number_format($data['precio'], 2)}}</strong> con un enganche de <strong>$ {{number_format($enganche, 2)}}</strong>, a un plazo de <strong>{{$data['meses']}} meses</strong>.
                                </p>

                            </div>
                    @else
                            <div class="content">

                                <p>
                                    En Villas de Guadalupe nos interesamos en ofrecerle las mejores opciones inmobiliarias acorde a sus necesidades. Es por eso que tenemos a bien la siguiente oferta:
                                    <br>De acuerdo a lo tratado con el vendedor <strong>{{$vendedor}}</strong> se le ofrece a <strong>{{$data['nombre']}}</strong> el lote <strong>{{$data['lote']}}</strong>, en la manzana <strong>{{$data['manzana']}}</strong>,de la zona <strong>{{$data['etapa']}}</strong>, del proyecto <strong>{{$data['proyecto']}}</strong>
                                    a un precio <strong>{{$data['pago']}}</strong> de <strong>$ {{number_format($data['precio'], 2)}}</strong>, a un plazo de <strong>{{$data['meses']}} meses</strong>.
                                </p>

                            </div>
                    @endif
                @endif
            @endif
                 <p>Si desea conocer más acerca de los detalles de las cuotas, se adjunta un documento con toda la informacion.</p>

                <p>
                    Esperamos que la propuesta sea de su agrado y nos ponemos a su disposición a través de nuestra <a href="https://villasdeguadalupedesarrollos.com/"> pagina web</a>, nuestro teléfono (656) 865 84 05 y nuestras oficinas ubicadas en Rio Nilo 449, Interior 1 - A, CP 32310, Juarez, Chihuahua
                    No olvide visitar nuestro sitio <a href="https://villasdeguadalupedesarrollos.com/">Villas de Guadalupe</a> donde podrá conocer otras ofertas inmobiliarias.
                </p>
                <p>
                    Sin más por el momento nos despedimos de usted que tenga un excelente día.
                    atentamente Villas de Guadalupe.
                </p>
            </div>
        </div>
        <div class="footer">
            Este correo electrónico es automático, por favor no lo respondas.
        </div>
    </div>

</body>
</html>
