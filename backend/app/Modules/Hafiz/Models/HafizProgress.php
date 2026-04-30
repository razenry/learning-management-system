<?php

namespace App\Modules\Hafiz\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HafizProgress extends Model
{
    protected $table = 'hafiz_progress';

    protected $fillable = [
        'student_id', 'juz', 'ayat_start', 'ayat_end', 'status', 'date'
    ];

    protected $casts = [
        'date' => 'date',
        'juz' => 'integer',
        'ayat_start' => 'integer',
        'ayat_end' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
