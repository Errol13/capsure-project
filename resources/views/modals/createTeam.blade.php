<!--Create Team Modal -->
<div class="modal" id="createTeamModal" tabindex="-1" role="dialog" aria-labelledby="createTeamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; padding: 20px;">
            <div class="modal-header py-0" style="border-bottom:none;">
                <h4 class="modal-title poppins-medium" id="createTeamLabel">Create <span style="color: #91216C;">Team Page</span></h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Profile Picture Uploader -->
                            <label for="teamProfilePic">
                                <div style="width: 125px; height: 125px; border-radius: 50%; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; font-size: 1rem; color: #bdbdbd; cursor: pointer;">
                                    Select Team Profile
                                </div>
                            </label>
                            <input type="file" id="teamProfilePic" accept="image/*" style="display:none;" />
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="teamName">Team Name</label>
                                <input type="text" class="form-control" id="teamName" placeholder="Enter team name" style="border-radius: 10px; border: 1px solid #dcdcdc;">
                            </div>
                            <div class="form-group mt-3">
                                <label for="packageFee">Total Package Fee</label>
                                <input type="text" class="form-control" id="packageFee" placeholder="Enter package fee" style="border-radius: 10px; border: 1px solid #dcdcdc;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="shortDescription">Short Description</label>
                        <textarea class="form-control" id="shortDescription" rows="3" placeholder="Enter short description" style="border-radius: 10px; border: 1px solid #dcdcdc;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <button type="button" class="confirm">
                    Create
                </button>
            </div>
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
