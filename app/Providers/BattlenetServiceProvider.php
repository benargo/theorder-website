<?php

namespace App\Providers;

use BlizzardApi\BlizzardClient;
use Illuminate\Support\ServiceProvider;
use BlizzardApi\Service\WorldOfWarcraft;

class BattlenetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $client = new BlizzardClient(
            config('battlenet.key'),
            config('battlenet.secret'),
            config('battlenet.region'),
            config('battlenet.locale')
        );

        $this->app->singleton(WorldOfWarcraft::class, function ($app) use ($client) {
            return new WorldOfWarcraft($client);
        });
    }
}
