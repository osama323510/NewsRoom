<?php

namespace App\Services\Notification;

use App\Models\User;
use Exception;
use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function markAsRead(User $user, string $id): bool
    {
        // 1. الفحص الأول: هل الإشعار موجود أصلاً في السيستم؟
        $notification = DatabaseNotification::whereRaw('id = ?', [$id])->first();

        if (!$notification) {
            throw new Exception("The notification ID '{$id}' is invalid or does not exist.");
        }

        elseif ((int) $notification->notifiable_id !== (int) $user->id) {
            throw new Exception("This notification does not belong to your account.");
        }

        elseif ($notification->read()) {
            throw new Exception("This notification has already been marked as read.");
        }

        $notification->markAsRead();

        return true;
    }

}
