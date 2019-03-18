<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Application'   => 'App\Policies\ApplicationPolicy',
        'App\Models\NewsItemDraft' => 'App\Policies\NewsItemDraftPolicy',
        'App\Models\NewsItem'      => 'App\Policies\NewsItemPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-inner-circle-control-panel', 'App\Policies\InnerCirclePolicy@accessControlPanel');

        Passport::routes();
    }
}
