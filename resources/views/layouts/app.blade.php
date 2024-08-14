<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Capsure</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!--Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/capsure.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/capsure_logo.png') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
                </a>
                @endguest

                @auth
                @if (Auth::user()->user_type == 'client')
                <a class="navbar-brand" href="{{ url('/client-homepage') }}">
                    <img src="{{ asset('assets/capsure_logo.png') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
                </a>
                @elseif (Auth::user()->user_type == 'freelancer')
                <a class="navbar-brand" href="{{ url('/freelancer-homepage') }}">
                    <img src="{{ asset('assets/capsure_logo.png') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
                </a>
                @endif
                @endauth

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">


                        <!-- Authentication Links -->
                        @guest

                        <!--Tutorial Link -->
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-black " href="#">HOW IT WORKS</a>
                        </li>

                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-bold text-black" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('choose'))
                        <li class="nav-item">
                            <a class="btn-purple rounded-2 px-3" href="{{ route('choose') }}"> SIGN UP</a>
                        </li>
                        @endif
                        @else
                        @if (Auth::user()->user_type == 'client')
                        <!-- Freelancer-specific navbar items -->
                        <li class="nav-item">
                            <a class="nav-link text-black {{ request()->is('client-homepage') ? 'active' : '' }}" href="client-homepage">SERVICES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  text-black {{ request()->is('#') ? 'active' : '' }}" href="#">MY EVENT POST</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black {{ request()->is('#') ? 'active' : '' }}" href="#">MY TRANSACTION</a>
                        </li>
                        @elseif (Auth::user()->user_type == 'freelancer')
                        <!-- Client-specific navbar items -->
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#">JOB POSTING</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#">MY JOBS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="#">MY TRANSACTION</a>
                        </li>
                        @endif

                        <!-- Common navbar items for both freelancers and clients -->
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="#">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bookmark"></i>
                            </a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bell"></i>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user"></i>
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/freelancer-profile">Profile</a>
                                <a class="dropdown-item" href="#">Setting</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-1 mx-1">
            @yield('content')
        </main>
    </div>
</body>

</html>