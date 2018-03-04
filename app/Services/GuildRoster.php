<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use BlizzardApi\Service\WorldOfWarcraft;

class GuildRoster
{
    /**
     * Contains the World of Warcraft API instance.
     *
     * @var \BlizzardApi\Service\WorldOfWarcraft
     */
    protected $client;

    /**
     * Render the homepage.
     *
     * @param  \BlizzardApi\Service\WorldOfWarcraft  $client
     * @return void
     */
    public function __construct(WorldOfWarcraft $client)
    {
        $this->client = $client;
    }

    /**
     * Get the roster for the specified guild.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRoster($realm = 'Silvermoon', $guild = 'The Road Less Travelled')
    {
        $cache_key = implode('_', [$realm, $guild]);

        // Attempt to fetch the roster from the cache...
        if (Cache::tags(['battlenet', 'roster'])->has($cache_key)) {
            return Cache::tags(['battlenet', 'roster'])->get($cache_key);
        }

        // Fetch a fresh copy of the cache from Battle.net...
        $response = json_decode(
            $this->client->getGuild($realm, $guild, ['fields' => 'members'])
                ->getBody()
                ->getContents()
        );

        // Wrap the roster in a collection...
        $roster = collect($response->members);

        // Cache the fetched roster for 30 minutes...
        Cache::tags(['battlenet', 'roster'])->put($cache_key, $roster, now()->addMinutes(30));

        return $roster;
    }
}
