<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Guild\Application as ApplicationModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder as Query;
use App\Notifications\ApplicationReceived;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationsController extends Controller
{
    protected $classes;
    protected $faction;
    protected $races;

    public function __construct(Classes $classes, Races $races)
    {
        $this->classes = $classes;
        $this->faction = config('blizzard.faction');
        $this->races   = $races;
    }

    public function all(Request $request)
    {
        $this->authorize('viewAll', ApplicationModel::class);

        $data = $this->validateGetRequest($request);

        // TODO: Move to a ViewComposer
        $data['classes'] = $this->classes->getClassicClasses($this->faction);
        $data['races']   = $this->races->getClassicRaces($this->faction);
        $data['roles']   = ApplicationModel::getAllowedRoles();

        return view('manage_applications', $data);
    }

    public function getCollection(Request $request)
    {
        $this->authorize('viewAll', ApplicationModel::class);

        $classes        = $this->classes;
        $races          = $this->races;
        $validated_data = $this->validateGetRequest($request);

        $applications = ApplicationModel::where(function (Query $query) use ($classes, $races, $validated_data) {
            // Add character name filter...
            if ($regexp = Arr::get($validated_data, 'characterName')) {
                $query->where('character_name', 'REGEXP', $regexp);
            }

            // Add class filters...
            if ($class = Arr::get($validated_data, 'classId')) {
                $class = $classes->getClass($class);

                $query->where('class_id', $class->id);
            }

            // Add race filters...
            if ($race = Arr::get($validated_data, 'raceId')) {
                $race = $races->getRace($race);

                $query->where('race_id', $race->id);
            }

            // Add role filters...
            if ($role = Arr::get($validated_data, 'role')) {
                $query->where('role', strtolower($role));
            }

            // Add status filters...
            if ($status = Arr::get($validated_data, 'status')) {
                $status = Str::studly($status);

                call_user_func_array([$this, "query{$status}Status"], [$query]);
            }
        })->latest()->get()->transform(function ($item, $key) {
            $item->status = $item->getStatus();

            return $item;
        });

        $page_number = (Paginator::resolveCurrentPage() ?: 1);
        $per_page    = 10;

        return new LengthAwarePaginator(
            $applications->forPage($page_number, $per_page),
            $applications->count(),
            $per_page,
            null,
            ['path' => action('ApplicationsController@getCollection', [], false)]
        );
    }

    protected function validateGetRequest(Request $request)
    {
        return $request->validate([
            'characterName' => [
                'nullable',
                'string',
            ],
            'classId' => [
                'nullable',
                Rule::in($this->classes->getClassicClasses($this->faction)->pluck('id')->toArray()),
            ],
            'raceId' => [
                'nullable',
                Rule::in($this->races->getClassicRaces($this->faction)->pluck('id')->toArray()),
            ],
            'role' => [
                'nullable',
                Rule::in(ApplicationModel::getAllowedRoles())
            ],
            'status' => [
                'nullable',
                Rule::in(ApplicationModel::getAllowedStates()),
            ],
        ]);
    }

    protected function queryAcceptedStatus(Query $query)
    {
        $query->whereNotNull('accepted_at');
    }

    protected function queryDeclinedStatus(Query $query)
    {
        $query->whereNotNull('declined_at');
    }

    protected function queryPendingStatus(Query $query)
    {
        $query->whereNull('accepted_at')
              ->whereNull('declined_at')
              ->whereNull('withdrawn_at');
    }

    protected function queryWithdrawnStatus(Query $query)
    {
        $query->whereNotNull('withdrawn_at');
    }

    public function create(Request $request)
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
                Rule::in($this->classes->getClassicClasses($this->faction)->pluck('id')->toArray()),
            ],
            'raceId' => [
                'required',
                Rule::in($this->races->getClassicRaces($this->faction)->pluck('id')->toArray()),
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

        // Send a notification to Discord...
        $this->notifyDiscord($application);

        return response(null, 204);
    }

    protected function notifyDiscord(ApplicationModel $application)
    {
        $application->notify(new ApplicationReceived);
    }

    public function patch(ApplicationModel $application, Request $request)
    {
        $action = Arr::get($request->validate([
            'action' => [
                'required',
                Rule::in(['accept', 'decline', 'withdraw']),
            ],
        ]), 'action');

        return call_user_func_array(
            [$this, "{$action}Application"],
            [$application, $request->user()]
        );
    }

    protected function acceptApplication(ApplicationModel $application, Authenticatable $user)
    {
        abort_unless($user->can('accept', $application), 403);

        $application->accepted_at = Carbon::now();
        $application->save();

        return response(null, 204);
    }

    protected function declineApplication(ApplicationModel $application, Authenticatable $user)
    {
        abort_unless($user->can('decline', $application), 403);

        $application->declined_at = Carbon::now();
        $application->save();

        return response(null, 204);
    }

    protected function withdrawApplication(ApplicationModel $application, Authenticatable $user)
    {
        abort_unless($user->can('withdraw', $application), 403);

        $application->withdrawn_at = Carbon::now();
        $application->save();

        return response(null, 204);
    }

    public function showJoinPage()
    {
        $classes = $this->classes->getClassicClasses($this->faction);
        $races   = $this->races->getClassicRaces($this->faction);
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
