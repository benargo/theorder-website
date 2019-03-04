<?php

namespace App\Notifications\Listeners;

use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationSendingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationSending  $event
     * @return void
     */
    public function handle(NotificationSending $event)
    {
        if (method_exists($event->notification, 'dontSend')) {
            return !$event->notification->dontSend($event->notifiable);
        }
        
        return true;
    }
}
