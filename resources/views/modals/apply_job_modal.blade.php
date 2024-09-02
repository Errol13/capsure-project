<div class="modal" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6 text-muted">Please select a Job you want to apply for and confirm the application.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('job.apply') }}" method="POST" id="apply-job-form">
                    @csrf
                    <label for="apply_as" class="form-label">Select Available Job</label>
                    <select class="form-select border border-danger-subtle" id="apply_as" name="apply_as" required>
                        <option value="" disabled selected class="text-muted"></option>
                        @foreach($eventJobs as $eventJob)

                        @php
                        // Get the hired count for the current job, or default to 0 if not set
                        $completedHiredCount = $completedHiredCounts->get($eventJob->job_id, 0);
                        @endphp

                        @if($eventJob->number_of_people != $completedHiredCount)
                        <option value="{{ $eventJob->job_id }}">{{ $eventJob->service_needed }}</option>
                        @elseif($eventJob->number_of_people == $completedHiredCount)
                        <option value="{{ $eventJob->job_id }}" disabled>{{ $eventJob->service_needed }}</option>
                        @endif
                        @endforeach
                    </select>

                    <label for="service_id" class="form-label mt-3">Apply as a/an</label>
                    <select class="form-select border border-danger-subtle" id="service_id" name="service_id" required>
                        <option value="" disabled selected class="text-muted"></option>
                        @foreach($freelancer->services as $service)
                        <option value="{{ $service->id }}">{{ $service->job_title }}</option>
                        @endforeach
                    </select>


                    <!-- Hidden input for passing the freelancer ID -->
                    <input type="hidden" id="user_id" name="user_id" value="{{ $freelancer->user_id }}">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="submit" form="apply-job-form" class="flex-grow-1 rounded-pill border-0 btn-seemore poppins-regular fw-light">Confirm Application</button>
                <button type="button" class="flex-grow-1 btn-seeprof" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>


</div>