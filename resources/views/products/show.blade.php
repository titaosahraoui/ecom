@extends('layouts.app') @section('title', $product->name) @section('content')
<div class="product-show-container">
    <div class="product-detail-card">
        <!-- Product Header -->
        <div class="product-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>

            @auth @if(auth()->user()->isCommercial() ||
            auth()->user()->isAdmin())
            <div class="product-actions">
                <a
                    href="{{ route('products.edit', $product->id) }}"
                    class="btn-action edit"
                >
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form
                    action="{{ route('products.destroy', $product->id) }}"
                    method="POST"
                    class="d-inline"
                >
                    @csrf @method('DELETE')
                    <button
                        type="submit"
                        class="btn-action delete"
                        onclick="return confirm('Are you sure you want to delete this product?')"
                    >
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
            @endif @endauth
        </div>

        <!-- Product Content -->
        <div class="product-content">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="main-image">
                    @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="img-fluid"
                    />
                    @else
                    <div class="image-placeholder">
                        <i class="fas fa-image"></i>
                        <span>No Image Available</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <div class="product-meta">
                    <span class="badge status-{{ $product->status }}">
                        {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                    </span>
                    <span
                        class="stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}"
                    >
                        <i
                            class="fas fa-{{ $product->stock > 0 ? 'check' : 'times' }}"
                        ></i>
                        {{ $product->stock }} in stock
                    </span>
                </div>

                <h1 class="product-title">{{ $product->name }}</h1>

                <div class="product-categories">
                    @foreach($product->categories as $category)
                    <span
                        class="category-badge"
                        style="background-color: {{ $categoryColors[$category->id] ?? '#6d28d9' }};"
                    >
                        {{ $category->name }}
                    </span>
                    @endforeach
                </div>

                <div class="product-price">
                    <span class="current-price"
                        >${{ number_format($product->price, 2) }}</span
                    >
                </div>

                <div class="product-description">
                    <h3>Description</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Order Form -->
                @if($product->status === 'available' && $product->stock > 0)
                <div class="order-form">
                    <h3>Order Now</h3>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input
                            type="hidden"
                            name="product_id"
                            value="{{ $product->id }}"
                        />

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <div class="quantity-selector">
                                <button
                                    type="button"
                                    class="quantity-btn minus"
                                    onclick="decrementQuantity()"
                                >
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="form-control"
                                />
                                <button
                                    type="button"
                                    class="quantity-btn plus"
                                    onclick="incrementQuantity()"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shipping_address"
                                >Shipping Address</label
                            >
                            <textarea
                                id="shipping_address"
                                name="shipping_address"
                                class="form-control"
                                rows="3"
                                required
                            ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="notes">Order Notes</label>
                            <textarea
                                id="notes"
                                name="notes"
                                class="form-control"
                                rows="2"
                                placeholder="Special instructions..."
                            ></textarea>
                        </div>

                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span id="subtotal"
                                    >${{ number_format($product->price, 2) }}</span
                                >
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>$5.00</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total</span>
                                <span id="total"
                                    >${{ number_format($product->price + 5, 2) }}</span
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn-order">
                            <i class="fas fa-shopping-cart"></i> Place Order
                        </button>
                    </form>
                </div>
                @else
                <div class="out-of-stock-message">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        This product is currently not available for purchase.
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Footer -->
        <div class="product-footer">
            <div class="seller-info">
                <div class="seller-avatar">
                    <img
                        src="{{ $product->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($product->user->name).'&background=random' }}"
                        alt="{{ $product->user->name }}"
                    />
                </div>
                <div class="seller-details">
                    <h4>Sold by {{ $product->user->name }}</h4>
                    <div class="seller-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(24 reviews)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Reviews -->
    <div class="product-reviews">
        <h2>Customer Reviews</h2>
    </div>
</div>

<style>
    /* Base Styles */
    :root {
        --primary-color: #6d28d9;
        --primary-light: #8b5cf6;
        --danger-color: #ef4444;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --gray-light: #f3f4f6;
        --gray-medium: #e5e7eb;
        --gray-dark: #6b7280;
        --text-color: #374151;
    }
    ol {
        list-style: none;
    }
    .product-show-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .product-detail-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }

    /* Product Header */
    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-medium);
    }

    .breadcrumb {
        margin-bottom: 0;
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .product-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .btn-action.edit {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-action.delete {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Product Content */
    .product-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        padding: 2rem;
    }

    @media (max-width: 992px) {
        .product-content {
            grid-template-columns: 1fr;
        }
    }

    /* Product Gallery */
    .product-gallery {
        position: relative;
    }

    .main-image {
        border-radius: 0.5rem;
        overflow: hidden;
        background-color: var(--gray-light);
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .image-placeholder {
        text-align: center;
        color: var(--gray-dark);
    }

    .image-placeholder i {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* Product Info */
    .product-meta {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .badge {
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-available {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-out_of_stock {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .status-coming_soon {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .stock {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.9rem;
    }

    .in-stock {
        color: var(--success-color);
    }

    .out-of-stock {
        color: var(--danger-color);
    }

    .product-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-color);
    }

    .product-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .category-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        color: white;
    }

    .product-price {
        margin-bottom: 1.5rem;
    }

    .current-price {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .product-description {
        margin-bottom: 2rem;
    }

    .product-description h3 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
        color: var(--text-color);
    }

    .product-description p {
        color: var(--gray-dark);
        line-height: 1.6;
    }

    /* Order Form */
    .order-form {
        background-color: var(--gray-light);
        padding: 1.5rem;
        border-radius: 0.5rem;
    }

    .order-form h3 {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        color: var(--text-color);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border: 1px solid var(--gray-medium);
        border-radius: 0.25rem;
        cursor: pointer;
    }

    .quantity-btn:hover {
        background-color: var(--gray-light);
    }

    .quantity-selector input {
        width: 60px;
        text-align: center;
    }

    .order-summary {
        margin: 1.5rem 0;
        padding: 1rem;
        background-color: white;
        border-radius: 0.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .summary-row.total {
        font-weight: 700;
        font-size: 1.1rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--gray-medium);
    }

    .btn-order {
        width: 100%;
        padding: 1rem;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-order:hover {
        background-color: var(--primary-light);
        transform: translateY(-2px);
    }

    .out-of-stock-message {
        margin-top: 2rem;
    }

    /* Product Footer */
    .product-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--gray-medium);
    }

    .seller-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .seller-avatar img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .seller-rating {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: var(--warning-color);
    }

    .seller-rating span {
        color: var(--gray-dark);
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    /* Product Reviews */
    .product-reviews {
        background: white;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .product-reviews h2 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: var(--text-color);
    }

    .review-card {
        padding: 1.5rem 0;
        border-bottom: 1px solid var(--gray-medium);
    }

    .review-card:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .reviewer-avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .reviewer-info {
        flex-grow: 1;
    }

    .reviewer-info h4 {
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .review-date {
        color: var(--gray-dark);
        font-size: 0.9rem;
    }

    .review-content h5 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--text-color);
    }

    .review-content p {
        color: var(--gray-dark);
        line-height: 1.6;
    }

    .no-reviews {
        text-align: center;
        padding: 2rem;
        color: var(--gray-dark);
    }

    .no-reviews i {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: var(--gray-medium);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-show-container {
            padding: 0 1rem;
        }

        .product-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .product-content {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .product-title {
            font-size: 1.5rem;
        }

        .current-price {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity controls
        function updateQuantity(value) {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value) + value;
            const max = parseInt(quantityInput.max);

            if (quantity < 1) quantity = 1;
            if (quantity > max) quantity = max;

            quantityInput.value = quantity;
            updateOrderSummary(quantity);
        }

        function incrementQuantity() {
            updateQuantity(1);
        }

        function decrementQuantity() {
            updateQuantity(-1);
        }

        // Update order summary when quantity changes
        function updateOrderSummary(quantity) {
            const price = parseFloat({{ $product->price }});
            const subtotal = price * quantity;
            const shipping = 5.00;
            const total = subtotal + shipping;

            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total').textContent = '$' + total.toFixed(2);
        };

        // Listen for quantity changes
        document.getElementById('quantity').addEventListener('change', function() {
            let quantity = parseInt(this.value);
            const max = parseInt(this.max);

            if (isNaN(quantity) ) quantity = 1;
            if (quantity < 1) quantity = 1;
            if (quantity > max) quantity = max;

            this.value = quantity;
            updateOrderSummary(quantity);
        });

        // Initialize order summary
        updateOrderSummary(1);
    });
</script>
@endsection
