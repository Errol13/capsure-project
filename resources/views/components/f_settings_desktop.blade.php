<div class="row mt-2">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <p class="fs-sm-name fs-md-name poppins-medium mb-0 poppins-light ms-4">SETTING</p>
        <div class="d-flex justify-content-end align-items-end">
            <button class="btn-cancel me-3 px-3">Cancel</button>
            <button class="btn-save px-3">Save</button>
        </div>
    </div>
</div>

<div class="row">
    <!--First Column -->
    <div class="col-md-2 col-lg-2">
        <!--Profile Pic and Personal Information -->
        <div class="row my-2">
            <div class="profile-container">
                <img src="{{ asset('assets/daisy.svg') }}" alt="Profile Picture" class="rounded-circle img-fluid">
            </div>

            <div class="d-flex align-items-center justify-content-center my-3">
                <p class="poppins-regular f6 mb-0 text-muted">Edit your profile</p>
                <span class="ms-2"><i class="fas fa-solid fa-pen-to-square"></i></span>
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <div class="w-100">
                    @if ($user->isVerified)
                    <button class="w-100 rounded-3 btn-verified fs-5 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle me-3" style="color: #8FE2ED;"></i>
                        Verified
                    </button>
                    @else
                    <button class="w-100 rounded-3 btn-verify fs-5 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle me-3" style="color: #BEBEBE;"></i>
                        Verify Account
                    </button>
                    @endif
                </div>
            </div>


            <div class="col-md-12 d-flex align-items-center justify-content-center mt-4">
                <div class="w-100">
                    @if ($user->user_type === 'client')
                    <button class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user me-3" style="color: gray;"></i>
                        Be a Freelancer
                    </button>
                    @else
                    <button class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user me-3" style="color: gray;"></i>
                        Be a Client
                    </button>
                    @endif
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center justify-content-center mt-2">
                <div class="w-100">

                    <button class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users me-3" style="color: gray;"></i>
                        Create Team
                    </button>

                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center justify-content-center mt-2">
                <div class="w-100">

                    <button class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-evenly">
                        <i class="fas fa-users" style="color: gray;"></i>
                        Join a Team
                    </button>

                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center justify-content-center mt-4">
                <div class="w-100">

                    <button class="w-100 rounded-3 btn-cancel text-danger fs-5 d-flex align-items-center justify-content-evenly">
                        <i class="fas fa-trash" style="color: #F38E8E;"></i>
                        Delete Account
                    </button>

                </div>
            </div>


            <!--Awards and Certifications -->
            <p class="mt-3 fs-sm fs-md poppins-medium text-start">Awards & Certifications</p>

            <div class="row my-1 text-start mb-1 ms-md-4">
                @if($user->freelancer->certificates->isEmpty())
                <div class="col-12 d-flex align-items-start justify-content-start">
                    <div class="d-flex align-items-start">
                        <img class="socmed-container" src="{{ asset('assets/Prize.svg') }}" alt="Certificate">
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start text-muted">No Awards</p>
                    </div>
                </div>
                @else
                @foreach($user->freelancer->certificates as $certificate)
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <img class="socmed-container" src="{{ asset('assets/Prize.svg') }}" alt="Certificate">
                    </div>
                    <div class="col">
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md text-start">{{ $certificate->title }}</p>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md text-start">{{ $certificate->date }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <!--Space between-->
    <div class="col-1"></div>

    <!--Second Column -->
    <div class="col-md-8 col-lg-8 poppins-regular">
        <div class="row my-3">
            <!-- Basic Info -->
            <form action="/freelancer/profile/update/{{$user->id}}" method="POST" id="basic-info-form">
                @csrf
                @method('PATCH')

                <!-- Edit Button -->

                <div class="d-flex justify-content-start align-items-center mb-2">
                    <span class="h6 mb-0 me-3 poppins-medium setting-color fs-5">Basic Information</span>
                    <div class="text-start" id="edit-button" onclick="enableEditMode()">
                        <i class="fas fa-solid fa-pen mb-2 me-2 mt-2"></i>
                    </div>
                </div>



                <div class="form-group">

                    <div class="row">

                        <!--first column name to bday -->
                        <div class="col-6">
                            <!-- First Name -->
                            <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                                name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus disabled>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Last Name -->
                            <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                                name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name" disabled>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Birthdate -->
                            <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                            <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" required disabled>
                            @error('birthdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Email -->
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $user->email }}" required autocomplete="email" disabled>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <!--second column name to bday -->
                        <div class="col-6">

                            <!-- Street -->
                            <label for="street" class="form-label">{{ __('Street') }}</label>
                            <input id="street" type="text" class="form-control @error('street') is-invalid @enderror"
                                name="street" value="{{ old('street', $user->street) }}" required autocomplete="street" disabled>
                            @error('street')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Barangay -->
                            <label for="barangay" class="form-label">{{ __('Barangay') }}</label>
                            <input id="barangay" type="text" class="form-control @error('barangay') is-invalid @enderror"
                                name="barangay" value="{{ old('barangay', $user->barangay) }}" required autocomplete="barangay" disabled>
                            @error('barangay')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- City -->
                            <label for="city" class="form-label">{{ __('City') }}</label>
                            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                name="city" value="{{ old('city', $user->city) }}" required autocomplete="city" disabled>
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Contact Number -->
                            <label for="contact_number" class="form-label">{{ __('Contact Number') }}</label>
                            <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required autocomplete="contact_number" disabled>
                            @error('contact_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-6">
                            <!-- Password Information -->
                            <div class="d-flex justify-content-start align-items-center mt-4 mb-2">
                                <span class="h6 mb-0 me-3 poppins-medium setting-color fs-5">Password Information</span>
                                <div class="text-start" id="edit-button" onclick="enableEditMode()">
                                    <i class="fas fa-solid fa-pen mb-2 me-2 mt-2"></i>
                                </div>
                            </div>

                            <!-- Password -->
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <div class="input-group m-0 p-0">
                                <input id="password" type="password" placeholder="Enter New Password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" autocomplete="new-password" disabled>
                                <button type="button" class="btn border" onclick="togglePasswordVisibility('password')" disabled>
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Confirm Password -->
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <div class="input-group m-0 p-0 mb-0">
                                <input id="password_confirmation" placeholder="Confirm New Password" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" autocomplete="new-password" disabled>
                                <button type="button" class="btn border" onclick="togglePasswordVisibility('password_confirmation')" disabled>
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
                </div>

                <!-- Save and Cancel Buttons -->
                <div class="form-group text-center" id="form-buttons" style="display: none;">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                </div>
            </form>
        </div>

        <!--Services -->
        <div class="row">
            <!-- Add New Service Button -->
            <div class="text-end mt-1 d-flex align-items-center">
                <p class="mb-0 me-2 poppins-medium setting-color fs-5">Services</p>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="fas fa-solid fa-circle-plus fs-6"></i>
                </button>
            </div>
            <!-- Modal for adding new services-->
            @include('modals.addService_modal', ['freelancer_id'=> $user->id])

            @foreach ($user->freelancer->services as $service)
            <div class="row mt-1 open-sans-reg">

                <div class="col">
                    <p class="fs-smaller fs-md">{{$service->job_title}}</p>
                </div>

                <div class="col">
                    <p class="fs-smaller fs-md">₱{{$service->job_fee}} {{$service->fee_type}}</p>
                </div>

                <div class="col">
                    <button type="button" class="btn" data-bs-target="#">
                        <i class="fas fa-pen fa-solid fa-circle-plus fs-6"></i>
                    </button>
                </div>


                <div class="col-auto">
                    @if ($service->isAvailable === true)
                    <p class="text-success fs-smaller fs-md">Available</p>
                    @else
                    <p class="text-danger fs-smaller fs-md">Not Available</p>
                    @endif
                </div>
            </div>
            @endforeach


        </div>

    </div>
</div>

<script>
    function enableEditMode() {
        // Enable form fields
        document.querySelectorAll('#basic-info-form input, #basic-info-form button').forEach(function(element) {
            element.removeAttribute('disabled');
        });

        // Show Save and Cancel buttons
        document.getElementById('form-buttons').style.display = 'block';

        // Hide Edit button
        document.getElementById('edit-button').style.display = 'none';
    }

    function cancelEdit() {
        // Disable form fields
        document.querySelectorAll('#basic-info-form input, #basic-info-form button').forEach(function(element) {
            element.setAttribute('disabled', 'true');
        });

        // Hide Save and Cancel buttons
        document.getElementById('form-buttons').style.display = 'none';

        // Show Edit button
        document.getElementById('edit-button').style.display = 'block';
    }

    function togglePasswordVisibility(fieldId) {
        var field = document.getElementById(fieldId);
        var button = field.nextElementSibling;

        if (field.type === "password") {
            field.type = "text";
            button.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            field.type = "password";
            button.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>