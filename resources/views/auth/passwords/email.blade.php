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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>


<body>
    <div class="mt-4" >
        <a class="ms-4 fw-medium fs-5" href="{{ route('login') }}" style="text-decoration: none; color:black;"><i class="fas fa-arrow-left me-3"></i>Back to Login</a>
    </div>
    <div class="container d-flex justify-content-center px-5 poppins-light py-5 mt-1">
        <div class="row justify-content-center align-items-center">
            <div class="w-100 col-md-8">
                <div class>
                    <div class="text-center mt-4 py-2 fs-2 fw-medium" style="white-space: nowrap;">{{ __('Forgot Password?') }}</div>
                    <p class="text-center note">Enter your email address below, and a link will be sent to reset your password.</p>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <label for="email" class="row-12 row-md-4 row-form-label text-md-end fs-cstm-3" >{{ __('Email Address') }}</label>
                            <div class="row mb-4">
                                <div class="row-md-4">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" style="background-color:white; color:grey;" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-md-6 d-grid gap-3">
                                <button type="submit" class="btn-auth rounded-pill border-0 border-white" style="white-space: nowrap;">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>