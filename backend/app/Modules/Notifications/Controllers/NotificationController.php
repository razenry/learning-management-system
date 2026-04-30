<?php

namespace App\Modules\Notifications\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Notifications\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    public function __construct(private NotificationService $notificationService) {}

    public function send(Request $request): JsonResponse
    {
        $notification = $this->notificationService->notify(
            $request->get('user_id'),
            $request->get('message'),
            $request->get('type', 'wa')
        );
        return $this->successResponse($notification, 'Notification queued successfully');
    }
}
