<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $statuses = ['approved', 'pending', 'rejected'];

        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement($statuses),
            'image' => 'products/' . $this->faker->unique()->word . '.jpg',
        ];
    }
}
