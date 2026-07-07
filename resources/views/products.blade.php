<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOGUE & CO. | Shop All Products</title>
    <style>
        /* -----------------------------------------
           1. RESET & BRAND VARIABLES
        ----------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --color-dark: #111111;
            --color-light: #f9f9f9;
            --color-accent: #c5a880; /* Elegant gold tone */
            --color-white: #ffffff;
            --color-border: #e5e5e5;
            --color-gray: #767676;
            --font-sans: 'Helvetica Neue', Arial, sans-serif;
            --transition-smooth: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--color-white);
            color: var(--color-dark);
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        list { list-style: none; }

        /* -----------------------------------------
           2. NAVBAR (Same as Welcome Page)
        ----------------------------------------- */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--color-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 4%;
            height: 80px;
        }

        .logo {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .logo span { color: var(--color-accent); }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 500;
            transition: var(--transition-smooth);
        }

        .nav-links a:hover { color: var(--color-accent); }

        .nav-icons { display: flex; gap: 25px; align-items: center; }
        
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--color-dark);
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background-color: var(--color-accent);
            color: var(--color-white);
            font-size: 10px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* -----------------------------------------
           3. PAGE HEADER
        ----------------------------------------- */
        .shop-header {
            text-align: center;
            padding: 60px 20px 40px;
            background-color: var(--color-light);
        }

        .shop-header h1 {
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .shop-header p {
            font-size: 14px;
            color: var(--color-gray);
            font-weight: 300;
        }

        /* -----------------------------------------
           4. SHOP LAYOUT (FILTERS + GRID)
        ----------------------------------------- */
        .shop-container {
            max-w: 1400px;
            margin: 0 auto;
            padding: 40px 4%;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 40px;
        }

        /* Sidebar Filters */
        .filter-sidebar {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .filter-section {
            border-bottom: 1px solid var(--color-border);
            padding-bottom: 20px;
        }

        .filter-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .filter-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-list label {
            font-size: 14px;
            color: #444;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-list input[type="checkbox"] {
            accent-color: var(--color-dark);
            width: 16px;
            height: 16px;
        }

        /* Size Chips */
        .size-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .size-chip {
            border: 1px solid var(--color-border);
            padding: 8px 14px;
            font-size: 12px;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .size-chip:hover, .size-chip.active {
            border-color: var(--color-dark);
            background-color: var(--color-dark);
            color: var(--color-white);
        }

        /* Main Content Area */
        .main-shop {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Toolbar (Sort & Count) */
        .shop-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--color-border);
        }

        .product-count {
            font-size: 14px;
            color: var(--color-gray);
        }

        .sort-select {
            padding: 8px 15px;
            font-size: 13px;
            border: 1px solid var(--color-border);
            background-color: var(--color-white);
            outline: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* -----------------------------------------
           5. PRODUCT GRID & CARD STYLING
        ----------------------------------------- */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 30px;
        }

        .product-card {
            position: relative;
            background-color: var(--color-white);
            group: hover;
        }

        .image-container {
            position: relative;
            height: 380px;
            overflow: hidden;
            background-color: #f5f5f5;
            margin-bottom: 15px;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-smooth);
        }

        /* Hover කලාම image එක සූම් වෙන්න */
        .product-card:hover .product-img {
            transform: scale(1.04);
        }

        /* Quick Add Button Layout */
        .quick-add {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(17, 17, 17, 0.9);
            color: var(--color-white);
            text-align: center;
            padding: 15px 0;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            transform: translateY(100%);
            transition: var(--transition-smooth);
            cursor: pointer;
        }

        .product-card:hover .quick-add {
            transform: translateY(0);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: var(--color-dark);
            color: var(--color-white);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 5px 10px;
            font-weight: 600;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .product-title {
            font-size: 15px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .product-price {
            font-size: 14px;
            font-weight: 600;
        }

        .product-price .old-price {
            color: var(--color-gray);
            text-decoration: line-through;
            font-weight: 300;
            margin-left: 8px;
            font-size: 13px;
        }

        /* -----------------------------------------
           6. RESPONSIVE DESIGN
        ----------------------------------------- */
        @media (max-width: 900px) {
            .shop-container {
                grid-template-columns: 1fr; /* Mobile වලදී filters උඩට යනවා */
            }
            .filter-sidebar {
                display: none; /* සරල වෙන්න mobile වලදී දැනට filter හංගලා තියෙන්නේ */
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="navbar">
        <a href="#" class="logo">VOGUE<span>.</span></a>
        <ul class="nav-links">
            <li><a href="#">New In</a></li>
            <li><a href="#">Clothing</a></li>
            <li><a href="#">Accessories</a></li>
            <li><a href="#">Lookbook</a></li>
        </ul>
        <div class="nav-icons">
            <button class="icon-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
            <button class="icon-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="cart-badge">3</span>
            </button>
        </div>
    </header>

    <!-- Page Title -->
    <section class="shop-header">
        <h1>All Apparel</h1>
        <p>Carefully tailored essential garments for the modern lifestyle.</p>
    </section>

    <!-- Main Shop Section -->
    <div class="shop-container">
        
        <!-- Sidebar Filters -->
        <aside class="filter-sidebar">
            <!-- Categories -->
            <div class="filter-section">
                <h3 class="filter-title">Categories</h3>
                <ul class="filter-list">
                    <li><label><input type="checkbox" checked> All Clothing</label></li>
                    <li><label><input type="checkbox"> Tops & Shirts</label></li>
                    <li><label><input type="checkbox"> Dresses</label></li>
                    <li><label><input type="checkbox"> Jackets & Coats</label></li>
                    <li><label><input type="checkbox"> Trousers</label></li>
                </ul>
            </div>

            <!-- Sizes -->
            <div class="filter-section">
                <h3 class="filter-title">Filter by Size</h3>
                <div class="size-grid">
                    <div class="size-chip">XS</div>
                    <div class="size-chip active">S</div>
                    <div class="size-chip active">M</div>
                    <div class="size-chip">L</div>
                    <div class="size-chip">XL</div>
                </div>
            </div>

            <!-- Price Range Quick Links -->
            <div class="filter-section">
                <h3 class="filter-title">Price</h3>
                <ul class="filter-list">
                    <li><label><input type="checkbox"> Under $50</label></li>
                    <li><label><input type="checkbox"> $50 - $100</label></li>
                    <li><label><input type="checkbox"> Over $100</label></li>
                </ul>
            </div>
        </aside>

        <!-- Product Grid Area -->
        <main class="main-shop">
            <!-- Toolbar -->
            <div class="shop-toolbar">
                <div class="product-count">Showing 1–4 of 24 products</div>
                <div>
                    <select class="sort-select">
                        <option>Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest Items</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="product-grid">
                
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="image-container">
                        <span class="product-badge">New</span>
                        <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=500&q=80" alt="Linen Trench Coat" class="product-img">
                        <div class="quick-add" onclick="addToCart('Classic Trench Coat')">Add to Bag</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Classic Linen Trench Coat</h3>
                        <div class="product-price">$129.00</div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="image-container">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=500&q=80" alt="Silk Midi Dress" class="product-img">
                        <div class="quick-add" onclick="addToCart('Minimalist Midi Dress')">Add to Bag</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Minimalist Silk Midi Dress</h3>
                        <div class="product-price">$89.00</div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="image-container">
                        <span class="product-badge" style="background-color: #d9534f;">Sale</span>
                        <img src="https://images.unsplash.com/photo-1534126416832-a88fdf2911c2?auto=format&fit=crop&w=500&q=80" alt="Oversized Knit Sweater" class="product-img">
                        <div class="quick-add" onclick="addToCart('Oversized Knit Sweater')">Add to Bag</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Oversized Knit Sweater</h3>
                        <div class="product-price">$45.00 <span class="old-price">$65.00</span></div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <div class="image-container">
                        <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?auto=format&fit=crop&w=500&q=80" alt="Tailored Cotton Shirt" class="product-img">
                        <div class="quick-add" onclick="addToCart('Tailored Cotton Shirt')">Add to Bag</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Tailored Cotton Shirt</h3>
                        <div class="product-price">$55.00</div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Interactivity Script -->
    <script>
        function addToCart(productName) {
            alert(`"${productName}" has been added to your shopping bag!`);
        }

        // Size chips ටොගල් කරන්න පොඩි JS කෑල්ලක්
        const chips = document.querySelectorAll('.size-chip');
        chips.forEach(chip => {
            chip.addEventListener('click', () => {
                chip.classList.toggle('active');
            });
        });
    </script>
</body>
</html>