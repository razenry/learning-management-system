<?php

namespace App\Modules\Subscriptions\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Subscriptions\Models\Subscription;
use App\Modules\Subscriptions\Models\SubscriptionItem;

class SubscriptionRepository extends BaseRepository
{
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }

    public function createWithItems(array $data, array $items): Subscription
    {
        $subscription = $this->model->create($data);
        
        foreach ($items as $item) {
            SubscriptionItem::create([
                'subscription_id' => $subscription->id,
                'product_id' => $item['product_id'],
                'price' => $item['price'],
            ]);
        }

        return $subscription->load('items.product');
    }

    public function getActiveByUser(int $userId)
    {
        return $this->model->where('user_id', $userId)
            ->where('status', 'active')
            ->with('items.product')
            ->first();
    }
}
