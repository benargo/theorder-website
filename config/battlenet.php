<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Battle.net Api configuration
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Battle.net API Key
    |--------------------------------------------------------------------------
    |
    | Before you be able to make requests to the Battle.net API, you need to provide your API key.
    | If you don't have an API key, refer to https://dev.battle.net/docs to get an API key
    |
    */

    'key' => env('BATTLENET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Battle.net API Secret
    |--------------------------------------------------------------------------
    */

   'secret' => env('BATTLENET_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Battle.net Locale
    |--------------------------------------------------------------------------
    |
    | Define what locale to use for the Battle.net API response.
    | For examples: en_GB | fr_FR | de_DE | ru_RU
    |
    */
    'locale' => 'en_GB',

    /*
    |--------------------------------------------------------------------------
    | Battle.net Region
    |--------------------------------------------------------------------------
    |
    | Define the Region API.
    |
    */
    'region' => 'eu',

];
