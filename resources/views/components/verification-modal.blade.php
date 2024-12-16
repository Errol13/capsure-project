<!-- Fancybox CSS -->
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" rel="stylesheet">

<div class="space-y-1 space-x-4">

    <div class="flex justify-start items-center space-x-4 mb-3">
        <i class="fas fa-id-card text-xl"></i>
        <h6 class="text-2xl font-semibold">Verification Details</h6>
    </div>



    <!-- User Profile Section -->
    <div class="flex items-center space-x-4">
        <img src="{{ $record->user->profile_image_url }}" alt="User Profile Image" class="w-10 h-10 rounded-full">
        <span class="font-medium">{{ $record->user->first_name }} {{ $record->user->last_name }}</span>
    </div>

    <!-- Image Section -->
    <div class="flex justify-between items-center space-x-2">

        <div class="p-5"></div>

        <!-- First Image Container -->
        <div class="border-2 border-accent p-4 rounded-lg shadow-lg bg-base-100 mr-4">
            <h3 class="font-semibold text-center">{{ $record->id_type }} Image</h3>
            <a href="{{ asset('storage/' . $record->id_card_image) }}" data-fancybox="gallery" data-caption="{{ $record->id_type }} Image">
                <img src="{{ asset('storage/' . $record->id_card_image) }}" alt="ID Card Image" class="w-52 h-52 object-contain mt-2 cursor-pointer">
            </a>
        </div>


        <!-- Second Image Container -->
        <div class="border-2 border-accent p-4 rounded-lg shadow-lg bg-base-100">
            <h3 class="font-semibold text-center">Selfie with ID</h3>
            <a href="{{ asset('storage/' . $record->pic_with_id) }}" data-fancybox="gallery" data-caption="Selfie with ID">
                <img src="{{ asset('storage/' . $record->pic_with_id) }}" alt="Picture with ID" class="w-52 h-52 object-contain mt-2 cursor-pointer">
            </a>
        </div>

        <div class="p-5"></div>
    </div>

</div>