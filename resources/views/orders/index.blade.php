@extends('layouts.app') @section('title', 'My Orders') @section('content')
<div class="orders-container">
    <!-- Header with filter and search -->
    <div class="orders-header">
        <div class="header-content">
            <h1 class="orders-title">
                <i class="fas fa-clipboard-list"></i> My Orders
                <span class="badge bg-primary">{{ $orders->total() }}</span>
            </h1>
            <p class="orders-subtitle">View and manage your order history</p>
        </div>

        <div class="orders-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    id="order-search"
                    placeholder="Search orders..."
                />
            </div>
            <div class="orders-filter">
                <select id="status-filter" class="form-select">
                    <option value="all">All Orders</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    @if($orders->isEmpty())
    <div class="empty-orders">
        <div class="empty-icon">
            <i class="fas fa-box-open"></i>
        </div>
        <h3>No Orders Yet</h3>
        <p>
            You haven't placed any orders yet. Start shopping to see your orders
            here.
        </p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-shopping-bag"></i> Browse Products
        </a>
    </div>
    @else
    <div class="orders-list">
        @foreach($orders as $order)
        <div
            class="order-card"
            data-status="{{ strtolower($order->status) }}"
            data-search="{{ $order->id }} {{ $order->items->pluck('product.name')->implode(' ') }}"
        >
            <div class="order-header">
                <div class="order-meta">
                    <span class="order-number">Order #{{ $order->id }}</span>
                    <span
                        class="order-date"
                        >{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span
                    >
                    <span class="order-items-count"
                        ><i class="fas fa-box"></i>
                        {{ $order->items->sum('quantity') }} items</span
                    >
                </div>
                <div class="order-status">
                    <span
                        class="status-badge status-{{ strtolower($order->status) }}"
                    >
                        <i class="status-icon"></i>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="order-summary">
                <div class="order-items">
                    @foreach($order->items->take(3) as $item)
                    <div class="order-item">
                        <div class="item-image">
                            @if($item->product->image)
                            <img
                                src="{{ asset('storage/' . $item->product->image) }}"
                                alt="{{ $item->product->name }}"
                                loading="lazy"
                            />
                            @else
                            <div class="image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </div>
                        <div class="item-details">
                            <h4>{{ $item->product->name }}</h4>
                            <div class="item-meta">
                                <span class="item-quantity"
                                    >{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</span
                                >
                                <span class="item-subtotal"
                                    >${{ number_format($item->price * $item->quantity, 2) }}</span
                                >
                            </div>
                        </div>
                    </div>
                    @endforeach @if($order->items->count() > 3)
                    <div class="more-items">
                        <button
                            class="btn-more-items"
                            data-order-id="{{ $order->id }}"
                        >
                            +{{ $order->items->count() - 3 }} more items
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="order-total">
                    <div class="total-details">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span
                                >${{ number_format($order->total - 5, 2) }}</span
                            >
                        </div>
                        <div class="total-row">
                            <span>Shipping</span>
                            <span>$5.00</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-actions">
                <a href="{{ route('orders.show', $order) }}" class="btn-view">
                    <i class="fas fa-eye"></i> View Details
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
                        class="btn-cancel"
                        id="cancel-order-btn"
                    >
                        <i class="fas fa-times"></i> Cancel Order
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="orders-footer">
        <div class="showing-entries">
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
            {{ $orders->total() }} entries
        </div>
        <div class="orders-pagination">
            {{ $orders->onEachSide(1)->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    /* Base Styles */
    :root {
        --primary-color: #4f46e5;
        --primary-light: #6366f1;
        --primary-dark: #4338ca;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
            0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 0.5rem;
    }

    body {
        background-color: var(--gray-50);
        font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .orders-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    /* Header Styles */
    .orders-header {
        background-color: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .header-content {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .orders-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .orders-title .badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
    }

    .orders-subtitle {
        font-size: 0.95rem;
        color: var(--gray-500);
        margin: 0;
    }

    .orders-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 250px;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
    }

    #order-search {
        width: 100%;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    #order-search:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .orders-filter .form-select {
        width: 200px;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .orders-filter .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* Empty State */
    .empty-orders {
        text-align: center;
        padding: 3rem;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
    }

    .empty-icon {
        font-size: 3.5rem;
        color: var(--gray-200);
        margin-bottom: 1.5rem;
    }

    .empty-orders h3 {
        font-size: 1.5rem;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .empty-orders p {
        color: var(--gray-500);
        margin-bottom: 1.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* Order Card */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .order-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-100);
    }

    .order-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-3px);
        border-color: var(--gray-200);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.25rem;
        border-bottom: 1px solid var(--gray-100);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .order-number {
        font-weight: 600;
        color: var(--gray-800);
        font-size: 1.1rem;
    }

    .order-date,
    .order-items-count {
        font-size: 0.875rem;
        color: var(--gray-500);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-items-count i {
        font-size: 0.8rem;
    }

    .order-status {
        display: flex;
        align-items: center;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
        gap: 0.5rem;
    }

    .status-icon {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        display: inline-block;
    }

    .status-pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }
    .status-pending .status-icon {
        background-color: var(--warning-color);
    }

    .status-processing {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }
    .status-processing .status-icon {
        background-color: var(--info-color);
    }

    .status-completed {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }
    .status-completed .status-icon {
        background-color: var(--success-color);
    }

    .status-cancelled {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }
    .status-cancelled .status-icon {
        background-color: var(--danger-color);
    }

    .order-summary {
        display: flex;
        flex-direction: column;
        padding: 1.25rem;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .order-summary {
            flex-direction: row;
            justify-content: space-between;
        }
    }

    .order-items {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 0.5rem;
        overflow: hidden;
        background-color: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        color: var(--gray-300);
        font-size: 1.5rem;
    }

    .item-details {
        flex: 1;
    }

    .item-details h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .item-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .item-subtotal {
        font-weight: 500;
        color: var(--gray-700);
    }

    .more-items {
        margin-top: 0.5rem;
    }

    .btn-more-items {
        background: none;
        border: none;
        color: var(--primary-color);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        transition: var(--transition);
    }

    .btn-more-items:hover {
        background-color: rgba(79, 70, 229, 0.1);
    }

    .btn-more-items i {
        transition: transform 0.2s;
    }

    .btn-more-items.active i {
        transform: rotate(180deg);
    }

    .order-total {
        width: 100%;
        max-width: 250px;
    }

    @media (min-width: 768px) {
        .order-total {
            border-left: 1px solid var(--gray-100);
            padding-left: 1.5rem;
        }
    }

    .total-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .grand-total {
        font-weight: 600;
        color: var(--gray-800);
        font-size: 1rem;
        padding-top: 0.5rem;
        margin-top: 0.5rem;
        border-top: 1px solid var(--gray-100);
    }

    .order-actions {
        display: flex;
        justify-content: flex-end;
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--gray-100);
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-view,
    .btn-cancel,
    .btn-reorder {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        gap: 0.5rem;
    }

    .btn-view {
        background-color: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    .btn-view:hover {
        background-color: var(--primary-dark);
        color: white;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background-color: white;
        color: var(--danger-color);
        border: 1px solid var(--danger-color);
    }

    .btn-cancel:hover {
        background-color: var(--danger-color);
        color: white;
        transform: translateY(-1px);
    }

    .btn-reorder {
        background-color: white;
        color: var(--success-color);
        border: 1px solid var(--success-color);
    }

    .btn-reorder:hover {
        background-color: var(--success-color);
        color: white;
        transform: translateY(-1px);
    }

    /* Footer with Pagination */
    .orders-footer {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
    }

    @media (min-width: 768px) {
        .orders-footer {
            flex-direction: row;
        }
    }

    .showing-entries {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .orders-pagination {
        display: flex;
    }

    .orders-pagination .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .orders-pagination .page-item .page-link {
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        border: 1px solid var(--gray-200);
        color: var(--gray-700);
        transition: var(--transition);
    }

    .orders-pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .orders-pagination .page-item:not(.active) .page-link:hover {
        background-color: var(--gray-100);
    }

    .orders-pagination .page-item.disabled .page-link {
        color: var(--gray-400);
        pointer-events: none;
    }

    /* Modal Styles */
    .modal-header {
        border-bottom: 1px solid var(--gray-200);
    }

    .modal-footer {
        border-top: 1px solid var(--gray-200);
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .orders-header {
            padding: 1rem;
        }

        .order-header {
            padding: 1rem;
        }

        .order-summary {
            padding: 1rem;
        }

        .order-actions {
            padding: 0.75rem 1rem;
        }
    }

    /* Animation Classes */
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
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Status filter functionality
        const statusFilter = document.getElementById("status-filter");
        if (statusFilter) {
            statusFilter.addEventListener("change", function () {
                const status = this.value;
                const orderCards = document.querySelectorAll(".order-card");

                orderCards.forEach((card) => {
                    if (status === "all" || card.dataset.status === status) {
                        card.style.display = "flex";
                        card.classList.add("animate-fade-in");
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        }

        // Search functionality
        const orderSearch = document.getElementById("order-search");
        if (orderSearch) {
            orderSearch.addEventListener("input", function () {
                const searchTerm = this.value.toLowerCase();
                const orderCards = document.querySelectorAll(".order-card");

                orderCards.forEach((card) => {
                    const searchContent = card.dataset.search.toLowerCase();
                    if (searchContent.includes(searchTerm)) {
                        card.style.display = "flex";
                        card.classList.add("animate-fade-in");
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        }

        // Cancel order modal setup
        const cancelButtons = document.querySelectorAll(".btn-cancel");
        const cancelOrderModal = new bootstrap.Modal(
            document.getElementById("cancelOrderModal")
        );
        const cancelOrderForm = document.getElementById("cancelOrderForm");
        const cancelReasonSelect = document.getElementById("cancel_reason");
        const otherReasonContainer = document.querySelector(
            ".other-reason-container"
        );

        cancelButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const orderId = this.dataset.orderId;
                cancelOrderForm.action = `/orders/${orderId}/cancel`;
                cancelOrderModal.show();
            });
        });

        // Show/hide other reason textarea
        cancelReasonSelect.addEventListener("change", function () {
            if (this.value === "other") {
                otherReasonContainer.style.display = "block";
            } else {
                otherReasonContainer.style.display = "none";
            }
        });

        // More items toggle
        const moreItemsButtons = document.querySelectorAll(".btn-more-items");
        const orderItemsModal = new bootstrap.Modal(
            document.getElementById("orderItemsModal")
        );

        moreItemsButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const orderId = this.dataset.orderId;
                document.getElementById("modal-order-id").textContent = orderId;

                // Load order items via AJAX
                fetch(`/orders/${orderId}/items`)
                    .then((response) => response.text())
                    .then((html) => {
                        document.getElementById(
                            "order-items-container"
                        ).innerHTML = html;
                        orderItemsModal.show();
                    })
                    .catch((error) => {
                        console.error("Error loading order items:", error);
                    });
            });
        });

        // Reorder functionality
        const reorderButtons = document.querySelectorAll(".btn-reorder");
        reorderButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const orderId = this.dataset.orderId;

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i> Adding to cart...';
                this.disabled = true;

                // Send AJAX request to reorder
                fetch(`/orders/${orderId}/reorder`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
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
                                backgroundColor: "var(--success-color)",
                                stopOnFocus: true,
                            }).showToast();

                            // Update cart count
                            if (data.cart_count) {
                                const cartCountElements =
                                    document.querySelectorAll(".cart-count");
                                cartCountElements.forEach((el) => {
                                    el.textContent = data.cart_count;
                                });
                            }
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
                            backgroundColor: "var(--danger-color)",
                            stopOnFocus: true,
                        }).showToast();
                    })
                    .finally(() => {
                        // Restore button state
                        this.innerHTML = originalText;
                        this.disabled = false;
                    });
            });
        });

        // Animate order cards on load
        const orderCards = document.querySelectorAll(".order-card");
        orderCards.forEach((card, index) => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";
            card.style.transition = "opacity 0.3s ease, transform 0.3s ease";

            setTimeout(() => {
                card.style.opacity = "1";
                card.style.transform = "translateY(0)";
            }, 100 * index);
        });
    });
</script>
@endsection
