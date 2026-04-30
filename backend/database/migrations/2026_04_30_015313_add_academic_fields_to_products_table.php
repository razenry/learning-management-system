<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('academic_level_id')->nullable()->constrained('academic_levels')->onDelete('set null');
            $table->integer('year_active')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['academic_level_id']);
            $table->dropColumn(['academic_level_id', 'year_active']);
        });
    }
};
