@extends('layouts.app')

@section('content')
<div class="container my-4 pb-2">
    <a href="{{ url('/client-events') }}" style="text-decoration:none; color:black;">
        <i class="fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

    <!-- Event Details -->
    <div class="row">
        <div class="col-md-8 pb-4" style=" border-radius:12px; justify-content:space-between;">
            <h3 class="mt-2 pb-0 poppins-medium pt-2">18th Birthday Celebration</h3>
            <p class="text-muted">Posted yesterday</p>
            <hr>
            <div class="row justify-content-between">
                <div class="row-md-3">
                    <div class="container d-flex" style="justify-content: flex-start;">
                        <div class="me-4 open-sans-reg fw-bold" style="color: #91216C;">DATE & TIME</div>
                        <div class="details">ONLY on June 27, 2024, 10:00 a.m. - 10:00 p.m.</div>
                    </div>
                </div>
                <div class="row-md-3">
                    <div class="container d-flex" style="justify-content: flex-start;">
                        <div class="me-4 open-sans-reg fw-bold" style="color: #91216C;">LOCATION</div>
                        <div class="details">Zone 2, Brgy. San Felipe, Naga City</div>
                    </div>
                </div>
                <div class="row-md-3">
                    <div class="container d-flex" style="justify-content: flex-start;">
                        <div class="me-4 open-sans-reg fw-bold" style="color: #91216C;">BUDGET</div>
                        <div class="details">₱10,000 - ₱20,000</div>
                    </div>
                </div>
                <div class="row-md-3">
                    <div class="container d-flex" style="justify-content: flex-start;">
                        <div class="me-4 open-sans-reg fw-bold" style="color: #91216C;">PAYMENT METHOD</div>
                        <div class="bi bi-cash-stackdetails">CASH </div>
                    </div>
                </div>
            </div>
            <hr>
            <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
        </div>

        <!-- Event Jobs -->
        <div class="card col-md-4" style="border-radius: 15px; background-color:white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);  border:none;">
            <div class="card-body poppins-medium">
                <h4>Event Jobs</h4>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: white;">
                        <span>2</span>
                        Photographer
                        <span class="badge bg-primary badge-custom rounded-pill">1 Hired</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: white;">
                        <span>1</span>
                        Make-Up Artist
                        <span class="badge bg-success badge-custom rounded-pill">Complete</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: white;">
                        <span>1</span>
                        Hair Stylist
                        <span class="badge bg-danger badge-custom rounded-pill">No Hired</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: white;">
                        <span>5</span>
                        Cake Baker
                        <span class="badge bg-primary badge-custom rounded-pill">3 Hired</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------------------------------------------------------------------------- -->
    <div class="card mt-4 py-2">
        <div class="container mt-2">
            <?php
            // Sample data for the tabs
            $tabs = [
                'application' => 'Application',
                'hiring-requests' => 'Hiring Requests',
                'recommendation' => 'Recommendation',
            ];

            // Sample counts for badges
            $badgeCounts = [
                'application' => 6,
                'hiring-requests' => 6,
                'recommendation' => 6,
            ];

            // Sample data for applicants
            $applicants = [
                [
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.9 (10)',
                    'role' => 'Photographer',
                    'fee' => '₱700 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.9 (10)',
                    'role' => 'Photographer',
                    'fee' => '₱700 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.9 (10)',
                    'role' => 'Photographer',
                    'fee' => '₱700 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.9 (10)',
                    'role' => 'Photographer',
                    'fee' => '₱700 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                    'chat_icon' => 'assets/chat-application.svg'
                ],
            ];

            // Sample data for hiring request
            $hiring = [
                [
                    'name' => 'Phoebe Castro',
                    'location' => 'Calabanga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.5 (10)',
                    'role' => 'Make-up Artist',
                    'fee' => '₱500 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Phoebe Castro',
                    'location' => 'Calabanga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.5 (10)',
                    'role' => 'Make-up Artist',
                    'fee' => '₱500 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Phoebe Castro',
                    'location' => 'Calabanga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.5 (10)',
                    'role' => 'Make-up Artist',
                    'fee' => '₱500 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Phoebe Castro',
                    'location' => 'Calabanga City',
                    'projects_done' => 10,
                    'rating' => '⭐4.5 (10)',
                    'role' => 'Make-up Artist',
                    'fee' => '₱500 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                ],
            ];

            // Sample data for recommendation
            $recomm = [
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role1' => 'Videographer',
                    'role2' => 'Make-up Artist',
                    'role3' => 'Cake Baker',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role1' => 'Videographer',
                    'role2' => 'Make-up Artist',
                    'role3' => 'Cake Baker',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role1' => 'Videographer',
                    'role2' => 'Make-up Artist',
                    'role3' => 'Cake Baker',
                    'profile_image' => 'assets/profilepic.svg',
                ],
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role1' => 'Videographer',
                    'role2' => 'Make-up Artist',
                    'role3' => 'Cake Baker',
                    'profile_image' => 'assets/profilepic.svg',
                ],

            ];

            ?>

            <!-- Nav tabs -->
            <ul class="nav nav-fill pt-2 poppins-medium" style="background-color: #FCF2F9; position: relative;">
                <?php foreach ($tabs as $tabId => $tabName): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $tabId === 'application' ? 'active' : ''; ?>"
                            id="<?php echo $tabId; ?>-tab"
                            data-bs-toggle="tab"
                            href="#<?php echo $tabId; ?>"
                            role="tab"
                            aria-controls="<?php echo $tabId; ?>"
                            aria-selected="<?php echo $tabId === 'application' ? 'true' : 'false'; ?>"
                            style="color:black; position:relative;">
                            <h6>
                                <?php echo $tabName; ?>
                                <span class="badge text-black" style="background-color: #8FE2ED; border-radius:150px">
                                    <?php echo $badgeCounts[$tabId]; ?>
                                </span>
                            </h6>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Tab content -->
            <div class="tab-content">

                <!-- Application Tab -->
                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                    <div class="application-content mt-4">
                        <div class="row mb-4">
                            <?php foreach ($applicants as $applicant) { ?>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                        <!-- Upper Part -->
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div>
                                                <small class="mb-0">Applying as </small><br>
                                                <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($applicant['role']); ?></span>
                                            </div>
                                            <div>
                                                <small class="mb-0">Service Fee:</small><br>
                                                <span class="fw-bold p-1" style="background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($applicant['fee']); ?></span>
                                            </div>
                                        </div>
                                        <hr class="mb-2" style="color:#CBCACA;">
                                        <!-- Profile Info -->
                                        <div class="d-flex pb-3 pt-0">
                                            <img src="<?php echo htmlspecialchars($applicant['profile_image']); ?>" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="ms-4">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($applicant['name']); ?></h6>
                                                <p class="text-muted mb-0"><?php echo htmlspecialchars($applicant['location']); ?></p>
                                                <small class="text-success mb-0"><?php echo htmlspecialchars($applicant['projects_done']); ?> Projects done</small>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <span class="badge text-black"><?php echo htmlspecialchars($applicant['rating']); ?></span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex flex-column flex-sm-row align-items-center" style="width: 100%;">
                                            <button class="btn me-2 mb-2 mb-sm-0" style="flex: 1; width: 100%; white-space:nowrap; color:white; background-color:#91216C; border:none; border-radius: 20px">See Profile</button>
                                            <button class="btn btn-primary me-2 mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#hireModal" style="flex: 1; width: 100%; color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Hire</button>
                                            <button class="btn mb-2 mb-sm-0" style="flex: 1; width: 100%; background-color:none; border-color:darkgrey; border-radius: 20px">Reject</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="hiring-requests" role="tabpanel" aria-labelledby="hiring-requests-tab">
                    <div class="application-content mt-4">
                        <div class="row mb-4">
                            <?php foreach ($hiring as $hiring) { ?>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                        <!-- Upper Part -->
                                        <div class="d-flex justify-content-between align-items-center mb-0">
                                            <div>
                                                <small class="mb-0">Hiring as </small><br>
                                                <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($hiring['role']); ?></span>
                                            </div>
                                            <div>
                                                <small class="mb-0">Service Fee:</small><br>
                                                <span class="fw-bold p-1" style="background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($hiring['fee']); ?></span>
                                            </div>
                                        </div>
                                        <hr class="mb-2" style="color:#CBCACA;">
                                        <!-- Profile Info -->
                                        <div class="d-flex pb-3 pt-0">
                                            <img src="<?php echo htmlspecialchars($hiring['profile_image']); ?>" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="ms-4">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($hiring['name']); ?></h6>
                                                <p class="text-muted mb-0"><?php echo htmlspecialchars($hiring['location']); ?></p>
                                                <small class="text-success mb-0"><?php echo htmlspecialchars($hiring['projects_done']); ?> Projects done</small>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <span class="badge text-black"><?php echo htmlspecialchars($hiring['rating']); ?></span>
                                            </div>
                                        </div>

                                        <!-- Table Negotiation -->
                                        <div class="d-flex table-responsive mt-1 mb-2 text-center">
                                            <table class="table table-bordered offer-table">
                                                <thead>
                                                    <tr>
                                                        <th>Freelancer's Offer</th>
                                                        <th>Your Offer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>₱600 per hour</td>
                                                        <td>₱500 per hour</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex flex-column flex-sm-row align-items-center" style="width: 100%;">
                                            <!-- Trigger the modal with this button -->
                                            <button class="btn me-2 mb-2 mb-sm-0 negotiate-btn" data-bs-toggle="modal" data-bs-target="#negotiateModal" style="flex: 1; width: 100%; white-space:nowrap; color:white; background-color:#91216C; border:none; border-radius: 20px">Negotiate</button>
                                            <button class="btn btn-primary me-2 mb-2 mb-sm-0" style="flex: 1; width: 100%; color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Accept Offer</button>
                                            <button class="btn mb-2 mb-sm-0" style="flex: 1; width: 100%; background-color:none; border-color:darkgrey; border-radius: 20px">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Negotiate Modal-->
                <div class="modal" id="negotiateModal" tabindex="-1" aria-labelledby="negotiateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header poppins-medium" style="border-bottom: none;">
                                <h4 class="modal-title" id="negotiateModalLabel">Make an Offer</h5>
                            </div>
                            <div class="d-flex table-responsive mt-1 mb-2 text-center">
                                <table class="table table-bordered offer-table" style="table-layout: fixed; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">Freelancer's Offer</th>
                                            <th style="width: 50%;">Your Offer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>₱600 per hour</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center" style="border:none;" value="₱500 per hour" id="offerInput" readonly>
                                                    <button class="btn" type="button" id="editButton" style="border:none;">
                                                        <i class="bi bi-pencil"></i> <!-- Bootstrap Pencil Icon -->
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mb-1">
                                <button type="button" class="btn me-2" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Offer</button>
                                <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendation Tab -->
                <div class="tab-pane fade" id="recommendation" role="tabpanel" aria-labelledby="recommendation-tab">
                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                        <div class="application-content mt-4">
                            <div class="row mb-4">
                                <?php foreach ($recomm as $recomm) { ?>
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                            <!-- Profile Info -->
                                            <div class="d-flex pb-0 pt-0">
                                                <img src="<?php echo htmlspecialchars($recomm['profile_image']); ?>" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="ms-4">
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($recomm['name']); ?></h6>
                                                    <p class="text-muted mb-0"><?php echo htmlspecialchars($recomm['location']); ?></p>
                                                    <small class="text-success mb-0"><?php echo htmlspecialchars($recomm['projects_done']); ?> Projects done</small>
                                                </div>
                                                <div class="ms-auto text-end">
                                                    <span class="badge text-black"><?php echo htmlspecialchars($recomm['rating']); ?></span>
                                                </div>
                                            </div>
                                            <hr class=" p-0 m-1" style="color:#CBCACA;">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div>
                                                    <small class="mb-0 ms-2">Service/s</small><br>
                                                    <div class="col ms-2">
                                                        <span class="fw-bold p-1  me-2" style="color: black; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($recomm['role1']); ?></span>
                                                        <span class="fw-bold p-1 me-2" style="color: black; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($recomm['role2']); ?></span>
                                                        <span class=" fw-bold p-1" style="color: black; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($recomm['role3']); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-flex flex-column flex-sm-row align-items-center" style="width: 100%;">
                                                <button class="btn me-2 mb-2 mb-sm-0" style="flex: 1; width: 100%; white-space:nowrap; color:white; background-color:#91216C; border:none; border-radius: 20px">See Profile</button>
                                                <button class="btn btn-primary me-2 mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#hireModal" style="flex: 1; width: 100%; color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Hire</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hire Modal -->
        <div class="modal" id="hireModal" tabindex="-1" aria-labelledby="hireModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex mb-4 align-items-center">
                            <!-- Profile Image -->
                            <img src="assets/profilepic.svg" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px;">

                            <!-- Profile Info -->
                            <div class="ms-3"> <!-- Add margin to the left of the text -->
                                <h6 class="mb-0">Daisy Maureen Dimasuay</h6>
                                <small class="text-muted mb-2">Naga City</small>
                                <div class="d-flex align-items-center">
                                    <span class="text-warning">⭐</span>
                                    <small class="fw-bold ms-1">5.0</small>
                                    <small class="text-muted ms-2">(10) Reviews</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group mb-4">
                            <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #EEEEEE;">
                                Photographer <span>₱5000/project</span> <span class="text-success">Available</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                Make-up Artist <span>₱5000/project</span> <span class="text-danger">Not Available</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#EEEEEE;">
                                Video Editor <span>₱5000/project</span> <span class="text-success">Available</span>
                            </div>
                        </div>
                        <div class="row d-flex mb-1 align-items-center">
                            <div class="col">
                                <label for="role" class="form-label">Hire as</label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="role">
                                    <option>Photographer</option>
                                    <option>Make-up Artist</option>
                                    <option>Video Editor</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex mb-1 align-items-center">
                            <label for="fee" class="me-3">Fee Offer</label>
                            <div class="col input-group me-2" style="max-width: 50%;">
                                <input type="text" class="form-control" id="fee" value="₱4000.00">
                                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt text-right"></i></button>
                            </div>
                            <select class="form-select" id="per" style="max-width: 30%;">
                                <option>per project</option>
                                <option>per hour</option>
                            </select>
                        </div>
                        <div class=" row mb-3 align-items-center">
                            <div class="col">
                                <label for="payment" class="form-label">Payment Method</label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="payment">
                                    <option>CASH</option>
                                    <option>CREDIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-1">
                            <button type="button" class="btn me-2" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Hire</button>
                            <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection