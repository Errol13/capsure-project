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
        // Select the modal by ID dynamically using Bootstrap's show.bs.modal event
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function(event) {
                let action = this.getAttribute('data-action');
                let hiringRequestId = this.getAttribute('data-hiringid')
                let modalId = this.getAttribute('data-bs-target'); // Get the modal ID

                let modal = document.querySelector(modalId);
                let title = modal.querySelector('.modal-title');
                let message = modal.querySelector('.modal-body');
                let form = modal.querySelector('form');

                console.log(hiringRequestId);

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
                }
                else if (action === 'cancel') {
                    title.textContent = 'Confirm Cancellation';
                    message.textContent = 'Are you sure you want to cancel this offer?';
                    form.setAttribute('action', `/hire/offer/cancel/${hiringRequestId}`);
                    form.querySelector('input[name="_method"]').value = 'PATCH';
                }
            });
        });
    });
</script>