<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Liste tous les produits
    // In your controller
    public function index()
    {
        $categories = Category::all();
        $statuses = ['available', 'out_of_stock', 'coming_soon'];

        $products = Product::with('categories', 'user')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('category'), function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->where('id', request('category'));
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->paginate(10);

        return view('products.index', compact('products', 'categories', 'statuses'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Enregistre un nouveau produit
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'required|array',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = new Product($request->only(['name', 'description', 'price', 'stock']));

        // Gérer l'upload d'image si présente
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->user_id = Auth::id();
        $product->save();

        // Synchroniser les catégories
        $product->categories()->sync($request->categories);

        return redirect()->route('products.index')->with('success', 'Produit créé avec succès.');
    }

    // Affiche un produit spécifique
    public function show(Product $product)
    {
        $product->load('categories', 'reviews.user');
        return view('products.show', compact('product'));
    }

    // Formulaire d'édition
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('categories');
        return view('products.edit', compact('product', 'categories'));
    }

    // Mise à jour
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'required|array',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->fill($request->only(['name', 'description', 'price', 'stock']));

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si besoin (à implémenter)
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        $product->categories()->sync($request->categories);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    // Suppression
    public function destroy(Product $product)
    {
        // Supprimer l'image associée si besoin (à implémenter)
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }
}
