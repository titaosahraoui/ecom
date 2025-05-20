<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic statistics
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'revenue' => Order::sum('total'),
        ];

        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Recent products
        $recentProducts = Product::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentProducts',
            'recentUsers'
        ));
    }
    public function pendingProducts()
    {
        $pendingProducts = Product::with('user')
            ->where('approval_status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.pending', compact('pendingProducts'));
    }

    public function approveProduct(Product $product)
    {
        $product->update(['approval_status' => 'approved']);
        return back()->with('success', 'Product approved successfully');
    }

    public function rejectProduct(Product $product)
    {

        $product->update([
            'approval_status' => 'rejected',
        ]);

        return back()->with('success', 'Product rejected successfully');
    }
    public function indexUsers()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser(User $user)
    {
        // Add authorization check if needed
        $user->delete();

        return response()->json(['success' => true]);
    }
}
