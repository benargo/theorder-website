<?php

namespace App\Http\Controllers;

use App\Guild\Rank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Discord\RolesRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RanksController extends Controller
{
    protected $ranks;
    protected $roles;

    public function __construct(RolesRepository $roles)
    {
        // Load the roles from Discord...
        $this->roles = $roles;

        // Load the ranks from the database...
        $this->ranks = Rank::orderBy('seniority', 'asc')
                           ->orderBy('title', 'asc')
                           ->get();
    }

    public function create(Request $request)
    {
        $validated_data = $request->validate([
            'title'          => 'required',
            'seniority'      => 'required|between:1,25',
            'kudos_per_day'  => 'nullable|between:0,100',
            'kudos_required' => 'required|min:0',
            'discord_role'   => [
                'nullable',
                Rule::in($this->roles->pluck('id')->toArray()),
            ]
        ]);

        $rank = Rank::create($validated_data);

        return response()->json($rank);
    }

    public function delete(Rank $rank, Request $request)
    {
        if ($rank->users()->count() > 0) {
            $validated_data = $request->validate([
                'new_rank' => Rule::requiredIf($rank->users()->count() > 0)
            ]);

            $rank->users()->update(['rank_id' => $validated_data['new_rank']]);
        }

        $rank->delete();

        return response(null, 204);
    }

    public function get()
    {
        return $this->ranks->toJson();
    }

    public function manage()
    {
        return view('manage_ranks', [
            'roles' => $this->roles->stringifyId(),
            'title' => ucwords(Lang::get('controlpanel.manage_ranks')),
        ]);
    }

    public function update(Rank $rank, Request $request)
    {
        $validated_data = $request->validate([
            'title'          => 'string',
            'seniority'      => 'integer|between:1,25',
            'kudos_per_day'  => 'nullable|between:0,100',
            'kudos_required' => 'integer|min:0',
            'discord_role'   => [
                'nullable',
                Rule::in($this->roles->pluck('id')->toArray()),
            ]
        ]);

        $rank->update($validated_data);
        $rank->save();

        return response(null, 204);
    }

    public function users(Rank $rank)
    {
        return $rank->users()->get();
    }
}
