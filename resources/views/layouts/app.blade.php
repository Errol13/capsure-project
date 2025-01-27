<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" sizes="196x196" href="{{ asset('assets/logotab.png') }}">
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
                    <img src="{{ asset('assets/capsure_logo.svg') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
                </a>
                @endguest

                @auth
                @if (Auth::user()->user_type == 'client')
                <a class="navbar-brand" href="{{ url('/client-homepage') }}">
                    <img src="{{ asset('assets/capsure_logo.svg') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
                </a>
                @elseif (Auth::user()->user_type == 'freelancer')
                <a class="navbar-brand" href="{{ url('/freelancer-homepage') }}">
                    <img src="{{ asset('assets/capsure_logo.svg') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
                </a>
                @endif
                @endauth

                <button class="navbar-toggler" style="border: none;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                            <a class="nav-link fw-bold text-black " href="#how-it-works">HOW IT WORKS</a>
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
                            <a class="nav-link text-black {{ request()->routeIs('client-transaction') ? 'active' : '' }}" style="white-space:nowrap;" href="{{ route('client-transaction') }}">MY TRANSACTIONS</a>
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
                            <a class="nav-link text-black {{ request()->routeIs('freelancer-transaction') ? 'active' : '' }}" style="white-space:nowrap;" href="{{ route('freelancer-transaction') }}">MY TRANSACTIONS</a>
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

                            @if(Auth::user()->user_type == 'freelancer' && Auth::user()->freelancer->team)
                            <li class="nav-item me-md-0">
                                <a class="nav-link" href="{{ route('team-profile') }}">
                                    <i class="fas fa-users" style="color: gray;"></i>
                                </a>
                            </li>
                            @endif

                            @php
                            $unreadMessagesCount = auth()->user()->conversations()->whereHas('messages', function ($query) {
                            $query->where('sender', '!=', auth()->id()) // Exclude messages sent by the authenticated user
                            ->where('recipient', auth()->id()) // Ensure the message is intended for the authenticated user
                            ->where('isRead', false); // Check if the message is unread
                            })->withCount(['messages as unread_messages' => function ($query) {
                            $query->where('sender', '!=', auth()->id()) // Exclude messages sent by the authenticated user
                            ->where('recipient', auth()->id()) // Ensure the message is intended for the authenticated user
                            ->where('isRead', false); // Check if the message is unread
                            }])->first()->unread_messages ?? 0;
                            @endphp


                            <li class="nav-item me-md-0">
                                <a class="nav-link" href="{{ route('show-chat', ['conversationId' => null]) }}">
                                    <i class="fas fa-comment"></i>
                                    @if($unreadMessagesCount > 0)
                                    <sup class="badge bg-danger" style="border-radius: 50%;">{{$unreadMessagesCount}}</sup>
                                    @endif
                                </a>
                            </li>

                            <!--for livewire or dynamic notifications -->
                            <livewire:notificationsbell />


                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   
                                    <span class="d-none d-md-inline fs-6 text-black">{{ Auth::user()->first_name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->user_type == 'client')
                                    <a class="dropdown-item" href="/client-profile">Profile</a>
                                    <a class="dropdown-item" href="/client-settings">Settings</a>
                                    @if(Auth::user()->freelancer)
                                    <a class="dropdown-item" href="/client/tofreelancer">Switch to Freelancer</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    @elseif (Auth::user()->user_type == 'freelancer')
                                    <a class="dropdown-item" href="/freelancer-profile">Profile</a>
                                    <a class="dropdown-item" href="/freelancer-settings">Settings</a>
                                    @if(Auth::user()->client)
                                    <a class="dropdown-item" href="/freelancer/toclient">Switch to Client</a>
                                    @endif
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
        </nav>

        <main class="mx-1 pb-4 mb-2">
            @yield('content')

        </main>
    </div>



    <nav class="navbar navbar-expand-sm d-sm-none fixed-bottom py-2 navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container justify-content-center">
            <div class="row w-100">
                <div class="col text-center">
                    @auth
                    @if (Auth::user()->user_type == 'client')
                    <a class="nav-link {{ request()->is('client-homepage') ? 'current' : '' }}"
                        href="{{ url('/client-homepage') }}" style="font-size:x-small;">
                        <i class="fas fa-home fs-6"></i>
                        <div>Services</div>
                    </a>
                    @elseif (Auth::user()->user_type == 'freelancer')
                    <a class="nav-link {{ request()->is('freelancer-homepage') ? 'current' : '' }}"
                        href="{{ url('/freelancer-homepage') }}" style="font-size:x-small;">
                        <i class="fas fa-home fs-6 txt-"></i>
                        <div>Job Postings</div>
                    </a>
                    @endif
                    @endauth
                </div>

                @auth
                @if (Auth::user()->user_type == 'client')
                <div class="col text-center">
                    <a class="nav-link {{ request()->is('client-events') ? 'current' : '' }}"
                        href="{{ route('client-events') }}" style="font-size:x-small;">
                        <i class="fas fa-calendar-days fs-6"></i>
                        <div>Event Post</div>
                    </a>
                </div>

                @php
                $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp
                <div class="col text-center">
                    <a class="nav-link {{ request()->is('client-transaction') ? 'current' : '' }}"
                        href="{{ url('/client-transaction') }}" style="font-size:x-small;">
                        <i class="fas fa-handshake fs-6"></i>
                        <div>Transaction</div>
                    </a>
                </div>

                @php
                $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp
                <div class="col text-center">
                    <a class="nav-link {{ Route::currentRouteName() === 'allNotifications.show' ? 'current' : '' }}"
                        href="{{ route('allNotifications.show') }}" style="font-size:x-small;">
                        <i class="notif-class fas fa-bell fs-6"></i>
                        @if($unreadCount > 0)
                        <sup class="badge bg-danger" style="border-radius: 50%;">{{$unreadCount}}</sup>
                        @endif
                        <div>Notification</div>
                    </a>
                </div>
                @elseif (Auth::user()->user_type == 'freelancer')
                <div class="col text-center">
                    <a class="nav-link {{ request()->is('my-jobs') ? 'current' : '' }}"
                        href="{{ route('my-jobs') }}" style="font-size:x-small;">
                        <i class="fas fa-briefcase fs-6"></i>
                        <div>Jobs</div>
                    </a>
                </div>
                <div class="col text-center">
                    <a class="nav-link {{ request()->is('freelancer-transaction') ? 'current' : '' }}"
                        href="{{ route('freelancer-transaction') }}" style="font-size:x-small;">
                        <i class="fas fa-handshake fs-6"></i>
                        <div>Transaction</div>
                    </a>
                </div>
                @php
                $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp
                <div class="col text-center">
                    <a class="nav-link {{ Route::currentRouteName() === 'allNotifications.show' ? 'current' : '' }}"
                        href="{{ route('allNotifications.show') }}" style="font-size:x-small;">
                        <i class="notif-class fas fa-bell fs-6"></i>
                        @if($unreadCount > 0)
                        <sup class="badge bg-danger" style="border-radius: 50%;">{{$unreadCount}}</sup>
                        @endif
                        <div>Notification</div>
                    </a>
                </div>

                @endif
                @endauth
            </div>
        </div>
    </nav>
    <style>
        .navbar .fa-calendar-days,
        .navbar .fa-home,
        .navbar .notif-class.fa-bell,
        .navbar .fa-handshake,
        .navbar .fa-briefcase {
            color: #91216c;
        }

        .nav-link.current .notif-class {
            color: #E1C1D7;
        }

        .nav-link.current i {
            color: #E1C1D7;
        }

        .nav-link.current div {
            color: #91216c;
        }
    </style>

    @livewireScripts

</body>

</html>