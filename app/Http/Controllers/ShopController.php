<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        // Get sorting and filtering parameters
        $sort = $request->input('sort', 'latest');

        // Base query for active products
        $query = Product::where('approval_status', 'approved')
            ->with('categories')
            ->when(request('category'), function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->where('id', request('category'));
                });
            });

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories', 'sort'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
