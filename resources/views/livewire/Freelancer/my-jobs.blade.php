<div wire:poll.10s>
    <div class="container me-1">
        <div class="mt-4 mb-4">
            <h3 class=" mt-3 poppins-medium">My Jobs</h3>
        </div>

        <!-- Navigations -->
        <ul class="nav border-bottom-0 row row-cols-1 row-cols-md-3 justify-content-between pt-2 poppins-medium mb-3">
            <li class="nav-item col text-start mb-2 mb-md-0">
                <a wire:click="$set('activeTab', 'application')"
                    class="nav-link {{ $activeTab === 'application' ? 'active' : 'inactive' }} rounded-top-4 px-4 letter-spacing d-flex justify-content-between align-items-center"
                    style="background-color: white;" data-bs-toggle="tab" href="#application"
                    aria-controls="application" aria-selected="true">
                    APPLICATION <span class="badge text-black rounded-4"
                        style="background-color: #8FE2ED;">{{$appliedJobsCount}}</span>
                </a>
            </li>
            <li class="nav-item col text-center mb-2 mb-md-0">
                <a wire:click="$set('activeTab', 'hiring-request')"
                    class="nav-link {{ $activeTab === 'hiring-request' ? 'active' : 'inactive' }} rounded-top-4 px-4 letter-spacing d-flex justify-content-between align-items-center"
                    style="background-color: white;" data-bs-toggle="tab" href="#hiring-request"
                    aria-controls="hiring-request" aria-selected="false">
                    HIRE REQUEST <span class="badge text-black rounded-4"
                        style="background-color: #8FE2ED;">{{$hiringRequestsCount}}</span>
                </a>
            </li>
            <li class="nav-item col text-center">
                <a wire:click="$set('activeTab', 'recommendation')"
                    class="nav-link {{ $activeTab === 'recommendation' ? 'active' : 'inactive' }} rounded-top-4 px-4 letter-spacing d-flex justify-content-between align-items-center"
                    style="background-color: white;" data-bs-toggle="tab" href="#recommendation"
                    aria-controls="recommendation" aria-selected="false">
                    RECOMMENDATION <span class="badge text-black rounded-4"
                        style="background-color: #8FE2ED;">{{$recommendationsCount}}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Application Content ----------------------------------------------------------------------------------------------------------------------------------->
            <div class="tab-pane fade {{ $activeTab === 'application' ? 'show active' : '' }}" id="application"
                aria-labelledby="application-tab">

                @if($appliedJobs->isNotEmpty())
                <div class="row">
                    <!-- Jobs Applied -->
                    @foreach($appliedJobs as $job)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 rounded-4"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex justify-content-between align-items-center"
                                style="border-bottom: none;">
                                <div class="d-flex align-items-center">
                                    <small class="note">Applying as </small><br>
                                    <span class="fs-6 poppins-medium text-uppercase badge"
                                        style="color: #91216C;">{{ $job->service_needed }}</span>
                                </div> <span
                                    class="{{ $job->event->status == 'Open' ? 'bg-success' : 'bg-danger' }} badge text-uppercase">
                                    {{ $job->event->status }}</span>
                            </div>
                            <div class="card-body flex-grow-1">
                                <span class="fs-5 me-2 poppins-medium">{{ $job->event->title }}</span><br>
                                <strong class="note">Date & Time:</strong><br>
                                <span> {{ $job->event->start_date_formatted }} -
                                    {{ $job->event->end_date_formatted }}</span><br>
                                <strong class="note">Location:</strong><br>
                                <span> {{ $job->event->street }}, {{ $job->event->barangay }},
                                    {{ $job->event->city }}</span><br>
                                <strong class="note">Budget:</strong><br>
                                <span> ₱{{ $job->event->budget_min }} - ₱{{ $job->event->budget_max }}</span>
                            </div>

                            <!-- Divider Line -->
                            <hr class="my-1" style="margin-bottom: 0; border: 1px solid #ddd;">

                            <div class="mt-auto p-3 mb-2">
                                <div class="{{ $job->pivot->status == 'Pending' ? 'pending-color' : ($job->pivot->status == 'Accepted' ? 'text-success' : 'text-danger') }} btn-round mb-2 fw-bold"
                                    style="background-color:aliceblue; border-radius:0px;">
                                    {{ $job->pivot->status }}
                                </div>
                                <a href="{{ route('client-viewpost', ['id' => $job->event->event_id]) }}"
                                    class="confirm">View Post</a>
                                @if($job->pivot->status == 'Pending')
                                <a href="#" class="btn-round text-danger" style="border: 1px solid red;"
                                    wire:click="openModal({{ $job->job_id }})">Cancel</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Confirming Cancellation -->
                    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1"
                        aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static"
                        data-bs-keyboard="false" wire:ignore>
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" wire:click="closeModal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to cancel this job application?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        wire:click="confirmCancellation">Confirm</button>
                                    <button type="button" class="btn btn-secondary"
                                        wire:click="closeModal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center mt-5 text-muted fs-4">No Applications</p>
                @endif

            </div>

            <!-- Hiring Request Content --------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="tab-pane fade {{ $activeTab === 'hiring-request' ? 'show active' : '' }}" id="hiring-request"
                aria-labelledby="hiring-request-tab">

                @if($hiringRequests->isNotEmpty())
                <div class="row">
                    <!-- Job Offers -->
                    @foreach($hiringRequests as $job)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 rounded-4 d-flex flex-column"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex justify-content-between align-items-center"
                                style="border-bottom: none;">
                                <div class="d-flex align-items-center">
                                    <small class="note">Hiring as </small><br>
                                    <span class="fs-6 poppins-medium text-uppercase badge"
                                        style="color: #91216C;">{{$job->eventjob->service_needed}}</span>
                                </div>
                            </div>

                            <div class="card-body flex-grow-1">
                                <span class="fs-5 me-2 poppins-medium">{{ $job->eventjob->event->title }}</span><br>
                                <strong class="note">Date & Time:</strong><br>
                                <span> {{ $job->eventjob->event->start_date_formatted }} -
                                    {{ $job->eventjob->event->end_date_formatted }}</span><br>
                                <strong class="note">Location:</strong><br>
                                <span>{{ $job->eventjob->event->street }}, {{ $job->eventjob->event->barangay }},
                                    {{ $job->eventjob->event->city }}</span><br>
                                <strong class="note">Budget:</strong><br>
                                <span> ₱{{ $job->eventjob->event->budget_min }} -
                                    ₱{{ $job->eventjob->event->budget_max }}</span>
                            </div>

                            <!-- Divider Line -->
                            <hr class="my-1" style="margin-bottom: 0; border: 1px solid #ddd;">

                            <!-- Table and Buttons at Bottom -->
                            <div class="mt-auto p-3">
                                <table class="table table-borderless mb-2 w-100">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="note" style="white-space: nowrap;">Fee</th>
                                            <th class="note" style="white-space: nowrap;">Client's Offer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td>₱{{ $job->freelancer_pricing }}</td>
                                            <td>₱{{ $job->client_pricing }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-start">
                                    @if($job->status != 'Rejected')
                                    @if($job->dealer_user_type == 'freelancer' && $job->status != 'Accepted')
                                    <a href="#" class="btn-rounded pending-color"
                                        style="background-color: #D9D9D9;">Pending</a>

                                    @elseif($job->dealer_user_type == 'client' && $job->status != 'Accepted')
                                    <button data-bs-toggle="modal" data-bs-target="#modal-{{ $job->hiring_request_id }}"
                                        data-action="accept" data-modal-type="confirm-modal"
                                        data-hiringid="{{ $job->hiring_request_id }}" class="confirm me-2">Accept
                                    </button>

                                    @elseif($job->status == 'Accepted')
                                    <a href="{{route('freelancer-transaction')}}" class="confirm">View Transaction</a>
                                    @endif

                                    @if($job->status != 'Accepted')
                                    <button data-bs-toggle="modal"
                                        data-bs-target="#negotiateModal-{{$job->hiring_request_id}}"
                                        class="confirm me-2" style="background-color: #8FE2ED; color: black;">
                                        Negotiate
                                    </button>
                                    <button data-bs-toggle="modal" data-bs-target="#modal-{{ $job->hiring_request_id }}"
                                        data-modal-type="confirm-modal" data-action="decline"
                                        data-hiringid="{{ $job->hiring_request_id }}" class="confirm"
                                        style="background-color: crimson;">
                                        Decline
                                    </button>
                                    @endif

                                    @elseif($job->status == 'Rejected')
                                    <button class="confirm" disabled style="color: white; background-color:lightpink;">
                                        Offer Declined
                                    </button>
                                    @endif
                                </div>
                                <!--modal component -->
                                <div wire:ignore>
                                    <x-confirmation-modal :id="$job->hiring_request_id" title="Confirmation"
                                        message="Are you sure you want to decline this offer?" :actionUrl="''"
                                        method="POST" />
                                </div>

                                <!-- Negotiate Modal-->
                                @livewire('negotiate-modal', ['hiringRequestId' => $job->hiring_request_id,
                                'service' => $job->serviceDetails])
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted text-center mt-4 fs-4">No Hiring Requests</p>
                @endif
            </div>

            <!--Recommendation Content----------------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="tab-pane fade {{ $activeTab === 'recommendation' ? 'show active' : '' }}" id="recommendation"
                aria-labelledby="recommendation-tab">

                <!--If no recommendations-->
                @if($eventRecommendations->isNotEmpty())
                <div class="row">
                    @foreach($eventRecommendations as $event)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 rounded-4 d-flex flex-column"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex justify-content-center align-items-center"
                                style="border-bottom: none;">
                                <small class="note me-2">Service/s required:</small>
                                <div class="my-1">
                                    @foreach($event->event_jobs as $job)
                                    <span class="badge fs-6"
                                        style="background-color: #8FE2ED; color:#323232;">{{$job->service_needed}}</span>
                                </div> @endforeach
                            </div>

                            <div class="card-body flex-grow-1">
                                <span class="fs-5 me-2 poppins-medium">{{ $event->title }}</span><br>
                                <strong class="note">Date & Time:</strong><br>
                                <span> {{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</span><br>
                                <strong class="note">Location:</strong><br>
                                <span>{{ $event->street }}, {{ $event->barangay }}, {{ $event->city }}</span><br>
                                <strong class="note">Budget:</strong><br>
                                <span> ₱{{ $event->budget_min }} - ₱{{ $event->budget_max }}</span>
                            </div>
                            <div class="mt-auto p-3 mb-1">
                                <a href="{{ route('client-viewpost', ['id' => $job->event->event_id]) }}"
                                    class="confirm h-100">View Post</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted text-center mt-4 fs-4">No Available Events</p>
                @endif
            </div>
        </div>
    </div>

    <style>
        .nav-link.inactive {
            color: #B0B0B0;
        }

        .nav-link.active {
            color: #91216C;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmationModalElement = document.getElementById('deleteConfirmationModal');
            const confirmationModal = new bootstrap.Modal(confirmationModalElement);

            window.addEventListener('show-modal', function() {
                confirmationModal.show();
            });

            window.addEventListener('hide-modal', function() {
                confirmationModal.hide();
            });

            confirmationModalElement.addEventListener('hidden.bs.modal', function() {
                Livewire.emit('modalHidden'); // Optional: notify Livewire when modal is hidden
            });
        });
    </script>
</div>