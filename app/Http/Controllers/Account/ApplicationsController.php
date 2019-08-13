<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ApplicationsController extends Controller
{
    public function get()
    {
        if (Auth::check()) {
            $applications = Auth::user()
                    ->applications()
                    ->latest()
                    ->get()
                    ->mapWithKeys(function ($item, $key) {
                        $item->status = $item->getStatus();

                        return [$item->id => $item];
                    });

            return $applications;
        }
    }
}
