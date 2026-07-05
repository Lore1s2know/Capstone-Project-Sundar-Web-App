<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::firstOrCreate(
            ['name' => 'Skincare'],
            ['description' => 'Lotions, serums, and products for skin health.'],
        );

        Category::firstOrCreate(
            ['name' => 'Makeup'],
            ['description' => 'Cosmetic products for face and eyes.'],
        );
    }
}
