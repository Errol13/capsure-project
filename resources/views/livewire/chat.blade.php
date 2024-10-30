<div>
    @if(session('selectedConversationId'))
    <div class="chat-container mt-2">
        <!-- Display Chat Messages -->
        @if($messages)
        <div class="chat-messages"
            x-data
            x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
            @message-received.window="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
            @user-selected.window="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })">

            @foreach($messages as $message)
            <div class="{{ $message['sender'] === auth()->id() ? 'message-sent' : 'message-received' }}">
                <p>{{ $message['message'] }}</p>
                <small class="text-muted">{{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}</small>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Send Message Form -->
        <form wire:submit.prevent="sendMessage" class="send-message-form">
            <input type="text" wire:model="newMessage" placeholder="Type your message..." />
            <button type="submit">Send</button>
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
            console.log(`Chat Initialized for User ID: {{ auth()->id() }}`);

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
        .chat-container {
            position: relative;
            display: block;
            width: 100%;
            height: 100%;
            background-color: #f9f9f9;
        }

        .chat-messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }

        .chat-messages .message-sent {
            text-align: right;
            background-color: #e0f7fa;
            margin: 5px 0;
            border-radius: 10px;
        }

        .chat-messages .message-received {
            text-align: left;
            background-color: #ffcccb;
            color: black;
            margin: 5px 0;
            border: #ffcccb solid 1px;
            border-radius: 10px;
        }

        .chat-messages .message-sent, .message-received{
            display: block;
            clear:both;
            word-wrap: break-word;
            padding: 8px 12px;
        }

        .send-message-form {
            display: flex;
            margin-top: auto;
        }

        .send-message-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        .send-message-form button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .send-message-form button:hover {
            background-color: #0056b3;
        }
    </style>
</div>