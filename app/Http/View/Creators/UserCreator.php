<?php

namespace App\Http\View\Creators;

use Illuminate\View\View;
use Illuminate\Http\Request;

class UserCreator
{
    /**
     * The user repository implementation.
     *
     * @var App\User
     */
    protected $user;

    /**
     * Create a new profile composer.
     *
     * @param  Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        // Dependencies automatically resolved by service container...
        $this->user = $request->user();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function create(View $view)
    {
        $view->with('user', $this->user);
    }
}
