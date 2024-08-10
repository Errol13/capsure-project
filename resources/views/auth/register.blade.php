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
    <div class=" bg-signup"></div>
    <div class="container mt-3 mt-md-4 txt-smaller">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card rounded bg-white px-4">
                    <div class="card-header border-0 bg-white fs-4 text-center fw-medium">Sign up as <b class="text-purple fw-medium">Client</b></div>

                    <div class="card-body  ">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- First Name and Last Name -->
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-1">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <p class="fw-bold"> What's your date of birth? </p>
                            <div class="row mb-1 ">
                                <div class="col-md-4">
                                    <label for="month" class="form-label">{{ __('Month') }}</label>
                                    <select id="month" class="form-select @error('month') is-invalid @enderror" name="month" required>
                                        <option value="" disabled selected class="text-gray">Select</option>
                                        @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="day" class="form-label">{{ __('Day') }}</label>
                                    <select id="day" class="form-select @error('day') is-invalid @enderror" name="day" required>
                                        <option value="" disabled selected>Select</option>
                                        @foreach(range(1, 31) as $day)
                                        <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="form-label">{{ __('Year') }}</label>
                                    <select id="year" class="form-select @error('year') is-invalid @enderror" name="year" required>
                                        <option value="" disabled selected>Select</option>
                                        @foreach(range(date('Y') - 100, date('Y')) as $year)
                                        <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!--Address -->
                            <p class="fw-bold"> What's your address? </p>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="street" class="form-label">{{ __('Street') }}</label>
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street">
                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="barangay" class="form-label">{{ __('Barangay') }}</label>
                                    <input id="barangay" type="text" class="form-control @error('barangay') is-invalid @enderror" name="barangay" value="{{ old('barangay') }}" required autocomplete="barangay">
                                    @error('barangay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label">{{ __('City') }}</label>
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <!--Password and Confirm Password -->
                            <div class="row mb-1">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <button type="button" class="btn border" onclick="togglePasswordVisibility('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                    <div class="input-group">
                                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                                        <button type="button" class="btn border" onclick="togglePasswordVisibility('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <p class="text-start fs-6 fs-cstm-5">By creating an account, you agree to <u>Terms of Use</u> and <u>Privacy Policy</u>.</p>

                            <div class="text-center">
                                <button type="submit" class="btn-auth rounded-pill fs-5 ">
                                    {{ __('Sign up') }}
                                </button>
                            </div>

                            <div class="mt-1 mt-md-1">
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="mb-0 me-2">Already have an account?</p>
                                    <a href="{{ route('login') }}" class="text-purple fs-6">Log in</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            const button = event.currentTarget;
            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '<i class="bi bi-eye-slash"></i>'; // Eye slash icon
            } else {
                input.type = 'password';
                button.innerHTML = '<i class="bi bi-eye"></i>'; // Eye icon
            }
        }
    </script>

</body>

</html>