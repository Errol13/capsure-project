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
                    <a class="w-100 rounded-3 btn-verify fs-5 d-flex align-items-center justify-content-center" href="{{ route('validphone') }}">
                        <i class="fas fa-check-circle me-3" style="color: #BEBEBE;"></i>
                        Verify Account
                    </a>
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

                    <button class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#createTeamModal">
                        <i class="fas fa-users me-3" style="color: gray;"></i>
                        Create Team
                    </button>
                    @include('modals.createTeam')
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center justify-content-center mt-2">
                <div class="w-100">

                    <button class="w-100 rounded-3 btn-save fs-5 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#joinTeamModal">
                        <i class="fas fa-users me-3" style="color: gray;"></i>
                        Join a Team
                    </button>
                    @include('modals.joinTeam')
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


            <!--Awards-->
            <div class="mt-4"></div>
            <div class="text-end d-flex align-items-center mt-4">
                <p class="mb-0 me-3 poppins-medium setting-color fs-5 text-start">Awards and Certifications</p>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addAwardsModal">
                    <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i>
                </button>
            </div>
            @include('components.f_awards', ['freelancer' => $user->freelancer])

            <!--Social Media -->
            @include('components.social_media', ['socmed' => $user->socmed])

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
                <div class="form-group text-end" id="form-buttons-dt" style="display: none;">
                    <button type="submit" class="fs-5 btn-save px-2">Save</button>
                    <button type="button" class="fs-5 btn-cancel px-2" onclick="cancelEditBasicInfo()">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Services -->
        <div class="row">
            <!-- Add New Service Button -->
            <div class="text-end mt-1 d-flex align-items-center">
                <p class="mb-0 me-2 poppins-medium setting-color fs-5">Services</p>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i>
                </button>
            </div>

            @foreach ($user->freelancer->services as $service)
            <div class="row mt-1 open-sans-reg" data-id="{{ $service->id }}">
                <div class="col">
                    <input type="text" class="form-control fs-smaller fs-md" value="{{ $service->job_title }}" readonly>
                </div>
                <div class="col">
                    <input type="text" class="form-control fs-smaller fs-md" value="₱{{ $service->job_fee }} {{ $service->fee_type }}" readonly>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn edit-btn" onclick="toggleEdit('{{ $service->id }}')">
                        <i class="fas fa-pen fs-6"></i>
                    </button>

                    <!-- Hidden elements -->
                    <div class="edit-controls d-none">
                        <button type="button" class="btn availability-toggle">
                            <i class="fas fa-toggle-{{ $service->isAvailable ? 'on' : 'off' }} fs-6"></i>
                        </button>
                        <button type="button" class="btn text-danger delete-btn">
                            <i class="fas fa-trash fs-6"></i>
                        </button>
                        <button type="button" class="btn btn-primary save-btn">
                            Save
                        </button>
                        <button type="button" class="btn btn-secondary cancel-btn">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

            @endforeach
        </div>


        <!--Skills -->
        <div class="row">
            <!-- Skills Section for adding, editing and deleting -->
            <div class="text-end mt-3 d-flex align-items-center">
                <p class="mb-0 me-2 poppins-medium setting-color fs-5">Skills</p>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addSkillsModal">
                    <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i> <!-- Plus icon for adding skills -->
                </button>
            </div>
            @include('components.f_skills', ['freelancer' => $user->freelancer])
        </div>

        <!--Terms of Service -->
        <div class="row">
            <div class="text-end mt-3 d-flex align-items-center">
                <p class="mb-0 me-2 poppins-medium setting-color fs-5">Terms of Service</p>
                <!-- Edit Icon -->
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editTermsDesktopModal">
                    <i class="ms-0 me-4 fs-6 text-start fas fa-pen fa-solid"></i>
                </button>

            </div>
            <div class="container terms-container rounded">
                <p class="text-start fs-6 mt-2 ">
                    {{$user->freelancer->terms_and_conditions}}
                </p>
            </div>
            @include('modals.f_terms_desktop', ['freelancer' => $user->freelancer])
        </div>


        <!--Portfolio -->
        <div class="row mt-3">
            <!-- Add New Service Button -->
            <div class="text-end mt-1 d-flex align-items-center">
                <p class="mb-0 me-2 poppins-medium setting-color fs-5">Portfolio</p>
                @if ($portfolioCount < $portfolioLimit)
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#albumModal">
                    <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i>
                    </button>
                    @else
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#albumModal">
                        <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i>
                    </button>
                    <span class="text-danger mt-2">You exceed the limit ({{ $portfolioLimit }})</span>
                    @endif

            </div>
            @php
            $portfolioLimit = 3; // Maximum number of portfolios allowed
            $portfolioCount = $user->freelancer->portfolios->count();
            @endphp

            <div class="mt-2">
                @if ($user->freelancer->portfolios->isEmpty())
                <div></div>
                @else
                <div class="d-flex justify-content-end mb-3">
                    <!-- Upload Button -->
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                    <!-- Delete Button -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
                @endif

                @include('components.f_portfolios', ['portfolios' => $user->freelancer->portfolios])
            </div>
        </div>

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

    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle edit mode
        window.toggleEdit = function(id) {
            console.log('Editing service with ID:', id); // Verify ID is correct

            const row = document.querySelector(`[data-id="${id}"]`);
            if (!row) {
                console.error(`No row found for id ${id}`);
                return;
            }

            const isEditing = row.classList.toggle('editing');

            // Toggle input and select fields
            row.querySelectorAll('input').forEach(el => {
                el.readOnly = !isEditing;
                el.disabled = !isEditing;
            });

            // Toggle visibility of edit controls
            const controls = row.querySelector('.edit-controls');
            if (controls) {
                controls.classList.toggle('d-none', !isEditing);
            }

            // Optionally update the button text or icon
            const editButton = row.querySelector('.edit-btn');
            if (editButton) {
                editButton.innerHTML = isEditing ?
                    '<i class="fas fa-check fs-6"></i>' // Change to check icon when in editing mode
                    :
                    '<i class="fas fa-pen fs-6"></i>'; // Pen icon when not in editing mode
            }
        };

        // Optional: Add event listeners to existing edit buttons if needed
    });
</script>