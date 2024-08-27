<!-- Modal for Adding Awards -->
<div class="modal fade" id="addAwardsModal" tabindex="-1" aria-labelledby="addAwardsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="award_title" class="form-label">Award Title</label>
                        <input type="text" class="form-control" id="award_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="award_date" class="form-label">Award Date</label>
                        <input type="date" class="form-control" id="award_date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="award_image" class="form-label">Award Image</label>
                        <input type="file" class="form-control" id="award_image" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Award</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Awards -->
<div class="modal fade" id="editAwardModal" tabindex="-1" aria-labelledby="editAwardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('certificates.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_award_id" name="cert_id">
                    <div class="mb-3">
                        <label for="edit_award_title" class="form-label">Edit Award Title</label>
                        <input type="text" class="form-control" id="edit_award_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_award_date" class="form-label">Edit Award Date</label>
                        <input type="date" class="form-control" id="edit_award_date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_award_image" class="form-label">Change Award Image</label>
                        <input type="file" class="form-control" id="edit_award_image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set up the Edit Award Modal
        var editAwardModal = document.getElementById('editAwardModal');
        editAwardModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');
            var date = button.getAttribute('data-date');
            var image = button.getAttribute('data-image');

            var awardIdField = editAwardModal.querySelector('#edit_award_id');
            var awardTitleField = editAwardModal.querySelector('#edit_award_title');
            var awardDateField = editAwardModal.querySelector('#edit_award_date');

            awardIdField.value = id; // Set the award id
            awardTitleField.value = title; // Set the award title
            awardDateField.value = date; // Set the award date
        });
    });

    function confirmDeleteAward(certId) {
        if (confirm('Are you sure you want to delete this award?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/certificates/delete';
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            var methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            var certField = document.createElement('input');
            certField.type = 'hidden';
            certField.name = 'cert_id';
            certField.value = certId;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(certField);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>