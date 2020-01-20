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

class RaidSignUpsClosed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $raid;
    protected $confirmed_team;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Raid $raid, $confirmed_team)
    {
        $this->raid = $raid;
        $this->confirmed_team = $confirmed_team;
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
            "Raid signups are now closed for {$raids_titles} on {$date}",
            [
                'title' => "Raid Signups: {$raids_abbrs} on {$date}",
                'type' => 'rich',
                'description' => "Sign ups are now closed for {$raids_titles} on {$date}. The list of confirmed members is as follows:",
                'url' => $url,
                'timestamp' => Carbon::now()->toIso8601String(),
                'color' => hexdec('dc3545'),
                'thumbnail' => [
                    'url' => $icon,
                ],
                'author' => ['name' => 'Rudolf'],
                'fields' => [
                    [
                        'name' => 'Tanks',
                        'value' => "- ".$this->confirmed_team->where('role', 'tank')->implode(", \r\n- "),
                    ],
                    [
                        'name' => 'Healers',
                        'value' => "- ".$this->confirmed_team->where('role', 'healer')->implode(", \r\n- "),
                    ],
                    [
                        'name' => 'Damage',
                        'value' => "- ".$this->confirmed_team->where('role', 'damage')->implode(", \r\n- "),
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
