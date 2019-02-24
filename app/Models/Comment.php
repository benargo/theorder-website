<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * While the model is called Comment, the database table is called something
     * different so we need to set it here manually.
     */
    protected $table = 'news_item_comments';

    /**
     * Gets the user who authored this comment.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the comment's child comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
