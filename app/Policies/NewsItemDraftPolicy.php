<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NewsItemDraft;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsItemDraftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the models news item draft.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can update the models news item draft.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @param  \App\Models\NewsItemDraft  $draft
     * @return mixed
     */
    public function forceDelete(User $user, NewsItemDraft $draft)
    {
        return $user->rank->seniority <= 1;
    }
}
