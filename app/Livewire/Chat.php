<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Profile\Chat as ProfileChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public $messages = [];
    public $newMessage;
    public $recipientId;

    #[On('userSelected')]
    public function mount($recipientId)
    {
        $this->recipientId = $recipientId;
        // Log recipientId to check if it is being set correctly
        Log::info('Recipient ID: ' . $this->recipientId);

        $this->loadMessages();
    }

    // Load the chat messages between the authenticated user and the recipient
    public function loadMessages()
    {
        $this->messages = ProfileChat::where(function ($query) {
            $query->where('sender', Auth::id())
                ->where('recipient', $this->recipientId);
        })
            ->orWhere(function ($query) {
                $query->where('sender', $this->recipientId)
                    ->where('recipient', Auth::id());
            })
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    // Method to send a new message
    public function sendMessage()
    {
        $validatedData = $this->validate([
            'newMessage' => 'required|string',
        ]);

        // Check if recipientId is set
        if (is_null($this->recipientId)) {
            // Log or throw an error
            Log::error('Recipient ID is not set while sending message.');
            return; 
        }

        $message = ProfileChat::create([
            'sender' => Auth::id(),
            'recipient' => $this->recipientId,
            'message' => $validatedData['newMessage'],
        ]);

        // Clear the input field
        $this->newMessage = '';

        // Trigger a frontend event to notify Pusher
        broadcast(new MessageSent($message))->toOthers();

        Log::info('Message sent: ' . $message->message);

        // Reload messages
        $this->loadMessages();
    }

    // Listener method for receiving new messages
    
    #[On('messageReceived')]
    public function onMessageReceived()
    {
        $this->loadMessages();

        Log::info('Message Recevied!');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
