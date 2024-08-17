<!-- Modal -->
<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
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
                            <!-- Hidden File Input -->
                            <input type="file" id="photoUpload" class="d-none" onchange="previewImage(event)" accept="image/*" />
                            <button type="button" class="btn btn-light w-100" onclick="document.getElementById('photoUpload').click();">
                                <i class="fas fa-upload"></i> Upload Photos
                            </button>
                        </div>
                        <div class="mb-4">
                            <select class="form-select" name="cover_photo">
                                <option selected disabled>Select Service</option>
                                <!-- Dynamically populate services -->
                                @foreach ($user->freelancer->services as $service)
                                <option value="{{ $service->id }}">{{ $service->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Post</button>
                    </div>
                    <!-- Right Panel -->
                    <div class="col-md-8 d-flex justify-content-center align-items-center">
                        <!-- Display uploaded photo -->
                        <div id="photoPreviewContainer" class="d-none position-relative">
                            <img id="photoPreview" src="" alt="Uploaded Photo" class="img-fluid rounded" />
                            <button type="button" class="position-absolute top-0 end-0 btn btn-danger btn-sm" onclick="removeImage()">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById('photoPreviewContainer');
                const previewImage = document.getElementById('photoPreview');
                
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const previewContainer = document.getElementById('photoPreviewContainer');
        const previewImage = document.getElementById('photoPreview');
        
        previewImage.src = ''; // Clear the image source
        previewContainer.classList.add('d-none'); // Hide the preview container
        document.getElementById('photoUpload').value = ''; // Clear the file input
    }
</script>
