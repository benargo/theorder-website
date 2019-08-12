<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class InnerCirclePolicy extends BasePolicy
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
        return $this->userIsMemberOfInnerCircle($user);
    }
}
