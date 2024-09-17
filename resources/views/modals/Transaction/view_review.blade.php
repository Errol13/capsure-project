<!-- Modal Structure -->
<div class="modal" id="reviewModal_{{ $transaction_id }}" tabindex="-1" aria-labelledby="reviewLabel_{{ $transaction_id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-header p-3 position-relative">
                <h5 class="modal-title w-100 text-center fw-bold" id="reviewLabel_{{ $transaction_id }}">Review Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- User Info -->
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <img src="{{ asset($reviewee->user->profile_image) }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 80px; height: 80px;">
                    <div class="text-start">
                        <h6 class="mb-0">{{ $reviewee->user->first_name }} {{ $reviewee->user->last_name }}</h6>
                        <p class="text-muted mb-0">{{ ucfirst($reviewee_role) }}</p>
                    </div>
                </div>
                <!-- Star Rating -->
                <div class="star-rating mt-1">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof">Rating:</p>
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $review->rating ? 'active' : '' }}" data-value="{{ $i }}">&#9733;</span>
                            @endfor
                        </div>
                    </div>
                </div>
                <!-- Review Text -->
                <div class="mb-3">
                    <p class="text-muted">{{ $review->content }}</p>
                </div>
                <!-- Review Date -->
                <p class="text-muted">Reviewed on: {{ \Carbon\Carbon::parse($review->review_date)->format('F j, Y') }}</p>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        max-width: 350px;
        /* Set a fixed max width */
    }

    /* Center modal vertically and horizontally */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        /* Align vertically */
        justify-content: center;
        /* Align horizontally */
    }

    .star-rating {
        cursor: default;
    }

    .star {
        font-size: 2.5rem;
        /* Increase star size */
        color: #ccc;
        /* Gray color for unfilled stars */
        transition: color 0.2s;
    }

    .star.active {
        color: #f39c12;
        /* Yellow color for filled stars */
    }

    .rounded-circle {
        width: 50px;
        height: 50px;
    }

    @media (min-width: 768px) {
        .modal-dialog {
            max-width: 400px;
            /* Slightly larger for larger screens */
        }
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var transactionId = <?php echo json_encode($transaction_id); ?>;
        var reviewRating = <?php echo json_encode($review->rating); ?>;

        var stars = document.querySelectorAll('#reviewModal_' + transactionId + ' .star');

        stars.forEach(function(star) {
            var value = parseInt(star.getAttribute('data-value'));
            if (value <= reviewRating) {
                star.classList.add('active');
                star.innerHTML = '★';
            } else {
                star.classList.remove('active');
                star.innerHTML = '☆';
            }
        });
    });
</script>

