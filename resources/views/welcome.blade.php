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
<div class="d-flex">
    <section class="text-center col-md-12 col-lg-12 col-sm-12">
        <div class="hero container rounded" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="row px-0 my-1 fs-3 d-flex justify-content-center">
                        <h1 class="m-0">
                            <span class="text-black sedan-regular-italic size-bigger">Capture</span>
                            <span class="sedan-regular size-bigger"> the Moments </span>
                            <span class="sedan-regular-italic size-bigger">Surely</span>
                        </h1>
                    </div>
                    <div class="input-group my-md-4 pb-2">
                        <input type="text" class="form-control fw-light poppins-light " placeholder="What service do you need?">
                        <div class="input-group-append ms-1">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search m-1 fs-3"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section class="container service-categories">

            <!--Mobile View -->

            <div id="mobileCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                    $chunks = array_chunk($cards, 3);
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
            <div class="mt-4 d-none d-md-flex d-lg-flex flex-wrap justify-content-between poppins-regular">
                @foreach ($cards as $card)
                <div class="card custom-card mb-3">
                    <img src="{{ asset($card['image']) }}" class="service-pic-size" alt="{{ $card['text'] }}">
                    <div class="card-body">
                        <p class="card-text mt-1">{{ $card['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="container freelancers">

            <div class="container-fluid">
                <div class="row">
                    <h1 class="mt-4 poppins-medium text-uppercase letter-spacing">Hire Competitive Freelancers</h1>
                    <big class="mb-4" style="line-height: 1.2;">Elevate your event with our exceptional freelancers!
                        From talented event planners and creative designers to dynamic performers, our professionals ensure every detail is perfect. Hire now and make your next event extraordinary!
                    </big>
                    <div id="freelancerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    @foreach($freelancers->slice(0,6) as $freelancer)
                                    <div class="col-md-2">
                                        <!--fetch the first service of the freelancer-->
                                        @php
                                        $firstService = $freelancer->services->where('isAvailable', true)->first();
                                        @endphp
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid mt-2">
                                            <h5 class="mb-0">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}} </h5>
                                            <span class="mt-0">{{ optional($firstService)->job_title ?? 'No service found with ID 1.' }}</span>

                                            <div class="d-flex align-items-center mt-1">
                                                @if($freelancer->avg_rating > 0)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=floor($freelancer->avg_rating))
                                                    <i class="fas fa-star filled mb-3"></i> <!-- Filled star -->
                                                    @elseif ($i == ceil($freelancer->avg_rating) && $freelancer->avg_rating - floor($freelancer->avg_rating) > 0)
                                                    <i class="fas fa-star-half-alt filled mb-3"></i> <!-- Half star -->
                                                    @else
                                                    <i class="far fa-star mb-3"></i> <!-- Empty star -->
                                                    @endif
                                                    @endfor
                                                    @else
                                                    <span class="text-muted mb-2">No ratings yet.</span>
                                                    @endif
                                            </div>
                                            <button class="btn-seemore fs-6 
                                            poppins-regular w-100 border-0 text-nowrap rounded-4 ">View Profile</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    @foreach($freelancers->slice(6,6) as $freelancer)

                                    <!--fetch the first service of the freelancer-->
                                    @php
                                    // Get the first service where it is available
                                    $firstService = $freelancer->services->where('isAvailable', true)->first();
                                    @endphp

                                    <div class="col-md-2">
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid">
                                            <h5 class="mb-0">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}} </h5>
                                            <span class="mt-0">{{ optional($firstService)->job_title ?? 'No service found with ID 1.' }}</span>

                                            <div class="d-flex align-items-center mt-1 mb-3">
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
                                                    <span class="text-muted">No ratings yet.</span>
                                                    @endif
                                            </div>
                                            <button class="btn-seemore fs-6  
                                            poppins-regular w-100 border-0 text-nowrap rounded-4 ">View Profile</button>
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

        <section class="container jobs">
            <div class="container-fluid">
                <div class="row">
                    <h1 class="poppins-medium text-uppercase letter-spacing">Find Your Event Job</h1>
                    <big class="mb-4" style="line-height: 1.2;">Unlock new opportunities and grow your career by becoming a CAPSURE freelancer.
                        Take control of your professional journey and join a community that values your skills and creativity.
                        Apply now to start your CAPSURE adventure!
                    </big>

                    <div class="row d-flex justify-content-center align-items-center">
                        @foreach($events as $event)
                        <div class="col-md-3">
                            <!--for event posts-->
                            <div class="freelancer-card border-1 d-flex flex-column justify-content-center align-items-center "
                                style="box-shadow: 0px 1px 0px rgba(75, 74, 74, 0.5); border:rgb(196, 194, 194) 1px solid;">
                                <div class="row ">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ $event->client->user->profile_image_url }}" alt="Freelancer-{{$event->client->user->id}}" style="width: 50px; height: 50px;" class="me-3 img-fluid">
                                        <div class="d-flex flex-column justify-content-start align-items-center">
                                            <h6 class="mb-0">{{$event->client->user->first_name}} {{$event->client->user->last_name}} </h6>
                                            <small class="text-gray">{{$event->client->user->barangay}}, {{$event->client->user->city}}</small>
                                        </div>

                                    </div>

                                    <h6 class="my-2 text-start fw-bold">{{$event->title}}</h6>
                                    <small class="open-sans-reg">{{$event->description}}</small>

                                    <div class="d-flex justify-content-start">
                                        @foreach($event->event_jobs as $job)
                                        <p class="px-2 rounded-3 border border-secondary-subtle bg-primary-subtle mt-2 mb-2">{{$job->service_needed}}</p>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <button class=" me-2 btn-seeprof fs-6 
                                            poppins-regular w-100 border-1 px-1 text-nowrap rounded-4 " style="background-color:#FCF2F9;">View Details</button>
                                    <button class="btn-save fs-6 
                                            poppins-regular w-100 border-1 px-1 text-nowrap rounded-4 ">Interested</button>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>
            </div>


        </section>
        <footer class="footer mt-5 py-4 text-white">
            <div class="container-fluid">
                <div class="row">
                    <!-- About Section -->
                    <div class="col-md-4 me-4">
                        <h5>About Us</h5>
                        <p>
                            We provide exceptional freelance services, helping you elevate your event or project with the right talent.
                            From event planners to videographers, we’ve got you covered.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-md-3 ms-4">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Home</a></li>
                            <li><a href="#" class="text-white">Services</a></li>
                            <li><a href="#" class="text-white">Freelancers</a></li>
                            <li><a href="#" class="text-white">Contact Us</a></li>
                        </ul>
                    </div>

                    <!-- Contact Section -->
                    <div class="col-md-4">
                        <h5>Contact Us</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-map-marker-alt"></i> 123 Freelancer St, City, Country</li>
                            <li><i class="fas fa-phone"></i> +1 234 567 890</li>
                            <li><i class="fas fa-envelope"></i> info@capsure.com</li>
                        </ul>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col text-center">
                        <p>&copy; 2024 CAPSURE. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </section>
</div>

<style>
    .footer {
        color: #ffffff;
        background-color: #91216C;
        position: relative;
        width: 100%;
    }

    .footer h5 {
        font-weight: 600;
    }

    .footer a {
        color: #ffffff;
        text-decoration: none;
    }

    .footer a:hover {
        color: #ffc107;
    }

    .footer .list-unstyled li {
        margin-bottom: 10px;
    }

    .footer .text-center {
        border-top: 1px solid #444;
        padding-top: 15px;
        margin-top: 20px;
    }
</style>
@endsection