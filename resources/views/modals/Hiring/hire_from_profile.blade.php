<!-- Hire Modal -->
<div class="modal" id="hireDirectlyModal-{{ $uniqueId }}" tabindex="-1" aria-labelledby="hireDirectlyModalLabel-{{ $uniqueId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($events)
                <form action="{{route('freelancer.hire')}}" method="POST" id="hire-from-profile>
                    @csrf

                    <!-- Step 1: Event Selection -->
                    <div id=" hire-step-1-{{ $uniqueId }}">


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
                        <button type="button" class="btn btn-seemore rounded-pill w-25" style="color:white; background-color:#91216C;" onclick="goToStep2('{{ $uniqueId }}')">Next</button>
                    </div>
            </div>

            <!-- Step 2: Hire Freelancer -->

            <div id="hire-step-2-{{ $uniqueId }}" style="max-height: 85dvh; overflow-y: auto; overflow-x: hidden; display:none;">
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
                    <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #EEEEEE;">
                        {{ $service->job_title }}
                        <span>₱{{ $service->job_fee }}{{ $service->fee_type }}</span>
                        <span class="{{ $service->isAvailable ? 'text-success' : 'text-danger' }}">
                            {{ $service->isAvailable ? 'Available' : 'Not Available' }}
                        </span>
                    </div>
                    @endforeach
                </div>

                <!-- Hire as role -->
                <div class="row d-flex mb-1 align-items-center">

                    <!-- Select Job -->
                    <div class="col">
                        <label for="eventjobsRecomm" class="form-label">Select Job</label>
                    </div>
                    <div class="col">
                        <select class="border-secondary-subtle form-select" name="job_id" id="eventjobsRecomm" required>

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
                            <option value="{{ $service->id }}" data-job-fee="{{ $service->job_fee }}" data-fee-type="{{$service->fee_type}}">
                                {{ $service->job_title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- Computed Fee -->
                <p class="fw-bold" id="recomm-computed-fee-<?php echo $uniqueId; ?>">Computed Fee: ₱0.00</p>
                <input type="hidden" name="freelancer_pricing" id="fee-hidden-<?php echo $uniqueId; ?>" value="0">

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
                    <button type="submit" class="btn btn-seeprof w-25 me-2 " style="color:white; background-color:#91216C;">Hire</button>
                    <button type="button" class="btn btn-secondary w-25" onclick="goToStep1('{{ $uniqueId }}')">Back</button>
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
                    // Update durationInHours with the response from the server
                    durationInHours = data.durationInHours;

                    const job_services = data.event_jobs; // Event jobs data

                    // Populate the job selection dropdown
                    const jobSelect = document.getElementById('eventjobsRecomm');
                    jobSelect.innerHTML = ''; // Clear existing options

                    job_services.forEach(job => {
                        const option = document.createElement('option');
                        option.value = job.job_id; // Adjust based on your data structure
                        option.textContent = job.service_needed; // Adjust based on your data structure
                        option.setAttribute('data-job-fee', job.fee); // Assuming job.fee exists
                        option.setAttribute('data-fee-type', job.fee_type); // Assuming fee_type exists
                        jobSelect.appendChild(option);
                    });

                    // Hide Step 1 and Show Step 2
                    document.getElementById('hire-step-1-' + uniqueId).style.display = 'none';
                    document.getElementById('hire-step-2-' + uniqueId).style.display = 'block';
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
        // Select all forms within modals (assuming multiple modals)
        document.querySelectorAll('.modal form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                // Prevent the default form submission to log details first
                event.preventDefault();

                // Create a FormData object from the form
                var formData = new FormData(form);

                // Log each form field and its value
                formData.forEach(function(value, key) {
                    console.log(key + ": " + value);
                });

                // Optionally delay the actual submission to see logs
                setTimeout(function() {
                    // Submit the form after logging
                    form.submit();
                }, 1000); // 1 second delay to check logs
            });
        });
    });
</script>