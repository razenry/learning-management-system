<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Subscriptions\Models\SubscriptionItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'price', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
    ];

    public function subscriptionItems()
    {
        return $this->hasMany(SubscriptionItem::class, 'product_id');
    }

    public function classes()
    {
        return $this->hasMany(\App\Modules\Classes\Models\ClassRoom::class, 'product_id');
    }
}
