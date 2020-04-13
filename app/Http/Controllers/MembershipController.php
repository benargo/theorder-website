<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Discord\RolesRepository;
use App\Http\Controllers\Controller;

class MembershipController extends Controller
{
    protected $roles;

    public function __construct(RolesRepository $roles)
    {
        // Load the roles from Discord...
        $this->roles = $roles;
    }

    public function all()
    {
        return view('manage_all_users', [
            'roles' => $this->roles->stringifyId(),
            'title' => ucwords(Lang::get('controlpanel.manage_members')),
        ]);
    }
}
