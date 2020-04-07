<?php

namespace App\Policies;

use App\Models\User;
use App\Guild\Application;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Guild\Application  $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        return $this->userIsOfficer($user);
    }

    /**
     * Determine whether the user can view applications.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $this->userIsOfficer($user);
    }

    /**
     * Determine whether the user can create applications.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Guild\Application  $application
     * @return mixed
     */
    public function withdraw(User $user, Application $application)
    {
        return $user->id === $application->user_id;
    }

    /**
     * Determine whether the user can approve the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Guild\Application  $application
     * @return mixed
     */
    public function accept(User $user, Application $application)
    {
        return $this->userIsOfficer($user);
    }

    /**
     * Determine whether the user can decline the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Guild\Application  $application
     * @return mixed
     */
    public function decline(User $user, Application $application)
    {
        return $this->userIsOfficera($user);
    }
}
