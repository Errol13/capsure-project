<x-filament-panels::page>

    

    <h1 class="text-2xl font-semibold"><i class="fas fa-light fa-id-card" style="color:blue;"></i>Verification Details</h1>

    <div class="space-y-4 mt-4">
        <!-- Display User's Name and Profile Image -->
        <div class="flex items-center space-x-4">
            <img src="{{ $this->record->user->profile_image_url }}"
                alt="User Profile Image" class="w-10 h-10 rounded-full">
            <span class="font-medium">{{ $this->record->user->first_name }} {{ $this->record->user->last_name }}</span>
        </div>

        <div class="flex justify-start items-center">
            <!-- Display ID Card Image -->
            <div class="border border-accent p-2 rounded-lg shadow-sm bg-base-100">
                <h3 class="font-semibold">ID Card Image</h3>
                <a href="{{ asset('storage/' . $this->record->id_card_image) }}" data-fancybox="gallery" data-caption="ID Card Image">
                    <img src="{{ asset('storage/' . $this->record->id_card_image) }}" alt="ID Card Image" class="w-52 h-52 object-contain mt-2 me-4 cursor-pointer">
                </a>
            </div>

            <!-- Display Picture with ID -->
            <div class="border border-accent p-2 rounded-lg shadow-sm bg-base-100">
                <h3 class="font-semibold">Picture with ID</h3>
                <a href="{{ asset('storage/' . $this->record->pic_with_id) }}" data-fancybox="gallery" data-caption="Picture with ID">
                    <img src="{{ asset('storage/' . $this->record->pic_with_id) }}" alt="Picture with ID" class="w-52 h-52 object-contain mt-2 cursor-pointer">
                </a>
            </div>

        </div>

    </div>
</x-filament-panels::page>