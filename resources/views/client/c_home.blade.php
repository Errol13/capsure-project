@extends('layouts.app')

@section('content')
<div class="container mb-4 pb-4">
    <div class="row justify-content-center pb-2">

        <!-- Search Filter and Create Event Button -->
        <livewire:client.search-filter />

        <div class="row mx-4 pt-3">
            <h3 class="poppins-medium text-center">Services For You</h3>
        </div>

        <!-- Solo Freelancers Services -->
        <div class="row">
            <div class="col-align mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/solo.svg" class="inside-icon me-1">
                    <h4 class="poppins-regular mb-0">Freelancers</h4>
                </div>
            </div>

            <livewire:client-home />

            <!-- Team Freelancers Services -->
            <div class="row py-3">
                <div class="col-align mb-2 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="assets/team.svg" class="inside-icon me-1" style="width: 40px; height: 40px">
                        <h4 class="poppins-regular mb-0">Team Freelancers</h4>
                    </div>
                    <a class="poppins-light fs-5 mb-0 text-purple right-side" href="#">View All</a>
                </div>

                <?php
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
                    // Add more card data here if needed
                ];
                ?>

                <!-- Responsive Grid Layout -->
                <div class="row g-3 justify-content-center">
                    <?php foreach ($cards as $card): ?>
                        <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                            <div class="card shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                                <div class="card-body open-sans-reg p-3">

                                    <!-- Package Details Section -->
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="card-title poppins-medium mb-0"><?php echo htmlspecialchars($card['title']); ?></h5>
                                        <h5 class="poppins-medium fs-5 mb-0"><?php echo htmlspecialchars($card['price']); ?></h5>
                                    </div>
                                    <ul class="list-unstyled text-center mb-3 px-3 py-3" style="background-color: #F6F2F2; width: 100%; height: 150px; object-fit: cover;">
                                        <?php foreach ($card['services'] as $service): ?>
                                            <li><?php echo htmlspecialchars($service); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo htmlspecialchars($card['profilePic']); ?>" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                        <div class="ms-3">
                                            <p class="card-text open-sans-reg fw-bold mb-0"><?php echo htmlspecialchars($card['name']); ?></p>
                                            <p class="card-text open-sans-light small mb-0"><?php echo htmlspecialchars($card['location']); ?></p>
                                            <p class="card-text open-sans-light small text-success mb-0"><?php echo htmlspecialchars($card['projects']); ?></p>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="text-warning me-1">★</span>
                                            <span class="fw-bold"><?php echo htmlspecialchars($card['rating']); ?></span>
                                            <span class="text-muted small ms-1"><?php echo htmlspecialchars($card['reviews']); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="#" class="btn btn-seeprof rounded-pill w-100" style="border-color: #91216C; color:#91216C;">See Profile</a>
                                        <img src="<?php echo htmlspecialchars($card['bookmark']); ?>" alt="Bookmark" class="bookmark-icon ms-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
