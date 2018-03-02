<?php

namespace App\Models;

use Marquine\EloquentUuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use Uuid;

    /**
     * Get the user that owns the character.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
