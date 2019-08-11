<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Account Management Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used on account management pages.
    |
    */

    // TODO: Change key to 'alerts'
    'errors' => [
        'battlenet_api_504' => 'We encountered an error fetching data from Battle.net’s API. Would you mind <a class="alert-link" href="'. route('character-select') .'">trying again</a>?',
        'no_characters_found' => 'We couldn’t find any characters attached to your World of Warcraft account.',
        'no_silvermoon_characters_found' => 'We couldn’t find any characters belonging to our guild. Don’t panic though, it’s not a big deal.',
    ],

    'character_select_title' => 'Character Select',
    'character_select_lead' => 'Click any character you like to make it your main character on this site.',
    'character_summary' => 'Level :level :race :class',
    'character_select_confirmation' => 'Congratulations, your main character has been updated.',
    'email_help_block' => 'Must be a valid email address.',
    'introduction_account_settings' => 'Here you can modify the following account settings.',
    'my_account' => 'My Account',
    'nickname_help_block' => 'Nicknames must be between (3) and (32) characters, and use only letters and numbers.',

];
