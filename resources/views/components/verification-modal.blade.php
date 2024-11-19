<!-- Fancybox CSS -->
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">

<div class="space-y-6">
    <!-- User Profile Section -->
    <div class="flex items-center space-x-4">
        <img src="{{ $record->user->profile_image_url }}" alt="User Profile Image" class="w-22 h-22 rounded-full">
        <span class="font-medium">{{ $record->user->first_name }} {{ $record->user->last_name }}</span>
    </div>

  <!-- Image Section -->
<div class="flex justify-start items-center space-x-6">
    <!-- First Image Container -->
    <div class="border-dashed border-2 border-gray-500 p-4">
        <h3 class="font-semibold text-center">{{ $record->id_type }} Image</h3>
        <a href="{{ asset('storage/' . $record->id_card_image) }}" data-fancybox="gallery" data-caption="{{ $record->id_type }} Image">
            <img src="{{ asset('storage/' . $record->id_card_image) }}" alt="ID Card Image" class="w-52 h-52 object-contain mt-2 cursor-pointer">
        </a>
    </div>
    
    <!-- Second Image Container -->
    <div class="border-dashed border-2 border-gray-500 p-4">
        <h3 class="font-semibold text-center">Selfie with ID</h3>
        <a href="{{ asset('storage/' . $record->pic_with_id) }}" data-fancybox="gallery" data-caption="Selfie with ID">
            <img src="{{ asset('storage/' . $record->pic_with_id) }}" alt="Picture with ID" class="w-52 h-52 object-contain mt-2 cursor-pointer">
        </a>
    </div>
</div>




</div>