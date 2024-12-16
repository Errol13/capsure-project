<!-- Hire Modal -->
<div class="modal" id="hireTeamAppModal-{{ $uniqueId }}" tabindex="-1" aria-labelledby="hireTeamAppModalLabel-{{ $uniqueId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" style="height: auto; overflow-y: auto; overflow-x: hidden;">
                <form action="/team/send/hiring-request" method="POST" id="hire-from-team-app-{{$uniqueId}}">
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

                    <!-- Hire as Role -->
                    <div class="row d-flex justify-content-center mb-3">
                        <label for="roleTeamHireApp-<?php echo $uniqueId; ?>" class="form-label">Hire as</label>
                        <div class="col-12">
                            <select class="form-select border-secondary-subtle" id="roleTeamHireApp-<?php echo $uniqueId; ?>" name="role" required>
                                <option value="{{ $team->team_code }}" selected>{{ $team->package_service }}</option>
                            </select>
                        </div>
                    </div>

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
                    <input type="hidden" name="job_id" value="{{$job_id}}">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center">
                        <button id="hireTeamAppSubmit-<?php echo $uniqueId; ?>" type="submit" class="btn btn-seemore me-2" style="width: 120px; height: 35px;">Hire</button>
                        <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('hire-from-team-app-<?php echo $uniqueId; ?>');
        const submitButton = document.getElementById('hireTeamAppSubmit-<?php echo $uniqueId; ?>');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission behavior

            // Show a loading state for the button
            submitButton.disabled = true;
            submitButton.textContent = 'Hiring...';

            const formData = new FormData(form); // Collect form data

            fetch('/team/send/hiring-request', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token
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
                })
                .finally(() => {
                    // Reset the button state
                    submitButton.disabled = false;
                    submitButton.textContent = 'Hire';
                });
        });
    });
</script>