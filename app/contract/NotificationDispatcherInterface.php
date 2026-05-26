<?php

namespace App\contract;
use App\Models\User;

interface NotificationDispatcherInterface
{
    public function send(User $user, string $message): void;    
}
