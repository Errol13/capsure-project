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

    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $this->selectedConversationId = $conversationId; //make the convo selected based on id in the url
            $this->loadMessages(10);
            $this->setRecipient();
        }
    }

    #[On('conversationSelected')] // Update the event name to conversationSelected
    public function conversationSelected($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->messages = []; // Clear current messages

        $this->loadMessages(); // Load new messages
        $this->setRecipient();
        Log::info('Conversation selected: ' . $conversationId);

        $this->dispatch('hideLoadingState');
    }

    public function loadMessages($limit = 10)
    {
        if (!$this->selectedConversationId) return;

        // Load the latest messages for the selected conversation
        $this->messages = ProfileChat::where('conversation_id', $this->selectedConversationId)
            ->orderBy('created_at', 'desc') // Get the latest messages first
            ->take($limit)
            ->get()
            ->toArray();

        // Reverse the array to display from oldest to newest in the chat
        $this->messages = array_reverse($this->messages);
    }


    #[On('loadMoreMessages')]
    public function loadMoreMessages()
    {
        if (!$this->selectedConversationId) return;

        // Load older messages in ascending order
        $olderMessages = ProfileChat::where('conversation_id', $this->selectedConversationId)
            ->orderBy('created_at', 'asc') // Order by created_at in ascending order
            ->skip(count($this->messages)) // Skip already loaded messages
            ->take(10) // Load 10 more messages
            ->get()
            ->toArray();

        // Check for duplicates before merging
        $existingMessageIds = collect($this->messages)->pluck('id')->toArray(); // Assuming each message has a unique ID
        $filteredOlderMessages = array_filter($olderMessages, function ($message) use ($existingMessageIds) {
            return !in_array($message['id'], $existingMessageIds); // Only include new messages
        });

        // Prepend the filtered older messages to the current messages
        $this->messages = array_merge($this->messages, $filteredOlderMessages);
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

        // update the conversation's last message timestamp
        Conversation::where('conversation_id', $this->selectedConversationId) // Update last_time_message for the selected conversation
            ->update(['last_time_message' => now()]);

        // Clear the input field
        $this->newMessage = '';

        // Trigger a frontend event to notify others
        broadcast(new MessageSent($message))->toOthers();

        //trigger or refresh the user-list
        $this->dispatch('refreshUserList');

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
