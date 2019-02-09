<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InnerCirclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can access the control panel.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function accessControlPanel(User $user)
    {
        return $user->rank->seniority <= 1;
    }
}