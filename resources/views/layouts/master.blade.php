<!DOCTYPE html>
<html>
    <head>
        <title>@yield("title")</title>
        <script src="https://kit.fontawesome.com/2c6ef1311b.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href={{ url('assets/img/favicon.png') }}>
        <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}">
    </head>
    <body>
        <script src="{{ url('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ url('assets/js/app.js') }}"></script>
    <div class="padreMenu">
        <div class="menu">
            <ul >
                <li><a style="border: 2px solid #000;" href="{{ route('servicio.index') }}">Listado Servicios</a></li>
                <li><a style="border: 2px solid #000; border-top: 0;" href="{{ route('qr.index') }}">Listado QRs</a></li>
            </ul>
        </div>
    </div>
        <div>
            <img style="   position: absolute; top: 0; right: 0;" src="{{ url("assets/img/sas.jpg") }}" alt="Logo del SAS">
            @yield("content")
        </div>
        <p id="creador" class="noHover" onclick="texto()" style="color:white; margin-top: 700px">Creado por Pablo De La Cuesta Espinosa</p>
    </body>
</html>