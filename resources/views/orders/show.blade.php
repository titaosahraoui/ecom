@extends('layouts.app') @section('title', 'Order #' . $order->id)
@section('content')
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #6366f1;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #111827;
        --light: #f3f4f6;
        --gray: #6b7280;
        --border-radius: 0.5rem;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .order-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .order-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        transition: var(--transition);
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-bottom: 1px solid #e5e7eb;
    }

    .order-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-badge i {
        margin-right: 0.5rem;
        font-size: 0.75rem;
    }

    .status-completed {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .status-processing {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .status-cancelled {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .order-body {
        padding: 2rem;
    }

    .order-section {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.75rem;
        color: var(--primary);
    }

    .order-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .detail-group {
        margin-bottom: 1.25rem;
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--gray);
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1rem;
        font-weight: 500;
        color: var(--dark);
    }

    .order-items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-items-table thead th {
        background-color: #f9fafb;
        padding: 1rem;
        text-align: left;
        font-size: 0.875rem;
        color: var(--gray);
        border-bottom: 1px solid #e5e7eb;
    }

    .order-items-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: var(--transition);
    }

    .order-items-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .order-items-table td {
        padding: 1.25rem 1rem;
        vertical-align: top;
    }

    .product-cell {
        display: flex;
        align-items: center;
    }

    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 0.375rem;
        overflow: hidden;
        margin-right: 1rem;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image-placeholder {
        color: #d1d5db;
        font-size: 1.5rem;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .product-sku {
        font-size: 0.875rem;
        color: var(--gray);
    }

    .price-cell,
    .quantity-cell,
    .subtotal-cell {
        font-weight: 500;
    }

    .order-summary {
        background-color: #f9fafb;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .summary-label {
        color: var(--gray);
    }

    .summary-value {
        font-weight: 500;
    }

    .summary-total {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--dark);
        padding-top: 0.75rem;
        margin-top: 0.75rem;
        border-top: 1px solid #e5e7eb;
    }

    .order-notes {
        background-color: #f0fdf4;
        border-left: 4px solid var(--success);
        padding: 1.25rem;
        border-radius: 0.375rem;
        margin-top: 2rem;
    }

    .notes-title {
        font-weight: 600;
        color: var(--success);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .notes-title i {
        margin-right: 0.5rem;
    }

    .order-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-light);
        transform: translateY(-2px);
    }

    .btn-outline {
        background-color: white;
        border: 1px solid #d1d5db;
        color: var(--dark);
    }

    .btn-outline:hover {
        background-color: #f9fafb;
        border-color: #9ca3af;
    }

    .btn-danger {
        background-color: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .order-details-grid {
            grid-template-columns: 1fr;
        }

        .order-items-table thead {
            display: none;
        }

        .order-items-table tbody tr {
            display: block;
            padding: 1.25rem 0;
        }

        .order-items-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 1rem;
            border: none;
        }

        .order-items-table td::before {
            content: attr(data-label);
            font-weight: 500;
            color: var(--gray);
            margin-right: 1rem;
        }

        .product-cell {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-image {
            margin-bottom: 1rem;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.4s ease-out forwards;
    }
</style>

<div class="order-container">
    <div class="order-card animate-fade-in">
        <div class="order-header">
            <h1 class="order-title">Order #{{ $order->id }}</h1>
            <span class="status-badge status-{{ $order->status }}">
                @switch($order->status) @case('completed')
                <i class="fas fa-check-circle"></i>
                @break @case('pending')
                <i class="fas fa-clock"></i>
                @break @case('processing')
                <i class="fas fa-sync-alt"></i>
                @break @case('cancelled')
                <i class="fas fa-times-circle"></i>
                @break @default
                <i class="fas fa-shopping-bag"></i>
                @endswitch
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="order-body">
            <div class="order-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i> Order Details
                </h2>
                <div class="order-details-grid">
                    <div>
                        <div class="detail-group">
                            <div class="detail-label">Order Date</div>
                            <div class="detail-value">
                                {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                            </div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Order Number</div>
                            <div class="detail-value">#{{ $order->id }}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">Credit Card</div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-group">
                            <div class="detail-label">Shipping Address</div>
                            <div class="detail-value">
                                {{ $order->shipping_address }}
                            </div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Contact</div>
                            <div class="detail-value">
                                {{ $order->user->email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-section">
                <h2 class="section-title">
                    <i class="fas fa-box-open"></i> Order Items
                </h2>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="product-cell" data-label="Product">
                                <div class="product-image">
                                    @if($item->product->image)
                                    <img
                                        src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}"
                                    />
                                    @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <div class="product-name">
                                        {{ $item->product->name }}
                                    </div>
                                    <div class="product-sku">
                                        SKU: {{ $item->product->id }}
                                    </div>
                                </div>
                            </td>
                            <td class="price-cell" data-label="Price">
                                ${{ number_format($item->price, 2) }}
                            </td>
                            <td class="quantity-cell" data-label="Quantity">
                                {{ $item->quantity }}
                            </td>
                            <td class="subtotal-cell" data-label="Subtotal">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="order-summary">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value"
                            >${{ number_format($order->total - 5, 2) }}</span
                        >
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value">$5.00</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tax</span>
                        <span class="summary-value">$0.00</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="order-notes">
                <div class="notes-title">
                    <i class="fas fa-sticky-note"></i> Order Notes
                </div>
                <p>{{ $order->notes }}</p>
            </div>
            @endif

            <div class="order-actions">
                <a href="{{ route('orders.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
                @if($order->status === 'pending')
                <form
                    action="{{ route('orders.cancel', $order->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to cancel this order?');"
                    style="display: inline"
                >
                    @csrf @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-danger"
                        id="cancel-order-btn"
                    >
                        <i class="fas fa-times"></i> Cancel Order
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Reorder functionality
        const reorderBtn = document.getElementById("reorder-btn");
        if (reorderBtn) {
            reorderBtn.addEventListener("click", function () {
                // Show loading state
                const originalText = reorderBtn.innerHTML;
                reorderBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i> Adding to cart...';
                reorderBtn.disabled = true;

                // Send AJAX request
                fetch('{{ route("orders.reorder", $order) }}', {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Show success message
                            Toastify({
                                text: "Items added to cart successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#10b981",
                                stopOnFocus: true,
                            }).showToast();

                            // Update cart count in navbar if exists
                            if (data.cart_count) {
                                const cartCountElements =
                                    document.querySelectorAll(".cart-count");
                                cartCountElements.forEach((el) => {
                                    el.textContent = data.cart_count;
                                });
                            }

                            // Redirect to cart after delay
                            setTimeout(() => {
                                window.location.href =
                                    '{{ route("product.index") }}';
                            }, 1500);
                        } else {
                            throw new Error(
                                data.message || "Failed to add items to cart"
                            );
                        }
                    })
                    .catch((error) => {
                        Toastify({
                            text: error.message,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#ef4444",
                            stopOnFocus: true,
                        }).showToast();
                    })
                    .finally(() => {
                        // Restore button state
                        reorderBtn.innerHTML = originalText;
                        reorderBtn.disabled = false;
                    });
            });
        }
    });
</script>
@endsection
