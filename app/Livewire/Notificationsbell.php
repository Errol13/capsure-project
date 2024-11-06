<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Notificationsbell extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function getListeners()
    {
        return [
            'refreshNotifications' => 'loadNotifications',
        ];
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notificationsbell', [
            'notifications' => $this->notifications,
        ]);
    }
}