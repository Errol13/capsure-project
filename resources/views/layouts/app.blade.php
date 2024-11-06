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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script> <!--Full viewing -->
    <link rel="stylesheet" href="{{ asset('css/capsure.css') }}">



    @livewireStyles

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
                            <a class="btn-purple rounded-4 px-3" href="{{ route('choose') }}"> SIGN UP</a>
                        </li>
                        @endif

                        @endguest
                        @Auth
                        @if (Auth::user()->user_type == 'client')
                        <!-- Client-specific navbar items -->
                        <li class="nav-item" id="nav-item-mobile">
                            <a class="nav-link text-black {{ request()->routeIs('client-homepage') ? 'active' : '' }}" href="{{ route('client-homepage') }}">SERVICES</a>
                        </li>
                        <li class="nav-item" id="nav-item-mobile">
                            <a class="nav-link text-black {{ request()->routeIs('client-events') ? 'active' : '' }}" style="white-space:nowrap;" href="{{ route('client-events') }}">MY EVENTS</a>
                        </li>
                        <li class="nav-item" id="nav-item-mobile">
                            <a class="nav-link text-black {{ request()->routeIs('client-transaction') ? 'active' : '' }}" style="white-space:nowrap;" href="{{ route('client-transaction') }}">MY TRANSACTION</a>
                        </li>

                        @elseif (Auth::user()->user_type == 'freelancer')
                        <!-- Freelancer-specific navbar items -->
                        <li class="nav-item" id="nav-item-mobile">
                            <a class="nav-link text-black {{ request()->routeIs('freelancer-homepage') ? 'active' : '' }}" href="{{ route('freelancer-homepage') }}">JOB POSTING</a>
                        </li>
                        <li class="nav-item" id="nav-item-mobile">
                            <a class="nav-link text-black {{ request()->routeIs('my-jobs') ? 'active' : '' }}" style="white-space:nowrap;" href="{{ route('my-jobs') }}">MY JOBS</a>
                        </li>
                        <li class="nav-item" id="nav-item-mobile">
                            <a class="nav-link text-black {{ request()->routeIs('freelancer-transaction') ? 'active' : '' }}" style="white-space:nowrap;" href="{{ route('freelancer-transaction') }}">MY TRANSACTION</a>
                        </li>
                        @endif

                        <!-- Common navbar items for both freelancers and clients -->
                        <div class="d-flex">

                            @if (Auth::user()->user_type == 'client')
                            <li class="nav-item me-md-0">
                                <a class="nav-link" href="{{ url('/client-bookmark') }}">
                                    <i class="fas fa-bookmark"></i>
                                </a>
                            </li>
                            @endif

                            <li class="nav-item me-md-0" id="nav-item-mobile">
                                <a class="nav-link" href="{{ route('show-chat', ['conversationId' => null]) }}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </li>

                        <!--for livewire or dynamic notifications -->
                        <livewire:notificationsbell />




                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user"></i>
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->user_type == 'client')
                                <a class="dropdown-item" href="/client-profile">Profile</a>
                                <a class="dropdown-item" href="/client-settings">Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                @elseif (Auth::user()->user_type == 'freelancer')
                                <a class="dropdown-item" href="/freelancer-profile">Profile</a>
                                <a class="dropdown-item" href="/freelancer-settings">Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                @endif

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endauth
                </div>
                </ul>
            </div>
    </div>
    </nav>

    <main class="mx-1 pb-4 mb-2">
        @yield('content')

    </main>
    </div>

    <nav class="navbar navbar-expand-sm d-sm-none fixed-bottom py-3 navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container justify-content-center">
            <div class="row w-100">
                <div class="col text-center">
                    @auth
                    @if (Auth::user()->user_type == 'client')
                    <a class="nav-link" href="{{ url('/client-homepage') }}" style="font-size:x-small;">
                        <img src="{{asset('assets/home-icon.svg')}}" alt="Services" class="services" style="width: 20px; height: 20px;">
                        <div>Services</div>
                    </a>
                    @elseif (Auth::user()->user_type == 'freelancer')
                    <a class="nav-link" href="{{ url('/freelancer-homepage') }}" style="font-size:x-small;">
                        <img src="{{asset('assets/home-icon.svg')}}" alt="Services" class="services" style="width: 20px; height: 20px;">
                        <div>Job Postings</div>
                    </a>
                    @endif
                    @endauth
                </div>

                @auth
                @if (Auth::user()->user_type == 'client')
                <div class="col text-center">
                    <a class="nav-link" href="{{ route ('client-events') }}" style="font-size:x-small;">
                        <img src="{{asset('assets/event-icon.svg')}}" alt="My-event" class="my-event" style="width: 20px; height: 20px;  white-space:nowrap;">
                        <div>Event Post</div>
                    </a>
                </div>
                <div class="col text-center">
                    <a class="nav-link" href="{{ url('/client-transaction') }}" style="font-size:x-small;">
                        <img src="{{asset('assets/transaction.svg')}}" alt="My-transaction" class="transaction" style="width: 20px; height: 20px; white-space:nowrap;">
                        <div>Transaction</div>
                    </a>
                </div>
                <div class="col text-center">
                    <a class="nav-link" href="#" style="font-size:x-small;">
                        <img src="{{asset('assets/chat.svg')}}" alt="Chat" class="chat" style="width: 20px; height: 20px;">
                        <div>Messages</div>
                    </a>
                </div>
                @elseif (Auth::user()->user_type == 'freelancer')
                <div class="col text-center">
                    <a class="nav-link" href="{{ route('my-jobs') }}" style="font-size:x-small;">
                        <img src="{{asset('assets/event-icon.svg')}}" alt="My-event" class="my-event" style="width: 20px; height: 20px;">
                        <div>Jobs</div>
                    </a>
                </div>
                <div class="col text-center">
                    <a class="nav-link" href="{{ route('freelancer-transaction') }}" style="font-size:x-small;">
                        <img src="{{asset('assets/transaction.svg')}}" alt="My-transaction" class="transaction" style="width: 20px; height: 20px;">
                        <div>Transaction</div>
                    </a>
                </div>
                <div class="col text-center">
                    <a class="nav-link" href="#" style="font-size:x-small;">
                        <img src="{{asset('assets/chat.svg')}}" alt="Chat" class="chat" style="width: 20px; height: 20px;">
                        <div>Messages</div>
                    </a>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </nav>

    @livewireScripts

</body>

</html>