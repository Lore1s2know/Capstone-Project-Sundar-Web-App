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
            ['description' => 'Cleansers, serums, moisturizers, and sun care for healthy skin.'],
        );

        Category::firstOrCreate(
            ['name' => 'Eye Makeup'],
            ['description' => 'Mascara, eyeliner, eyeshadow, and brow products for eye looks.'],
        );
    }
}
