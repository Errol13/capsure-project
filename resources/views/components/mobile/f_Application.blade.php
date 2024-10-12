<div class="d-md-none d-block">
    @foreach($appliedJobs as $job)
    <div class="card mb-3 shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="card-title fw-bold">{{ $job->event->title }}</h5>
            <p class="card-text mb-1">
                <span class="fw-bold" style="color: #91216C;">DATE & TIME:</span>
                <span class="d-block">{{ $job->event->start_date_formatted }} - {{ $job->event->end_date_formatted }}</span>
            </p>
            <p class="card-text mb-1">
                <span class="fw-bold" style="color: #91216C;">LOCATION:</span>
                <span class="d-block">{{ $job->event->street }}, {{ $job->event->barangay }}, {{ $job->event->city }}</span>
            </p>
            <p class="card-text mb-1">
                <span class="fw-bold" style="color: #91216C;">BUDGET:</span>
                <span class="d-block">₱{{ $job->event->budget_min }} - ₱{{ $job->event->budget_max }}</span>
            </p>
            <hr>
            <p class="card-text mb-1">
                <span class="fw-bold" style="color: #91216C;">Applied as:</span>
                <span class="d-block">{{ $job->service_needed }}</span>
            </p>
            <p class="card-text mb-1">
                <span class="fw-bold" style="color: #91216C;">Availability:</span>
                <span class="d-block {{ $job->event->status == 'Open' ? 'text-success' : 'text-danger' }} text-uppercase fw-bold">{{ $job->event->status }}</span>
            </p>
            <p class="card-text mb-3">
                <span class="fw-bold" style="color: #91216C;">Status:</span>
                <span class="d-block {{ $job->pivot->status == 'Pending' ? 'pending-color' : ($job->pivot->status == 'Accepted' ? 'text-success' : 'text-danger')}} text-uppercase fw-bold">{{ $job->pivot->status }}</span>
            </p>

            <div class="d-flex justify-content-between">
                <a href="{{ route('client-viewpost', ['id' => $job->event->event_id]) }}" class="btn btn-link p-0" style="color: #91216C; text-decoration: none;">View Post</a>
                @if($job->pivot->status == 'Pending')
                <a href="#" class="btn btn-link p-0 text-danger" style="text-decoration: none;" wire:click="openModal({{ $job->job_id }})">Cancel</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>