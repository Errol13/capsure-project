
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

    });
</script>