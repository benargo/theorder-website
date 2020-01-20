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
        'num_tanks' => 'integer',
        'num_tanks_druid' => 'integer',
        'num_tanks_paladin' => 'integer',
        'num_tanks_warrior' => 'integer',
        'num_healers' => 'integer',
        'num_healers_druid' => 'integer',
        'num_healers_paladin' => 'integer',
        'num_healers_priest' => 'integer',
        'num_damage' => 'integer',
        'num_damage_druid' => 'integer',
        'num_damage_hunter' => 'integer',
        'num_damage_mage' => 'integer',
        'num_damage_paladin' => 'integer',
        'num_damage_priest' => 'integer',
        'num_damage_rogue' => 'integer',
        'num_damage_warlock' => 'integer',
        'num_damage_warrior' => 'integer',
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
        'num_tanks',
        'num_tanks_druid',
        'num_tanks_paladin',
        'num_tanks_warrior',
        'num_healers',
        'num_healers_druid',
        'num_healers_paladin',
        'num_healers_priest',
        'num_damage',
        'num_damage_druid',
        'num_damage_hunter',
        'num_damage_mage',
        'num_damage_paladin',
        'num_damage_priest',
        'num_damage_rogue',
        'num_damage_warlock',
        'num_damage_warrior',
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

    public function raids()
    {
        return $this->hasMany('App\Raiding\Raid');
    }
}
