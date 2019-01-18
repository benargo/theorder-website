<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'bnet_access_token_expires',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'battletag',
        'bnet_access_token',
        'bnet_access_token_expires',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'bnet_access_token',
        'bnet_access_token_expires',
    ];

    /**
     * Get the user's battle tag.
     *
     * @param  string  $value
     * @return string
     */
    public function getBattletagAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (DecryptException $e) {
            //
        }
    }

    /**
     * Set the user's battle tag.
     *
     * @param  string  $value
     * @return void
     */
    public function setBattletagAttribute($value)
    {
        $this->attributes['battletag'] = encrypt($value);
    }

    /**
     * Get the main character associated with the user.
     */
    public function mainCharacter()
    {
        return $this->hasOne('App\Models\Character');
    }

    /**
     * Get the user's access token.
     *
     * @param  string  $value
     * @return string
     */
    public function getAccessTokenAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (DecryptException $e) {
            //
        }
    }

    /**
     * Set the user's access token.
     *
     * @param  string  $value
     * @return void
     */
    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = encrypt($value);
    }

    /**
     * Get all the characters associated with the user.
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character');
    }

    /**
     * Get the kudos awarded to the user.
     */
    public function kudos()
    {
        return $this->hasMany('App\Models\Kudos', 'awarded_to_user_id');
    }

    /**
     * Gets the rank for the user.
     */
    public function rank()
    {
        return $this->belongsTo('App\Models\Rank');
    }
}
