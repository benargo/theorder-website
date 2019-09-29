<?php

namespace App\Discord\Channels;

use Illuminate\Notifications\Notifiable;

class RecruitmentChannel
{
    use Notifiable;

    public function routeNotificationForDiscord()
    {
        return config('discord.channels.recruitment');
    }
}
