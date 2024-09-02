<div id="responseModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Application Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('apply-job-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const form = this;
        const formData = new FormData(form);
        const applyJobUrl = '/apply-job'; 

        fetch(applyJobUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            const modalMessage = document.getElementById('modalMessage');
            if (data.error) {
                modalMessage.innerHTML = '<p class="text-danger">' + data.error + '</p>';
            } else if (data.success) {
                modalMessage.innerHTML = '<p class="text-success">' + data.success + '</p>';
            }

            $('#responseModal').modal('show'); // Show the modal
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});



</script>
