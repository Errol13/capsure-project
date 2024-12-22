<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">

@php
$reports = $record->reportedUser->receivedReports()->where('isArchived', false)->paginate(1); // Limit to 1 per page
@endphp

<div class="space-y-4 space-x-1 p-4 bg-white rounded-xl shadow-lg max-w-3xl mx-auto">
    <!-- Report Header -->
    <div class="border-b pb-4">
        <h2 class="text-2xl font-semibold text-primary">Report Details</h2>
    </div>

    <!-- User Profile Section -->
    <div class="flex flex-col items-center space-y-2">
        <p class="text-sm text-muted">Reported User</p>
        <img src="{{ $record->reportedUser->profile_image_url }}" alt="User Profile Image" class="w-32 h-32 rounded-full object-cover border-2 border-primary">
        <span class="font-semibold text-primary text-xl">{{ $record->reportedUser->first_name }} {{ $record->reportedUser->last_name }}</span>
    </div>

    @foreach($reports as $report)
    <!-- Report ID and Date -->
    <div class="my-2">
        @if($record->id === $report->id)
        <span class="border border-blue-600 rounded-full px-4 text-sm text-blue-600 py-0.5 ml-0 mb-2">
            Next in line for suspension/archive.
        </span>
        @endif</br>
        <p class="text-sm font-medium text-gray-700">Report ID: <span class="text-primary mr-4">{{ $report->id }}</span>
        </p>
        <span class="text-sm text-muted">Date submitted: {{ $report->created_at->format('M d, Y h:i A') }}</span>
    </div>

    <!-- Reason/s Section -->
    <div class="mb-2">
        <h3 class="text-lg font-medium text-primary mb-2">Reason/s:</h3>
        <ul class="list-disc list-inside text-primary">
            @foreach(json_decode($report->reason, true) as $reason)
            <li>{{ $reason }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Other Details Section -->
    <div class="mb-2">
        <h3 class="text-lg font-medium text-primary mb-2">Other Details:</h3>
        <p class="text-primary">{{ $report->details }}</p>
    </div>

    <!-- Proof Images Section -->
    <div class="mb-2">
        <h3 class="text-lg font-medium text-primary mb-2">Proof Images:</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @php
            $proofImages = json_decode($report->proof_image, true);
            $proofImages = is_array($proofImages) ? $proofImages : (empty($proofImages) ? [] : [$proofImages]); // Normalize to array or empty
            @endphp

            @forelse($proofImages as $image)
            @if($image)
            <!-- Proof Image Card -->
            <div class="border-2 border-accent p-2 rounded-lg shadow-sm bg-base-100 hover:shadow-lg transition">
                <a href="{{ asset('storage/' . $image) }}" data-fancybox="gallery" data-caption="Proof Image">
                    <img src="{{ asset('storage/' . $image) }}" alt="Proof Image" class="w-full h-32 object-cover rounded-lg cursor-pointer transition-transform transform hover:scale-105">
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
    @endforeach

    <!-- Pagination Links -->
    <div class="mt-6 flex justify-center">
        {{ $reports->links('vendor.livewire.tailwind') }}
    </div>
</div>