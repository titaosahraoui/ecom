@extends('layouts.app') @section('title', 'Account Settings - MY')
@section('content')
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #6366f1;
        --secondary: #f59e0b;
        --dark: #1e293b;
        --light: #f8fafc;
        --gray: #64748b;
        --light-gray: #e2e8f0;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --gradient: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    }

    .settings-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--light-gray);
    }

    .settings-title {
        font-size: 2rem;
        color: var(--dark);
        font-weight: 600;
        margin: 0;
    }

    .settings-content {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2.5rem;
    }

    .settings-sidebar {
        border-right: 1px solid var(--light-gray);
        padding-right: 2rem;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1.5rem;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .profile-email {
        color: var(--gray);
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .profile-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .profile-menu-item {
        margin-bottom: 0.5rem;
    }

    .profile-menu-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: var(--dark);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .profile-menu-link:hover {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary);
    }

    .profile-menu-link.active {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary);
        font-weight: 500;
    }

    .profile-menu-link i {
        margin-right: 12px;
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .settings-section {
        margin-bottom: 3rem;
        background: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--light-gray);
        color: var(--dark);
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
        color: var(--primary);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--light-gray);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        outline: none;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-primary {
        background: var(--gradient);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-outline-primary {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline-primary:hover {
        background: rgba(79, 70, 229, 0.1);
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        border: 1px solid var(--light-gray);
        transition: all 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .card-default {
        border-left: 4px solid var(--primary);
    }

    .card-title {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--dark);
    }

    .card-actions {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        background: var(--primary);
        color: white;
        margin-left: 0.5rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 0;
        border-bottom: 1px solid var(--light-gray);
        transition: all 0.2s ease;
    }

    .order-item:hover {
        background: rgba(241, 245, 249, 0.5);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-pending {
        background: #ffedd5;
        color: #9a3412;
    }

    .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-info {
        background: #e0f2fe;
        color: #075985;
        border-left: 4px solid #0ea5e9;
    }

    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid var(--light-gray);
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 600;
        color: var(--dark);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--light-gray);
        padding: 1.25rem 1.5rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-top: 1rem;
    }

    .form-check-input {
        margin-right: 0.5rem;
    }

    .form-check-label {
        font-size: 0.9rem;
        color: var(--gray);
    }

    @media (max-width: 992px) {
        .settings-content {
            grid-template-columns: 240px 1fr;
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .settings-container {
            padding: 1.5rem;
        }

        .settings-content {
            grid-template-columns: 1fr;
        }

        .settings-sidebar {
            border-right: none;
            padding-right: 0;
            border-bottom: 1px solid var(--light-gray);
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<div class="settings-container">
    <div class="settings-header">
        <h1 class="settings-title">Account Settings</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle mr-2"></i> {{ session("success") }}
    </div>
    @endif

    <div class="settings-content">
        <!-- Sidebar Navigation -->
        <div class="settings-sidebar">
            <img
                src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->prenom.' '.Auth::user()->nom).'&background=random' }}"
                alt="{{ Auth::user()->prenom }}"
                class="profile-avatar"
            />

            <h2 class="profile-name">
                {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
            </h2>
            <p class="profile-email">{{ Auth::user()->email }}</p>

            <ul class="profile-menu">
                <li class="profile-menu-item">
                    <a
                        href="{{ route('account.profile') }}"
                        class="profile-menu-link"
                    >
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="profile-menu-item">
                    <a
                        href="{{ route('orders.index') }}"
                        class="profile-menu-link"
                    >
                        <i class="fas fa-shopping-bag"></i> My Orders
                    </a>
                </li>
                <li class="profile-menu-item">
                    <a
                        href="{{ route('account.settings') }}"
                        class="profile-menu-link active"
                    >
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="settings-main">
            <!-- Password Update Section -->
            <div class="settings-section">
                <h3 class="section-title">
                    <i class="fas fa-lock"></i> Change Password
                </h3>

                <form
                    method="POST"
                    action="{{ route('account.update-password') }}"
                >
                    @csrf

                    <div class="form-group">
                        <label for="current_password" class="form-label"
                            >Current Password</label
                        >
                        <div class="input-group">
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="form-control"
                                required
                                placeholder="Enter current password"
                            />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i
                                        class=""
                                        data-target="current_password"
                                    ></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label"
                            >New Password</label
                        >
                        <div class="input-group">
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                class="form-control"
                                required
                                placeholder="Enter new password"
                            />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="" data-target="new_password"></i>
                                </span>
                            </div>
                        </div>
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>

                    <div class="form-group">
                        <label
                            for="new_password_confirmation"
                            class="form-label"
                            >Confirm New Password</label
                        >
                        <div class="input-group">
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                class="form-control"
                                required
                                placeholder="Confirm new password"
                            />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i
                                        class=""
                                        data-target="new_password_confirmation"
                                    ></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Addresses Section -->
            <div class="settings-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt"></i> My Addresses
                </h3>

                @forelse($addresses as $address)
                <div
                    class="address-card {{ $address->is_default ? 'default-address' : '' }}"
                >
                    <div class="address-actions">
                        <button
                            class="edit-address-btn"
                            data-address-id="{{ $address->id }}"
                        >
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form
                            action="{{
                                route('account.delete-address', $address)
                            }}"
                            method="POST"
                        >
                            @csrf @method('DELETE')
                            <button type="submit" class="delete-address-btn">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>

                    <h4 class="address-title">
                        {{ $address->address_line1 }}
                        @if($address->is_default)
                        <span class="default-badge">Default</span>
                        @endif
                    </h4>
                    @if($address->address_line2)
                    <p class="address-line">{{ $address->address_line2 }}</p>
                    @endif
                    <p class="address-line">
                        {{ $address->city }}, {{ $address->postal_code }}
                    </p>
                    <p class="address-line">{{ $address->country }}</p>
                </div>
                @empty
                <div class="info-message">
                    <i class="fas fa-info-circle"></i> You haven't added any
                    addresses yet.
                </div>
                @endforelse

                <button class="add-address-btn" id="openAddAddressModal">
                    <i class="fas fa-plus"></i> Add New Address
                </button>
            </div>

            <!-- Payment Methods Section -->
            <div class="settings-section">
                <h3 class="section-title">
                    <i class="far fa-credit-card"></i> Payment Methods
                </h3>

                @forelse($paymentMethods as $method)
                <div
                    class="payment-method-card {{ $method->is_default ? 'default' : '' }}"
                >
                    <div class="payment-method-header">
                        @if($method->card_type == 'Visa')
                        <i class="fab fa-cc-visa payment-method-icon"></i>
                        @elseif($method->card_type == 'Mastercard')
                        <i class="fab fa-cc-mastercard payment-method-icon"></i>
                        @elseif($method->card_type == 'American Express')
                        <i class="fab fa-cc-amex payment-method-icon"></i>
                        @else
                        <i class="far fa-credit-card payment-method-icon"></i>
                        @endif

                        <div class="payment-method-info">
                            <h4 class="payment-method-title">
                                **** **** **** {{ $method->last_four }}
                                @if($method->is_default)
                                <span class="default-badge">Default</span>
                                @endif
                            </h4>
                            <p class="payment-method-type">
                                {{ $method->card_type }}
                            </p>
                        </div>

                        <div class="payment-method-actions">
                            @if(!$method->is_default)
                            <button
                                class="btn-set-default"
                                data-method-id="{{ $method->id }}"
                            >
                                <i class="fas fa-star"></i> Set as Default
                            </button>
                            @endif
                            <button
                                class="btn-delete"
                                data-method-id="{{ $method->id }}"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="payment-method-details">
                        <div class="detail-item">
                            <span class="detail-label">Expires:</span>
                            <span class="detail-value"
                                >{{ str_pad($method->expiry_month, 2, '0', STR_PAD_LEFT)







                                }}/{{ $method->expiry_year }}</span
                            >
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Cardholder:</span>
                            <span
                                class="detail-value"
                                >{{ $method->card_holder_name }}</span
                            >
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <p>You haven't added any payment methods yet.</p>
                </div>
                @endforelse

                <button class="btn-add-payment" id="openPaymentModal">
                    <i class="fas fa-plus"></i> Add New Payment Method
                </button>
            </div>

            <!-- Recent Orders Section -->
            <div class="settings-section">
                <h3 class="section-title">
                    <i class="fas fa-receipt"></i> Recent Orders
                </h3>

                @forelse($orders as $order)
                <div class="order-item">
                    <div>
                        <h4 class="mb-1">Order #{{ $order->id }}</h4>
                        <p class="mb-1 text-muted">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $order->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            <strong>Total:</strong>
                            ${{ number_format($order->total, 2) }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="order-status status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                        <a
                            href="{{ route('orders.show', $order) }}"
                            class="btn btn-sm btn-outline-primary mt-2"
                        >
                            <i class="fas fa-eye mr-1"></i> Details
                        </a>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> You haven't placed
                    any orders yet.
                </div>
                @endforelse

                <a
                    href="{{ route('orders.index') }}"
                    class="btn btn-primary mt-3"
                >
                    <i class="fas fa-list mr-2"></i> View All Orders
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Add Address Modal -->
<div id="addAddressModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Address</h2>
            <span class="close-modal">&times;</span>
        </div>
        <form
            method="POST"
            action="{{ route('account.store-address') }}"
            id="addressForm"
        >
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Address Line 1*</label>
                    <input
                        type="text"
                        name="address_line1"
                        required
                        placeholder="Street address, P.O. box"
                    />
                </div>

                <div class="form-group">
                    <label>Address Line 2</label>
                    <input
                        type="text"
                        name="address_line2"
                        placeholder="Apartment, suite, unit, building, floor"
                    />
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>City*</label>
                        <input type="text" name="city" required />
                    </div>
                    <div class="form-group">
                        <label>Postal Code*</label>
                        <input type="text" name="postal_code" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Country*</label>
                    <select name="country" required>
                        <option value="">Select Country</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                        <option value="UK">United Kingdom</option>
                    </select>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="is_default" id="is_default" />
                    <label for="is_default">Set as default address</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Save Address</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Payment Method Modal -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add Payment Method</h3>
            <button class="modal-close" id="closePaymentModal">&times;</button>
        </div>
        <form
            id="paymentForm"
            action="{{ route('account.add-payment-method') }}"
            method="POST"
        >
            @csrf
            <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input
                    type="text"
                    id="cardNumber"
                    name="card_number"
                    placeholder="1234 5678 9012 3456"
                    required
                />
            </div>
            <div class="form-group">
                <label for="cardHolder">Cardholder Name</label>
                <input
                    type="text"
                    id="cardHolder"
                    name="card_holder_name"
                    placeholder="John Doe"
                    required
                />
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="expiryMonth">Expiry Month</label>
                    <select id="expiryMonth" name="expiry_month" required>
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                            {{ str_pad($i, 2, "0", STR_PAD_LEFT) }}
                        </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="expiryYear">Expiry Year</label>
                    <select id="expiryYear" name="expiry_year" required>
                        @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input
                        type="text"
                        id="cvv"
                        name="cvv"
                        placeholder="123"
                        required
                    />
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" id="makeDefault" name="is_default" />
                <label for="makeDefault">Set as default payment method</label>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Save Payment Method
            </button>
        </form>
    </div>
</div>

<style>
    /* Modal Styles */

    /* Payment Methods Section */
    .settings-section {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #6c757d;
    }

    /* Payment Method Card */
    .payment-method-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .payment-method-card.default {
        border-left: 4px solid #4e73df;
        background-color: #f8f9fa;
    }

    .payment-method-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        gap: 15px;
    }

    .payment-method-icon {
        font-size: 2rem;
        color: #4e73df;
    }

    .payment-method-info {
        flex-grow: 1;
    }

    .payment-method-title {
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .default-badge {
        background-color: #4e73df;
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
    }

    .payment-method-type {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .payment-method-actions {
        display: flex;
        gap: 10px;
    }

    .btn-set-default,
    .btn-delete {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-set-default {
        color: #4e73df;
    }

    .btn-set-default:hover {
        background-color: rgba(78, 115, 223, 0.1);
    }

    .btn-delete {
        color: #e74a3b;
    }

    .btn-delete:hover {
        background-color: rgba(231, 74, 59, 0.1);
    }

    .payment-method-details {
        display: flex;
        gap: 20px;
    }

    .detail-item {
        display: flex;
        gap: 5px;
    }

    .detail-label {
        color: #6c757d;
        font-weight: 500;
    }

    .detail-value {
        color: #333;
    }

    /* Empty State */
    .empty-state {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        color: #6c757d;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .empty-state i {
        font-size: 2rem;
        color: #6c757d;
    }

    /* Add Payment Button */
    .btn-add-payment {
        background-color: #4e73df;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        margin-top: 15px;
    }

    .btn-add-payment:hover {
        background-color: #3a5bc7;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
        transition: all 0.2s;
    }

    .modal-close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .btn-submit {
        background-color: #4e73df;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background-color: #3a5bc7;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .payment-method-header {
            flex-wrap: wrap;
        }

        .payment-method-details {
            flex-direction: column;
            gap: 10px;
        }

        .form-row {
            flex-direction: column;
            gap: 15px;
        }
    }
    /* Address Cards */
    .address-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .address-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .default-address {
        border-left: 4px solid #4f46e5;
    }

    .address-actions {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .edit-address-btn,
    .delete-address-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        border: none;
    }

    .edit-address-btn {
        background: transparent;
        border: 1px solid #4f46e5;
        color: #4f46e5;
    }

    .edit-address-btn:hover {
        background: rgba(79, 70, 229, 0.1);
    }

    .delete-address-btn {
        background: #ef4444;
        color: white;
    }

    .delete-address-btn:hover {
        background: #dc2626;
    }

    .default-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        background: #4f46e5;
        color: white;
        margin-left: 0.5rem;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        width: 100%;
        max-width: 500px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .close-modal {
        color: #6b7280;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .close-modal:hover {
        color: #111827;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-top: 1rem;
    }

    .form-check input {
        margin-right: 0.5rem;
        width: 1rem;
        height: 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
    }

    .form-check label {
        font-size: 0.875rem;
        color: #4b5563;
        font-weight: normal;
    }

    /* Buttons */
    .cancel-btn,
    .submit-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .cancel-btn {
        background-color: #e5e7eb;
        color: #374151;
    }

    .cancel-btn:hover {
        background-color: #d1d5db;
    }

    .submit-btn {
        background-color: #4f46e5;
        color: white;
    }

    .submit-btn:hover {
        background-color: #4338ca;
    }

    .add-address-btn {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        margin-top: 1rem;
    }

    .add-address-btn:hover {
        background: #6366f1;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    /* Responsive */
    @media (max-width: 640px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .modal-content {
            margin: 0.5rem;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }
    }

    /* Form Styles */
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-top: 1rem;
    }

    .form-check-input {
        margin-right: 0.5rem;
        width: 1rem;
        height: 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
    }

    .form-check-label {
        font-size: 0.875rem;
        color: #4b5563;
    }

    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background-color: #d1d5db;
    }

    .btn-primary {
        background-color: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background-color: #4338ca;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        /** ------------------------ Add Address Modal ------------------------ **/
        const addAddressModal = document.getElementById("addAddressModal");
        const openAddAddressModal = document.getElementById(
            "openAddAddressModal"
        );
        const closeAddAddressModal = document.querySelector(
            "#addAddressModal .close-modal"
        );
        const cancelAddAddressBtn = document.querySelector(
            "#addAddressModal .cancel-btn"
        );

        function toggleAddAddressModal() {
            addAddressModal?.classList.toggle("show");
        }

        openAddAddressModal?.addEventListener("click", (e) => {
            e.preventDefault();
            toggleAddAddressModal();
        });

        closeAddAddressModal?.addEventListener("click", toggleAddAddressModal);
        cancelAddAddressBtn?.addEventListener("click", toggleAddAddressModal);

        window.addEventListener("click", (e) => {
            if (e.target === addAddressModal) toggleAddAddressModal();
        });

        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                addAddressModal?.classList.contains("show")
            ) {
                toggleAddAddressModal();
            }
        });

        /** ------------------------ Edit Address Modals ------------------------ **/
        document.querySelectorAll(".edit-address-btn").forEach((button) => {
            button.addEventListener("click", function () {
                const addressId = this.getAttribute("data-address-id");
                const editModal = document.getElementById(
                    `editAddressModal${addressId}`
                );
                editModal?.classList.add("show");
            });
        });

        function setupEditModals() {
            document.querySelectorAll(".modal").forEach((modal) => {
                if (modal.id !== "addAddressModal") {
                    modal.addEventListener("click", function (e) {
                        if (e.target === this) {
                            this.classList.remove("show");
                        }
                    });
                }
            });

            document.querySelectorAll(".edit-modal-close").forEach((btn) => {
                btn.addEventListener("click", function () {
                    this.closest(".modal")?.classList.remove("show");
                });
            });

            document.querySelectorAll(".edit-modal-cancel").forEach((btn) => {
                btn.addEventListener("click", function () {
                    this.closest(".modal")?.classList.remove("show");
                });
            });
        }

        setupEditModals();

        /** ------------------------ Payment Modal ------------------------ **/
        const paymentModal = document.getElementById("paymentModal");
        const openPaymentBtn = document.getElementById("openPaymentModal");
        const closePaymentBtn = document.getElementById("closePaymentModal");

        openPaymentBtn?.addEventListener("click", () => {
            paymentModal.style.display = "flex";
        });

        closePaymentBtn?.addEventListener("click", () => {
            paymentModal.style.display = "none";
        });

        window.addEventListener("click", (e) => {
            if (e.target === paymentModal) {
                paymentModal.style.display = "none";
            }
        });

        /** ------------------------ Delete Payment Method ------------------------ **/
        document.querySelectorAll(".btn-delete").forEach((btn) => {
            btn.addEventListener("click", function () {
                const methodId = this.getAttribute("data-method-id");
                if (
                    confirm(
                        "Are you sure you want to delete this payment method?"
                    )
                ) {
                    fetch(`/account/payment-methods/${methodId}`, {
                        method: "DELETE",
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
                                location.reload();
                            } else {
                                alert(
                                    data.message ||
                                        "Failed to delete payment method"
                                );
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert(
                                "An error occurred while deleting the payment method"
                            );
                        });
                }
            });
        });

        /** ------------------------ Set Default Payment Method ------------------------ **/
        document.querySelectorAll(".btn-set-default").forEach((btn) => {
            btn.addEventListener("click", function () {
                const methodId = this.getAttribute("data-method-id");
                fetch(`/account/payment-methods/${methodId}/set-default`, {
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
                            location.reload();
                        } else {
                            alert(
                                data.message ||
                                    "Failed to set default payment method"
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert(
                            "An error occurred while setting the default payment method"
                        );
                    });
            });
        });
    });
</script>

@endsection
