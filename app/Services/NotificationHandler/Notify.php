<?php

namespace App\Services\NotificationHandler;
use App\contract\NotificationDispatcherInterface;
use App\Models\User;
use App\Models\Article;

class Notify
{
    protected $dbDispatcher;
    protected $emailDispatcher;

    public function __construct(
        NotificationDispatcherInterface $dbDispatcher,
        NotificationDispatcherInterface $emailDispatcher
    ) {
        $this->dbDispatcher = $dbDispatcher;
        $this->emailDispatcher = $emailDispatcher;
    }

    public function notifyAllUsers($name, $title): void
    {
        $messageText = "New article '{$title}' created by {$name}.";
        
        
        User::chunk(100, function ($users) use ($messageText) {
        foreach ($users as $user) {
            if ($user->role == 'admin') {
                $this->dbDispatcher->send($user, $messageText);
            } else {
                $this->emailDispatcher->send($user, $messageText);
            }
        }
    });
    
    }
}
