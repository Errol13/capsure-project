<form action="/freelancer/services/delete/{{ $service->id }}" method="POST" id="delete-form-{{ $service->id }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<div class="container mt-2">
    <div class="accordion" id="termsAccordion{{$service->id}}">
        <!-- Accordion Item -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{$service->id}}">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0">{{$service->job_title}}</span>
                    <div class="mx-5"></div>
                    <!-- Expand/Collapse Icon -->
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$service->id}}" aria-expanded="false" aria-controls="collapse{{$service->id}}">
                        <i class="ms-5 text-end fas fa-chevron-down"></i>
                    </button>
                </div>
            </h2>
            <div id="collapse{{$service->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$service->id}}" data-bs-parent="#termsAccordion{{$service->id}}">
                <div class="accordion-body">
                    <form action="{{ route('service.update', ['id' => $service->id]) }}" method="POST" id="services-form-{{ $service->id }}">
                        @csrf
                        @method('PATCH')
                        <div id="services-list">
                            <div class="service-item" data-id="{{ $service->id }}">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="Job Title" class="form-label">Job Title</label>
                                        <input type="text" class="form-control" name="job_title" value="{{ $service->job_title }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="Job Fee" class="form-label">Job Fee</label>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input type="text" class="form-control me-0" name="job_fee" value="{{ $service->job_fee }}" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="fs-6 my-2 ms-0 text-start text-muted">pesos</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="Fee Type" class="form-label">Fee Type</label>
                                                <select name="fee_type" class="form-control" disabled>
                                                    <option value="" disabled {{ old('fee_type', $service->fee_type) === '' ? 'selected' : '' }}></option>
                                                    <option value="/hour" {{ old('fee_type', $service->fee_type) === '/hour' ? 'selected' : '' }}>/hr</option>
                                                    <option value="/project" {{ old('fee_type', $service->fee_type) === '/project' ? 'selected' : '' }}>/project</option>
                                                </select>
                                                @error('fee_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Job Category" class="form-label">Job Category</label>
                                        <select name="job_category" class="form-control" disabled>
                                            <option value="" {{ old('job_category', $service->job_category) ? '' : 'selected' }}></option>
                                            <option value="Arts" {{ old('job_category', $service->job_category) == 'Arts' ? 'selected' : '' }}>Arts</option>
                                            <option value="Entertainment" {{ old('job_category', $service->job_category) == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                            <option value="Event Planner" {{ old('job_category', $service->job_category) == 'Event Planner' ? 'selected' : '' }}>Event Planner</option>
                                            <option value="Food Service" {{ old('job_category', $service->job_category) == 'Food Service' ? 'selected' : '' }}>Food Service</option>
                                            <option value="Handicrafts" {{ old('job_category', $service->job_category) == 'Handicrafts' ? 'selected' : '' }}>Handicrafts</option>
                                            <option value="Online Services" {{ old('job_category', $service->job_category) == 'Online Services' ? 'selected' : '' }}>Online Services</option>
                                            <option value="Photography" {{ old('job_category', $service->job_category) == 'Photography' ? 'selected' : '' }}>Photography</option>
                                            <option value="Styling" {{ old('job_category', $service->job_category) == 'Styling' ? 'selected' : '' }}>Styling</option>
                                            <option value="Videography" {{ old('job_category', $service->job_category) == 'Videography' ? 'selected' : '' }}>Videography</option>
                                            <option value="Voice Talent" {{ old('job_category', $service->job_category) == 'Voice Talent' ? 'selected' : '' }}>Voice Talent</option>
                                        </select>
                                        @error('job_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Availability" class="form-label">Availability</label>
                                        <select name="availability" class="form-control" disabled>
                                            <option class="text-success" value="available" {{ $service->isAvailable ? 'selected' : '' }}>Available</option>
                                            <option class="text-danger" value="not_available" {{ !$service->isAvailable ? 'selected' : '' }}>Not Available</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <i class="fas fa-pen-to-square me-2" onclick="editService('{{ $service->id }}')"></i>
                                        <button type="button" class="btn px-0 " onclick="confirmDelete('{{ $service->id }}')"><i class="text-danger fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-primary d-none save-btn" id="save-btn-{{ $service->id }}" onclick="saveService('{{ $service->id }}')">Save</button>
                                    <button type="button" class="btn btn-secondary d-none cancel-btn" id="cancel-btn-{{ $service->id }}" onclick="cancelEdit('{{ $service->id }}')">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript to enable/disable edit mode as well as saving and deleting -->
<script>
    // For Services
    function editService(id) {
        const serviceItem = document.querySelector(`[data-id="${id}"]`);
        serviceItem.querySelectorAll('input, select').forEach((input) => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });
        serviceItem.querySelector('.save-btn').classList.remove('d-none');
        serviceItem.querySelector('.cancel-btn').classList.remove('d-none');
    }

    function cancelEdit(id) {
        const serviceItem = document.querySelector(`[data-id="${id}"]`);
        serviceItem.querySelectorAll('input, select').forEach((input) => {
            input.setAttribute('readonly', 'readonly');
            input.setAttribute('disabled', 'disabled');
        });
        serviceItem.querySelector('.save-btn').classList.add('d-none');
        serviceItem.querySelector('.cancel-btn').classList.add('d-none');
    }

    function confirmDelete(serviceId) {
        if (confirm('Are you sure you want to delete this service?')) {
            document.getElementById(`delete-form-${serviceId}`).submit();
        }
    }

    function saveService(serviceId) {
        console.log('saveService called with ID:', serviceId);

        const form = document.getElementById(`services-form-${serviceId}`);
        if (form) {
            form.submit();
        } else {
            console.error('Form not found for service ID:', serviceId);
        }
    }
</script>