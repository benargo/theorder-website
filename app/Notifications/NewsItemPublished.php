<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\NewsItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class NewsItemPublished extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($this->dontSend($notifiable)) {
            return [];
        }

        return [DiscordChannel::class];
    }

    public function dontSend($notifiable)
    {
        if ($notifiable instanceof NewsItem) {
            return empty($notifiable->published_at);
        }

        return false;
    }

    /**
     * Get the Discord representation of the notification.
     *
     * @param  App\Models\NewsItem  $notifiable
     * @return \NotificationChannels\Discord\DiscordMessage
     */
    public function toDiscord(NewsItem $notifiable)
    {
        $battletag = str_before($notifiable->author->battletag, '#');
        $url = route('news.single', $notifiable->url);

        return DiscordMessage::create(
            "Hey @everyone! {$battletag} just published a news article. Check it out...\n\n{$url}",
            [
                'title' => $notifiable->title,
                'type' => 'rich',
                'description' => str_before($notifiable->body, "\n"),
                'url' => $url,
                'timestamp' => $notifiable->published_at->toIso8601String(),
                'color' => hexdec('f8b700'),
                'thumbnail' => [
                    'url' => asset('images/guild_emblem.png'),
                ],
                'author' => ['name' => $battletag],
            ]
        );
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
            //
        ];
    }
}
