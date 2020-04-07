<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
