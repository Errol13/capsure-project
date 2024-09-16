<!-- Modal Structure -->
<div class="modal" id="writeReviewModal_{{ $transaction_id }}" tabindex="-1" aria-labelledby="writeReviewLabel_{{ $transaction_id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">  <!-- Centered modal both vertically and horizontally -->
        <div class="modal-content">
            <div class="modal-header p-3 position-relative">
                <h5 class="modal-title w-100 text-center fw-bold" id="writeReviewLabel_{{ $transaction_id }}">Write your Review</h5>
            </div>
            <div class="modal-body text-center">
                <!-- User Info -->
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <img src="{{ asset('assets/profilepic.svg') }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 50px; height: 50px;">  <!-- Reduced profile pic size -->
                    <div class="text-start">
                        <h6 class="mb-0">{{ $client_name }}</h6> <!-- Dynamic client name -->
                        <p class="text-muted mb-0">Client</p>
                    </div>
                </div>
                <!-- Star Rating and Rating -->
                <div class="star-rating mt-1" id="starRating_{{ $transaction_id }}">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof">Rate:</p>
                            <span class="star" data-value="1">&#9734;</span>
                            <span class="star" data-value="2">&#9734;</span>
                            <span class="star" data-value="3">&#9734;</span>
                            <span class="star" data-value="4">&#9734;</span>
                            <span class="star" data-value="5">&#9734;</span>
                            <input type="hidden" id="rating_{{ $transaction_id }}" value="0">
                        </div>
                    </div>
                </div>
                <!-- Review Textarea -->
                <div class="mb-3">
                    <textarea class="form-control" id="reviewDetails_{{ $transaction_id }}" rows="3" maxlength="300" placeholder="Write your review..." style="font-size: 0.85rem;"></textarea>
                    <small class="form-text text-muted text-end d-block mt-1">0/300</small>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="confirm" data-bs-dismiss="modal" style="padding: 0.4rem 1.2rem;" onclick="submitReview('{{ $transaction_id }}')">Submit</button>
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

    .star-rating {
        cursor: pointer;
    }

    .star {
        font-size: 1.5rem;
        color: #ccc; /* Gray color for inactive stars */
        transition: color 0.2s;
    }

    .star.active, .star:hover, .star.hover {
        color: #f39c12; /* Yellow color for active stars */
    }

    .star-rating span {
        display: inline-block;
    }

    .star-rating span:hover ~ span,
    .star-rating span.hover ~ span {
        color: #f39c12; /* Yellow color for stars on hover */
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

<!-- JavaScript to handle star rating -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stars = document.querySelectorAll('#starRating_{{ $transaction_id }} .star');
        var ratingInput = document.getElementById('rating_{{ $transaction_id }}');

        stars.forEach(function(star) {
            star.addEventListener('mouseover', function() {
                var value = this.getAttribute('data-value');
                updateStars(value);
                this.classList.add('hover');
            });

            star.addEventListener('mouseout', function() {
                var value = ratingInput.value;
                updateStars(value);
                this.classList.remove('hover');
            });

            star.addEventListener('click', function() {
                var value = this.getAttribute('data-value');
                ratingInput.value = value;
                updateStars(value);
            });
        });

        function updateStars(rating) {
            stars.forEach(function(star) {
                if (parseInt(star.getAttribute('data-value')) <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }
    });

    function submitReview(transactionId) {
        var reviewText = document.getElementById('reviewDetails_' + transactionId).value;
        var rating = document.getElementById('rating_' + transactionId).value;
        // Perform the review submission process here, e.g., AJAX request or form submission
        console.log('Review for transaction ' + transactionId + ': ' + reviewText + ' with rating ' + rating);
    }
</script>
