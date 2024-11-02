<div wire.poll>
    @if($users->isEmpty())
    <p class="fs-5 text-muted text-center open-sans-reg">No Freelancers found.</p>
    @else

    <!-- Grid Layout for All Screens -->
    <div class="card-grid d-flex flex-wrap">
        @foreach ($users as $user)
        @if($user->freelancer)
        @php
        if($category === 'any') {
        $service = $user->freelancer->services->first();
        } else {
        $service = $user->freelancer->services->where('job_category', $category)->first();
        }
        $portfolio = $user->freelancer->portfolios->first();
        @endphp

        <div class="card mx-auto shadow-box my-3" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
            <div class="col-align px-2 mt-1">
                <h5 class="card-title poppins-medium mt-1">{{ $service->job_title }}</h5>
                <h5 class="poppins-medium fs-5 mb-0 right-side">₱{{ $service->job_fee}}</h5>
            </div>

            <!-- Display Freelancer Cover Image -->
            @if($portfolio)
            @php
            $paths = json_decode($portfolio->path, true);
            $firstImage = $paths[0];
            $relativePath = str_replace('public/', '', $firstImage);
            @endphp
            <img src="{{ asset('storage/' . $relativePath) }}" class="rounded-0" alt="cover" style="border-radius: 15px 15px 0 0; width: 100%; height: 150px; object-fit: cover;">
            @else
            <img src="{{ asset('assets/cover.svg') }}" class="rounded-0" alt="cover" style="border-radius: 15px 15px 0 0; width: 100%; height: 150px; object-fit: cover;">
            @endif


            <div class="card-body open-sans-reg px-3 py-2">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ $user->profile_image_url }}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                    <div class="ms-3">
                        <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">{{ $user->first_name }} {{ $user->last_name }}</p>
                        <p class="card-text open-sans-light small mb-0">{{ $user->city }}</p>

                        @if($user->freelancer->number_of_projects > 0)
                        <p class="card-text open-sans-light small text-success mb-0">{{ $user->freelancer->number_of_projects }} done</p>
                        @else
                        <p class="card-text open-sans-light small text-success mb-0">No projects yet</p>
                        @endif
                    </div>
                    <div class="ms-auto d-flex justify-content-center align-items-center">
                        @if($user->freelancer->avg_rating > 0)
                        <span class="text-warning me-1">★</span>
                        <span class="fw-bold">{{ number_format($user->freelancer->avg_rating, 1) }}</span>
                        <span class="text-muted ms-1">({{ $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->count() }})</span>
                        @else
                        <span class="text-muted me-1 fs-smaller">No ratings yet</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('view-freelancer-profile', ['id' => $user->id]) }}" class="btn btn-seeprof rounded-pill w-100 me-2" style="border-color: #91216C; color:#91216C;">See Profile</a>
                    <button wire:click="toggleFavorite({{ $user->id }})" class="btn">
                        <img src="{{ auth()->user()->client->isFavorite($user->id) ? asset('assets/saved.svg') : asset('assets/bookmark.svg') }}" alt="Bookmark" class="bookmark-icon" style="width: 40px; height: 40px;">
                    </button>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links('vendor.pagination.bootstrap-4') }}
    </div>
    <hr class="custom-hr py-4 my-4">
    @endif
</div>