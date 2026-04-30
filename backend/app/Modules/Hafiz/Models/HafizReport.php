<?php

namespace App\Modules\Hafiz\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HafizReport extends Model
{
    protected $table = 'hafiz_reports';

    protected $fillable = ['student_id', 'teacher_id', 'note', 'report_date'];

    protected $casts = [
        'report_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
