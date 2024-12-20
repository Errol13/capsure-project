<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form wire:submit.prevent="updatePortfolio" id="updateAlbumForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Update Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body d-flex">
                    <!-- Left Panel -->
                    <div class="flex-fill me-2" style="max-width: 40%;">
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
                            <input type="file" id="fileUploadUpdate" wire:model="newFiles" multiple accept="image/*,video/*" class="d-none" required onchange="handleUpdateFileChange()">
                            <!-- Custom Upload Button -->
                            <button type="button" class="btn-seeprof border-secondary-subtle w-100 fs-for-mobile text-wrap" onclick="document.getElementById('fileUploadUpdate').click();">
                                <i class="fas fa-upload"></i> Upload Images/Videos
                            </button>
                            <small class="poppins-light text-muted fs-for-mobile">Attach at least one (1) file. Maximum of 5</small>
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
                        </div>

                        <button type="submit" class="btn-verify rounded p-2 w-100 mt-2">Update</button>
                    </div>
                    <!-- Vertical Line -->
                    <div style="width: 1px; background-color: #dee2e6; margin: 0 10px;"></div>
                    <!-- Right Column for Previews -->
                    <div class="flex-fill" style="max-width: 60%;">
                        <div id="filePreviewContainer" class="d-flex flex-wrap mt-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach($files as $index => $file)
                            <div class="position-relative m-2" style="max-width: 200px;">
                                @if($file->getMimeType() === 'image/jpeg' || $file->getMimeType() === 'image/png' || $file->getMimeType() === 'image/gif')
                                <img src="{{ $file->temporaryUrl() }}" class="img-thumbnail rounded">
                                @elseif(strpos($file->getMimeType(), 'video') !== false)
                                <video src="{{ $file->temporaryUrl() }}" controls class="img-thumbnail rounded"></video>
                                @endif
                                <button type="button" class="position-absolute top-0 end-0 btn btn-danger btn-sm" wire:click="removeFile({{ $index }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            @endforeach
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

        window.handleUpdateFileChange = function() {
            Livewire.dispatch('filesUpdated');
        };

        // Handle modal hide event to reset form
        uploadModal.addEventListener('hidden.bs.modal', function() {
            Livewire.dispatch('resetForm');
        });
    });
</script>