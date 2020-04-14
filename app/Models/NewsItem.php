<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NewsItem extends Model
{
    use Notifiable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'allows_comments',
        'url',
        'published_at',
    ];

    /**
     * Get the author of the news item.
     */
    public function author()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    /**
     * Get all of the drafts.
     */
    public function drafts()
    {
        return $this->hasMany('App\Models\NewsItemDraft');
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->where('id', $value)
                    ->orWhere('url', $value)
                    ->first() ?? abort(404);
    }

    /**
     * Get the channel ID to send notifications to.
     */
    public function routeNotificationForDiscord()
    {
        return config('discord.channels.notices');
    }
}
