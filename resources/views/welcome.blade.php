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
<div class="d-flex align-items-center justify-content-center">
    <section class="hero text-center rounded-3 mt-2 mt-md-4 mt-lg-4 col-md-12 col-lg-12 col-sm-12 ">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="row px-0 my-1 fs-3 d-flex justify-content-center">
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

            <div class="container-fluid">
                <div class="row">
                    <h2 class="poppins-medium text-uppercase letter-spacing">Hire Competitive Freelancers</h2>
                    <span class="text-wrap">Elevate your event with our exceptional freelancers!
                        From talented event planners and creative designers to dynamic performers, our professionals ensure every detail is perfect. Hire now and make your next event extraordinary!
                    </span>
                    <div id="freelancerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    @foreach($freelancers->slice(0,4) as $freelancer)
                                    <div class="col-md-3">
                                        <!--fetch the first service of the freelancer-->
                                        @php
                                        $firstService = $freelancer->services->where('isAvailable', true)->first();
                                        @endphp
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid">
                                            <h6 class="mb-0">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}} </h6>
                                            <span class="mt-0">{{ optional($firstService)->job_title ?? 'No service found with ID 1.' }}</span>

                                            <div class="d-flex align-items-center mt-1">
                                                @if($freelancer->avg_rating > 0)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=floor($freelancer->avg_rating))
                                                    <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                    @elseif ($i == ceil($freelancer->avg_rating) && $freelancer->avg_rating - floor($freelancer->avg_rating) > 0)
                                                    <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                    @else
                                                    <i class="far fa-star"></i> <!-- Empty star -->
                                                    @endif
                                                    @endfor
                                                    @else
                                                    <p class="text-muted">No ratings yet.</p>
                                                    @endif
                                            </div>
                                            <button class="btn-seemore fs-6 text-uppercase 
                                            poppins-regular w-100 border-0 text-nowrap rounded-2 ">View Profile</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    @foreach($freelancers->slice(4,4) as $freelancer)

                                    <!--fetch the first service of the freelancer-->
                                    @php
                                    // Get the first service where it is available
                                    $firstService = $freelancer->services->where('isAvailable', true)->first();
                                    @endphp

                                    <div class="col-md-3">
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid">
                                            <h5 class="mb-0">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}} </h5>
                                            <span class="mt-0">{{ optional($firstService)->job_title ?? 'No service found with ID 1.' }}</span>

                                            <div class="d-flex align-items-center mt-1">
                                                @if($freelancer->avg_rating > 0)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=floor($freelancer->avg_rating))
                                                    <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                    @elseif ($i == ceil($freelancer->avg_rating) && $freelancer->avg_rating - floor($freelancer->avg_rating) > 0)
                                                    <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                    @else
                                                    <i class="far fa-star"></i> <!-- Empty star -->
                                                    @endif
                                                    @endfor
                                                    @else
                                                    <p class="text-muted">No ratings yet.</p>
                                                    @endif
                                            </div>
                                            <button class="btn-seemore fs-6 text-uppercase 
                                            poppins-regular w-100 border-0 text-nowrap rounded-2 ">View Profile</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#freelancerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#freelancerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>

        </section>

        <section class="jobs">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="poppins-medium text-uppercase letter-spacing">FInd a Job</h2>
                    <span class="text-wrap">Unlock new opportunities and grow your career by becoming a CAPSURE freelancer..
                        Take control of your professional journey and join a community that values your skills and creativity.
                        Apply now to start your CAPSURE adventure!
                    </span>
                    <div id="eventsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    @foreach($freelancers->slice(0,4) as $freelancer)
                                    <div class="col-md-3">
                                        <!--fetch the first service of the freelancer-->
                                        @php
                                        $firstService = $freelancer->services->where('isAvailable', true)->first();
                                        @endphp
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid">
                                            <h5 class="mb-0">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}} </h5>
                                            <span class="mt-0">{{ optional($firstService)->job_title ?? 'No service found with ID 1.' }}</span>

                                            <div class="d-flex align-items-center mt-1">
                                                @if($freelancer->avg_rating > 0)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=floor($freelancer->avg_rating))
                                                    <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                    @elseif ($i == ceil($freelancer->avg_rating) && $freelancer->avg_rating - floor($freelancer->avg_rating) > 0)
                                                    <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                    @else
                                                    <i class="far fa-star"></i> <!-- Empty star -->
                                                    @endif
                                                    @endfor
                                                    @else
                                                    <p class="text-muted">No ratings yet.</p>
                                                    @endif
                                            </div>
                                            <button class="btn-seemore fs-6 text-uppercase 
                                            poppins-regular w-100 border-0 text-nowrap rounded-2 ">View Profile</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    @foreach($freelancers->slice(4,4) as $freelancer)

                                    <!--fetch the first service of the freelancer-->
                                    @php
                                    // Get the first service where it is available
                                    $firstService = $freelancer->services->where('isAvailable', true)->first();
                                    @endphp

                                    <div class="col-md-3">
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid">
                                            <h5 class="mb-0">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}} </h5>
                                            <span class="mt-0">{{ optional($firstService)->job_title ?? 'No service found with ID 1.' }}</span>

                                            <div class="d-flex align-items-center mt-1">
                                                @if($freelancer->avg_rating > 0)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=floor($freelancer->avg_rating))
                                                    <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                    @elseif ($i == ceil($freelancer->avg_rating) && $freelancer->avg_rating - floor($freelancer->avg_rating) > 0)
                                                    <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                    @else
                                                    <i class="far fa-star"></i> <!-- Empty star -->
                                                    @endif
                                                    @endfor
                                                    @else
                                                    <p class="text-muted">No ratings yet.</p>
                                                    @endif
                                            </div>
                                            <button class="btn-seemore fs-6 text-uppercase 
                                            poppins-regular w-100 border-0 text-nowrap rounded-2 ">View Profile</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>

        </section>

        <footer class="footer text-center">
            <p>&copy; 2024, CapSure</p>
        </footer>
</div>
@endsection