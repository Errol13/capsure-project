<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ApplicationRejected extends Notification
{
    use Queueable;

    public $eventJob;

    public function __construct($eventJob)
    {
        $this->eventJob = $eventJob;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your application for the job has been rejected.',
            'url' => route('my-jobs'),
        ];
    }
}
