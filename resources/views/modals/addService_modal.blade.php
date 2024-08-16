<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-service-form">
                    <div class="mb-3">
                        <label for="job_title" class="form-label">Job Title</label>
                        <input type="text" class="form-control" id="job_title" name="job_title">
                        @error('job_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="job_fee" class="form-label">Job Fee</label>
                        <input type="text" class="form-control" id="job_fee" name="job_fee">

                        @error('job_fee')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fee_type" class="form-label">Fee Type</label>
                        <select class="form-control" id="fee_type" name="fee_type">
                            <option value="" disabled selected></option>
                            <option value="/hour" {{ old('fee_type') == '/hour' ? 'selected' : '' }}>/hr</option>
                            <option value="/project" {{ old('fee_type') == '/project' ? 'selected' : '' }}>/project</option>
                        </select>

                        @error('fee_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="job_category" class="form-label">Job Category</label>
                        <select class="form-control" id="job_category" name="job_category">
                            <option value="" disabled selected></option>
                            <option value="Arts" {{ old('job_category') == 'Arts' ? 'selected' : '' }}>Arts</option>
                            <option value="Entertainment" {{ old('job_category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                            <option value="Event Planner" {{ old('job_category') == 'Event Planner' ? 'selected' : '' }}>Event Planner</option>
                            <option value="Food Service" {{ old('job_category') == 'Food Service' ? 'selected' : '' }}>Food Service</option>
                            <option value="Handicrafts" {{ old('job_category') == 'Handicrafts' ? 'selected' : '' }}>Handicrafts</option>
                            <option value="Online Services" {{ old('job_category') == 'Online Services' ? 'selected' : '' }}>Online Services</option>
                            <option value="Photography" {{ old('job_category') == 'Photography' ? 'selected' : '' }}>Photography</option>
                            <option value="Styling" {{ old('job_category') == 'Styling' ? 'selected' : '' }}>Styling</option>
                            <option value="Videography" {{ old('job_category') == 'Videography' ? 'selected' : '' }}>Videography</option>
                            <option value="Voice Talent" {{ old('job_category') == 'Voice Talent' ? 'selected' : '' }}>Voice Talent</option>

                            @error('job_category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-save px-4">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>