<!-- Skills Display -->
<div class="text-end mt-3 d-flex align-items-center">
    <p class="mb-0 me-2 poppins-medium">Skills</p>
    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addSkillsModal">
        <i class="fas fa-solid fa-circle-plus"></i> <!-- Plus icon for adding skills -->
    </button>
</div>

<div class="container mt-2">
    @if(empty($freelancer->skills))
    <p>Add skills to attract more clients.</p>
    @else
    <div class="accordion" id="skillsAccordion">
        <!-- Accordion Item for Skills -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSkills">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0">Skills</span>
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


<!-- Modal for Adding Skills -->
<div class="modal fade" id="addSkillsModal" tabindex="-1" aria-labelledby="addSkillsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('skills.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="skill_name" class="form-label">Skill</label>
                        <input type="text" class="form-control" id="skill_name" name="skill_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Skill</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Skills -->
<div class="modal fade" id="editSkillModal" tabindex="-1" aria-labelledby="editSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('skills.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_skill_name" class="form-label">Edit Skill</label>
                        <input type="text" class="form-control" id="edit_skill_name" name="new_skill_name" required>
                        <input type="hidden" id="old_skill_name" name="old_skill_name">
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

        // Set up the Edit Skill Modal
        var editSkillModal = document.getElementById('editSkillModal');
        editSkillModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var skill = button.getAttribute('data-skill');
            var skillNameField = editSkillModal.querySelector('#edit_skill_name');
            var oldSkillNameField = editSkillModal.querySelector('#old_skill_name');

            skillNameField.value = skill; // Set the skill name
            oldSkillNameField.value = skill; // Pass old skill name to the hidden field
        });
    });

    function confirmDeleteSkill(skillName) {
        if (confirm('Are you sure you want to delete this skill?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/skills/delete';
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            var methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            var skillField = document.createElement('input');
            skillField.type = 'hidden';
            skillField.name = 'skill_name';
            skillField.value = skillName;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(skillField);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>