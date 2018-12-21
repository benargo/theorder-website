<?php

namespace App;

trait KudosReasons
{
    protected static $reasons = [
        'community' => [
            'help',
            'thanks',
        ],
        'discord' => ['slash_command'],
        'effort',
        'forum_post' => [
            'answer',
            'like',
        ],
        'just_because',
        'marketplace' => [
            'deal',
            'thanks',
        ],
        'news_article_comment' => [
            'like',
        ],
        'raid' => [
            'attendance',
            'contribution',
        ],
    ];

    /**
     * Gets a collection containing the possible reasons that kudos can be
     * awarded.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getPossibleReasons()
    {
        return collect(self::$reasons);
    }
}
