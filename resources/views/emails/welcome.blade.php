<!DOCTYPE html>
<html>
<head>
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
            ¡Bienvenido a Villas de Guadalupe!
        </div>
        <div class="content">
            <p>Hola {{ $name }},</p>
            <p>¡Bienvenido a nuestra comunidad! Estamos emocionados de tenerte con nosotros!.</p>
            <p>En breve podrás ingresar a la plataforma de <a href="{{ Route('home') }}">Villas de Guadalupe</a>, donde podra explorar las diferentes opciones inmobiliarias que tenemos para usted.</p>
        </div>
        <div class="footer">
            Este correo electrónico es automático, por favor no lo respondas.
        </div>
    </div>

</body>
</html>
