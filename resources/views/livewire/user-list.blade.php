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
                    <!--show the other user-->
                    @php
                    // Determine who is the other participant (not the authenticated user)
                    $otherUser = ($conversation['recipient']->id === auth()->user()->id)
                    ? $conversation['sender']
                    : $conversation['recipient'];
                    @endphp
                
                    <img src="{{ $otherUser->profile_image_url }}" alt="{{ $otherUser->fullName() }}"
                        class="user-image me-2" />

                    <!--contains the latest message -->
                    <div class="d-flex flex-column justify-content-start">
                        <span>{{ $otherUser->fullName() }}</span>
                        <div style="max-width: 200px; overflow: hidden;" class="text-truncate">

                            @if($conversation->messages->isNotEmpty())

                            @if(auth()->user()->id === $conversation->messages->first()->senderUser->id)
                            <small>
                                You: {{$conversation->messages->first()->message}}
                            </small>
                            @else
                            <small>
                                {{$conversation->messages->first()->senderUser->first_name}}: {{$conversation->messages->first()->message}}
                            </small>
                            @endif
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