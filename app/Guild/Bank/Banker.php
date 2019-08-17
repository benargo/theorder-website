<?php

namespace App\Guild\Bank;

use Illuminate\Database\Eloquent\Model;

class Banker extends Model
{
    /**
     * Defines the relationship to the banker's current stock.
     */
    public function stock()
    {
        return $this->hasMany('App\Guild\Bank\Stock');
    }
}
