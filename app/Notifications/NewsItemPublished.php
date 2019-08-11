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

    protected $news_item;

    public function __construct(NewsItem $news_item)
    {
        $this->news_item = $news_item;
    }

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

        return [
            'database',
            DiscordChannel::class,
        ];
    }

    /**
     * Determine whether or not we should send the notification.
     *
     * @param  mixed
     * @return boolean
     */
    public function dontSend($notifiable)
    {
        return empty($this->news_item->published_at);
    }

    /**
     * Get the Discord representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Discord\DiscordMessage
     */
    public function toDiscord($notifiable)
    {
        $author = isset($this->news_item->author->nickname)
            ? $this->news_item->author->nickname
            : str_before($this->news_item->author->battletag, '#');

        $url = route('news.single', $this->news_item->url);

        return DiscordMessage::create(
            "Hey everyone! {$author} just published an important announcement. Check it out...\n\n{$url}",
            [
                'title' => $this->news_item->title,
                'type' => 'rich',
                'description' => str_before($this->news_item->body, "\n"),
                'url' => $url,
                'timestamp' => $this->news_item->published_at->toIso8601String(),
                'color' => hexdec('f8b700'),
                'thumbnail' => [
                    'url' => asset('images/guild_emblem.png'),
                ],
                'author' => ['name' => $author],
            ]
        );
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'    => 'New announcement posted:',
            'subtitle' => $this->news_item->title,
            'redirect' => route('news.single', $this->news_item->url),
        ];
    }
}
