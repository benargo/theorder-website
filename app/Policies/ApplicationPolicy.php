<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can view applications.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can create applications.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
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
     * @param  \App\Models\Application  $application
     * @return mixed
     */
    public function accept(User $user, Application $application)
    {
        return $user->rank->seniority <= 1;
    }

    /**
     * Determine whether the user can decline the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return mixed
     */
    public function decline(User $user, Application $application)
    {
        return $user->rank->seniority <= 1;
    }
}
