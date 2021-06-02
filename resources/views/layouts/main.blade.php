<!DOCTYPE html>
<html>
    <head>
        <title>@yield("title")</title>
        <script src="https://kit.fontawesome.com/2c6ef1311b.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href={{ url('assets/img/favicon.png') }}>
        <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}">
        
        <script src="{{ url('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ url('assets/js/app.js') }}"></script>
    </head>
    <body>
        <div>
            <img style="   position: absolute; top: 0; right: 0;" src="{{ url("assets/img/sas.jpg") }}" alt="Logo del SAS">
            @yield("content")
        </div>
        <p id="creador" class="noHover" onclick="texto()" style="color:white; margin-top: 200px">Creado por Pablo De La Cuesta Espinosa</p>
    </body>
</html>