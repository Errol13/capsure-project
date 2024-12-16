<!-- Hire Modal -->
<div class="modal" id="hireTeamRecommModal-{{ $uniqueId }}" tabindex="-1" aria-labelledby="hireTeamRecommModalLabel-{{ $uniqueId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" style="height: auto; overflow-y: auto; overflow-x: hidden;">
                <form action="/team/send/hiring-request" method="POST" id="hire-from-team-recom-{{$uniqueId}}">
                    @csrf
                    <!-- Profile Section -->
                    <div class="d-flex mb-4 align-items-center">
                        <!-- Profile Image -->
                        <img src="{{ asset('storage/' . $team->team_profilepic) }}" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px;">
                        <!-- Profile Info -->
                        <div class="ms-3">
                            <h6 class="mb-0">{{ $team->team_name }}</h6>
                            <div class="d-flex align-items-center">
                                @if($team->avg_rating != 0)
                                <span class="text-warning">⭐</span>
                                <small class="fw-bold ms-1">{{ number_format($team->avg_rating, 1) }}</small>
                                @else
                                <span class="text-muted">No ratings yet</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Services List -->
                    <div class="list-group mb-4">
                        <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #EEEEEE;">
                            {{ $team->package_service }}
                            <span>₱{{ $team->package_price }}</span>
                        </div>
                    </div>

                    <!-- Hire as role -->
                    <div class="row d-flex  flex-column flex-md-row mb-1 align-items-center">
                        <div class="col">
                            <label for="eventjobsTeamHireRecomm-<?php echo $uniqueId; ?>" class="form-label">Select Job</label>
                        </div>
                        <div class="col">
                            <select class="border-secondary-subtle form-select" name="job_id" id="eventjobsTeamHireRecomm-<?php echo $uniqueId; ?>" onchange="updateHireAsRole('<?php echo $uniqueId; ?>')" required>
                                <option value="" selected disabled></option>
                                @foreach($job_services as $job)
                                @php
                                $completedHiredCount = $completedHiredCounts->get($job->job_id, 0);
                                @endphp
                                <option value="{{ $job->job_id }}" data-service-needed="{{ $job->service_needed }}"
                                    @if($job->number_of_people == $completedHiredCount) disabled @endif>
                                    {{ $job->service_needed }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="roleTeamHireRecomm-<?php echo $uniqueId; ?>" class="form-label">Hire as</label>
                        </div>
                        <div class="col">
                            <select class="border-secondary-subtle form-select" id="roleTeamHireRecomm-<?php echo $uniqueId; ?>" required disabled>
                                <option value="" selected disabled></option>
                                <option value="{{ $team->team_code }}" data-job-fee="{{ $team->package_price }}" data-job-title="{{ $team->package_service }}">
                                    {{ $team->package_service }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <p class="text-danger" id="noMatchingServiceMessage-{{ $uniqueId }}" style="display: none;">No matching available service</p>

                    <!-- Computed Fee (Fixed Fee) -->
                    <p class="fw-bold" id="recomm-team-computed-fee-<?php echo $uniqueId; ?>">Package Fee: ₱{{ $team->package_price }}</p>
                    <input type="hidden" name="freelancer_pricing" id="fee-hidden-<?php echo $uniqueId; ?>" value="{{ $team->package_price }}">

                    <!-- Offer Input -->
                    <div class="d-flex mb-1 justify-content-between align-items-center">
                        <label for="fee-<?php echo $uniqueId; ?>" class="me-1">Your Offer</label>
                        <div class="col input-group me-2" style="max-width: 50%;">
                            <input type="text" class="form-control" id="fee-<?php echo $uniqueId; ?>" name="client_pricing" value="₱{{ $team->package_price }}" required>
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt text-right"></i></button>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="d-flex mb-3 justify-content-between align-items-center">
                        <label for="payment-{{ $team->team_code }}" class="form-label">Payment Method</label>
                        <p class="text-uppercase fw-bold me-4">{{ $payment_method }}</p>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="team_code" value="{{ $team->team_code }}">
                    <input type="hidden" name="client_id" value="{{ auth()->user()->id }}">
                    

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center mb-1">
                        <button id="hireTeamRecommSubmit-<?php echo $uniqueId; ?>" type="submit" class="btn btn-seemore me-2" style="width: 120px; height: 35px;">Hire</button>
                        <button id="cancelTeamHireButton-{{$uniqueId}}" type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to update the "Hire as" role and check for matching services
    function updateHireAsRole(uniqueId) {
        // Get the selected job service needed
        const selectJob = document.getElementById('eventjobsTeamHireRecomm-' + uniqueId);
        const selectedOption = selectJob.options[selectJob.selectedIndex];
        const serviceNeeded = selectedOption ? selectedOption.getAttribute('data-service-needed') : '';

        const roleSelect = document.getElementById('roleTeamHireRecomm-' + uniqueId);
        const noMatchingMessage = document.getElementById('noMatchingServiceMessage-' + uniqueId);
        const submitButton = document.getElementById('hireTeamRecommSubmit-' + uniqueId);

        // Check if a job is selected and there is a corresponding service
        if (selectJob.value) {
            if (serviceNeeded && serviceNeeded === '{{ $team->package_service }}') {
                // Enable the "Hire as" select and hide the error message
                roleSelect.disabled = false;
                roleSelect.innerHTML = `
                <option value="{{ $team->team_code }}" data-job-fee="{{ $team->package_price }}" data-job-title="{{ $team->package_service }}">
                    {{ $team->package_service }}
                </option>
            `;
                noMatchingMessage.style.display = 'none'; // Hide error if there's a match
            } else {
                // Disable the "Hire as" select and show the error message
                roleSelect.disabled = true;
                roleSelect.innerHTML = `<option value="" disabled>No matching service</option>`;
                noMatchingMessage.style.display = 'block'; // Show error if no matching service
            }
        } else {
            // If no job is selected, reset and hide the error message
            roleSelect.disabled = true;
            roleSelect.innerHTML = `<option value="" selected disabled></option>`;
            noMatchingMessage.style.display = 'none'; // Hide error if no job selected
        }

        // Enable or disable the submit button and toggle classes
        const isButtonDisabled = !(selectJob.value && roleSelect.value);

        if (isButtonDisabled) {
            submitButton.classList.add('btn-secondary');
            submitButton.classList.remove('btn-seemore');
        } else {
            submitButton.classList.add('btn-seemore');
            submitButton.classList.remove('btn-secondary');
        }

        submitButton.disabled = isButtonDisabled;
    }



    document.addEventListener('DOMContentLoaded', function() {
        // Initial check when the modal opens
        updateHireAsRole('<?php echo $uniqueId; ?>');

        document.getElementById('cancelTeamHireButton-<?php echo $uniqueId; ?>').addEventListener('click', function() {
            document.getElementById('hire-from-team-recom-<?php echo $uniqueId; ?>').reset();
        });

        const form = document.getElementById('hire-from-team-recom-<?php echo $uniqueId; ?>');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form); // Create a FormData object from the form

            submitButton.textContent = 'Sending...';

            fetch('/team/send/hiring-request', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                    }
                })
                .then(response => {
                    // Check if the response's content-type is JSON
                    const contentType = response.headers.get('content-type');

                    if (contentType && contentType.includes('application/json')) {
                        // Parse and return JSON data if it's valid JSON
                        return response.json();
                    } else {
                        // If it's not JSON , trigger page reload
                        return null;
                    }
                })
                .then(data => {
                    if (data) {
                        // Handle the JSON response
                        if (data.success) {
                            alert(data.success);
                            window.location.reload(); // Reload the page on success
                        } else if (data.error) {
                            alert("Error: " + data.error); // Show error message
                        }
                    } else {
                        // If no data (not JSON), reload the page
                        window.location.reload();
                    }
                })
                .catch(error => {
                    alert('An unexpected error occurred.'); // Generic error message
                });
        });

    });
</script>