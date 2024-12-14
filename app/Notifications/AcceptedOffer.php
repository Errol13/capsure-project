<?php

namespace App\Notifications;

use App\Models\Hiring\EventJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptedOffer extends Notification
{
    use Queueable;

    protected $firstName;
    protected $lastName;
    protected $eventId;
    protected $eventName;

    /**
     * Create a new notification instance.
     */
    public function __construct($hiringRequest, $user)
    {
        //find the eventId using the job_id
        $eventJob = EventJob::where('job_id', $hiringRequest->job_id)->first();
        $event = $eventJob->event;

        $this->eventId = $event->event_id;
        $this->eventName = $event->title;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
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

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->firstName} {$this->lastName} accepted your offer.",
            'url' => $this->getUrlBasedOnUserType($notifiable),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("{$this->firstName} {$this->lastName} accepted your offer. Event: {$this->eventName}.")
            ->action('View Details', $this->getUrlBasedOnUserType($notifiable)) // Use dynamic URL
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
            'message' => "{$this->firstName} {$this->lastName} accepted your offer.",
            'url' => $this->getUrlBasedOnUserType($notifiable),
        ];
    }

    /**
     * Dynamically generate the URL based on user type.
     */
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
