<!-- Modal Structure -->
<div class="modal" id="reviewFreelancerModal" tabindex="-1" aria-labelledby="reviewFreelancerLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">  <!-- Centered modal both vertically and horizontally -->
        <div class="modal-content">
            <div class="modal-header p-3 position-relative">
                <h5 class="modal-title w-100 text-center fw-bold" id="reviewFreelancerLabel">Write your Review</h5>
            </div>
            <div class="modal-body text-center">
                <!-- User Info -->
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <img src="{{ asset('assets/profilepic.svg') }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 50px; height: 50px;">  <!-- Reduced profile pic size -->
                    <div class="text-start">
                        <h6 class="mb-0">Melissa Dane Santos</h6>
                        <p class="text-muted mb-0">Client</p>
                    </div>
                </div>
                <!-- Star Rating and Rating -->
                <div class="star-rating mt-1">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof">Rate:</p>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                </div>
                <!-- Review Textarea -->
                <div class="mb-3">
                    <textarea class="form-control" id="otherDetails" rows="3" maxlength="300" placeholder="Write your review..." style="font-size: 0.85rem;"></textarea>
                    <small class="form-text text-muted text-end d-block mt-1">0/300</small>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="confirm" data-bs-dismiss="modal" style="padding: 0.4rem 1.2rem;">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Styles (CSS) -->
<style>
    /* Reduce modal content size */
    .modal-content {
        border-radius: 20px;
        padding: 15px;
    }

    /* Adjust modal width */
    .modal-dialog {
        max-width: 350px;  /* Set a fixed max width */
    }

    /* Center modal vertically and horizontally */
    .modal-dialog-centered {
        display: flex;
        align-items: center;  /* Align vertically */
        justify-content: center; /* Align horizontally */
    }

    .star-rating i {
        font-size: 1.2rem; /* Adjust star size to fit */
    }

    /* Reduce image size inside the modal */
    .rounded-circle {
        width: 50px;
        height: 50px;
    }

    /* Reduce textarea and button font sizes */
    textarea {
        font-size: 0.85rem;
    }

    .confirm {
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .modal-dialog {
            max-width: 400px;  /* Slightly larger for larger screens */
        }
    }
</style>
