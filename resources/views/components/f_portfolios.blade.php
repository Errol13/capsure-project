<div class="ps-0 ms-0 justify-content-center align-items-center m-2">
    @if ($portfolios->isEmpty())
    <p class="fs-6 text-center open-sans-reg text-muted mt-5">No portfolios yet. Create one.</p>
    @else

    <ul class="nav nav-tabs" id="portfolioTabs" role="tablist">
        @foreach ($portfolios as $index => $portfolio)
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                @if($desktopView)
                id="tabDesktop-{{ $portfolio->portfolio_id }}"
                href="#portfolioDesktop-{{ $portfolio->portfolio_id }}"
                @else
                id="tab-{{ $portfolio->portfolio_id }}"
                href="#portfolioMobile-{{ $portfolio->portfolio_id }}"
                @endif
                data-bs-toggle="tab"
                role="tab"
                aria-controls="portfolio-{{ $portfolio->portfolio_id }}"
                aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                {{ $portfolio->album_name }}
            </a>
        </li>
        @endforeach
    </ul>

    <div class="tab-content mt-3" id="portfolioTabsContent">
        @foreach ($portfolios as $index => $portfolio)
        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
            @if($desktopView)
            id="portfolioDesktop-{{ $portfolio->portfolio_id }}"
            @else
            id="portfolioMobile-{{ $portfolio->portfolio_id }}"
            @endif
            role="tabpanel"
            aria-labelledby="{{ $desktopView ? 'tabDesktop-' : 'tab-' }}{{ $portfolio->portfolio_id }}">

            @if ($portfolio->path)
            <div class="d-flex flex-wrap gap-3">
    @foreach (json_decode($portfolio->path) as $filePath)
        @php
            $relativePath = str_replace('public/', '', $filePath);
            $fileName = basename($relativePath);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        @endphp

        @if (Str::startsWith($relativePath, 'portfolios/' . $portfolio->portfolio_id . '/'))
            <div class="position-relative" style="width: calc(33.33% - 1rem); max-width: 300px;">
                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                    <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                        <img src="{{ asset('storage/' . $relativePath) }}" alt="Portfolio Image" class="img-profile-portfolio rounded w-100">
                    </a>
                @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                    <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                        <video src="{{ asset('storage/' . $relativePath) }}" controls class="img-profile-portfolio rounded w-100"></video>
                    </a>
                @else
                    <p>Unsupported file type: {{ $fileExtension }}</p>
                @endif

                <!-- Delete Checkbox -->
                <div class="form-check position-absolute top-0 end-0 m-2">
                    <input type="checkbox" class="form-check-input delete-checkbox rounded border border-primary-subtle" id="delete-checkbox-{{ $portfolio->portfolio_id }}-{{ $fileName }}" data-file-path="{{ $relativePath }}" data-portfolio-id="{{ $portfolio->portfolio_id }}">
                    <label class="form-check-label" for="delete-checkbox-{{ $portfolio->portfolio_id }}-{{ $fileName }}"> </label>
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


<!-- JavaScript to Handle Batch Deletion -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtonId = '{{ $desktopView ? "batchDeleteButtonDesktop" : "batchDeleteButtonMobile" }}';

        // Uses event delegation
        document.body.addEventListener('click', function(event) {
            if (event.target.closest(`#${deleteButtonId}`)) {
                // Confirmation prompt before deletion
                const confirmDelete = confirm("Are you sure you want to delete the selected items?");

                if (!confirmDelete) {
                    return; // Exit if the user cancels the operation
                }

                const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
                const portfolios = {};

                checkboxes.forEach(checkbox => {
                    const portfolioId = checkbox.getAttribute('data-portfolio-id');
                    const filePath = checkbox.getAttribute('data-file-path');

                    // Initialize array for each portfolio if it doesn't exist
                    if (!portfolios[portfolioId]) {
                        portfolios[portfolioId] = [];
                    }

                    // Add the file path to the correct portfolio
                    portfolios[portfolioId].push(filePath);
                });

                if (Object.keys(portfolios).length > 0) {
                    // Send AJAX request to delete the selected files
                    fetch('/delete/portfolio/files', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                            },
                            body: JSON.stringify({
                                portfolios: portfolios // Use the structured portfolios object
                            })
                        })
                        .then(response => {
                            // Check for response status to handle redirects or errors
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('An error occurred while deleting files: ' + (data.message || ''));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting files: ' + error.message);
                        });
                } else {
                    alert('No files selected for deletion.');
                }
            }
        });
    });
</script>
