<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rank;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManageRanksPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ranks.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ranks  $ranks
     * @return mixed
     */
    public function view(User $user, Rank $rank)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can create ranks.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can update the ranks.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ranks  $ranks
     * @return mixed
     */
    public function update(User $user, Rank $rank)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can delete the ranks.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ranks  $ranks
     * @return mixed
     */
    public function delete(User $user, Rank $rank)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    /**
     * Determine whether the user can see the users belonging to the rank.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ranks  $ranks
     * @return mixed
     */
    public function seeUsers(User $user, Rank $rank)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }
}
