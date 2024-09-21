<div wire.poll>

    @if($users->isEmpty())
    <p class="fs-5 text-muted text-center open-sans-reg">No Freelancers found.</p>

    @else

    
    <!-- Carousel for Mobile View -->
    <div id="cardCarousel" class="carousel slide d-block d-md-none mb-4 pb-1" data-bs-ride="carousel">
        <div class="carousel-inner justify-content-center pb-4">
            @foreach ($users as $user)
            @if ($user->freelancer)
            @php
            $service = $user->freelancer->services->first();
            $portfolio = $user->freelancer->portfolios->first();
            @endphp
            <div class="carousel-item {{ $loop->first ? 'active' : '' }} py-2">
                <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border: none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                    <div class="col-align px-2 mt-1">
                        <h5 class="card-title poppins-medium mt-1">{{ $service->job_title }}</h5>
                        <h5 class="poppins-medium fs-5 mb-0 right-side">{{ $service->fee }}</h5>
                    </div>

                    @if ($portfolio)
                    @php
                    $paths = json_decode($portfolio->path, true);
                    $firstImage = $paths[0];
                    @endphp
                    <img src="{{ $firstImage }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                    @else
                    <img src="{{ asset('assets/cover.svg') }}" class="card-img-top profile-container rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                    @endif

                    <div class="card-body open-sans-reg p-2">
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $user->profile_image }}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                            <div class="ms-3">
                                <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="card-text open-sans-light small mb-0">{{ $user->city }}</p>
                                @if ($user->freelancer->number_of_projects > 0)
                                <p class="card-text open-sans-light small text-success mb-0">{{ $user->freelancer->number_of_projects }} done</p>
                                @else
                                <p class="card-text open-sans-light small text-success mb-0">No projects yet</p>
                                @endif
                            </div>
                            <div class="ms-auto d-flex align-items-center">
                                @if ($user->avg_rating > 0)
                                <span class="text-warning me-1">★</span>
                                <span class="fw-bold">{{ $user->freelancer->avg_rating }}</span>
                                <span class="text-muted small ms-1">(10)</span>
                                @else
                                <span class="text-muted me-1 fs-smaller">No ratings yet</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2">
                            <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                            <img src="{{ asset('assets/bookmark.svg') }}" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
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



    <!-- Grid Layout for Larger Screens -->
    <div class="card-grid d-none d-md-flex flex-wrap justify-content-center">
        @foreach ($users as $user)
        @if($user->freelancer)

        @php
        $service = $user->freelancer->services->first();
        $portfolio =$user->freelancer->portfolios->first();
        @endphp

        <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
            <div class="col-align px-2 mt-1">
                <!-- Display Freelancer Title and Rate -->
                <h5 class="card-title poppins-medium mt-1">{{ $service->job_title }}</h5>
                <h5 class="poppins-medium fs-5 mb-0 right-side">{{ $service->fee}}</h5>
            </div>

            <!-- Display Freelancer Cover Image -->
            @if($portfolio)
            <!--display the first image in their first album -->
            @php
            $paths = json_decode($portfolio->path, true);
            $firstImage = $paths[0];
            @endphp
            <img src="{{ $firstImage }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
            @else
            <img src="{{ asset('assets/cover.svg') }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
            @endif

            <div class="card-body open-sans-reg p-3">
                <div class="d-flex align-items-center mb-2">
                    <!-- Display Freelancer Profile Image -->
                    <img src="{{ $user->profile_image }}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                    <div class="ms-3">
                        <!-- Display Freelancer Name, Location, and Projects -->
                        <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="card-text open-sans-light small mb-0">{{ $user->city }}</p>

                        <!-- if no projects yet -->
                        @if($user->freelancer->number_of_projects > 0)
                        <p class="card-text open-sans-light small text-success mb-0">{{ $user->freelancer->number_of_projects }} done</p>
                        @else
                        <p class="card-text open-sans-light small text-success mb-0">No projects yet</p>
                        @endif
                    </div>
                    <div class="ms-auto d-flex align-items-center">
                        @if($user->avg_rating > 0)
                        <span class="text-warning me-1">★</span>
                        <!-- Display Freelancer Rating and Reviews -->
                        <span class="fw-bold">{{ $user->freelancer->avg_rating }}</span>
                        <span class="text-muted small ms-1">(10)</span>
                        @else
                        <span class="text-muted me-1 fs-smaller ">No ratings yet</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- See Profile Button -->
                    <a href="#" class="btn btn-outline-primary w-100 me-2" style="border-radius: 25px; font-weight: 600; border-color: #91216C; color: #91216C">See Profile</a>
                    <!-- Bookmark Icon -->
                    <img src="{{ asset('assets/bookmark.svg') }}" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class=" mt-4 d-flex justify-content-center">
        {{ $users->links('vendor.pagination.bootstrap-4') }}

    </div>
    <hr class="custom-hr py-4 my-4">
    @endif


</div>