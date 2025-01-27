<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspensionNotice extends Notification
{
    use Queueable;

    protected array $reasons;
    protected string $duration;
    protected string $startDate;
    protected string $endDate;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $reasons, string $duration, string $startDate,string $endDate)
    {
        $this->reasons = $reasons;
        $this->duration = $duration;
        $this->startDate = $startDate;
        $this->endDate= $endDate;
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
        return [
            'message' => str_replace('\/', '/', "You are suspended for the following reasons: " 
                         . implode(', ', $this->reasons)
                         . ", with the duration of {$this->duration}. Suspension starts on {$this->startDate} and ends on {$this->endDate}."),
            'url' => $this->getUrlBasedOnUserType($notifiable),
        ];
    }
    

    private function getUrlBasedOnUserType($notifiable)
    {
        if ($notifiable->user_type === 'freelancer') {
            return route('freelancer-homepage' ); // Freelancer-specific route
        } elseif ($notifiable->user_type === 'client') {
            return route('client-homepage'); // Client-specific route
        }

        return url('/'); // Fallback URL if user type is not recognized
    }
}
