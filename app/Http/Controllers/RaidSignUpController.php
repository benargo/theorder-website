<?php

namespace App\Http\Controllers;

use App\Raiding\Raid;
use App\Raiding\SignUp;
use App\Blizzard\Warcraft\Classes;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRaidSignUp;

class RaidSignUpController extends Controller
{
    protected $classes;

    /**
     * Create the controller, passing in data from the service container.
     *
     * @param App\Blizzard\Warcraft\Classes $classes
     */
    public function __construct(Classes $classes)
    {
        $this->classes = $classes->getClassicClasses(config('blizzard.faction'));
    }

    public function create(Raid $raid, CreateRaidSignUp $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
        $user = $request->user();

        $signup = new SignUp($validated);
        $signup->raid()->associate($raid);
        $signup->user()->associate($user);
        $signup->save();

        $request->session()->put('raid_signup', $validated);

        return response($signup, 202);
    }

    public function delete(Raid $raid, SignUp $signup)
    {
        $signup->delete();

        return response(null, 204);
    }
}
