<x-filament-panels::page>

    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">

    <!-- Add Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

    <h1 class="text-2xl font-semibold">Verification Details</h1>

    <div class="space-y-4 mt-4">
        <!-- Display User's Name and Profile Image -->
        <div class="flex items-center space-x-4">
            <!-- If there's no profile image, use a placeholder image -->
            <img src="{{ $this->record->user->profile_image_url }}"
                alt="User Profile Image" class="w-22 h-22 rounded-full">
            <span class="font-medium">{{ $this->record->user->first_name }} {{ $this->record->user->last_name }}</span>
        </div>

        <div class="flex justify-start items-center">
            <!-- Display ID Card Image -->
            <div>
                <h3 class="font-semibold">ID Card Image</h3>
                <a href="{{ asset('storage/' . $this->record->id_card_image) }}" data-fancybox="gallery" data-caption="ID Card Image">
                    <img src="{{ asset('storage/' . $this->record->id_card_image) }}" alt="ID Card Image" class="w-52 h-52 object-contain mt-2 me-4 cursor-pointer">
                </a>
            </div>

            <!-- Display Picture with ID -->
            <div>
                <h3 class="font-semibold">Picture with ID</h3>
                <a href="{{ asset('storage/' . $this->record->pic_with_id) }}" data-fancybox="gallery" data-caption="Picture with ID">
                    <img src="{{ asset('storage/' . $this->record->pic_with_id) }}" alt="Picture with ID" class="w-52 h-52 object-contain mt-2 cursor-pointer">
                </a>
            </div>

        </div>

        <div class="mt-4 flex space-x-4">
            <!-- Verify Button -->
            <form action="{{ route('filament.resources.verifications.verify', $record->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Verify</button>
            </form>

            <!-- Resend Verification Button -->
            <form action="{{ route('filament.resources.verifications.resend', $record->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">Resend Verification Notice</button>
            </form>
        </div>


    </div>
</x-filament-panels::page>