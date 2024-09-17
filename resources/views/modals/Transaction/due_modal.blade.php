<div class="modal fade" id="due{{$id}}" tabindex="-1" aria-labelledby="dueModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dueModalLabel">Event Due Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-danger">The event <strong>{{$eventTitle}}</strong> is due.</p>
        <small class="fs-6 mt-3">Cause of due:</small>
        <ul>
            @if($unsettledPayment)
            <li class="fs-6"> Unsettled payment</li>
            @endif
            @if($noReview)
            <li class="fs-6"> No review</li>
            @endif
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>