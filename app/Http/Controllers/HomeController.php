<?php

namespace App\Http\Controllers;

use App\Services\GuildRoster;
use App\Http\Controllers\Controller;

/**
 * Homepage Controller
 *
 * This controller renders the home page. Pretty straight forward, huh?
 */
class HomeController extends Controller
{
    /**
     * Contains the Guild Roster instance.
     *
     * @var \App\Services\GuildRoster
     */
    protected $roster;

    /**
     * Construct the controller.
     *
     * @param  \App\Services\GuildRoster  $roster
     * @return void
     */
    public function __construct(GuildRoster $roster)
    {
        $this->roster = $roster->getRoster('Silvermoon');
    }

    /**
     * Render the homepage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function renderHomepage()
    {
        // Pluck the guild master from the roster...
        $guild_master = $this->roster->first(function ($item, $key) {
            return $item->rank == 0;
        });

        // Filter the roster to just include officers...
        $officers = $this->roster->filter(function ($item, $key) {
            return $item->rank == 2;
        })->sortBy('character.name');

        return view('home', [
            'guild_master' => $guild_master,
            'officers' => $officers,
        ]);
    }
}
