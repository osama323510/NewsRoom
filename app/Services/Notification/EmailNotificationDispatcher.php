<?php

namespace App\Services\Notification;
use App\contract\NotificationDispatcherInterface;
use App\Models\User;
use App\Notifications\ArticlePublishedMailNotification;
use Illuminate\Support\Facades\Notification;

class EmailNotificationDispatcher implements NotificationDispatcherInterface
{
    public function send(User $user, string $message): void
    {
        
        Notification::send($user, new ArticlePublishedMailNotification($message));
    }
}
