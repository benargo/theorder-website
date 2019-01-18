<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
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
        return $this->hasMany('App\Models\User');
    }
}
