@extends('layouts.app') @section('content')
<div class="container-fluid px-4">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="breadcrumb">
            <span class="active">Dashboard</span>
        </div>
        <div class="current-date">
            <i class="fas fa-calendar-alt"></i>
            <span id="current-date"></span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="card-content">
                <div class="stat-info">
                    <h6>Total Products</h6>
                    <h3>{{ $stats["total_products"] }}</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                    <small>+5.2% from last month</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="card-footer">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card success">
            <div class="card-content">
                <div class="stat-info">
                    <h6>Total Users</h6>
                    <h3>{{ $stats["total_users"] }}</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 65%"></div>
                    </div>
                    <small>+12.1% from last month</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <a href="#" class="card-footer">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card info">
            <div class="card-content">
                <div class="stat-info">
                    <h6>Total Orders</h6>
                    <h3>{{ $stats["total_orders"] }}</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 85%"></div>
                    </div>
                    <small>+8.7% from last month</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <a href="#" class="card-footer">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card warning">
            <div class="card-content">
                <div class="stat-info">
                    <h6>Total Revenue</h6>
                    <h3>€{{ number_format($stats["revenue"], 2) }}</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 90%"></div>
                    </div>
                    <small>+15.3% from last month</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-euro-sign"></i>
                </div>
            </div>
            <a href="#" class="card-footer">
                View Details <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="dashboard-section">
        <div class="section-header">
            <i class="fas fa-table"></i>
            <h3>Recent Orders</h3>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            {{ $order->user->prenom }} {{ $order->user->nom }}
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>€{{ number_format($order->total, 2) }}</td>
                        <td>
                            <span
                                class="status-badge {{ $order->status == 'completed' ? 'success' : 'warning' }}"
                            >
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <button class="action-btn view-btn">View</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Products & Users -->
    <div class="double-column">
        <div class="dashboard-section">
            <div class="section-header">
                <i class="fas fa-box"></i>
                <h3>Recent Products</h3>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="list-container">
                @foreach($recentProducts as $product)
                <a
                    href="{{ route('products.show', $product) }}"
                    class="list-item"
                >
                    <div class="item-content">
                        <h4>{{ $product->name }}</h4>
                        <p>€{{ number_format($product->price, 2) }}</p>
                        <small
                            >Added by {{ $product->user->prenom }} on
                            {{ $product->created_at->format('d/m/Y') }}</small
                        >
                    </div>
                    <i class="fas fa-chevron-right"></i>
                </a>
                @endforeach
            </div>
        </div>

        <div class="dashboard-section">
            <div class="section-header">
                <i class="fas fa-users"></i>
                <h3>Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="view-all"
                    >View All</a
                >
            </div>
            <div class="list-container">
                @foreach($recentUsers as $user)
                <div class="list-item" id="user-{{ $user->id }}">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->prenom, 0, 1))





                        }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                    </div>
                    <div class="item-content">
                        <h4>{{ $user->prenom }} {{ $user->nom }}</h4>
                        <p>{{ ucfirst($user->role) }}</p>
                        <small
                            >Joined
                            {{ $user->created_at->format('d/m/Y') }}</small
                        >
                    </div>
                    <div class="item-actions">
                        <button
                            class="btn-delete-user"
                            data-user-id="{{ $user->id }}"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Deletion</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>
                Are you sure you want to delete this user? This action cannot be
                undone.
            </p>
        </div>
        <div class="modal-footer">
            <form id="deleteUserForm" method="POST">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-secondary cancel-delete">
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger confirm-delete">
                    Delete User
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    :root {
        --primary: #4a6bdf;
        --success: #4caf50;
        --info: #00bcd4;
        --warning: #ff9800;
        --danger: #f44336;
        --dark: #343a40;
        --light: #f8f9fa;
        --gray: #6c757d;
        --white: #ffffff;
        --primary-gradient: linear-gradient(135deg, #4a6bdf 0%, #6a11cb 100%);
        --success-gradient: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
        --info-gradient: linear-gradient(135deg, #00bcd4 0%, #00838f 100%);
        --warning-gradient: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    }

    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        color: #333;
    }
    /* Existing styles */
    .list-item {
        position: relative;
    }

    .item-actions {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .btn-delete-user {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .btn-delete-user:hover {
        background: #fee2e2;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 0.5rem;
        width: 100%;
        max-width: 500px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: #1f2937;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
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

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
        border: 1px solid #dc2626;
    }

    .container-fluid {
        padding: 20px;
        max-width: 1600px;
        margin: 0 auto;
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 28px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .breadcrumb {
        font-size: 14px;
        color: var(--gray);
    }

    .breadcrumb .active {
        color: var(--primary);
        font-weight: 500;
    }

    .current-date {
        background-color: var(--white);
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .current-date i {
        margin-right: 8px;
        color: var(--primary);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: var(--white);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card .card-content {
        padding: 20px;
        display: flex;
        justify-content: space-between;
    }

    .stat-card.primary {
        border-left: 4px solid var(--primary);
    }

    .stat-card.success {
        border-left: 4px solid var(--success);
    }

    .stat-card.info {
        border-left: 4px solid var(--info);
    }

    .stat-card.warning {
        border-left: 4px solid var(--warning);
    }

    .stat-info h6 {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray);
        margin-bottom: 10px;
    }

    .stat-info h3 {
        font-size: 24px;
        font-weight: 600;
        margin: 5px 0 15px;
    }

    .progress-container {
        height: 6px;
        background-color: #e9ecef;
        border-radius: 3px;
        margin-bottom: 8px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 3px;
    }

    .stat-card.primary .progress-bar {
        background-color: var(--primary);
    }

    .stat-card.success .progress-bar {
        background-color: var(--success);
    }

    .stat-card.info .progress-bar {
        background-color: var(--info);
    }

    .stat-card.warning .progress-bar {
        background-color: var(--warning);
    }

    .stat-info small {
        font-size: 12px;
        color: var(--gray);
    }

    .stat-icon {
        font-size: 40px;
        opacity: 0.2;
        align-self: center;
    }

    .stat-card .card-footer {
        display: block;
        padding: 12px 20px;
        background-color: rgba(0, 0, 0, 0.02);
        color: var(--gray);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s;
    }

    .stat-card .card-footer:hover {
        background-color: rgba(0, 0, 0, 0.05);
        color: var(--dark);
    }

    .stat-card .card-footer i {
        margin-left: 5px;
        transition: transform 0.3s;
    }

    .stat-card .card-footer:hover i {
        transform: translateX(3px);
    }

    /* Dashboard Sections */
    .dashboard-section {
        background-color: var(--white);
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .section-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .section-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 0 10px;
    }

    .section-header i {
        color: var(--primary);
        font-size: 18px;
    }

    .view-all {
        margin-left: auto;
        font-size: 14px;
        color: var(--primary);
        text-decoration: none;
    }

    .view-all:hover {
        text-decoration: underline;
    }

    /* Table Styles */
    .table-container {
        padding: 20px;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }

    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover td {
        background-color: #f8f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge.success {
        background-color: rgba(76, 175, 80, 0.1);
        color: var(--success);
    }

    .status-badge.warning {
        background-color: rgba(255, 152, 0, 0.1);
        color: var(--warning);
    }

    .action-btn {
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .view-btn {
        background-color: rgba(74, 107, 223, 0.1);
        color: var(--primary);
    }

    .view-btn:hover {
        background-color: rgba(74, 107, 223, 0.2);
    }

    /* Double Column Layout */
    .double-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 992px) {
        .double-column {
            grid-template-columns: 1fr;
        }
    }

    /* List Styles */
    .list-container {
        padding: 0;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
    }

    .list-item:hover {
        background-color: #f8f9fa;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item .item-content {
        flex: 1;
    }

    .list-item h4 {
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 5px;
    }

    .list-item p {
        font-size: 14px;
        margin: 0 0 5px;
        color: var(--dark);
    }

    .list-item small {
        font-size: 12px;
        color: var(--gray);
    }

    .list-item i {
        color: var(--gray);
        font-size: 14px;
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-weight: 600;
        font-size: 14px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .data-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".btn-delete-user");
        const deleteModal = document.getElementById("deleteUserModal");
        const deleteForm = document.getElementById("deleteUserForm");
        const closeModal = document.querySelector(".close-modal");
        const cancelDelete = document.querySelector(".cancel-delete");

        function closeDeleteModal() {
            deleteModal.classList.remove("show");
        }

        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const userId = this.getAttribute("data-user-id");
                deleteForm.action = `/admin/users/${userId}`;
                deleteModal.classList.add("show");
            });
        });

        closeModal?.addEventListener("click", closeDeleteModal);
        cancelDelete?.addEventListener("click", closeDeleteModal);

        deleteModal.addEventListener("click", function (e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });

        deleteForm.addEventListener("submit", function (e) {
            e.preventDefault();

            fetch(this.action, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
            })
                .then((response) => {
                    if (response.ok) return response.json();
                    throw new Error("Failed to delete user");
                })
                .then((data) => {
                    if (data.success) {
                        const userId = this.action.split("/").pop();
                        const row = document.getElementById(`user-${userId}`);
                        if (row) row.remove();
                        alert("User deleted successfully.");
                    } else {
                        alert("Failed to delete user.");
                    }
                })
                .catch((error) => {
                    console.error("Error deleting user:", error);
                    alert("There was an error deleting the user.");
                })
                .finally(() => {
                    closeDeleteModal();
                });
        });
    });
    // Current Date Display
    document.addEventListener("DOMContentLoaded", function () {
        // Set current date
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        document.getElementById("current-date").textContent =
            new Date().toLocaleDateString("en-US", options);

        // Add hover effects to cards
        const cards = document.querySelectorAll(".stat-card");
        cards.forEach((card) => {
            card.addEventListener("mouseenter", function () {
                this.style.transform = "translateY(-5px)";
                this.style.boxShadow = "0 10px 20px rgba(0,0,0,0.1)";
            });
            card.addEventListener("mouseleave", function () {
                this.style.transform = "";
                this.style.boxShadow = "0 4px 12px rgba(0,0,0,0.05)";
            });
        });

        // Table row hover effect
        const tableRows = document.querySelectorAll(".data-table tr");
        tableRows.forEach((row) => {
            row.addEventListener("mouseenter", function () {
                this.style.backgroundColor = "#f8f9fa";
            });
            row.addEventListener("mouseleave", function () {
                this.style.backgroundColor = "";
            });
        });
    });
</script>
@endsection
