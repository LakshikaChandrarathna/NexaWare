<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DBONDA </title>

<head>
    <link rel="stylesheet" href="src/css/welcome.css">
    <link rel="stylesheet" href="src/css/shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
       
        #modal-size-grid .size-btn {
            background-color: #ffffff;
            color: #333333;
            border: 1px solid #dddddd;
            border-radius: 4px;
            padding: 6px 12px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            
        }

        
        #modal-size-grid .size-btn:hover {
            border-color: #888888;
        }

        
        #modal-size-grid .size-btn.selected {
            background-color: #b5cbf0;
            
            color: #ffffff;
            
            border-color: #071835;
         
        }
        #modal-color-grid .color-item.selected {
    border: 3px solid #071835 !important; 
    transform: scale(1.15); 
    box-shadow: 0 0 8px rgba(0,0,0,0.3);
}
    </style>

    <!-- <div class="top-bar">
    <div class="container top-bar-content">
        <div>Free Shipping on all orders | 90-day returns</div>
    </div>
</div> -->

    @include('navbar.ecomnav')
    <div class="nav-sized-black-block"></div>
    <a href="javascript:history.back()" class="back-btns">
        <span class="arrow">&larr;</span> Back
    </a>


    <div class="container">
        <div class="products-header-wrapper">
            <h2 class="section-title-style-1">Products</h2>
        </div>

        <div id="best-sellers-content" class="product-grid product-tab-content active">

            <div id="filtered-products-grid" style="display: contents;">

                @if(isset($products) && $products->count() > 0)
                    @foreach ($products as $product)
                        @php

                            $discountValue = $product->computed_discount ?? 0;

                            $badgeText = $discountValue > 0 ? $discountValue . '% OFF' : '';
                        @endphp

                        <div class="card">
                            <div class="card-img" onclick="openProductModal(this)" style="cursor: pointer;"
                                data-title="{{ $product->title }}" data-price="{{ $product->price }}"
                                data-discount="{{ $discountValue }}"
                                data-delivery="Rs. {{ number_format($product->delivery_fee ?? 350, 0) }}"
                                data-image="{{ $product->image_url ? asset($product->image_url) : asset('/upload/default.png') }}"
                                data-rating="{{ $product->rating ?? 5.0 }}" data-reviews="{{ $product->reviews_count ?? 0 }}"
                                data-colors="{{ !empty($product->formatted_colors) ? $product->formatted_colors : 'White,#ffffff' }}"
                                data-sizes="{{ !empty($product->formatted_sizes) ? $product->formatted_sizes : 'Free Size' }}">

                                @if(!empty($badgeText))
                                    <span class="badge badge-bestseller">{{ $badgeText }}</span>
                                @endif
                                <img src="{{ $product->image_url ? asset($product->image_url) : asset('/upload/default.png') }}"
                                    alt="{{ $product->title }}">
                            </div>

                            <div class="card-body">
                                <p class="product-title">{{ $product->title }}</p>

                                <div class="price">
                                    @if($discountValue > 0)
                                        @php
                                            $calculatedPrice = $product->price - ($product->price * ($discountValue / 100));
                                        @endphp
                                        Rs. {{ number_format($calculatedPrice, 0) }}
                                        <span
                                            style="text-decoration: line-through; color: #aaa; font-size: 12px; margin-left: 5px;">
                                            Rs. {{ number_format($product->price, 0) }}
                                        </span>
                                    @else
                                        Rs. {{ number_format($product->price, 0) }}
                                    @endif
                                </div>

                                <div class="card-rating">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($product->rating))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-text">{{ number_format($product->rating, 1) }}
                                        ({{ $product->reviews_count }}+ Reviews)</span>
                                </div>

                                <div class="sold-cart-wrapper">
                                    <div class="sold-count">{{ $product->sold_count ?? 0 }}+ sold</div>
                                    <div class="cart-action-container">
                                        <div class="cart-box" onclick="toggleToQty(this); updateQty(this, 0)"
                                            data-id="{{ $product->id }}">
                                            <img src="{{ asset('/upload/shoppingcart3.png') }}" alt="Cart" class="cart-img">
                                        </div>
                                        <div class="qty-controls">
                                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                            <span class="qty-val">1</span>
                                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="color: #ffffff; grid-column: 1/-1; text-align:center; padding: 40px; font-size: 1.1rem;">
                        No products found matching your filter selections.
                    </div>
                @endif

            </div>
        </div>
    </div>




    <div id="five-star-content" class="product-grid product-tab-content">
        <div class="card">
            <div class="card-img">
                <span class="badge badge-top-rated">5.0 Rated</span>
                <img src="/upload/d2.png" alt="Product">
            </div>
            <div class="card-body">
                <p class="product-title">High Quality Purple Sand Disc(6 inch)</p>
                <div class="card-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                </div>
                <div class="price">Rs.850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">1.2k+ sold</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-top-rated">5.0 Rated</span>
                <img src="/upload/d2.png" alt="Product">
            </div>
            <div class="card-body">
                <p class="product-title">High Quality Purple Sand Disc(6 inch)</p>
                <div class="card-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                </div>
                <div class="price">Rs.850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">1.2k+ sold</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-img">
                <span class="badge badge-top-rated">5.0 Rated</span>
                <img src="/upload/d2.png" alt="Product">
            </div>
            <div class="card-body">
                <p class="product-title">High Quality Purple Sand Disc(6 inch)</p>
                <div class="card-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                </div>
                <div class="price">Rs.850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">1.2k+ sold</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-top-rated">5.0 Rated</span>
                <img src="/upload/d2.png" alt="Product">
            </div>
            <div class="card-body">
                <p class="product-title">High Quality Purple Sand Disc(6 inch)</p>
                <div class="card-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                </div>
                <div class="price">Rs.850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">1.2k+ sold</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-top-rated">5.0 Rated</span>
                <img src="/upload/d2.png" alt="Product">
            </div>
            <div class="card-body">
                <p class="product-title">High Quality Purple Sand Disc(6 inch)</p>
                <div class="card-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                </div>
                <div class="price">Rs.850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">1.2k+ sold</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-top-rated">5.0 Rated</span>
                <img src="/upload/d2.png" alt="Product">
            </div>
            <div class="card-body">
                <p class="product-title">High Quality Purple Sand Disc(6 inch)</p>
                <div class="card-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="rating-text">5.0 (2k+ Reviews)</span>
                </div>
                <div class="price">Rs.850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">1.2k+ sold</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div id="new-drops-content" class="product-grid product-tab-content">
        <div class="card">
            <div class="card-img">
                <span class="badge badge-new">Just In</span>
                <img src="/upload/d2.png" alt="Wallet">
            </div>
            <div class="card-body">
                <p class="product-title">Genuine Leather Slim Wallet - Hand-stitched</p>
                <div class="price">Rs.2,850</div>

                <div class="sold-cart-wrapper">
                    <div class="sold-count">New Release</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-new">Just In</span>
                <img src="/upload/d2.png" alt="Wallet">
            </div>
            <div class="card-body">
                <p class="product-title">Genuine Leather Slim Wallet - Hand-stitched</p>
                <div class="price">Rs.2,850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">New Release</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-new">Just In</span>
                <img src="/upload/d2.png" alt="Coasters">
            </div>
            <div class="card-body">
                <p class="product-title">Ebony Wood Hand-carved Coaster Set (4 pcs)</p>
                <div class="price">Rs.1,850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">New Release</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-new">Just In</span>
                <img src="/upload/d2.png" alt="Coasters">
            </div>
            <div class="card-body">
                <p class="product-title">Ebony Wood Hand-carved Coaster Set (4 pcs)</p>
                <div class="price">Rs.1,850</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">New Release</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-new">Just In</span>
                <img src="/upload/d2.png" alt="Placemats">
            </div>
            <div class="card-body">
                <p class="product-title">Natural Cane Table Placemats - Set of 6</p>
                <div class="price">Rs.3,200</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">New Release</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-img">
                <span class="badge badge-new">New Arrival</span>
                <img src="/upload/d3.png" alt="Treacle">
            </div>
            <div class="card-body">
                <p class="product-title">Pure Traditional Kithul Treacle - 375ml Bottle</p>
                <div class="price">Rs.1,350</div>
                <div class="sold-cart-wrapper">
                    <div class="sold-count">New Release</div>

                    <div class="cart-action-container">
                        <div class="cart-box" onclick="toggleToQty(this)">
                            <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <span class="qty-val">1</span>
                            <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </div>



    <div class="show-more-container">
        <button class="show-more-btn" id="show-more-btn">Show more</button>
    </div>
    <!-- Explore items ui -->

    <!-- <div class="main-explore-container">

        <h2 style="margin: 40px 31px 20px; font-family: sans-serif; font-size: 24px;">Explore your interests</h2>
        <div class="scroll-container-wrapper">
            <button class="scrollbtn prev-btn" onclick="scrollGrid(-1)">&#10094;</button>
            <div class="horizontal-grid" id="productGrid">


                <div class="Explorecard">
                    <div class="card-img">
                        <span class="badge badge-premium">Premium</span>
                        <img src="/upload/d2.png" alt="Ceylon Tea">
                    </div>
                    <div class="card-body">
                        <p class="product-title">High Quality Purple Sand Disc(6 inch) </p>
                        <div class="price">Rs.1094</div>
                        <div class="card-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (2k+ Reviews)</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">1.2k+ sold</div>

                            <div class="cart-action-container">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="Explorecard">
                    <div class="card-img">
                        <span class="badge badge-bestseller">Bestseller</span>
                        <img src="/upload/d3.png" alt="Beeralu Lace">
                    </div>
                    <div class="card-body">
                        <p class="product-title">Dbonda Body Sealant & Windscreen Sealant</p>
                        <div class="price">Rs.4,200</div>
                        <div class="card-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (2k+ Reviews)</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">1.2k+ sold</div>

                            <div class="cart-action-container">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="Explorecard">
                    <div class="card-img">
                        <span class="badge badge-premium">Premium</span>
                        <img src="/upload/d2.png" alt="Ceylon Tea">
                    </div>
                    <div class="card-body">
                        <p class="product-title">High Quality Purple Sand Disc(6 inch) </p>
                        <div class="price">Rs.1094</div>
                        <div class="card-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (2k+ Reviews)</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">1.2k+ sold</div>

                            <div class="cart-action-container">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="Explorecard">
                    <div class="card-img">
                        <span class="badge badge-premium">Premium</span>
                        <img src="/upload/d2.png" alt="Ceylon Tea">
                    </div>
                    <div class="card-body">
                        <p class="product-title">High Quality Purple Sand Disc(6 inch) </p>
                        <div class="price">Rs.1094</div>
                        <div class="card-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (2k+ Reviews)</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">1.2k+ sold</div>

                            <div class="cart-action-container">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="Explorecard">
                    <div class="card-img">
                        <span class="badge badge-bestseller">Bestseller</span>
                        <img src="/upload/d3.png" alt="Beeralu Lace">
                    </div>
                    <div class="card-body">
                        <p class="product-title">Dbonda Body Sealant & Windscreen Sealant</p>
                        <div class="price">Rs.4,200</div>
                        <div class="card-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (2k+ Reviews)</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">1.2k+ sold</div>

                            <div class="cart-action-container">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="Explorecard">
                    <div class="card-img">
                        <span class="badge badge-premium">Premium</span>
                        <img src="/upload/d2.png" alt="Ceylon Tea">
                    </div>
                    <div class="card-body">
                        <p class="product-title">High Quality Purple Sand Disc(6 inch) </p>
                        <div class="price">Rs.1094</div>
                        <div class="card-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (2k+ Reviews)</span>
                        </div>
                        <div class="sold-cart-wrapper">
                            <div class="sold-count">1.2k+ sold</div>

                            <div class="cart-action-container">
                                <div class="cart-box" onclick="toggleToQty(this)">
                                    <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                                </div>
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <span class="qty-val">1</span>
                                    <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <button class="scrollbtn next-btn" onclick="scrollGrid(1)">&#10095;</button>
        </div>
    </div> -->

    <div id="similar-products-section"
        style="display: none; margin-top: 40px; border-top: 2px solid #f0f0f0; padding-top: 20px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Similar Products You May Like</h2>
        <div class="product-grid">
            <div class="card">
                <div class="card-img">
                    <span class="badge">Almost Sold Out</span>
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400" alt="Product">
                </div>
                <div class="card-body">
                    <p class="product-title">Authentic Ceylon Spices Variety Pack - Small Farm Direct</p>
                    <div class="price">Rs.850</div>
                    <div class="card-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.0 (1k+ Reviews)</span>
                    </div>
                    <div class="supplier-info">
                        <span class="supplier-label">Sold by:</span>
                        <a href="/sellerdetails" class="supplier-name">Crafts Ltd.</a>
                        <span class="supplier-location">| Galle</span>
                    </div>
                    <div class="sold-cart-wrapper">
                        <div class="sold-count">1.2k+ sold</div>



                        <div class="cart-action-container">
                            <div class="cart-box"
                                onclick="toggleToQty(this); openModal('https:/images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'Authentic Ceylon Spices Variety Pack - Small Farm Direct', '850', '', 1)">
                                <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                            </div>

                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="similar-products-link">
                    <a href="javascript:void(0)" class="similar-btn" onclick="showSimilarProducts()">
                        Show Similar Products
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-img">
                    <span class="badge">Almost Sold Out</span>
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400" alt="Product">
                </div>
                <div class="card-body">
                    <p class="product-title">Authentic Ceylon Spices Variety Pack - Small Farm Direct</p>
                    <div class="price">Rs.850</div>
                    <div class="card-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.0 (1k+ Reviews)</span>
                    </div>
                    <div class="supplier-info">
                        <span class="supplier-label">Sold by:</span>
                        <a href="/sellerdetails" class="supplier-name">Crafts Ltd.</a>
                        <span class="supplier-location">| Galle</span>
                    </div>
                    <div class="sold-cart-wrapper">
                        <div class="sold-count">1.2k+ sold</div>



                        <div class="cart-action-container">
                            <div class="cart-box"
                                onclick="toggleToQty(this); openModal('https:/images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'Authentic Ceylon Spices Variety Pack - Small Farm Direct', '850', '', 1)">
                                <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                            </div>

                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="similar-products-link">
                    <a href="javascript:void(0)" class="similar-btn" onclick="showSimilarProducts()">
                        Show Similar Products
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-img">
                    <span class="badge">Almost Sold Out</span>
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400" alt="Product">
                </div>
                <div class="card-body">
                    <p class="product-title">Authentic Ceylon Spices Variety Pack - Small Farm Direct</p>
                    <div class="price">Rs.850</div>
                    <div class="card-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.0 (1k+ Reviews)</span>
                    </div>
                    <div class="supplier-info">
                        <span class="supplier-label">Sold by:</span>
                        <a href="/sellerdetails" class="supplier-name">Crafts Ltd.</a>
                        <span class="supplier-location">| Galle</span>
                    </div>
                    <div class="sold-cart-wrapper">
                        <div class="sold-count">1.2k+ sold</div>



                        <div class="cart-action-container">
                            <div class="cart-box"
                                onclick="toggleToQty(this); openModal('https:/images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'Authentic Ceylon Spices Variety Pack - Small Farm Direct', '850', '', 1)">
                                <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                            </div>

                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="similar-products-link">
                    <a href="javascript:void(0)" class="similar-btn" onclick="showSimilarProducts()">
                        Show Similar Products
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-img">
                    <span class="badge">Almost Sold Out</span>
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400" alt="Product">
                </div>
                <div class="card-body">
                    <p class="product-title">Authentic Ceylon Spices Variety Pack - Small Farm Direct</p>
                    <div class="price">Rs.850</div>
                    <div class="card-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.0 (1k+ Reviews)</span>
                    </div>
                    <div class="supplier-info">
                        <span class="supplier-label">Sold by:</span>
                        <a href="/sellerdetails" class="supplier-name">Crafts Ltd.</a>
                        <span class="supplier-location">| Galle</span>
                    </div>
                    <div class="sold-cart-wrapper">
                        <div class="sold-count">1.2k+ sold</div>



                        <div class="cart-action-container">
                            <div class="cart-box"
                                onclick="toggleToQty(this); openModal('https:/images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'Authentic Ceylon Spices Variety Pack - Small Farm Direct', '850', '', 1)">
                                <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                            </div>

                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="similar-products-link">
                    <a href="javascript:void(0)" class="similar-btn" onclick="showSimilarProducts()">
                        Show Similar Products
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-img">
                    <span class="badge">Almost Sold Out</span>
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400" alt="Product">
                </div>
                <div class="card-body">
                    <p class="product-title">Authentic Ceylon Spices Variety Pack - Small Farm Direct</p>
                    <div class="price">Rs.850</div>
                    <div class="card-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.0 (1k+ Reviews)</span>
                    </div>
                    <div class="supplier-info">
                        <span class="supplier-label">Sold by:</span>
                        <a href="/sellerdetails" class="supplier-name">Crafts Ltd.</a>
                        <span class="supplier-location">| Galle</span>
                    </div>
                    <div class="sold-cart-wrapper">
                        <div class="sold-count">1.2k+ sold</div>



                        <div class="cart-action-container">
                            <div class="cart-box"
                                onclick="toggleToQty(this); openModal('https:/images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'Authentic Ceylon Spices Variety Pack - Small Farm Direct', '850', '', 1)">
                                <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                            </div>

                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="similar-products-link">
                    <a href="javascript:void(0)" class="similar-btn" onclick="showSimilarProducts()">
                        Show Similar Products
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-img">
                    <span class="badge">Almost Sold Out</span>
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400" alt="Product">
                </div>
                <div class="card-body">
                    <p class="product-title">Authentic Ceylon Spices Variety Pack - Small Farm Direct</p>
                    <div class="price">Rs.850</div>
                    <div class="card-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.0 (1k+ Reviews)</span>
                    </div>
                    <div class="supplier-info">
                        <span class="supplier-label">Sold by:</span>
                        <a href="/sellerdetails" class="supplier-name">Crafts Ltd.</a>
                        <span class="supplier-location">| Galle</span>
                    </div>
                    <div class="sold-cart-wrapper">
                        <div class="sold-count">1.2k+ sold</div>



                        <div class="cart-action-container">
                            <div class="cart-box"
                                onclick="toggleToQty(this); openModal('https:/images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'Authentic Ceylon Spices Variety Pack - Small Farm Direct', '850', '', 1)">
                                <img src="/upload/shoppingcart3.png" alt="Cart" class="cart-img">
                            </div>

                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="similar-products-link">
                    <a href="javascript:void(0)" class="similar-btn" onclick="showSimilarProducts()">
                        Show Similar Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div id="cartModal" class="modal">
        <div class="modal-content">
            <div class="modalhead">
                <span class="close-btn" onclick="closeModal()">&times;</span>

                <div class="cart-header">
                    <div class="subtotal-banner">
                        <i class="fas fa-shopping-cart"></i> Subtotal
                    </div>
                    <h2 id="modalTotal">LKR 0.00</h2>
                    <!-- <div class="shipping-note">
                <span><i class="fas fa-check"></i> Free shipping special for you</span>
            </div> -->
                    <div class="cart-actions">
                        <button class="go-cart-btn" onclick="saveCartToBackend()">Go to cart</button>
                    </div>
                    <!-- <div class="cart-actions">
                     
                    <button class="go-cart-btn" onclick="saveCartToBackend()" onclick="window.location.href='/buyercart'">Go to cart</button>

                </div> -->
                </div>
            </div>

            <hr>


            <!-- <div class="select-all-sec">
            <input type="checkbox" id="selectAll"> <label for="selectAll">Select all (2)</label>
        </div> -->

            <div id="cartItemsList" class="cart-items-container">

            </div>


        </div>
    </div>

    <div class="modal-overlay" id="productModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 99999 !important; justify-content: center; align-items: center;">
        <div class="modern-product-card">
            <span class="close-modal" onclick="closeProductModal()" style="cursor: pointer;">&times;</span>

            <div class="image-section">
                <div class="thumbnail-grid" id="modal-thumbnail-grid">
                </div>
                <div class="main-img-container" id="zoom-container"
                    style="width: 100%; height: 450px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f9f9f9; border-radius: 8px;">
                    <img src="" alt="Product" id="modal-main-img"
                        style="max-width: 100%; max-height: 100%; object-fit: contain; width: auto; height: auto;">
                </div>
            </div>

            <div class="details-section">
                <nav style="font-size: 12px; color: #888;">Products > </nav>
                <h1 class="productname" id="modal-title"></h1>

                <div class="rating-row">
                    <div class="stars" id="modal-stars"></div>
                    <span class="rating-val" id="modal-rating-val"></span>
                    <a href="#" class="review-link" id="modal-review-link"></a>
                </div>

                <div class="price-container">
                    <span class="main-price" id="modal-price"></span>
                    <span style="text-decoration: line-through; color: #aaa;" id="modal-old-price"></span>
                    <span class="discount-badge" id="modal-discount-badge"></span>
                </div>

                <div class="delivery-container">
                    <div class="delivery-info">
                        <div class="delivery-icon-wrapper">
                            <i class="fas fa-truck"></i>
                        </div>
                        <span class="delivery-label">Delivery Fee</span>
                    </div>
                    <div class="delivery-value-box">
                        <span class="delivery-amount" id="modal-delivery-amount"></span>
                    </div>
                </div>

                <div class="options">
                    <p class="options-title" id="modal-color-title">Color: </p>
                    <div class="color-grid" id="modal-color-grid">
                    </div>
                </div>

                <div class="options size-selection-wrapper">
                    <p class="options-title size-title">Size:</p>
                    <div class="size-grid" id="modal-size-grid">
                    </div>
                </div>

                <div class="qty-container">
                    <p style="font-size: 13px; font-weight: 600;">Quantity: deliver within 3 days</p>
                    <div class="qty-selector">
                        <button class="qty-btn" onclick="updateQty(-1)">-</button>
                        <input type="text" class="qty-input" id="qty" value="1" readonly>
                        <button class="qty-btn" onclick="updateQty(1)">+</button>
                    </div>
                </div>

                <div class="button-group">
                    <button class="addcartbtn" onclick="saveModalProductToBackend()">Add to Cart</button>
                    <!-- <button class="buynowbtn">Buy Now</button> -->
                </div>
            </div>
        </div>
    </div>

    <script>

        function scrollGrid(direction) {
            const grid = document.getElementById('productGrid');
            const scrollAmount = grid.clientWidth;

            grid.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        function updateButtons() {
            const grid = document.getElementById('productGrid');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');

            if (grid.scrollLeft <= 5) {
                prevBtn.style.opacity = "0";
                prevBtn.style.pointerEvents = "none";
            } else {
                prevBtn.style.opacity = "1";
                prevBtn.style.pointerEvents = "auto";
            }

            if (grid.scrollLeft + grid.clientWidth >= grid.scrollWidth - 5) {
                nextBtn.style.opacity = "0";
                nextBtn.style.pointerEvents = "none";
            } else {
                nextBtn.style.opacity = "1";
                nextBtn.style.pointerEvents = "auto";
            }
        }

        const grid = document.getElementById('productGrid');
        grid.addEventListener('scroll', updateButtons);
        window.addEventListener('load', updateButtons);
        window.addEventListener('resize', updateButtons);



        document.addEventListener('DOMContentLoaded', function () {
            const bestSellersView = document.getElementById('best-sellers-content');
            const fiveStarView = document.getElementById('five-star-content');
            const newDropsView = document.getElementById('new-drops-content');

            const navLinks = document.querySelectorAll('.ecom-nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    const text = this.textContent.trim().toLowerCase();


                    const validTabs = ['5 star', 'rated', 'best seller', 'new drops'];

                    if (validTabs.some(tab => text.includes(tab))) {
                        e.preventDefault();


                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');


                        bestSellersView.classList.remove('active');
                        fiveStarView.classList.remove('active');
                        newDropsView.classList.remove('active');


                        if (text.includes('5 star') || text.includes('rated')) {
                            fiveStarView.classList.add('active');
                        } else if (text.includes('best seller')) {
                            bestSellersView.classList.add('active');
                        } else if (text.includes('new drops')) {
                            newDropsView.classList.add('active');
                        }
                    }
                });
            });
        });

        function toggleToQty(element) {
            element.style.display = 'none';
            element.nextElementSibling.style.display = 'flex';
        }

        // Update Quantity
        function updateQty(btn, delta) {
            const controls = btn.parentElement;
            const valSpan = controls.querySelector('.qty-val');
            let val = parseInt(valSpan.innerText);

            val += delta;

            if (val < 1) {
                controls.style.display = 'none';
                controls.previousElementSibling.style.display = 'flex';
                valSpan.innerText = 1;
            } else {
                valSpan.innerText = val;
            }
        }

        document.getElementById('show-more-btn').addEventListener('click', function () {

            const hiddenCards = document.querySelectorAll('.hidden-card');


            hiddenCards.forEach(card => {
                card.classList.remove('hidden-card');

            });

            this.parentElement.style.display = 'none';
        });

        // function saveCartToBackend() {
        //         const title = document.querySelector('.item-name')?.innerText;
        //         const priceText = document.querySelector('.price')?.innerText;
        //         const qty = document.querySelector('.qty-count-text')?.innerText;
        //         const imgSrc = document.querySelector('.cart-item img')?.src;
        //         const imageUrl = imgSrc ? new URL(imgSrc).pathname : null;


        //         let cleanPrice = priceText ? priceText.replace(/\D/g, '') : 0;


        //         const dataToSend = {
        //             title: title,
        //             price: parseInt(cleanPrice),
        //             qty: parseInt(qty) || 1,
        //             img: imageUrl,

        //         };

        //         fetch('/cart/save', {
        //             method: 'POST',  
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'Accept': 'application/json',  
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        //             },
        //             body: JSON.stringify(dataToSend)  
        //         })
        //         .then(response => response.json())  
        //         .then(result => {
        //             if(result.success) {

        //                 window.location.href = '/my-cart';
        //             } else {
        //                 alert("Error: " + result.message);
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // }

        function saveCartToBackend() {

            const cartItems = document.querySelectorAll('.cart-items-container .cart-item');

            if (cartItems.length === 0) {
                alert("empty card!");
                return;
            }

            const itemsArray = [];


            cartItems.forEach(item => {
                const title = item.querySelector('.item-name')?.innerText;
                const priceText = item.querySelector('.price')?.innerText;
                const qty = item.querySelector('.qty-count-text')?.innerText;
                const imgSrc = item.querySelector('img')?.src;
                const imageUrl = imgSrc ? new URL(imgSrc).pathname : null;

                let cleanPrice = priceText ? priceText.replace(/\D/g, '') : 0;

                itemsArray.push({
                    title: title ?? 'No Title',
                    price: parseInt(cleanPrice) || 0,
                    qty: parseInt(qty) || 1,
                    img: imageUrl
                });
            });


            fetch('/cart/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({ items: itemsArray })
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        window.location.href = '/my-cart';
                    } else {
                        alert("Error: " + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        function openModal(img, title, price, desc, qty = 1) {
            document.getElementById("cartModal").style.display = "flex";
            const cartItemsList = document.getElementById("cartItemsList");

            let cleanPrice = price.replace(/\D/g, '');
            let unitPrice = parseInt(cleanPrice);

            if (isNaN(unitPrice)) unitPrice = 0;

            let existingItem = Array.from(cartItemsList.querySelectorAll('.cart-item')).find(item => {
                return item.querySelector('.item-name')?.innerText === title;
            });

            if (existingItem) {
                let qtyDisplay = existingItem.querySelector('.qty-count-text');
                if (qtyDisplay) {
                    qtyDisplay.innerText = qty;
                }
            } else {

                const newItemHTML = `
        <div class="cart-item">
            <input type="checkbox" checked>
            <img src="${img}" alt="${title}">
            <div class="item-details">
                <p class="item-name" style="font-size: 12px; margin-bottom: 5px; ">${title}</p>
                <p class="price">Rs. ${unitPrice.toLocaleString()}</p>
                <p>Qty: <span class="qty-count-text" >${qty}</span></p>
                
            </div>
        </div>`;
                cartItemsList.insertAdjacentHTML('beforeend', newItemHTML);
            }


            let finalSubtotal = 0;
            const allCartItems = cartItemsList.querySelectorAll('.cart-item');

            allCartItems.forEach(item => {
                let itemPriceText = item.querySelector('.price')?.innerText || "0";
                let itemQtyText = item.querySelector('.qty-count-text')?.innerText || "1";

                let itemUnitPrice = parseInt(itemPriceText.replace(/\D/g, '')) || 0;
                let itemQty = parseInt(itemQtyText) || 1;

                finalSubtotal += (itemUnitPrice * itemQty);
            });


            document.getElementById("modalTotal").innerText = "Rs. " + finalSubtotal.toLocaleString();
        }


        function closeModal() {
            document.getElementById("cartModal").style.display = "none";
        }

        // function updateQty(btn, change) {
        //     let qtyValSpan = btn.parentElement.querySelector('.qty-val');
        //     let currentQty = parseInt(qtyValSpan.innerText);
        //     let newQty = currentQty + change;

        //     if (newQty >= 1) {
        //         qtyValSpan.innerText = newQty;

        //         let card = btn.closest('.card');
        //         let title = card.querySelector('.product-title').innerText;
        //         let price = card.querySelector('.price').innerText;
        //         let img = card.querySelector('.card-img img').src;

        //         openModal(img, title, price, '', newQty);
        //     }
        // }

        function updateQty(btnOrChange, change) {
            let qtyInput, currentQty, newQty;

            if (typeof btnOrChange === 'number') {
                qtyInput = document.getElementById('qty');
                currentQty = parseInt(qtyInput.value);
                newQty = currentQty + btnOrChange;

                if (newQty >= 1) {
                    qtyInput.value = newQty;
                    let img = document.getElementById('main-img').src;
                    let title = document.getElementById('title').innerText;
                    let price = document.getElementById('price').innerText;
                }
            }
            else {
                let btn = btnOrChange;
                let qtyValSpan = btn.parentElement.querySelector('.qty-val');
                currentQty = parseInt(qtyValSpan.innerText);
                newQty = currentQty + change;

                const qtyControls = btn.parentElement;
                const cartButton = qtyControls.previousElementSibling;

                if (newQty >= 1) {
                    qtyValSpan.innerText = newQty;

                    let card = btn.closest('.card');
                    if (card) {
                        let title = card.querySelector('.product-title').innerText;
                        let img = card.querySelector('.card-img img').src;

                        let priceElement = card.querySelector('.price');
                        let price = priceElement.childNodes[0].textContent.trim();

                        openModal(img, title, price, '', newQty);
                    }
                } else {
                    qtyControls.style.display = 'none';
                    if (cartButton) cartButton.style.display = 'flex';
                    qtyValSpan.innerText = "1";
                }
            }
        }

        function openProductModal(element) {

            const title = element.getAttribute('data-title');
            const image = element.getAttribute('data-image');
            const rating = element.getAttribute('data-rating');
            const reviews = element.getAttribute('data-reviews');
            const delivery = element.getAttribute('data-delivery');
            const colorsData = element.getAttribute('data-colors');
            const sizesData = element.getAttribute('data-sizes');

            const basePrice = parseFloat(element.getAttribute('data-price')) || 0;
            const discountPercent = parseFloat(element.getAttribute('data-discount')) || 0;

            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-main-img').src = image;
            document.getElementById('modal-rating-val').innerText = rating;
            document.getElementById('modal-review-link').innerText = `(${reviews}+ Reviews)`;
            document.getElementById('modal-delivery-amount').innerText = delivery;
            document.getElementById('qty').value = 1; 

            const modalPriceElem = document.getElementById('modal-price');
            const modalOldPriceElem = document.getElementById('modal-old-price');
            const modalDiscountElem = document.getElementById('modal-discount-badge');

            if (discountPercent > 0) {
  
                const finalPrice = basePrice - (basePrice * (discountPercent / 100));

                modalPriceElem.innerText = `Rs. ${finalPrice.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
                modalOldPriceElem.innerText = `Rs. ${basePrice.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
                modalDiscountElem.innerText = `-${discountPercent}% OFF`;

                modalOldPriceElem.style.display = 'inline';
                modalDiscountElem.style.display = 'inline-block';
            } else {

                modalPriceElem.innerText = `Rs. ${basePrice.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
                modalOldPriceElem.style.display = 'none';
                modalDiscountElem.style.display = 'none';
            }

            const starsContainer = document.getElementById('modal-stars');
            starsContainer.innerHTML = '';
            const roundedRating = Math.round(parseFloat(rating));
            for (let i = 1; i <= 5; i++) {
                if (i <= roundedRating) {
                    starsContainer.innerHTML += '<i class="fas fa-star"></i>';
                } else {
                    starsContainer.innerHTML += '<i class="far fa-star"></i>';
                }
            }


            const colorGrid = document.getElementById('modal-color-grid');
            colorGrid.innerHTML = ''; 

            if (colorsData) {
               
                const colorsArray = colorsData.split(','); 
                for (let i = 0; i < colorsArray.length; i += 2) {
                    const colorName = colorsArray[i];
                    const colorCode = colorsArray[i+1];
                    if(colorName && colorCode) {
                        colorGrid.innerHTML += `
                            <div class="color-item" 
                                 style="background-color: ${colorCode}; width: 30px; height: 30px; border-radius: 50%; display: inline-block; margin-right: 10px; cursor: pointer; border: 2px solid #ddd;" 
                                 title="${colorName}"
                                 data-color="${colorName}"
                                 onclick="selectModalColor('${colorName}', this)">
                            </div>`;
                    }
                }
            }
            // ----------------------------------

            const sizeGrid = document.getElementById('modal-size-grid');
            sizeGrid.innerHTML = ''; // Clear it out

            if (sizesData) {
                const sizesArray = sizesData.split(','); // e.g., ["S", "M", "L"]
                sizesArray.forEach(size => {
                    // Appends each size option directly into your container
                    sizeGrid.innerHTML += `
        <button class="size-btn" style="padding: 5px 10px; margin-right: 5px; cursor: pointer;" onclick="selectSize(this)">
            ${size}
        </button>`;
                });
            }

            document.getElementById('productModal').style.display = 'flex';
        }

        function selectModalOption(element, className) {
            const parent = element.parentElement;
            parent.querySelectorAll('.' + className).forEach(el => el.classList.remove('active'));
            element.classList.add('active');
        }

        function closeProductModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        function closeProductModal() {
            document.getElementById('productModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function (event) {
            let modal = document.getElementById('productModal');
            if (event.target == modal) {
                closeProductModal();
            }
        }

        function selectModalColor(colorName, element) {
            if (document.getElementById('modal-color-title')) {
                document.getElementById('modal-color-title').innerText = `Color: ${colorName}`;
            }
            let items = document.querySelectorAll('#modal-color-grid .color-item');
            items.forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
        }

        // function selectSize(element) {
        //     let sizeItems = document.querySelectorAll('#modal-size-grid .size-item');
        //     sizeItems.forEach(item => item.classList.remove('selected'));
        //     element.classList.add('selected');
        // }
        function selectSize(element) {
            // .toggle() automatically adds the class if it's missing, or removes it if it's already there
            element.classList.toggle('selected');
        }

        // Optional Helper: Use this function when you are ready to collect all chosen sizes for your backend
        function getSelectedSizes() {
            let selectedElements = document.querySelectorAll('#modal-size-grid .size-item.selected');
            let selectedSizes = Array.from(selectedElements).map(item => item.textContent.trim());

            console.log("User selected sizes:", selectedSizes); // Returns an array, e.g., ["S", "L", "XL"]
            return selectedSizes;
        }

        function changeImage(src, element) {
            const mainImg = document.getElementById('modal-main-img') || document.getElementById('main-img');
            if (mainImg) mainImg.src = src;

            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            element.classList.add('active');
        }


        const container = document.getElementById('zoom-container');
        const img = document.getElementById('main-img');

        let isZoomed = false;

        container.addEventListener('click', (e) => {
            if (!isZoomed) {
                img.style.transformOrigin = `${e.offsetX}px ${e.offsetY}px`;
                img.style.transform = "scale(2)";
                container.style.cursor = "zoom-out";
                isZoomed = true;
            } else {
                img.style.transform = "scale(1)";
                container.style.cursor = "zoom-in";
                isZoomed = false;
            }
        });

        container.addEventListener('mouseleave', () => {
            img.style.transform = "scale(1)";
            container.style.cursor = "zoom-in";
            isZoomed = false;
        });

        function showSimilarProducts() {
            const section = document.getElementById('similar-products-section');
            section.style.display = 'block';

            section.scrollIntoView({ behavior: 'smooth' });
        }

        function scrollSlider(direction) {
            const slider = document.getElementById('categorySlider');
            const scrollAmount = 300;

            if (slider) {
                slider.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const dropBtn = document.getElementById('categoryDropBtn');
            const megaMenu = document.getElementById('categoryMegaMenu');

            if (dropBtn && megaMenu) {

                dropBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    megaMenu.classList.toggle('show-menu');
                });


                document.addEventListener('click', (e) => {
                    if (!megaMenu.contains(e.target) && e.target !== dropBtn) {
                        megaMenu.classList.remove('show-menu');
                    }
                });
            }
        });

       function saveModalProductToBackend() {
    const title = document.getElementById('modal-title')?.innerText;
    const priceText = document.getElementById('modal-price')?.innerText;
    const qty = document.getElementById('qty')?.value;
    const imgSrc = document.getElementById('modal-main-img')?.src;

    
    const selectedSizeElements = document.querySelectorAll('#modal-size-grid .selected');
    

    let sizesArray = Array.from(selectedSizeElements).map(el => el.innerText.trim());
    
    if (sizesArray.length === 0) {
        sizesArray = ['N/A']; 
    }

    const selectedColorElement = document.querySelector('#modal-color-grid .selected');
    let color = 'N/A';

    if (selectedColorElement) {

        color = selectedColorElement.getAttribute('data-color') || selectedColorElement.innerText.trim();
    } else {
        const colorGridElement = document.getElementById('modal-color-grid');
        if (colorGridElement && colorGridElement.value) {
            color = colorGridElement.value.trim();
        }
    }

    const imageUrl = imgSrc ? new URL(imgSrc).pathname : null;
    let cleanPrice = priceText ? priceText.replace(/\D/g, '') : 0;


    const itemsArray = [{
        title: title ?? 'No Title',
        price: parseInt(cleanPrice) || 0,
        qty: parseInt(qty) || 1,
        img: imageUrl,
        sizes: sizesArray,   
        color: color
    }];

    
    fetch('/cart/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        body: JSON.stringify({ items: itemsArray })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            window.location.href = '/my-cart';
        } else {
            alert("Error: " + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
    </script>