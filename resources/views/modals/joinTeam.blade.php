<!-- Join Team Modal -->
<div class="modal fade" id="joinTeamModal{{$view}}" tabindex="-1" aria-labelledby="joinTeamLabel{{$view}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; padding: 20px;">
            <div class="modal-header py-0" style="border-bottom:none;">
                <h4 class="modal-title poppins-medium" id="joinTeamLabel{{$view}}">Join a <span style="color: #91216C;">Team</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Ask the page creator for the team code, then enter it here.</p>
                <!-- Display error message -->
                @error('team_code')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
                <form action="{{route('team-join')}}" method="POST">
                    @csrf
                    <div class="d-flex">

                        <input type="text" minlength="6" maxlength="6"
                            pattern="[A-Za-z0-9]{6,}" name="team_code"
                            class="form-control" id="teamCodeInput{{$view}}" placeholder="Input the 6-length code"
                            style="height: 50px; width: 325px; border: 1px solid black;" required>
                        <button type="submit" class="btn ms-2" style="background-color: #91216C; color:white; height: 50px; white-space:nowrap">
                            Join Team
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($errors->has('team_code'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#joinTeamModal{{$view}}').modal('show');
    });
</script>
@endif