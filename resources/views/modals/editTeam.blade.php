<!-- Edit Team Page -->

<div class="modal" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="editTeamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; padding: 20px;">
            <div class="modal-header py-0" style="border-bottom:none;">
                <h4 class="modal-title poppins-medium" id="editTeamLabel">Edit <span style="color: #91216C;">Team Page</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="editTeamForm" action="{{route('team-edit')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Profile Picture Uploader -->
                            <label for="teamProfilePic">
                                <div
                                    style="width: 125px; height: 125px; border-radius: 50%; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; font-size: 1rem; color: #bdbdbd; cursor: pointer;">
                                    <!-- Display existing profile picture if available -->
                                    @if($team->team_profilepic)
                                    <img
                                        src="{{ asset('storage/' . $team->team_profilepic) }}"
                                        alt="Profile Picture"
                                        class="rounded-circle img-fluid"
                                        id="profilePicPreview"
                                        data-default-profilepic="{{ asset('storage/' . $team->team_profilepic) }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                    <span>Upload Image</span>
                                    @endif
                                </div>
                            </label>
                            <input
                                type="file"
                                name="team_profilepic"
                                id="teamProfilePic"
                                accept="image/*"
                                style="display:none;"
                                onchange="previewImage(event)">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="teamName">Team Name</label>
                                <input
                                    type="text"
                                    name="team_name"
                                    class="form-control"
                                    id="teamName"
                                    placeholder="Enter team name"
                                    value="{{ old('team_name', $team->team_name) }}"
                                    style="border-radius: 10px; border: 1px solid #dcdcdc;"
                                    required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="packageName">Package Offer</label>
                                <input
                                    type="text"
                                    name="package_service"
                                    class="form-control"
                                    id="packageName"
                                    placeholder="Enter package name"
                                    value="{{ old('package_service', $team->package_service) }}"
                                    style="border-radius: 10px; border: 1px solid #dcdcdc;"
                                    required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="packageFee">Total Package Fee</label>
                                <input
                                    type="number"
                                    name="package_price"
                                    class="form-control"
                                    id="packageFee"
                                    min="500"
                                    value="{{ old('package_price', $team->package_price) }}"
                                    style="border-radius: 10px; border: 1px solid #dcdcdc;"
                                    required>
                            </div>

                            <input type="hidden" name="team_id" value="{{$team->team_id}}"></input>

                        </div>
                    </div>

                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <button type="save" class="confirm me-2 w-50">Save</button>
                    <button type="button" id="cancelEditTeam" class="confirm w-50" style="background-color:lightgrey; color:black;" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profilePicPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('cancelEditTeam').addEventListener('click', function() {
        const form = document.getElementById('editTeamForm');
        form.reset(); // Reset the form fields

        const defaultProfilePic = document.getElementById('profilePicPreview').getAttribute('data-default-profilepic');
        document.getElementById('profilePicPreview').src = defaultProfilePic;
    });
</script>