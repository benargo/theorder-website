<?php

namespace App\Blizzard\Warcraft;

use App\Blizzard\Warcraft\Service as WarcraftService;
use Illuminate\Support\Facades\Cache;

class Races
{
    /**
     * Contains the races collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $races;

    protected $classic_races = [
        'alliance' => [
            1,  // Human
            3,  // Dwarf
            4,  // Night Elf
            7,  // Gnome
        ],
        'horde' => [
            2,  // Orc
            5,  // Undead
            6,  // Tauren
            8,  // Troll
        ],
    ];

    /**
     * Construct the repository.
     */
    public function __construct(WarcraftService $client)
    {
        // First check the cache for the list of races...
        if (Cache::tags(['blizzard', 'static'])->has('races')) {
            $this->races = Cache::tags(['blizzard', 'static'])->get('races');
        }
        else {
            // Fetch the list of races from the API...
            $response = json_decode(
                $client->getDataCharacterRaces()
                     ->getBody()
                     ->getContents()
            );

            // Wrap the races in a collection then map the collection based on
            // the race ID...
            $this->races = collect($response->races)->mapWithKeys(function ($item) {
                return [$item->id => $item];
            });

            // Store the characters in the cache for a day...
            Cache::tags(['blizzard', 'static'])->put(
                'races',
                $this->races,
                now()->addDays(30)
            );
        }
    }

    /**
     * Get all the races.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRaces()
    {
        return $this->races;
    }

    /**
     * Get all the Classic races.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getClassicRaces($faction)
    {
        return $this->races->whereIn('id', $this->classic_races[$faction]);
    }

    /**
     * Gets a specific race.
     *
     * @param  int  $id
     * @return mixed
     */
    public function getRace($id)
    {
        return $this->races->get($id);
    }
}
