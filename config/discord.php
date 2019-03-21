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
        'recruitment' => 484387377956257804,
    ],

    'guild' => 470564810929733643,

];
