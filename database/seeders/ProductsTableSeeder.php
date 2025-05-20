<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Clear existing products
        Product::truncate();

        // Get commercial users and categories
        $commercialUsers = User::where('role', User::ROLE_COMMERCIAL)->get();
        $categories = Category::all();

        if ($commercialUsers->isEmpty()) {
            $this->command->error('Please seed commercial users first!');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Products will be created without categories.');
        }

        // Sample products data with images
        $products = [
            [
                'name' => 'Classic White T-Shirt',
                'description' => 'Premium quality cotton t-shirt for everyday wear.',
                'price' => 24.99,
                'stock' => 50,
                'status' => 'available',
                'approval_status' => 'approved',
                'image' => 'seeders/images/tshirt.jpg',
                'thumbnail' => 'seeders/images/tshirt.jpg',
                'images' => [
                    'seeders/images/tshirt.jpg',
                ],
                'image_alt_text' => 'Classic white cotton t-shirt'
            ],
            // ... (keep your other product examples)
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'user_id' => $commercialUsers->random()->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'status' => $productData['status'],
                'approval_status' => $productData['approval_status'],
                'image' => $productData['image'],
                'thumbnail' => $productData['thumbnail'],
                'images' => $productData['images'],
                'image_alt_text' => $productData['image_alt_text'],
                'sales' => rand(0, 100)
            ]);

            // Only attach categories if they exist
            if (!$categories->isEmpty()) {
                $product->categories()->attach(
                    $categories->random(rand(1, min(3, $categories->count())))->pluck('id')->toArray()
                );
            }
        }

        $this->command->info('Successfully seeded products!');
    }
}
