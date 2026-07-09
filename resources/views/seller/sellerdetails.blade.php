<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="src/css/welcome.css">
<link rel="stylesheet" href="src/css/sellerdetails.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>

        
        
    </style>
</head>

<body>
    <div class="container">
        <div style="margin-bottom: 15px;">
            <a href="/" class="backtohome">
                <i class="fas fa-chevron-left"></i> Back to Home
            </a>
        </div>

        <header class="seller-hero">
            <div class="seller-identity">
                <img src="https://via.placeholder.com/100" class="seller-logo-large" alt="Logo">
                <div class="seller-title">
                    <h1>Crafts Ltd <i class="fas fa-check-circle verified-badge"></i></h1>
                    <div class="owner-info">
                        <span class="owner-label">Seller:</span>
                        <span class="owner-name">Kasun Perera</span>
                    </div>
                    <p class="location-text"><i class="fas fa-map-marker-alt"></i> Galle, Sri Lanka • Since 2024</p>
                </div>
            </div>
            <!-- <div class="hero-search-container">
                <form action="" method="GET" class="hero-search-form">
                    <input type="text" name="shop_search" placeholder="Search in this store..."
                        class="hero-search-input">
                    <button type="submit" class="hero-search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div> -->
            <div class="hero-actions">
                <button class="btn btn-message"><i class="far fa-envelope"></i> Message</button>
                <button class="btn btn-follow">Follow Store</button>
            </div>
        </header>

        <div class="stats-grid">
            <div class="stat-card">
                <b>4.9 / 5</b>
                <span>Store Rating</span>
            </div>
            <div class="stat-card">
                <b>1.2k+</b>
                <span>Total Sales</span>
            </div>
            <div class="stat-card">
                <b>98%</b>
                <span>Response Rate</span>
            </div>
            <div class="stat-card">
                <b>24h</b>
                <span>Avg. Shipping</span>
            </div>
        </div>

        <div class="shop-tabs">
            <div class="tab-item active" onclick="openTab(event, 'all-products')">About Store</div>
            <div class="tab-item" onclick="openTab(event, 'reviews')">Reviews</div>
            <!-- <div class="tab-item" onclick="openTab(event, 'about')">History</div> -->
            <div class="tab-item" onclick="openTab(event, 'gallery')">Gallery</div>
        </div>

        <div id="all-products" class="tab-content active">
            <div class="seller-main">
                <aside>
                    <div class="sidebar-card">
                        <h3>About the Artisan</h3>
                        <p class="artisan-description">
                            Specializing in traditional Southern Sri Lankan wood carvings and Raksha masks. Every piece
                            is
                            handcrafted by local artisans using sustainable timber.
                        </p>
                        <div class="artisan-contact-list">
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>+94 77 123 4567</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>crafts.ltd@email.com</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>123, Galle Road, Galle</span>
                            </div>
                        </div>
                        <div class="social-links-container">
                            <p class="social-title">Follow Us:</p>
                            <div class="social-icons">
                                <a href="#" class="social-icon-btn facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon-btn instagram"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-icon-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-card">
                        <h3>Business Policies</h3>
                        <ul style="list-style: none; padding: 0; font-size: 13px; color: var(--text-muted);">
                            <li style="margin-bottom: 10px;"><i class="fas fa-truck"></i> Island-wide Delivery</li>
                            <li style="margin-bottom: 10px;"><i class="fas fa-undo"></i> 7-Day Easy Returns</li>
                            <li><i class="fas fa-certificate"></i> 100% Authentic Handmade</li>
                        </ul>
                    </div>
                </aside>

                <main>
                    <h2 style="font-size: 18px; margin-bottom: 20px;">All Products from Crafts</h2>
                    <div class="product-grid">
                        <div class="card">
                            <div class="card-img">
                                <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=400"
                                    alt="Beeralu Lace">
                            </div>
                            <div class="card-body">
                                <p class="product-title">Hand-Carved Traditional Raksha Mask - Wall Hanging Art</p>
                                <div class="price">Rs.4,200</div>
                                <div class="card-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                                </div>
                                <div class="supplier-info">
                                    <span class="supplier-label">Sold by:</span>
                                    <a href="#" class="supplier-name">Crafts Ltd.</a>
                                    <span class="supplier-location">| Galle</span>
                                </div>
                                <div class="sold-cart-wrapper">
                                    <div class="sold-count">1.2k+ sold</div>
                                    <div class="cart-action-container">
                                        <div class="cart-box">
                                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-img">
                                <img src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=400"
                                    alt="Ceramic Mug">
                            </div>
                            <div class="card-body">
                                <p class="product-title">Hand-painted Ceramic Coffee Mug - Island Flora Designs</p>
                                <div class="price">Rs.950</div>
                                <div class="card-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                                </div>
                                <div class="supplier-info">
                                    <span class="supplier-label">Sold by:</span>
                                    <a href="#" class="supplier-name">Crafts Ltd.</a>
                                    <span class="supplier-location">| Galle</span>
                                </div>
                                <div class="sold-cart-wrapper">
                                    <div class="sold-count">1.2k+ sold</div>
                                    <div class="cart-action-container">
                                        <div class="cart-box">
                                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-img">
                                <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=400"
                                    alt="Beeralu Lace">
                            </div>
                            <div class="card-body">
                                <p class="product-title">Hand-Carved Traditional Raksha Mask - Wall Hanging Art</p>
                                <div class="price">Rs.4,200</div>
                                <div class="card-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                                </div>
                                <div class="supplier-info">
                                    <span class="supplier-label">Sold by:</span>
                                    <a href="#" class="supplier-name">Crafts Ltd.</a>
                                    <span class="supplier-location">| Galle</span>
                                </div>
                                <div class="sold-cart-wrapper">
                                    <div class="sold-count">1.2k+ sold</div>
                                    <div class="cart-action-container">
                                        <div class="cart-box">
                                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-img">
                                <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=400"
                                    alt="Beeralu Lace">
                            </div>
                            <div class="card-body">
                                <p class="product-title">Hand-Carved Traditional Raksha Mask - Wall Hanging Art</p>
                                <div class="price">Rs.4,200</div>
                                <div class="card-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                                </div>
                                <div class="supplier-info">
                                    <span class="supplier-label">Sold by:</span>
                                    <a href="#" class="supplier-name">Crafts Ltd.</a>
                                    <span class="supplier-location">| Galle</span>
                                </div>
                                <div class="sold-cart-wrapper">
                                    <div class="sold-count">1.2k+ sold</div>
                                    <div class="cart-action-container">
                                        <div class="cart-box">
                                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <div id="reviews" class="tab-content">
            <div class="reviews-container">
                <aside>
                    <div class="sidebar-card">
                        <h3>Store Rating</h3>
                        <div class="rating-summary">
                            <h1 class="rating-number">4.9</h1>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="rating-count">Based on 2,450 reviews</p>
                        </div>

                        <div class="rating-bars">
                            <div class="bar-item">
                                <span>5 Star</span>
                                <div class="bar-bg">
                                    <div class="bar-fill" style="width: 90%;"></div>
                                </div>
                                <span>90%</span>
                            </div>
                            <div class="bar-item">
                                <span>4 Star</span>
                                <div class="bar-bg">
                                    <div class="bar-fill" style="width: 7%;"></div>
                                </div>
                                <span>7%</span>
                            </div>
                            <div class="bar-item">
                                <span>3 Star</span>
                                <div class="bar-bg">
                                    <div class="bar-fill" style="width: 3%;"></div>
                                </div>
                                <span>3%</span>
                            </div>
                        </div>
                    </div>
                </aside>

                <main>
                    <h2 style="font-size: 18px; margin-bottom: 20px;">Customer Feedback</h2>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="user-info">
                                <div class="user-avatar">AM</div>
                                <div class="user-details">
                                    <h4>Amila Munasinghe</h4>
                                    <div class="rating-stars" style="font-size: 12px; margin: 2px 0;">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="review-date">2 days ago</span>
                        </div>
                        <p class="review-text">
                            Excellent quality! The Raksha mask is beautifully carved and the details are amazing. Fast
                            shipping to Colombo. Highly recommended!
                        </p>
                        <div class="review-images">
                            <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=200"
                                class="review-img" alt="Review Image">
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="user-info">
                                <div class="user-avatar">SK</div>
                                <div class="user-details">
                                    <h4>Sandeepa Kavinda</h4>
                                    <div class="rating-stars" style="font-size: 12px; margin: 2px 0;">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="far fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="review-date">1 week ago</span>
                        </div>
                        <p class="review-text">
                            The ceramic mug is very pretty. The painting is neat. Would have liked a slightly larger
                            size, but overall very happy.
                        </p>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="user-info">
                                <div class="user-avatar">AM</div>
                                <div class="user-details">
                                    <h4>Amila Munasinghe</h4>
                                    <div class="rating-stars" style="font-size: 12px; margin: 2px 0;">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="review-date">2 days ago</span>
                        </div>
                        <p class="review-text">
                            Excellent quality! The Raksha mask is beautifully carved and the details are amazing. Fast
                            shipping to Colombo. Highly recommended!
                        </p>
                        <div class="review-images">
                            <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=200"
                                class="review-img" alt="Review Image">
                        </div>
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="user-info">
                                <div class="user-avatar">KP</div>
                                <div class="user-details">
                                    <h4>Kasun Perera</h4>
                                    <div class="rating-stars" style="font-size: 12px; margin: 2px 0; color: #f1c40f;">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="far fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="review-date">1 week ago</span>
                        </div>
                        <p class="review-text">
                            Great value for the price. I bought the hand-woven wall hanging and it adds a really vibrant
                            touch to my living room. The packaging was very secure. Delivery took about 3 days, but it
                            was worth the wait!
                        </p>
                        <div class="review-images">

                        </div>
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="user-info">
                                <div class="user-avatar">SD</div>
                                <div class="user-details">
                                    <h4>Sanduni de Silva</h4>
                                    <div class="rating-stars" style="font-size: 12px; margin: 2px 0; color: #ffc107;">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="review-date">5 days ago</span>
                        </div>
                        <p class="review-text">
                            Absolutely love this hand-painted batik sarong! The colors are even more vibrant in person
                            than in the photos. It feels very high quality and perfect for the beach. Will definitely be
                            ordering more as gifts.
                        </p>
                        <div class="review-images">

                        </div>
                    </div>

                    <button class="btn-view-more">View More Reviews</button>
                </main>
            </div>
        </div>

        <!-- <div id="about" class="tab-content about-section">
            <div class="header-area">
                <h2>The Journey of Crafts Ltd</h2>
                <div class="underline"></div>
                <p style="margin-top: 15px; color: var(--text-muted);">From a small backyard workshop in Galle to a leading platform
                    for Sri Lankan artisans.</p>
            </div>

            <div class="journey-grid">
                <div class="journey-card">
                    <span class="year-badge">Jan 2024</span>
                    <h4>The Beginning</h4>
                    <p>Kasun Perera started with 3 woodcarvers in Galle, digitalizing traditional art.</p>
                </div>

                <div class="journey-card">
                    <span class="year-badge">June 2024</span>
                    <h4>Empowering Women</h4>
                    <p>Partnered with 10+ Beeralu lace makers to preserve this dying heritage.</p>
                </div>

                <div class="journey-card">
                    <span class="year-badge">Nov 2025</span>
                    <h4>1,000+ Customers</h4>
                    <p>Reached 1,000+ handcrafted deliveries with a stellar 4.9-star rating.</p>
                </div>

                <div class="journey-card" style="background: linear-gradient(145deg, var(--white), #fff5ef);">
                    <span class="year-badge" style="background: var(--light-highlight); color: var(--primary-teal);">Today</span>
                    <h4>Future Ready</h4>
                    <p>Supporting 50+ artisans island-wide with sustainable income models.</p>
                </div>
            </div>

            <div class="mission-box">
                <h4><i class="fas fa-bullseye"></i> Our Mission</h4>
                <p>
                    To empower local artisans by connecting traditional craftsmanship
                    with modern online markets.
                </p>
            </div>

            <div class="values-row">
                <div class="value-item">
                    <i class="fas fa-leaf"></i>
                    <div class="value-text">
                        <h5>100% Sustainable</h5>
                        <p>Eco-friendly timber & natural dyes.</p>
                    </div>
                </div>
                <div class="value-item">
                    <i class="fas fa-hands"></i>
                    <div class="value-text">
                        <h5>Handmade</h5>
                        <p>No mass production, truly unique.</p>
                    </div>
                </div>
                <div class="value-item">
                    <i class="fas fa-heart"></i>
                    <div class="value-text">
                        <h5>Fair Trade</h5>
                        <p>Direct profits to rural artisans.</p>
                    </div>
                </div>
            </div>
        </div> -->

