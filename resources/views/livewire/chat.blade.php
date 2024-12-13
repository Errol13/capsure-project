<div>
    <!-- Chat Header -->
    <div>
        <h5 class="text-center my-2">{{$otherUser->fullName()}}</h5>
    </div>
    <hr class="mb-3 px-0">
    @if($selectedConversationId)
    <div class="chat-wrapper">

        <!-- Display Chat Messages -->
        @if($messages && count($messages) > 0)
        <div class="chat-messages position-relative" x-data="chatMessages()" x-init="scrollToBottom()" @message.sent.window="scrollToBottom()" @conversationSelected.window="scrollToBottom()">
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
                        $lastMessage = end($messages); // Get the last message
                        @endphp

                     
                        <div wire:key="message-{{ $message['id'] }}" wire:target="updateMessageStatus">
                            @if($message === $lastMessage)
                            @if($message['isRead'] === true && $message['recipient'] !== auth()->id())
                            <span class="text-muted fs-smaller">Seen by {{$otherUser->fullName()}}</span>
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

        <div class="text-center d-none" id="loadingState">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading chat...</p>
        </div>

        <!-- Send Message Form -->
        <form wire:submit.prevent="sendMessage" class="send-message-form align-items-center">
            <input type="text" wire:model="newMessage" placeholder="Type your message..." />
            <i class="fas fa-solid fa-paper-plane fs-3 text-purple me-3" type="button"></i>
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
            chatBox.addEventListener('scroll', function() {
                if (chatBox.scrollTop === 0) {
                    Livewire.dispatch('loadMoreMessages');
                }
            });

            //listen for loading state
            document.addEventListener('showLoadingState', function() {
                const loadingState = document.querySelector('#loadingState');
                const messageList = document.querySelector('.chat-messages');

                // console.log('Triggered');
                messageList.classList.add('d-none');
                loadingState.classList.remove('d-none');

            });

            document.addEventListener('hideLoadingState', function() {
                const loadingState = document.querySelector('#loadingState');
                const messageList = document.querySelector('.chat-messages');

                // console.log('Triggered');
                loadingState.classList.add('d-none');
                messageList.classList.remove('d-none');
            });

            // console.log(`Chat Initialized for User ID: {{ auth()->id() }}`);

            // Dynamically subscribe to the Echo channel for real-time updates
            window.Echo.private(`chat.{{ auth()->id() }}`)
                .listen('.message.sent', (e) => {
                    console.log('Message received:', e);
                    // Dispatch a Livewire event to refresh messages
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
        }

        .send-message-form {
            display: flex;
            padding: 10px;
            background-color: whitesmoke;
            border-radius: 20px;
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