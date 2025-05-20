@extends('layouts.app') @section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <h1>New Collection 2025</h1>
            <p>Discover our latest fashion trends for the season</p>
            <a href="{{ route('shop') }}" class="shop-button">Shop Now</a>
        </div>
        <img
            src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
            alt="Fashion Collection"
            class="hero-image"
        />
    </div>
</section>

<!-- Featured Categories -->
<section class="categories-section">
    <div class="section-header">
        <h2>Shop by Category</h2>
        <p>Browse our popular collections</p>
    </div>
    <div class="categories-grid">
        @foreach($categories as $category)
        <div class="category-card">
            <div class="category-image-container">
                <img
                    src="https://via.placeholder.com/300x300"
                    alt="{{ $category->name }}"
                    class="category-image"
                />
                <div class="category-overlay">
                    <a
                        href="{{ route('shop', ['category' => $category->id]) }}"
                        class="category-link"
                    >
                        {{ $category->name }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Featured Products -->
<section class="products-section">
    <div class="section-header">
        <h2>Featured Products</h2>
        <p>Our handpicked selection for you</p>
    </div>
    <div class="products-grid">
        @foreach($featuredProducts as $product)
        <div class="product-card">
            <div class="product-image-container">
                <img
                    src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}"
                    alt="{{ $product->name }}"
                    class="product-image"
                />
                @if($product->status == 'out_of_stock')
                <span class="status-badge out-of-stock">Sold Out</span>
                @elseif($product->status == 'coming_soon')
                <span class="status-badge coming-soon">Coming Soon</span>
                @endif
                <div class="product-actions">
                    <a
                        href="{{ route('products.show', $product) }}"
                        class="view-button"
                        >View Details</a
                    >
                </div>
            </div>
            <div class="product-info">
                <h3>{{ $product->name }}</h3>
                <div class="product-meta">
                    <span class="price"
                        >€{{ number_format($product->price, 2) }}</span
                    >
                    @if($product->stock > 0)
                    <span class="stock-status in-stock">In Stock</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="section-footer">
        <a href="{{ route('shop') }}" class="view-all-button"
            >View All Products</a
        >
    </div>
</section>

