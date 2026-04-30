<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WaliRelation extends Model
{
    protected $fillable = ['student_id', 'wali_id'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }
}
