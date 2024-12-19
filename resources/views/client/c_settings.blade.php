@extends ('layouts.app')

@section('content')
<div class="container py-4 my-2">
    <p class="fs-sm-name fs-md-name poppins-medium mb-0 ms-1 mb-3">Settings</p>

    <div class="row justify-content-between">
        <div class="col-md-4 col-lg-3">
            <!--Profile Pic and Personal Information -->
            <div class="row my-2">
                <div class="profile-container d-flex justify-content-center align-items-center">
                    <img id="profilePicPreview" src="{{ $user->profile_image_url }}" alt="Profile Picture" class="img fluid">
                </div>

                <!-- Change Profile Pic -->
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
                <!--Verify Buttons -->
                <div class="col-md-12 d-flex justify-content-center">
                    @if ($user->isVerified)
                    <button class="btn-round poppins-regular h-100 w-75 text-black" disabled>
                        <i class="fas fa-check-circle me-2" style="color: #8FE2ED;"></i>
                        Verified
                    </button>
                    @elseif($user->isVerified == false && $user->verification)
                    <button class="btn-round pending-color h-100 w-75 poppins-regular" disabled>
                        <i class="fas fa-check-circle me-2" style="color: #BEBEBE;"></i>
                        Pending
                    </button>
                    @else
                    <a class="btn-round h-100 w-75 poppins-regular text-black" style="background-color:#8FE2ED;" href="{{ route('validID') }}">
                        Verify Account
                    </a>
                    @endif
                </div>

                <div class="col-md-12 align-items-center justify-content-center">
                    <!-- Switch role -->
                    <div class="mt-4">
                        @if ($user->user_type === 'client' && $user->freelancer === null)
                        <a href="{{route('client-to-freelancer')}}" class="btn-round h-100 w-75" style="background-color: #E1C1D7; color:#91216C">
                            <i class="fas fa-user me-2"></i>
                            Be a Freelancer
                        </a>
                        @elseif($user->user_type === 'client' && $user->freelancer)
                        <a href="{{route('client-to-freelancer')}}" class="btn-round h-100 w-75" style="background-color: #E1C1D7; color:#91216C">
                            <i class="fas fa-user me-2"></i>
                            Switch to Freelancer
                        </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-8 poppins-regular">
            <div class="row my-3">
                <!-- Basic Info -->
                <form action="/client/profile/update/{{$user->id}}" method="POST" id="basic-info-form">
                    @csrf
                    @method('PATCH')

                    <!-- Edit Button -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex justify-content-start align-items-center">
                            <h5 class="mb-0 me-3 poppins-medium setting-color">Basic Information</h5>
                            <a href="#" class=" text-muted text-start" id="edit-button" onclick="enableEditModeDesktop()">
                                <i class="fas fa-solid fa-pen my-2 me-2"></i>
                            </a>
                        </div>
                        <!-- Save and Cancel Buttons -->
                        <div class="form-group text-end" id="form-buttons-dt" style="display: none;">
                            <button type="submit" class="fs-6 btn-save">Save</button>
                            <button type="button" class="fs-6 btn-cancel" onclick="cancelEditBasicInfo()">Cancel</button>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="row">

                            <!--first column name to bday -->
                            <div class="col-6">
                                <!-- First Name -->
                                <label for="first_name" class="form-label mb-0">{{ __('First Name') }}</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus disabled
                                    data-verified="{{ auth()->user()->isVerified ? 'true' : 'false' }}">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Last Name -->
                                <label for="last_name" class="form-label mb-0 mt-2">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name" disabled
                                    data-verified="{{ auth()->user()->isVerified ? 'true' : 'false' }}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Birthdate -->
                                <label for="birthdate" class="form-label mb-0 mt-2">{{ __('Birthdate') }}</label>
                                <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                    name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" required disabled
                                    data-verified="{{ auth()->user()->isVerified ? 'true' : 'false' }}">
                                @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Email -->
                                <label for="email" class="form-label mb-0 mt-2">{{ __('Email Address') }}</label>
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
                                <label for="street" class="form-label mb-0">{{ __('Street') }}</label>
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror"
                                    name="street" value="{{ old('street', $user->street) }}" required autocomplete="street" disabled>
                                @error('street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Barangay -->
                                <label for="barangay" class="form-label mb-0 mt-2">{{ __('Barangay') }}</label>
                                <input id="barangay" type="text" class="form-control @error('barangay') is-invalid @enderror"
                                    name="barangay" value="{{ old('barangay', $user->barangay) }}" required autocomplete="barangay" disabled>
                                @error('barangay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- City -->
                                <label for="city" class="form-label mb-0 mt-2">{{ __('City') }}</label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                    name="city" value="{{ old('city', $user->city) }}" required autocomplete="city" disabled>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Contact Number -->
                                <label for="contact_number" class="form-label mb-0 mt-2">{{ __('Contact Number') }}</label>
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
                            <div class="col-8 col-lg-6 my-3">
                                <!-- Password Information -->
                                <div class="d-flex justify-content-start align-items-center mt-4 mb-2">
                                    <h5 class=" mb-0 me-3 poppins-medium setting-color">Password Information</h5>
                                    <a href="#" class=" text-muted text-start" id="edit-button" onclick="enableEditModeDesktop()">
                                        <i class="fas fa-solid fa-pen my-2 me-2"></i>
                                    </a>
                                </div>

                                <!-- Password -->
                                <label for="password_current" class="form-label mb-0">{{ __('Current Password') }}</label>
                                <div class="input-group m-0 p-0">
                                    <input id="password_current" type="password" placeholder="Enter Current Password" class="form-control @error('password_cuurent') is-invalid @enderror"
                                        name="password_current" autocomplete="new-password" disabled>
                                    <button type="button" class="btn border" onclick="togglePasswordVisibility('password_current')" disabled>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <label for="password" class="form-label mb-0 mt-2">{{ __('Password') }}</label>
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
                                <label for="password_confirmation" class="form-label mb-0 mt-2">{{ __('Confirm Password') }}</label>
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
                </form>
            </div>
            <div class="row my-3">
                <div class="col-12">
                    <!--Social Media -->
                    @include('components.social_media', ['socmed' => $user->socmed])
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function enableEditModeDesktop() {
        // Enable all input fields in the form
        document.querySelectorAll('#basic-info-form input').forEach(function(input) {
            // Keep email always disabled
            if (input.id === 'email') {
                return;
            }

            // Keep first_name and last_name disabled if the user is verified
            if ((input.id === 'first_name' || input.id === 'last_name' || input.id === 'birthdate') && input.dataset.verified === 'true') {
                return;
            }

            // Enable all other inputs
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

    // Function to preview and submit the form automatically upon selecting a file
    function submitProfilePicForm(event) {
        // Optional: Show a preview of the selected image before upload
        const file = event.target.files[0];
        if (file) {
            const preview = document.getElementById('profilePicPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }

        // Submit the form automatically after image selection
        document.getElementById('profilePicForm').submit();
    }
</script>
@endsection