<!--Create Team Modal -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="modal" id="createTeamModal{{$view}}" tabindex="-1" role="dialog" aria-labelledby="createTeamLabel{{$view}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; padding: 20px;">
            <div class="modal-header py-0" style="border-bottom:none;">
                <h4 class="modal-title poppins-medium" id="createTeamLabel{{$view}}">Create <span style="color: #91216C;">Team Page</span></h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{route('team-create')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Profile Picture Uploader -->
                            <label for="teamProfilePic">
                                <div style="width: 125px; height: 125px; border-radius: 50%; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; font-size: 1rem; color: #bdbdbd; cursor: pointer;">
                                    Select Team Profile
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
                    <div class="form-group mt-3">
                        <label for="shortDescription">Short Description</label>
                        <textarea class="form-control" name="team_description" id="shortDescription" rows="3" placeholder="Enter short description" style="border-radius: 10px; border: 1px solid #dcdcdc;" required></textarea>
                    </div>

                    <smaller class="text-muted fs-smaller">Note: You can only be in one(1) team at a time.</smaller></br>
                    <smaller class="fs-smaller text-danger">All fields required.</smaller>

                    
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button  type="submit" class="confirm" >
                        Create
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Image Preview and Upload Script -->
<script>
    document.getElementById('teamProfilePic').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('label[for="teamProfilePic"] div').style.backgroundImage = `url(${e.target.result})`;
                document.querySelector('label[for="teamProfilePic"] div').style.backgroundSize = 'cover';
                document.querySelector('label[for="teamProfilePic"] div').style.backgroundPosition = 'center';
                document.querySelector('label[for="teamProfilePic"] div').textContent = '';
            };
            reader.readAsDataURL(file);
        }
    });
</script>