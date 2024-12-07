@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<div class="welcome-cont container text-content d-block d-lg-flex row">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center text-lg-start py-lg-3 txt-purple"
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

<div class="container justify-content-center">
    <section class="container text-content freelancers">
        <div class="row">
            <h1 class="mt-4 pt-4 letter-spacing text-center poppins-medium">Hire <span class="text-purple">Competitive</span> Event Freelancers</h1>
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
                                    <h5 class="mb-0 ellipsis">Aliza Dalisay</h5>
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
                                    <h5 class="mb-0 ellipsis">James Paul Buenavides</h5>
                                    <span class="mt-0">Event Organizer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-6" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Ferlanie Jade Roxas</h5>
                                    <span class="mt-0">Make-up Artist</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-8" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Dulce Dina Co</h5>
                                    <span class="mt-0">English Tutor</span>

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
                                    <h5 class="mb-0 ellipsis">Manuel David</h5>
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
                                    <h5 class="mb-0 ellipsis">Xavier Ramos</h5>
                                    <span class="mt-0">Party Clown</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-14" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Daisy Smith</h5>
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
                                    <h5 class="mb-0 ellipsis">Loki Limosa</h5>
                                    <span class="mt-0">Florist</span>

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
                                    <h5 class="mb-0 ellipsis">Annaliza Castillo</h5>
                                    <span class="mt-0">Event Singer</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-20" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Chinna Garbo</h5>
                                    <span class="mt-0">Bead Artist</span>

                                    <div class="d-flex align-items-center mt-1">
                                        <span class="text-muted mb-2">No ratings yet.</span>
                                    </div>
                                    <button class="mb-2 py-1 btn-seemore fs-6 poppins-regular w-75 border-0 text-nowrap rounded-4">View Profile</button>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="freelancer-card d-flex flex-column justify-content-center align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/default.svg" alt="Freelancer-22" class="img-fluid rounded-circle" style="width: 70px; height: 70px;">
                                    <h5 class="mb-0 ellipsis">Kevin Azura</h5>
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
                                    <h5 class="mb-0 ellipsis">Erika Nina Boler</h5>
                                    <span class="mt-0">Host</span>

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

    <section class="container text-content jobs py-4">
        <div class="row  d-flex justify-content-center align-items-center">
            <h1 class="letter-spacing text-center poppins-medium"><span class="text-purple">Start</span> your Event Freelancing Career</h1>
            <small class="mb-4 text-muted text-center" style="line-height: 1.2;">
                <div> Unlock new opportunities and grow your career by becoming a CAPSURE freelancer.
                    Take control of your professional journey and join a community that values your skills and creativity.
                </div>
                <div class="mt-3"> Apply now to start your CAPSURE adventure!</div>
            </small>
            <div class="row" style="white-space: nowrap;">
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
                                <span class="card-text note">{{ $timeSince }}</span>
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

    <section class="text-content py-4 my-4 rounded-4 justify-content-center" style="background-color: #fceef7;">
        <div class="row d-block d-md-flex d-lg-flex justify-content-center">
            <h1 class="letter-spacing text-center poppins-medium">How <span class="text-purple">Capsure</span> Works</h1>
        </div>
        <div class="row justify-content-center pb-2">
            <div class="col-lg-3 col-md-4 col-sm-6 card rounded-4 m-2 text-center" style="border: none;">
                <div class="row justify-content-center">
                    <img src="assets/create.svg" style="height: 150px; width: 150px;">
                    <strong class="fs-6 text-center poppins-medium">Create Your Account</strong>
                    <p class="px-3 text-center poppins-regular note" style="font-size: small;">Sign up as a Client or Freelancer and verify your email to access all platform features.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 card rounded-4 m-2 text-center" style="border: none;">
                <div class="row justify-content-center">
                    <img src="assets/build.svg" style="height: 150px; width: 150px;">
                    <strong class="fs-6 text-center poppins-medium px-4">Build Your Profile & Post or Apply</strong>
                    <p class="px-3 text-center poppins-regular note"  style="font-size: small;">Clients can post events with detailed requirements, while freelancers can showcase their skills and apply for jobs that match their expertise.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 card rounded-4 m-2 text-center" style="border: none;">
                <div class="row justify-content-center">
                    <img src="assets/review.svg" style="height: 150px; width: 150px;">
                    <strong class="fs-6 text-center poppins-medium px-4">Manage Transactions & Leave Reviews</strong>
                    <p class="px-3 text-center poppins-regular note"  style="font-size: small;">Track payments, confirm transactions, and share reviews to build credibility and strengthen the Capsure community.</p>
                </div>
            </div>
        </div>

        <div class="row px-4 mx-1 justify-content-center">
            <!-- Toggle Section 1 -->
            <div class="toggle-section p-0 rounded-4">
                <div class="toggle-header" onclick="toggleSection(this)">
                    <span class="poppins-medium">For Client Guide</span>
                    <span class="toggle-arrow"><i class="fas fa-angle-down"></i></span>
                </div>
                <div class="toggle-content p-4 poppins-regular" style="font-size: small;">
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 1: Sign Up as a Client</strong><br>
                     by creating an account as a "Client." After registering, verify your email address to activate your account.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 2: Create Your Profile & Verify Your Account</strong><br>
                    Fill in the required details to complete your profile and proceed with the verification process.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 3: Create Your Event Post</strong><br>
                    Provide detailed information about your event, including the services you need. Whether it’s event planning, coordination, or specialized roles, clearly specify your requirements to help freelancers respond accurately.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 4: Hire or Negotiate</strong><br>
                    Browse available freelancers or you can wait for applicants and choose one that meets your needs. You can hire a freelancer at their listed rate or negotiate the fee to reach a mutually agreeable arrangement.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 5: Manage Transactions & Leave Reviews</strong><br>
                    Track your hired freelancers and payment status through the "My Transactions" page. After your event is completed, leave a review to help other clients and contribute to the community's growth.<br><br>
                </div>
            </div>

            <!-- Toggle Section 2 -->
            <div class="toggle-section p-0 rounded-4">
                <div class="toggle-header" onclick="toggleSection(this)">
                    <span class="poppins-medium">For Freelancer Guide</span>
                    <span class="toggle-arrow"><i class="fas fa-angle-down"></i></span>
                </div>
                <div class="toggle-content p-4 poppins-regular" style="font-size: small;">
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 1: Sign Up as a Freelancer</strong><br>
                    Create an account as a "Freelancer" by providing your job role.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 2: Build Your Profile & Portfolio</strong><br>
                    Enhance your profile by adding details about your skills.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 3: Verify Your Account</strong><br>
                    Complete the verification process to establish trust and authenticity as a freelancer on the platform.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 4: Apply for Jobs in Events</strong><br>
                    Browse job event postings and apply for events that match your expertise. Once you submit your application, wait for the client’s response to proceed with negotiations or hiring.<br><br>
                    <strong class="fs-6 txt-purple poppins-medium"><i class="fas fa-thumbtack text-warning me-1"></i> Step 5: Manage Transactions & Leave Reviews</strong><br>
                    Track your client’s payment and confirm through the "My Transactions" page. After completing a job, leave a review to enhance your reputation and help the client gain credibility.<br><br>
                </div>
            </div>
        </div>
    </section>
</div>

<footer class="footer py-2">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col text-center mb-0 pb-0">
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

    // Toggle function
    function toggleSection(header) {
        const content = header.nextElementSibling;
        const arrow = header.querySelector('.toggle-arrow i');

        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
            arrow.classList.add("open");
        } else {
            content.style.display = "none";
            arrow.classList.remove("open");
        }
    }
</script>

<style>
    .toggle-section {
        border: 1px solid #ddd;
        border-radius: px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .toggle-header {
        background-color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: bold;
    }

    .toggle-content {
        padding: 10px;
        display: none;
        background-color: white;
        border-top: 1px solid lightgray;
    }

    .toggle-arrow {
        transition: transform 0.3s ease;
    }

    .toggle-arrow.open {
        transform: rotate(90deg);
    }

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
        font-size: 12px;
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
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 16px;
        color: #5c005c;
        font-weight: bold;
        font-family: 'Rammetto One', sans-serif;
        text-align: center;
        z-index: 10;
    }

    @media (width >=768px) {
        .text-content h1 {
            font-size: 40px;
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
            font-size: 55px;
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
        .toggle-section {
            width: 85%;
        }
    }
</style>
@endsection