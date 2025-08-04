<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancellationNotification extends Notification
{
    // By Asfia
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected $ad = null,
        protected $property = null,
        protected $cancel_reason = null
    ) {
        $this->ad = $ad;
        $this->property = $property;
        $this->cancel_reason = $cancel_reason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->ad ? 'Your Ad has been Cancelled' : 'Your Property has been Cancelled')
            ->line($this->ad ? 'We regret to inform you that your ad has been cancelled.' : 'We regret to inform you that your property has been cancelled.')
            ->line($this->ad ? 'Reason for cancellation: ' . $this->ad->cancel_reason : 'Reason for cancellation:' . $this->property->cancel_reason)
            ->line('If you have any questions or need further assistance, please feel free to contact us at +92 51 111 342 360.')
            ->line('Thank you for choosing DHA360. We greatly appreciate your trust in our services.');
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return [
            'message' => $this->ad ? 'Your ad has been cancelled.' : 'Your property has been cancelled',
            'reason' => $this->cancel_reason,
            'ad_id' => $this->ad?->id,
            'property_id' => $this->property ? $this->property?->id : null,
        ];
    }
}
