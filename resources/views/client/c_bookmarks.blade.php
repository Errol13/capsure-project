@extends('layouts.app')

@section('content')
<div class="container mb-4 pb-4">
    <div class="row justify-content-center mb-4">

        <!-- Saved to Bookmarkpage -->


        
        <!-- Grid Layout for Larger Screens -->
        <?php
            // Sample card data
            $cards = [
                [
                    'title' => 'Photographer',
                    'rate' => '₱500/hr',
                    'profile' => '/assets/profilepic.svg',
                    'cover' => '/assets/cover.svg',
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/saved.svg'
                ],
                // Add more card arrays as needed
                [
                    'title' => 'Photographer',
                    'rate' => '₱500/hr',
                    'profile' => '/assets/profilepic.svg',
                    'cover' => '/assets/cover.svg',
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/saved.svg'
                ],

                [
                    'title' => 'Photographer',
                    'rate' => '₱500/hr',
                    'profile' => '/assets/profilepic.svg',
                    'cover' => '/assets/cover.svg',
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/saved.svg'
                ],

                [
                    'title' => 'Photographer',
                    'rate' => '₱500/hr',
                    'profile' => '/assets/profilepic.svg',
                    'cover' => '/assets/cover.svg',
                    'name' => 'Daisy Maureen Dimasuay',
                    'location' => 'Naga City',
                    'projects' => '10 Projects done',
                    'rating' => '4.9',
                    'reviews' => '(10)',
                    'bookmark' => 'assets/saved.svg'
                ],
            ];

            ?>

            <!-- Grid Layout for Larger Screens -->
            <div class="card-grid d-md-flex row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($cards as $card): ?>
                    <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                        <div class="col-align px-2 mt-1">
                            <h5 class="card-title poppins-medium mt-1"><?php echo htmlspecialchars($card['title']); ?></h5>
                            <h5 class="poppins-medium fs-5 mb-0 right-side"><?php echo htmlspecialchars($card['rate']); ?></h5>
                        </div>
                        <img src="<?php echo htmlspecialchars($card['cover']); ?>" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                        <div class="card-body open-sans-reg p-3">
                            <div class="d-flex align-items-center mb-2">
                                <img src="<?php echo htmlspecialchars($card['profile']); ?>" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                <div class="ms-3">
                                    <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;"><?php echo htmlspecialchars($card['name']); ?></p>
                                    <p class="card-text open-sans-light small mb-0"><?php echo htmlspecialchars($card['location']); ?></p>
                                    <p class="card-text open-sans-light small text-success mb-0"><?php echo htmlspecialchars($card['projects']); ?></p>
                                </div>
                                <div class="ms-auto d-flex align-items-center">
                                    <span class="text-warning me-1">★</span>
                                    <span class="fw-bold"><?php echo htmlspecialchars($card['rating']); ?></span>
                                    <span class="text-muted small ms-1"><?php echo htmlspecialchars($card['reviews']); ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                <img src="<?php echo htmlspecialchars($card['bookmark']); ?>" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
    </div>
</div>
@endsection