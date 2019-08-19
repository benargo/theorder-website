<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MarketplaceController extends Controller
{
    public function getIndex()
    {
        return view('marketplace');
    }
}
