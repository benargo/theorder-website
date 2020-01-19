<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Raiding\Raid;
use App\Raiding\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Blizzard\Warcraft\Instances\Raids as Instances;

class RaidSchedularController extends Controller
{
    public function getAllSchedules(Instances $instances)
    {
        $schedules = Schedule::all();

        $schedules = $schedules->map(function ($item, $key) use ($instances) {
            $item->instances = $instances->whereIn('zone_id', $item->instance_ids)->values();
            $item->schedule = "Repeats every {$item->repeats_days} days, beginning {$item->starts->format('l, d F Y')}";
            $item->start_time = $item->starts->format('H:i T');
            return $item;
        });

        return response()->json($schedules);
    }

    public function getAllRaids(Instances $instances)
    {
        $raids = Raid::all();

        $raids = $raids->map(function ($item, $key) use ($instances) {
            $item->instances = $instances->whereIn('zone_id', $item->instance_ids)->values();
            $item->starts_at_human = $item->starts_at->format('l d F Y @ H:i T');
            $item->url = route('raids.single', $item->id);
            return $item;
        });

        return response()->json($raids);
    }

    public function createSchedule(Instances $instances, Request $request)
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
                Rule::in($instances->pluck('zone_id')),
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

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();

        return response(null, 202);
    }
}
