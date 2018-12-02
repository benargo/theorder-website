<?php

namespace App\Http\Controllers;

use App\Services\GuildRoster;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

/**
 * Homepage Controller
 *
 * This controller renders the home page. Pretty straight forward, huh?
 */
class HomeController extends Controller
{
    // /**
    //  * Contains the Guild Roster instance.
    //  *
    //  * @var \App\Services\GuildRoster
    //  */
    // protected $roster;
    //
    // /**
    //  * Construct the controller.
    //  *
    //  * @param  \App\Services\GuildRoster  $roster
    //  * @return void
    //  */
    // public function __construct(GuildRoster $roster)
    // {
    //     $this->roster = $roster->getRoster('Silvermoon');
    // }

    /**
     * Render the homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function renderHomepage()
    {
        $recruiting_classes = DB::table('wow_classes')
            ->select('name', 'is_recruiting')
            ->where('is_recruiting', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('home', [
            'recruiting_classes' => $recruiting_classes,
        ]);
    }
}
