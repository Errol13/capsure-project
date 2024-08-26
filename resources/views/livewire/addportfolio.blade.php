<!-- Modal -->
<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form wire:submit.prevent="save" id="albumForm" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="albumModalLabel">Create Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body d-flex flex-column" style="position: relative;">
                    <!-- Content -->
                    <div class="mb-4">
                        <input type="text" wire:model="album_name" class="form-control @error('album_name') is-invalid @enderror" placeholder="Add Album Title" required />
                        @error('album_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <!-- File Input -->
                        <input type="file" id="fileUpload" wire:model="files" multiple accept="image/*,video/*" class="d-none" />
                        <!-- Custom Upload Button -->
                        <p class="poppins-light text-muted fs-6">Attach at least one (1) file. Maximum of 10</p>
                        <button type="button" class="btn btn-light w-100" onclick="document.getElementById('fileUpload').click();">
                            <i class="fas fa-upload"></i> Upload Images/Videos
                        </button>
                        @if($errors->has('files'))
                        <div class="text-danger mt-2">
                            <strong>{{ $errors->first('files') }}</strong>
                        </div>
                        @endif
                        @if(count($files) > 10)
                        <div class="text-danger mt-2">
                            <strong>You can only upload up to 10 files.</strong>
                        </div>
                        @endif
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
                    <!-- Post Button -->
                    <button type="submit" class="btn btn-primary w-100 mt-2" style="position: relative; bottom: 20px;">Post</button>
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
        var albumModal = document.getElementById('albumModal');

        // Handle modal hide event to reset form
        albumModal.addEventListener('hidden.bs.modal', function() {
            Livewire.emit('resetForm');
        });
    });
</script>