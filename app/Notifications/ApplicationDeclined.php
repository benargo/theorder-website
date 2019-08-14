<?php

namespace App\Notifications;

use App\Guild\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationDeclined extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Application declined',
            'body'  => "<p>The Inner Circle regretfully inform you that your application to join the guild has been rejected. You will be welcome to apply again on {$this->application->canApplyAgainWhen()->format('jS F Y')}.</p>",
        ];
    }
}
