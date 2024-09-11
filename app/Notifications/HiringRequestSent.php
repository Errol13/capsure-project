<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HiringRequestSent extends Notification
{
    use Queueable;

    protected $clientName;
    protected $eventTitle;

    /**
     * Create a new notification instance.
     *
     * @param string $clientName
     * @param string $eventTitle
     */
    public function __construct($clientName, $eventTitle)
    {
        $this->clientName = $clientName;
        $this->eventTitle = $eventTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Hiring Request')
                    ->line("You have received a new hiring request from {$this->clientName}.")
                    ->line("Event: {$this->eventTitle}")
                    ->action('View Request', url('/hiring-requests')) 
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'client_name' => $this->clientName,
            'event_title' => $this->eventTitle,
            'url' => route('my-jobs'),
            'message' => "You have received a new hiring request from {$this->clientName}. Event: {$this->eventTitle}",
        ];
    }
}