<!-- Best Sellers -->
<section class="best-sellers-section">
    <div class="section-header">
        <h2>Best Sellers</h2>
        <p>What everyone is loving</p>
    </div>
    <div class="products-grid">
        @foreach($bestSellers as $product)
        <div class="product-card">
            <div class="product-image-container">
                <img
                    src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}"
                    alt="{{ $product->name }}"
                    class="product-image"
                />
                <span class="bestseller-badge">Bestseller</span>
            </div>
            <div class="product-info">
                <h3>{{ $product->name }}</h3>
                <div class="product-meta">
                    <span class="price"
                        >€{{ number_format($product->price, 2) }}</span
                    >
                    <span class="sales-count">Sold: {{ $product->sales }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Brand Story -->
<section class="brand-story">
    <div class="brand-container">
        <img
            src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
            alt="Our Story"
            class="brand-image"
        />
        <div class="brand-content">
            <h2>Our Story</h2>
            <p class="lead">
                MY is more than just a clothing brand - it's a lifestyle.
            </p>
            <p>
                Founded in 2020, we've been committed to providing high-quality,
                sustainable fashion that makes you look good and feel good. Our
                designs blend contemporary trends with timeless elegance.
            </p>
            <a href="{{ route('about') }}" class="learn-more-button"
                >Learn More</a
            >
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter">
    <div class="newsletter-container">
        <h2>Stay Updated</h2>
        <p>
            Subscribe to our newsletter for the latest collections and exclusive
            offers.
        </p>
        <form class="newsletter-form">
            <input type="email" placeholder="Your email address" required />
            <button type="submit">Subscribe</button>
        </form>
    </div>
</section>

<style>
    /* Base Styles */
    :root {
        --primary: #4a00e0;
        --secondary: #8e2de2;
        --dark: #212529;
        --light: #f8f9fa;
        --danger: #dc3545;
        --warning: #ffc107;
        --success: #28a745;
    }

    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        color: #333;
        line-height: 1.6;
    }

    /* Section Styling */
    section {
        padding: 3rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-header h2 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .section-header p {
        color: #666;
        margin-top: 0;
    }

    .section-footer {
        text-align: center;
        margin-top: 2rem;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url("https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80");
        background-size: cover;
        background-position: center;
        color: white;
        min-height: 500px;
        display: flex;
        align-items: center;
    }

    .hero-container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }

    .hero-content {
        flex: 1;
        min-width: 300px;
        padding: 2rem;
    }

    .hero-content h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .hero-image {
        flex: 1;
        min-width: 300px;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .shop-button {
        display: inline-block;
        background: white;
        color: var(--dark);
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .shop-button:hover {
        background: #eee;
        transform: translateY(-2px);
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .category-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
    }

    .category-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image {
        transform: scale(1.05);
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card:hover .category-overlay {
        opacity: 1;
    }

    .category-link {
        color: white;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border: 1px solid white;
        border-radius: 4px;
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .out-of-stock {
        background: var(--danger);
        color: white;
    }

    .coming-soon {
        background: var(--warning);
        color: var(--dark);
    }

    .bestseller-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        background: var(--danger);
        color: white;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .product-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.7);
        padding: 0.5rem;
        text-align: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-actions {
        opacity: 1;
    }

    .view-button {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 0.25rem 0.5rem;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .product-info {
        padding: 1rem;
    }

    .product-info h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        font-weight: bold;
        color: var(--primary);
    }

    .stock-status {
        font-size: 0.8rem;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }

    .in-stock {
        background: var(--success);
        color: white;
    }

    .sales-count {
        font-size: 0.8rem;
        color: #666;
    }

    /* Buttons */
    .view-all-button,
    .learn-more-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border: 1px solid var(--primary);
        color: var(--primary);
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .view-all-button:hover,
    .learn-more-button:hover {
        background: var(--primary);
        color: white;
    }

    /* Brand Story */
    .brand-container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 2rem;
    }

    .brand-image {
        flex: 1;
        min-width: 300px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .brand-content {
        flex: 1;
        min-width: 300px;
    }

    .brand-content h2 {
        font-size: 2rem;
        color: var(--dark);
        margin-bottom: 1rem;
    }

    .brand-content .lead {
        font-size: 1.25rem;
        font-weight: 300;
        margin-bottom: 1rem;
    }

    /* Newsletter */
    .newsletter {
        background: var(--dark);
        color: white;
    }

    .newsletter-container {
        width: 90%;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    .newsletter h2 {
        margin-bottom: 0.5rem;
    }

    .newsletter p {
        margin-bottom: 1.5rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .newsletter-form {
        display: flex;
        gap: 0.5rem;
    }

    .newsletter-form input {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 4px;
    }

    .newsletter-form button {
        padding: 0 1.5rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .newsletter-form button:hover {
        background: var(--secondary);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hero-container,
        .brand-container {
            flex-direction: column;
        }

        .hero-content,
        .brand-content {
            text-align: center;
            margin-bottom: 2rem;
        }

        .newsletter-form {
            flex-direction: column;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Simple hover effects
        $(".category-card, .product-card").hover(
            function () {
                $(this).css("transform", "translateY(-5px)");
            },
            function () {
                $(this).css("transform", "translateY(0)");
            }
        );

        // Newsletter form submission
        $(".newsletter-form").submit(function (e) {
            e.preventDefault();
            const email = $(this).find("input").val();

            $.ajax({
                url: "/newsletter/subscribe",
                method: "POST",
                data: { email: email },
                success: function (response) {
                    alert("Thank you for subscribing!");
                    $(".newsletter-form")[0].reset();
                },
                error: function (xhr) {
                    alert("Subscription failed. Please try again.");
                },
            });
        });
    });
</script>
@endsection
