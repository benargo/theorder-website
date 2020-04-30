<?php

namespace App\Providers;

use App\Blizzard\Warcraft\Service as WarcraftService;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\ItemRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ItemRepositoryInterface::class, function ($app) {
            return new ItemRepository($app->make(WarcraftService::class));
        });
    }
}
