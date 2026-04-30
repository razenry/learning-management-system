<?php

namespace App\Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'start_date', 'end_date', 'total_price'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SubscriptionItem::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            \App\Modules\Products\Models\Product::class,
            SubscriptionItem::class,
            'subscription_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date >= now()->toDateString();
    }

    public function hasProduct(int $productId): bool
    {
        return $this->items()->where('product_id', $productId)->exists();
    }
}
