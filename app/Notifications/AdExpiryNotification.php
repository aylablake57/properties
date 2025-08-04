<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdExpiryNotification extends Notification
{
    use Queueable;

    protected $ad;
    protected $days;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ad, $days)
    {
        $this->ad = $ad;
        $this->days = $days;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; 
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Ad Expiry Notice')
                    ->line('One of your ads will expire in "' . $this->days . '" days.')
                    ->action('Renew Ad', url('/ads/' . $this->ad->id . '/renew'))
                    ->line('Thank you for using our service!');
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
            'message' => 'One of your ads will expire in '. $this->days .' days.',
            'ad_id' => $this->ad->id,
        ];
    }
}