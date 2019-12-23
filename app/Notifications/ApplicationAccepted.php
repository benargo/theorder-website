<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Discord\Channels\RecruitmentChannel;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationAccepted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database',
            DiscordChannel::class,
        ];
    }

    public function toDiscord($notifiable)
    {
        if ($notifiable instanceof RecruitmentChannel::class) {
            
        }
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
            'title' => 'Application accepted!',
            'body'  => '<p>The Inner Circle are delighted to announce that your application has been accepted! Someone will be in touch with you, either via Discord or in-game very soon to invite you to the guild.</p>'
        ];
    }
}
