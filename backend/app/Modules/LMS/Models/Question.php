<?php

namespace App\Modules\LMS\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'assignment_id', 'type', 'question_text', 'options', 'correct_answer', 'points'
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
