<?php

namespace App\Raiding;

use Illuminate\Database\Eloquent\Model;
use App\Blizzard\Warcraft\Facades\Classes;

class SignUp extends Model
{
    /**
     * While the model is called Schedule, the database table is called
     * something different so we need to set it here manually.
     */
    protected $table = 'raids_signups';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'signed_up_at',
        'confirmed_at',
        'withdrawn_at',
    ];

    protected static $allowed_roles = [
        'damage',
        'healer',
        'tank',
    ];

    public function getClassAttribute()
    {
        if ($this->attributes['class_id']) {
            return Classes::getClass($this->attributes['class_id']);
        }
    }

    public function setRoleAttribute($value)
    {
        $value = strtolower($value);

        if (in_array($value, static::$allowed_roles)) {
            $this->attributes['role'] = $value;
        }
    }

    public function raid()
    {
        return $this->belongsTo('App\Raiding\Raid');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
