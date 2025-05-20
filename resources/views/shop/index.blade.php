@extends('layouts.app')

@section('title', 'Shop - ' . config('app.name'))

@section('content')
<div class="shop-container">
    <div class="shop-header">
        <h1>Our Products</h1>
        
        <div class="shop-filters">
            <div class="filter-group">
                <label for="category-filter">Category</label>
                <select id="category-filter">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
                </select>
            </div>
            
            <div class="filter-group">
                <label for="sort-filter">Sort By</label>
                <select id="sort-filter">
                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                </select>
            </div>
        </div>
    </div>

    @if($products->count())
    <div class="products-grid">
        @foreach($products as $product)
        <div class="product-card">
            <a href="{{ route('products.show', $product) }}" class="product-link">
                <div class="product-image">
                    @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                    <div class="image-placeholder">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                </div>
                
                <div class="product-details">
                    <h3>{{ $product->name }}</h3>
                    <div class="item-categories">
                    @foreach($product->categories as $category)
                    <span class="category-tag" style="background-color: {{ $categoryColors[$category->id] ?? '#e0e0e0' }};">
                        {{ $category->name }}
                    </span>
                    @endforeach
                    </div>
                    <div class="product-footer">
                        <span class="price">${{ number_format($product->price, 2) }}</span>
                        <span class="stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg viewBox="0 0 24 24">
            <path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3>No products found</h3>
        <p>Try adjusting your search or filter to find what you're looking for.</p>
    </div>
    @endif
</div>

<style>
    /* Shop Container */
    .shop-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* Shop Header */
    .shop-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 2rem;
    }

    .shop-header h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 1rem;
    }

    .shop-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #555;
    }

    .filter-group select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .product-link {
        display: block;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .product-image {
        height: 200px;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
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

    .image-placeholder svg {
        width: 60px;
        height: 60px;
        fill: #ccc;
    }

    .product-details {
        padding: 1rem;
    }

    .product-details h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .product-details .category {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        font-weight: bold;
        color: #4f46e5;
    }

    .stock {
        font-size: 0.8rem;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }

    .in-stock {
        background-color: #e6ffed;
        color: #22863a;
    }

    .out-of-stock {
        background-color: #ffeef0;
        color: #cb2431;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        fill: #ccc;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #666;
    }

    /* Pagination */
    .pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        // Get filter elements
        const categoryFilter = document.getElementById('category-filter');
        const sortFilter = document.getElementById('sort-filter');
        
        // Function to update filters
        function updateFilters() {
            const params = new URLSearchParams();
            
            // Add category filter if selected
            if (categoryFilter.value) {
                params.set('category', categoryFilter.value);
            }
            
            // Add sort filter if not default
            if (sortFilter.value && sortFilter.value !== 'latest') {
                params.set('sort', sortFilter.value);
            }
            
            // Update URL with new parameters
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }
        
        // Add event listeners
        categoryFilter.addEventListener('change', updateFilters);
        sortFilter.addEventListener('change', updateFilters);
    });
</script>
@endsection