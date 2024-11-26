<!-- confirm be a client modal -->
<div class="modal fade" id="confirmBeAClientModal" tabindex="-1" aria-labelledby="confirmBeAClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-be-clientLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-5 text-black d-flex flex-column justify-content-center align-items-center">
                <p>
                    Are you sure you want to become a Client?
                </p>
                <span class="text-danger fs-6">
                This action cannot be undone.
                </span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('freelancer-to-client') }}" id="confirmBeAClientButton" class="px-3 mx-2 py-2 rounded btn-seemore">Confirm</a>
            </div>
        </div>
    </div>
</div>