<?php

namespace App\Raiding;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    /**
     * While the model is called Schedule, the database table is called
     * something different so we need to set it here manually.
     */
    protected $table = 'raids';

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

    public function schedule()
    {
        return $this->belongsTo('App\Raiding\Schedule');
    }

    public function signups()
    {
        return $this->hasMany('App\Raiding\Signup');
    }
}
