<?php

namespace App\Notifications;

use App\Guild\Application;
use Illuminate\Bus\Queueable;
use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationReceived extends Notification
{
    protected $application;
    protected $classes;
    protected $races;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->classes     = App::make(Classes::class);
        $this->races       = App::make(Races::class);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    /**
     * Get the Discord representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Discord\DiscordMessage
     */
    public function toDiscord($notifiable)
    {
        $url = url('inner-circle/applications?status=pending');

        return DiscordMessage::create(
            "Hey chaps! {$this->application->character_name} just applied to join The Order. If someone could review the application please?\n\n{$url}",
            [
                'title' => 'Guild Applications',
                'type' => 'rich',
                'description' => "{$this->application->character_name} has applied to join The Order.",
                'url' => $url,
                'timestamp' => $this->application->created_at->toIso8601String(),
                'color' => hexdec('f8b700'),
                'thumbnail' => [
                    'url' => asset('images/guild_emblem.png'),
                ],
                'fields' => [
                    [
                        'name'  => 'Character name',
                        'value' => $this->application->character_name,
                    ],
                    [
                        'name'   => 'Race',
                        'value'  => $this->races->getRace($this->application->race_id)->name,
                        'inline' => true,
                    ],
                    [
                        'name'   => 'Class',
                        'value'  => $this->classes->getClass($this->application->class_id)->name,
                        'inline' => true,
                    ],
                    [
                        'name'  => 'Role',
                        'value' => ucfirst($this->application->role),
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
