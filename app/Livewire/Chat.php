<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Profile\Chat as ProfileChat;
use App\Models\User;
use Illuminate\Support\Carbon;
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
    public $otherUser;


    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $this->selectedConversationId = $conversationId; //make the convo selected based on id in the url
            $this->loadMessages(10);
            $this->setRecipient();
            $this->otherUser = User::find($this->recipientId);
        }
    }

    #[On('conversationSelected')] // Update the event name to conversationSelected
    public function conversationSelected($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->messages = []; // Clear current messages

        $this->loadMessages(); // Load new messages
        $this->setRecipient();
        // Log::info('Conversation selected: ' . $conversationId);

        $this->otherUser = User::find($this->recipientId);
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

        // Mark all messages in the selected conversation as read
        ProfileChat::where('conversation_id', $this->selectedConversationId)
            ->where('recipient', Auth::id()) // Only mark messages for the current user as read
            ->where('isRead', false)
            ->update(['isRead' => true]);

        // Reverse the array to display from oldest to newest in the chat
        $this->messages = array_reverse($this->messages);

        $this->dispatch('loadToBottom');
    }


    #[On('loadMoreMessages')]
    public function loadMoreMessages()
    {
        if (!$this->selectedConversationId) return;

        // If there are no messages yet, just return (nothing to load)
        if (count($this->messages) === 0) return;

        // Get the timestamp or ID of the most recent message
        $lastMessage = $this->messages[0];  // messages are ordered with the most recent at index 0
        $lastMessageCreatedAt = $lastMessage['created_at'];  // Adjust this depending on how your messages are structured

        $lastMessageCreatedAtCarbon = Carbon::parse($lastMessageCreatedAt)->timezone('Asia/Manila');

        // $first = ProfileChat::where('conversation_id', $this->selectedConversationId)
        // ->first();

        //  dd('type of format of created_at: ' . $first->created_at , 'Last message created_at: ' . $lastMessageCreatedAtCarbon);

        // Fetch older messages than the most recent one
        $olderMessages = ProfileChat::where('conversation_id', $this->selectedConversationId)
            ->where('created_at', '<', $lastMessageCreatedAtCarbon) // Fetch messages created before the most recent message
            ->orderBy('created_at', 'desc') // Ensure messages are ordered correctly
            ->take(10) // Load 10 more messages
            ->get()
            ->toArray();

        // // Check if we fetched any older messages
        // Log::info('Fetched messages: ', ['messages' => count($olderMessages)]);

        // If no older messages are found, we don't need to do anything
        if (count($olderMessages) === 0) return;

        // Prepend the older messages to the existing ones
        $this->messages = array_merge($olderMessages, $this->messages); // Prepend, not append

        $this->dispatch('messagesLoaded');
    }



    public function updateMessageStatus($messageId)
    {
        // Fetch the message and update its status
        $message = ProfileChat::find($messageId);
        if ($message && $message->recipient === auth()->id() && !$message->isRead) {
            $message->update(['isRead' => true]);

            $this->dispatch('messageRead', $messageId); // This event will trigger frontend updates
        }
    }


    // Set the recipient based on the selected conversation
    protected function setRecipient()
    {
        $conversation = Conversation::find($this->selectedConversationId);
        if ($conversation) {
            // Determine recipient ID based on sender and authenticated user
            $this->recipientId = ($conversation->sender_id === Auth::id()) ? $conversation->recipient_id : $conversation->sender_id;
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
            // Log::error('Selected Conversation ID is not set while sending message.');
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
        // Log::info('Message received!');

        //updates the user-list
        $this->dispatch('refreshUserList');
    }

    public function render()
    {
        return view('livewire.chat', [
            'messages' => $this->messages,
            'otherUser' => $this->otherUser,
        ]);
    }
}
