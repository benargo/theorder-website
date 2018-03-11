<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use BlizzardApi\Service\WorldOfWarcraft;

class ClassesRepository
{
    /**
     * Contains the races collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $classes;

    /**
     * Construct the repository.
     *
     * @param \BlizzardApi\Service\WorldOfWarcraft  $client
     */
    public function __construct(WorldOfWarcraft $client)
    {
        // First check the cache for the list of races...
        if (Cache::tags(['battlenet'])->has('classes')) {
            $this->classes = Cache::tags(['battlenet'])->get('classes');
        }
        else {
            // Fetch the list of races from the API...
            $response = json_decode(
                $client->getDataCharacterClasses()
                     ->getBody()
                     ->getContents()
            );

            // Wrap the races in a collection then map the collection based on the
            // Race ID...
            $this->classes = collect($response->classes)->mapWithKeys(function ($item) {
                return [$item->id => $item];
            });

            // Store the characters in the cache for a day...
            Cache::tags(['battlenet'])->put(
                'classes',
                $this->classes,
                now()->addHours(24)
            );
        }
    }

    /**
     * Get all the races.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Gets a specific race.
     *
     * @param  int  $id
     * @return mixed
     */
    public function getClass($id)
    {
        return $this->classes->get($id);
    }
}
