<?php

namespace App\Http\Controllers;

use App\Raiding\Raid;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Blizzard\Warcraft\Classes;
use App\Http\Controllers\Controller;
use App\Blizzard\Warcraft\Instances\Raids as Instances;

class ViewRaidController extends Controller
{
    public function get(Raid $raid, Classes $classes, Instances $instances, Request $request)
    {
        $confirmed_team = $raid->signups()->whereNotNull('confirmed_at')->get();
        $signed_up = $raid->signups()
                          ->where('user_id', $request->user()->id)
                          ->first();
        $signed_up = Arr::get($signed_up, 'id', 'undefined');
        $signups_open_time = $raid->starts_at->subDays(6)->hour(10)->minute(0);
        $signups_close_time = $raid->starts_at->subHours(24);
        $signups_are_open = now()->between($signups_open_time, $signups_close_time);

        return view('view_raid', [
            'confirmed_team' => $confirmed_team,
            'classes' => $classes->getClassicClasses(config('blizzard.faction')),
            'default_character_name' => $request->session()->get('raid_signup.character_name', 'undefined'),
            'default_class_id' => $request->session()->get('raid_signup.class_id', 'undefined'),
            'default_role' => $request->session()->get('raid_signup.role', 'undefined'),
            'instances' => $instances->whereIn('zone_id', $raid->instance_ids)->values(),
            'raid' => $raid,
            'signed_up' => $signed_up,
            'signups_are_open' => $signups_are_open,
            'signups_open_time' => $signups_open_time,
            'signups_close_time' => $signups_close_time,
        ]);
    }
}
