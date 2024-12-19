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
    <div class="container d-flex justify-content-center align-items-center my-4 txt-smaller poppins-light">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-7">
                <div class="card rounded-4 bg-white px-4 mb-4">
                    <div class="card-header border-0 bg-white fs-3 text-center poppins-medium">Sign up as <b class="text-purple poppins-medium">Client</b>
                        <a class="btn-close position-absolute" href="{{ route('choose') }}" style="top: 8px; right: 8px; height: 5px; width: 5px;" aria-label="Close"></a>
                    </div>

                    <div class="card-body">
                        <small class="open-sans-reg my-2  text-danger text-center"><i>All fields are required.</i></small>

                        <form method="POST" action="{{ route('register.client.post') }}">
                            @csrf

                            <!-- First Name and Last Name -->
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label mb-0">{{ __('First Name') }}</label>
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label mb-0">{{ __('Last Name') }}</label>
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
                                <label for="email" class="form-labelmb-0">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!--Password and Confirm Password -->
                            <div class="row mb-1">
                                <div class="col-md-6 ">
                                    <label for="password" class="form-label mb-0">{{ __('Password') }}</label>
                                    <div class="input-group m-0 p-0">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <button type="button" class="btn border " onclick="togglePasswordVisibility('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label mb-0">{{ __('Confirm Password') }}</label>
                                    <div class="input-group m-0 p-0">
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

                            <!-- Birthdate -->
                            <p class="fw-bold mb-1"> What's your date of birth? </p>
                            <div class="row mb-1 ">
                                <div class="col-md-4">
                                    <label for="birth_month" class="form-label mb-0">{{ __('Month') }}</label>
                                    <select id="birth_month" class="form-select @error('birth_month') is-invalid @enderror" name="birth_month" required>
                                        <option value="" disabled selected class="text-gray"></option>
                                        @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ old('birth_month') == $month ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('birth_month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="birth_day" class="form-label mb-0">{{ __('Day') }}</label>
                                    <select id="birth_day" class="form-select @error('birth_day') is-invalid @enderror" name="birth_day" required>
                                        <option value="" disabled selected></option>
                                        @foreach(range(1, 31) as $day)
                                        <option value="{{ $day }}" {{ old('birth_day') == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('birth_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="birth_year" class="form-label mb-0">{{ __('Year') }}</label>
                                    <select id="birth_year" class="form-select @error('birth_year') is-invalid @enderror" name="birth_year" required>
                                        <option value="" disabled selected></option>
                                        @foreach(range(date('Y') - 100, date('Y')) as $year)
                                        <option value="{{ $year }}" {{ old('birth_year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('birth_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!--Address -->
                            <p class="fw-bold mb-1"> What's your address? </p>

                            <div class="row mb-1">
                                <div class="col-md-4">
                                    <label for="street" class="form-label mb-0">{{ __('Street') }}</label>
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street">
                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="barangay" class="form-label mb-0">{{ __('Barangay') }}</label>
                                    <input id="barangay" type="text" class="form-control @error('barangay') is-invalid @enderror" name="barangay" value="{{ old('barangay') }}" required autocomplete="barangay">
                                    @error('barangay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label mb-0">{{ __('City/Municipality') }}</label>
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <p class="text-center fs-cstm-6">By creating an account, you agree to <u>Terms of Use</u> and <u>Privacy Policy</u>.</p>

                            <div class="text-center">
                                <button type="submit" class="confirm rounded-pill border-0">
                                    {{ __('SIGN UP') }}
                                </button>
                            </div>

                            <div class="mt-1 mt-md-1">
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="mb-0 me-2">Already have an account?</p>
                                    <a href="{{ route('login') }}" class="text-purple fs-6 fw-medium">Log in</a>
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