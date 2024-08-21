 <!-- Add New Service Button -->
 <div class="text-end mt-3 d-flex align-items-center">
     <p class="mb-0 me-2 poppins-medium">Terms of Service</p>
     <!-- Edit Icon -->
     <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editTermsModal">
         <i class="ms-0 me-4 fs-6 text-start fas fa-edit"></i>
     </button>
 </div>





 <div class="container mt-2">
     <div class="accordion" id="termsAccordion">
         <!-- Accordion Item -->
         <div class="accordion-item">
             <h2 class="accordion-header" id="headingOne">
                 <div class="d-flex justify-content-between align-items-center">
                     <span class="h6 mb-0">Terms of Service</span>

                     <div class="mx-auto"></div>
                     <!-- Expand/Collapse Icon -->
                     <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                         <i class="ms-5 text-end fas fa-chevron-down"></i>
                     </button>
                 </div>
             </h2>
             <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#termsAccordion">
                 <div class="accordion-body">
                     <p>
                         {{$freelancer->terms_and_conditions}}
                     </p>
                 </div>
             </div>
         </div>
     </div>
 </div>



 <!-- Modal -->
 <div class="modal fade" id="editTermsModal" tabindex="-1" aria-labelledby="editTermsModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <form action="{{ route('terms.update', ['id' => $freelancer->user_id]) }}" method="POST">
                 @csrf
                 @method('PATCH')
                 <div class="modal-header">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="terms_and_conditions" class="form-label">Terms and Conditions</label>
                         <textarea class="form-control" id="terms_and_conditions" name="terms_and_conditions" rows="5" maxlength="500" required>{{ old('terms_and_conditions', $freelancer->terms_and_conditions ?? '') }}</textarea>
                         <small class="form-text text-muted">Maximum 500 characters.</small>
                         <div class="text-end">
                             <span id="charCount">0</span>/500 characters
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Save changes</button>
                 </div>
             </form>
         </div>
     </div>
 </div>


 <!-- JavaScript to update character count -->
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const textarea = document.getElementById('terms_and_conditions');
         const charCount = document.getElementById('charCount');

         textarea.addEventListener('input', function() {
             charCount.textContent = textarea.value.length;
         });

         // Initialize character count on load
         charCount.textContent = textarea.value.length;
     });
 </script>