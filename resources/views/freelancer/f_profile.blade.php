@extends ('layouts.app')

@section('content')

<div class="container  open-sans-reg">
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
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-location-dot"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md word-wrap text-start">{{$user->street}} {{$user->barangay}} {{$user->city}}</p>
                    </div>
                </div>
            </div>

            <div class="row my-0 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-sharp fa-thin fa-envelope" style="color: #0a0a0a;"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start">{{$user->email}}</p>
                    </div>
                </div>
            </div>

            <div class="row my-1 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-solid fa-phone"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start">{{$user->contact_number}}</p>
                    </div>
                </div>
            </div>

            <!--Social Media Accounts -->
            <div class="row my-1 text-center mb-1 mt-3">
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

            <!--Awards and Certifications -->
            <p class="mt-3 fs-sm fs-md poppins-medium text-center">Awards & Certifications</p>

            <div class="row my-1 text-center mb-1 ms-md-4">
                @if($user->freelancer->certificates->isEmpty())
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
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

        <!--Second Column -->
        <div class="col-8 col-md-8 col-lg-8 poppins-regular">
            <div class="row my-3">
                <!-- Full Name and Verification Status -->
                <div class="col-12 col-md-12">
                    <div class="d-flex align-items-center">
                        <p class="fs-sm-name fs-md-name text-start mb-0 poppins-medium">
                            {{ $fullName }}
                        </p>
                        <span class="d-flex align-items-center mt-2 mb-0">
                            <i class="fas fa-check-circle fs-6 ms-2 ms-md-1 me-md-1 ms-lg-4 verify-icon mb-1 mb-md-0" title="Verified"></i>
                            <span class="fs-sm fs-md ms-1 mb-1 mb-md-0 poppins-medium">Verified</span>
                        </span>

                    </div>
                </div>
                <p class="mt-0 m-0 open-sans-reg light-color-prof">{{$user->age}} years old</p>
                <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof ">Rating</p>
                @if($user->freelancer->avg_rating == 0)
                <p class="fs-6 open-sans-reg light-color-prof mt-1 fst-italic text-muted">No ratings yet</p>
                @else
                <!-- Star Rating Container -->
                <div class="star-rating mt-0 mt-md-1">
                    <div class="row">
                        <div class="col-auto">
                            <p class="mb-0 fs-sm fs-md">{{ number_format($user->freelancer->avg_rating, 1) }}</p>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center mt-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $user->freelancer->avg_rating ? 'filled' : '' }}"></i>
                                    @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!--Hire Chat Report -->
                <div class="d-flex justify-content-start align-items-start mt-2 mt-md-3">
                    <a href="#" class="text-center btn-seemore rounded-1 px-3 py-1 px-md-5 me-3 me-md-4 poppins-light fs-sm">Hire</a>
                    <a href="#" class=" rounded-1 btn-chat me-3 me-md-4 px-3 py-1 px-md-5 poppins-light fs-sm">Chat</a>
                    <button type="button" class="rounded btn-report me-2 px-3 px-md-5 py-1 py-md-1 poppins-light fs-sm " data-bs-toggle="modal" data-bs-target="#reportProfileModal">Report</button>
                </div>

                <!-- Report Modal -->
                 @include('modals.f_report')

                <!--Team -->
                <div class=""></div>

                <!--Services -->
                <p class="mt-3 fs-sm fs-md poppins-medium">Services</p>
                @foreach ($user->freelancer->services as $service)
                <div class="row mt-1 open-sans-reg">

                    <div class="col">
                        <p class="fs-smaller fs-md">{{$service->job_title}}</p>
                    </div>

                    <div class="col">
                        <p class="fs-smaller fs-md">₱{{$service->job_fee}} {{$service->fee_type}}</p>
                    </div>

                    <div class="col">
                        @if ($service->isAvailable === true)
                        <p class="text-success fs-smaller fs-md">Available</p>
                        @else
                        <p class="text-danger fs-smaller fs-md">Not Available</p>
                        @endif
                    </div>
                </div>
                @endforeach

                <!--Terms of Service-->
                <p class="mt-3 fs-sm fs-md poppins-medium">Terms of Service</p>
                <div class="container terms-container rounded">
                    @if($user->freelancer->terms_and_conditions != null)
                    <p class="text-start fs-smaller fs-md mt-2 ">
                        {{$user->freelancer->terms_and_conditions}}
                    </p>
                    @else
                    <p class="text-start fs-smaller fs-md mt-2">
                        The freelancer agrees to perform the services as outlined in the project brief or as otherwise agreed upon with the client.
                        The freelancer will deliver the services with reasonable skill, care, and diligence.
                    </p>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!--Client Review -->
    <section id="client-reviews">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">Client Reviews</h2>
                <p class="mb-0 fs-smaller">(10 reviews)</p>
            </div>
            <a class="fs-sm fs-md poppins-light txt-review" href="#">See All Reviews</a>
        </div>

        <p class="text-center fs-smaller fs-md mt-2">Recent Projects</p>



        <!-- Reviews -->
        <div class="container">
            <div class="row d-flex align-items-center justify-content-between">
                <!-- Review Item 1 -->
                <div class="col-12 col-md-5 flex-grow-1 mb-4 rvw-container rounded">
                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <div>
                            <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">18th Birthday Celebration</h2>
                        </div>
                        <a class="fs-sm fs-md poppins-light txt-review" href="#">See Post</a>
                    </div>
                    <p class="fs-sm fs-md poppins-light mt-0">June 27 2024</p>
                    <div class="d-flex">
                        <div class="text-center me-3">
                            <!-- Profile Picture -->
                            <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                        </div>
                        <div>
                            <!-- Review Content -->
                            <h5 class="font-weight-bold">John Doe</h5>
                            <div class="mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-half text-warning"></i>
                            </div>
                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                        </div>
                    </div>
                </div>

                <div class="col-1"></div>
                <!-- Review Item 2 -->
                <div class="col-12 col-md-5 flex-grow-1 mb-4 rvw-container rounded">
                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <div>
                            <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">18th Birthday Celebration</h2>
                        </div>
                        <a class="fs-sm fs-md poppins-light txt-review" href="#">See Post</a>
                    </div>
                    <p class="fs-sm fs-md poppins-light">June 27 2024</p>
                    <div class="d-flex">
                        <div class="text-center me-3">
                            <!-- Profile Picture -->
                            <img src="{{ asset('assets/daisy.svg') }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                        </div>
                        <div>
                            <!-- Review Content -->
                            <h5 class="font-weight-bold">John Doe</h5>
                            <div class="mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-half text-warning"></i>
                            </div>
                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis auctor elit ut purus consectetur, sed tincidunt sapien luctus."</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!--Portfolio -->
    <section id="portfolio-freelancer">
        <div class="row">
        <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">PORTFOLIO</h2>
        </div>
        <div class="container mt-2 mb-4">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="portfolioTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="videos-tab" data-bs-toggle="tab" href="#videos" role="tab" aria-controls="videos" aria-selected="true">Videos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="images-tab" data-bs-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Images</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="portfolioTabsContent">
            <div class="tab-pane fade show active" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                <!-- Videos content -->
                <div class="row mt-3">
                    <div class="col-md-4 mb-5 mb-md-3">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
                        </div>
                    </div>
                    <!-- Add more video items -->
                </div>
            </div>
            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                <!-- Images content here -->
                <div class="row mt-3">
                    <div class="col-md-4 mb-5 mb-md-3">
                        <img src="https://via.placeholder.com/300" class="img-fluid" alt="Image 1">
                    </div>
                    <!-- Add more image items -->
                </div>
            </div>
        </div>
    </div>
    </section>

    
</div>




@endsection