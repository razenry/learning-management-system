<?php

namespace App\Modules\LMS\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Classes\Models\ClassRoom;

class Assignment extends Model
{
    protected $fillable = ['class_id', 'title', 'description', 'deadline', 'is_published'];

    protected $casts = [
        'deadline' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
