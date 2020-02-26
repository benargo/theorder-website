<?php

namespace App\Discord\Channels;

use App\Contracts\Discord\Channel;
use Illuminate\Notifications\Notifiable;

class RecruitmentChannel implements Channel
{
    use Notifiable;

    public function routeNotificationForDiscord()
    {
        return config('discord.channels.recruitment');
    }
}
