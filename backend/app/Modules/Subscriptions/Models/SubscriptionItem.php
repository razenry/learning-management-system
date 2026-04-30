<?php

namespace App\Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Products\Models\Product;

class SubscriptionItem extends Model
{
    protected $fillable = ['subscription_id', 'product_id', 'price'];

    protected $casts = [
        'price' => 'integer',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
