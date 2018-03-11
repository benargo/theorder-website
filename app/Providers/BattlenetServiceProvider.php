<?php

namespace App\Providers;

use App\Services\GuildRoster;
use BlizzardApi\BlizzardClient;
use App\Services\RacesRepository;
use App\Services\ClassesRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\CharactersRepository;
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

        $this->app->singleton(WorldOfWarcraft::class, function () use ($client) {
            return new WorldOfWarcraft($client);
        });

        $this->app->singleton(CharactersRepository::class, function ($app) {
            return new CharactersRepository($app->make(WorldOfWarcraft::class));
        });

        $this->app->singleton(ClassesRepository::class, function ($app) {
            return new ClassesRepository($app->make(WorldOfWarcraft::class));
        });

        $this->app->singleton(GuildRoster::class, function ($app) {
            return new GuildRoster($app->make(WorldOfWarcraft::class));
        });

        $this->app->singleton(RacesRepository::class, function ($app) {
            return new RacesRepository($app->make(WorldOfWarcraft::class));
        });
    }
}
