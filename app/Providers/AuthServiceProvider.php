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
        'App\Guild\Application'    => 'App\Policies\ApplicationPolicy',
        'App\Models\NewsItemDraft' => 'App\Policies\NewsItemDraftPolicy',
        'App\Models\NewsItem'      => 'App\Policies\NewsItemPolicy',
        'App\Models\Rank'          => 'App\Policies\ManageRanksPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Control Panel gates...
        Gate::define('access-inner-circle-control-panel', 'App\Policies\InnerCirclePolicy@accessControlPanel');

        // Guild bank/stock addon gates...
        Gate::define('update-stock-data', 'App\Policies\StockAddonPolicy@update');
        Gate::define('withdraw-from-guild-bank', 'App\Policies\StockAddonPolicy@withdraw');

        Passport::routes();
    }
}
