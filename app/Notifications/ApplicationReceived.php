<?php

namespace App\Notifications;

use App\Guild\Application;
use Illuminate\Bus\Queueable;
use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;


class ApplicationReceived extends Notification
{
    protected $classes;
    protected $races;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->classes = App::make(Classes::class);
        $this->races   = App::make(Races::class);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DiscordChannel::class, 'database'];
    }

    /**
     * Get the Discord representation of the notification.
     *
     * @param  App\Guild\Application  $notifiable
     * @return \NotificationChannels\Discord\DiscordMessage
     */
    public function toDiscord(Application $notifiable)
    {
        $url = url('inner-circle/applications?status=pending');

        return DiscordMessage::create(
            "Hey chaps! {$notifiable->character_name} just applied to join The Order. If someone could review the application please?\n\n{$url}",
            [
                'title' => 'Guild Applications',
                'type' => 'rich',
                'description' => "{$notifiable->character_name} has applied to join The Order.",
                'url' => $url,
                'timestamp' => $notifiable->created_at->toIso8601String(),
                'color' => hexdec('f8b700'),
                'thumbnail' => [
                    'url' => asset('images/guild_emblem.png'),
                ],
                'fields' => [
                    [
                        'name'  => 'Character name',
                        'value' => $notifiable->character_name,
                    ],
                    [
                        'name'   => 'Race',
                        'value'  => $this->races->getRace($notifiable->race_id)->name,
                        'inline' => true,
                    ],
                    [
                        'name'   => 'Class',
                        'value'  => $this->classes->getClass($notifiable->class_id)->name,
                        'inline' => true,
                    ],
                    [
                        'name'  => 'Role',
                        'value' => ucfirst($notifiable->role),
                    ],
                ],
            ]
        );
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
            //
        ];
    }
}
