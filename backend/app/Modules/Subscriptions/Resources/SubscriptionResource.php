<?php

namespace App\Modules\Subscriptions\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Products\Resources\ProductResource;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_price' => $this->total_price,
            'items' => $this->items->map(function($item) {
                return [
                    'product' => new ProductResource($item->product),
                    'price' => $item->price
                ];
            }),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
