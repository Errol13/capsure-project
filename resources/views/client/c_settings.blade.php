@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <p class="fs-sm-name fs-md-name poppins-medium mb-0 poppins-light ms-4">SETTING</p>
        </div>
    </div>
    <div class="row">
        <!--First Column -->
        <div class="col-md-3 col-lg-3">
            <!--Profile Pic and Personal Information -->
            <div class="row my-2">
                <div class="profile-container d-flex justify-content-center align-items-center">
                    <img id="profilePicPreview" src="{{ $user->profile_image_url }}" alt="Profile Picture" class="img fluid">
                </div>

                <!-- Change Profile Pic -->
                <form action="{{ route('profilepic.update') }}" method="POST" enctype="multipart/form-data" id="profilePicForm">
                    @csrf
                    <div class="d-flex align-items-center justify-content-center my-3">
                        <p class="poppins-regular f6 mb-0 text-muted">Change profile pic</p>
                        <span class="ms-2">
                            <a href="#" class="p-0" onclick="showUploadOptions(); return false;">
                                <i class="fas fa-solid fa-arrow-up-from-bracket"></i>
                            </a>
                        </span>
                    </div>
                    <input type="file" id="profilePicUpload" name="profile_picture" style="display: none;" accept="image/*" onchange="previewImage(event)" />

                    <div id="actionButtons" class="d-flex justify-content-center my-3 d-none">
                        <button type="submit" class="btn-verify rounded px-3 me-2">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
                    </div>
                </form>

                @if($user->isVerified)
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="w-100">
                        <a class="w-100 rounded-3 btn-verified fs-5 d-flex align-items-center justify-content-center" href="#" disabled>
                            <i class="fas fa-check-circle me-3" style="color: #8FE2ED;"></i>
                            Verified
                        </a>
                    </div>
                </div>
                @elseif($user->isVerified == false && $user->verification)
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="w-100">
                        <a class="w-100 rounded-3 btn btn-secondary fs-5 d-flex align-items-center justify-content-center" href="#" disabled>
                            <i class="fas fa-check-circle me-3" style="color: #BEBEBE;"></i>
                            Pending
                        </a>
                    </div>
                </div>
                @else
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="w-100">
                        <a class="w-100 rounded-3 btn-verify fs-5 d-flex align-items-center justify-content-center" href="{{ route('validphone') }}">
                            <i class="fas fa-check-circle me-3" style="color: #BEBEBE;"></i>
                            Verify Account
                        </a>
                    </div>
                </div>
                @endif

                <div class="col-md-12 d-flex align-items-center justify-content-center mt-4">
                    <div class="w-100">
                        <a class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-center" href="{{ route('freelancer-freelancer') }}">
                            <i class="fas fa-user me-3" style="color: gray;"></i>
                            Be a Freelancer
                        </a>
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
            </div>
        </div>

        <!-- Second Column -->
        <div class="col-md-8 offset-md-1">
            <div class="row my-3">
                <!-- Basic Info -->
                <form action="/client/profile/update/{{$user->id}}" method="POST" id="basic-info-form">
                    @csrf
                    @method('PATCH')

                    <!-- Edit Button -->

                    <div class="d-flex justify-content-start align-items-center mb-2">
                        <span class="h6 mb-0 me-3 poppins-medium setting-color fs-5">Basic Information</span>
                        <div class="text-start" id="edit-button" onclick="enableEditModeDesktop()">
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
                                    <div class="text-start" id="edit-button-dt" onclick=" enableEditModeDesktop()">
                                        <i class="fas fa-solid fa-pen mb-2 me-2 mt-2"></i>
                                    </div>
                                </div>

                                <!-- Password -->
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group m-0 p-0">
                                    <input id="password" type="password" placeholder="Enter New Password" class="form-control"
                                        name="password" autocomplete="new-password" disabled>
                                    <button type="button" class="btn border" onclick="togglePasswordVisibility('password')" disabled>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <!-- Confirm Password -->
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="input-group m-0 p-0 mb-0">
                                    <input id="password_confirmation" placeholder="Confirm New Password" type="password" class="form-control"
                                        name="password_confirmation" autocomplete="new-password" disabled>
                                    <button type="button" class="btn border" onclick="togglePasswordVisibility('password_confirmation')" disabled>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="form-group text-end" id="form-buttons-dt" style="display: none;">
                        <button type="submit" class="fs-5 btn-save px-2">Save</button>
                        <button type="button" class="fs-5 btn-cancel px-2" onclick="cancelEditBasicInfo()">Cancel</button>
                    </div>
                </form>

                <div class="col-md-8 col-sm-12 d-flex justify-content-start align-items-start ms-0 ps-0">
                    <!--Social Media -->
                    @include('components.social_media', ['socmed' => $socmed])
                </div>
            </div>

        </div>
    </div>

    <!-- Save and Cancel Buttons -->
    <div class="form-group text-end" id="form-buttons-dt" style="display: none;">
        <button type="submit" class="fs-5 btn-save px-2">Save</button>
        <button type="button" class="fs-5 btn-cancel px-2" onclick="cancelEditBasicInfo()">Cancel</button>
    </div>
</div>

<script>
    function enableEditModeDesktop() {
        // Enable all input fields in the form
        document.querySelectorAll('#basic-info-form input').forEach(function(input) {
            input.disabled = false;
        });

        // Show Save and Cancel buttons
        document.getElementById('form-buttons-dt').style.display = 'block';

        // Optionally hide the edit button to prevent further clicks
        document.getElementById('edit-button-dt').style.display = 'none';
    }

    function cancelEditBasicInfo() {
        // Disable all input fields in the form
        document.querySelectorAll('#basic-info-form input').forEach(function(input) {
            input.disabled = true;
        });

        // Hide Save and Cancel buttons
        document.getElementById('form-buttons-dt').style.display = 'none';

        // Show the edit button again
        document.getElementById('edit-button-dt').style.display = 'block';
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

    function showUploadOptions() {
        // Show action buttons and hide the upload icon
        document.getElementById('actionButtons').classList.remove('d-none');
        document.querySelector('.fa-arrow-up-from-bracket').style.display = 'none';

        // Trigger the file input
        document.getElementById('profilePicUpload').click();
    }

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profilePicPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result; // Update the src with the new image
            };
            reader.readAsDataURL(input.files[0]); // Convert to base64 string
        }
    }

    function resetForm() {
        document.getElementById('profilePicUpload').value = ''; // Clear file input
        document.getElementById('profilePicPreview').src = '{{ asset($user->profile_image) }}'; // Reset to original image
        document.getElementById('actionButtons').classList.add('d-none'); // Hide action buttons
        document.querySelector('.fa-arrow-up-from-bracket').style.display = 'inline'; // Show upload icon again
    }
</script>
@endsection