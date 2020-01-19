<?php

namespace App\Notifications;

use App;
use Carbon\Carbon;
use App\Raiding\Raid;
use Illuminate\Bus\Queueable;
use App\Blizzard\Warcraft\Instances\Raids;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class RaidSignUpsAvailable extends Notification
{
    protected $raid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Raid $raid)
    {
        $this->raid = $raid;
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
        $date = $this->raid->starts_at->format('l dS F Y @ H:i T');
        $raids = new Raids;
        $raids = $raids->whereIn('zone_id', $this->raid->instance_ids);
        $raids_abbrs = $raids->implode('abbr', '/');
        $raids_titles = $raids->implode('name', '/');
        $max_players = $raids->max('max_players');
        $url = route('raids.single', $this->raid->id);
        $icon = asset('images/raid_icon_'.strtolower($raids->take(1)->get('abbr')).'.png');

        return DiscordMessage::create(
            "Raid signups are now available for {$raids_titles} on {$date}",
            [
                'title' => "Raid Signups: {$raids_abbrs} on {$date}",
                'type' => 'rich',
                'description' => "Sign up now to enter the ballot for the raid {$raids_titles} on {$date}. Only {$max_players} players can be selected.",
                'url' => $url,
                'timestamp' => Carbon::now()->toIso8601String(),
                'color' => hexdec('f8b700'),
                'thumbnail' => [
                    'url' => $icon,
                ],
                'author' => ['name' => 'Rudolf'],
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
