<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_code' => 'VIT-000001',
            'name' => 'Testovací humánny liek',
            'slug' => 'testovaci-humanny-liek',
            'ean' => '8580000000001',
            'sukl_code' => 'TEST001',
            'product_type' => ProductType::HUMAN_MEDICINE,
            'price' => 8.90,
            'is_active' => true,
            'description' => 'Testovací produkt pre vývoj Vitalis Shop.',
            'composition' => null,
            'dosage' => null,
            'usage' => null,
            'warnings' => null,
        ]);

        Product::create([
            'product_code' => 'VIT-000002',
            'name' => 'Testovací výživový doplnok',
            'slug' => 'testovaci-vyzivovy-doplnok',
            'ean' => '8580000000002',
            'sukl_code' => null,
            'product_type' => ProductType::FOOD_SUPPLEMENT,
            'price' => 12.50,
            'is_active' => true,
            'description' => 'Testovací výživový doplnok.',
            'composition' => null,
            'dosage' => null,
            'usage' => null,
            'warnings' => null,
        ]);

        Product::create([
            'product_code' => 'VIT-000003',
            'name' => 'Testovacie náplasti',
            'slug' => 'testovacie-naplasti',
            'ean' => '8580000000003',
            'sukl_code' => null,
            'product_type' => ProductType::OTHER,
            'price' => 3.20,
            'is_active' => true,
            'description' => 'Testovací produkt z kategórie náplastí.',
            'composition' => null,
            'dosage' => null,
            'usage' => null,
            'warnings' => null,
        ]);
    }
}
