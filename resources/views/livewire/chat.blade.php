<div>
    <div class="chat-container">
        <!-- Display Chat Messages -->
        <div class="chat-messages">
            @foreach($messages as $message)
            <div class="{{ $message['sender'] === auth()->id() ? 'message-sent' : 'message-received' }}">
                <p>{{ $message['message'] }}</p>
                <small>{{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}</small>
            </div>
            @endforeach
        </div>

        <!-- Send Message Form -->
        <form wire:submit.prevent="sendMessage" class="send-message-form">
            <input type="text" wire:model="newMessage" placeholder="Type your message..." />
            <button type="submit">Send</button>
        </form>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            console.log(`chat.{{ auth()->id() }}`);
            // Dynamically subscribe to the Echo channel using the recipientId passed from PHP
            window.Echo.private(`chat.{{ auth()->id() }}`)
                .listen('.message.sent', (e) => {
                    console.log('Message received:', e);
                    // Emit the Livewire event to refresh messages
                    Livewire.dispatch('messageReceived');
                });
        });
    </script>


    <style>
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .chat-messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .message-sent {
            text-align: right;
            background-color: #e0f7fa;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
        }

        .message-received {
            text-align: left;
            background-color: black;
            padding: 10px;
            color: white;
            margin: 5px 0;
            border-radius: 10px;
        }

        .send-message-form {
            display: flex;
        }

        .send-message-form input[type="text"] {
            flex: 1;
            padding: 10px;
        }

        .send-message-form button {
            padding: 10px;
        }
    </style>


</div>