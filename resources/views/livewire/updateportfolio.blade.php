<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form wire:submit.prevent="updatePortfolio" id="albumForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Update Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Panel -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label for="albumSelect" class="form-label">Select Album</label>
                                <select id="albumSelect" wire:model="selectedAlbumId" class="form-select @error('selectedAlbumId') is-invalid @enderror" required>
                                    <option value="">Choose an album</option>
                                    @foreach($portfolios as $portfolio)
                                    <option value="{{ $portfolio->portfolio_id }}">{{ $portfolio->album_name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedAlbumId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <!-- File Input -->
                                <input type="file" id="fileUpload" wire:model="files" multiple accept="image/*,video/*" class="d-none" />
                                <!-- Custom Upload Button -->
                                <p class="poppins-light text-muted fs-6">Attach at least one (1) file. Maximum of 5</p>
                                <button type="button" class="btn btn-light w-100" onclick="document.getElementById('fileUpload').click();">
                                    <i class="fas fa-upload"></i> Upload Images/Videos
                                </button>
                                @if($errors->has('files'))
                                <div class="text-danger mt-2">
                                    <strong>{{ $errors->first('files') }}</strong>
                                </div>
                                @endif
                                @if(count($files) > 5)
                                <div class="text-danger mt-2">
                                    <strong>You can only upload up to 5 files.</strong>
                                </div>
                                @endif
                                <div id="filePreviewContainer" class="mt-3">
                                    @foreach($files as $index => $file)
                                    <div class="position-relative m-2">
                                        @if($file->getMimeType() === 'image/jpeg' || $file->getMimeType() === 'image/png' || $file->getMimeType() === 'image/gif')
                                        <img src="{{ $file->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;">
                                        @elseif(strpos($file->getMimeType(), 'video') !== false)
                                        <video src="{{ $file->temporaryUrl() }}" controls class="img-fluid rounded" style="max-width: 200px;"></video>
                                        @endif
                                        <button type="button" class="position-absolute top-0 end-0 btn btn-danger btn-sm" wire:click="removeFile({{ $index }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-2">Update</button>
                            </div>
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
    document.addEventListener('livewire:load', function() {
    var uploadModal = document.getElementById('uploadModal');

    // Handle modal hide event to reset form
    uploadModal.addEventListener('hidden.bs.modal', function() {
        Livewire.emit('resetForm');
    });
});

</script>