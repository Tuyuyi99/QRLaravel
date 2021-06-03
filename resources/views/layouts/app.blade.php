<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>QRLaravel</title>

    <script src="https://kit.fontawesome.com/2c6ef1311b.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href={{ url('assets/img/favicon.png') }}>
    <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}">
    
    <script src="{{ url('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ url('assets/js/app.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <img style="position: absolute; top: 0; right: 0;" src="{{ url("assets/img/sas.jpg") }}" alt="Logo del SAS">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                    <a class="abrirsesion" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                            @endif

                            @if (Route::has('register'))
                                    <a class="registrarse" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                            @endif
                        @else
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                        @endguest   
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
