@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<div class="welcome-cont container text-content d-block d-lg-flex row">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center text-lg-start py-lg-3"
                    style="font-family: Rammetto One, sans-serif; font-weight: 400; font-style: normal;">Capture <span style="color:black;">the <br> Moments</span> Surely</h1>
                <p class="poppins-regular pb-3 text-center text-lg-start">Sign up now and find the perfect freelancer to bring your event to life. With Capsure, every moment is a masterpiece waiting to be captured.</p>
                <div class="d-flex d-lg-block justify-content-center"><a href="/choose" class="btn mb-3">Get Started</a></div>
            </div>
            <div class="col d-flex justify-content-center my-4 my-lg-0">
                <!-- Bootstrap Carousel -->
                <div id="carouselServices" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/craft.svg" class="d-block" alt="Handicraft">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/foodservices.svg" class="d-block" alt="Food Services">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/online.svg" class="d-block " alt="Online Services">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/eventplanner.svg" class="d-block" alt="Event Planner">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/style.svg" class="d-block" alt="Stylist">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/art.svg" class="d-block" alt="Artistry">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/photography.svg" class="d-block" alt="Photography">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/videog.svg" class="d-block" alt="Videography">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/voicetalent.svg" class="d-block" alt="Voice Talent">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/entertain.svg" class="d-block" alt="Entertainment">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselServices" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselServices" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>
        </div>
        <div class="row d-flex justify-content-center mt-2">
            <ul class="menu-list d-flex list-unstyled text-center">
                <li class="menu-item active">Handicraft</li>
                <li class="menu-item">Food Services</li>
                <li class="menu-item">Online Services</li>
                <li class="menu-item">Event Planner</li>
                <li class="menu-item">Stylist</li>
                <li class="menu-item">Art</li>
                <li class="menu-item">Photography</li>
                <li class="menu-item">Videography</li>
                <li class="menu-item">Voice Talent</li>
                <li class="menu-item">Entertainment</li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <section class="container freelancers">
        <div class="row">
            <h1 class="mt-4 pt-4 letter-spacing text-center" style="font-family: Rammetto One, sans-serif;">Hire <span class="text-purple">Competitive</span> Event Freelancers</h1>
            <small class="mb-4 text-muted fs-md-1 text-center" style="line-height: 1.2;">
                <div>Elevate your event with our exceptional freelancers!
                    From talented event planners and creative designers to dynamic performers, our professionals ensure every detail is perfect.
                </div>
                <div class="mt-2"> Hire now and make your next event extraordinary!</div>
            </small>
            <div id="freelancerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" style="height: 500px;">
                    <div class="carousel-item active">

                        <div class="row">
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-2" class="rounded-circle img-fluid" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith2</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <a href="#" class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</a>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-4" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith4</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-6" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith6</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-8" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith8</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item ">
                        <div class="row">
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-10" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith10</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-12" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith12</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-14" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith14</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-16" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith16</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item ">
                        <div class="row">
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-18" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith18</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-20" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith20</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-22" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith22</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-24" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith24</h5>
                                    <span class="mt-0">Videographer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
    </section>

    <section class="container jobs py-4">
        <div class="row">
            <h1 class="letter-spacing text-center" style="font-family: Rammetto One, sans-serif;"><span class="text-purple">Start</span> your Event Freelancing Career</h1>
            <small class="mb-4 text-muted text-center" style="line-height: 1.2;">
                <div> Unlock new opportunities and grow your career by becoming a CAPSURE freelancer.
                    Take control of your professional journey and join a community that values your skills and creativity.
                </div>
                <div class="mt-3"> Apply now to start your CAPSURE adventure!</div>
            </small>
            <div class="row d-flex justify-content-center align-items-center">
                <!-- Event Post Card -->
                @foreach($events as $event)
                <div class="col-12 col-md-6 col-lg-4 mb-4" wire:loading.remove>
                    <div class="card shadow-sm rounded-4" style="background-color: white;">
                        <div class="card-body">

                            <div class="d-flex justify-content-between ">
                                <h4 class="card-title poppins-medium text-truncate">{{$event->title}}</h4>
                                <!-- Calculate and display the time since creation -->
                                @php
                                $createdAt = \Carbon\Carbon::parse($event->created_at);
                                $timeSince = $createdAt->diffForHumans();
                                @endphp
                                <p class="card-text note">{{ $timeSince }}</p>
                            </div>
                            <div class="row rw-height-eventdesc mb-2">
                                <p class="card-text content-color text-truncate">{!! nl2br(e($event->description)) !!}</p>
                            </div>

                            <div class="d-flex flex-wrap">
                                @foreach($event->event_jobs ?? [] as $event_job)
                                <span class="badge me-1 mb-2" style="font-size:small; background-color: #8FE2ED; color:#323232;">{{$event_job->service_needed}}</span>
                                @endforeach
                            </div>

                            <hr class="mt-2 border-1 opacity-25">
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ $event->client->user->profile_image_url }}" alt="Profile" class="rounded-circle me-2" width="50">
                                <div>
                                    <h6 class="mb-0 poppins-medium">{{$event->client->user->fullName()}}</h6>
                                    <small class="text-muted">{{$event->client->user->city}}</small>
                                </div>
                                <div class="ms-auto d-flex align-items-center">
                                    @if ($event->client->avg_rating > 0)
                                    <span class="text-warning me-1">★</span>
                                    <span class="fw-bold">{{ number_format($event->client->avg_rating, 1) }}</span>
                                    <span class="text-muted small ms-1">({{ $event->client->reviews()->where('reviewee_role', 'client')->count() }})</span>
                                    @else
                                    <span class="note me-1">No ratings yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <a href="{{ route('login') }}" class="btn-seeprof" style="background-color: #fceef7;border:none;">Interested</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<footer class="footer py-2">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col text-center mb-0 pb-0" style="border-top:none; background-color:#fceef7;">
                <p>&copy; 2024 CAPSURE. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.querySelector('#carouselServices');
        const menuItems = document.querySelectorAll('.menu-item');

        // Add event listener to carousel
        carousel.addEventListener('slide.bs.carousel', function(event) {
            // Get the index of the new active item
            const newIndex = event.to;

            // Remove active class from all menu items
            menuItems.forEach(item => item.classList.remove('active'));

            // Add active class to the corresponding menu item
            if (menuItems[newIndex]) {
                menuItems[newIndex].classList.add('active');
            }
        });
    });
