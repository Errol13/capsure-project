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
                <div class="profile-container">
                    <img src="{{ asset('assets/daisy.svg') }}" alt="Profile Picture" class="rounded-circle img-fluid">
                </div>

                <div class="d-flex align-items-center justify-content-center my-3">
                    <p class="poppins-regular f6 mb-0 text-muted">Edit your profile</p>
                    <span class="ms-2"><i class="fas fa-solid fa-pen-to-square"></i></span>
                </div>

                <div class="col-md-12 d-flex justify-content-center">
                    <div class="w-100">
                        <a class="w-100 rounded-3 btn-verify fs-5 d-flex align-items-center justify-content-center" href="{{ route('validphone') }}">
                            <i class="fas fa-check-circle me-3" style="color: #BEBEBE;"></i>
                            Verify Account
                        </a>
                    </div>
                </div>

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
            <div class="row">
                <!--first column name to bday -->

                <div class="d-flex justify-content-start align-items-center mb-2">
                    <span class="h6 mb-0 me-3 poppins-medium setting-color fs-5">Basic Information</span>
                    <div class="text-start" id="edit-button" onclick="enableEditModeDesktop()">
                        <i class="fas fa-solid fa-pen mb-2 me-2 mt-2"></i>
                    </div>
                </div>
                <div class="col-6">
                    <!-- First Name -->
                    <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                    <input id="first_name" type="text" class="form-control">

                    <!-- Last Name -->
                    <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                    <input id="last_name" type="text" class="form-control">

                    <!-- Birthdate -->
                    <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                    <input id="birthdate" type="date" class="form-control">

                    <!-- Email -->
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control">
                </div>

                <!--second column name to bday -->
                <div class="col-6">
                    <!-- Street -->
                    <label for="street" class="form-label">{{ __('Street') }}</label>
                    <input id="street" type="text" class="form-control">

                    <!-- Barangay -->
                    <label for="barangay" class="form-label">{{ __('Barangay') }}</label>
                    <input id="barangay" type="text" class="form-control">

                    <!-- City -->
                    <label for="city" class="form-label">{{ __('City') }}</label>
                    <input id="city" type="text" class="form-control">

                    <!-- Contact Number -->
                    <label for="contact_number" class="form-label">{{ __('Contact Number') }}</label>
                    <input id="contact_number" type="text" class="form-control">
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

                <div class="col-6">
                    <div class="container mt-4">
                        <div class="d-flex justify-content-start align-items-center mt-4 mb-2">
                            <span class="h6 mb-0 me-3 poppins-medium setting-color fs-5 mb-3">Social Media Accounts</span>
                        </div>
                        <form method="POST" class="row mb-1 align-items-center">
                            <div class="col-auto col-md-2">
                                <img src="profilepic.svg" alt="socmed Logo" class="socmed-container setting-socmed-img">
                            </div>
                            <div class="col col-md-8">
                                <div class="input-group">
                                    <input
                                        type="url"
                                        name="url"
                                        class="form-control"
                                        placeholder="Enter your profile URL"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-auto col-md-2">
                                <button type="button" class="btn edit-btn">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <button type="submit" class="btn btn-primary d-none save-btn">
                                    Save
                                </button>
                            </div>
                        </form>
                        <form method="POST" class="row mb-1 align-items-center">
                            <div class="col-auto col-md-2">
                                <img src="profilepic.svg" alt="socmed Logo" class="socmed-container setting-socmed-img">
                            </div>
                            <div class="col col-md-8">
                                <div class="input-group">
                                    <input
                                        type="url"
                                        name="url"
                                        class="form-control"
                                        placeholder="Enter your profile URL"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-auto col-md-2">
                                <button type="button" class="btn edit-btn">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <button type="submit" class="btn btn-primary d-none save-btn">
                                    Save
                                </button>
                            </div>
                        </form>
                        <form method="POST" class="row mb-1 align-items-center">
                            <div class="col-auto col-md-2">
                                <img src="profilepic.svg" alt="socmed Logo" class="socmed-container setting-socmed-img">
                            </div>
                            <div class="col col-md-8">
                                <div class="input-group">
                                    <input
                                        type="url"
                                        name="url"
                                        class="form-control"
                                        placeholder="Enter your profile URL"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-auto col-md-2">
                                <button type="button" class="btn edit-btn">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <button type="submit" class="btn btn-primary d-none save-btn">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
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
@endsection