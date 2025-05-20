<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (you can modify this query as needed)
        $featuredProducts = Product::where('approval_status', 'approved')
            ->with('categories')
            ->inRandomOrder()
            ->take(8)
            ->get();

        $bestSellers = Product::where('approval_status', 'approved')
            ->orderByDesc('sales')
            ->take(4)
            ->get();

        // Get all categories
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->get();

        return view('home', compact('featuredProducts', 'bestSellers', 'categories'));
    }
}
