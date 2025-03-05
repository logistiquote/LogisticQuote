<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationRepository {
    public function getUserNotifications() {
        return Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->take(10)
            ->get();
    }

    public function markAsRead($notificationId) {
        return Notification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);
    }

    public function createNotification($userId, $message, $quotationId = null) {
        return Notification::create([
            'user_id' => $userId,
            'quotation_id' => $quotationId,
            'message' => $message,
            'is_read' => false,
        ]);
    }
}


