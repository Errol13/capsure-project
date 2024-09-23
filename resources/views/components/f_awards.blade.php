<div class="container mt-2">
    @if($freelancer->certificates->isEmpty())
    <p>Add awards to showcase your achievements.</p>
    @else
    <h2 class="h6 mb-3">Awards</h2>
    <div>
        @foreach ($freelancer->certificates as $certificate)
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-center">
                <a data-fancybox="certificate-gallery" data-caption="{{ $certificate->title }}" href="{{ asset('storage/' . str_replace('public/', '', $certificate->image)) }}">
                    <img src="{{ asset('storage/' . str_replace('public/', '', $certificate->image)) }}" alt="{{ $certificate->title }}" class="me-2 rounded-circle border border-secondary" style="width: 40px; height: 40px;">
                </a>
                <div>
                    <span class="d-block">{{ $certificate->title }}</span>
                    <small class="text-muted text-nowrap">{{ \Carbon\Carbon::parse($certificate->date)->format('M d, Y') }}</small>
                </div>
            </div>

            <!--Action Buttons -->
            <div class="d-flex justify-content-end align-items-end">
                <a href="#" class="p-1" data-bs-toggle="modal" data-bs-target="#editAwardModal" data-id="{{ $certificate->cert_id }}" data-title="{{ $certificate->title }}" data-date="{{ $certificate->date }}" data-image="{{ $certificate->image }}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="text-danger ms-2 p-1 " onclick="confirmDeleteAward('{{ $certificate->cert_id }}')">
                    <i class="fas fa-trash"></i>
                </a>
            </div>

        </div>
        @endforeach
    </div>
    @endif
</div>