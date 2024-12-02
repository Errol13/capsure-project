<!-- Apply Job Modal -->
<div class="modal fade" id="applyJobTeamModal" tabindex="-1" aria-labelledby="applyJobTeamModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6 text-muted">Please select a Job you want to apply for and confirm the application.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="cancelTeamButton" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('team-apply') }}" method="POST" id="apply-job-team-form">
                    @csrf
                    <!-- Apply as a/an -->
                    <label for="team_service_id" class="form-label">Apply as a/an</label>
                    <select class="form-select border border-danger-subtle" id="team_service_id" name="team_service_id" required>
                        <option value="" disabled selected class="text-muted"></option>
                        <option value="{{ $team->team_id }}" data-job-title="{{ $team->package_service }}">
                            {{ $team->package_service }}
                        </option>
                    </select>

                    <!-- Available Job -->
                    <label for="job_available" class="form-label mt-3">Select Available Job</label>
                    <select class="form-select border border-danger-subtle" id="job_available" name="job_available" required>
                        <option value="" disabled selected class="text-muted"></option>
                        @foreach($eventJobs as $eventJob)
                        @php
                        $completedHiredCount = $completedHiredCounts->get($eventJob->job_id, 0);
                        @endphp
                        @if($eventJob->number_of_people != $completedHiredCount)
                        <option value="{{ $eventJob->job_id }}" data-job-service="{{ $eventJob->service_needed }}">{{ $eventJob->service_needed }}</option>
                        @else
                        <option value="{{ $eventJob->job_id }}" disabled>{{ $eventJob->service_needed }}</option>
                        @endif
                        @endforeach
                    </select>

                    <!-- Hidden input for passing the freelancer ID -->
                    <input type="hidden" id="user_id" name="user_id" value="{{ $team->team_code }}">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <!-- Confirm Application Button -->
                <button type="submit" id="confirm-team-application" form="apply-job-team-form" class="flex-grow-1 rounded-pill border-0 btn-cancel poppins-regular fw-light" disabled>
                    Confirm Application
                </button>
                <button id="cancelTeamButton" type="button" class="flex-grow-1 btn-seeprof" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Response Modal -->
<div id="responseTeamModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="responseTeamModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseTeamModalLabel">Application Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalTeamMessage">
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
        const applyAsSelect = document.getElementById('job_available'); // available services from event
        const serviceSelect = document.getElementById('team_service_id'); //the team's package service
        const confirmButton = document.getElementById('confirm-team-application');
        const servicesOptions = Array.from(applyAsSelect.options); // Store all service options

        // Function to check if both selects have valid selections
        function checkButtonState() {
            const isEventJobSelected = applyAsSelect.value !== "";
            const isTeamServiceSelected = serviceSelect.value !== "";
            const isEnabled = isEventJobSelected && isTeamServiceSelected // Check if both are selected 

            confirmButton.disabled = !isEnabled; // Enable button only if both are selected

            // Change button classes based on enabled state
            if (isEnabled) {
                confirmButton.classList.remove('btn-cancel');
                confirmButton.classList.add('btn-seemore');
            } else {
                confirmButton.classList.remove('btn-seemore');
                confirmButton.classList.add('btn-cancel');
            }
        }

        // Reset the form when cancelled
        document.getElementById('cancelTeamButton').addEventListener('click', function() {
            document.getElementById('apply-job-team-form').reset();
            checkButtonState(); // Recheck the button state when the modal is reset
        });

        // When job is selected, filter the service options and check button state
        serviceSelect.addEventListener('change', function() {
            const selectedJob = serviceSelect.options[serviceSelect.selectedIndex].text.toLowerCase(); // Get selected package service of team as text

            // Clear the current jobs options
            applyAsSelect.innerHTML = '<option value="" disabled selected class="text-muted"></option>';

            // Filter services based on the selected job
            let matchFound = false;
            servicesOptions.forEach(option => {
                const jobTitle = option.getAttribute('data-job-service');
                if (jobTitle) {
                    const jobTitleLower = jobTitle.toLowerCase(); // Convert to lowercase

                    // Only add options that match the selected job title
                    if (jobTitleLower === selectedJob) {
                        applyAsSelect.appendChild(option); // Add matching option back to the select element
                        matchFound = true;
                    }
                }
            });

            // If no matching services, add a "No matching service" option
            if (!matchFound) {
                const noMatchOption = document.createElement('option');
                noMatchOption.disabled = true;
                noMatchOption.textContent = 'No matching service available';
                applyAsSelect.appendChild(noMatchOption);
            }

            checkButtonState(); // Check button state after filtering
        });

        // Check button state when service selection changes
        applyAsSelect.addEventListener('change', function() {
            checkButtonState(); // Check button state when the service selection changes
        });

        // Check button state on both select change events
        serviceSelect.addEventListener('change', function() {
            checkButtonState();
        });

        // Initial check when modal is loaded
        checkButtonState();

        document.getElementById('apply-job-team-form').addEventListener('submit', function(event) {
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
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    const modalMessage = document.getElementById('modalTeamMessage');
                    if (data.error) {
                        modalMessage.innerHTML = '<p class="text-danger">' + data.error + '</p>';
                        $('#responseTeamModal').modal('show'); // Show the error modal
                    } else if (data.warning) {
                        modalMessage.innerHTML = '<p class="text-warning">' + data.warning + '</p>';
                        $('#responseTeamModal').modal('show'); // Show the warning modal
                    } else if (data.conflict) {
                        modalMessage.innerHTML = '<p class="text-danger">' + data.conflict + '</p>' +
                            '<p class="fs-6">' + 'Conflicting Event: ' + data.event + '</p>' +
                            '<p class="fs-6">' + 'Event Start Date: ' + data.start_date + '</p>' +
                            '<p class="fs-6">' + 'Event End Date: ' + data.end_date + '</p>';

                        // Close the applyJobTeamModal
                        $('#applyJobTeamModal').modal('hide');
                        $('#responseTeamModal').modal('show');
                    } else if (data.success){
                        modalMessage.innerHTML = '<p class="text-success">' + data.success + '</p>';
                        $('#responseTeamModal').modal('show');
                        document.getElementById('apply-job-team-form').reset();
                        setTimeout(() => {
                            $('#applyJobTeamModal').modal('hide');
                            $('#responseTeamModal').modal('hide');
                        }, 2000); // Hide both modals after 2 seconds
                    }else{
                        modalMessage.innerHTML = '<p class="text-danger">' + data.message + '</p>';
                        $('#responseTeamModal').modal('show'); // Show the error modal
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>