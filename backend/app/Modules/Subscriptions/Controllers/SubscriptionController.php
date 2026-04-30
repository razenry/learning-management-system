<?php

namespace App\Modules\Subscriptions\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Subscriptions\Requests\StoreSubscriptionRequest;
use App\Modules\Subscriptions\Resources\SubscriptionResource;
use App\Modules\Subscriptions\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    public function __construct(private SubscriptionService $subscriptionService) {}

    public function store(StoreSubscriptionRequest $request): JsonResponse
    {
        $subscription = $this->subscriptionService->createSubscription(
            $request->get('user_id'),
            $request->get('product_ids')
        );
        return $this->successResponse(new SubscriptionResource($subscription), 'Subscription created successfully', 201);
    }

    public function userSubscription(int $userId): JsonResponse
    {
        $subscription = $this->subscriptionService->getUserSubscription($userId);
        if (!$subscription) {
            return $this->errorResponse('No active subscription found', 404);
        }
        return $this->successResponse(new SubscriptionResource($subscription), 'Subscription retrieved successfully');
    }
}
