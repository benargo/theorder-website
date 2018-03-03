<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Default properties.
     *
     * @var array
     */
    protected $attributes = [
        'is_officer' => 'false',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_officer' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'battletag',
        'access_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token',
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
}
