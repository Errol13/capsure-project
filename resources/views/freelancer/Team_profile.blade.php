@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Profile Header -->
    <div class="my-4 profile-header">
        <div class="image ms-4">
            <img src="assets/profilepic.svg" alt="Party Needs" style="height: 200px; width: 200px;">
        </div>
        <div class="details px-4 ms-4">
            <div class="d-flex">
                <h1 class="d-flex fs-sm-name fs-md-name text-start mb-0 poppins-medium">PARTY NEEDS</h1>
                <small style="text-align:end;"> All members verified </small>
            </div>
            <small>
                Rating:
            </small>
            <div class="d-flex align-items-center mb-3">
                <div class="rating">
                    <span class="text-warning me-1">★★★★★</span>5.0
                </div>
                <div class="team-code ms-4 ps-4">
                    Team Code: <strong>042HD9</strong>
                </div>
            </div>

            <div class="package-fee mb-3">
                Package Fee: <strong>Php 50,000.00</strong>
            </div>
            <div class="description me-4 pe-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </div>
        </div>
        <div class="align-items-start" style="position: absolute;top: 100px; right: 120px; font-size: 16px;">
            <i class="fas fa-pencil"></i>
        </div>
    </div>

    <!-- Tabs for Profile, Portfolio, and Hiring Request -------------------------------------------------------------------------------------------------------------------------------------------------->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="portfolio-tab" data-bs-toggle="tab" data-bs-target="#portfolio" type="button" role="tab" aria-controls="portfolio" aria-selected="false">Portfolio</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="hiring-request-tab" data-bs-toggle="tab" data-bs-target="#hiring-request" type="button" role="tab" aria-controls="hiring-request" aria-selected="false">Hiring Request<span class="badge-notification">3</span></button>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Profile Tab -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
                <!-- Team Members Section -->
                <span class="poppins-medium fs-5">Team Members<small>(6)</small></span>
                <div class="col-lg-4 col-md-4 team-members" style="height: 400px; overflow-y: auto;">
                    <div class="team-member" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="col member-info" style="display: flex; align-items: center;">
                            <img src="assets/profilepic.svg" alt="Member" style="margin-right: 10px;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">Phoebe Castro</p>
                                <small class="text-muted" style="margin: 0;">Photographer</small>
                                <p style="margin: 0;">★ 4.9</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center" style="color: lightgreen;">Available</div>
                        </div>
                        <div class="col">
                            <button class="btn" style="margin-left: 10px; background-color:#91216C; color:white; border-radius:10px;">Remove</button>
                        </div>
                    </div>
                    <div class="team-member" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="col member-info" style="display: flex; align-items: center;">
                            <img src="assets/profilepic.svg" alt="Member" style="margin-right: 10px;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">Phoebe Castro</p>
                                <small class="text-muted" style="margin: 0;">Photographer</small>
                                <p style="margin: 0;">★ 4.9</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center" style="color: lightgreen;">Available</div>
                        </div>
                        <div class="col">
                            <button class="btn" style="margin-left: 10px; background-color:#91216C; color:white; border-radius:10px;">Remove</button>
                        </div>
                    </div>
                    <div class="team-member" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="col member-info" style="display: flex; align-items: center;">
                            <img src="assets/profilepic.svg" alt="Member" style="margin-right: 10px;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">Phoebe Castro</p>
                                <small class="text-muted" style="margin: 0;">Photographer</small>
                                <p style="margin: 0;">★ 4.9</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center" style="color: lightgreen;">Available</div>
                        </div>
                        <div class="col">
                            <button class="btn" style="margin-left: 10px; background-color:#91216C; color:white; border-radius:10px;">Remove</button>
                        </div>
                    </div>
                    <div class="team-member" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="col member-info" style="display: flex; align-items: center;">
                            <img src="assets/profilepic.svg" alt="Member" style="margin-right: 10px;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">Phoebe Castro</p>
                                <small class="text-muted" style="margin: 0;">Photographer</small>
                                <p style="margin: 0;">★ 4.9</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center" style="color: lightgreen;">Available</div>
                        </div>
                        <div class="col">
                            <button class="btn" style="margin-left: 10px; background-color:#91216C; color:white; border-radius:10px;">Remove</button>
                        </div>
                    </div>
                    <div class="team-member" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="col member-info" style="display: flex; align-items: center;">
                            <img src="assets/profilepic.svg" alt="Member" style="margin-right: 10px;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">Phoebe Castro</p>
                                <small class="text-muted" style="margin: 0;">Photographer</small>
                                <p style="margin: 0;">★ 4.9</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center" style="color: lightgreen;">Available</div>
                        </div>
                        <div class="col">
                            <button class="btn" style="margin-left: 10px; background-color:#91216C; color:white; border-radius:10px;">Remove</button>
                        </div>
                    </div>
                    <div class="team-member" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="col member-info" style="display: flex; align-items: center;">
                            <img src="assets/profilepic.svg" alt="Member" style="margin-right: 10px;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">Phoebe Castro</p>
                                <small class="text-muted" style="margin: 0;">Photographer</small>
                                <p style="margin: 0;">★ 4.9</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center" style="color: lightgreen;">Available</div>
                        </div>
                        <div class="col">
                            <button class="btn" style="margin-left: 10px; background-color:#91216C; color:white; border-radius:10px;">Remove</button>
                        </div>
                    </div>
                    <!-- Add other team members here... -->
                </div>
                <div class="col ms-4 ps-2">
                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 form-section">
                            <span class="poppins-medium fs-5">Basic Information</span><br>
                            <!-- City -->
                            <label for="city" class="form-label">City Address</label>
                            <input id="city" type="text" class="form-control">
                            <!-- Email -->
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control">
                            <!-- Contact Number -->
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input id="contact_number" type="text" class="form-control">
                        </div>

                        <!-- Social Media -->
                        <div class="col-lg-6 col-md-6 form-section">
                            <div class="container">
                                <span class="poppins-medium fs-5">Social Media Accounts</span>
                                <form method="POST" class="row mb-1 align-items-center">
                                    <div class="col-auto col-md-2">
                                        <img src="profilepic.svg" alt="socmed Logo" class="socmed-container setting-socmed-img">
                                    </div>
                                    <div class="col col-md-8">
                                        <div class="input-group">
                                            <input type="url" name="url" class="form-control" placeholder="Enter your profile URL" readonly />
                                        </div>
                                    </div>
                                    <div class="col-auto col-md-2">
                                        <button type="button" class="btn edit-btn">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>
                                        <button type="submit" class="btn btn-primary d-none save-btn">Save</button>
                                    </div>
                                </form>
                                <form method="POST" class="row mb-1 align-items-center">
                                    <div class="col-auto col-md-2">
                                        <img src="profilepic.svg" alt="socmed Logo" class="socmed-container setting-socmed-img">
                                    </div>
                                    <div class="col col-md-8">
                                        <div class="input-group">
                                            <input type="url" name="url" class="form-control" placeholder="Enter your profile URL" readonly />
                                        </div>
                                    </div>
                                    <div class="col-auto col-md-2">
                                        <button type="button" class="btn edit-btn">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>
                                        <button type="submit" class="btn btn-primary d-none save-btn">Save</button>
                                    </div>
                                </form>
                                <form method="POST" class="row mb-1 align-items-center">
                                    <div class="col-auto col-md-2">
                                        <img src="profilepic.svg" alt="socmed Logo" class="socmed-container setting-socmed-img">
                                    </div>
                                    <div class="col col-md-8">
                                        <div class="input-group">
                                            <input type="url" name="url" class="form-control" placeholder="Enter your profile URL" readonly />
                                        </div>
                                    </div>
                                    <div class="col-auto col-md-2">
                                        <button type="button" class="btn edit-btn">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>
                                        <button type="submit" class="btn btn-primary d-none save-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Terms of Service -->
                        <div class="col-lg-12 col-md-6 terms-of-service">
                            <span class="poppins-medium fs-5">Terms of Services</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Tab -->
        <div class="tab-pane show" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">
            <div class="portfolio-section" style="padding: 20px;">

              
            </div>
        </div>

        <!-- Hiring Request Tab --------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane fade" id="hiring-request" role="tabpanel" aria-labelledby="hiring-request-tab">

            <?php
            echo '<div style="display: flex; flex-wrap: wrap; gap: 25px;">';
            for ($i = 0; $i < 3; $i++) {
                echo '
    <div style="border: 1px solid #ddd; border-radius: 10px; padding: 15px; width: 32%; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif; margin-bottom: 20px;">
        <h2 class="poppins-medium" style="font-size: 18px; margin: 0;">18th Birthday Celebration
            <a href="#" style="color: #91216C; text-decoration: none; font-size: 14px; float: right;">View Post</a>
        </h2>
        <hr class="mb-2" style="color: #CBCACA;">
         <div class="col-md-12 pb-4" style="border-radius:12px;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="fw-bold open-sans-reg" style="color: #91216C;">DATE & TIME</div>
                            </div>
                            <div class="col-md-8">
                                <div class="details">ONLY on June 27, 2024, 10:00 a.m. - 10:00 p.m.</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="fw-bold open-sans-reg" style="color: #91216C;">LOCATION</div>
                            </div>
                            <div class="col-md-8">
                                <div class="details">Zone 2, Brgy. San Felipe, Naga City</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="fw-bold open-sans-reg" style="color: #91216C;">BUDGET</div>
                            </div>
                            <div class="col-md-8">
                                <div class="details">₱100 - ₱200</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5">
                                <div class="fw-bold open-sans-reg" style="color: #91216C;">PAYMENT METHOD</div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex justify-content-start align-items-center">
                                    <i class="fas fa-solid fa-money-bills fs-5 text-success"></i>
                                    <div class="details text-uppercase ms-2 open-sans-reg fw-bold">cash</div>
                                </div>
                            </div>
                        </div>
                    </div>

        <!-- Table Negotiation -->
        <div class="d-flex table-responsive mb-2 text-center">
            <table class="table table-bordered offer-table">
                <thead>
                    <tr>
                        <th>Client\'s Offer</th>
                        <th>Your Offer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>₱500</td>
                        <td>₱400</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-column flex-sm-row align-items-center" style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
            <button class="btn negotiate-btn" style="flex: 1; width: 100%; color: white; background-color: #91216C; border: none; border-radius: 20px; padding: 10px; white-space: nowrap;">
                Negotiate
            </button>

            <button class="btn btn-primary" style="flex: 1; width: 100%; color: black; background-color: #8FE2ED; border: none; border-radius: 20px; padding: 10px; white-space: nowrap;">
                Accept Offer
            </button>

            <!-- Cancel button, shown if not accepted -->
            <button class="btn" style="flex: 1; width: 100%; color: darkgrey; background-color: transparent; border: 1px solid darkgrey; border-radius: 20px; padding: 10px;">
                Cancel
            </button>
        </div>
        <hr class="mb-2" style="color: #CBCACA;">
        <a href="#" class="text-center" style="color: #91216C; text-decoration: none; font-size: 14px; display: block; text-align: center;">
             View Transaction
        </a>
    </div>';
            }

            echo '</div>';
            ?>

        </div>
    </div>
