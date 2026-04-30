<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wali_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('wali_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'wali_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wali_relations');
    }
};
