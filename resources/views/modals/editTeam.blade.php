<!-- Edit Team Page -->

<div class="modal" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="editTeamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; padding: 20px;">
            <div class="modal-header py-0" style="border-bottom:none;">
                <h4 class="modal-title poppins-medium" id="editTeamLabel">Edit <span style="color: #91216C;">Team Page</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{route('team-edit')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Profile Picture Uploader -->
                            <label for="teamProfilePic">
                                <div style="width: 125px; height: 125px; border-radius: 50%; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; font-size: 1rem; color: #bdbdbd; cursor: pointer;">
                                    <img src="{{asset('storage/' .$team->team_profilepic)}}" alt="Profile Picture" class="rounded-circle img-fluid">
                                </div>
                            </label>
                            <input type="file" name="team_profilepic" id="teamProfilePic" accept="image/*" style="display:none;" required />
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="teamName">Team Name</label>
                                <input type="text" name="team_name" class="form-control" id="teamName" placeholder="Enter team name" style="border-radius: 10px; border: 1px solid #dcdcdc;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="packageName">Package Offer</label>
                                <input type="text" name="package_service" class="form-control" id="packageName" placeholder="Enter package name" style="border-radius: 10px; border: 1px solid #dcdcdc;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="packageFee">Total Package Fee</label>
                                <input type="number" name="package_price" class="form-control" id="packageFee" min="500" style="border-radius: 10px; border: 1px solid #dcdcdc;" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <button type="save" class="confirm me-2 w-50">Save</button>
                    <button type="button" class="confirm w-50" style="background-color:lightgrey; color:black;" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>