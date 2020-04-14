<?php

namespace App\Guild;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discord_role' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'seniority',
        'kudos_per_day',
        'kudos_required',
        'discord_role',
    ];

    /**
     * While the model is called Rank, the database table is called something
     * different so we need to set it here manually.
     */
    protected $table = 'user_ranks';

    /**
     * Get the users for the rank.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
