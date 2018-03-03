<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

/**
 * Logout Controller
 *
 * This controller logs users out of the application. It doesn't log them out
 * of their Battle.net session though, as this is handled seperately.
 */
class LogoutController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Log out the user...
     *
     * @return \Illuminate\Http\Response
     */
    public function handleLogout()
    {
        Auth::logout();

        return redirect($this->redirectTo);
    }
}
