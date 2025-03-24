<?php

namespace App\Services;

use App\Repositories\NotificationRepository;

class NotificationService {

    public function __construct(protected NotificationRepository $notificationRepository) {
    }

    public function getUserNotifications() {
        return $this->notificationRepository->getUserNotifications();
    }

    public function markNotificationAsRead($notificationId) {
        return $this->notificationRepository->markAsRead($notificationId);
    }

    public function createNotification($userId, $message, $quotationId = null) {
        return $this->notificationRepository->createNotification($userId, $message, $quotationId);
    }

}

