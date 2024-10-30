<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Conversation; // Import the Conversation model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserList extends Component
{
    public $chatUsers = []; // List of users you have chatted with
    public $selectedConversationId; // The ID of the selected conversation
    public $search = ''; // Property for search input

    public function mount()
    {
        // Load the users you have chatted with or other potential users
        $this->loadChatUsers();
    }

    // Load chat users based on the search term and existing conversations
    public function loadChatUsers()
    {
        // Fetch conversations where the authenticated user is involved
        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->with(['sender', 'recipient']) // Eager load user relationships
            ->get();

        // Prepare the chat users based on the conversations
        $this->chatUsers = $conversations->map(function ($conversation) {
            // Determine the other user in the conversation
            $user = $conversation->sender_id == Auth::id() ? $conversation->recipient : $conversation->sender;

            return [
                'id' => $conversation->conversation_id, // Use the correct primary key
                'user' => $user, // This will be a User model instance
                'lastMessage' => $conversation->messages()->latest()->first(),
            ];
        });
    }

    // Method to handle conversation selection
    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;

        // Store the selected conversation ID in the session for use by the Chat component
        session(['selectedConversationId' => $conversationId]);

        // Refresh the Chat component
        $this->dispatch('conversationSelected', $conversationId);

        Log::info('Conversation selected: ' . $conversationId);
    }

    // Update the chat users when the search term changes
    public function updatedSearch()
    {
        $this->loadChatUsers();
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
