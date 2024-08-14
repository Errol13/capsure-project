@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">

        <!-- Search Engine Button -->
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="search-container rounded-4 px-3 ">
                <!-- search bar -->
                <div class="input-group mt-3 mb-1">
                    <input type="text" class="form-control fw-lighter rounded-5 py-1 py-md-2" placeholder="Find a Job or Event">
                    <span class="input-group-text border-0 bg-transparent position-absolute end-0">
                        <i class="fas fa-search m-1 fs-5"></i>
                        <i class="fas fa-filter m-3 fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="row mx-0 mt-4">
            <h3 class="poppins-medium fs-3 text-start">Jobs For You</h3>
        </div>
        <!-- Events -->
        <div class="container mt-2 poppins-regular ">
            <div class="row">
                <!-- Job Item 1 -->
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title poppins-medium">18th Birthday Celebration</h5>
                            <p class="card-text text-muted">45 min. ago</p>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="d-flex flex-wrap">
                                <span class="badge bg-secondary me-2 mb-2">Photographer</span>
                                <span class="badge bg-secondary me-2 mb-2">Make-up Artist</span>
                                <span class="badge bg-secondary me-2 mb-2">Hair Stylist</span>
                                <span class="badge bg-secondary me-2 mb-2">Cake Baker</span>
                            </div>
                            <hr class="mt-2 border-1 opacity-25"></hr>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Profile" class="rounded-circle me-2" width="50">
                                <div>
                                    <h6 class="mb-0 poppins-medium">Daisy Maureen Dimasuay</h6>
                                    <small class="text-muted">Naga City</small>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-success">4.9 <i class="bi bi-star-fill"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <a href="#" class="text-center btn-seemore rounded-3 me-2 flex-grow-1 poppins-light fs-6">See More</a>
                                <a href="#" class=" rounded-3 btn-seeprof me-2 px-2 poppins-light fs-6">See Profile</a>
                                <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Job Item 2 -->
                 <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title poppins-medium">18th Birthday Celebration</h5>
                            <p class="card-text text-muted">45 min. ago</p>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="d-flex flex-wrap">
                                <span class="badge bg-secondary me-2 mb-2">Photographer</span>
                                <span class="badge bg-secondary me-2 mb-2">Make-up Artist</span>
                                <span class="badge bg-secondary me-2 mb-2">Hair Stylist</span>
                                <span class="badge bg-secondary me-2 mb-2">Cake Baker</span>
                            </div>
                            <hr class="mt-2 border-1 opacity-25"></hr>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Profile" class="rounded-circle me-2" width="50">
                                <div>
                                    <h6 class="mb-0 poppins-medium">Daisy Maureen Dimasuay</h6>
                                    <small class="text-muted">Naga City</small>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-success">4.9 <i class="bi bi-star-fill"></i></span>
                                </div>
                            </div>
                           
                            <div class="d-flex align-items-center mt-3">
                                <a href="#" class="text-center btn-seemore rounded-3 me-2 flex-grow-1 poppins-light fs-6">See More</a>
                                <a href="#" class=" rounded-3 btn-seeprof me-2 px-2 poppins-light fs-6">See Profile</a>
                                <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Job Item 3 -->
                 <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title poppins-medium">18th Birthday Celebration</h5>
                            <p class="card-text text-muted">45 min. ago</p>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="d-flex flex-wrap">
                                <span class="badge bg-secondary me-2 mb-2">Photographer</span>
                                <span class="badge bg-secondary me-2 mb-2">Make-up Artist</span>
                                <span class="badge bg-secondary me-2 mb-2">Hair Stylist</span>
                                <span class="badge bg-secondary me-2 mb-2">Cake Baker</span>
                            </div>
                            <hr class="mt-2 border-1  opacity-25"></hr>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Profile" class="rounded-circle me-2" width="50">
                                <div>
                                    <h6 class="mb-0 poppins-medium">Daisy Maureen Dimasuay</h6>
                                    <small class="text-muted">Naga City</small>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-success">4.9 <i class="bi bi-star-fill"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <a href="#" class="text-center btn-seemore rounded-3 me-2 flex-grow-1 poppins-light fs-6">See More</a>
                                <a href="#" class=" rounded-3 btn-seeprof me-2 px-2 poppins-light fs-6">See Profile</a>
                                <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Job Item 4 -->
                 <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title poppins-medium">18th Birthday Celebration</h5>
                            <p class="card-text text-muted">45 min. ago</p>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="d-flex flex-wrap">
                                <span class="badge bg-secondary me-2 mb-2">Photographer</span>
                                <span class="badge bg-secondary me-2 mb-2">Make-up Artist</span>
                                <span class="badge bg-secondary me-2 mb-2">Hair Stylist</span>
                                <span class="badge bg-secondary me-2 mb-2">Cake Baker</span>
                            </div>
                            <hr class="mt-2 border-1 opacity-25"></hr>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/daisy.svg') }}" alt="Profile" class="rounded-circle me-2" width="50">
                                <div>
                                    <h6 class="mb-0 poppins-medium">Daisy Maureen Dimasuay</h6>
                                    <small class="text-muted">Naga City</small>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-success">4.9 <i class="bi bi-star-fill"></i></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <a href="#" class="text-center btn-seemore rounded-3 me-2 flex-grow-1 poppins-light fs-6">See More</a>
                                <a href="#" class=" rounded-3 btn-seeprof me-2 px-2 poppins-light fs-6">See Profile</a>
                                <img src="assets/bookmark.svg" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-4 mb-5">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo; Prev</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">Next &raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


    </div>
</div>


@endsection('content')