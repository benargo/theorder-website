<?php

namespace App\Policies;

use App\Models\User;

abstract class BasePolicy
{
    public function userIsMemberOfInnerCircle(User $user)
    {
        return $user->rank->seniority <= 1;
    }
}