</div>

<style>
    .badge-notification {
        display: inline-block;
        background-color: #8FE2ED;
        color: black;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1.2;
        margin-left: 8px;
        /* Adds space between text and badge */
        min-width: 20px;
        text-align: center;
    }

    .profile-header {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .portfolio-item {
        display: flex;
        justify-content: star;
        align-items: start;
    }

    .portfolio-item img {
        border-radius: 8px;
        margin-bottom: 10px;
        /* Optional: Set a max-width or height if desired */
    }

    /* Tab-specific styling */
    .nav-tabs .nav-link {
        color: black;
        width: 250px;
    }

    .nav-tabs .nav-link.active {
        color: #91216C;
        border: none;
    }

    .nav-tabs .nav-portfolio {
        color: black;
        border: none;
        background: none;
        width: 150px;
        height: 40px;
        background-color: none;
    }

    .nav-tabs .nav-portfolio.active {
        color: #91216C;
        border: none;
        background-color: none;
        background-color: #E1C1D7;
        border-radius: 50px;
        height: 40px;
    }

    .tab-content {
        margin-top: 20px;
    }

    .team-member {
        padding: 15px;
        background-color: white;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
    }

    .hiring-request-section form {
        display: flex;
        flex-direction: column;
    }

    .hiring-request-section label {
        margin-top: 10px;
    }

    .hiring-request-section input {
        padding: 10px;
        border-radius: 5px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
    }

    .hiring-request-section button {
        margin-top: 20px;
        padding: 10px;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    .hiring-request-section button:hover {
        background-color: #0056b3;
    }
</style>
@endsection