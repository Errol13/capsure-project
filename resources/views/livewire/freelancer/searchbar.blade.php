<!-- Search Engine Button -->
<div class="col-md-12 col-lg-12 col-sm-12">
    <div class="search-container justify-content-center align-items-center rounded-4 px-3 ">
        <!-- search bar -->
        <div class="input-group search-bar mt-3 mb-3 position-relative">
            <input type="text" class="form-control fw-lighter rounded-5 py-1 py-md-2" placeholder="Find a Job or Event"
                wire:model.debounce.500ms="query" style="padding-right: 50px;">
            <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;">
                <a href="#" class="text-black text-decoration-none"><i class="fas fa-search m-1 fs-5" wire:click="search"></i></a>
                <i class="fas fa-filter m-3 fs-5" data-bs-toggle="modal" data-bs-target="#filterModal"></i>
            </span>
        </div>

        <!-- Filter Modal -->
        <div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog d-flex modal-sm modal-lg position-center py-4 my-4 px-2">
                <div class="modal-content rounded-4" style="max-height: 85dvh; overflow-y: auto;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 poppins-medium" id="filterModalLabel">Filter Options</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Filter Form -->
                        <form>
                            <!-- Job Category Filter -->
                            <div class="mb-3 text-start">
                                <h5 class="poppins-regular">Job Category</h5>
                                <div class="row">
                                    <div class="col">
                                        @foreach(['Any Category', 'Art', 'Entertainment', 'Photography', 'Voice Talent', 'Stylist'] as $jobCategory)
                                        <label>
                                            <input type="radio" name="jobCategory" value="{{ $jobCategory }}" wire:model="jobCategory"> {{ $jobCategory }}
                                        </label><br>
                                        @endforeach
                                    </div>
                                    <div class="col">
                                        @foreach(['Food Service', 'Event Planner', 'Online Services', 'Videography', 'Handicrafts', 'Event Package'] as $jobCategory)
                                        <label>
                                            <input type="radio" name="jobCategory" value="{{ $jobCategory }}" wire:model="jobCategory"> {{ $jobCategory }}
                                        </label><br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Budget Fee Range -->
                            <div class="mb-3 text-start">
                                <h5 class="poppins-regular">Budget Fee Range</h5>
                                @foreach(['Any' => 'any-range', '₱1,000 and below' => '1000', '₱1,000 - ₱5,000' => '5000', '₱5,000 - ₱10,000' => '10000', '₱10,000 and above' => 'above'] as $label => $value)
                                <label>
                                    <input type="radio" name="budgetRange" value="{{ $value }}" wire:model="budgetRange"> {{ $label }}
                                </label><br>
                                @endforeach
                            </div>

                            <!-- Location -->
                            <div class="mb-3 text-start">
                                <h5 class="poppins-regular">Location</h5>
                                <select class="form-select" wire:model="location" style="border-radius: 12px; border-color: gray;">
                                    <option value="any">Any</option>
                                    @foreach($locationLists as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary poppins-medium" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary poppins-medium" wire:click="sendFilter">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        window.addEventListener('close-filter-modal', function() {
            $('#filterModal').modal('hide'); // Close the modal using jQuery
        });
    </script>

</div>