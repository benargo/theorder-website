<?php

namespace App\Providers;

use App\Blizzard\Client;
use App\Services\GuildRoster;
use App\Blizzard\Warcraft\Items;
use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Service as WarcraftService;
use App\Blizzard\Warcraft\Classes;
use Illuminate\Support\Facades\Auth;
use App\Services\CharactersRepository;
use Illuminate\Support\ServiceProvider;
use App\Blizzard\Warcraft\Instances\Raids;

class BlizzardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $client = new Client(
            config('blizzard.key'),
            config('blizzard.secret'),
            config('blizzard.region'),
            config('blizzard.locale')
        );

        $this->app->singleton(WarcraftService::class, function () use ($client) {
            return new WarcraftService($client);
        });

        $this->app->singleton(CharactersRepository::class, function ($app) {
            return new CharactersRepository($app->make(WorldOfWarcraft::class));
        });

        $this->app->singleton(Classes::class, function ($app) {
            return new Classes($app->make(WarcraftService::class));
        });

        $this->app->singleton(GuildRoster::class, function ($app) {
            return new GuildRoster($app->make(WarcraftService::class));
        });

        $this->app->singleton(Races::class, function ($app) {
            return new Races($app->make(WarcraftService::class));
        });

        $this->app->singleton(Raids::class, function ($app) {
            return new Raids();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            WarcraftService::class,
            CharactersRepository::class,
            Classes::class,
            Items::class,
            GuildRoster::class,
            Races::class,
        ];
    }
}
