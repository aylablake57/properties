<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminApprovalNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected $ad = null,
        protected $property = null
    ) { }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; 
    }

    /**
     * Get the database notification representation.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->ad 
                ? 'A new ad requires your approval.'
                : 'A new property requires your approval.',
            'ad_id' => $this->ad?->id,
            'property_id' => $this->property?->id,
        ];
    }
}
