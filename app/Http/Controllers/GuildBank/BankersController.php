<?php

namespace App\Http\Controllers\GuildBank;

use App\Guild\Bank\Banker;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BankersController extends Controller
{
    public function deleteBanker(Banker $banker)
    {
        $banker->delete();

        return response(null, 204);
    }

    public function getBankers(Request $request)
    {
        $select = explode(',', $request->query('fields', '*'));
        $order_by = $request->query('sort', 'position');

        $results = Banker::select($select)->orderBy($order_by)->get();

        return response()->json(['bankers' => $results]);
    }

    public function updateBankers(Request $request)
    {
        $validated_data = $request->validate([
            'bankers' => 'required|array',
            'bankers.*.id' => 'integer|nullable',
            'bankers.*.name' => 'required|between:2,12',
        ]);

        $bankers = Arr::get($validated_data, 'bankers');

        foreach($bankers as $new_position => $banker) {
            Banker::updateOrCreate(
                // Where...
                ['id' => Arr::get($banker, 'id', null)],

                // Update/Create...
                [
                    'name' => Arr::get($banker, 'name'),
                    'position' => $new_position,
                ]
            );
        }

        return $this->getBankers($request);
    }
}
