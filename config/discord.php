<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Discord API configuration
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    |
    | Before you be able to make requests to the Discord API, you need to
    | provide your API key.
    |
    */

    'clients' => [
        'guildbot' => [
            'key' => env('DISCORD_GUILDBOT_KEY'),
            'secret' => env('DISCORD_GUILDBOT_SECRET'),
            'token' => env('DISCORD_GUILDBOT_TOKEN'),
        ],
        'rudolf' => [
            'key' => env('DISCORD_RUDOLF_KEY'),
            'secret' => env('DISCORD_RUDOLF_SECRET'),
            'token' => env('DISCORD_RUDOLF_TOKEN'),
        ],
    ],

    'channels' => [
        'notices' => env('DISCORD_CHANNEL_NOTICES', 479666941447897109),
        'raids' => env('DISCORD_CHANNEL_RAIDS', 492290479111667722),
        'raid_signups' => env('DISCORD_CHANNEL_RAID_SIGNUPS', 667320284621045778),
        'recruitment' => env('DISCORD_CHANNEL_RECRUITMENT', 484387377956257804),
    ],

    'guild' => 470564810929733643,

];
