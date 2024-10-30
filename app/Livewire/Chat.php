<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Profile\Chat as ProfileChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public $messages = [];
    public $newMessage;
    public $selectedConversationId;
    public $recipientId;

    public function mount()
    {
        // Load initial messages if selectedConversationId is set from session
        $this->selectedConversationId = session('selectedConversationId');
        if ($this->selectedConversationId) {
            $this->loadMessages();
            $this->setRecipient();
        }
        // Log selectedConversationId to check if it is being set correctly
        Log::info('Selected Conversation ID: ' . $this->selectedConversationId);
    }

    #[On('conversationSelected')] // Update the event name to conversationSelected
    public function conversationSelected($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->messages = []; // Clear current messages
        $this->loadMessages(); // Load new messages
        $this->setRecipient();
        Log::info('Conversation selected: ' . $conversationId);
    }

    // Load the chat messages for the selected conversation
    public function loadMessages()
    {
        if (!$this->selectedConversationId) return;

        $this->messages = ProfileChat::where('conversation_id', $this->selectedConversationId) // Ensure this field exists in ProfileChat
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    // Set the recipient based on the selected conversation
    protected function setRecipient()
    {
        $conversation = Conversation::find($this->selectedConversationId);
        if ($conversation) {
            // Determine recipient ID based on sender and authenticated user
            $this->recipientId = ($conversation->sender_id === Auth::id()) ? $conversation->recipient_id : $conversation->sender_id;
            Log::info('Recipient ID set: ' . $this->recipientId);
        } else {
            Log::error('Conversation not found for ID: ' . $this->selectedConversationId);
        }
    }

    // Method to send a new message
    public function sendMessage()
    {
        $validatedData = $this->validate([
            'newMessage' => 'required|string',
        ]);

        // Check if selectedConversationId is set
        if (is_null($this->selectedConversationId)) {
            Log::error('Selected Conversation ID is not set while sending message.');
            return;
        }

        // Create a new chat message
        $message = ProfileChat::create([
            'sender' => Auth::id(),
            'recipient' => $this->recipientId,
            'conversation_id' => $this->selectedConversationId, // Use the conversation ID
            'message' => $validatedData['newMessage'],
        ]);

        // Optionally, update the conversation's last message timestamp
        Conversation::where('conversation_id', $this->selectedConversationId) // Update last_time_message for the selected conversation
            ->update(['last_time_message' => now()]);

        // Clear the input field
        $this->newMessage = '';

        // Trigger a frontend event to notify others
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
        Log::info('Message received!');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
