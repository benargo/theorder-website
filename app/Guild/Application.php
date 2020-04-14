<?php

namespace App\Guild;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Blizzard\Warcraft\Facades\Races;
use App\Blizzard\Warcraft\Facades\Classes;

class Application extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'accepted_at',
        'declined_at',
        'withdrawn_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'character_name',
        'class_id',
        'race_id',
        'role',
    ];

    protected static $allowed_roles = [
        'damage',
        'healer',
        'tank',
    ];

    protected static $allowed_states = [
        'accepted',
        'declined',
        'pending',
        'withdrawn',
        null,
    ];

    public static function getAllowedRoles()
    {
        return static::$allowed_roles;
    }

    public static function getAllowedStates()
    {
        return static::$allowed_states;
    }

    public function getCharacterName()
    {
        return ucfirst(strtolower($this->attributes['character_name']));
    }

    public function setCharacterName($value)
    {
        $this->attributes['character_name'] = ucfirst(strtolower($value));
    }

    public function getClassAttribute()
    {
        if ($this->attributes['class_id']) {
            return Classes::getClass($this->attributes['class_id']);
        }
    }

    public function getRaceAttribute()
    {
        if ($this->attributes['race_id']) {
            return Races::getRace($this->attributes['race_id']);
        }
    }

    public function setRoleAttribute($value = 'damage')
    {
        $value = strtolower($value);

        if (in_array($value, static::$allowed_roles)) {
            $this->attributes['role'] = $value;
        }
    }

    public function getStatus()
    {
        if ($this->attributes['withdrawn_at'] <> null) {
            return 'withdrawn';
        }
        elseif ($this->attributes['accepted_at'] <> null) {
            return 'accepted';
        }
        elseif ($this->attributes['declined_at'] <> null) {
            return 'declined';
        }
        elseif ($this->attributes['accepted_at'] === null &&
                $this->attributes['declined_at'] === null) {
            return 'pending';
        }

        return null;
    }

    public function canApplyAgainWhen()
    {
        if ($this->attributes['declined_at']) {
            $declined_at = new Carbon($this->attributes['declined_at']);

            if ($declined_at->between(Carbon::now()->subWeek(), Carbon::now()))
            {
                return $declined_at->addWeek();
            }
        }

        return Carbon::now();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
