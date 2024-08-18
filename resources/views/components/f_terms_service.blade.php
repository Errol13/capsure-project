<div class="container mt-2">
    <div class="accordion" id="termsAccordion">
        <!-- Accordion Item -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">Terms of Service</span>
                    <div class="d-flex align-items-start">
                        <!-- Edit Icon -->
                        <a href="#" class="text-decoration-none me-2">
                            <i class="fs-6 text-end fas fa-edit"></i>
                        </a>
                        <!-- Expand/Collapse Icon -->
                        <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
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