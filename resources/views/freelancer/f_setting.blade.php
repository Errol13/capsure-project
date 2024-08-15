@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <!--Setting -->
        <section id="mobileinfosetting">
            <div class="mt-4">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <p class="fs-sm-name fs-md-name poppins-medium mb-0 poppins-light">SETTING</p>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="row my-4 ">
                    <div class="col-12 profile-container">
                        <img src="{{ asset('assets/daisy.svg') }}" alt="Profile Picture" class="rounded-circle img-fluid">
                    </div>
                </div>

                <div class="row text-center mb-1 mt-4">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center">
                            <i class="fs-5 fas fa-check-circle" style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-4">
                            <a href="#" class="mb-0 fs-5 text-start txt-purple">Verify Account</a>
                        </div>
                        <div class="d-flex align-items-center ms-2">
                            <i class="fs-5 fas fa-user" style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-2">
                            <a href="#" class="mb-0 fs-5 text-start txt-purple">Be a Client</a>
                        </div>
                    </div>
                </div>

                <div class="row my-0 text-center mb-1 mt-2">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center">
                            <i class="fs-5 fas fa-users" style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-4">
                            <a href="#" class="mb-0 fs-5 text-start txt-purple">Join/Create Team</a>
                        </div>
                        <div class="d-flex align-items-center ms-2">
                            <i class="fs-5 fas fa-trash " style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-2">
                            <a href="#" class="mb-0 fs-5 text-start text-danger">Delete Account</a>
                        </div>
                    </div>
                </div>

                <!-- Settings Tab -->
                <ul class="nav nav-tabs mt-4 justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item border" role="presentation">
                        <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info" role="tab" aria-controls="basic-info" aria-selected="true">Basic Info</a>
                    </li>
                    <li class="nav-item border" role="presentation">
                        <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false">Services</a>
                    </li>
                    <li class="nav-item border" role="presentation">
                        <a class="nav-link" id="portfolio-tab" data-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false">Portfolio</a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="myTabContent">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                        <form action="/freelancer/profile/update/{{$user->id}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <!-- Basic Info form fields here -->
                            <div class="form-group">
                                <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--Email -->
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Birthdate -->

                                <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                                <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" required>

                                @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--Street-->
                                <label for="street" class="form-label">{{ __('Street') }}</label>
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street', $user->street) }}" required autocomplete="street">
                                @error('street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--Barangay-->
                                <label for="barangay" class="form-label">{{ __('Barangay') }}</label>
                                <input id="barangay" type="text" class="form-control @error('barangay') is-invalid @enderror" name="barangay" value="{{ old('barangay', $user->barangay) }}" required autocomplete="barangay">
                                @error('barangay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--City-->
                                <label for="city" class="form-label">{{ __('City') }}</label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $user->city) }}" required autocomplete="city">
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--Contact Number-->
                                <label for="contact_number" class="form-label">{{ __('Contact Number') }}</label>
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required autocomplete="contact_number">
                                @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--Password-->
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group m-0 p-0">
                                    <input id="password" type="password" placeholder="Enter New Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <button type="button" class="btn border " onclick="togglePasswordVisibility('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!--Confirm Password-->
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
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
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='/settings';">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Services Tab -->
                    <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                        <form action="/save-services" method="POST">
                            @csrf
                            <!-- Services form fields here -->
                            <div class="form-group">
                                <label for="service-name">Service Name</label>
                                <input type="text" class="form-control" id="service-name" name="service_name" value="{{ old('service_name') }}">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='/settings';">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Portfolio Tab -->
                    <div class="tab-pane fade" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">
                        <form action="/save-portfolio" method="POST">
                            @csrf
                            <!-- Portfolio form fields here -->
                            <div class="form-group">
                                <label for="portfolio-title">Portfolio Title</label>
                                <input type="text" class="form-control" id="portfolio-title" name="portfolio_title" value="{{ old('portfolio_title') }}">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='/settings';">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
        </section>

    </div>
    <div class="mt-5"></div>
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

@endsection