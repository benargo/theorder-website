<?php

namespace App\Models;

use Marquine\EloquentUuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use Uuid;

    /**
     * Default properties.
     *
     * @var array
     */
    protected $attributes = [
        'region' => 'eu',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region',
        'realm',
        'name',
    ];

    /**
     * Get the user that owns the character.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
