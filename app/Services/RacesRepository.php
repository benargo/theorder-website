<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use BlizzardApi\Service\WorldOfWarcraft;

class RacesRepository
{
    /**
     * Contains the races collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $races;

    /**
     * Construct the repository.
     *
     * @param \BlizzardApi\Service\WorldOfWarcraft  $client
     */
    public function __construct(WorldOfWarcraft $client)
    {
        // First check the cache for the list of races...
        if (Cache::tags(['battlenet'])->has('races')) {
            $this->races = Cache::tags(['battlenet'])->get('races');
        }
        else {
            // Fetch the list of races from the API...
            $response = json_decode(
                $client->getDataCharacterRaces()
                     ->getBody()
                     ->getContents()
            );

            // Wrap the races in a collection then map the collection based on the
            // Race ID...
            $this->races = collect($response->races)->mapWithKeys(function ($item) {
                return [$item->id => $item];
            });

            // Store the characters in the cache for a day...
            Cache::tags(['battlenet'])->put(
                'races',
                $this->races,
                now()->addHours(24)
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
