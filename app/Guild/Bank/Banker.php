<?php

namespace App\Guild\Bank;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Banker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
    ];

    /**
     * Defines the relationship to the banker's current stock.
     */
    public function stock()
    {
        return $this->hasMany('App\Guild\Bank\Stock');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::studly($value);
    }
}
