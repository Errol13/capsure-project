@extends('layouts.app')

@section('content')
<div class="container px-5 poppins-light py-5 mt-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class>
                <div class="card-header text-center py-4 fs-1 fw-bold">{{ __('Log In') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                     <label for="email" class="row-12 row-md-4 row-form-label text-md-end fs-cstm-5">{{ __('Email Address') }}</label>
                        <div class="row mb-4">
                        <div class="row-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                     <label for="password" class="row-form-label text-md-end fs-cstm-5">{{ __('Password') }}</label>
                        <div class="row mb-2">
                            <div class="row-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-5">
                        <div class="row-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p class="text-center fs-cstm-6">By continuing, you agree to <u>Terms of Use</u> and <u>Privacy Policy</u>.</p>
                        <div class="row row-md-6 d-grid gap-3">
                                <button type="submit" class="btn-auth rounded-pill border-white">
                                    {{ __('Login') }}
                                </button>
                            </div>
                                <div class="row mb-4 gap-3">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-black" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                                <p class="text-center">Don't have an account yet?<a href="{{ route('choose') }}" class="text-purple fs-6 ms-1">Sign Up</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
