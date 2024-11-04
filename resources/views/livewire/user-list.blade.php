<div class="w-100">
    <input
        type="text"
        wire:model.debounce.300ms="search"
        placeholder="Search chats..."
        class="form-control mb-3 mt-3" />

    @if($conversations->isNotEmpty())
    <ul class="list-group">
        <h5 class="p-3">Chats</h5>
        @foreach($conversations as $conversation)
        <li
            wire:key="conversation-{{ $conversation['conversation_id'] }}"
            wire:click="selectConversation({{ $conversation['conversation_id'] }})"
            class="list-group-item list-group-item-action @if($selectedConversationId == $conversation['conversation_id']) active @endif">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ $conversation['recipient']->profile_image_url }}" alt="{{ $conversation['recipient']->first_name }} {{ $conversation['recipient']->last_name }}"
                        class="user-image me-2" />

                    <!--contains the latest message -->
                    <div class="d-flex flex-column justify-content-start">
                        <span>{{ $conversation['recipient']->first_name }} {{ $conversation['recipient']->last_name }}</span>
                        <div style="max-width: 200px; overflow: hidden;" class="text-truncate">

                        @if($conversation->messages->isNotEmpty())
                            <small>
                                {{$conversation->messages->first()->senderUser->first_name}}: {{$conversation->messages->first()->message}}
                            </small>
                            @endif
                        </div>
                    </div>

                </div>
                @if($conversation->last_time_message && $conversation->messages->isNotEmpty())
                <small class="text-muted">{{ \Carbon\Carbon::parse($conversation->messages->first()->created_at)->format('h:i A') }}</small>
                @endif
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <p class="text-center">No messages.</p>
    @endif

    <style>
        .list-group-item.active {
            background-color: #E6F7FF;
            border: #B0D3E8 solid 1px;
            color: black;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('update-url', event => {
                const url = event.detail;
                if (url) {
                    history.pushState(null, '', url);
                } else {
                    console.error("Received undefined URL");
                }
            });
        });
    </script>
</div>