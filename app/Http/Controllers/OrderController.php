<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Change from get() to paginate()
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10); // 10 items per page

        return view('orders.index', compact('orders'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check product availability
        if ($product->status !== 'available' || $product->stock < $validated['quantity']) {
            return back()->with('error', 'Product is not available in the requested quantity');
        }

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $product->price * $validated['quantity'],
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'],
        ]);

        // Create order item
        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price' => $product->price,
        ]);

        // Update product stock
        $product->decrement('stock', $validated['quantity']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function show(Order $order)
    {
        // Ensure the authenticated user can only view their own orders
        if (Auth::id() !== $order->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('order'));
    }
    public function cancel(Request $request, Order $order)
    {
        // Authorization check
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate cancellation
        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Order cannot be cancelled at this stage');
        }

        // Update order status
        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->cancel_reason
        ]);

        // Restore product stock
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order has been cancelled');
    }
}
