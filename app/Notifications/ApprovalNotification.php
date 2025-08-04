<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalNotification extends Notification
{
    public function __construct(
        protected $ad = null,
        protected $property = null
    ) {
        
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->ad ? 'Your Ad is Now Live on DHA360!' : 'Your Property is Now Live on DHA360!')
                    ->line($this->ad 
                        ? 'Congratulations! We are excited to inform you that your ad has been successfully approved and is now live on DHA360. Your ad is now visible to potential clients and ready to generate interest!'
                        : 'Congratulations! We are thrilled to inform you that your property has been successfully approved and is now live on DHA360. Your listing is ready to attract potential buyers!'
                    )
                    ->line($this->ad 
                        ? 'If you have any questions or need further assistance, please feel free to contact us at +92 51 111 342 360.'
                        : 'If you have any questions or need further assistance, please feel free to contact us at +92 51 111 342 360.'
                    )
                    ->line($this->ad 
                        ? 'Thank you for choosing DHA360. We greatly appreciate your trust in our services.' 
                        : 'Thank you for choosing DHA360. We truly appreciate your trust in our services.');
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
            'message' => $this->ad 
                ? 'Great news! Your ad has been successfully approved!'
                : 'Great news! Your property has been successfully approved!',
            'ad_id' => $this->ad?->id,
            'property_id' => $this->property?->id,
        ];
    }
}
