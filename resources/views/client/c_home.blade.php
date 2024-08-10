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
            <div class="col mb-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/solo.svg" class="inside-icon me-1">
                    <h3 class="poppins-regular fs-3 mb-0">Solo Freelancers</h3>
                </div>
                <p class="poppins-light fs-5 mb-0 btn-link view-all">View All</p>
            </div>


            <!-- Services -->
            <div class="card" style="width: 18rem;">
              <h5 class="card-title">Card title</h5>  
              <img src="/assets/cover.svg" class="card-img-top" alt="image daw">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection('content')