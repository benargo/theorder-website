<?php

namespace App\Models;

use Illuminate\Support\Str;
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
     * Get the user's nickname.
     *
     * @return string
     */
    public function getNicknameAttribute()
    {
        try {
            if ($this->attributes['nickname']) {
                return Str::title($this->attributes['nickname']);
            }

            return Str::before(decrypt($this->attributes['battletag']), '#');
        } catch (DecryptException $e) {
            //
        }
    }

    /**
     * Get the user's email address.
     *
     * @param  string  $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (DecryptException $e) {
            //
        }
    }

    /**
     * Set the user's email address.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = encrypt($value);
    }

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
     * Get the user's Discord ID.
     *
     * @param  string  $value
     * @return string
     */
    public function getDiscordUserIdAttribute($value)
    {
        try {
            return intval(decrypt($value));
        } catch (DecryptException $e) {
            //
        }
    }

    /**
     * Set the user's nickname.
     *
     * @param  string  $value
     * @return void
     */
    public function setDiscordUserIdAttribute($value)
    {
        $this->attributes['discord_user_id'] = encrypt($value);
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
     * Get all the comments this user has made.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Get the kudos awarded to the user.
     */
    public function kudos()
    {
        return $this->hasMany('App\Models\Kudos', 'awarded_to_user_id');
    }

    /**
     * Get the main character associated with the user.
     */
    public function mainCharacter()
    {
        return $this->hasOne('App\Models\Character');
    }

    /**
     * Get all of the drafts.
     */
    public function newsItemDrafts()
    {
        return $this->hasMany('App\Models\NewsItemDraft');
    }

    /**
     * Get the news items authored by the user.
     */
    public function newsItems()
    {
        return $this->hasMany('App\Models\NewsItem');
    }

    /**
     * Gets the rank for the user.
     */
    public function rank()
    {
        return $this->belongsTo('App\Models\Rank');
    }
}
