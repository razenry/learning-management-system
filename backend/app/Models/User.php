<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Modules\Users\Models\WaliRelation;
use App\Modules\Subscriptions\Models\Subscription;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function waliRelation()
    {
        return $this->hasOne(WaliRelation::class, 'student_id');
    }

    public function siswas()
    {
        return $this->hasMany(WaliRelation::class, 'wali_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }

    public function hasProductAccess(int $productId): bool
    {
        $active = $this->activeSubscription()->with('items')->first();
        if (!$active) return false;
        return $active->hasProduct($productId);
    }
}
