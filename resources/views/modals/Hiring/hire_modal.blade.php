<!-- Hire Modal -->
<div class="modal" id="hireModal-{{ $applicantId }}" tabindex="-1" aria-labelledby="hireModalLabel-{{ $applicantId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form action="/hire/applicant" method="POST" id="hire-from-jobapp-{{$applicantId}}">
                    @csrf
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
                        <div class="col">
                            <label for="role-<?php echo $applicantId; ?>" class="form-label">Hire as</label>
                        </div>
                        <div class="col">
                            <select class="form-select" id="role-<?php echo $applicantId; ?>" onchange="updateTheFee('<?php echo $applicantId; ?>')" required>
                                <option value="" selected disabled></option>
                                <option value="{{ $service->id }}" data-job-fee="{{ $service->job_fee }}" data-fee-type="{{$service->fee_type}}">
                                    {{ $service->job_title }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Computed Fee -->
                    <p class="fw-bold" id="computed-fee-<?php echo $applicantId; ?>">Computed Fee: ₱0.00</p>
                    <input type="hidden" name="freelancer_pricing" id="fee-hidden-<?php echo $applicantId; ?>" value="0">

                    <!-- Offer Input -->
                    <div class="d-flex mb-1 justify-content-between align-items-center">
                        <label for="fee-<?php echo $applicantId; ?>" class="me-1">Your Offer</label>
                        <div class="col input-group me-2" style="max-width: 50%;">
                            <input type="text" class="form-control" id="fee-<?php echo $applicantId; ?>" name="client_pricing" value="₱0.00" required>
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt text-right"></i></button>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="d-flex mb-3 justify-content-between align-items-center">
                        <label for="payment-{{ $applicantId }}" class="form-label">Payment Method</label>
                        <p class="text-uppercase fw-bold me-4">{{$payment_method}}</p>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="freelancer_id" value="{{ $freelancer->user_id }}">
                    <input type="hidden" name="client_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="job_id" value="{{$job_id}}">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center mb-1">
                        <button type="submit" class="btn me-2" id="hire-from-app-{{$applicantId}}" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Hire</button>
                        <button id="cancelJobApplication-{{$applicantId}}" type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const durationInHours = <?php echo json_encode($durationInHours ?? 0); ?>;

    function updateTheFee(applicantId) {
        const selectElement = document.getElementById('role-' + applicantId);
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        //get corresponding data from the selected option
        const jobFee = parseFloat(selectedOption.getAttribute('data-job-fee')) || 0;
        const feeType = selectedOption.getAttribute('data-fee-type');

        //compute for totalfee 
        let totalFee;

        // Check fee type and calculate total fee
        if (feeType === '/hour') {
            totalFee = jobFee * durationInHours;
        } else if (feeType === '/project') {
            totalFee = jobFee;
        }

        const roundedFee = totalFee.toFixed(2);
        const formattedFee = parseFloat(roundedFee).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.getElementById('computed-fee-' + applicantId).innerHTML = 'Computed Fee: ₱' + formattedFee;
        document.getElementById('fee-hidden-' + applicantId).value = roundedFee;
        document.getElementById('fee-' + applicantId).value = '₱' + formattedFee;
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Cancel button event listener
        document.getElementById('cancelJobApplication-<?php echo $applicantId; ?>').addEventListener('click', function() {
            document.getElementById('hire-from-jobapp-<?php echo $applicantId; ?>').reset(); // Reset the form
        });
        const form = document.getElementById('hire-from-jobapp-<?php echo $applicantId; ?>');
        
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            //disable the hire button
            const hireButton = document.getElementById('hire-from-app-<?php echo $applicantId; ?>');
            hireButton.disabled = true;
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