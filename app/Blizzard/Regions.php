<?php

namespace App\Blizzard;

trait Regions
{
    static public $regions = [
        'eu' => [
            'en_gb',
            'de_de',
            'es_es',
            'fr_fr',
            'it_it',
            'pl_pl',
            'pt_pt',
            'ru_ru',
        ],
        'us' => [
            'en_us',
            'pt_br',
            'es_mx',
        ],
        'kr' => [
            'ko_kr',
        ],
        'tw' => [
            'zh_tw',
        ],
        'sea' => [
            'en_us',
        ],
    ];
}
