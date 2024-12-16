<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewOffer extends Notification
{
    use Queueable;

    protected $dealerName;
    protected $eventTitle;
    protected $eventId;

    /**
     * Create a new notification instance.
     */
    public function __construct($dealerName, $eventTitle, $eventId)
    {
        $this->dealerName = $dealerName;
        $this->eventTitle = $eventTitle;
        $this->eventId = $eventId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        Log::info('New Offer Notification Payload:', [
            'dealer_name' => $this->dealerName,
            'event_title' => $this->eventTitle,
            'url' => route('client-viewpost', [ 'id' => $this->eventId ]),
            'message' => "You have received a new offer from {$this->dealerName} for the event: {$this->eventTitle}",
        ]);
        
        return [
            'dealer_name' => $this->dealerName,
            'event_title' => $this->eventTitle,
            'url' => $this->getUrlBasedOnUserType($notifiable),
            'message' => "You have received a new offer from {$this->dealerName} for the event: {$this->eventTitle}",
        ];
    }

    private function getUrlBasedOnUserType($notifiable)
    {
        if ($notifiable->user_type === 'freelancer') {
            return route('my-jobs'); // Freelancer-specific route
        } elseif ($notifiable->user_type === 'client') {
            return route('client-viewpost', ['id' => $this->eventId]); // Client-specific route
        }

        return url('/'); // Fallback URL if user type is not recognized
    }
}
