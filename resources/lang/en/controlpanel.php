<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Control Panel Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the control panel only
    | accessible by members of the Inner Circle.
    |
    */

    'applications' => 'Applications',
    'control_panel' => 'Control Panel',
    'create_event' => 'Create a new event',
    'create_news_item' => 'Create a news item',
    'create_team' => 'Create a new team',
    'events' => 'Events',
    'edit_event' => 'Edit an event',
    'edit_news_item' => 'Edit a news item',
    'edit_team' => 'Manage a team',
    'forum' => 'Forum',
    'inner_circle' => 'Inner Circle',
    'manage_forum_boards' => 'Manage boards',
    'manage_members' => 'Manage members',
    'manage_ranks' => 'Manage guild ranks',
    'marketplace' => 'Marketplace',
    'message_team' => 'Message a team',
    'news' => 'News',
    'not_yet_implemented' => '(not yet implemented)',
    'review_marketplace_transactions' => 'Review transactions',
    'roster' => 'Roster',
    'send_event_reminder' => 'Send a reminder to attendees',
    'teams' => 'Teams',
    'view_marketplace_statistics' => 'View stats',
    'view_new_applicants' => 'View new applicants',
    'view_all_applicants' => 'View all applicants',

    /*
    |--------------------------------------------------------------------------
    | Manage Ranks Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the control panel section for
    | managing guild ranks.
    |
    */

    'ranks' => [
        'errors' => [
            'title' => 'This must not be empty.',
            'seniority' => 'This must be between (1) and (25).',
            'kudos_per_day' => 'This must either be empty (for unlimited) or be between (0) and (100).',
            'kudos_required' => 'This must be at least (0).',
            'empty' => 'This must not be empty.',
        ],

        'abbr_unlimited' => '∞',
        'btn_cancel' => 'Cancel',
        'btn_create_rank' => 'Create Rank',
        'btn_delete' => 'Delete Rank',
        'btn_edit' => 'Edit Rank',
        'btn_new_rank' => 'New Rank',
        'btn_save' => 'Save',
        'field_unlimited' => 'Unlimited',
        'hdr_title' => 'Title',
        'hdr_seniority' => 'Seniority',
        'hdr_kudos_per_day' => 'Kudos per day',
        'hdr_kudos_required' => 'Kudos required',
        'hdr_discord_role' => 'Discord role',
        'hdr_actions' => 'Actions',
        'hdr_new_rank' => 'New rank',
        'warn_delete_is_permanent' => [
            'p1' => 'Deleting this rank is permanent. Once it’s done, there’s no going back. Ever.',
            'p2' => 'Well, I suppose you could always create a new rank with the same details, but that’s a great use of your time... 🤦‍♂️',
        ],

        'are_you_sure' => 'Are you sure?',
        'no_role' => '(No Role)',
        'users_to_move' => [
            'lead' => 'First though, there are users that need moving to another rank. Pick a rank to move these users to.',
            'small' => 'This will only affect the website and Discord. This box has no control over Blizzard’s data.',
        ],
        'whoa' => 'Whoa there!',
   ],

];
