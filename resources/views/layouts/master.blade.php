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
            @if (auth()->user()->rol_id == "2")
            <ul>
                <li><a style="border: 2px solid #000;" href="{{ route('servicio.index') }}">Listado Servicios</a></li>
                <li><a style="border: 2px solid #000; border-top: 0;" href="{{ route('qr.index') }}">Listado QRs</a></li>
            </ul>
            @else
            <ul>
                <li><a style="border: 2px solid #000;" href="{{ route('servicio.index') }}">Listado Servicios</a></li>
                <li><a style="border: 2px solid #000; border-top: 0;" href="{{ route('qr.index') }}">Listado QRs</a></li>
                <li><a style="border: 2px solid #000; border-top: 0;" href="{{ route('user.index') }}">Listado Usuarios</a></li>
            </ul>
            @endif
        </div>
    </div>
        <div>
            {{-- Login y registro siempre --}}
            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">{{ __('Entrar') }}</a><br>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">{{ __('Registrarse') }}</a><br>
                @endif
                @else
                    Bienvenido, {{ Auth::user()->name }}
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><br>
                        {{ __('Cerrar sesión') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
            @endguest

            <img style="   position: absolute; top: 0; right: 0;" src="{{ url("assets/img/sas.jpg") }}" alt="Logo del SAS">
            @yield("content")
        </div>
    </body>
</html>