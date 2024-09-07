<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function getListeners()
    {
        return [
            'refreshNotifications' => 'refreshNotifications',
        ];
    }

    public function refreshNotifications()
    {
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->refreshNotifications();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
