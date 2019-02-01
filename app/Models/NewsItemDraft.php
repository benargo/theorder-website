<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItemDraft extends Model
{
    /**
     * Get the news item.
     */
    public function newsItem()
    {
        return $this->belongsTo('App\Models\NewsItem');
    }

    /**
     * Get the author of the draft.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
