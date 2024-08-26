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