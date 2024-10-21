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
        <div class="hero container rounded-1 d-flex flex-column  align-items-center justify-content-center" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">
            <div class="row d-flex justify-content-center">
                <div class="col-12 text-center"> <!-- Center the text and the search bar -->
                    <div class="row px-0 my-1 fs-3 d-flex justify-content-center">
                        <h1 class="m-0">
                            <span class="text-black sedan-regular-italic size-bigger">Capture</span>
                            <span class="sedan-regular size-bigger"> the Moments </span>
                            <span class="sedan-regular-italic size-bigger">Surely</span>
                        </h1>
                    </div>
                    <div class="input-group my-md-4 pb-2 justify-content-center mx-auto" style="max-width: 600px;"> <!-- Added mx-auto and max-width -->
                        <input type="text" class="form-control fw-light poppins-light" placeholder="What service do you need?">
                        <div class="input-group-append ms-1">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search m-1 fs-3"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="container service-categories">
            @php
            $chunks = array_chunk($cards, 10);
            @endphp

            @foreach($chunks as $index => $chunk)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="row justify-content-center">
                    @foreach($chunk as $card)
                    <div class="col-6 col-lg-3 mb-3 justify-content-center align-items-center"> <!-- 2 columns for small screens, 4 columns for large screens -->
                        <div class="card justify-content-center align-items-center d-flex g-1 card-equal-height" style="line-height:0.9;">
                            <img src="{{ $card['image'] }}" class="img-mob mt-2" alt="{{ $card['text'] }}">
                            <p>{{ $card['text'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </section>

        <section class="container freelancers">
            <div class="container-fluid">
                <div class="row">
                    <h1 class="mt-4 pt-4 poppins-medium text-uppercase letter-spacing">Hire Competitive Freelancers</h1>
                    <small class="mb-4 text-muted fs-md-1" style="line-height: 1.2;">Elevate your event with our exceptional freelancers!
                        From talented event planners and creative designers to dynamic performers, our professionals ensure every detail is perfect. Hire now and make your next event extraordinary!
                    </small>
                    <div id="freelancerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" style="overflow-y: visible;">
                            @php
                            $chunks = $freelancers->chunk(4); 
                            @endphp

                            @foreach($chunks as $index => $chunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row">
                                    @foreach($chunk as $freelancer)
                                    <div class="col-6 col-md-4 col-lg-3"> <!-- col-6 for small screens (2 per row), col-md-2 for larger screens (6 per row) -->
                                        @php
                                        $firstService = $freelancer->services->where('isAvailable', true)->first();
                                        @endphp
                                        <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $freelancer->user->profile_image_url }}" alt="Freelancer-{{$freelancer->user_id}}" class="img-fluid mt-2">
                                            <h5 class="mb-0 ellipsis">{{$freelancer->user->first_name}} {{$freelancer->user->last_name}}</h5>
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
                                            <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Carousel controls -->
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

        <section class="container jobs py-4">
            <div class="container-fluid">
                <div class="row">
                    <h1 class="poppins-medium text-uppercase letter-spacing">Find Your Event Job</h1>
                    <small class="mb-4 text-muted" style="line-height: 1.2;">
                        Unlock new opportunities and grow your career by becoming a CAPSURE freelancer.
                        Take control of your professional journey and join a community that values your skills and creativity.
                        Apply now to start your CAPSURE adventure!
                    </small>
                    <div class="row">
                        @foreach($events as $event)
                        <div class="col-12 col-md-6 col-lg-4 mb-2"> <!-- Adjust the grid for responsiveness -->
                            <!-- Event Post Card -->
                            <div class="freelancer-card border-1 d-flex flex-column justify-content-center align-items-center"
                                style="box-shadow: 0px 1px 0px rgba(75, 74, 74, 0.5); border:rgb(196, 194, 194) 1px solid; padding: 1rem; width: 100%;">
                                <div class="row w-100"> <!-- Ensure full width -->
                                    <div class="p-0 d-flex justify-content-start align-items-center">
                                        <img src="{{ $event->client->user->profile_image_url }}"
                                            alt="Freelancer-{{$event->client->user->id}}"
                                            style="width: 50px; height: 50px;"
                                            class="mx-2 img-fluid rounded-circle">
                                        <div class="d-flex flex-column">
                                            <span class="mb-0">{{$event->client->user->first_name}} {{$event->client->user->last_name}}</span>
                                            <small class="text-gray">{{$event->client->user->barangay}}, {{$event->client->user->city}}</small>
                                        </div>
                                    </div>
                                    <h6 class="my-2 text-center fw-bold">{{$event->title}}</h6>
                                    <small class="open-sans-reg">{{$event->description}}</small>
                                    <div class="d-flex justify-content-center flex-wrap"> <!-- Added flex-wrap for better responsiveness -->
                                        @foreach($event->event_jobs as $job)
                                        <p class="me-2 px-2 rounded-4 border-secondary-subtle bg-primary-subtle mt-2 mb-2"
                                            style=" box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);">
                                            {{$job->service_needed}}
                                        </p>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-between align-items-center w-100"> <!-- Full width for buttons -->
                                    <button class="p-1 me-3 btn-seemore fs-6 poppins-regular w-100 border-0 text-nowrap rounded-4">View Details</button>
                                    <button class="p-1 btn-save fs-6 poppins-regular w-50 px-1 border-0 text-nowrap rounded-4">Interested</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer py-2">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col text-center" style="color: #91216C;">
                        <p>&copy; 2024 CAPSURE. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

    </section>
</div>

<style>
    .img-mob {
        height: 90px;
        width: 90px;
    }

    .card-equal-height {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .footer {
        background-color: white;
        position: relative;
        width: 100%;
    }

    .footer .text-center {
        border-top: 1px solid #91216C;
        padding-top: 15px;
        margin-top: 20px;
    }
</style>
@endsection