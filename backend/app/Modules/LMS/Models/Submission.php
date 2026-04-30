<?php

namespace App\Modules\LMS\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id', 'student_id', 'answers', 'score', 'is_graded', 'submitted_at'
    ];

    protected $casts = [
        'answers' => 'array',
        'score' => 'integer',
        'is_graded' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
