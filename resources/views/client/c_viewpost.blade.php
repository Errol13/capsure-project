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
                    'chat_icon' => 'assets/chat-application.svg'
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
                    'role' => 'Videographer',
                    'fee' => '₱1000 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                    'chat_icon' => 'assets/chat-application.svg'
                ],
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role' => 'Videographer',
                    'fee' => '₱1000 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                    'chat_icon' => 'assets/chat-application.svg'
                ],
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role' => 'Videographer',
                    'fee' => '₱1000 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                    'chat_icon' => 'assets/chat-application.svg'
                ],
                [
                    'name' => 'Errol Celis',
                    'location' => 'Pasay City',
                    'projects_done' => 9,
                    'rating' => '⭐5 (10)',
                    'role' => 'Videographer',
                    'fee' => '₱1000 per hour',
                    'profile_image' => 'assets/profilepic.svg',
                    'chat_icon' => 'assets/chat-application.svg'
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
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <small class="mb-0">Applying as </small>
                                                <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($applicant['role']); ?></span>
                                            </div>
                                            <div>
                                                <small class="mb-0">Service Fee:</small>
                                                <span class="fw-bold p-1" style="background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($applicant['fee']); ?></span>
                                            </div>
                                        </div>
                                        <hr class="custom-hr">
                                        <!-- Profile Info -->
                                        <div class="d-flex pb-3 pt-0">
                                            <img src="<?php echo htmlspecialchars($applicant['profile_image']); ?>" alt="Profile Image" class="rounded-circle ms-2" style="width: 70px; height: 70px; object-fit: cover;">
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
                                            <button class="btn me-2 mb-2 mb-sm-0" style="white-space:nowrap; color:#91216C; width:100px; height: 35px; background-color:none; border-color:#91216C; border-radius: 12px">See Profile</button>
                                            <button class="btn btn-primary me-2 mb-2 mb-sm-0" style="color:black; width: 100px; height: 35px; background-color:#8FE2ED; border:none; border-radius: 12px">Hire</button>
                                            <button class="btn me-2 mb-2 mb-sm-0" style="width: 100px; height: 35px; background-color:none; border-color:darkgrey; border-radius: 12px">Reject</button>
                                            <a class="d-flex align-items-center ms-2" href="#">
                                                <img src="<?php echo htmlspecialchars($applicant['chat_icon']); ?>" alt="Chat Icon" style="height: 30px;">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Hiring Request Tab -->
                <div class="tab-pane fade" id="hiring-requests" role="tabpanel" aria-labelledby="hiring-requests-tab">
                    <div class="application-content mt-4">
                        <div class="row mb-4">
                            <?php foreach ($hiring as $hiring) { ?>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                        <!-- Upper Part -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <small class="mb-0">Hiring as </small>
                                                <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($hiring['role']); ?></span>
                                            </div>
                                            <div>
                                                <small class="mb-0">Service Fee:</small>
                                                <span class="fw-bold p-1" style="background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($hiring['fee']); ?></span>
                                            </div>
                                        </div>
                                        <hr class="custom-hr">
                                        <!-- Profile Info -->
                                        <div class="d-flex pb-3 pt-0">
                                            <img src="<?php echo htmlspecialchars($hiring['profile_image']); ?>" alt="Profile Image" class="rounded-circle ms-2" style="width: 70px; height: 70px; object-fit: cover;">
                                            <div class="ms-4">
                                                <h5 class="mb-0"><?php echo htmlspecialchars($hiring['name']); ?></h5>
                                                <small class="text-muted mb-0"><?php echo htmlspecialchars($hiring['location']); ?></small><br>
                                                <small class="text-success mb-0"><?php echo htmlspecialchars($hiring['projects_done']); ?> Projects done</small>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <span class="text-black"><?php echo htmlspecialchars($hiring['rating']); ?></span>
                                            </div>
                                        </div>
                                        <hr class="custom-hr">

                                        <!-- Action Buttons -->
                                        <div class="d-flex flex-column flex-sm-row align-items-center">
                                            <a href="#" class="text-decoration-none mb-2 mb-sm-0" style="color: #91216C;">See Profile</a>
                                            <div class="d-flex flex-column flex-sm-row align-items-center ms-0 ms-sm-4" style="justify-content:flex-end;">
                                                <button class="btn btn-primary me-2 mb-2 mb-sm-0" style="color:black; width: 100px; height: 35px; background-color:#8FE2ED; border:none; border-radius: 12px">Hire</button>
                                                <button class="btn btn-outline-secondary me-2 mb-2 mb-sm-0" style="width: 100px; height: 35px; background-color:none; border-color:darkgrey; border-radius: 12px">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                <!-- Recommendation Tab -->
                <div class="tab-pane fade" id="recommendation" role="tabpanel" aria-labelledby="recommendation-tab">
                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                        <div class="application-content mt-4">
                            <div class="row mb-4">
                                <?php
                                foreach ($recomm as $recomm) {
                                ?>
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                            <!-- Upper Part -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div>
                                                    <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;"><?php echo htmlspecialchars($recomm['role']); ?></span>
                                                </div>
                                            </div>
                                            <hr class="custom-hr">
                                            <!-- Profile Info -->
                                            <div class="d-flex pb-3 pt-0">
                                                <img src="<?php echo htmlspecialchars($recomm['profile_image']); ?>" alt="Profile Image" class="rounded-circle ms-2" style="width: 70px; height: 70px; object-fit: cover;">
                                                <div class="ms-4">
                                                    <h5 class="mb-0"><?php echo htmlspecialchars($recomm['name']); ?></h5>
                                                    <small class="text-muted mb-0"><?php echo htmlspecialchars($recomm['location']); ?></small><br>
                                                    <small class="text-success mb-0"><?php echo htmlspecialchars($recomm['projects_done']); ?> Projects done</small>
                                                </div>
                                                <div class="ms-auto text-end">
                                                    <span class=" text-black"><?php echo htmlspecialchars($recomm['rating']); ?></span>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-flex flex-column flex-sm-row align-items-center">
                                                <a href="#" class="text-decoration-none mb-2 mb-sm-0" style="color: #91216C;">See Profile</a>
                                                <div class="d-flex flex-column flex-sm-row align-items-center ms-0 ms-sm-4" style="justify-content:flex-end;">
                                                    <button class="btn btn-primary me-2 mb-2 mb-sm-0" style="color:black; width: 100px; height: 35px; background-color:#8FE2ED; border:none; border-radius: 12px">Hire</button>
                                                    <a class="d-flex align-items-center ms-2" href="#">
                                                        <img src="<?php echo htmlspecialchars($recomm['chat_icon']); ?>" alt="Chat Icon" style="height: 35px;">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection