<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ControlPanelPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can access the control panel.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewControlPanel(User $user)
    {
        return $this->userIsOfficer($user);
    }
}
