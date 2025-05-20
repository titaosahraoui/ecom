@extends('layouts.app') @section('content')
<div class="account-container">
    <div class="account-content">
        <!-- Sidebar Navigation -->
        <div class="account-sidebar">
            <div class="account-profile">
                <img
                    src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->prenom.' '.Auth::user()->nom).'&background=random' }}"
                    alt="{{ Auth::user()->prenom }}"
                    class="account-avatar"
                />
                <h2 class="account-name">
                    {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </h2>
                <p class="account-email">{{ Auth::user()->email }}</p>
            </div>

            <ul class="account-menu">
                <li class="account-menu-item">
                    <a
                        href="{{ route('account.profile') }}"
                        class="account-menu-link {{ request()->routeIs('account.profile') ? 'active' : '' }}"
                    >
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="account-menu-item">
                    <a
                        href="{{ route('orders.index') }}"
                        class="account-menu-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                    >
                        <i class="fas fa-shopping-bag"></i> My Orders
                    </a>
                </li>
                <li class="account-menu-item">
                    <a
                        href="{{ route('account.wishlist') }}"
                        class="account-menu-link {{ request()->routeIs('account.wishlist') ? 'active' : '' }}"
                    >
                        <i class="fas fa-heart"></i> Wishlist
                    </a>
                </li>
                <li class="account-menu-item">
                    <a
                        href="{{ route('account.settings') }}"
                        class="account-menu-link {{ request()->routeIs('account.settings') ? 'active' : '' }}"
                    >
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="account-main">@yield('account-content')</div>
    </div>
</div>

<style>
    .account-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .account-content {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2.5rem;
    }

    .account-sidebar {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        height: fit-content;
    }

    .account-profile {
        text-align: center;
        margin-bottom: 2rem;
    }

    .account-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1rem;
        border: 4px solid #f3f4f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .account-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #111827;
    }

    .account-email {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .account-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .account-menu-item {
        margin-bottom: 0.5rem;
    }

    .account-menu-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .account-menu-link:hover {
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
    }

    .account-menu-link.active {
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
        font-weight: 500;
    }

    .account-menu-link i {
        margin-right: 12px;
        width: 20px;
        text-align: center;
    }

    .account-main {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .account-content {
            grid-template-columns: 1fr;
        }

        .account-sidebar {
            margin-bottom: 2rem;
        }
    }
</style>
@endsection