<div id="gallery" class="tab-content">

    <div class="gallery-header">
        <h2>Image Gallery</h2>
        <p>Explore our workshop, handmade creations, artisan team, and memorable moments.</p>
    </div>

    <div class="gallery-grid">

        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=900"
                alt="Workshop">

            <div class="gallery-overlay">
                <span class="gallery-badge">Workshop</span>
                <h3>Traditional Wood Carving</h3>
                <p>Handcrafted artwork created by skilled local artisans.</p>
            </div>
        </div>

        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?w=900"
                alt="Mask Art">

            <div class="gallery-overlay">
                <span class="gallery-badge">Craft</span>
                <h3>Raksha Mask Collection</h3>
                <p>Authentic Sri Lankan traditional mask designs.</p>
            </div>
        </div>

        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900"
                alt="Ceramic">

            <div class="gallery-overlay">
                <span class="gallery-badge">Ceramics</span>
                <h3>Hand-painted Pottery</h3>
                <p>Unique ceramic collections with artistic detailing.</p>
            </div>
        </div>

        <div class="gallery-card large-card">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=900"
                alt="Team">

            <div class="gallery-overlay">
                <span class="gallery-badge">Team</span>
                <h3>Our Artisan Family</h3>
                <p>Supporting talented rural creators across Sri Lanka.</p>
            </div>
        </div>

        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?w=900"
                alt="Painting">

            <div class="gallery-overlay">
                <span class="gallery-badge">Painting</span>
                <h3>Creative Detailing</h3>
                <p>Every product is carefully finished by hand.</p>
            </div>
        </div>

        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=900"
                alt="Packaging">

            <div class="gallery-overlay">
                <span class="gallery-badge">Delivery</span>
                <h3>Safe Packaging</h3>
                <p>Secure and eco-friendly product packaging process.</p>
            </div>
        </div>

    </div>

</div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-item");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>