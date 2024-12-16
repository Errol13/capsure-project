<!-- Modal -->
<div class="modal fade" id="editTermsDesktopModal" tabindex="-1" aria-labelledby="editTermsDesktopModalLabel" aria-hidden="true">
     <div class="modal-dialog ">
         <div class="modal-content">
             <form action="{{ route('terms.update', ['id' => $freelancer->user_id]) }}" method="POST">
                 @csrf
                 @method('PATCH')
                 <div class="modal-header">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="terms_and_conditions_dt" class="form-label">Terms and Conditions</label>
                         <textarea class="form-control" id="terms_and_conditions_dt" name="terms_and_conditions" rows="5" maxlength="500" required>{{ old('terms_and_conditions', $freelancer->terms_and_conditions ?? '') }}</textarea>
                         <small class="form-text text-muted">Maximum 500 characters.</small>
                         <div class="text-end">
                             <span id="charCount_dt">0</span>/500 characters
                         </div>
                     </div> 
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="rounded btn-cancel px-2" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="rounded btn-verify px-2">Save changes</button>
                 </div>
             </form>
         </div>
     </div>
 </div>


 <!-- JavaScript to update character count -->
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const textarea = document.getElementById('terms_and_conditions_dt');
         const charCount = document.getElementById('charCount_dt');

         textarea.addEventListener('input', function() {
             charCount.textContent = textarea.value.length;
         });

         // Initialize character count on load
         charCount.textContent = textarea.value.length;
     });
 </script>