<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Testovací humánny liek',
            'ean' => '8580000000001',
            'sukl_code' => 'TEST001',
            'product_type' => ProductType::HUMAN_MEDICINE,
            'is_active' => true,
            'description' => 'Testovací produkt pre vývoj Vitalis Shop.',
            'composition' => null,
            'dosage' => null,
            'usage' => null,
            'warnings' => null,
        ]);

        Product::create([

            'name' => 'Testovací výživový doplnok',

            'ean' => '8580000000002',
            'sukl_code' => null,
            'product_type' => ProductType::FOOD_SUPPLEMENT,
            'is_active' => true,
            'description' => 'Testovací výživový doplnok.',
            'composition' => null,
            'dosage' => null,
            'usage' => null,
            'warnings' => null,
        ]);

        Product::create([

            'name' => 'Testovacie náplasti',

            'ean' => '8580000000003',
            'sukl_code' => null,
            'product_type' => ProductType::OTHER,
            'is_active' => true,
            'description' => 'Testovací produkt z kategórie náplastí.',
            'composition' => null,
            'dosage' => null,
            'usage' => null,
            'warnings' => null,
        ]);
    }
}
