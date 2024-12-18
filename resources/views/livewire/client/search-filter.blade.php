<div class="col-md-12 col-lg-12 col-sm-12 py-4">
    <div class="search-container rounded-4">
        <!-- Search bar -->
        <div class="input-group search-bar mt-3 mb-3 position-relative">
            <input type="text" class="form-control fw-lighter rounded-5 py-1 md-3" placeholder="What service do you need?"
                wire:model.debounce.500ms="query" style="padding-right: 50px;">
            <span class="input-group-text border-0 bg-transparent position-absolute end-0 mx-2 d-flex align-items-center" style="z-index: 10;">
                <a href="#" class="text-black text-decoration-none">
                    <i class="fas fa-search m-2 fs-5" wire:click="search"></i>
                </a>
                <i class="fas fa-filter m-2 fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
            </span>
        </div>


        <!-- Filter Options Modal -->
        <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:none">
                        <h5 class="modal-title poppins-medium" id="exampleModalLabel">Filter Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Filter Form -->
                        <form>
                            <!-- Job Category Filter -->
                            <div class="col mb-3 text-start mx-4">
                                <h6 class="poppins-regular">Job Category</h6>
                                <select class="form-select border border-2 brdr-modal" wire:model="category">
                                    <option value="any">Any Category</option>
                                    <option value="Art">Art</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Photography">Photography</option>
                                    <option value="Voice">Voice Talent</option>
                                    <option value="Stylist">Stylist</option>
                                    <option value="Food">Food Service</option>
                                    <option value="Event">Event Planner</option>
                                    <option value="Online">Online Services</option>
                                    <option value="Videography">Videography</option>
                                    <option value="Handicrafts">Handicrafts</option>
                                    <option value="Package">Event Package</option>
                                </select>
                            </div>

                            <!-- Additional Filters -->
                            <div class="row text-start ms-3">
                                <div class="col mb-2">
                                    <h6 class="poppins-regular">Job Fee Type</h6>
                                    <select class="form-select border border-2" wire:model="feeType">
                                        <option value="any-fee">Any</option>
                                        <option value="/hour">Per Hour</option>
                                        <option value="/project">Per Project</option>
                                    </select>
                                </div>
                                <div class="col mb-2 me-4">
                                    <h6 class="poppins-regular">Freelancer Type</h6>
                                    <select class="form-select border border-2 " wire:model="freelancerType">
                                        <option value="solo">Solo</option>
                                        <option value="team">Team</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row text-start ms-3">
                                <div class="col mb-2">
                                    <h6 class="poppins-regular">Job Fee Range</h6>
                                    <select class="form-select border border-2 " wire:model="feeRange" >
                                        <option value="any-range">Any</option>
                                        <option value="100">₱100 and below</option>
                                        <option value="500">₱100 - ₱500</option>
                                        <option value="1000">₱500 - ₱1000</option>
                                        <option value="above">₱1000 and above</option>
                                    </select>
                                </div>
                                <div class="col mb-2 me-4">
                                    <h6 class="poppins-regular">Rating</h6>
                                    <select class="form-select border border-2 " wire:model="rating" >
                                        <option value="any-rate">Any</option>
                                        <option value="2">2 stars and below</option>
                                        <option value="3">3 stars</option>
                                        <option value="4">4 stars</option>
                                        <option value="5">5 stars</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col mb-0 text-start mx-4">
                                <h6 class="poppins-regular">Location</h6>
                                <select class="form-select border border-2 " wire:model="location" >
                                    <option value="any">Any</option>
                                    @foreach($locationLists as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="button" class="confirm w-25" style="height: 40px;" wire:click="applyFilters">Save</button>
                        <button type="button" class="cancel w-25" style="height: 40px;" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- create an event -->
        <a class="create-event-btn mb-2 shadow-btn rounded-pill open-sans-reg " href="{{ url('/events') }}" style="text-decoration: none;">
            Create an Event <i class="fas fa-party-horn"></i>
            <img src="assets/event.svg" class="inside-icon me-1">
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('filtersApplied', (event) => {
                // Use Bootstrap's method to hide the modal
                $('#exampleModal').modal('hide');
            });
        });
    </script>

</div>