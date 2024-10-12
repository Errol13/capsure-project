<div class="modal fade" id="modal-{{ $id }}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <form action="{{ $actionUrl }}" method="POST">
                    @csrf
                    @method($method)
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to handle form submission and AJAX request
        function handleFormSubmit(event) {
            event.preventDefault(); // Prevent default form submission
            const form = this; // Reference to the form that triggered this event
            const modal = new bootstrap.Modal(form.closest('.modal')); // Get the modal instance
            const formData = new FormData(form);
            const actionUrl = form.getAttribute('action');
            const method = form.querySelector('input[name="_method"]').value || 'POST';

            // Make the AJAX request using fetch
            fetch(actionUrl, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            // Handle JSON error messages
                            if (data.error) {
                                alert(data.error || 'An error occurred');
                                // Close the modal after the alert
                                setTimeout(() => {
                                    const closeButton = modal._element.querySelector('.btn-close'); // Get close button
                                    if (closeButton) {
                                        closeButton.click(); // Simulate click to close the modal
                                    }
                                }, 100);
                            } else {
                                window.location.reload(); // Reload the page 
                            }
                        });
                    } else {
                        // If not JSON, assume it's a redirect, so reload the page
                        window.location.reload();
                    }
                })
                .catch(error => {
                    // Handle network or other unexpected errors
                    alert('An unexpected error occurred. Please try again.');
                    console.error('Error:', error);
                    modal.hide(); // Close the modal when alert is shown
                });
        }

        // Select all buttons that trigger modals
        document.querySelectorAll('[data-modal-type="confirm-modal"]').forEach(button => {
            button.addEventListener('click', function(event) {
                let action = this.getAttribute('data-action');
                let hiringRequestId = this.getAttribute('data-hiringid');
                let modalId = this.getAttribute('data-bs-target'); // Get the modal ID

                let modal = document.querySelector(modalId);
                let title = modal.querySelector('.modal-title');
                let message = modal.querySelector('.modal-body');
                let form = modal.querySelector('form');

                // Update modal content based on the action
                if (action === 'decline') {
                    title.textContent = 'Confirmation';
                    message.textContent = 'Are you sure you want to decline this offer?';
                    form.setAttribute('action', `/hire/offer/decline/${hiringRequestId}`);
                    form.querySelector('input[name="_method"]').value = 'PATCH';
                } else if (action === 'accept') {
                    title.textContent = 'Confirm Accept Offer';
                    message.textContent = 'Are you sure you want to accept this offer?';
                    form.setAttribute('action', `/hire/offer/accept/${hiringRequestId}`);
                    form.querySelector('input[name="_method"]').value = 'POST';
                } else if (action === 'cancel') {
                    title.textContent = 'Confirm Cancellation';
                    message.textContent = 'Are you sure you want to cancel this offer?';
                    form.setAttribute('action', `/hire/offer/cancel/${hiringRequestId}`);
                    form.querySelector('input[name="_method"]').value = 'PATCH';
                }

                // Remove any previously bound event listeners to prevent duplicates
                const existingListener = form.getAttribute('data-listener-bound');
                if (!existingListener) {
                    form.addEventListener('submit', handleFormSubmit);
                    form.setAttribute('data-listener-bound', 'true'); // Set a flag indicating listener is bound
                }
            });
        });
    });
</script>