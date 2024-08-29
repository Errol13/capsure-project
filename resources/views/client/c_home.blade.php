@extends('layouts.app')

@section('content')
<div class="container mb-4 pb-4">
    <div class="row justify-content-center pb-2">

        <!-- Search Engine and Event Post Button -->
        <div class="col-md-12 col-lg-12 col-sm-12 py-4">
            <div class="search-container rounded-4">
                <!-- search bar -->
                <div class="input-group search-bar mt-3 mb-3 position-relative">
                    <input type="text" class="form-control fw-lighter rounded-5 py-1 md-2" placeholder="What service do you need?">
                    <span class="input-group-text border-0 bg-transparent position-absolute end-0 mx-2 d-flex align-items-center">
                        <i class="fas fa-search m-2 fs-5"></i>
                        <i class="fas fa-filter m-2 fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                    </span>
                </div>

                <!-- PopUp Filter Options -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog d-flex modal-sm-lg position-center py-4 my-4 px-2">
                        <div class="modal-content rounded-4">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 poppins-medium" id="exampleModalLabel">Filter Options</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="col mb-3 text-start ms-4">
                                        <h5 class="poppins-regular">Job Category</h5>
                                        <div class="row">
                                            <div class="col">
                                                <label><input type="radio" name="category" value="any"> Any Category</label><br>
                                                <label><input type="radio" name="category" value="art"> Art</label><br>
                                                <label><input type="radio" name="category" value="entertainment"> Entertainment</label><br>
                                                <label><input type="radio" name="category" value="photography"> Photography</label><br>
                                                <label><input type="radio" name="category" value="voice"> Voice Talent</label><br>
                                                <label><input type="radio" name="category" value="stylist"> Stylist</label><br>
                                            </div>
                                            <div class="col">
                                                <label><input type="radio" name="category" value="food"> Food Service</label><br>
                                                <label><input type="radio" name="category" value="event"> Event Planner</label><br>
                                                <label><input type="radio" name="category" value="online"> Online Services</label><br>
                                                <label><input type="radio" name="category" value="videography"> Videography</label><br>
                                                <label><input type="radio" name="category" value="handicrafts"> Handicrafts</label><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-start ms-3">
                                        <div class="col mb-3">
                                            <h5 class="poppins-regular">Job Fee Type</h5>
                                            <label><input type="radio" name="fee-type" value="any-fee"> Any</label><br>
                                            <label><input type="radio" name="fee-type" value="hour"> per hour</label><br>
                                            <label><input type="radio" name="fee-type" value="project"> per project</label><br>
                                        </div>
                                        <div class="col mb-3">
                                            <h5 class="poppins-regular">Freelancer Type</h5>
                                            <label><input type="radio" name="type" value="solo"> Solo</label><br>
                                            <label><input type="radio" name="type" value="team"> Team</label><br>
                                        </div>
                                    </div>
                                    <div class="row text-start ms-3">
                                        <div class="col mb-3">
                                            <h5 class="poppins-regular">Job Fee Range</h5>
                                            <label><input type="radio" name="fee-range" value="any-range"> Any</label><br>
                                            <label><input type="radio" name="fee-range" value="100"> ₱100 and below</label><br>
                                            <label><input type="radio" name="fee-range" value="500"> ₱100 - ₱500</label><br>
                                            <label><input type="radio" name="fee-range" value="1000"> ₱500 - ₱1000</label><br>
                                            <label><input type="radio" name="fee-range" value="above"> ₱1000 and above</label><br>
                                        </div>
                                        <div class="col mb-3">
                                            <h5 class="poppins-regular">Rating</h5>
                                            <label><input type="radio" name="rating" value="any-rate"> Any</label><br>
                                            <label><input type="radio" name="rating" value="1"> 1-2 stars</label><br>
                                            <label><input type="radio" name="rating" value="2"> 2-3 stars</label><br>
                                            <label><input type="radio" name="rating" value="4"> 3-4 stars</label><br>
                                            <label><input type="radio" name="rating" value="5"> 4-5 stars</label><br>
                                        </div>
                                    </div>
                                    <div class="col mb-3 text-start ms-4">
                                        <h5 class="poppins-regular">Location</h5>
                                        <label><input type="text" class="location" style="border-radius: 12px; border-color:gray;" placeholder=" Put the location here"></label><br>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer d-flex justify-content-left">
                                <button type="button" class="btn btn-primary open-sans-reg" style="background-color: #91216C; color:white; border: none; border-radius: 12px;">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- create an event -->
                <a class="create-event-btn shadow-btn mb-3 rounded-pill open-sans-reg " href="{{ url('/events') }}" style="text-decoration: none;">
                    Create an Event <i class="fas fa-party-horn"></i>
                    <img src="assets/event.svg" class="inside-icon me-1">
                </a>
            </div>
        </div>

        <div class="row mx-4 pt-3">
            <h3 class="poppins-medium fs-1 text-right">Services For You</h3>
        </div>

        <!-- Solo Freelancers Services -------------------------------------------------------------------------------------------->
        <div class="row">
            <div class="col-align mb-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/solo.svg" class="inside-icon me-1">
                    <h3 class="poppins-regular fs-3 mb-0">Solo Freelancers</h3>
                </div>
                <a href="#" class="poppins-light fs-5 mb-0 text-purple right-side">View All</a>
            </div>


            <!-- Carousel for Mobile View -->
            <div id="cardCarousel" class="carousel slide d-block d-md-none mb-4 pb-1" data-bs-ride="carousel">
                <div class="carousel-inner justify-content-center pb-4">
                    @foreach ($users as $user)
                    @if ($user->freelancer)
                    @php
                    $service = $user->freelancer->services->first();
                    $portfolio = $user->freelancer->portfolios->first();
                    @endphp
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }} py-2">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border: none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                            <div class="col-align px-2 mt-1">
                                <h5 class="card-title poppins-medium mt-1">{{ $service->job_title }}</h5>
                                <h5 class="poppins-medium fs-5 mb-0 right-side">{{ $service->fee }}</h5>
                            </div>

                            @if ($portfolio)
                            @php
                            $paths = json_decode($portfolio->path, true);
                            $firstImage = $paths[0];
                            @endphp
                            <img src="{{ $firstImage }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                            @else
                            <img src="{{ asset('assets/cover.svg') }}" class="card-img-top profile-container rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                            @endif

                            <div class="card-body open-sans-reg p-2">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $user->profile_image }}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                    <div class="ms-3">
                                        <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">{{ $user->first_name }} {{ $user->last_name }}</p>
                                        <p class="card-text open-sans-light small mb-0">{{ $user->city }}</p>
                                        @if ($user->freelancer->number_of_projects > 0)
                                        <p class="card-text open-sans-light small text-success mb-0">{{ $user->freelancer->number_of_projects }} done</p>
                                        @else
                                        <p class="card-text open-sans-light small text-success mb-0">No projects yet</p>
                                        @endif
                                    </div>
                                    <div class="ms-auto d-flex align-items-center">
                                        @if ($user->avg_rating > 0)
                                        <span class="text-warning me-1">★</span>
                                        <span class="fw-bold">{{ $user->freelancer->avg_rating }}</span>
                                        <span class="text-muted small ms-1">(10)</span>
                                        @else
                                        <span class="text-muted me-1 fs-smaller">No ratings yet</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pb-2">
                                    <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                    <img src="{{ asset('assets/bookmark.svg') }}" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>



            <!-- Grid Layout for Larger Screens -->
            <div class="card-grid d-none d-md-flex flex-wrap justify-content-center">
                @foreach ($users as $user)
                @if($user->freelancer)

                @php
                $service = $user->freelancer->services->first();
                $portfolio =$user->freelancer->portfolios->first();
                @endphp

                <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                    <div class="col-align px-2 mt-1">
                        <!-- Display Freelancer Title and Rate -->
                        <h5 class="card-title poppins-medium mt-1">{{ $service->job_title }}</h5>
                        <h5 class="poppins-medium fs-5 mb-0 right-side">{{ $service->fee}}</h5>
                    </div>

                    <!-- Display Freelancer Cover Image -->
                    @if($portfolio)
                    <!--display the first image in their first album -->
                    @php
                    $paths = json_decode($portfolio->path, true);
                    $firstImage = $paths[0];
                    @endphp
                    <img src="{{ $firstImage }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                    @else
                    <img src="{{ asset('assets/cover.svg') }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                    @endif

                    <div class="card-body open-sans-reg p-3">
                        <div class="d-flex align-items-center mb-2">
                            <!-- Display Freelancer Profile Image -->
                            <img src="{{ $user->profile_image }}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                            <div class="ms-3">
                                <!-- Display Freelancer Name, Location, and Projects -->
                                <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="card-text open-sans-light small mb-0">{{ $user->city }}</p>

                                <!-- if no projects yet -->
                                @if($user->freelancer->number_of_projects > 0)
                                <p class="card-text open-sans-light small text-success mb-0">{{ $user->freelancer->number_of_projects }} done</p>
                                @else
                                <p class="card-text open-sans-light small text-success mb-0">No projects yet</p>
                                @endif
                            </div>
                            <div class="ms-auto d-flex align-items-center">
                                @if($user->avg_rating > 0)
                                <span class="text-warning me-1">★</span>
                                <!-- Display Freelancer Rating and Reviews -->
                                <span class="fw-bold">{{ $user->freelancer->avg_rating }}</span>
                                <span class="text-muted small ms-1">(10)</span>
                                @else
                                <span class="text-muted me-1 fs-smaller ">No ratings yet</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- See Profile Button -->
                            <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                            <!-- Bookmark Icon -->
                            <img src="{{ asset('assets/bookmark.svg') }}" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>


        </div>

        <hr class="custom-hr py-4 my-4">

        <!-- Team Freelancers Services -------------------------------------------------------------------------------------->
        <div class="row py-3">
            <div class="col-align mb-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/team.svg" class="inside-icon me-1" style="width: 40px; height: 40px">
                    <h3 class="poppins-regular fs-3 mb-0">Team Freelancers</h3>
                </div>
                <a class="poppins-light fs-5 mb-0 text-purple right-side" href="#">View All</a>
            </div>


            <!-- Carousel for Mobile View -->
            <div id="cardCarouselteam" class="carousel slide" data-bs-ride="carouselteam">
                <div class="carousel-inner justify-content-center">
                    <!-- Start of loop to generate cards -->
                    <div class="carousel-item active py-2">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                            <div class="card-body open-sans-reg p-3">
                                <!-- Package Details Section -->
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title poppins-medium mb-0">Party Package</h5>
                                    <h5 class="poppins-medium fs-5 mb-0">₱50,000</h5>
                                </div>
                                <ul class="list-unstyled mb-3 px-3 py-3" style="background-color: #F6F2F2; max-height: 200opx;">
                                    <li>Photographer</li>
                                    <li>Make-up Artist</li>
                                    <li>2 Hosts</li>
                                </ul>
                                <div class="d-flex align-items-center">
                                    <img src="/assets/profilepic.svg" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                    <div class="ms-3 d-flex justify-content-between w-100 align-items-center">
                                        <div>
                                            <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1.2;">Party Needs</p>
                                            <p class="card-text open-sans-light small mb-0" style="line-height: 1.2;">Naga City</p>
                                            <p class="card-text open-sans-light small text-success mb-0" style="line-height: 1.4;">10 Projects done</p>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="text-warning me-1">★</span>
                                            <span class="fw-bold">4.9</span>
                                            <span class="text-muted small ms-1">(10)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="#" class="see-prof-btn btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                    <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat for additional cards -->
                    <div class="carousel-item active py-2">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                            <div class="card-body open-sans-reg p-3">
                                <!-- Package Details Section -->
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title poppins-medium mb-0">Party Package</h5>
                                    <h5 class="poppins-medium fs-5 mb-0">₱50,000</h5>
                                </div>
                                <ul class="list-unstyled mb-3 px-3 py-3" style="background-color: #F6F2F2;">
                                    <li>Photographer</li>
                                    <li>Make-up Artist</li>
                                    <li>2 Hosts</li>
                                </ul>
                                <div class="d-flex align-items-center">
                                    <img src="/assets/profilepic.svg" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                    <div class="ms-3 d-flex justify-content-between w-100 align-items-center">
                                        <div>
                                            <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1.2;">Party Needs</p>
                                            <p class="card-text open-sans-light small mb-0" style="line-height: 1.2;">Naga City</p>
                                            <p class="card-text open-sans-light small text-success mb-0" style="line-height: 1.4;">10 Projects done</p>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="text-warning me-1">★</span>
                                            <span class="fw-bold">4.9</span>
                                            <span class="text-muted small ms-1">(10)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="#" class="see-prof-btn btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                    <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#cardCarouselteam" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#cardCarouselteam" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Grid Layout for Larger Screens -->
            <?php
            // Sample card data
            $cards = [
                [
                    'title' => 'Party Package',
                    'price' => '₱50,000',
                    'services' => ['Photographer', 'Make-up Artist', '2 Hosts'],
                    'profilePic' => '/assets/profilepic.svg',
                    'name' => 'Party Needs',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/bookmark.svg'
                ],
                // Add more card arrays as needed
                [
                    'title' => 'Party Package',
                    'price' => '₱50,000',
                    'services' => ['Photographer', 'Make-up Artist', '2 Hosts'],
                    'profilePic' => '/assets/profilepic.svg',
                    'name' => 'Party Needs',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/bookmark.svg'
                ],

                [
                    'title' => 'Party Package',
                    'price' => '₱50,000',
                    'services' => ['Photographer', 'Make-up Artist', '2 Hosts'],
                    'profilePic' => '/assets/profilepic.svg',
                    'name' => 'Party Needs',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/bookmark.svg'
                ],

                [
                    'title' => 'Party Package',
                    'price' => '₱50,000',
                    'services' => ['Photographer', 'Make-up Artist', '2 Hosts'],
                    'profilePic' => '/assets/profilepic.svg',
                    'name' => 'Party Needs',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/bookmark.svg'
                ],
            ];

            ?>

            <!-- Grid Layout for Larger Screens -->
            <div class="card-grid d-none d-md-flex flex-wrap justify-content-center">
                <?php foreach ($cards as $card): ?>
                    <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                        <div class="card-body open-sans-reg p-3">
                            <!-- Package Details Section -->
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title poppins-medium mb-0"><?php echo htmlspecialchars($card['title']); ?></h5>
                                <h5 class="poppins-medium fs-5 mb-0"><?php echo htmlspecialchars($card['price']); ?></h5>
                            </div>
                            <ul class="list-unstyled mb-3 px-3 py-3" style="background-color: #F6F2F2;">
                                <?php foreach ($card['services'] as $service): ?>
                                    <li><?php echo htmlspecialchars($service); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo htmlspecialchars($card['profilePic']); ?>" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                <div class="ms-3 d-flex justify-content-between w-100 align-items-center">
                                    <div>
                                        <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1.2;"><?php echo htmlspecialchars($card['name']); ?></p>
                                        <p class="card-text open-sans-light small mb-0" style="line-height: 1.2;"><?php echo htmlspecialchars($card['location']); ?></p>
                                        <p class="card-text open-sans-light small text-success mb-0" style="line-height: 1.4;"><?php echo htmlspecialchars($card['projects']); ?></p>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <span class="text-warning me-1">★</span>
                                        <span class="fw-bold"><?php echo htmlspecialchars($card['rating']); ?></span>
                                        <span class="text-muted small ms-1"><?php echo htmlspecialchars($card['reviews']); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="#" class="see-prof-btn btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                <img src="<?php echo htmlspecialchars($card['bookmark']); ?>" alt="Bookmark" class="bookmark-icon">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
@endsection('content')