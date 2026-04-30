<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicLevel;

class AcademicLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['Kelas 10', 'Kelas 11', 'Kelas 12'];

        foreach ($levels as $level) {
            AcademicLevel::firstOrCreate(['name' => $level]);
        }
    }
}
