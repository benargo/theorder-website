<?php

namespace App\Policies;

use App\User;
use App\Policies\BasePolicy;
use App\Models\NewsItemDraft;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsItemDraftPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models news item draft.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItemDraft  $draft
     * @return mixed
     */
    public function view(User $user, NewsItemDraft $draft)
    {
        return $user->id === $draft->user_id;
    }

    /**
     * Determine whether the user can create models news item drafts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can update the models news item draft.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItemDraft  $draft
     * @return mixed
     */
    public function update(User $user, NewsItemDraft $draft)
    {
        return $user->id === $draft->user_id;
    }

    /**
     * Determine whether the user can delete the models news item draft.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItemDraft  $draft
     * @return mixed
     */
    public function delete(User $user, NewsItemDraft $draft)
    {
        return $user->id === $draft->user_id;
    }

    /**
     * Determine whether the user can restore the models news item draft.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItemDraft  $draft
     * @return mixed
     */
    public function restore(User $user, NewsItemDraft $draft)
    {
        return $user->id === $draft->user_id;
    }

    /**
     * Determine whether the user can permanently delete the models news item draft.
     *
     * @param  \App\User  $user
     * @param  \App\Models\NewsItemDraft  $draft
     * @return mixed
     */
    public function forceDelete(User $user, NewsItemDraft $draft)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }
}
