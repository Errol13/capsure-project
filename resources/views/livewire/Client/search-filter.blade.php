<div class="col-md-12 col-lg-12 col-sm-12 py-4">
    <div class="search-container rounded-4">
        <!-- Search bar -->
        <div class="input-group search-bar mt-3 mb-3 position-relative">
            <input type="text" class="form-control fw-lighter rounded-5 py-1 md-3" placeholder="What service do you need?"
                wire:model.debounce.500ms="query">
            <span class="input-group-text border-0 bg-transparent position-absolute end-0 mx-2 d-flex align-items-center">
                <a href="#" class="text-black text-decoration-none"><i class="fas fa-search m-2 fs-5" wire:click="search"></i></a>
                <i class="fas fa-filter m-2 fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
            </span>
        </div>

        <!-- Filter Options Modal -->
        <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content" style="max-height: 75dvh; overflow-y: auto;">
                    <div class="modal-header" style="border-bottom:none">
                        <h3 class="modal-title poppins-medium" id="exampleModalLabel">Filter Options</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Filter Form -->
                        <form>
                            <!-- Job Category Filter -->
                            <div class="col mb-3 text-start ms-4">
                                <h5 class="poppins-regular">Job Category</h5>
                                <div class="row">
                                    <div class="col">
                                        <label><input type="radio" name="category" value="any" wire:model="category"> Any Category</label><br>
                                        <label><input type="radio" name="category" value="Art" wire:model="category"> Art</label><br>
                                        <label><input type="radio" name="category" value="Entertainment" wire:model="category"> Entertainment</label><br>
                                        <label><input type="radio" name="category" value="Photography" wire:model="category"> Photography</label><br>
                                        <label><input type="radio" name="category" value="Voice" wire:model="category"> Voice Talent</label><br>
                                        <label><input type="radio" name="category" value="Stylist" wire:model="category"> Stylist</label><br>
                                    </div>
                                    <div class="col">
                                        <label><input type="radio" name="category" value="Food" wire:model="category"> Food Service</label><br>
                                        <label><input type="radio" name="category" value="Event" wire:model="category"> Event Planner</label><br>
                                        <label><input type="radio" name="category" value="Online" wire:model="category"> Online Services</label><br>
                                        <label><input type="radio" name="category" value="Videography" wire:model="category"> Videography</label><br>
                                        <label><input type="radio" name="category" value="Handicrafts" wire:model="category"> Handicrafts</label><br>
                                        <label><input type="radio" name="category" value="Package" wire:model="category"> Event Package</label><br>
                                    </div>
                                </div>
                            </div>
                            <!-- Additional Filters (Fee Type, Freelancer Type, etc.) -->
                            <div class="row text-start ms-3">
                                <div class="col mb-3">
                                    <h5 class="poppins-regular">Job Fee Type</h5>
                                    <label><input type="radio" name="fee-type" value="any-fee" wire:model="feeType"> Any</label><br>
                                    <label><input type="radio" name="fee-type" value="/hour" wire:model="feeType"> per hour</label><br>
                                    <label><input type="radio" name="fee-type" value="/project" wire:model="feeType"> per project</label><br>
                                </div>
                                <div class="col mb-3">
                                    <h5 class="poppins-regular">Freelancer Type</h5>
                                    <label><input type="radio" name="type" value="solo" wire:model="freelancerType"> Solo</label><br>
                                    <label><input type="radio" name="type" value="team" wire:model="freelancerType"> Team</label><br>
                                </div>
                            </div>
                            <div class="row text-start ms-3">
                                <div class="col mb-3">
                                    <h5 class="poppins-regular">Job Fee Range</h5>
                                    <label><input type="radio" name="fee-range" value="any-range" wire:model="feeRange"> Any</label><br>
                                    <label><input type="radio" name="fee-range" value="100" wire:model="feeRange"> ₱100 and below</label><br>
                                    <label><input type="radio" name="fee-range" value="500" wire:model="feeRange"> ₱100 - ₱500</label><br>
                                    <label><input type="radio" name="fee-range" value="1000" wire:model="feeRange"> ₱500 - ₱1000</label><br>
                                    <label><input type="radio" name="fee-range" value="above" wire:model="feeRange"> ₱1000 and above</label><br>
                                </div>
                                <div class="col mb-3">
                                    <h5 class="poppins-regular">Rating</h5>
                                    <label><input type="radio" name="rating" value="any-rate" wire:model="rating"> Any</label><br>
                                    <label><input type="radio" name="rating" value="2" wire:model="rating"> 2 stars and below</label><br>
                                    <label><input type="radio" name="rating" value="3" wire:model="rating"> 3 stars</label><br>
                                    <label><input type="radio" name="rating" value="4" wire:model="rating"> 4 stars</label><br>
                                    <label><input type="radio" name="rating" value="5" wire:model="rating"> 5 stars</label><br>
                                </div>
                            </div>
                            <div class="col mb-2 text-start mx-4">
                                <h5 class="poppins-regular">Location</h5>
                                <input type="text" class="form-control location" style="border-radius: 12px; border-color:gray;" placeholder="Put the location here" wire:model="location">
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
                console.log('Filters applied event received:', event.detail);

                // Use Bootstrap's method to hide the modal
                $('#exampleModal').modal('hide');
            });
        });
    </script>

</div>