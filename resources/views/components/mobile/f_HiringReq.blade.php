<div class="d-md-none d-block">
    <div class="row">
        @forelse($hiringRequests as $job)
        <div class="col-12 mb-3"> <!-- Card for each hiring request -->
            <div class="card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ $job->eventjob->event->title }}</h5>
                        <a href="{{ route('client-viewpost', ['id' => $job->eventjob->event->event_id]) }}" class="btn btn-link pt-0" style="color: #91216C; white-space:nowrap;">
                            View Post
                        </a>
                    </div>

                    <p class="mb-1"><strong style="color: #91216C;">DATE & TIME:</strong> {{ $job->eventjob->event->start_date_formatted }} - {{ $job->eventjob->event->end_date_formatted }}</p>
                    <p class="mb-1"><strong style="color: #91216C;">LOCATION:</strong> {{ $job->eventjob->event->street }}, {{ $job->eventjob->event->barangay }}, {{ $job->eventjob->event->city }}</p>
                    <p class="mb-1"><strong style="color: #91216C;">BUDGET:</strong> ₱{{ $job->eventjob->event->budget_min }} - ₱{{ $job->eventjob->event->budget_max }}</p>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-uppercase fw-bold" style="color: #ad3d88;">Client's Fee Offer: ₱{{ $job->client_pricing }}</span>
                        <span class="text-uppercase fw-bold">My Fee: ₱{{ $job->freelancer_pricing }}</span>
                    </div>

                    <div class="d-flex flex-column">
                        @if($job->status != 'Rejected')
                            @if($job->dealer_user_type == 'freelancer' && $job->status != 'Accepted')
                                <a href="#" class="btn btn-save rounded mb-1 border-secondary-subtle" style="background-color:#D9D9D9; color: black; text-decoration: none;">Pending</a>
                            @elseif($job->dealer_user_type == 'client' && $job->status != 'Accepted')
                                <button data-bs-toggle="modal" data-bs-target="#modal-{{ $job->hiring_request_id }}" class="btn btn-primary mb-1 border-1 border-secondary-subtle" style="background-color:#8FE2ED; color:black;">Accept Offer</button>
                            @elseif($job->status == 'Accepted')
                                <a href="{{route('freelancer-transaction')}}" class="btn btn-primary mb-1 border-1 border-secondary-subtle" style="background-color:#8FE2ED; color:black;">View Transaction</a>
                            @endif

                            @if($job->status != 'Accepted')
                                <button data-bs-toggle="modal" data-bs-target="#negotiateModal-{{$job->hiring_request_id}}" class="btn-save rounded text-purple border-1 mb-1 text-black" style="text-decoration: none;">Negotiate</button>
                                <button data-bs-toggle="modal" data-bs-target="#modal-{{ $job->hiring_request_id }}" data-action="decline" data-hiringid="{{$job->hiring_request_id}}" class="btn-cancel rounded text-danger border-1" style="text-decoration: none;">Decline Offer</button>
                            @endif
                        @else
                            <button class="btn btn-danger mb-1 border-1 border-secondary-subtle" disabled style="color:white;">Offer Declined</button>
                        @endif

                        <!-- Modal components -->
                        <div wire:ignore>
                            <x-confirmation-modal
                                :id="$job->hiring_request_id"
                                title="Confirmation"
                                message="Are you sure you want to decline this offer?"
                                :actionUrl="''"
                                method="POST" />
                        </div>

                        <!-- Negotiate Modal-->
                        @livewire('negotiate-modal', ['hiringRequestId' => $job->hiring_request_id, 'service' => $job->serviceDetails])
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-muted text-center mt-4 fs-4">No Hiring Requests</div>
        @endforelse
    </div>
</div>
