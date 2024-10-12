<div class="d-md-none d-block">
    <div class="row">
        @forelse($eventRecommendations as $event)
        <div class="col-12 mb-3"> <!-- Card for each event recommendation -->
            <div class="card rounded-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-text">
                        <span class="me-2" style="color: #91216C;"><strong>DATE & TIME:</strong></span> 
                        <span>{{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</span><br>
                        <span class="me-2" style="color: #91216C;"><strong>LOCATION:</strong></span> 
                        <span>{{ $event->street }}, {{ $event->barangay }}, {{ $event->city }}</span><br>
                        <span class="me-2" style="color: #91216C;"><strong>BUDGET:</strong></span> 
                        <span>₱{{ $event->budget_min }} - ₱{{ $event->budget_max }}</span>
                    </p>
                    <div class="d-flex flex-wrap justify-content-start align-items-start mb-2">
                        @foreach($event->event_jobs as $job)
                        <span class="me-2 rounded-3 border border-secondary-subtle bg-primary-subtle p-2">{{ $job->service_needed }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="btn btn-link" style="color: #91216C;">View Post</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-muted text-center mt-4 fs-4">No Available Events</div>
        @endforelse
    </div>
</div>
