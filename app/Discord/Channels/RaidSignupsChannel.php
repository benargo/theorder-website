<?php

namespace App\Discord\Channels;

use App\Contracts\Discord\Channel;
use Illuminate\Notifications\Notifiable;

class RaidSignupsChannel implements Channel
{
    use Notifiable;

    public function routeNotificationForDiscord()
    {
        return config('discord.channels.raid_signups');
    }
}
