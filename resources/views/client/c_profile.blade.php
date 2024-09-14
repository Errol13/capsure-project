@extends ('layouts.app')

@section('content')
<div class="container open-sans-reg mt-4">
    <div class="row">

        <!--First Column -->
        <div class="col-4 col-md-4 col-lg-4">
            <!--Profile Pic and Personal Information -->
            <div class="row my-3">
                <div class="profile-container">
                    <img src="{{ asset('assets/daisy.svg') }}" alt="Profile Picture" class="rounded-circle img-fluid">
                </div>
            </div>

            <!--Address and Contacts -->
            <div class="row my-3 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-location-dot"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md word-wrap text-start">118 Random St Barangay 2 Cityville</p>
                    </div>
                </div>
            </div>

            <div class="row my-0 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-sharp fa-thin fa-envelope" style="color: #0a0a0a;"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start">daisy@example.com</p>
                    </div>
                </div>
            </div>

            <div class="row my-1 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-solid fa-phone"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start">09789939471</p>
                    </div>
                </div>
            </div>

            <!--Social Media Accounts -->
            <div class="row my-1 text-center mb-4 mt-3">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img class="socmed-container" src="{{ asset('assets/Facebook.svg') }}" alt="Facebook">
                        </a>
                    </div>
                    <div class="ms-1 ">
                        <a href="#">
                            <img class="socmed-container" src="{{ asset('assets/LinkedIn.svg') }}" alt="Linkedin">
                        </a>
                    </div>
                    <div class="ms-1">
                        <a href="#">
                            <img class="socmed-container" src="{{ asset('assets/Instagram.svg') }}" alt="Instagram">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8 col-md-8 col-lg-8 poppins-regular">
            <div class="row my-3">
                <!-- Full Name and Verification Status -->
                <div class="col-12 col-md-12">
                    <div class="d-flex align-items-center">
                        <p class="fs-sm-name fs-md-name text-start mb-0 poppins-medium">
                            Daisy Maureen Dimasuay
                        </p>
                        <span class="d-flex align-items-center mt-2 mb-0">
                            <i class="fas fa-check-circle fs-6 ms-2 ms-md-1 me-md-1 ms-lg-4 verify-icon mb-1 mb-md-0" title="Verified"></i>
                            <span class="fs-sm fs-md ms-1 mb-1 mb-md-0 poppins-medium">Verified</span>
                        </span>
                    </div>
                </div>
                <p class="mt-0 m-0 open-sans-reg light-color-prof">20 years old</p>

                <!-- Star Rating and Rating -->
                <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof ">Rating</p>
                <div class="star-rating mt-1">
                    <div class="d-flex align-items-center">
                        <span class="fs-6 open-sans-reg me-2">5.0</span>
                        <div>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-start align-items-start mt-2 mt-md-3">
                    <a href="#" class="rounded-1 btn-chat me-3 me-md-4 px-3 py-1 px-md-5 poppins-light fs-sm">Chat</a>
                    <button type="button" class="rounded btn-report me-2 px-3 px-md-5 py-1 py-md-1 poppins-light fs-sm" data-bs-toggle="modal" data-bs-target="#reportClientModal">Report Profile</button>
                </div>

                <div class="row mt-4 pt-2">
                    <div class="col-1 text-end">
                        <h1 style="color: #91216C;">10</h1>
                    </div>
                    <div class="col-2 me-2 d-flex justify-content-center" style="white-space: nowrap;">
                        <h4 class="mb-0 open-sans-reg light-color-prof">Events posted</h4>
                    </div>
                    <div class="col-3">
                        <a href="#" class="fs-sm poppins-medium text-decoration-underline text-muted"><small>See Events Posts</small></a>
                    </div>
                    <div class="col-1">
                        <h1 style="color: #91216C;">80%</h1>
                    </div>
                    <div class="col ms-3 ">
                        <h4 class="mb-0 open-sans-reg light-color-prof">Hiring Success Rate</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row note">
                            <span class="mb-0" style="line-height: 1; color:lightgray;">Total number of of events posted by the client. </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row note">
                            <span class="mb-0" style="line-height: 1; color:lightgray;">Represents how often a client successfully hires </span>
                        </div>
                        <div class="row note">
                            <span style=" color:lightgray;">after posting an event.</span>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 open-sans-reg light-color-prof fs-sm">Member since <strong> May 5, 2016</strong></p>
            </div>
        </div>

        <!--Freelancer Review -->
        <section id="client-reviews">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">Freelancer's Reviews</h2>
                    <p class="mb-0 fs-smaller">(10 reviews)</p>
                </div>
                <a class="fs-sm fs-md poppins-light txt-review" href="#">See All Reviews</a>
            </div>

            <!-- Reviews -->
            <div class="container">
                <div class="row d-flex align-items-center justify-content-between" style="gap: 25px;">
                    <!-- Review Item 1 -->
                    <div class="col-md-2 flex-grow-1 mb-4 rvw-container rounded shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-0 mt-3 ms-2">
                            <div>
                                <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">18th Birthday Celebration</h2>
                            </div>
                            <a class="fs-sm fs-md poppins-light txt-review me-2" href="#">See Post</a>
                        </div>
                        <span class="fs-sm fs-md poppins-light mt-0 ms-2">June 27 2024</span>
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">John Doe</span>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <span>4.9</span>
                                </div>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">John Doe</span>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <span>4.9</span>
                                </div>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">John Doe</span>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <span>4.9</span>
                                </div>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Item 2 -->
                    <div class="col-md-2 flex-grow-1 mb-4 rvw-container rounded me-2 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-0 mt-3 ms-2">
                            <div>
                                <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">18th Birthday Celebration</h2>
                            </div>
                            <a class="fs-sm fs-md poppins-light txt-review me-2" href="#">See Post</a>
                        </div>
                        <span class="fs-sm fs-md poppins-light mt-0 ms-2">June 27 2024</span>
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">John Doe</span>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <span>4.9</span>
                                </div>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">John Doe</span>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <span>4.9</span>
                                </div>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">John Doe</span>
                                <div class="mb-2">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <span>4.9</span>
                                </div>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('modals.c_report')
</div>
@endsection