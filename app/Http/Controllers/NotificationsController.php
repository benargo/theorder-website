<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Gets the unread notifications for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUnreadNotifications(Request $request)
    {
        $user = $request->user();

        return response()->json($user->unreadNotifications);
    }
}