</script>

<style>
    .menu-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .menu-item {
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #5c005c;
        background-color: transparent;
        transition: background-color 0.3s ease, color 0.3s ease;
        padding: 5px 15px;
        margin: 8px;
        text-align: center;
        white-space: nowrap;
    }

    .menu-item:hover,
    .menu-item.active {
        background-color: #E1C1D7;
        color: #000;
    }

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

    .welcome-cont {
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin: 0;
        background-color: #fceef7;
    }

    .text-content {
        max-width: 100%;
    }

    .text-content h1 {
        font-size: 40px;
        color: #5c005c;
        line-height: 1.5;
    }

    .text-content p {
        margin: 20px 10px;
        font-size: 14px;
        color: #555;
        max-width: 100%;
    }

    .carousel-inner img {
        width: 300px;
        height: 300px;
    }

    .text-content .btn {
        padding: 10px 40px;
        background-color: #91216C;
        color: #fff;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        cursor: pointer;
    }

    .text-content .btn:hover {
        background-color: #b3006d;
    }

    .carousel-caption {
        position: absolute;
        bottom: 80px;
        background-color: rgba(255, 255, 255, 0.8);
        /* Semi-transparent white background */
        padding: 5px 10px;
        /* Adjust spacing */
        border-radius: 5px;
        font-size: 16px;
        color: #5c005c;
        /* Text color */
        font-weight: bold;
        font-family: 'Rammetto One', sans-serif;
        text-align: center;
        /* Center-align the text */
        z-index: 10;
        /* Ensure it displays above other elements */
    }

    @media (width >=768px) {
        .text-content h1 {
            font-size: 50px;
        }

        .text-content p {
            font-size: 15px;
        }

        .welcome-cont {
            padding: 75px 60px;
        }

        .carousel-inner img {
            width: 500px;
            height: 500px;
        }
    }

    @media (min-width: 1200px) {
        .text-content h1 {
            font-size: 60px;
        }

        .text-content p {
            font-size: 15px;
        }

        .welcome-cont {
            padding: 75px 60px;
        }

        .carousel-inner img {
            width: 500px;
            height: 500px;
        }
    }
</style>

@endsection