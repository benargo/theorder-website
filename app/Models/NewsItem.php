<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * Get the author of the news item.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User');
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
}
