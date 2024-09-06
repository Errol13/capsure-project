<!--Modal for closing the post -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to close this event post?</p>
            </div>
            <div class="modal-footer">
                <form id="cancel-form" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var confirmationModal = document.getElementById('confirmationModal');
    var form = document.getElementById('cancel-form');

    confirmationModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var eventId = button.getAttribute('data-event-id'); // Extract event ID from data-event-id attribute
        var actionUrl = "{{ route('eventpost.close', ':id') }}"; 
        actionUrl = actionUrl.replace(':id', eventId); // Replace placeholder with actual event ID

        form.setAttribute('action', actionUrl); // Set the form action dynamically
    });
});
</script>