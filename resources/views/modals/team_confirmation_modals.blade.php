<!-- Modal -->
<div class="modal fade" id="TeamConfirmationModal-{{$action}}-{{$freelancer_id}}" tabindex="-1" aria-labelledby="TeamConfirmationModalLabel-{{$action}}-{{$freelancer_id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold {{$action === 'make-admin' ? 'text-warning' : 'text-danger' }}" id="TeamConfirmationModalLabel-{{$action}}-{{$freelancer_id}}">{{$modalTitle}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{$actionURL}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <h4 class="text-center"> Are you sure to do this action?</h4>

                    @if($action === 'make-admin' || $action === 'remove')
                    <input type="hidden" name="team_id" value="{{$team_id}}"></input>
                    <input type="hidden" name="freelancer_id" value="{{$freelancer_id}}"></input>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>