<div>
    <!-- Events -->
    <div class="container mt-2 poppins-regular ">
        <div class="row">

            <!-- Spinner - Shown while loading -->
            <div class="col-12" wire:loading>
                <div class=" d-flex justify-content-center align-items-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            @if($filtersApplied)
            <div class="col-12" wire:loading.remove>
                <div class="d-flex justify-content-center">
                    <p class="text-muted badge fs-6">Jobs Result: {{$resultsCount}}</p>
                </div>
            </div>
            @endif

            @if($events->isNotEmpty())
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
                            <p class="card-text content-color">{!! nl2br(e($event->description)) !!}</p>
                        </div>

                        <div class="d-flex flex-wrap justify-content-start align-items-center">

                            @php
                            $plusMoreCount = $event->event_jobs->count() > 2 ? $event->event_jobs->count() - 2 : null;
                            @endphp

                            @foreach ($event->event_jobs->take(2) as $event_job)
                            <span class="badge me-1 mb-2" style="font-size:small; background-color: whitesmoke; color:#323232;">{{$event_job->service_needed}}</span>
                            @endforeach

                            @if ($plusMoreCount)
                            <span class="badge bg-light text-dark me-1 mb-2">
                                +{{ $plusMoreCount }}
                            </span>
                            @endif

                        </div>

                        <hr class="mt-2 border-1 opacity-25">
                        <div class="d-flex align-items-center mt-3">
                            <img src="{{ $event->client->user->profile_image_url }}" alt="Profile" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
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
                                <span class="note me-1 fs-for-mobile">No ratings yet</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="confirm me-2">View Details</a>
                            <a href=" {{route('view-client-profile', ['id' => $event->client_id] ) }}" class="btn-seeprof ">See Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-center fs-5">No events found.</p>
            @endif

        </div>

        <!-- Pagination -->
        <div class=" mt-4 d-flex justify-content-center">
            {{ $events->links('vendor.livewire.bootstrap') }}
        </div>

    </div>

</div>
