<!-- Modal -->
<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('albums.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="albumModalLabel">Create Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Panel -->
                        <div class="col-md-4">
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Add Album Title" name="album_name" />
                            </div>
                            <div class="mb-4">
                                <!-- File Input -->
                                <input type="file" id="fileUpload" name="files[]" class="form-control" multiple />
                                <button type="submit" class="btn btn-primary w-100 mt-2">Post</button>
                            </div>
                        </div>
                        <!-- Right Panel -->
                        <div class="col-md-8 d-flex justify-content-center align-items-center">
                            <!-- Display uploaded files preview here -->
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function previewFiles(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('filePreviewContainer');

        // Get current number of previews
        const existingPreviews = previewContainer.querySelectorAll('div.position-relative').length;
        const maxFiles = 5;

        // Limit number of files that can be added
        if (files.length + existingPreviews > maxFiles) {
            alert('You can only upload up to 5 files.');
            event.target.value = ''; // Clear the file input
            return;
        }

        Array.from(files).forEach(file => {
            if (existingPreviews >= maxFiles) return; // Stop if we reach the limit

            const reader = new FileReader();
            const fileDiv = document.createElement('div');
            fileDiv.classList.add('position-relative', 'm-2');

            reader.onload = function(e) {
                let mediaElement;

                if (file.type.startsWith('image/')) {
                    mediaElement = document.createElement('img');
                    mediaElement.src = e.target.result;
                    mediaElement.classList.add('img-fluid', 'rounded');
                    mediaElement.style.maxWidth = '200px'; // 
                } else if (file.type.startsWith('video/')) {
                    mediaElement = document.createElement('video');
                    mediaElement.src = e.target.result;
                    mediaElement.controls = true;
                    mediaElement.classList.add('img-fluid', 'rounded');
                    mediaElement.style.maxWidth = '200px'; 
                }

                fileDiv.appendChild(mediaElement);

                // Create and append remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('position-absolute', 'top-0', 'end-0', 'btn', 'btn-danger', 'btn-sm');
                removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
                removeButton.onclick = function() {
                    fileDiv.remove();
                };

                fileDiv.appendChild(removeButton);
                previewContainer.appendChild(fileDiv);
            };

            reader.readAsDataURL(file);
        });
    }
</script>