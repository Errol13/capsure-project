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
                @if($editingServiceId !=$service->id) readonly @endif>
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
            @if ($editingServiceId == $service->id)
            <button type="button" class="btn btn-primary"
                wire:click="saveService">Save</button>
            <button type="button" class="btn btn-secondary"
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
    @endforeach

    @if ($showMessage)
    <div id="success-message" class="alert alert-success mt-2">
        {{ session('message') }}
    </div>
    @endif

</div>