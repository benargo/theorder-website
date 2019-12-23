<?php

namespace App\Raiding;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * While the model is called Schedule, the database table is called
     * something different so we need to set it here manually.
     */
    protected $table = 'raiding_schedule';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'repeats_days' => 'integer',
        'instance_ids' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'starts',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'starts',
        'repeats_days',
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
}
