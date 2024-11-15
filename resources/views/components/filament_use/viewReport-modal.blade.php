<!-- Fancybox CSS -->
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">

<div class="space-y-6 p-6 bg-background rounded-xl shadow-lg">
    <!-- Report Header -->
    <div class="border-b pb-4">
        <h2 class="text-xl font-semibold text-primary">Report Details</h2>
    </div>

    <!-- User Profile Section -->
    <div class="flex flex-col items-center space-x-4">
        <p class="text-sm text-muted my-1">Reported User</p>
        <img src="{{ $record->reportedUser->profile_image_url }}" alt="User Profile Image" class="w-30 h-32 rounded-full mt-2">
        <span class="font-semibold text-primary text-lg mt-2">{{ $record->reportedUser->first_name }} {{ $record->reportedUser->last_name }}</span>
    </div>

    <!-- Reason/s Section -->
    <div>
        <h3 class="font-medium text-primary">Reason/s:</h3>
        <ul class="list-disc list-inside text-primary">
            @foreach(json_decode($record->reason, true) as $reason)
                <li>{{ $reason }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Other Details Section -->
    <div>
        <h3 class="font-medium text-primary">Other Details:</h3>
        <p class="text-primary">{{ $record->details }}</p>
    </div>

    <!-- Proof Images Section -->
    <div>
        <h3 class="font-medium text-primary">Proof Images:</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            @php
            $proofImages = json_decode($record->proof_image, true);
            $proofImages = is_array($proofImages) ? $proofImages : (empty($proofImages) ? [] : [$proofImages]); // Normalize to array or empty
            @endphp

            @forelse($proofImages as $image)
                @if($image)
                <!-- Proof Image Card -->
                <div class="border border-accent p-2 rounded-lg shadow-sm bg-base-100">
                    <a href="{{ asset('storage/' . $image) }}" data-fancybox="gallery" data-caption="Proof Image">
                        <img src="{{ asset('storage/' . $image) }}" alt="Proof Image" class="w-full h-32 object-contain rounded-lg cursor-pointer">
                    </a>
                </div>
                @else
                <p class="text-muted">No valid image found for this entry.</p>
                @endif
            @empty
                <p class="text-muted">No proof images available.</p>
            @endforelse
        </div>
    </div>

</div>
