<div class="space-y-4">
    <div class="flex items-center space-x-4">
        <img src="{{ $record->user->profile_image_url }}" alt="User Profile Image" class="w-22 h-22 rounded-full">
        <span class="font-medium">{{ $record->user->first_name }} {{ $record->user->last_name }}</span>
    </div>

    <div class="flex justify-start items-center">
        <div>
            <h3 class="font-semibold">ID Card Image</h3>
            <a href="{{ asset('storage/' . $record->id_card_image) }}" data-fancybox="gallery" data-caption="ID Card Image">
                <img src="{{ asset('storage/' . $record->id_card_image) }}" alt="ID Card Image" class="w-52 h-52 object-contain mt-2 cursor-pointer">
            </a>
        </div>

        <div>
            <h3 class="font-semibold">Picture with ID</h3>
            <a href="{{ asset('storage/' . $record->pic_with_id) }}" data-fancybox="gallery" data-caption="Picture with ID">
                <img src="{{ asset('storage/' . $record->pic_with_id) }}" alt="Picture with ID" class="w-52 h-52 object-contain mt-2 cursor-pointer">
            </a>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
