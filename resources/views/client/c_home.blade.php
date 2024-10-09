@extends('layouts.app')

@section('content')
<div class="container mb-4 pb-4">
    <div class="row justify-content-center pb-2">

        <!--Search Filter and Create Event Button -->
        <livewire:client.search-filter />


        <div class="col-lg-3 col-md-4" style="border-right: 1px solid #ddd;">
            <h4 class="poppins-medium">Filter Options</h4>
            <!-- Filter Form -->
            <form>
                <!-- Job Category Filter -->
                <div class="col my-3 text-start">
                    <h5 class="poppins-regular" style="color: #91216C;">Job Category</h5>
                    <div class="row">
                        <div class="col">
                            <label><input type="radio" name="category" value="any" wire:model="category"> Any Category</label><br>
                            <label><input type="radio" name="category" value="Art" wire:model="category"> Art</label><br>
                            <label><input type="radio" name="category" value="Entertainment" wire:model="category"> Entertainment</label><br>
                            <label><input type="radio" name="category" value="Photography" wire:model="category"> Photography</label><br>
                            <label><input type="radio" name="category" value="Voice" wire:model="category"> Voice Talent</label><br>
                            <label><input type="radio" name="category" value="Stylist" wire:model="category"> Stylist</label><br>
                        </div>
                        <div class="col">
                            <label><input type="radio" name="category" value="Food" wire:model="category"> Food Service</label><br>
                            <label><input type="radio" name="category" value="Event" wire:model="category"> Event Planner</label><br>
                            <label><input type="radio" name="category" value="Online" wire:model="category"> Online Services</label><br>
                            <label><input type="radio" name="category" value="Videography" wire:model="category"> Videography</label><br>
                            <label><input type="radio" name="category" value="Handicrafts" wire:model="category"> Handicrafts</label><br>
                            <label><input type="radio" name="category" value="Package" wire:model="category"> Event Package</label><br>
                        </div>
                    </div>
                </div>

                <!-- Job Fee Type Filter -->
                <div class="row text-start">
                    <div class="col mb-3">
                        <h5 class="poppins-regular" style="color: #91216C;">Job Fee Type</h5>
                        <label><input type="radio" name="fee-type" value="any-fee" wire:model="feeType"> Any</label><br>
                        <label><input type="radio" name="fee-type" value="/hour" wire:model="feeType"> per hour</label><br>
                        <label><input type="radio" name="fee-type" value="/project" wire:model="feeType"> per project</label><br>
                    </div>
                    <div class="col mb-3">
                        <h5 class="poppins-regular" style="color: #91216C;">Freelancer Type</h5>
                        <label><input type="radio" name="type" value="solo" wire:model="freelancerType"> Solo</label><br>
                        <label><input type="radio" name="type" value="team" wire:model="freelancerType"> Team</label><br>
                    </div>
                </div>

                <!-- Job Fee Range Filter -->
                <div class="row text-start">
                    <div class="col mb-3">
                        <h5 class="poppins-regular" style="color: #91216C;">Job Fee Range</h5>
                        <label><input type="radio" name="fee-range" value="any-range" wire:model="feeRange"> Any</label><br>
                        <label><input type="radio" name="fee-range" value="100" wire:model="feeRange"> ₱100 and below</label><br>
                        <label><input type="radio" name="fee-range" value="500" wire:model="feeRange"> ₱100 - ₱500</label><br>
                        <label><input type="radio" name="fee-range" value="1000" wire:model="feeRange"> ₱500 - ₱1000</label><br>
                        <label><input type="radio" name="fee-range" value="above" wire:model="feeRange"> ₱1000 and above</label><br>
                    </div>
                    <div class="col mb-3">
                        <h5 class="poppins-regular" style="color: #91216C;">Rating</h5>
                        <label><input type="radio" name="rating" value="any-rate" wire:model="rating"> Any</label><br>
                        <label><input type="radio" name="rating" value="2" wire:model="rating"> 2 stars and below</label><br>
                        <label><input type="radio" name="rating" value="3" wire:model="rating"> 3 stars</label><br>
                        <label><input type="radio" name="rating" value="4" wire:model="rating"> 4 stars</label><br>
                        <label><input type="radio" name="rating" value="5" wire:model="rating"> 5 stars</label><br>
                    </div>
                </div>

                <!-- Location Filter -->
                <div class="col-md-12 mb-2 text-start">
                    <h5 class="poppins-regular" style="color: #91216C;">Location</h5>
                    <input type="text" class="form-control location" style="border-radius: 12px; border-color: gray;" placeholder="Put the location here" wire:model="location">
                </div>
            </form>
        </div>

        <div class="col-lg-9 col-md-8">
            <div class="row mx-4 pt-1">
                <h3 class="poppins-medium fs-2 text-center">Services For You</h3>
            </div>

            <!-- Solo Freelancers Services -------------------------------------------------------------------------------------------->
            <div class="row">
                <div class="col-align mb-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="assets/solo.svg" class="inside-icon me-1">
                        <h3 class="poppins-regular fs-4 mb-0">Freelancers</h3>
                    </div>
                </div>

                <livewire:client-home />

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
                                            <a href="#" class="btn btn-seeprof rounded-pill w-100 me-2" style="border-color: #91216C; color:#91216C;">>See Profile</a>
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
                                        <a href="#" class="btn btn-seeprof rounded-pill w-100 me-2" style="border-color: #91216C; color:#91216C;">See Profile</a>
                                        <img src="<?php echo htmlspecialchars($card['bookmark']); ?>" alt="Bookmark" class="bookmark-icon">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection('content')