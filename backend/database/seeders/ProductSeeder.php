<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Products\Models\Product;
use App\Models\AcademicLevel;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kelas10 = AcademicLevel::where('name', 'Kelas 10')->first();
        $kelas11 = AcademicLevel::where('name', 'Kelas 11')->first();
        $kelas12 = AcademicLevel::where('name', 'Kelas 12')->first();

        $products = [
            [
                'name' => 'Bimbingan SNBT 2026',
                'type' => 'main',
                'price' => 500000,
                'description' => 'Program persiapan masuk PTN jalur SNBT untuk Kelas 12',
                'is_active' => true,
                'academic_level_id' => $kelas12->id,
                'year_active' => 2026
            ],
            [
                'name' => 'Bimbingan TKA Soshum 2026',
                'type' => 'main',
                'price' => 600000,
                'description' => 'Program persiapan masuk PTN jalur TKA Soshum',
                'is_active' => true,
                'academic_level_id' => $kelas12->id,
                'year_active' => 2026
            ],
            [
                'name' => 'Bimbingan TKA Saintek 2026',
                'type' => 'main',
                'price' => 600000,
                'description' => 'Program persiapan masuk PTN jalur TKA Saintek',
                'is_active' => true,
                'academic_level_id' => $kelas12->id,
                'year_active' => 2026
            ],
            [
                'name' => 'Reguler Kelas 10',
                'type' => 'main',
                'price' => 400000,
                'description' => 'Bimbingan belajar reguler Kelas 10',
                'is_active' => true,
                'academic_level_id' => $kelas10->id,
                'year_active' => 2026
            ],
            [
                'name' => 'Reguler Kelas 11',
                'type' => 'main',
                'price' => 400000,
                'description' => 'Bimbingan belajar reguler Kelas 11',
                'is_active' => true,
                'academic_level_id' => $kelas11->id,
                'year_active' => 2026
            ],
            [
                'name' => 'Program Hafiz Add-on',
                'type' => 'addon',
                'price' => 200000,
                'description' => 'Tambahan program menghafal Qur’an',
                'is_active' => true,
                'academic_level_id' => null, // Addon available for all
                'year_active' => null
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
