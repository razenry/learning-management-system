<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafiz_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->date('report_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafiz_reports');
    }
};
