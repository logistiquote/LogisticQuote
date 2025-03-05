<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function index() {
        return response()->json($this->notificationService->getUserNotifications());
    }

    public function markAsRead($id) {
        $this->notificationService->markNotificationAsRead($id);
        return response()->json(['message' => 'Notification marked as read']);
    }
}
