<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\NewsItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class NewsItemPublished extends Notification
{
    use Queueable;

    public $author;

    public $news_item;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NewsItem $news_item)
    {
        $this->news_item = $news_item;
        $this->author = $this->news_item->author;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Discord\DiscordMessage
     */
    public function toDiscord($notifiable)
    {
        $battletag = str_before($this->author->battletag, '#');
        $url = route('news.single', $this->news_item->url);

        return DiscordMessage::create(
            "Hey! *{$battletag} just published a new article. [Check it out!](*{$url})",
            [
                'title' => $this->news_item->title,
                'description' => str_before($this->news_item->body, "\n"),
                'url' => $url,
                'thumbnail' => [
                    'url' => asset('images/guild_emblem.png'),
                ],
                'author' => ['name' => $this->author],
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
