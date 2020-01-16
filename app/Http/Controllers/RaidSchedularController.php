<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Raiding\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Blizzard\Warcraft\Instances\Raids;

class RaidSchedularController extends Controller
{
    public function getAll(Raids $raids)
    {
        $schedules = Schedule::all();
        $schedules->map(function ($item, $key) use ($raids) {
            $item->instances = $raids->whereIn('zone_id', $item->instance_ids);
            $item->schedule = "Repeats every {$item->repeats_days} days, beginning {$item->starts->format('l, d F Y')}";
            $item->start_time = $item->starts->format('H:i T');
            return $item;
        });

        return response()->json($schedules);
    }

    public function create(Raids $raids, Request $request)
    {
        $validated_data = $request->validate([
            'start' => 'required|date_format:Y-m-d H:i',
            'repeats_days' => 'min:1',
            'instances' => [
                'required',
                'array',
                'min:1',
            ],
            'instances.*' => [
                Rule::in($raids->pluck('zone_id')),
            ],
        ]);

        // Format the start date...
        $validated_data['start'] = Carbon::createFromFormat('Y-m-d H:i', $validated_data['start'], 'Europe/Paris');

        $schedule = new Schedule([
            'starts' => $validated_data['start'],
            'repeats_days' => $validated_data['repeats_days'],
        ]);
        $schedule->instance_ids = $validated_data['instances'];

        $schedule->save();

        return response()->json($schedule);
    }

    public function delete(Schedule $schedule)
    {
        $schedule->delete();

        return response(null, 202);
    }
}
