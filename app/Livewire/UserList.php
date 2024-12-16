<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Conversation; // Import the Conversation model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class UserList extends Component
{
    public $selectedConversationId; // The ID of the selected conversation
    public $conversations = []; // list of convos
    public $search = ''; // Property for search input

    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $this->selectedConversationId = $conversationId; //make the convo selected based on id in the url
        }

        Log::info('RETAINED:' . $this->selectedConversationId);

        // Load the users you have chatted with or other potential users
        $this->loadConversations();
    }

    // Load chat users based on the search term and existing conversations
    public function loadConversations()
    {
        $this->conversations = Conversation::where('sender_id', Auth::id())
        ->orWhere('recipient_id', Auth::id())
        ->with(['sender', 'recipient', 'messages' => function ($query) {
            $query->latest(); // Eager load all messages, ordered by latest
        }])
        ->get()
        ->sortByDesc(function ($conversation) {
            // Return the timestamp of the latest message, if it exists
            return $conversation->messages->isNotEmpty() ? $conversation->messages->first()->created_at : null;
        });
    }

    //listen to any sending message events and refresh the list
    #[On('refreshUserList')]
    public function refreshTheUserList(){

        $this->loadConversations();
    }


    // Method to handle conversation selection
    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;

        //Log::info('ID selected'. $conversationId);

        $url = url("/chat/{$conversationId}");
        $this->dispatch('update-url', $url);

        Log::info('ID selected' . $url);
        $this->loadConversations();
        //show the loading state
        $this->dispatch('showLoadingState');

        // Refresh the Chat component
        $this->dispatch('conversationSelected', $conversationId);
    }

    // Update the chat users when the search term changes
    public function updatedSearch()
    {
        $this->loadConversations();
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
