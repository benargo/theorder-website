<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use BlizzardApi\Service\WorldOfWarcraft;

/**
 * Homepage Controller
 *
 * This controller renders the home page. Pretty straight forward, huh?
 */
class HomeController extends Controller
{
    /**
     * Render the homepage.
     *
     * @param  \BlizzardApi\Service\WorldOfWarcraft  $api
     * @return \Illuminate\Http\Response
     */
    public function renderHomepage(WorldOfWarcraft $api)
    {
        // Fetch the roster from the cache, or the Battle.net API...
        $roster = Cache::get('roster', function () use ($api) {
            $response = json_decode(
                $api->getGuild('Silvermoon', 'The Road Less Travelled', ['fields' => 'members'])
                    ->getBody()
                    ->getContents()
            );

            $roster = collect($response->members);

            Cache::put('roster', $roster, now()->addMinutes(30));

            return $roster;
        });

        // Pluck the guild master from the roster...
        $guild_master = $roster->first(function ($item, $key) {
            return $item->rank == 0;
        });

        // Filter the roster to just include officers...
        $officers = $roster->filter(function ($item, $key) {
            return $item->rank == 2;
        })->sortBy('character.name');

        return view('home', [
            'guild_master' => $guild_master,
            'officers' => $officers,
        ]);
    }
}
