<?php

namespace App\Blizzard\Warcraft;

use App\Blizzard\Warcraft\Service as WarcraftService;
use Illuminate\Support\Facades\Cache;

class Classes
{
    /**
     * Contains the races collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $classes;

    protected $classic_classes = [
        'alliance' => [
            1,  // Warrior
            2,  // Paladin
            3,  // Hunter
            4,  // Rogue
            5,  // Priest
            8,  // Mage
            9,  // Warlock
            11, // Druid
        ],
        'horde' => [
            1,  // Warrior
            3,  // Hunter
            4,  // Rogue
            5,  // Priest
            7,  // Shaman
            8,  // Mage
            9,  // Warlock
            11, // Druid
        ],
    ];

    /**
     * Construct the repository.
     */
    public function __construct(WarcraftService $client)
    {
        // First check the cache for the list of classes...
        if (Cache::tags(['blizzard', 'static'])->has('classes')) {
            $this->classes = Cache::tags(['blizzard', 'static'])->get('classes');
        }

        else {
            // Fetch the list of classes from the API...
            $response = json_decode(
                $client->getDataCharacterClasses()
                       ->getBody()
                       ->getContents()
            );

            // Wrap the classes in a collection then map the collection based
            // on the class ID...
            $this->classes = collect($response->classes)->mapWithKeys(function ($item) {
                return [$item->id => $item];
            });

            // Store the characters in the cache for a day...
            Cache::tags(['blizzard', 'static'])->put(
                'classes',
                $this->classes,
                now()->addHours(24)
            );
        }
    }

    /**
     * Get all the classes.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Get all the Classic classes.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getClassicClasses($faction)
    {
        return $this->classes->whereIn('id', $this->classic_classes[$faction]);
    }

    /**
     * Gets a specific class.
     *
     * @param  int  $id
     * @return mixed
     */
    public function getClass($id)
    {
        return $this->classes->get($id);
    }
}
