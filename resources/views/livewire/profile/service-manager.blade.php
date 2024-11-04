<div>
    <div class="text-end mt-1 d-flex align-items-center">
        <p class="mb-0 me-2 poppins-medium setting-color fs-5">Services</p>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i>
        </button>
    </div>

    @foreach ($services as $service)
    <div class="row mt-1 open-sans-reg" data-id="{{ $service->id }}">
        <div class="col">
            <input type="text" class="form-control fs-smaller fs-md"
                wire:model.defer="serviceData.{{ $service->id }}.title"
                readonly disabled>
        </div>
        <div class="col">
            <input type="text" class="form-control fs-smaller fs-md"
                wire:model.defer="serviceData.{{ $service->id }}.fee"
                @if($editingServiceId !=$service->id) readonly @endif>
        </div>
        <div class="col">
            <select class="form-control fs-smaller fs-md"
                wire:model.defer="serviceData.{{ $service->id }}.fee_type"
                @if($editingServiceId !=$service->id) disabled @endif>
                <option value="/hour">/hour</option>
                <option value="/project">/project</option>
            </select>
        </div>
        <div class="col-auto">

            <div class="d-flex justify-content-between align-items-center">
                @if ($editingServiceId == $service->id)
                <button type="button" wire:click="saveService" class="d-block d-md-none  btn-save bg-transparent border-0 p-0">
                    <i class="fs-5 fas fa-check p-2 text-primary me-2"></i> </button>
                <button type="button" class="d-block d-md-none bg-transparent border-0 p-0"
                    wire:click="resetFields"><i class="fs-5 bi bi-x-circle text-danger"></i></button>

                <!--for desktop -->
                <button type="button" wire:click="saveService" class="d-none d-md-block btn btn-primary me-2">
                    Save</button>
                <button type="button" class="d-none d-md-block btn btn-secondary"
                    wire:click="resetFields">Cancel</button>

                @else
                <button type="button" class="btn edit-btn"
                    wire:click="editService({{ $service->id }})">
                    <i class="fas fa-pen fs-6"></i>
                </button>
                @endif

                <button type="button" class="btn availability-toggle"
                    wire:click="toggleAvailability({{ $service->id }})">
                    <i class="fas fa-toggle-{{ $serviceData[$service->id]['isAvailable'] ? 'on text-success' : 'off text-danger' }} fs-6"></i>
                </button>
            </div>

        </div>
    </div>
    @endforeach

    @if ($showMessage)
    <div id="success-message" class="alert alert-success mt-2">
        {{ session('message') }}
    </div>
    @endif

</div>