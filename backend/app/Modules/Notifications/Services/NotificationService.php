<?php

namespace App\Modules\Notifications\Services;

use App\Core\Services\BaseService;
use App\Modules\Notifications\Repositories\NotificationRepository;
use App\Modules\Notifications\Jobs\SendNotificationJob;

class NotificationService extends BaseService
{
    public function __construct(private NotificationRepository $notificationRepository) {}

    public function notify(int $userId, string $message, string $type = 'wa')
    {
        $notification = $this->notificationRepository->create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'status' => 'pending'
        ]);

        SendNotificationJob::dispatch($notification);

        return $notification;
    }
}
