<?php

namespace App\Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Enrollment extends Model
{
    protected $fillable = ['user_id', 'class_id'];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
