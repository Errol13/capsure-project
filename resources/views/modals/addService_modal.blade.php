<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service.add', ['id' => $freelancer_id]) }}" method="POST" id="add-service-form">
                    @csrf
                    <!-- Job Category -->
                    <div class="mb-3">
                        <label for="job_category" class="form-label mb-0">{{ __('Job Category') }}</label>
                        <select id="job_category" class="mx-1 form-select @error('job_category') is-invalid @enderror" name="job_category" required>
                            <option value="" disabled selected></option>
                            @foreach(array_keys($jobTitles) as $category)
                            <option value="{{ $category }}" {{ old('job_category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('job_category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Job Title -->
                    <div class="mb-3">
                        <label for="job_title" class="form-label mb-0">{{ __('Job Title') }}</label>
                        <select id="job_title" class="mx-1 form-select @error('job_title') is-invalid @enderror" name="job_title" required>
                            <option value="" disabled selected></option>
                            <!-- Options will be populated dynamically -->
                        </select>
                        <input type="text" id="custom_job_title" name="custom_job_title" class="form-control @error('custom_job_title') is-invalid @enderror" style="display:none;" placeholder="Enter Job Title" />
                        @error('custom_job_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="job_fee" class="form-label">Job Fee</label>
                                <input type="text" class="form-control" id="job_fee" name="job_fee">

                                @error('job_fee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="fee_type" class="form-label">Fee Type</label>
                                <select class="form-select" id="fee_type" name="fee_type">
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

                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="availability" class="form-label">Availability</label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-verify px-5">Add Service</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // initialize the variable with data from controller
    var jobTitles = <?php echo json_encode($jobTitles); ?>;

    document.getElementById('job_category').addEventListener('change', function() {
        var selectedCategory = this.value;
        var jobTitleSelect = document.getElementById('job_title');
        var customJobTitleInput = document.getElementById('custom_job_title');

        // Clear previous options and input field
        jobTitleSelect.innerHTML = '<option value="" disabled selected></option>';
        customJobTitleInput.style.display = 'none'; // Hide the custom job title input

        // Add job titles for the selected category
        if (jobTitles[selectedCategory]) {
            jobTitles[selectedCategory].forEach(function(title) {
                var option = document.createElement('option');
                option.value = title;
                option.text = title;
                jobTitleSelect.appendChild(option);
            });
        }

        // Add option for custom input
        var customOption = document.createElement('option');
        customOption.value = 'custom';
        customOption.text = 'Other (Please specify)';
        jobTitleSelect.appendChild(customOption);

        // Show the dropdown again
        jobTitleSelect.style.display = 'block'; // Ensure dropdown is visible
    });

    // Show custom input if 'Other' is selected
    document.getElementById('job_title').addEventListener('change', function() {
        var selectedJobTitle = this.value;
        var customJobTitleInput = document.getElementById('custom_job_title');

        if (selectedJobTitle === 'custom') {
            customJobTitleInput.style.display = 'block'; // Show the custom job title input
            this.style.display = 'none'; // Hide the dropdown
        } else {
            customJobTitleInput.style.display = 'none'; // Hide the custom job title input
            this.style.display = 'block'; // Ensure the dropdown is visible
        }
    });
</script>