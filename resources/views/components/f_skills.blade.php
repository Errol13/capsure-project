
<div class="container mt-2">
    @if(empty($freelancer->skills))
    <p>Add skills to attract more clients.</p>
    @else
    <div class="accordion" id="skillsAccordion">
        <!-- Accordion Item for Skills -->
        <div class="accordion-item" style="background-color: white;">
            <h2 class="accordion-header" id="headingSkills">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0"></span>
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSkills" aria-expanded="false" aria-controls="collapseSkills">
                        <i class="ms-5 text-end fas fa-chevron-down collapse-icon" aria-hidden="true"></i>
                        <i class="ms-5 text-end fas fa-chevron-up collapse-icon d-none" aria-hidden="true"></i>
                    </button>
                </div>
            </h2>
            <div id="collapseSkills" class="accordion-collapse collapse" aria-labelledby="headingSkills" data-bs-parent="#skillsAccordion">
                <div class="accordion-body">
                    @foreach ($freelancer->skills as $skill)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <span class="me-2"><i class="fas fa-solid fa-certificate" style="color: yellow;"></i></span>
                            <span>{{ $skill }}</span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#editSkillModal" data-skill="{{ $skill }}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-link text-danger" onclick=" confirmDeleteSkill('{{ $skill }}')"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var accordionCollapse = document.getElementById('collapseSkills');
        var collapseIcons = document.querySelectorAll('.collapse-icon');

        // Initial icon setup based on current collapse state
        if (accordionCollapse.classList.contains('show')) {
            toggleIcons(true);
        } else {
            toggleIcons(false);
        }

        // Update icons on accordion show
        accordionCollapse.addEventListener('show.bs.collapse', function() {
            toggleIcons(true);
        });

        // Update icons on accordion hide
        accordionCollapse.addEventListener('hide.bs.collapse', function() {
            toggleIcons(false);
        });

        function toggleIcons(isExpanded) {
            collapseIcons.forEach(function(icon) {
                if (isExpanded) {
                    icon.classList.toggle('d-none', icon.classList.contains('fa-chevron-down'));
                } else {
                    icon.classList.toggle('d-none', icon.classList.contains('fa-chevron-up'));
                }
            });
        }
        
    });
</script>