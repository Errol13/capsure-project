<!-- Hire Modal -->
<div class="modal" id="hireDirectlyModal-{{ $uniqueId }}" tabindex="-1" aria-labelledby="hireDirectlyModalLabel-{{ $uniqueId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2">
            <div class="modal-header pt-0" style="border-bottom: none;">
                <h3 class="poppins-medium">Hire Freelancer</h3>
                <button data-unique-id="{{$uniqueId}}" type="button" class="close-form-hire btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="goToStep1('{{ $uniqueId }}')"></button>
            </div>
            <div class="modal-body" style="height: auto; overflow-y: auto; overflow-x: hidden;">
                @if($events)
                <form action="{{route('freelancer.hire')}}" method="POST" id="hire-from-profile-{{$uniqueId}}">
                    @csrf

                    <!-- Step 1: Event Selection -->
                    <div id="hire-step-1-{{ $uniqueId }}">

                        <!-- Event Selection Dropdown -->
                        <div class="mb-4">
                            <label for="eventSelection" class="form-label">Choose Event:</label>
                            <select class="form-select" name="event_id" id="eventSelection-{{ $uniqueId }}" required>
                                <option value="" selected disabled>Select an event</option>
                                @foreach($events as $event)
                                <option value="{{ $event->event_id }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Next Button -->
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn me-2 " style="background-color: #91216C; border:none; color:white; width: 150px; height: 35px; white-space:nowrap;" onclick="goToStep2('{{ $uniqueId }}')">Next</button>
                        </div>
                    </div>

                    <!-- Step 2: Hire Freelancer -->

                    <div class="pt-0" id="hire-step-2-{{ $uniqueId }}" style="max-height: 85dvh; overflow-y: auto; overflow-x: hidden; display:none;">
                        <!-- Profile Section -->
                        <div class="d-flex mb-4 align-items-center">
                            <!-- Profile Image -->
                            <img src="{{ asset($freelancer->user->profile_image_url) }}" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px;">
                            <!-- Profile Info -->
                            <div class="ms-3">
                                <h6 class="mb-0">{{ $freelancer->user->first_name }} {{ $freelancer->user->last_name }}</h6>
                                <small class="text-muted mb-2">{{ $freelancer->user->city }}</small>
                                <div class="d-flex align-items-center">
                                    @if($freelancer->avg_rating != 0)
                                    <span class="text-warning">⭐</span>
                                    <small class="fw-bold ms-1">{{ number_format($freelancer->avg_rating, 1) }}</small>
                                    <small class="text-muted ms-2">{{$freelancer->reviews()->where('reviewee_role', 'freelancer')->count()}} Reviews</small>
                                    @else
                                    <span class="text-muted">No ratings yet</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Services List -->
                        <div class="list-group mb-4">
                            @foreach($freelancer->services as $service)
                            <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #FCF2F9;">
                                <span class="fw-bold">{{ $service->job_title }}</span>
                                <span>₱{{ $service->job_fee }}{{ $service->fee_type }}</span>
                                <span class="badge poppins-medium {{ $service->isAvailable ? 'text-success' : 'text-danger' }}">
                                    {{ $service->isAvailable ? 'Available' : 'Not Available' }}
                                </span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Hire as role -->
                        <div class="row d-flex mb-1 align-items-center">

                            <!-- Select Job -->
                            <div class="col">
                                <label for="eventjobsRecomm-{{$uniqueId}}" class="form-label">Select Job</label>
                            </div>
                            <div class="col">
                                <select class="border-secondary-subtle form-select" name="job_id" id="eventjobsRecomm-{{$uniqueId}}" required>

                                </select>
                            </div>

                            <div class="col">
                                <label for="roleRecomm-<?php echo $uniqueId; ?>" class="form-label">Hire as</label>
                            </div>
                            <div class="col">
                                <select class="border-secondary-subtle form-select" id="roleRecomm-<?php echo $uniqueId; ?>" onchange="updateFee('<?php echo $uniqueId; ?>')" required>
                                    <option value="" selected disabled></option>
                                    @foreach($freelancer->services as $service)
                                    @if($service->isAvailable == true)
                                    <option value="{{ $service->id }}" data-job-fee="{{ $service->job_fee }}" data-fee-type="{{$service->fee_type}}" data-job-title="{{$service->job_title}}">
                                        {{ $service->job_title }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <!-- Computed Fee -->
                        <span class="fw-bold" id="recomm-computed-fee-<?php echo $uniqueId; ?>">Computed Fee:<span style="color: mediumseagreen;"> ₱0.00</span></span><br>
                        <input type="hidden" name="freelancer_pricing" id="fee-hidden-<?php echo $uniqueId; ?>" value="0">
                        <span class="note">Note: Computed based on event duration and freelancer's rate</span>

                        <!-- Offer Input -->
                        <div class="d-flex mb-1 justify-content-between align-items-center">
                            <label for="fee-<?php echo $uniqueId; ?>" class="me-1">Your Offer</label>
                            <div class="col input-group me-2" style="max-width: 50%;">
                                <input type="text" class="form-control" id="fee-<?php echo $uniqueId; ?>" name="client_pricing" value="₱0.00" required>
                                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt text-right"></i></button>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="d-flex mb-3 justify-content-between align-items-center">
                            <label for="payment-{{ $freelancer->user_id }}" class="form-label">Payment Method</label>
                            <p class="text-uppercase fw-bold me-4">{{$event->payment_method}}</p>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="freelancer_id" value="{{ $freelancer->user_id }}">
                        <input type="hidden" name="client_id" value="{{ auth()->user()->id }}">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center mb-2">
                            <button id="hire-direct-button{{$uniqueId}}" type="submit" class="btn me-2 " style="background-color: #91216C; border:none; color:white; width: 150px; height: 35px; white-space:nowrap;" disabled>Send Hire Request</button>
                            <button data-unique-id="<?php echo $uniqueId; ?>" type="button" class="btn btn-secondary" style="width: 150px; height: 35px;" onclick="goToStep1('{{ $uniqueId }}')">Back</button>
                        </div>
                    </div>
                </form>

                @else
                <div class="d-flex align-items-center flex-column justify-content-center">
                    <p class="fs-4 text-muted">No Events Available</p>
                    <small class="text-center text-warning me-2">Please create an event post first.
                        <a href="{{ url('/events') }}" class="btn-seemore px-2 rounded-pill">Create Event Post</a>
                    </small>

                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let durationInHours = 0; // Initialize the global variable

    function goToStep2(uniqueId) {

        const eventSelect = document.getElementById('eventSelection-' + uniqueId);

        if (eventSelect && eventSelect.value) {
            const selectedEventId = eventSelect.value;

            fetch(`/profile/getselectedevents/${selectedEventId}`)
                .then(response => response.json())
                .then(data => {

                    console.log('Fetched data:', data);

                    // Update durationInHours with the response from the server
                    durationInHours = data.durationInHours;

                    const job_services = data.event_jobs; // Event jobs data
                    const completedHiredCounts = data.completedHiredCounts; // The hired freelancers count for each job

                    const hireServiceSelect = document.getElementById('roleRecomm-<?php echo $uniqueId; ?>'); //for the services of freelancer
                    const hireServicesOptions = Array.from(hireServiceSelect.options); // Store all service options
                    const confirmButton = document.getElementById('hire-direct-button<?php echo $uniqueId; ?>');

                    // Populate the job selection dropdown
                    const jobSelect = document.getElementById('eventjobsRecomm-<?php echo $uniqueId; ?>');
                    jobSelect.innerHTML = '<option value="" disabled selected class="text-muted"></option>'; // Clear existing options

                    job_services.forEach(job => {
                        const option = document.createElement('option');
                        option.value = job.job_id;
                        option.textContent = job.service_needed;

                        // Get the hired count for the job
                        const hiredCount = completedHiredCounts[job.job_id] || 0;
                        console.log(hiredCount);

                        // Check if the job is full and disable the option if true
                        if (hiredCount >= job.number_of_people) {
                            option.disabled = true; // Disable the option if job is full
                            option.textContent += ' (Full)'; // Add text indicating the job is full
                        }

                        jobSelect.appendChild(option);
                    });

                    // Function to check if both selects have valid selections
                    function checkButtonState() {
                        const isJobSelected = jobSelect.value !== "";
                        const isServiceSelected = hireServiceSelect.value !== "";
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
                        console.log('Hire button is ' + (isEnabled ? 'enabled' : 'disabled'));
                    }

                    // Hide Step 1 and Show Step 2
                    document.getElementById('hire-step-1-' + uniqueId).style.display = 'none';
                    document.getElementById('hire-step-2-' + uniqueId).style.display = 'block';

                    // Inside the jobSelect change event listener
                    jobSelect.addEventListener('change', function() {
                        checkButtonState(); // Check button state after selecting job

                        // Ensure jobSelect has a valid selection before accessing it
                        if (jobSelect.selectedIndex >= 0) {
                            const selectedJobHire = jobSelect.options[jobSelect.selectedIndex].text.toLowerCase(); // Get selected job name as text

                            // Clear the current service options
                            hireServiceSelect.innerHTML = '<option value="" disabled selected class="text-muted"></option>';

                            // Filter services based on the selected job
                            let matchFound = false;

                            hireServicesOptions.forEach(option => {
                                const jobTitle = option.getAttribute('data-job-title');

                                // Ensure jobTitle exists before calling toLowerCase
                                if (jobTitle) {
                                    const jobTitleLower = jobTitle.toLowerCase(); // Convert to lowercase

                                    console.log('Title:', jobTitleLower, 'Selected:', selectedJobHire);

                                    // Only add options that match the selected job title
                                    if (jobTitleLower === selectedJobHire) {
                                        hireServiceSelect.appendChild(option); // Add matching option back to the select element
                                        matchFound = true;
                                    }
                                }
                            });

                            // If no matching services, add a "No matching service" option
                            if (!matchFound) {
                                const noMatchOption = document.createElement('option');
                                noMatchOption.disabled = true;
                                noMatchOption.textContent = 'No matching service available';
                                hireServiceSelect.appendChild(noMatchOption);
                            }

                            checkButtonState(); // Check button state after filtering
                        }
                    });

                    // Check button state when the service selection changes
                    hireServiceSelect.addEventListener('change', function() {
                        checkButtonState();
                    });

                })
                .catch(error => {
                    console.error('Error fetching event details:', error);
                    alert('Failed to load event details. Please try again.');
                });
        } else {
            alert('Please select an event.');
        }
    }



    function goToStep1(uniqueId) {
        // Hide Step 2 and show Step 1
        document.getElementById('hire-step-2-' + uniqueId).style.display = 'none';
        document.getElementById('hire-step-1-' + uniqueId).style.display = 'block';
    }

    function updateFee(uniqueId) {
        const selectElement = document.getElementById('roleRecomm-' + uniqueId);
        if (!selectElement) {
            console.error('Select element not found for roleRecomm-' + uniqueId);
            return;
        }

        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const jobFee = parseFloat(selectedOption.getAttribute('data-job-fee')) || 0;
        const feeType = selectedOption.getAttribute('data-fee-type');

        let totalFee = 0;

        // Calculate total fee based on fee type
        if (feeType === '/hour') {
            totalFee = jobFee * (durationInHours > 0 ? durationInHours : 1);
        } else if (feeType === '/project') {
            totalFee = jobFee;
        }

        // Error handling for totalFee
        if (isNaN(totalFee)) {
            console.error('Total fee calculation error for roleRecomm-' + uniqueId);
            totalFee = 0;
        }

        const roundedFee = totalFee.toFixed(2);
        const formattedFee = parseFloat(roundedFee).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });


        document.getElementById('recomm-computed-fee-' + uniqueId).innerHTML = 'Computed Fee: ₱' + formattedFee;
        document.getElementById('fee-hidden-' + uniqueId).value = roundedFee;
        document.getElementById('fee-' + uniqueId).value = '₱' + formattedFee;
    }


    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.close-form-hire').forEach(function(button) {
            button.addEventListener('click', function() {
                var uniqueId = this.getAttribute('data-unique-id');
                document.getElementById('hire-from-profile-' + uniqueId).reset();
                document.getElementById('recomm-computed-fee-<?php echo $uniqueId; ?>').innerHTML = 'Computed Fee: ₱ 0.00';
            });
        });


        const form = document.getElementById('hire-from-profile-<?php echo $uniqueId; ?>');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form); // Create a FormData object from the form

            fetch('/hire/applicant', {
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
                    console.error('Error:', error);
                    alert('An unexpected error occurred.'); // Generic error message
                });
        });

    });
</script>