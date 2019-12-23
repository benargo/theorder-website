<?php

namespace App\Blizzard\Warcraft\Instances;

use Illuminate\Support\Collection;

class Raids
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([
            [
                'zone_id' => 2159,
                'abbr' => 'Ony',
                'name' => 'Onyxia\'s Lair',
                'max_players' => 40,
                'position' => 0,
            ],
            [
                'zone_id' => 2717,
                'abbr' => 'MC',
                'name' => 'Molten Core',
                'max_players' => 40,
                'position' => 1,
            ],
            [
                'zone_id' => 2677,
                'abbr' => 'BWL',
                'name' => 'Blackwing Lair',
                'max_players' => 40,
                'position' => 2,
            ],
            [
                'zone_id' => 1977,
                'abbr' => 'ZG',
                'name' => 'Zul\'Gurub',
                'max_players' => 20,
                'position' => 3,
            ],
            [
                'zone_id' => 3429,
                'abbr' => 'AQ20',
                'name' => 'Ruins of Ahn\'Qiraj',
                'max_players' => 20,
                'position' => 4,
            ],
            [
                'zone_id' => 3428,
                'abbr' => 'AQ40',
                'name' => 'Ahn\'Qiraj',
                'max_players' => 40,
                'position' => 5,
            ],
            [
                'zone_id' => 3456,
                'abbr' => 'Naxx',
                'name' => 'Naxxramas',
                'max_players' => 40,
                'position' => 6,
            ],
        ]);
    }

    public function __get($key)
    {
        return $this->items->{$key};
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->items, $method], $args);
    }
}
