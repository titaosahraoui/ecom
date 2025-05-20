@extends('layouts.app') @section('title', 'Shopping Cart') @section('content')
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(count($cartItems) > 0)
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $id => $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item['image'])
                                    <img
                                        src="{{
                                            asset('storage/'.$item['image'])
                                        }}"
                                        alt="{{ $item['name'] }}"
                                        class="img-thumbnail me-3"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            object-fit: cover;
                                        "
                                    />
                                    @endif
                                    <span>{{ $item["name"] }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($item["price"], 2) }}</td>
                            <td>
                                <div class="input-group" style="width: 120px">
                                    <button
                                        class="btn btn-outline-secondary btn-sm quantity-btn"
                                        data-action="decrease"
                                        data-id="{{ $id }}"
                                    >
                                        -
                                    </button>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm text-center quantity-input"
                                        value="{{ $item['quantity'] }}"
                                        min="1"
                                        data-id="{{ $id }}"
                                    />
                                    <button
                                        class="btn btn-outline-secondary btn-sm quantity-btn"
                                        data-action="increase"
                                        data-id="{{ $id }}"
                                    >
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                ${{
                                    number_format(
                                        $item["price"] * $item["quantity"],
                                        2
                                    )
                                }}
                            </td>
                            <td>
                                <button
                                    class="btn btn-link text-danger remove-item"
                                    data-id="{{ $id }}"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Cart Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span
                                    >${{ number_format(collect($cartItems)->sum(function($item) { return $item['price'] * $item['quantity']; }), 2) }}</span
                                >
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>$5.00</span>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Total:</strong>
                                <strong
                                    >${{ number_format(collect($cartItems)->sum(function($item) { return $item['price'] * $item['quantity']; }) + 5, 2) }}</strong
                                >
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <a
                                    href="{{ route('checkout') }}"
                                    class="btn btn-primary"
                                >
                                    Proceed to Checkout
                                </a>
                                <a
                                    href="{{ route('products.index') }}"
                                    class="btn btn-outline-secondary"
                                >
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
        <h3>Your cart is empty</h3>
        <p class="text-muted">
            Looks like you haven't added any items to your cart yet.
        </p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection @section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Update quantity
        const quantityBtns = document.querySelectorAll(".quantity-btn");
        const quantityInputs = document.querySelectorAll(".quantity-input");

        quantityBtns.forEach((btn) => {
            btn.addEventListener("click", function () {
                const id = this.dataset.id;
                const input = document.querySelector(
                    `.quantity-input[data-id="${id}"]`
                );
                const currentValue = parseInt(input.value);

                if (this.dataset.action === "increase") {
                    input.value = currentValue + 1;
                } else {
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                }

                updateQuantity(id, input.value);
            });
        });

        quantityInputs.forEach((input) => {
            input.addEventListener("change", function () {
                const id = this.dataset.id;
                if (this.value < 1) {
                    this.value = 1;
                }
                updateQuantity(id, this.value);
            });
        });

        function updateQuantity(id, quantity) {
            fetch(`/cart/update/${id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({ quantity: quantity }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Remove item
        const removeButtons = document.querySelectorAll(".remove-item");
        removeButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const id = this.dataset.id;

                fetch(`/cart/remove/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            });
        });
    });
</script>
@endsection
