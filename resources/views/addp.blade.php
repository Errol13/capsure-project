<!-- Modal -->
<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form wire:submit.prevent="submit" enctype="multipart/form-data">
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
                                <input type="text" class="form-control @error('album_name') is-invalid @enderror"
                                    placeholder="Add Album Title" wire:model="album_name" id="albumName" required />
                                @error('album_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <!-- Hidden File Input -->
                                <input type="file" wire:model="files" class="d-none" multiple accept="image/*,video/*" />
                                <!-- Custom Upload Button -->
                                <button type="button" class="btn btn-light w-100" onclick="document.querySelector('input[type=file]').click();">
                                    <i class="fas fa-upload"></i> Upload Images/Files
                                </button>
                                <div id="filePreviewContainer" class="mt-3">
                                    @foreach($files as $file)
                                    <div class="position-relative m-2">
                                        @if($file->getClientMimeType() === 'image/jpeg' || $file->getClientMimeType() === 'image/png')
                                        <img src="{{ $file->temporaryUrl() }}" class="img-fluid rounded" style="max-width: 200px;">
                                        @elseif($file->getClientMimeType() === 'video/mp4')
                                        <video src="{{ $file->temporaryUrl() }}" controls class="img-fluid rounded" style="max-width: 200px;"></video>
                                        @endif
                                        <button type="button" wire:click="removeFile('{{ $file->getClientOriginalName() }}')" class="position-absolute top-0 end-0 btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
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