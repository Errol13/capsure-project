<!-- Team Terms of Services -->

<div class="modal fade" id="editTermsTeamModal" tabindex="-1" aria-labelledby="editTermsTeamLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('terms-edit') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="terms_and_conditions_t" class="form-label">Terms and Conditions</label>
                        <textarea class="form-control" id="terms_and_conditions_t" name="terms_of_services" rows="5" maxlength="500" required>{{ old('terms_of_services', $team->terms_of_services ?? '') }}</textarea>
                        <small class="form-text text-muted">Maximum 500 characters.</small>
                        <div class="text-end">
                            <span id="charCount_t">0</span>/500 characters
                        </div>
                    </div>

                    <input type="hidden" name="team_id" value="{{$team->team_id}}"></input>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="rounded btn-verify px-2">Save changes</button>
                    <button type="button" class="rounded btn-cancel px-2" id="cancelEditTerms" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to handle cancel behavior and character count -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('terms_and_conditions_t');
        const charCount = document.getElementById('charCount_t');
        let initialValue = textarea.value; // Save the initial value of the textarea

        textarea.addEventListener('input', function() {
            charCount.textContent = textarea.value.length;
        });

        // Initialize character count on load
        charCount.textContent = textarea.value.length;

        // Reset the textarea to its initial value when the modal is canceled
        document.getElementById('cancelEditTerms').addEventListener('click', function() {
            textarea.value = initialValue; // Revert the textarea value back to the initial value
            charCount.textContent = initialValue.length; // Update the character count
        });
    });
</script>