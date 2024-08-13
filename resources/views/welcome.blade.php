@extends('layouts.app')

@section('content')

<!--Data for Services -->
@php
$cards = [
['image' => 'assets/handicrafts.svg', 'text' => 'Handicrafts'],
['image' => 'assets/food.svg', 'text' => 'Food Services'],
['image' => 'assets/online_services.svg', 'text' => 'Online Services'],
['image' => 'assets/event_planner.svg', 'text' => 'Event Planner'],
['image' => 'assets/styling.svg', 'text' => 'Styling'],
['image' => 'assets/videography.svg', 'text' => 'Videography'],
['image' => 'assets/arts.svg', 'text' => 'Arts'],
['image' => 'assets/voice.svg', 'text' => 'Voice Talent'],
['image' => 'assets/photography.svg', 'text' => 'Photography'],
['image' => 'assets/entertainment.svg', 'text' => 'Entertainment'],
];

@endphp
<!-- Contents -->
<div class="flex items-center justify-center">
    <section class="hero text-center rounded-3 mt-2 mt-md-4 mt-lg-4 col-md-12 col-lg-12 col-sm-12 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="row px-0 my-1 fs-3 justify-content-center">
                        <h1 class="m-0">
                            <span class="text-black sedan-regular-italic size-bigger">Capture</span>
                            <span class="sedan-regular size-bigger"> the Moments </span>
                            <span class="sedan-regular-italic size-bigger">Surely</span>
                        </h1>
                    </div>
                    <div class="input-group my-md-4 pb-2">
                        <input type="text" class="form-control fw-lighter poppins-light fw-medium" placeholder="What service do you need?">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search m-1 fs-3"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="service-categories">

            <!--Mobile View -->

            <div id="mobileCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                    $chunks = array_chunk($cards, 2);
                    @endphp

                    @foreach($chunks as $index => $chunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $card)
                            <div class="col-6">
                                <div class="card custom-mob-card">
                                    <img src="{{ $card['image'] }}" class="img-mob" alt="{{ $card['text'] }}">
                                    <div class="card-body">
                                        <p class="card-text">{{ $card['text'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mobileCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mobileCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>



            <!--For Bigger screens -->
            <div class="d-none d-md-flex d-lg-flex flex-wrap justify-content-between poppins-regular">
                @foreach ($cards as $card)
                <div class="card custom-card mb-2">
                    <img src="{{ asset($card['image']) }}" class="service-pic-size" alt="{{ $card['text'] }}">
                    <div class="card-body">
                        <p class="card-text mt-0">{{ $card['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="freelancers">
            <div class="row">
            <h2>Hire Competitive Freelancers</h2>
            </div>
            
            <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <img src="{{ asset('assets/daisy.svg') }}" class="card-img-top" alt="Freelancer">
                        <div class="card-body">
                            <p class="card-text">Daisy</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            
        </section>

        <section class="jobs">
            <h2>Find a Job</h2>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">Job Description</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

        <footer class="footer text-center">
            <p>&copy; 2024, CapSure</p>
        </footer>
</div>

</div>

@endsection