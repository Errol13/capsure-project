<div wire:poll class=" w-100">
    <input
        type="text"
        wire:model.debounce.300ms="search"
        placeholder="Search chats..."
        class="form-control mb-3 mt-3" />

    @if($chatUsers->isNotEmpty())
    <div class="list-group">
        <h5 class="p-3">Chats</h5>
        @foreach($chatUsers as $chat)
        <button
            wire:click="selectConversation({{ $chat['id'] }})"
            class="list-group-item list-group-item-action @if(session('selectedConversationId') == $chat['id']) active @endif">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ $chat['user']->profile_image_url }}" alt="{{ $chat['user']->first_name }} {{ $chat['user']->last_name }}"
                        class="user-image me-2" />
                    <span>{{ $chat['user']->first_name }} {{ $chat['user']->last_name }}</span>
                </div>
                @if($chat['lastMessage'])
                <small class="text-muted">{{ \Carbon\Carbon::parse($chat['lastMessage']->created_at)->format('H:i') }}</small>
                @endif
            </div>

        </button>
        @endforeach
    </div>
    @else
    <p>No messages.</p>
    @endif

    <style>
        .list-group-item.active{
            background-color: #ffcccb;
            border: none;
            color: black;
        }

    </style>
</div>