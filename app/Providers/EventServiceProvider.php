<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Notifications\Events\NotificationSending;
use App\Notifications\Listeners\NotificationSendingListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NotificationSending::class => [
            NotificationSendingListener::class,
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\Battlenet\BattlenetExtendSocialite@handle',
            'SocialiteProviders\Discord\DiscordExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
