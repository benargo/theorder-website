<?php

namespace App\Raiding;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['instance_ids' => 'array'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['starts_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'starts_at',
        'instance_ids',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'instance_ids',
        'created_at',
        'updated_at',
    ];

    public function schedule()
    {
        return $this->belongsTo('App\Raiding\Schedule');
    }

    public function signups()
    {
        return $this->hasMany('App\Raiding\Signup');
    }
}
