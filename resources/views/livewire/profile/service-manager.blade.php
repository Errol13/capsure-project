<div class="my-2">
    <div class="text-end mt-1 d-flex align-items-center">
        <h5 class="mb-0 me-2 poppins-medium setting-color">Services</h5>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="fas fa-solid fa-circle-plus add-setting-clr fs-5"></i>
        </button>
    </div>

    @foreach ($services as $service)
    <div class="row mt-2 open-sans-reg g-1 rounded-2 p-1 align-items-center" style="background-color:white;" data-id="{{ $service->id }}">
        <div class="col-sm-4 col">
            <input type="text" class="form-control fs-smaller fs-md"
                wire:model.defer="serviceData.{{ $service->id }}.title"
                readonly disabled>
        </div>
        <div class="col-sm-3 col">
            <input type="text" class="form-control fs-smaller fs-md"
                wire:model.defer="serviceData.{{ $service->id }}.fee"
                @if($editingServiceId !=$service->id) readonly disabled @endif>
        </div>
        <div class="col-sm-2 col">
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
                <button type="button" wire:click="saveService" class="bg-transparent border-0 p-0">
                    <i class="fs-5 fas fa-check text-success mx-3"></i> </button>
                <button type="button" class="bg-transparent border-0 p-0"
                    wire:click="resetFields"><i class="fs-5 fas fa-xmark text-danger"></i></button>
                @else
                <button type="button" class="btn edit-btn mx-2"
                    wire:click="editService({{ $service->id }})">
                    <i class="fas fa-pen fs-6"></i>
                </button>
                @endif
                <button type="button" class="btn availability-toggle"
                    wire:click="toggleAvailability({{ $service->id }})">
                    <i class="fas fa-toggle-{{ $serviceData[$service->id]['isAvailable'] ? 'on text-success' : 'off text-danger' }} fs-4 "></i>
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