<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Row 1
        \App\Models\Category::create([
            'name' => 'Skincare',  // <--- Put your first category name here
            'description' => 'Lotions, serums, and products for skin health.', // <--- Your description
        ]);

        // Row 2
        \App\Models\Category::create([
            'name' => 'Makeup', // <--- Put your second category name here
            'description' => 'Cosmetic products for face and eyes.', // <--- Your description
        ]);
    }
}
