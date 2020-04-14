<?php

namespace App\Policies;

use App\User;
use App\Models\NewsItem;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsItemPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models news item.
     *
     * @param  \App\User  $user
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
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can update the models news item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function update(User $user, NewsItem $news_item)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can delete the models news item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function delete(User $user, NewsItem $news_item)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can restore the models news item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function restore(User $user, NewsItem $news_item)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can permanently delete the models news item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItem  $news_item
     * @return mixed
     */
    public function forceDelete(User $user, NewsItem $news_item)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }
}
