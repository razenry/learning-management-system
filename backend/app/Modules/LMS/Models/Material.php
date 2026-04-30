<?php

namespace App\Modules\LMS\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Classes\Models\ClassRoom;

class Material extends Model
{
    protected $fillable = ['class_id', 'title', 'content', 'type', 'file_path', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
