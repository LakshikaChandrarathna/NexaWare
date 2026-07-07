<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='src/css/style.css'>
    <title>VOGUE & CO. | Minimalist Luxury</title>
</head>
<body>

    @include('navbar.ecomnav')

    <main>
        <section class="hero">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1800&q=80" alt="New Season Luxury Collection" class="hero-bg">
            <div class="hero-content">
                <span class="hero-tag">New Season Arrival</span>
                <h1 class="hero-title">Define Your <br><span>Signature</span> Look.</h1>
                <p class="hero-desc">Discover our curation of minimal, elegant pieces designed to blend effortlessly into your lifestyle.</p>
                <div class="hero-btns">
                    <a href="#" class="btn btn-primary">Shop Collection</a>
                    <a href="#" class="btn btn-secondary">Explore Lookbook</a>
                </div>
            </div>
        </section>

        <section class="categories">
            <div class="section-header">
                <h2>Shop by Category</h2>
                <div class="divider"></div>
            </div>

            <div class="category-grid">
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=600&q=80" alt="Essential Apparel" class="category-img">
                    <div class="category-overlay">
                        <h3>Essential Apparel</h3>
                        <span class="category-link">Discover</span>
                    </div>
                </div>

                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80" alt="Statement Pieces" class="category-img">
                    <div class="category-overlay">
                        <h3>Statement Pieces</h3>
                        <span class="category-link">Discover</span>
                    </div>
                </div>

                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=600&q=80" alt="Luxury Footwear" class="category-img">
                    <div class="category-overlay">
                        <h3>Luxury Footwear</h3>
                        <span class="category-link">Discover</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Sample interactivity: Simple cart mock increment counter
        const cartBtn = document.getElementById('cart-btn');
        const cartCount = document.getElementById('cart-count');
        let currentItems = 0;

        // Simulate browsing activity by giving a default count after a brief delay
        setTimeout(() => {
            const cartCountEl = document.getElementById('cart-count');
            if(cartCountEl) {
                currentItems = 2;
                cartCountEl.textContent = currentItems;
            }
        }, 1000);

        // Click notification example
        if(cartBtn) {
            cartBtn.addEventListener('click', () => {
                alert(`You have ${currentItems} items in your bag. Proceeding to checkout?`);
            });
        }
    </script>
</body>
</html>