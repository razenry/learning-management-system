<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Products\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Bimbingan SNBT',
                'type' => 'main',
                'price' => 500000,
                'description' => 'Program persiapan masuk PTN jalur SNBT',
                'is_active' => true
            ],
            [
                'name' => 'Bimbingan TKA',
                'type' => 'main',
                'price' => 600000,
                'description' => 'Program persiapan masuk PTN jalur TKA',
                'is_active' => true
            ],
            [
                'name' => 'Program Hafiz Add-on',
                'type' => 'addon',
                'price' => 200000,
                'description' => 'Tambahan program menghafal Qur’an',
                'is_active' => true
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
