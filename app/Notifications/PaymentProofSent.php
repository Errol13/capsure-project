<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentProofSent extends Notification
{
    use Queueable;

    protected $clientName;
    protected $amountPaid;

    /**
     * Create a new notification instance.
     */
    public function __construct($clientFirstName, $clientLastName, $amountPaid )
    {
        //mount
        $this->clientName = $clientFirstName . ' ' . $clientLastName;
        $this->amountPaid = $amountPaid;
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
                    ->subject('New Payment')
                    ->line("You have received a new payment from {$this->clientName}.")
                    ->action('View Request', $this->getUrlBasedOnUserType($notifiable)) 
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
            'message' => "{$this->clientName} sent you a new payment.",
            'url' => $this->getUrlBasedOnUserType($notifiable),
        ];
    }

    private function getUrlBasedOnUserType($notifiable)
    {
        if ($notifiable->user_type === 'freelancer') {
            return route('freelancer-transaction' ); // Freelancer-specific route
        } elseif ($notifiable->user_type === 'client') {
            return route('client-transaction'); // Client-specific route
        }

        return url('/'); // Fallback URL if user type is not recognized
    }
}
