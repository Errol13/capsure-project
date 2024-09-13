<!-- Apply Job Modal -->
<div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
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
                        $completedHiredCount = $completedHiredCounts->get($eventJob->job_id, 0);
                        @endphp
                        @if($eventJob->number_of_people != $completedHiredCount)
                        <option value="{{ $eventJob->job_id }}">{{ $eventJob->service_needed }}</option>
                        @else
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

<!-- Response Modal -->
<div id="responseModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Application Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('apply-job-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = this;
            const formData = new FormData(form);
            const applyJobUrl = form.action; // Get the form action URL

            fetch(applyJobUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => {
                    // Log the raw response to the console
                    console.log('Response Status:', response.status);
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    console.log('Response Data:', data); // Log the response data to the console

                    const modalMessage = document.getElementById('modalMessage');
                    if (data.error) {
                        modalMessage.innerHTML = '<p class="text-danger">' + data.error + '</p>';
                        $('#responseModal').modal('show'); // Show the error modal
                    } else if (data.warning) {
                        modalMessage.innerHTML = '<p class="text-warning">' + data.warning + '</p>';
                        $('#responseModal').modal('show'); // Show the warning modal

                    } else if (data.conflict) {
                        console.log(data.event);
                        modalMessage.innerHTML = '<p class="text-danger">' + data.conflict + '</p>' +
                            '<p class="fs-6">' + 'Conflicting Event: ' + data.event + '</p>' +
                            '<p class="fs-6">' + 'Event Start Date: ' + data.start_date + '</p>' +
                            '<p class="fs-6">' + 'Event End Date: ' + data.end_date + '</p>';

                        // Close the applyJobModal
                        $('#applyJobModal').modal('hide');

                        $('#responseModal').modal('show'); // Show the warning modal

                    } else if (data.success) {
                        modalMessage.innerHTML = '<p class="text-success">' + data.success + '</p>';

                        // Close the applyJobModal
                        $('#applyJobModal').modal('hide');

                        // Show the responseModal
                        $('#responseModal').modal('show');

                        //Redirect after showing the responseModal
                        setTimeout(function() {
                            window.location.href = data.redirectUrl || window.location.href; // Redirect to a specific URL or refresh the page
                        }, 2000); // time before the action get done
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                });
        });
    });
</script>