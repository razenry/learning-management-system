<?php

namespace App\Modules\Subscriptions\Services;

use App\Core\Services\BaseService;
use App\Modules\Subscriptions\Repositories\SubscriptionRepository;
use App\Modules\Products\Repositories\ProductRepository;

class SubscriptionService extends BaseService
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private ProductRepository $productRepository
    ) {}

    public function createSubscription(int $userId, array $productIds)
    {
        $products = [];
        $totalPrice = 0;

        foreach ($productIds as $id) {
            $product = $this->productRepository->find($id);
            if ($product) {
                $products[] = [
                    'product_id' => $product->id,
                    'price' => $product->price
                ];
                $totalPrice += $product->price;
            }
        }

        $data = [
            'user_id' => $userId,
            'status' => 'active',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(), // Default 1 month
            'total_price' => $totalPrice
        ];

        return $this->subscriptionRepository->createWithItems($data, $products);
    }

    public function getUserSubscription(int $userId)
    {
        return $this->subscriptionRepository->getActiveByUser($userId);
    }
}
