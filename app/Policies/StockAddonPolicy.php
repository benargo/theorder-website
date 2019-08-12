<?php

namespace App\Policies;

use App\Models\User;
use App\Guild\Bank\Stock;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockAddonPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function uploadData(User $user)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }

    public function withdraw(User $user)
    {
        return $this->userIsMemberOfInnerCircle($user);
    }
}