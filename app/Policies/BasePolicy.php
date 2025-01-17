<?php

namespace App\Policies;

use App\User;

abstract class BasePolicy
{
    public function userIsMemberOfInnerCircle(User $user)
    {
        if ($user->rank) {
            return $user->rank->seniority <= 1;
        }

        return false;
    }

    public function userIsOfficer(User $user)
    {
        if ($user->rank) {
            return $user->rank->seniority <= 4;
        }

        return false;
    }
}
