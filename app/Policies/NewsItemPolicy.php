<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NewsItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models news item.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function view(?User $user, NewsItem $news_item)
    {
        return true;
    }

    /**
     * Determine whether the user can create models news items.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can update the models news item.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function update(User $user, NewsItem $news_item)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can delete the models news item.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function delete(User $user, NewsItem $news_item)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can restore the models news item.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function restore(User $user, NewsItem $news_item)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can permanently delete the models news item.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function forceDelete(User $user, NewsItem $news_item)
    {
        return $user->rank->seniority <= 1;
    }
}
