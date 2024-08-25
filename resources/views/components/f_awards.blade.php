<!-- Awards Display -->
<div class="text-end mt-3 d-flex align-items-center">
    <p class="mb-0 me-2 poppins-medium">Awards</p>
    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addAwardsModal">
        <i class="fas fa-solid fa-circle-plus"></i>
    </button>
</div>

<div class="container mt-2">
    @if($freelancer->certificates->isEmpty())
    <p>Add awards to showcase your achievements.</p>
    @else
    <div class="accordion" id="awardsAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingAwards">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0">Awards</span>
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAwards" aria-expanded="false" aria-controls="collapseAwards">
                        <i class="ms-5 text-end fas fa-chevron-down collapse-icon" aria-hidden="true"></i>
                        <i class="ms-5 text-end fas fa-chevron-up collapse-icon d-none" aria-hidden="true"></i>
                    </button>
                </div>
            </h2>
            <div id="collapseAwards" class="accordion-collapse collapse" aria-labelledby="headingAwards" data-bs-parent="#awardsAccordion">
                <div class="accordion-body">
                    @foreach ($freelancer->certificates as $certificate)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <a data-fancybox="certificate-gallery" href="{{ asset('storage/' . str_replace('public/', '', $certificate->image)) }}">
                                <img src="{{ asset('storage/' . str_replace('public/', '', $certificate->image)) }}" alt="{{ $certificate->title }}" class="me-2" style="width: 50px; height: 50px;">
                            </a>
                            <div>
                                <span class="d-block">{{ $certificate->title }}</span>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($certificate->date)->format('M d, Y') }}</small>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#editAwardModal" data-id="{{ $certificate->cert_id }}" data-title="{{ $certificate->title }}" data-date="{{ $certificate->date }}" data-image="{{ $certificate->image }}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-link text-danger" onclick="confirmDeleteAward('{{ $certificate->cert_id }}')"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal for Adding Awards -->
<div class="modal fade" id="addAwardsModal" tabindex="-1" aria-labelledby="addAwardsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="award_title" class="form-label">Award Title</label>
                        <input type="text" class="form-control" id="award_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="award_date" class="form-label">Award Date</label>
                        <input type="date" class="form-control" id="award_date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="award_image" class="form-label">Award Image</label>
                        <input type="file" class="form-control" id="award_image" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Award</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Awards -->
<div class="modal fade" id="editAwardModal" tabindex="-1" aria-labelledby="editAwardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('certificates.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_award_id" name="cert_id">
                    <div class="mb-3">
                        <label for="edit_award_title" class="form-label">Edit Award Title</label>
                        <input type="text" class="form-control" id="edit_award_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_award_date" class="form-label">Edit Award Date</label>
                        <input type="date" class="form-control" id="edit_award_date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_award_image" class="form-label">Change Award Image</label>
                        <input type="file" class="form-control" id="edit_award_image" name="image">
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
        var accordionCollapse = document.getElementById('collapseAwards');
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

        // Set up the Edit Award Modal
        var editAwardModal = document.getElementById('editAwardModal');
        editAwardModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');
            var date = button.getAttribute('data-date');
            var image = button.getAttribute('data-image');

            var awardIdField = editAwardModal.querySelector('#edit_award_id');
            var awardTitleField = editAwardModal.querySelector('#edit_award_title');
            var awardDateField = editAwardModal.querySelector('#edit_award_date');

            awardIdField.value = id; // Set the award id
            awardTitleField.value = title; // Set the award title
            awardDateField.value = date; // Set the award date
        });
    });

    function confirmDeleteAward(certId) {
        if (confirm('Are you sure you want to delete this award?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/certificates/delete';
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            var methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            var certField = document.createElement('input');
            certField.type = 'hidden';
            certField.name = 'cert_id';
            certField.value = certId;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(certField);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>