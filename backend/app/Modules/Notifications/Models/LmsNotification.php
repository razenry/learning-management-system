<?php

namespace App\Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LmsNotification extends Model
{
    protected $table = 'lms_notifications';

    protected $fillable = ['user_id', 'type', 'message', 'status', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
