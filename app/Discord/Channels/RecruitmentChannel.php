<?php

namespace App\Discord\Channels;

use App\Contracts\Discord\Channel;
use Illuminate\Notifications\AnonymousNotifiable;

class RecruitmentChannel extends AnonymousNotifiable implements Channel
{
    public function routeNotificationForDiscord()
    {
        return config('discord.channels.recruitment');
    }
}
