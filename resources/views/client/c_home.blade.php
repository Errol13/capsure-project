@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <!-- Search Engine and Event Post Button -->
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="search-container rounded-4">
                <!-- search bar -->
                <div class="input-group mt-3 mb-1">
                    <input type="text" class="form-control fw-lighter rounded-5" placeholder="What service do you need?">
                    <span class="input-group-text border-0 bg-transparent position-absolute end-0">
                        <i class="fas fa-search m-1 fs-5"></i>
                        <i class="fas fa-filter m-3 fs-5"></i>
                    </span>
                </div>
                <!-- create an event -->
                <button class="create-event-btn shadow-btn mb-3 rounded-pill open-sans-reg ">
                    Create an Event <i class="fas fa-party-horn"></i>
                    <img src="assets/event.svg" class="inside-icon me-1">
                </button>
            </div>
        </div>

        <div class="row mx-4 py-4">
            <h3 class="poppins-medium fs-1 text-center">Services For You</h3>
        </div>

        <!-- Solo Freelancers Services -->
        <div class="row">
            <div class="col-align mb-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/solo.svg" class="inside-icon me-1">
                    <h3 class="poppins-regular fs-3 mb-0">Solo Freelancers</h3>
                </div>
                <p class="poppins-light fs-5 mb-0 btn-link right-side">View All</p>
            </div>


            <!-- Carousel Services -->
            <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner justify-content-center">
                    <!-- Start of loop to generate cards -->
                    <div class="carousel-item active">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px;">
                            <div class="col-align px-2 mt-1">
                                <h5 class="card-title poppins-medium mt-1">Photographer</h5>
                                <h5 class="poppins-medium fs-5 mb-0 right-side">₱500/hr</h5>
                            </div>
                            <img src="/assets/cover.svg" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                            <div class="card-body open-sans-reg p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="/assets/profilepic.svg" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                    <div class="ms-3">
                                        <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">Daisy Maureen Dimasuay</p>
                                        <p class="card-text open-sans-light small mb-0">Naga City</p>
                                        <p class="card-text open-sans-light small text-success mb-0">10 Projects done</p>
                                    </div>
                                    <div class="ms-auto d-flex align-items-center">
                                        <span class="text-warning me-1">★</span>
                                        <span class="fw-bold">4.9</span>
                                        <span class="text-muted small ms-1">(10)</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                    <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat for additional cards -->
                    <div class="carousel-item active">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px;">
                            <div class="col-align px-2 mt-1">
                                <h5 class="card-title poppins-medium mt-1">Photographer</h5>
                                <h5 class="poppins-medium fs-5 mb-0 right-side">₱500/hr</h5>
                            </div>
                            <img src="/assets/cover.svg" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                            <div class="card-body open-sans-reg p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="/assets/profilepic.svg" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                    <div class="ms-3">
                                        <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">Daisy Maureen Dimasuay</p>
                                        <p class="card-text open-sans-light small mb-0">Naga City</p>
                                        <p class="card-text open-sans-light small text-success mb-0">10 Projects done</p>
                                    </div>
                                    <div class="ms-auto d-flex align-items-center">
                                        <span class="text-warning me-1">★</span>
                                        <span class="fw-bold">4.9</span>
                                        <span class="text-muted small ms-1">(10)</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                                    <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                                </div>
                            </div>
                        </div>
                    </div>
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
        </div>

        <hr class="custom-hr py-4">

        <!-- Team Freelancers Services -->
        <div class="row py-3">
            <div class="col-align mb-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/team.svg" class="inside-icon me-1" style="width: 40px; height: 40px">
                    <h3 class="poppins-regular fs-3 mb-0">Team Freelancers</h3>
                </div>
                <p class="poppins-light fs-5 mb-0 btn-link right-side">View All</p>
            </div>


            <!-- Services -->
            <div id="cardCarouselteam" class="carousel slide" data-bs-ride="carouselteam">
                <div class="carousel-inner justify-content-center">
                    <!-- Start of loop to generate cards -->
                    <div class="carousel-item active">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px;">
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

                    <!-- Repeat for additional cards -->
                    <div class="carousel-item active">
                        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px;">
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
        </div>
    </div>


    @endsection('content')