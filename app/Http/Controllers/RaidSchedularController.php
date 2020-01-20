<?php

namespace App\Http\Controllers;

use Artisan;
use Validator;
use Carbon\Carbon;
use App\Raiding\Raid;
use App\Raiding\Schedule;
use Illuminate\Support\Arr;
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
            'schedule.start' => 'required|date_format:Y-m-d H:i',
            'schedule.repeats_days' => 'min:1',
            'schedule.instances' => [
                'required',
                'array',
                'min:1',
            ],
            'schedule.instances.*' => [
                Rule::in($instances->pluck('zone_id')),
            ],
            'raid_composition.tanks.*' => 'integer',
            'raid_composition.healers.*' => 'integer',
            'raid_composition.damage.*' => 'integer',
        ]);

        // Format the start date...
        Arr::set($validated_data, 'schedule.start', Carbon::createFromFormat('Y-m-d H:i', Arr::get($validated_data, 'schedule.start'), 'Europe/Paris'));

        $schedule = new Schedule([
            'starts' => Arr::get($validated_data, 'schedule.start'),
            'repeats_days' => Arr::get($validated_data, 'schedule.repeats_days'),
            'num_tanks' => Arr::get($validated_data, 'raid_composition.tanks.total'),
            'num_tanks_druid' => Arr::get($validated_data, 'raid_composition.tanks.druid'),
            'num_tanks_paladin' => Arr::get($validated_data, 'raid_composition.tanks.paladin'),
            'num_tanks_warrior' => Arr::get($validated_data, 'raid_composition.tanks.warrior'),
            'num_healers' => Arr::get($validated_data, 'raid_composition.healers.total'),
            'num_healers_druid' => Arr::get($validated_data, 'raid_composition.healers.druid'),
            'num_healers_paladin' => Arr::get($validated_data, 'raid_composition.healers.paladin'),
            'num_healers_priest' => Arr::get($validated_data, 'raid_composition.healers.priest'),
            'num_damage' => Arr::get($validated_data, 'raid_composition.damage.total'),
            'num_damage_druid' => Arr::get($validated_data, 'raid_composition.damage.druid'),
            'num_damage_hunter' => Arr::get($validated_data, 'raid_composition.damage.hunter'),
            'num_damage_mage' => Arr::get($validated_data, 'raid_composition.damage.mage'),
            'num_damage_paladin' => Arr::get($validated_data, 'raid_composition.damage.paladin'),
            'num_damage_priest' => Arr::get($validated_data, 'raid_composition.damage.priest'),
            'num_damage_rogue' => Arr::get($validated_data, 'raid_composition.damage.rogue'),
            'num_damage_warlock' => Arr::get($validated_data, 'raid_composition.damage.warlock'),
            'num_damage_warrior' => Arr::get($validated_data, 'raid_composition.damage.warrior'),
        ]);
        $schedule->instance_ids = Arr::get($validated_data, 'schedule.instances');

        $schedule->save();

        Artisan::call('raids:create');

        return response()->json($schedule);
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();

        return response(null, 202);
    }
}
