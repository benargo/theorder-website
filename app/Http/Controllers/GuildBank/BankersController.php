<?php

namespace App\Http\Controllers\GuildBank;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BankersController extends Controller
{
    public function getBankers()
    {
        $results = DB::table('bankers')->select('id', 'name')
                    ->orderBy('position')
                    ->get();
                    
        return response($results);
    }

    public function updateBankers(Request $request)
    {
        $validated_data = $request->validate([
            'bankers' => 'required|array',
            'bankers.id' => 'required|unique:bankers,id',
            'bankers.name' => 'required|unique.bankers,name',
            'bankers.position' => 'required',
        ]);
    }
}
