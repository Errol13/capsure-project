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
                        <option value="{{ $eventJob->service_needed }}">{{ $eventJob->service_needed }}</option>
                        @else
                        <option value="{{ $eventJob->service_needed }}" disabled>{{ $eventJob->service_needed }}</option>
                        @endif
                        @endforeach
                    </select>

                    <label for="service_id" class="form-label mt-3">Apply as a/an</label>
                    <select class="form-select border border-danger-subtle" id="service_id" name="service_id" required>
                        <option value="" disabled selected class="text-muted"></option>
                        @foreach($freelancer->services as $service)
                        <option value="{{ $service->id }}" data-job-title="{{ $service->job_title }}">
                            {{ $service->job_title }}
                        </option>
                        @endforeach
                    </select>


                    <!-- Hidden input for passing the freelancer ID -->
                    <input type="hidden" id="user_id" name="user_id" value="{{ $freelancer->user_id }}">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <!-- Confirm Application Button -->
                <button type="submit" id="confirm-application" form="apply-job-form" class="flex-grow-1 rounded-pill border-0 btn-cancel poppins-regular fw-light" disabled>
                    Confirm Application
                </button>
                <button id="cancelButton" type="button" class="flex-grow-1 btn-seeprof" data-bs-dismiss="modal">Cancel</button>
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
        const applyAsSelect = document.getElementById('apply_as');
        const serviceSelect = document.getElementById('service_id');
        const confirmButton = document.getElementById('confirm-application');
        const servicesOptions = Array.from(serviceSelect.options); // Store all service options

        // Function to check if both selects have valid selections
        function checkButtonState() {
            const isJobSelected = applyAsSelect.value !== "";
            const isServiceSelected = serviceSelect.value !== "";
            const isEnabled = isJobSelected && isServiceSelected; // Check if both are selected
            
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

        //reset the form when cancelled
        document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('apply-job-form').reset();
    });

        applyAsSelect.addEventListener('change', function () {
            const selectedJob = applyAsSelect.options[applyAsSelect.selectedIndex].text.toLowerCase(); // Get selected job name as text

            // Clear the current service options
            serviceSelect.innerHTML = '<option value="" disabled selected class="text-muted"></option>';

            // Filter services based on the selected job
            let matchFound = false;
            servicesOptions.forEach(option => {
                const jobTitle = option.getAttribute('data-job-title');

                if (jobTitle) { 
                    const jobTitleLower = jobTitle.toLowerCase(); // Convert to lowercase
                    
                    // Only add options that match the selected job title
                    if (jobTitleLower === selectedJob) {
                        serviceSelect.appendChild(option); // Add matching option back to the select element
                        matchFound = true;
                    }
                }
            });

            // If no matching services, add a "No matching service" option
            if (!matchFound) {
                const noMatchOption = document.createElement('option');
                noMatchOption.disabled = true;
                noMatchOption.textContent = 'No matching service available';
                serviceSelect.appendChild(noMatchOption);
            }

            checkButtonState(); // Check button state after filtering
        });

        serviceSelect.addEventListener('change', function () {
            checkButtonState(); // Check button state when the service selection changes
        });


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