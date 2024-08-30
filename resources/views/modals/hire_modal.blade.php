<!-- Hire Modal -->
<div class="modal" id="hireModal" tabindex="-1" aria-labelledby="hireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex mb-4 align-items-center">
                    <!-- Profile Image -->
                    <img src="assets/profilepic.svg" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px;">

                    <!-- Profile Info -->
                    <div class="ms-3"> <!-- Add margin to the left of the text -->
                        <h6 class="mb-0">Daisy Maureen Dimasuay</h6>
                        <small class="text-muted mb-2">Naga City</small>
                        <div class="d-flex align-items-center">
                            <span class="text-warning">⭐</span>
                            <small class="fw-bold ms-1">5.0</small>
                            <small class="text-muted ms-2">(10) Reviews</small>
                        </div>
                    </div>
                </div>
                <div class="list-group mb-4">
                    <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #EEEEEE;">
                        Photographer <span>₱5000/project</span> <span class="text-success">Available</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Make-up Artist <span>₱5000/project</span> <span class="text-danger">Not Available</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center" style="background-color:#EEEEEE;">
                        Video Editor <span>₱5000/project</span> <span class="text-success">Available</span>
                    </div>
                </div>
                <div class="row d-flex mb-1 align-items-center">
                    <div class="col">
                        <label for="role" class="form-label">Hire as</label>
                    </div>
                    <div class="col">
                        <select class="form-select" id="role">
                            <option>Photographer</option>
                            <option>Make-up Artist</option>
                            <option>Video Editor</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex mb-1 align-items-center">
                    <label for="fee" class="me-3">Fee Offer</label>
                    <div class="col input-group me-2" style="max-width: 50%;">
                        <input type="text" class="form-control" id="fee" value="₱4000.00">
                        <button class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt text-right"></i></button>
                    </div>
                    <select class="form-select" id="per" style="max-width: 30%;">
                        <option>per project</option>
                        <option>per hour</option>
                    </select>
                </div>
                <div class=" row mb-3 align-items-center">
                    <div class="col">
                        <label for="payment" class="form-label">Payment Method</label>
                    </div>
                    <div class="col">
                        <select class="form-select" id="payment">
                            <option>CASH</option>
                            <option>CREDIT</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-1">
                    <button type="button" class="btn me-2" style="background-color: #91216C; border:none; color:white; width: 120px; height: 35px;">Hire</button>
                    <button type="button" class="btn btn-secondary" style="width: 120px; height: 35px;" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>