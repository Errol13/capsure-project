
<!-- Confirmation Modal -->
<div class="modal fade" id="deleteModal-{{$event_id}}" tabindex="-1" aria-labelledby="deleteModalLabel-{{$event_id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-{{$event_id}}">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure you want to delete this event?</h5>
                
                <small class="note text-danger">This action cannot be undone.</small>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <!-- Delete Form -->
                <form action="{{ route('event-delete', ['id' => $event_id]) }}" method="POST">
                    @csrf
                    @method('DELETE') 
                    <button type="submit" class="btn btn-danger">Delete Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
