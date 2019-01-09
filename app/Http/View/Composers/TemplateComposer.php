<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateComposer
{
    /**
     * The user repository implementation.
     *
     * @var App\Models\User
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
    public function compose(View $view)
    {
        // Share the total number of kudos the user has received...
        $view->with('user_kudos_count', $this->user->kudos()->count());

        // Determine how many kudos the user has to give out today...
    }
}
