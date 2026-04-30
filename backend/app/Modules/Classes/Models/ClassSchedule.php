<?php

namespace App\Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $table = 'class_schedules';

    protected $fillable = ['class_id', 'date', 'start_time', 'end_time', 'location'];

    protected $casts = [
        'date' => 'date',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
