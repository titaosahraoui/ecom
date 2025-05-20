@extends('layouts.app') @section('title', 'My Profile - MY') @section('content')
<style>
    .profile-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eaeaea;
    }

    .profile-title {
        font-size: 1.8rem;
        color: var(--dark);
    }

    .edit-btn {
        background: var(--gradient);
        color: white;
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        text-decoration: none;
        transition: opacity 0.3s;
    }

    .edit-btn:hover {
        opacity: 0.9;
        color: white;
    }

    .profile-content {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }

    .profile-sidebar {
        border-right: 1px solid #eaeaea;
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

    .section-title {
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eaeaea;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 150px 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-label {
        font-weight: 500;
        color: var(--gray);
    }

    .info-value {
        color: var(--dark);
    }

    .alert-success {
        background: #e3fcec;
        color: #0a5c36;
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .profile-content {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            border-right: none;
            padding-right: 0;
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <h1 class="profile-title">My Profile</h1>
        <a href="{{ route('account.profile.edit') }}" class="edit-btn">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
    </div>

    @if(session('success'))
    <div class="alert-success">
        {{ session("success") }}
    </div>
    @endif

    <div class="profile-content">
        <div class="profile-sidebar">
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
                        class="profile-menu-link active"
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
                        class="profile-menu-link"
                    >
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <div class="profile-main">
            <div class="profile-section">
                <h3 class="section-title">Personal Information</h3>

                <div class="info-grid">
                    <span class="info-label">First Name:</span>
                    <span class="info-value">{{ $user->prenom }}</span>
                </div>

                <div class="info-grid">
                    <span class="info-label">Last Name:</span>
                    <span class="info-value">{{ $user->nom }}</span>
                </div>

                <div class="info-grid">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>

                <div class="info-grid">
                    <span class="info-label">Phone:</span>
                    <span
                        class="info-value"
                        >{{ $user->phone ?? 'Not provided' }}</span
                    >
                </div>
            </div>

            @if($address)
            <div class="profile-section">
                <h3 class="section-title">Address</h3>

                <div class="info-grid">
                    <span class="info-label">Street:</span>
                    <span
                        class="info-value"
                        >{{ $address->address_line1 }}</span
                    >
                </div>

                <div class="info-grid">
                    <span class="info-label">City:</span>
                    <span class="info-value">{{ $address->city }}</span>
                </div>

                <div class="info-grid">
                    <span class="info-label">Postal Code:</span>
                    <span class="info-value">{{ $address->postal_code }}</span>
                </div>

                <div class="info-grid">
                    <span class="info-label">Country:</span>
                    <span class="info-value">{{ $address->country }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
