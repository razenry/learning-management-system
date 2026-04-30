<?php

namespace App\Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Modules\Classes\Models\ClassRoom;

class AttendanceSession extends Model
{
    protected $table = 'attendance_sessions';

    protected $fillable = [
        'class_id', 'teacher_id', 'qr_code', 'expired_at',
        'latitude', 'longitude', 'radius'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'radius' => 'integer',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }

    public function isExpired(): bool
    {
        return $this->expired_at->isPast();
    }
}
