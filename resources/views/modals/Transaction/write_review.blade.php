<!-- Modal Structure -->
<div class="modal" id="writeReviewModal_{{ $transaction_id }}" tabindex="-1" aria-labelledby="writeReviewLabel_{{ $transaction_id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-header p-3 position-relative">
                <h5 class="modal-title w-100 text-center fw-bold" id="writeReviewLabel_{{ $transaction_id }}">Write your Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <form id="reviewForm_{{ $transaction_id }}" action="{{ route('submit.review', ['id' => $transaction_id]) }}" method="POST">
                    @csrf
                    <!-- User Info -->
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <img src="{{ asset($reviewee->user->profile_image) }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 80px; height: 80px;">
                        <div class="text-start">
                            <h6 class="mb-0">{{$reviewee->user->first_name}} {{$reviewee->user->last_name}}</h6>
                            <p class="text-muted mb-0">{{ucfirst($reviewee_role)}}</p>
                        </div>
                    </div>
                    <!-- Star Rating -->
                    <div class="star-rating mt-1" id="starRating_{{ $transaction_id }}">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof">Rate:</p>
                                <span class="star" data-value="1">&#9734;</span>
                                <span class="star" data-value="2">&#9734;</span>
                                <span class="star" data-value="3">&#9734;</span>
                                <span class="star" data-value="4">&#9734;</span>
                                <span class="star" data-value="5">&#9734;</span>
                                <input type="hidden" id="rating_{{ $transaction_id }}" name="rating" value="0" required>
                            </div>
                        </div>
                    </div>
                    <!-- Review Textarea -->
                    <div class="mb-3">
                        <textarea
                            class="form-control border-3"
                            id="reviewDetails_{{ $transaction_id }}"
                            name="content"
                            rows="3"
                            maxlength="300"
                            placeholder="Write your review..."
                            style="font-size: 0.85rem;"
                            oninput="updateCharacterCount('{{ $transaction_id }}')"
                            required></textarea>
                        <small class="form-text text-muted text-end d-block mt-1" id="charCount_{{ $transaction_id }}">0/300</small>
                    </div>

                    @php
                    $review_date = Carbon\Carbon::now();
                    @endphp
                    <input type="hidden" name="review_date" value="{{ $review_date }}"></input>
                    <input type="hidden" name="reviewee_role" value="{{ $reviewee_role }}"></input>

                    @if($reviewee_role === 'freelancer' )
                    <input type="hidden" name="client_id"
                        value="{{ auth()->user()->id }}"></input>
                    <input type="hidden" name="freelancer_id" value="{{$reviewee->user_id}}"></input>
                    @else
                    <input type="hidden" name="client_id"
                        value="{{ $reviewee->user_id }}"></input>
                    <input type="hidden" name="freelancer_id" value="{{ auth()->user()->id }}"></input>
                    @endif

                </form>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="confirm" style="padding: 0.4rem 1.2rem;" onclick="submitReview('{{ $transaction_id }}')">Submit</button>
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
        cursor: pointer;
    }

    .star {
        font-size: 2.5rem;
        /* Increase star size */
        color: #ccc;
        /* Gray color for unfilled stars */
        transition: color 0.2s;
    }

    /* Active stars (clicked) will be yellow and filled inside */
    .star.active {
        color: #f39c12;
        /* Yellow color for filled stars */
    }

    /* On hover, stars will not show as unfilled once clicked */
    .star:hover {
        color: #f39c12;
        /* Maintain the yellow color on hover */
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
            max-width: 400px;
            /* Slightly larger for larger screens */
        }
    }
</style>



<!-- JavaScript to handle star rating and character count -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stars = document.querySelectorAll('#starRating_{{ $transaction_id }} .star');
        var ratingInput = document.getElementById('rating_{{ $transaction_id }}');

        stars.forEach(function(star) {
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
                    star.innerHTML = '★';
                } else {
                    star.classList.remove('active');
                    star.innerHTML = '☆';
                }
            });
        }

        window.updateCharacterCount = function(transactionId) {
            var textarea = document.getElementById('reviewDetails_' + transactionId);
            var charCountElement = document.getElementById('charCount_' + transactionId);
            var currentLength = textarea.value.length;
            charCountElement.textContent = currentLength + "/300";
        }

        window.submitReview = function(transactionId) {
            var form = document.getElementById('reviewForm_' + transactionId);
            var reviewText = document.getElementById('reviewDetails_' + transactionId).value;
            var rating = document.getElementById('rating_' + transactionId).value;

            if (reviewText.length === 0 || rating === "0") {
                alert("Please provide a rating and a review.");
            } else {
                form.submit(); // Submit the form
            }
        }
    });
</script>