<div x-data="{
    messages: @entangle('messages'), // Keep Alpine and Livewire in sync
    isLoading: false,
    scrollToBottom() {
        this.$nextTick(() => {
            const chatBox = document.querySelector('.chat-messages');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    },
    loadMoreMessages() {
        if (this.isLoading) return;
        this.isLoading = true;
        Livewire.dispatch('loadMoreMessages');
    }
}"
    x-init="scrollToBottom()"
    x-effect="scrollToBottom()">

    <!-- Chat Header -->
    @if($otherUser)
    <div>
        @if($otherUser->user_type === 'freelancer')
        <a href="{{route('view-freelancer-profile', ['id'=> $otherUser->id])}}" class="text-decoration-none">
            <h5 class="text-center my-2">{{$otherUser->fullName()}}</h5>
        </a>
            @else
            <a href="{{route('view-client-profile', ['id'=> $otherUser->id])}}" class="text-decoration-none">
                <h5 class="text-center my-2">{{$otherUser->fullName()}}</h5>
            </a>
            @endif

    </div>
    @endif
    <hr class="mb-3 px-0">
    @if($selectedConversationId)
    <div class="chat-wrapper">

        <!-- Display Chat Messages -->
        @if($messages && count($messages) > 0)
        <div class="chat-messages position-relative"
            x-init="scrollToBottom()"
            @scroll="if ($event.target.scrollTop === 0) { $wire.loadMoreMessages(); }">

            @foreach($messages as $message)
            <div class="message-wrapper {{ $message['sender'] === auth()->id() ? 'message-sent' : 'message-received' }}">
                <div class="message-content d-flex align-items-start">
                    <div class="message-text-wrapper 
                        {{ $message['sender'] === auth()->id() ? 'ml-auto' : '' }}"
                        style="max-width: 70%; width: auto;">
                        <div class="message-bubble 
                            {{ $message['sender'] === auth()->id() ? 'bg-sender' : 'bg-receiver' }} py-2 px-3">
                            <p class="message-text mb-1">
                                {{ $message['message'] }}
                            </p>
                            <small class="message-timestamp text-muted 
                                  {{ $message['sender'] === auth()->id() ? 'text-white-50' : '' }}"
                                style="font-size: 0.7rem; display: block; text-align: right;">
                                {{ \Carbon\Carbon::parse($message['created_at'])
                            ->timezone('Asia/Manila')
                            ->format('h:i A') }}
                            </small>
                        </div>

                        @php
                        // Get the last message in the loop
                        $isLastMessage = $loop->last;
                        @endphp

                        <div wire:key="message-{{ $message['id'] }}" wire:click="updateMessageStatus({{ $message['id'] }})">
                            <!-- Display 'Seen by' or 'Delivered' for the last message -->
                            @if($isLastMessage)
                            @if($message['isRead'] === true && $message['recipient'] !== auth()->id())
                            <span class="text-muted fs-smaller">Seen by {{ $otherUser->fullName() }}</span>
                            @elseif($message['isRead'] === false && $message['sender'] === auth()->id())
                            <span class="text-muted fs-smaller text-white">Delivered</span>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-muted p-4">
            No messages in this conversation. Start chatting!
        </div>
        @endif

        <!-- Loading Spinner -->
        <div class="text-center d-none" id="loadingState">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading chat...</p>
        </div>

        <!-- Send Message Form -->
        <form wire:submit.prevent="sendMessage" class="send-message-form align-items-center">
            <input type="text" wire:model="newMessage" placeholder="Type your message..." />
            <i class="fas fa-paper-plane fs-3 text-purple me-3" wire:click="sendMessage"></i>
        </form>

    </div>
    @else
    <div class="text-center d-flex justify-content-center align-items-center mt-5">
        <div class="row">
            <h5 class="text-center text-muted open-sans-reg">Select a user to start chatting</h5>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.querySelector('.chat-messages');
            const loadingState = document.querySelector('#loadingState');

            function showLoadingState() {
                if (loadingState) {
                    loadingState.classList.remove('d-none');
                }
                if (chatBox) {
                    chatBox.classList.add('d-none');
                }
            }

            function hideLoadingState() {
                if (loadingState) {
                    loadingState.classList.add('d-none');
                }
                if (chatBox) {
                    chatBox.classList.remove('d-none');
                }
            }

            // Scroll to bottom on load
            scrollToBottom();

            // Load more messages on scroll up
            if (chatBox) {
                chatBox.addEventListener('scroll', function() {
                    if (chatBox.scrollTop === 0) {
                        showLoadingState();
                        Livewire.dispatch('loadMoreMessages');
                    }
                });
            }

            // After messages are loaded, adjust scroll position to keep user at the same point
            Livewire.on('messagesLoaded', () => {
                const chatBox = document.querySelector('.chat-messages');
                // Ensure scroll position remains at the top after loading messages
                if (chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight - chatBox.clientHeight;
                }
            });


            // Scroll to bottom when a message is sent or received
            document.addEventListener('loadToBottom', function() {
                scrollToBottom();
            });

            // Scroll to bottom when a new conversation selected
            document.addEventListener('hideLoadingState', function() {
                scrollToBottom();
            });

            // Retain scroll position after new message
            document.addEventListener('scrollToBottom', () => {
                scrollToBottom();
            });

            function scrollToBottom() {
                if (chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }

            //Dynamically subscribe to te Pusher channel for real time messaging
            window.Echo.private(`chat.{{auth()->id()}}`).listen('.message.sent', (e) => {
                Livewire.dispatch('messageReceived');
            });
        });
    </script>

    <style>
        .chat-messages {
            max-height: 500px;
            overflow-y: auto;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .chat-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .send-message-form {
            display: flex;
            padding: 10px;
            position: sticky;
            bottom: 0;
            background-color: whitesmoke;
            border-radius: 20px;
            z-index: 10;
        }

        .send-message-form input[type="text"] {
            flex: 1;
            padding: 5px;
            border: none;
            border-radius: 15px;
            margin-right: 20px;
            margin-left: 3px;
        }

        .message-bubble {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-width: 100%;
        }

        .message-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .message-wrapper {
            margin-bottom: 10px;
        }

        .message-sent .message-content {
            justify-content: flex-end;
        }

        .message-received .message-content {
            justify-content: flex-start;
        }

        .bg-sender {
            background-color: #91216C;
            color: white;
            border-radius: 25px 25px 0 25px;
        }

        .bg-receiver {
            border-radius: 0 25px 25px 25px;
            background-color: aliceblue;
        }
    </style>
</div>
