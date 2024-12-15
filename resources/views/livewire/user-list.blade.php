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
                    <!--show the other user-->
                    @php
                    // Determine who is the other participant (not the authenticated user)
                    $otherUser = ($conversation['recipient']->id === auth()->user()->id)
                    ? $conversation['sender']
                    : $conversation['recipient'];
                    @endphp

                    <img src="{{ $otherUser->profile_image_url }}" alt="{{ $otherUser->fullName() }}"
                        class="user-image me-2" style="width: 40px; height: 40px;" />

                    <!--contains the latest message -->
                    <div class="d-flex d-none d-lg-block flex-column justify-content-start">
                        <span>{{ $otherUser->fullName() }}</span>
                        <div style="max-width: 200px; overflow: hidden;" class=" text-truncate">

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
                <small class="text-muted fs-smaller time-stamp d-md-inline">
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
                    // console.error("Received undefined URL");
                }
            });
        });
    </script>
</div>