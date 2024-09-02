<!-- resources/views/modals/conflict_modal.blade.php -->
<div class="modal fade" id="conflictModal" tabindex="-1" aria-labelledby="conflictModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="conflictModalLabel">Conflict Detected</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($conflictingEvent)
                <p>{{ $errorMessage }}</p>
                <p><strong>Conflicting Event Details:</strong></p>
                <p>Start Time: {{ $conflictingEvent->start_time }}</p>
                <p>End Time: {{ $conflictingEvent->end_time }}</p>
                <p>Event Name: {{ $conflictingEvent->name }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>