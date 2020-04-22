<?php

namespace App\Guild\Bank;

use Illuminate\Database\Eloquent\Model;
use App\Blizzard\Warcraft\Facades\Items;

class Stock extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banker_id',
        'bag',
        'mail',
        'slot',
        'item_id',
        'count',
        'updated_by_user_id',
    ];

    /**
     * Set the database table that the data resides in.
     */
    protected $table = 'guild_bank_stock';

    /**
     * Defines the relationship to the bank character.
     */
    public function banker()
    {
        return $this->belongsTo('App\Guild\Bank\Banker');
    }

    /**
     * Defines the relationship showing who last updated this entry.
     */
    public function updatingUser()
    {
        return $this->belongsTo('App\User', 'updated_by_user_id');
    }
}
