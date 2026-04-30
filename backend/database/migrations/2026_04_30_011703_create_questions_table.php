<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->enum('type', ['mcq', 'essay'])->default('mcq');
            $table->text('question_text');
            $table->json('options')->nullable()->comment('JSON array for MCQ options');
            $table->string('correct_answer')->nullable()->comment('For MCQ: option key, for essay: null');
            $table->unsignedInteger('points')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
