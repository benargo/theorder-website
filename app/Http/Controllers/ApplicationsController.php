<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Application as ApplicationModel;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ApplicationsController extends Controller
{
    const FACTION = 'alliance';

    public function create(Classes $classes, Races $races, Request $request)
    {
        $user = $request->user();

        // Get the most recent application...
        $application = $user->applications()
                            ->latest()
                            ->first();

        if ($application) {
            abort_unless($application->canApplyAgainWhen()->diffInSeconds(Carbon::now()) <= 60, 403);
        }

        // Abort if the user's most recent application status is anything other
        // than null...

        $validated_data = $request->validate([
            'characterName' => 'required|max:12',
            'classId' => [
                'required',
                Rule::in($classes->getClassicClasses(self::FACTION)->pluck('id')->toArray()),
            ],
            'raceId' => [
                'required',
                Rule::in($races->getClassicRaces(self::FACTION)->pluck('id')->toArray()),
            ],
            'role' => [
                'required',
                Rule::in(ApplicationModel::getAllowedRoles()),
            ],
        ]);

        $application = $user->applications()->create([
            'character_name' => Arr::get($validated_data, 'characterName'),
            'class_id' => Arr::get($validated_data, 'classId'),
            'race_id' => Arr::get($validated_data, 'raceId'),
            'role' => Arr::get($validated_data, 'role'),
        ]);

        return response(null, 204);
    }

    public function patch(ApplicationModel $application, Request $request)
    {
        $action = Arr::get($request->validate([
            'action' => [
                'required',
                Rule::in(['approve', 'decline', 'withdraw']),
            ],
        ]), 'action');

        return call_user_func_array(
            [$this, "{$action}Application"],
            [$application, $request->user()]
        );
    }

    protected function approveApplication(ApplicationModel $application, Authenticatable $user)
    {

    }

    protected function declineApplication(ApplicationModel $application, Authenticatable $user)
    {

    }

    protected function withdrawApplication(ApplicationModel $application, Authenticatable $user)
    {
        abort_unless($user->can('withdraw', $application), 400);

        $application->withdrawn_at = Carbon::now();
        $application->save();

        return response(null, 204);
    }

    public function showJoinPage(Classes $classes, Races $races)
    {
        $classes = $classes->getClassicClasses(self::FACTION);
        $races   = $races->getClassicRaces(self::FACTION);
        $application = null;

        if (Auth::check()) {
            $user = Auth::user();

            // Get the most recent application...
            $application = $user->applications()
                                ->latest()
                                ->first();
        }

        return view('join', [
            'application' => $application,
            'classes' => $classes,
            'races'   => $races,
        ]);
    }
}
