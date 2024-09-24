<div class="ps-0 ms-0 container mt-4">
    @if ($portfolios->isEmpty())
    <p class="fs-6 text-center open-sans-reg text-muted mt-5">No portfolios yet. Create one.</p>
    @else

    <ul class="nav nav-tabs" id="portfolioTabs" role="tablist">
        @foreach ($portfolios as $index => $portfolio)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $portfolio->portfolio_id }}" data-bs-toggle="tab" href="#portfolio-{{ $portfolio->portfolio_id }}" role="tab" aria-controls="portfolio-{{ $portfolio->portfolio_id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                {{ $portfolio->album_name }} <span><i class="ms-2 fas fa-solid fa-ellipsis-vertical"></i></span>
            </a>
        </li>
        @endforeach
    </ul>

    <div class="tab-content mt-3" id="portfolioTabsContent">
        @foreach ($portfolios as $index => $portfolio)
        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="portfolio-{{ $portfolio->portfolio_id }}" role="tabpanel" aria-labelledby="tab-{{ $portfolio->portfolio_id }}">
            @if ($portfolio->path)
            <div class="d-flex flex-wrap">
                @foreach (json_decode($portfolio->path) as $filePath)
                @php
                $relativePath = str_replace('public/', '', $filePath);
                $fileName = basename($relativePath);
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                @endphp
                @if (Str::startsWith($relativePath, 'portfolios/' . $portfolio->portfolio_id . '/'))
                <div class="position-relative">
                    @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                    <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                        <img src="{{ asset('storage/' . $relativePath) }}" alt="Portfolio Image" class="img-profile-portfolio rounded">
                    </a>
                    @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                    <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                        <video src="{{ asset('storage/' . $relativePath) }}" controls class="img-profile-portfolio rounded"></video>
                    </a>
                    @else
                    <p>Unsupported file type: {{ $fileExtension }}</p>
                    @endif

                    <!-- Delete Checkbox -->
                    <div class="form-check position-absolute top-0 end-0 m-2">
                        <input type="checkbox" class="form-check-input" id="delete-checkbox-{{ $service->id }}" data-file-path="{{ $relativePath }}">
                        <label class="form-check-label" for="delete-checkbox-{{ $service->id }}"> </label>
                    </div>

                </div>
                @else
                <p>File path mismatch: {{ $relativePath }}</p>
                @endif
                @endforeach
            </div>
            @else
            <p>No media found for this album.</p>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</div>