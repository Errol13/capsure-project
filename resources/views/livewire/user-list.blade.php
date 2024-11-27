<div class="w-100">
    <input
        type="text"
        wire:model.debounce.300ms="search"
        placeholder="Search Capsure"
        class="form-control mb-3 mt-3 d-md-block d-block bg-white rounded-4" />

    @if($conversations->isNotEmpty())
    <ul class="list-group">
        <h4 class="p-2 poppins-medium d-md-block d-block">Chats</h4>
        @foreach($conversations as $conversation)
        <li
            wire:key="conversation-{{ $conversation['conversation_id'] }}"
            wire:click="selectConversation({{ $conversation['conversation_id'] }})"
            class="rounded-4 mb-2 list-group-item list-group-item-action @if($selectedConversationId == $conversation['conversation_id']) active @endif"
            style="border: none;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img
                        src="{{ $conversation['recipient']->profile_image_url }}"
                        alt="{{ $conversation['recipient']->first_name }} {{ $conversation['recipient']->last_name }}"
                        class="rounded-circle me-2"
                        width="40"
                        height="40" />

                    <div class="conversation-details">
                        <span class="user-name d-md-inline d-none">
                            {{ $conversation['recipient']->first_name }} {{ $conversation['recipient']->last_name }}
                        </span>
                        <div class="latest-message d-md-block d-none">
                            @if($conversation->messages->isNotEmpty())
                            <small class="text-truncate">
                                {{$conversation->messages->first()->senderUser->first_name}}:
                                {{$conversation->messages->first()->message}}
                            </small>
                            @endif
                        </div>
                    </div>
                </div>

                @if($conversation->last_time_message && $conversation->messages->isNotEmpty())
                <small class="text-muted time-stamp d-md-inline d-none">
                    {{ \Carbon\Carbon::parse($conversation->messages->first()->created_at)->format('h:i A') }}
                </small>
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
            background-color: #FADAF0;
            border: none;
            color: black;
        }

        .latest-message small {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }

        @media (max-width: 768px) {
            .conversation-details .user-name,
            .conversation-details .latest-message,
            .time-stamp {
                display: none !important;
            }
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