<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Raiding\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blizzard\Warcraft\Instances\Raids;

class RaidSchedularController extends Controller
{
    public function get(Raids $raids)
    {
        $schedules = Schedule::all();
        $schedules->map(function ($item, $key) use ($raids) {
            $item->instances = $raids->whereIn('zone_id', $item->instance_ids);
            $item->schedule = "Repeats every {$item->repeats_days} days, beginning {$item->starts->format('l, d F Y')}";
            $item->start_time = $item->starts->format('H:i');
            return $item;
        });

        return response()->json($schedules);
    }

    public function create(Raids $raids, Request $request)
    {
        $validated_data = $request->validate([
            'start' => 'required|date_format:Y-m-d H:i',
            'repeat' => 'min:1',
            'instances' => [
                'required',
                'array',
                'min:1',
                // function ($attribute, $value, $fail) use ($raids) {
                //     if ($raids->where('zone_id', $value)->count() == 0) {
                //         $fail($attribute.' must contain at least one valid raid ID');
                //     }
                // }
            ],
        ]);

        // Format the start date...
        $validated_data['start'] = Carbon::createFromFormat('Y-m-d H:i', $validated_data['start'], 'Europe/Paris');

        $schedule = new Schedule([
            'starts' => $validated_data['start'],
            'repeats_days' => $validated_data['repeat'],
        ]);
        $schedule->instance_ids = $validated_data['instances'];

        $schedule->save();

        return response(null, 204);
    }

}
