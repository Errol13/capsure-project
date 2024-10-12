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
                    <div class="col-12 profile-container -flex align-items-center justify-content-center d-flex">
                        <img id="profilePicPreview" src="{{ $user->profile_image_url }}" alt="Profile Picture" class="rounded-circle img-fluid">
                    </div>
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

                <div class="row text-center mb-1 mt-4">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center ">
                            @if ($user->isVerified == true)
                            <i class="fs-5 fas fa-check-circle" style="color: #8FE2ED;"></i>
                            @else
                            <i class="fs-5 fas fa-check-circle" style="color: #BEBEBE;"></i>
                            @endif
                        </div>
                        <div class="ms-2 me-4">
                            @if ($user->isVerified == true)
                            <button class="px-3 rounded-3 btn-verified fs-6 open-sans-reg fw-bold">Verified</button>
                            @else
                            <a class="rounded-3 btn-verify fs-6 open-sans-reg" href="{{ route('validphone') }}">Verify Account</a>
                            @endif
                        </div>
                        <div class="d-flex align-items-center ms-2 ">
                            <i class=" ms-4 fs-5 fas fa-user" style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-2 ">
                            <a href="#" class="mb-0 text-start">
                                @if ($user->user_type === 'client')
                                <button class=" px-3 rounded-3 btn-save fs-6">Be a Freelancer</button></a>
                            @else
                            <button class=" px-3 rounded-3 btn-save fs-6">Be a Client</button></a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row my-0 text-center mb-1 mt-2">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center">
                            <i class="fs-5 fas fa-users" style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-4">
                            <a href="#" class="mb-0  text-start txt-purple">
                                <button class="rounded-3 btn-save fs-6"
                                    @if($user->freelancer->isin_A_Team)
                                    data-toggle="modal" data-target="#createTeamModalMobile"
                                    @else
                                    data-toggle="modal" data-target="#joinTeamModalMobile"
                                    @endif
                                    >Join/Create Team</button></a>
                            @include('modals.createTeam', ['view' => 'Mobile'])
                            @include('modals.joinTeam', ['view' => 'Mobile'])
                        </div>
                        <div class="d-flex align-items-center ms-2">
                            <i class="fs-5 fas fa-trash " style="color: #BEBEBE;"></i>
                        </div>
                        <div class="ms-2 me-2">
                            <a href="#" class="mb-0  text-start text-danger">
                                <button class="rounded-3 btn-cancel text-danger fs-6">Delete Account</button></a>
                        </div>
                    </div>
                </div>

                <!-- Settings Tab -->
                <ul class="nav nav-tabs mt-4 justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item border" role="presentation">
                        <a class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" href="#basic-info" role="tab" aria-controls="basic-info" aria-selected="true">Basic Info</a>
                    </li>
                    <li class="nav-item border" role="presentation">
                        <a class="nav-link" id="services-tab" data-bs-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false">Services</a>
                    </li>
                    <li class="nav-item border" role="presentation">
                        <a class="nav-link" id="contacts-tab" data-bs-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="false">Contacts</a>
                    </li>

                    <li class="nav-item border" role="presentation">
                        <a class="nav-link" id="portfolio-tab" data-bs-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false">Portfolio</a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="myTabContent">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                        <form action="/freelancer/profile/update/{{$user->id}}" method="POST" id="basic-info-form">
                            @csrf
                            @method('PATCH')

                            <!-- Edit Button -->
                            <div class="text-end" id="edit-button" onclick="enableEditMode()">
                                <i class="fas fa-solid fa-pen-to-square mb-2 me-2 mt-2"></i><span>Edit</span>
                            </div>

                            <div class="form-group">
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

                                <!-- Email -->
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $user->email }}" required autocomplete="email" disabled>
                                @error('email')
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
                                <div class="input-group m-0 p-0 mb-4">
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

                            <!-- Save and Cancel Buttons -->
                            <div class="form-group text-center" id="form-buttons" style="display: none;">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Services Tab -->
                    <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">

                        <!--Accordion for Terms of Service -->
                        @include('components.f_terms_service', ['freelancer' => $user->freelancer])

                        <!-- Add New Service Button -->
                        <div class="text-end mt-3 d-flex align-items-center">
                            <p class="mb-0 me-2 poppins-medium">Services</p>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="fas fa-solid fa-circle-plus"></i>
                            </button>
                        </div>


                        @foreach ($user->freelancer->services as $service)
                        @include('components.f_update_services', ['service' => $service])
                        @endforeach

                        <!--Awards-->
                        <div class="text-end mt-3 d-flex align-items-center">
                            <p class="mb-0 me-2 poppins-medium">Awards</p>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addAwardsModal">
                                <i class="fas fa-solid fa-circle-plus"></i>
                            </button>
                        </div>
                        @include('components.f_awards', ['freelancer' => $user->freelancer])

                        <!-- Skills Section for adding, editing and deleting -->
                        <div class="text-end mt-3 d-flex align-items-center">
                            <p class="mb-0 me-2 poppins-medium">Skills</p>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addSkillsModal">
                                <i class="fas fa-solid fa-circle-plus"></i> <!-- Plus icon for adding skills -->
                            </button>
                        </div>
                        @include('components.f_skills', ['freelancer' => $user->freelancer])
                    </div>

                    <!-- Contacts Tab -->
                    <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                        @include('components.social_media', ['socmed' => $user->socmed])
                    </div>

                    <!-- Portfolio Tab -->
                    <div class="tab-pane fade" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">
                        <!-- Modal Trigger -->
                        @php
                        $portfolioLimit = 3; // Maximum number of portfolios allowed
                        $portfolioCount = $user->freelancer->portfolios->count();
                        @endphp

                        @if ($portfolioCount < $portfolioLimit)
                            <button type="button" class="btn-seeprof rounded mt-3" data-bs-toggle="modal" data-bs-target="#albumModal">
                            Create Album
                            </button>
                            @else
                            <div class="d-flex justify-content-start align-items-center">
                                <button class="btn-seeprof mt-3" disabled>
                                    Create Album
                                </button>
                                <span class="ms-2 text-danger mt-2"><small>You've reached the limit ({{ $portfolioLimit }})</small></span>
                            </div>
                            @endif

                            <div class="mt-4">
                                @if ($user->freelancer->portfolios->isEmpty())
                                <div></div>
                                @else
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <!-- Upload Button -->
                                    <button type="button" class="btn-verify rounded me-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                    <!-- Delete Button -->
                                    <button type="button" class="btn-cancel rounded" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fa-solid fa-images"></i> Edit
                                    </button>

                                    <!-- Batch Delete Button -->
                                    <button id="batchDeleteButtonMobile" class="ms-2 btn-report rounded"><i class=" me-2 fas fa-trash"></i>Delete Selected</button>

                                </div>
                                @endif



                                @include('components.f_portfolios', ['portfolios' => $user->freelancer->portfolios, 'desktopView' => false])
                            </div>
                    </div>

                </div>
        </section>

        <section id="desktopview">
            <!--Settinga -->
            @include('components.f_settings_desktop')
        </section>

        <!-- Modal for adding new services-->
        @include('modals.addService_modal', ['freelancer_id'=> $user->id])

        <!--skills modal -->
        @include('modals.skills_modal', ['freelancer' => $user->freelancer])

        <!--awards -->
        @include('modals.awards_modal', ['freelancer' => $user->freelancer])

        <!--adding portfolio-->
        <livewire:addportfolio :freelancer_id="$user->id" />

        <!--updating portfolio -->
        <livewire:updateportfolio :portfolios="$user->freelancer->portfolios" />

        <!--deleting portfolio -->
        @include('modals.delete_album', ['portfolios' => $user->freelancer->portfolios])



    </div>
    <div class="mt-5"></div>
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