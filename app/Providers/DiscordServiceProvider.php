<?php

namespace App\Providers;

use RestCord\DiscordClient;
use App\Discord\RolesRepository;
use Illuminate\Support\ServiceProvider;
use App\Discord\Channels\RaidSignupsChannel;
use App\Discord\Channels\RecruitmentChannel;

class DiscordServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DiscordClient::class, function ($app) {
            return new DiscordClient(['token' => config('discord.clients.guildbot.token')]);
        });

        $this->app->singleton(RolesRepository::class, function ($app) {
            return new RolesRepository($app->make(DiscordClient::class));
        });

        $this->app->singleton(RecruitmentChannel::class, function ($app) {
            return new RecruitmentChannel;
        });

        $this->app->singleton(RaidSignupsChannel::class, function ($app) {
            return new RaidSignupsChannel;
        });
    }

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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [DiscordClient::class];
    }

}
