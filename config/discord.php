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
        'autokin' => [
            'key' => env('DISCORD_AUTOKIN_KEY'),
            'secret' => env('DISCORD_AUTOKIN_SECRET'),
            'token' => env('DISCORD_AUTOKIN_TOKEN'),
        ]
    ],

    'channels' => [
        'notices'     => env('DISCORD_CHANNEL_NOTICES', 479666941447897109),
        'recruitment' => env('DISCORD_CHANNEL_RECRUITMENT', 484387377956257804),
    ],

    'guild' => 470564810929733643,

];
