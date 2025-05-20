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
        $categories = [
            ['name' => 'T-Shirts'],
            ['name' => 'Shirts'],
            ['name' => 'Pants'],
            ['name' => 'Jeans'],
            ['name' => 'Shorts'],
            ['name' => 'Jackets'],
            ['name' => 'Sweaters'],
            ['name' => 'Dresses'],
            ['name' => 'Skirts'],
            ['name' => 'Activewear'],
            ['name' => 'Swimwear'],
            ['name' => 'Underwear'],
            ['name' => 'Socks'],
            ['name' => 'Shoes'],
            ['name' => 'Accessories'],
        ];

        // Clear existing categories
        Category::truncate();

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Successfully seeded categories!');
    }
}
