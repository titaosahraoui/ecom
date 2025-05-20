<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>MY - Your Premium Shopping Experience</title>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        />
        <style>
            :root {
                --primary: #4a00e0;
                --secondary: #8e2de2;
                --accent: #ff6b6b;
                --light: #f8f9fa;
                --dark: #212529;
                --gray: #6c757d;
                --gradient: linear-gradient(
                    135deg,
                    var(--primary),
                    var(--secondary)
                );
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f5f5f5;
                color: var(--dark);
                line-height: 1.6;
            }

            ul {
                list-style: none;
            }
            /* Navigation */
            .navbar {
                background: var(--gradient);
                color: white;
                padding: 1rem 0;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .nav-container {
                width: 90%;
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                font-size: 1.8rem;
                font-weight: 800;
                letter-spacing: -1px;
                color: white;
                text-decoration: none;
            }

            .nav-toggle {
                display: none;
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .nav-menu {
                display: flex;
                list-style: none;
            }

            .nav-item {
                margin-left: 1rem;
            }

            .nav-link {
                color: white;
                text-decoration: none;
                font-weight: 500;
                padding: 0.5rem 1rem;
                display: block;
            }

            .nav-link:hover {
                opacity: 0.8;
            }

            .nav-actions {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .search-box {
                display: flex;
            }

            .search-input {
                padding: 0.5rem;
                border: none;
                border-radius: 4px 0 0 4px;
            }

            .search-button {
                background: white;
                border: none;
                padding: 0 1rem;
                border-radius: 0 4px 4px 0;
                cursor: pointer;
            }

            .cart-button,
            .account-button {
                background: white;
                color: var(--dark);
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                text-decoration: none;
            }

            .cart-count {
                position: absolute;
                top: -5px;
                right: -5px;
                background: var(--accent);
                color: white;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                font-size: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Dropdown */
            .dropdown {
                position: relative;
            }

            .dropdown-menu {
                position: absolute;
                right: 0;
                top: 100%;
                background: white;
                min-width: 250px;
                border-radius: 4px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                padding: 0.5rem 0;
                display: none;
                z-index: 1000;
            }

            .dropdown:hover .dropdown-menu {
                display: block;
            }

            .dropdown-header {
                padding: 0.5rem 1rem;
                background: var(--light);
            }

            .dropdown-item {
                display: block;
                padding: 0.5rem 1rem;
                color: var(--dark);
                text-decoration: none;
            }

            .dropdown-item:hover {
                background: var(--light);
            }

            .dropdown-divider {
                height: 1px;
                background: #dee2e6;
                margin: 0.5rem 0;
            }

            /* Main Content */
            main {
                min-height: calc(100vh - 200px);
            }

            /* Footer */
            footer {
                background: var(--dark);
                color: white;
                padding: 3rem 0;
            }

            .footer-container {
                width: 90%;
                max-width: 1200px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
            }

            .footer-col h5 {
                margin-bottom: 1rem;
                font-size: 1.1rem;
            }

            .footer-links {
                list-style: none;
            }

            .footer-links li {
                margin-bottom: 0.5rem;
            }

            .footer-links a {
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
            }

            .footer-links a:hover {
                color: white;
            }

            .social-links {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
            }

            .social-icon {
                color: rgba(255, 255, 255, 0.7);
                font-size: 1.5rem;
            }

            .social-icon:hover {
                color: white;
            }

            .newsletter-form {
                display: flex;
                margin-top: 1rem;
            }

            .newsletter-input {
                flex: 1;
                padding: 0.5rem;
                border: none;
                border-radius: 4px 0 0 4px;
            }

            .newsletter-button {
                background: var(--primary);
                color: white;
                border: none;
                padding: 0 1rem;
                border-radius: 0 4px 4px 0;
                cursor: pointer;
            }

            .footer-bottom {
                text-align: center;
                padding-top: 2rem;
                margin-top: 2rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .nav-toggle {
                    display: block;
                }

                .nav-menu {
                    flex-direction: column;
                    width: 100%;
                    display: none;
                }

                .nav-menu.active {
                    display: flex;
                }

                .nav-item {
                    margin: 0;
                }

                .nav-link {
                    padding: 0.75rem 0;
                }

                .nav-actions {
                    width: 100%;
                    justify-content: space-between;
                    margin-top: 1rem;
                    display: none;
                }

                .nav-actions.active {
                    display: flex;
                }
                .alert-success {
                    position: fixed;
                    top: 1rem;
                    right: 1rem;
                    padding: 1rem 1.5rem;
                    background: #ecfdf5;
                    color: #065f46;
                    border-left: 4px solid #10b981;
                    border-radius: 4px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .close-alert {
                    background: none;
                    border: none;
                    color: #065f46;
                    cursor: pointer;
                    font-size: 1.25rem;
                    padding: 0 0.5rem;
                }
            }
        </style>
        @stack('styles')
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar">
            <div class="nav-container">
                <a href="/" class="logo">MY</a>

                <button class="nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="/shop" class="nav-link">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a href="/gallery" class="nav-link">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a href="/about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="/contact" class="nav-link">Contact</a>
                    </li>
                </ul>

                <div class="nav-actions" id="navActions">
                    <div class="search-box">
                        <input
                            type="text"
                            class="search-input"
                            placeholder="Search products..."
                        />
                        <button class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <a href="/orders" class="cart-button">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">3</span>
                    </a>

                    <div class="dropdown">
                        <button class="account-button">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @auth
                            <li class="dropdown-header">
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 10px;
                                    "
                                >
                                    <img
                                        src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->prenom.' '.Auth::user()->nom).'&background=random' }}"
                                        alt="{{ Auth::user()->prenom }}"
                                        style="
                                            width: 40px;
                                            height: 40px;
                                            border-radius: 50%;
                                            object-fit: cover;
                                        "
                                    />
                                    <div>
                                        <div style="color: var(--dark)">
                                            {{ Auth::user()->prenom }}
                                            {{ Auth::user()->nom }}
                                        </div>
                                        <small
                                            style="color: var(--gray)"
                                            >{{ Auth::user()->email }}</small
                                        >
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a
                                    href="{{ route('account.profile') }}"
                                    class="dropdown-item"
                                    ><i
                                        class="fas fa-user-cog"
                                        style="margin-right: 8px"
                                    ></i>
                                    Account Settings</a
                                >
                            </li>
                            <li>
                                <a
                                    href="{{ route('orders.index') }}"
                                    class="dropdown-item"
                                    ><i
                                        class="fas fa-shopping-bag"
                                        style="margin-right: 8px"
                                    ></i>
                                    My Orders</a
                                >
                            </li>

                            @if(auth()->user()->hasRole('admin') ||
                            auth()->user()->hasRole('commercial'))
                            <li class="dropdown-divider"></li>
                            <li>
                                <a
                                    href="{{ route('products.index') }}"
                                    class="dropdown-item"
                                    ><i
                                        class="fas fa-boxes"
                                        style="margin-right: 8px"
                                    ></i>
                                    Manage Products</a
                                >
                            </li>
                            @endif @if(auth()->user()->hasRole('admin'))
                            <li>
                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    class="dropdown-item"
                                    ><i
                                        class="fas fa-tachometer-alt"
                                        style="margin-right: 8px"
                                    ></i>
                                    Admin Dashboard</a
                                >
                            </li>
                            @endif

                            <li class="dropdown-divider"></li>
                            <li>
                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                    style="display: block"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        style="
                                            background: none;
                                            border: none;
                                            width: 100%;
                                            text-align: left;
                                            padding: 0.5rem 1rem;
                                            cursor: pointer;
                                        "
                                        class="dropdown-item"
                                    >
                                        <i
                                            class="fas fa-sign-out-alt"
                                            style="margin-right: 8px"
                                        ></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                            @else
                            <li>
                                <a
                                    href="{{ route('login') }}"
                                    class="dropdown-item"
                                    ><i
                                        class="fas fa-sign-in-alt"
                                        style="margin-right: 8px"
                                    ></i>
                                    Login</a
                                >
                            </li>
                            <li>
                                <a
                                    href="{{ route('register') }}"
                                    class="dropdown-item"
                                    ><i
                                        class="fas fa-user-plus"
                                        style="margin-right: 8px"
                                    ></i>
                                    Register</a
                                >
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>@yield('content')</main>

        <!-- Footer -->
        <footer>
            <div class="footer-container">
                <div class="footer-col">
                    <h5>MY</h5>
                    <p>
                        Your premium destination for quality products and
                        exceptional shopping experience.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-icon"
                            ><i class="fab fa-facebook-f"></i
                        ></a>
                        <a href="#" class="social-icon"
                            ><i class="fab fa-twitter"></i
                        ></a>
                        <a href="#" class="social-icon"
                            ><i class="fab fa-instagram"></i
                        ></a>
                        <a href="#" class="social-icon"
                            ><i class="fab fa-pinterest"></i
                        ></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h5>Shop</h5>
                    <ul class="footer-links">
                        <li><a href="#">All Products</a></li>
                        <li><a href="#">Featured</a></li>
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Sale Items</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Customer</h5>
                    <ul class="footer-links">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Order Tracking</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Shipping Info</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Newsletter</h5>
                    <p>
                        Subscribe to get updates on new products and special
                        offers.
                    </p>
                    <form class="newsletter-form">
                        <input
                            type="email"
                            class="newsletter-input"
                            placeholder="Your email"
                        />
                        <button type="submit" class="newsletter-button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2023 MY. All rights reserved.</p>
                <p>
                    <a href="#" style="color: white; margin: 0 10px"
                        >Privacy Policy</a
                    >
                    <a href="#" style="color: white; margin: 0 10px"
                        >Terms of Service</a
                    >
                    <a href="#" style="color: white; margin: 0 10px"
                        >Contact Us</a
                    >
                </p>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Mobile menu toggle
                $("#navToggle").click(function () {
                    $("#navMenu").toggleClass("active");
                    $("#navActions").toggleClass("active");
                });

                // Cart count (would normally come from backend)
                let cartCount = 3;
                $(".cart-count").text(cartCount);

                // Newsletter form submission
                $(".newsletter-form").submit(function (e) {
                    e.preventDefault();
                    const email = $(this).find("input").val();

                    $.ajax({
                        url: "/newsletter/subscribe",
                        method: "POST",
                        data: { email: email },
                        success: function () {
                            alert("Thank you for subscribing!");
                            $(".newsletter-form")[0].reset();
                        },
                        error: function () {
                            alert("Subscription failed. Please try again.");
                        },
                    });
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".close-alert").forEach((button) => {
                    button.addEventListener("click", function () {
                        this.closest(".alert-success").remove();
                    });
                });

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    document
                        .querySelectorAll(".alert-success")
                        .forEach((alert) => {
                            alert.remove();
                        });
                }, 5000);
            });
        </script>
        @stack('scripts')
    </body>
</html>
