<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserList extends Component
{
    public $chatUsers = []; // List of users you have chatted with
    public $selectedUserId; // The ID of the user you're currently chatting with
    public $search = ''; // Property for search input

    public function mount()
    {
        // Load the users you have chatted with or other potential users
        $this->loadChatUsers();
    }

    // Load chat users based on the search term
    public function loadChatUsers()
    {
        $this->chatUsers = User::where('id', '!=', Auth::id())
            ->where(function ($query) {
                $query->whereIn('id', function ($subquery) {
                    $subquery->select('recipient')
                        ->from('chats')
                        ->where('sender', Auth::id());
                })
                    ->orWhereIn('id', function ($subquery) {
                        $subquery->select('sender')
                            ->from('chats')
                            ->where('recipient', Auth::id());
                    });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->limit(100) // Limit to 100 users
            ->get();
    }

    // Method to handle user selection
    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;

        // Store the selected user ID in the session for use by the Chat component
        session(['selectedUserId' => $userId]);

        // Refresh the Chat component
        $this->dispatch('userSelected', $userId);
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
