<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafiz_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('juz');
            $table->unsignedSmallInteger('ayat_start')->nullable();
            $table->unsignedSmallInteger('ayat_end')->nullable();
            $table->enum('status', ['hafalan', 'murojaah'])->default('hafalan');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafiz_progress');
    }
};
