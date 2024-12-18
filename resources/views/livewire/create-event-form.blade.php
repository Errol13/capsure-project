<div class="container" wire:poll>
    <!-- Flash Message -->
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <div class="row d-flex justify-content-center pt-4">
        <div class="col-sm-12 col-md-9 col-lg-8 ">
            <div class="card p-4 shadow-sm rounded-4" style="background-color: white;">

                <!-- Title and Buttons Inside Form -->
                <form wire:submit.prevent="saveEvent">
                    <div class="align-items-center mb-3 open-sans-reg">
                        <h3 class="event-title text-purple text-center fw-bold">Create an Event</h3>
                        <small class="open-sans-reg my-2 text-danger text-start fst-italic">All fields are required.</small>
                    </div>
                    <!-- Event Information -->
                    <div class="form-group mb-3 open-sans-reg">
                        <label for="title">Title</label>
                        <input type="text" id="title" class="form-control" wire:model="title" placeholder="Enter event title">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                        <label for="description">Description:</label>
                        <textarea id="description" class="form-control" wire:model.debounce.500ms="description" rows="3" maxlength="500" placeholder="Enter event description" oninput="updateCharCount()"></textarea>
                        <small class="text-muted"><span id="charCount">{{ strlen($description) }}</span>/500</small>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                        <label>Location:</label>
                        <div class="row">
                            <div class="col-4">
                                <input type="text" id="street" class="form-control" wire:model="street" placeholder="St.">
                                @error('street') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <input type="text" id="barangay" class="form-control" wire:model="barangay" placeholder="Brgy.">
                                @error('barangay') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <input type="text" id="city" class="form-control" wire:model="city" placeholder="City">
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 open-sans-reg" style="color: #91216C; white-space:nowrap;">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-5 fs-sm">
                                <label for="start_date">Start Date & Time:</label>
                                <input type="datetime-local" id="start_date" class="form-control" wire:model="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                                @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="px-1 col-auto pt-4">-</div>
                            <div class="col-5">
                                <label for="end_date">End Date & Time:</label>
                                <input type="datetime-local" id="end_date" class="form-control" wire:model="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                                @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-3 open-sans-reg" style="color: #91216C;">
                        <div class="row">
                            <div class="col-8">
                                <label for="budget_min">Budget Range:</label>
                            </div>
                            <div class="col-3" style="white-space: nowrap; font-size:small;">
                                <label for="payment_method">Payment Method:</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="budget_min" class="form-control" wire:model="budget_min" min="20" placeholder="Min ₱">
                                @error('budget_min') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <input type="number" id="budget_max" class="form-control" wire:model.debounce.1000ms="budget_max" :min="budget_min" placeholder="Max ₱">
                                @error('budget_max') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <select id="payment_method" class="form-control" wire:model="payment_method">
                                    <option value="">Select</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Online">Online</option>
                                </select>
                                @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Job Information -->
                    <div class="form-group my-3 pt-3 open-sans-reg">
                        <div class="d-flex justify-content-start align-items-center mb-3">
                            <img src="{{ asset('assets/add_jobs.svg') }}" alt="add_jobs_icon" class="socmed-container me-2">
                            <span class="fs-5 poppins-medium">Add Job/s</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless create-event-table  ">
                                <thead>
                                    <tr class="text-center" style="white-space:nowrap;">
                                        <th scope="col col-sm-auto">Job Category</th>
                                        <th scope="col col-sm-auto">Service Needed</th>
                                        <th scope="col col-sm-auto">No. of People</th>
                                        <th scope="col col-sm-auto">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $index => $job)
                                    <tr style="border-bottom: 0.5px solid; border-color:lightgray; ">
                                        <td class="align-middle my-1 py-1 px-2">
                                            <select id="job_category" style="background-color:white;" class="form-select w-100" wire:model="jobs.{{ $index }}.job_category" wire:change="updateServiceDropdown({{ $index }})">
                                                <option value="">Select Category</option>
                                                @foreach(array_keys($jobTitles) as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                                @endforeach
                                            </select>
                                            @error("jobs.$index.job_category") <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="align-middle my-1 py-1 px-2">
                                            @if(isset($jobs[$index]['job_category']) && array_key_exists($jobs[$index]['job_category'], $jobTitles))
                                            @if($jobs[$index]['service_needed'] === 'Others' || (isset($jobs[$index]['custom_service_needed']) && $jobs[$index]['custom_service_needed'] !== ''))
                                            <!-- Input field when "Others" is selected or custom service input is provided -->
                                            <input type="text" class="transition form-control fs-6" wire:model="jobs.{{ $index }}.custom_service_needed" placeholder="Specify Other Service" wire:keydown.enter="validateServiceInput({{ $index }})">
                                            @else
                                            <!-- Dropdown for selecting services -->
                                            <select class="form-select transition" wire:model="jobs.{{ $index }}.service_needed" wire:change="checkOthersSelection({{ $index }})">
                                                <option value="" disabled>Select Service</option>
                                                @foreach ($jobs[$index]['available_services'] as $service)
                                                <option value="{{ $service }}">{{ $service }}</option>
                                                @endforeach
                                                <option value="Others">Others</option>
                                            </select>
                                            @endif
                                            @else
                                            <input type="text" class="form-control fs-6 transition" wire:model="jobs.{{ $index }}.custom_service_needed" placeholder="Eg. Photographer" data-autocomplete disabled>
                                            @endif

                                            @error("jobs.$index.custom_service_needed") <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>

                                        <td class="align-middle my-1 py-1">
                                            <input type="number" class="form-control"
                                                style="background-color:white;" wire:model="jobs.{{ $index }}.number_of_people" placeholder="1" min="1"
                                                @if(isset($jobs[$index]['job_category']) && $jobs[$index]['job_category']==='Package' )
                                                disabled
                                                @endif>
                                            @error("jobs.$index.number_of_people") <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="align-middle my-1 py-1">
                                            <button type="button" class="btn" wire:click="removeJob({{ $index }})"><i class="fas fa-trash text-danger"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn open-sans-reg mt-2" style="background-color: #8FE2ED; color: black; border: none; font-size: smaller;" wire:click="addJob">Add Job</button>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button class="confirm me-2 w-75" type="submit">Post</button>
                        <button type="button" class="btn-cancel w-75" onclick="cancelForm(event)">Cancel</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {

            const dataEl = document.getElementById('editor-data');
            if (dataEl) {
                const services = JSON.parse(dataEl.dataset.services);
                // console.log('Services:', services); // Verify if this is logged

                if (services && services.length > 0) {
                    $('input[data-autocomplete]').autocomplete({
                        source: services,
                        minLength: 2
                    });
                } else {
                    // console.warn('No services data available for autocomplete.');
                }
            } else {
                // console.warn('No data element found.');
            }
        });

        function cancelForm(event) {
            event.preventDefault();
            window.history.back();
        }

        function updateCharCount() {
            var description = document.getElementById('description').value;
            document.getElementById('charCount').innerText = description.length;
        }

        // Function to set the min date for start and end date inputs
        function setMinDateTime() {
            var currentDateTime = new Date().toISOString().slice(0, 16); // Get current date-time in the right format

            // Set min attribute for both start and end date inputs
            document.getElementById('start_date').setAttribute('min', currentDateTime);
            document.getElementById('end_date').setAttribute('min', currentDateTime);
        }

        // Initialize when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            setMinDateTime();
        });

        // Re-run when Livewire updates the page
        Livewire.on('inputUpdated', function() {
            setMinDateTime();
        });
    </script>

</div>