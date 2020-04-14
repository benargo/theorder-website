<?php

namespace App\Discord;

use App\Guild\Rank;
use Illuminate\Support\Arr;
use RestCord\DiscordClient;
use Illuminate\Support\Facades\Cache;

class RolesRepository
{
    protected $discord;
    protected $roles;

    public function __construct(DiscordClient $discord)
    {
        $this->discord = $discord;

        // Load the roles from Discord...
        if (Cache::tags(['discord', 'guild'])->has('roles')) {
            $this->roles = Cache::tags(['discord', 'guild'])->get('roles');
        }
        else {
            $this->roles = $this->discord->guild->getGuildRoles(['guild.id' => config('discord.guild')]);

            Cache::tags(['discord', 'guild'])->put(
                'roles',
                $this->roles,
                now()->addHours(24)
            );
        }
    }

    public function stringifyId()
    {
        foreach ($this->roles as $key => $role) {
            $this->roles[$key]->id = (string) $role->id;
        }

        return $this;
    }

    public function getRoles()
    {
        return collect($this->roles);
    }

    public function getRanks()
    {
        // Load the ranks from the database...
        $ranks = Rank::all();

        dd($roles);

        $roles = Arr::where($this->roles, function ($value, $key) use ($ranks) {
            return ($value);
        });
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->getRoles(), $method], $args);
    }
}
