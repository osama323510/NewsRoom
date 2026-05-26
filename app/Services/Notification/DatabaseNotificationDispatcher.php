<?php

namespace App\Services\Notification;
use App\contract\NotificationDispatcherInterface;
use App\Models\User;
use App\Notifications\ArticlePublishedDbNotification;


class DatabaseNotificationDispatcher implements NotificationDispatcherInterface
{
    public function send(User $user, string $message): void
    {
        
        $user->notify(new ArticlePublishedDbNotification($message));
    }
}
