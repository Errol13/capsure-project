@extends('layouts.app')

@section('content')

<!-- Contents -->
<div class="flex items-center justify-center h-full">
    <!--Hero Section -->
    <section class="hero text-center rounded-3 mt-4 col-md-12 col-lg-12 col-sm-12 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <h1 class="px-4 sm-mgn-rmv">Capture the Moments Surely</h1>
                    <div class="input-group my-4">
                        <input type="text" class="form-control fw-lighter" placeholder="What service do you need?">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search m-1 fs-3"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="container">
            <div class="row text-center mt-4">
                <div class="col-3 col-md-3 col-sm-3"> 
                    <div class="service">
                        <img src="{{ asset('assets/handicrafts.svg') }}" class="img-fluid" alt="Handicrafts"> <!-- img-fluid ensures image is responsive -->
                        <div class="service-body">
                            <p class="service-text">Handicrafts</p>
                        </div>
                    </div>
                </div>
                <!--Other services-->
            </div>
        </div>


    </section>

</div>

@endsection