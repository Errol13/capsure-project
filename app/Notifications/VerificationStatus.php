<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationStatus extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
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
            ->subject('Verification Status')
            ->line("{$this->message}")
            ->action('View Status', $this->getUrlBasedOnUserType($notifiable))
            ->line('Thank you for using our application!');
    }

    private function getUrlBasedOnUserType($notifiable)
    {
        if ($notifiable->user_type === 'freelancer') {
            return route('freelancer-settings' ); // Freelancer-specific route
        } elseif ($notifiable->user_type === 'client') {
            return route('client-settings'); // Client-specific route
        }

        return url('/'); // Fallback URL if user type is not recognized
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "{$this->message}",
            'url' => $this->getUrlBasedOnUserType($notifiable),
        ];
    }
}
