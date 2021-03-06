<?php

namespace Preferred\Infrastructure\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

abstract class AbstractNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var array */
    public $data;

    /** @var string */
    protected $title;

    /** @var string */
    protected $message;

    /** @var string */
    protected $url;

    /** @var string */
    protected $color;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return [
            'mail',
            'broadcast',
            'database',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param $notifiable
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        app()->setLocale($notifiable->profile->locale);

        return new BroadcastMessage($this->toArray($notifiable));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        app()->setLocale($notifiable->profile->locale);

        return [
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url,
            'color'   => $this->color
        ];
    }
}
