<?php

namespace App\Guild;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function attendees()
    {
        return $this->belongsToMany('App\Models\User', 'event_attendees')
                    ->withPivot([
                        'status',
                        'created_at',
                        'updated_at',
                    ]);
    }

    public function invitees()
    {
        return $this->belongsToMany('App\Models\User', 'event_invitees')
                    ->withTimestamps();
    }
}
