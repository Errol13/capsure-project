

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">

<div class="container mt-4">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="portfolioTabs" role="tablist">
        @foreach ($portfolios as $index => $portfolio)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $portfolio->portfolio_id }}" data-bs-toggle="tab" href="#portfolio-{{ $portfolio->portfolio_id }}" role="tab" aria-controls="portfolio-{{ $portfolio->portfolio_id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                    {{ $portfolio->album_name }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Tabs Content -->
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
                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                                        <img src="{{ asset('storage/' . $relativePath) }}" alt="Portfolio Image" class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover; margin: 5px;">
                                    </a>
                                @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                                    <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                                        <video src="{{ asset('storage/' . $relativePath) }}" controls class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover; margin: 5px;"></video>
                                    </a>
                                @else
                                    <p>Unsupported file type: {{ $fileExtension }}</p>
                                @endif
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
</div>


