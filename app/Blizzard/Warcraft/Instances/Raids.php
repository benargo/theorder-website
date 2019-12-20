<?php

namespace App\Blizzard\Warcraft\Instances;

use Illuminate\Support\Collection;

class Raids extends Collection
{
    protected $items = [
        1977 => [
            'zone_id' => 1977,
            'abbr' => 'ZG',
            'name' => 'Zul\'Gurub',
            'max_players' => 20,
            'sort' => 3,
        ],
        2159 => [
            'zone_id' => 2159,
            'abbr' => 'Ony',
            'name' => 'Onyxia\'s Lair',
            'max_players' => 40,
            'sort' => 0,
        ],
        2677 => [
            'zone_id' => 2677,
            'abbr' => 'BWL',
            'name' => 'Blackwing Lair',
            'max_players' => 40,
            'sort' => 2,
        ],
        2717 => [
            'zone_id' => 2717,
            'abbr' => 'MC',
            'name' => 'Molten Core',
            'max_players' => 40,
            'sort' => 1,
        ],
        3428 => [
            'zone_id' => 3428,
            'abbr' => 'AQ40',
            'name' => 'Ahn\'Qiraj',
            'max_players' => 40,
            'sort' => 5,
        ],
        3429 => [
            'zone_id' => 3429,
            'abbr' => 'AQ20',
            'name' => 'Ruins of Ahn\'Qiraj',
            'max_players' => 20,
            'sort' => 4,
        ],
        3456 => [
            'zone_id' => 3456,
            'abbr' => 'Naxx',
            'name' => 'Naxxramas',
            'max_players' => 40,
            'sort' => 6,
        ],
    ];
}
