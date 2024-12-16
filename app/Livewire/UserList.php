<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Conversation; // Import the Conversation model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Log::info('RETAINED:' . $this->selectedConversationId);

        // Load the users you have chatted with or other potential users
        $this->loadConversations();
    }


    public function loadConversations()
    {
        // Get all conversations where the user is either the sender or recipient
        $query = Conversation::where('sender_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->with(['sender', 'recipient', 'messages' => function ($query) {
                $query->latest(); // Eager load all messages, ordered by latest
            }]);

        // Get all conversations
        $conversations = $query->get();

        // If a search term is provided, filter the conversations 
        if (!empty($this->search)) {
            $conversations = $conversations->filter(function ($conversation) {
                // Created full name for sender and recipient
                $senderFullName = $conversation->sender->first_name . ' ' . $conversation->sender->last_name;
                $recipientFullName = $conversation->recipient->first_name . ' ' . $conversation->recipient->last_name;

                // Check if the search term matches the sender's or recipient's first name, last name, or full name
                return (stripos($conversation->sender->first_name, $this->search) !== false ||
                    stripos($conversation->sender->last_name, $this->search) !== false ||
                    stripos($senderFullName, $this->search) !== false || // Full name check
                    stripos($conversation->recipient->first_name, $this->search) !== false ||
                    stripos($conversation->recipient->last_name, $this->search) !== false ||
                    stripos($recipientFullName, $this->search) !== false); // Full name check
            });
        }

        // Sort the conversations by the latest message timestamp
        $this->conversations = $conversations->sortByDesc(function ($conversation) {
            return $conversation->messages->isNotEmpty() ? $conversation->messages->first()->created_at : null;
        });

        // If no conversations match, return an empty array
        if (empty($this->conversations)) {
            $this->conversations = []; // Empty array if no results found
        }
    }


    //listen to any sending message events and refresh the list
    #[On('refreshUserList')]
    public function refreshTheUserList()
    {

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
        // dd('HEY');
        $this->dispatch('refreshUserList');
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
