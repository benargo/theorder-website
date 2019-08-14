<?php

namespace App\Policies;

use App\Models\User;

abstract class BasePolicy
{
    public function userIsMemberOfInnerCircle(User $user)
    {
        if ($user->rank) {
            return $user->rank->seniority <= 1;
        }
    }
}
