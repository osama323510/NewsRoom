<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function markAsRead(string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }
        $this->notificationService->markAsRead($user, $id);
        return response()->json([
                'status'  => 'success',
                'message' => 'Notification marked as read successfully.'
            ], 200);

        }
    }









