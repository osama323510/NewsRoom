<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticlePublishedMailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $message;
    public function __construct($message)
    {
        $this->message=$message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->line('Thank you for using our application!')
            ->line($this->message);
    }

    
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
