@extends('layouts/app')

@section('title', 'Fashion Catalog')
@section('content')
    <section class="fashion-catalog">
        <!-- Header with Search and Filters -->
        <div class="catalog-header">
            <div class="header-content">
                <h1><i class=""></i>Products Collection</h1>
                <p class="subtitle">Discover our latest clothing and accessories</p>
            </div>
            
            <div class="filter-controls">
                <form method="GET" action="{{ route('products.index') }}" class="filter-form">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="filter-group">
                        <label for="category"><i class="fas fa-tags"></i> Category</label>
                        <select name="category" id="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="status"><i class="fas fa-info-circle"></i> Status</label>
                        <select name="approval_status'" id="approval_status'" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    
                    <a href="{{ route('products.create') }}" class="add-product-btn">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            @forelse ($products as $product)
                <div class="fashion-item" 
                     data-categories="{{ $product->categories->pluck('id')->implode(',') }}"
                     data-status="{{ $product->status }}">
                     @if(auth()->user()->isAdmin() && $product->approval_status === 'pending')
                     <div class="approval-actions">
                         <form action="{{ route('admin.approve', $product) }}" method="POST">
                             @csrf
                             @method('PATCH')
                             <button type="submit" class="approve-btn">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                     <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                 </svg>
                                 Approve
                             </button>
                         </form>
                         
                         <form action="{{ route('admin.reject', $product) }}" method="POST">
                             @csrf
                             @method('PATCH')
                             <button type="submit" class="reject-btn">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                     <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                 </svg>
                                 Reject
                             </button>
                         </form>
                     </div>
                     @endif
                    <div class="item-image-container">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="item-image">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-tshirt"></i>
                            </div>
                        @endif
                        
                        <div class="item-badges">
                            @if($product->approval_status == 'pending')
                            <span class="status-badge pending">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                            @endif
                            
                            <span class="stock-badge {{ $product->stock > 0 ? 'in-stock' : 'out-stock' }}">
                                <i class="fas fa-{{ $product->stock > 0 ? 'check' : 'times' }}"></i>
                                {{ $product->stock }} in stock
                            </span>
                        </div>
                        
                        <div class="quick-actions">
                            <a href="{{ route('products.edit', $product) }}" class="action-btn edit" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete"
                                        onclick="return confirm('Delete this product?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="item-details">
                        <h3 class="item-title">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        
                        <div class="item-categories">
                            @foreach($product->categories as $category)
                            <span class="category-tag" style="background-color: {{ $categoryColors[$category->id] ?? '#e0e0e0' }}">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>
                        
                        <p class="item-description">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        
                        <div class="item-footer">
                            <span class="item-price">${{ number_format($product->price, 2) }}</span>
                            
                            <div class="item-meta">
                                <span class="item-seller">
                                    <img src="{{ $product->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($product->user->name).'&background=random' }}" 
                                         alt="{{ $product->user->name }}" 
                                         class="seller-avatar">
                                    {{ Str::limit($product->user->name, 10) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            @empty
                <div class="empty-catalog">
                    <div class="empty-content">
                        <img src="{{ asset('images/fashion-empty.svg') }}" alt="No products" class="empty-illustration">
                        <h3>Catalog Empty</h3>
                        <p>No products match your filters. Try adjusting your search or add new products.</p>
                        <a href="{{ route('products.create') }}" class="btn-add">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="catalog-pagination">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @endif
    </section>

    <style>
        /* Color variables */
        :root {
            --fashion-primary: #6d28d9;
            --fashion-secondary: #be185d;
            --fashion-light: #f5f3ff;
            --fashion-dark: #1e293b;
            --fashion-gray: #64748b;
            --fashion-success: #10b981;
            --fashion-warning: #f59e0b;
            --fashion-danger: #ef4444;
        }
        
        /* Base styles */
        .fashion-catalog {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Header styles */
        .catalog-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.5rem;
            gap: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .header-content h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--fashion-dark);
            margin-bottom: 0.25rem;
        }
        
        .header-content .subtitle {
            color: var(--fashion-gray);
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        .filter-controls {
            flex-grow: 1;
            max-width: 800px;
        }
        
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }
        
        .search-container {
            position: relative;
            flex-grow: 1;
            min-width: 250px;
        }
        
        .search-container i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--fashion-gray);
        }
        
        .search-container input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        
        .search-container input:focus {
            outline: none;
            border-color: var(--fashion-primary);
            box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
        }
        
        .filter-group {
            position: relative;
        }
        
        .filter-group label {
            position: absolute;
            top: -8px;
            left: 12px;
            font-size: 0.75rem;
            background: white;
            padding: 0 4px;
            color: var(--fashion-gray);
        }
        
        .filter-group select {
            padding: 0.6rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            min-width: 160px;
            background-color: white;
            cursor: pointer;
        }
        
        .filter-group select:focus {
            outline: none;
            border-color: var(--fashion-primary);
            box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
        }
        
        .add-product-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background-color: var(--fashion-primary);
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .add-product-btn:hover {
            background-color: #5b21b6;
            transform: translateY(-1px);
        }
        
        /* Products grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        /* Fashion item card */
        .fashion-item {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .fashion-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .item-image-container {
            position: relative;
            height: 200px;
            background: #f8fafc;
        }
        
        .item-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e0;
            font-size: 3.5rem;
        }
        
        .item-badges {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .status-badge.pending {
            background-color: var(--fashion-warning);
        }
        
        .stock-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .in-stock {
            color: var(--fashion-success);
        }
        
        .out-stock {
            color: var(--fashion-danger);
        }
        
        .quick-actions {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .fashion-item:hover .quick-actions {
            opacity: 1;
        }

        .approval-actions {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        padding: 8px 0;
        border-top: 1px solid rgba(0,0,0,0.1);
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    
    .approval-actions form {
        flex: 1;
    }
    
    .approve-btn, .reject-btn {
        width: 100%;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .approve-btn {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    
    .approve-btn:hover {
        background-color: #dcfce7;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .approve-btn:active {
        background-color: #bbf7d0;
        transform: translateY(0);
    }
    
    .approve-btn svg {
        width: 18px;
        height: 18px;
    }
    
    .reject-btn {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    
    .reject-btn:hover {
        background-color: #fee2e2;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .reject-btn:active {
        background-color: #fecaca;
        transform: translateY(0);
    }
    
    .reject-btn svg {
        width: 18px;
        height: 18px;
    }
        
        .action-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .action-btn.edit {
            background-color: rgba(59, 130, 246, 0.9);
            color: white;
        }
        
        .action-btn.delete {
            background-color: rgba(239, 68, 68, 0.9);
            color: white;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .item-details {
            padding: 1.25rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .item-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--fashion-dark);
        }
        
        .item-title a {
            color: inherit;
            text-decoration: none;
        }
        
        .item-title a:hover {
            color: var(--fashion-primary);
            text-decoration: underline;
        }
        
        .item-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .category-tag {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.7rem;
            font-weight: 500;
            color: white;
        }
        
        .item-description {
            color: var(--fashion-gray);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            flex-grow: 1;
        }
        
        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }
        
        .item-price {
            font-weight: 700;
            color: var(--fashion-dark);
            font-size: 1.2rem;
        }
        
        .item-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .item-seller {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--fashion-gray);
        }
        
        .seller-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        /* Empty state */
        .empty-catalog {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem 0;
        }
        
        .empty-content {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .empty-illustration {
            width: 180px;
            opacity: 0.7;
            margin-bottom: 1.5rem;
        }
        
        .empty-catalog h3 {
            color: var(--fashion-dark);
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        
        .empty-catalog p {
            color: var(--fashion-gray);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: var(--fashion-primary);
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-add:hover {
            background-color: #5b21b6;
            transform: translateY(-1px);
        }
        
        /* Pagination */
        .catalog-pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .catalog-pagination .pagination {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .catalog-pagination .page-item.active .page-link {
            background-color: var(--fashion-primary);
            border-color: var(--fashion-primary);
        }
        
        .catalog-pagination .page-link {
            color: var(--fashion-primary);
            border-radius: 0.5rem !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .catalog-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1.5rem;
            }
            
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-container, .filter-group, .filter-group select {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
        
        @media (max-width: 576px) {
            .fashion-catalog {
                padding: 0 1rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Assign random colors to categories if not provided
            const categoryTags = document.querySelectorAll('.category-tag');
            const defaultColors = [
                '#6d28d9', '#be185d', '#0e7490', '#047857', '#b45309',
                '#a21caf', '#1d4ed8', '#15803d', '#c2410c', '#7e22ce'
            ];
            
            categoryTags.forEach(tag => {
                if (!tag.style.backgroundColor) {
                    const randomColor = defaultColors[Math.floor(Math.random() * defaultColors.length)];
                    tag.style.backgroundColor = randomColor;
                }
            });
            
            // Add animation to product cards when they come into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            document.querySelectorAll('.fashion-item').forEach(item => {
                observer.observe(item);
            });
            
            // Add smooth scroll to top when pagination is clicked
            const pagination = document.querySelector('.catalog-pagination');
            if (pagination) {
                pagination.addEventListener('click', function(e) {
                    if (e.target.closest('a.page-link')) {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            }
        });
    </script>

    <!-- Include Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection