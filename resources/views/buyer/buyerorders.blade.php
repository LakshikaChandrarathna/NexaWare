@extends('buyer.layouts.master')
<link rel="stylesheet" href="src/css/buyerorders.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=eye_tracking" />
@section('content')
    <style>
       /* ===== ORDER DETAILS MODAL ===== */

         .material-symbols-outlined {
        font-size: 24px;
        color: #000000;
       
        transition: color 0.3s ease;
    }


        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 60%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .modal-header {
            background-color:white;
            /* display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ffffff;
            /* padding-bottom: 10px; */
            /* margin-bottom: 15px; */ */
        }
        .close-modal {
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
        }
        .modal-body h5 {
            /* margin-top: 15px; */
            margin-bottom: 5px;
            color: #4f9eee;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        .modal-body p {
            margin: 6px 0;
            font-size: 14px;
        }
    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">›</span>
        <span class="active">Orders</span>
    </div>

    <div class="orders-container">
        {{-- TABS NAVIGATION --}}
        <div class="order-tabs">
            <div class="tab-item active" onclick="openTab(event, 'all')">All Orders</div>
            <div class="tab-item" onclick="openTab(event, 'processing')">Processing</div>
            <div class="tab-item" onclick="openTab(event, 'shipped')">Shipped</div>
            <div class="tab-item" onclick="openTab(event, 'delivered')">Delivered</div>
            <div class="tab-item" onclick="openTab(event, 'cancelled')">Cancelled</div>
        </div>

        {{-- ALL ORDERS TAB --}}
        <div id="all" class="tab-content active">
            @forelse($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            @if($order->status == 'delivered')
                                <span>DELIVERED ON:
                                    <strong>{{ \Carbon\Carbon::parse($order->updated_at)->format('F d, Y') }}</strong></span>
                            @elseif($order->status == 'cancelled')
                                <span>CANCELLED ON:
                                    <strong>{{ \Carbon\Carbon::parse($order->updated_at)->format('F d, Y') }}</strong></span>
                            @else
                                <span>ORDER PLACED:
                                    <strong>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</strong></span>
                            @endif
                            <span>TOTAL: <strong>Rs.
                                    {{ number_format($order->total_price ?? $order->total, 2) }}</strong></span>
                            <span>ORDER #<strong>{{ $order->order_id ?? $order->id }}</strong></span>
                        </div>
                        <div class="order-status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</div>
                    </div>

                    <div class="order-body">
                        <img src="{{ $order->image_url ?? '' }}" class="item-img" alt="Product Image">
                        <div class="item-details">
                            <div class="item-title">{{ $order->product_name ?? $order->title ?? 'Product Name' }}</div>
                            <div class="item-meta">Qty: {{ $order->quantity ?? 1 }} | Seller:
                                {{ $order->seller_name ?? 'Local Partner' }}</div>
                        </div>
                        <div class="btn-group">
                            <button class="review-btn"
                                onclick="openReviewModal('{{ $order->order_id ?? $order->id }}', '{{ addslashes($order->product_name ?? $order->title ?? 'Product Name') }}')">
                                Write a Review
                            </button>
                            @if($order->status == 'delivered')
                                <button class="track-btn">Buy Again</button>
                            @elseif($order->status == 'cancelled')
                                <button class="track-btn" style="border-color: var(--gray-border); color: var(--text-muted);"
                                    disabled>Closed</button>
                            @else
                                <button class="track-btn"
                                    data-order-id="{{ $order->order_id ?? $order->id }}"
                                    data-created-at="{{ isset($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i A') : 'N/A' }}"
                                    data-current-status="{{ $order->current_status ?? $order->status }}"
                                    data-name="{{ trim(($order->human->firstname ?? '') . ' ' . ($order->human->surname ?? '')) }}"
                                    data-phone="{{ $order->human->contacts->firstWhere('is_primary', 1)->contact_no ?? ($order->human->contacts->first()->contact_no ?? 'N/A') }}"
                                    data-email="{{ $order->human->emails->firstWhere('is_primary', 1)->email ?? ($order->human->emails->first()->email ?? 'N/A') }}"
                                    data-city="{{ $order->human->district->d_name ?? $order->human->district->name_en ?? $order->human->district->name ?? $order->human->discrict ?? 'N/A' }}"
                                    data-country="{{ $order->human->country ?? 'N/A' }}"
                                    data-status="{{ $order->status }}"
                                    data-total="{{ number_format($order->total_price ?? $order->total ?? 0, 2) }}"
                                    onclick="handleOrderModalClick(this)">
                                    Order Details
                                </button>
                            @endif
                        </div>
                    </div>

                    @if(in_array($order->status, ['processing', 'shipped']))
                        <div class="tracking-wrapper">
                            <div class="tracking-steps">
                                <div class="step completed">
                                    <div class="step-icon"><i class="fa fa-check"></i></div>
                                    <div class="step-label">Confirmed</div>
                                </div>
                                <div class="step {{ $order->status == 'processing' ? 'active' : 'completed' }}">
                                    <div class="step-icon"><i class="fa fa-box"></i></div>
                                    <div class="step-label">Processing</div>
                                </div>
                                <div class="step {{ $order->status == 'shipped' ? 'active' : '' }}">
                                    <div class="step-icon"><i class="fa fa-truck"></i></div>
                                    <div class="step-label">Shipped</div>
                                </div>
                                <div class="step">
                                    <div class="step-icon"><i class="fa fa-home"></i></div>
                                    <div class="step-label">Delivered</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 20px;">You haven't placed any orders yet.</p>
            @endforelse
        </div>

        {{-- PROCESSING TAB --}}
        <div id="processing" class="tab-content" style="display: none;">
            @forelse($orders->where('current_status', 'Processing') as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <span>ORDER PLACED:
                                <strong>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</strong></span>
                            <span>TOTAL: <strong>Rs.
                                    {{ number_format($order->total_price ?? $order->total, 2) }}</strong></span>
                            <span>ORDER #<strong>{{ $order->order_id ?? $order->id }}</strong></span>
                        </div>
                        <div class="order-status-badge status-processing">Processing</div>
                    </div>
                    <div class="order-body">
                        <img src="{{ $order->image_url ?? '' }}" class="item-img">
                        <div class="item-details">
                            <div class="item-title">{{ $order->product_name ?? $order->title ?? 'Product Name' }}</div>
                            <div class="item-meta">Qty: {{ $order->quantity ?? 1 }} | Seller:
                                {{ $order->seller_name ?? 'Local Partner' }}</div>
                        </div>
                        <div class="btn-group">
                            <button class="review-btn"
                                onclick="openReviewModal('{{ $order->order_id ?? $order->id }}', '{{ addslashes($order->product_name ?? $order->title ?? 'Product Name') }}')">
                                Write a Review
                            </button>
                            <button class="track-btn"
                                data-order-id="{{ $order->order_id ?? $order->id }}"
                                data-created-at="{{ isset($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i A') : 'N/A' }}"
                                data-current-status="{{ $order->current_status ?? $order->status }}"
                                data-name="{{ trim(($order->human->firstname ?? '') . ' ' . ($order->human->surname ?? '')) }}"
                                data-phone="{{ $order->human->contacts->firstWhere('is_primary', 1)->contact_no ?? ($order->human->contacts->first()->contact_no ?? 'N/A') }}"
                                data-email="{{ $order->human->emails->firstWhere('is_primary', 1)->email ?? ($order->human->emails->first()->email ?? 'N/A') }}"
                                data-city="{{ $order->human->district->d_name ?? $order->human->district->name_en ?? $order->human->district->name ?? $order->human->discrict ?? 'N/A' }}"
                                data-country="{{ $order->human->country ?? 'N/A' }}"
                                data-status="{{ $order->status }}"
                                data-total="{{ number_format($order->total_price ?? $order->total ?? 0, 2) }}"
                                onclick="handleOrderModalClick(this)">
                                Order Details
                            </button>
                        </div>
                    </div>
                    <div class="tracking-wrapper">
                        <div class="tracking-steps">
                            <div class="step completed">
                                <div class="step-icon"><i class="fa fa-check"></i></div>
                                <div class="step-label">Confirmed</div>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-box"></i></div>
                                <div class="step-label">Processing</div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-truck"></i></div>
                                <div class="step-label">Shipped</div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-home"></i></div>
                                <div class="step-label">Delivered</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 20px;">No processing orders found.</p>
            @endforelse
        </div>

        {{-- SHIPPED TAB --}}
        <div id="shipped" class="tab-content" style="display: none;">
            @forelse($orders->where('current_status', 'shipped') as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <span>ORDER PLACED:
                                <strong>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</strong></span>
                            <span>TOTAL: <strong>Rs.
                                    {{ number_format($order->total_price ?? $order->total, 2) }}</strong></span>
                            <span>ORDER #<strong>{{ $order->order_id ?? $order->id }}</strong></span>
                        </div>
                        <div class="order-status-badge status-shipped">Shipped</div>
                    </div>
                    <div class="order-body">
                        <img src="{{ $order->image_url ?? '' }}" class="item-img">
                        <div class="item-details">
                            <div class="item-title">{{ $order->product_name ?? $order->title ?? 'Product Name' }}</div>
                            <div class="item-meta">Qty: {{ $order->quantity ?? 1 }} | Seller:
                                {{ $order->seller_name ?? 'Local Partner' }}</div>
                        </div>
                        <div class="btn-group">
                            <button class="review-btn"
                                onclick="openReviewModal('{{ $order->order_id ?? $order->id }}', '{{ addslashes($order->product_name ?? $order->title ?? 'Product Name') }}')">
                                Write a Review
                            </button>
                            <button class="track-btn"
                                data-order-id="{{ $order->order_id ?? $order->id }}"
                                data-created-at="{{ isset($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i A') : 'N/A' }}"
                                data-current-status="{{ $order->current_status ?? $order->status }}"
                                data-name="{{ trim(($order->human->firstname ?? '') . ' ' . ($order->human->surname ?? '')) }}"
                                data-phone="{{ $order->human->contacts->firstWhere('is_primary', 1)->contact_no ?? ($order->human->contacts->first()->contact_no ?? 'N/A') }}"
                                data-email="{{ $order->human->emails->firstWhere('is_primary', 1)->email ?? ($order->human->emails->first()->email ?? 'N/A') }}"
                                data-city="{{ $order->human->district->d_name ?? $order->human->district->name_en ?? $order->human->district->name ?? $order->human->discrict ?? 'N/A' }}"
                                data-country="{{ $order->human->country ?? 'N/A' }}"
                                data-status="{{ $order->status }}"
                                data-total="{{ number_format($order->total_price ?? $order->total ?? 0, 2) }}"
                                onclick="handleOrderModalClick(this)">
                                Order Details
                            </button>
                        </div>
                    </div>
                    <div class="tracking-wrapper">
                        <div class="tracking-steps">
                            <div class="step completed">
                                <div class="step-icon"><i class="fa fa-check"></i></div>
                                <div class="step-label">Confirmed</div>
                            </div>
                            <div class="step completed">
                                <div class="step-icon"><i class="fa fa-box"></i></div>
                                <div class="step-label">Processing</div>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-truck"></i></div>
                                <div class="step-label">Shipped</div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-home"></i></div>
                                <div class="step-label">Delivered</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 20px;">No shipped orders found.</p>
            @endforelse
        </div>

        {{-- DELIVERED TAB --}}
        <div id="delivered" class="tab-content" style="display: none;">
            @forelse($orders->where('current_status', 'delivered') as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <span>DELIVERED ON:
                                <strong>{{ \Carbon\Carbon::parse($order->updated_at)->format('F d, Y') }}</strong></span>
                            <span>TOTAL: <strong>Rs.
                                    {{ number_format($order->total_price ?? $order->total, 2) }}</strong></span>
                            <span>ORDER #<strong>{{ $order->order_id ?? $order->id }}</strong></span>
                        </div>
                        <div class="order-status-badge status-delivered">Delivered</div>
                    </div>
                    <div class="order-body">
                        <img src="{{ $order->image_url ?? '' }}" class="item-img">
                        <div class="item-details">
                            <div class="item-title">{{ $order->product_name ?? $order->title ?? 'Product Name' }}</div>
                            <div class="item-meta">Qty: {{ $order->quantity ?? 1 }} | Seller:
                                {{ $order->seller_name ?? 'Local Partner' }}</div>
                        </div>
                        <div class="btn-group">
                            <button class="review-btn"
                                onclick="openReviewModal('{{ $order->order_id ?? $order->id }}', '{{ addslashes($order->product_name ?? $order->title ?? 'Product Name') }}')">
                                Write a Review
                            </button>
                            <button class="track-btn">Buy Again</button>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 20px;">No delivered orders found.</p>
            @endforelse
        </div>

        {{-- CANCELLED TAB --}}
        <div id="cancelled" class="tab-content" style="display: none;">
            @forelse($orders->where('current_status', 'cancelled') as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <span>CANCELLED ON:
                                <strong>{{ \Carbon\Carbon::parse($order->updated_at)->format('F d, Y') }}</strong></span>
                            <span>TOTAL: <strong>Rs.
                                    {{ number_format($order->total_price ?? $order->total, 2) }}</strong></span>
                            <span>ORDER #<strong>{{ $order->order_id ?? $order->id }}</strong></span>
                        </div>
                        <div class="order-status-badge status-cancelled">Cancelled</div>
                    </div>
                    <div class="order-body">
                        <img src="{{ $order->image_url ?? '' }}" class="item-img">
                        <div class="item-details">
                            <div class="item-title">{{ $order->product_name ?? $order->title ?? 'Product Name' }}</div>
                            <div class="item-meta">Qty: {{ $order->quantity ?? 1 }} | Seller:
                                {{ $order->seller_name ?? 'Local Partner' }}</div>
                        </div>
                        <div class="btn-group">
                            <button class="review-btn"
                                onclick="openReviewModal('{{ $order->order_id ?? $order->id }}', '{{ addslashes($order->product_name ?? $order->title ?? 'Product Name') }}')">
                                Write a Review
                            </button>
                            <button class="track-btn" style="border-color: var(--gray-border); color: var(--text-muted);"
                                disabled>Closed</button>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 20px;">No cancelled orders found.</p>
            @endforelse
        </div>
    </div>

    {{-- REVIEW MODAL --}}
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeReviewModal()">&times;</span>
            <h3 style="margin-top:0">Write a Review</h3>
            <h4 id="modalProductName" style="margin-bottom: 5px; color: #333;"></h4>
            <p id="modalOrderId" style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;"></p>

            <form action="/store-review" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="formOrderId">
                <input type="hidden" name="item_title" id="formItemTitle">
                <div class="form-group">
                    <label>Rating</label>
                    <select name="rating">
                        <option value="5">★★★★★ (5/5)</option>
                        <option value="4">★★★★☆ (4/5)</option>
                        <option value="3">★★★☆☆ (3/5)</option>
                        <option value="2">★★☆☆☆ (2/5)</option>
                        <option value="1">★☆☆☆☆ (1/5)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Your Feedback</label>
                    <textarea name="comment" rows="4" placeholder="Tell us what you think about the product..."></textarea>
                </div>
                <button type="submit" class="submit-review">Submit Review</button>
            </form>
        </div>
    </div>

    {{-- ORDER DETAILS VIEW MODAL --}}
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                
                <div id="eye_trac" >
                     <span class="material-symbols-outlined">
                      eye_tracking
                     </span>
                </div>                         
                    <h3 style="margin-right:321px;">Order Details</h3>

                    <span class="close-modal" onclick="closeOrderModal()">&times;</span>
 
            </div>
            <div class="modal-body" style="margin-left:19px;">
                <h5>Order Information</h5>
                <p><strong>Order Number:</strong> <span id="display_order_id" style="color: blue; font-weight: bold;"></span></p>
                <p><strong>Placed Date & Time:</strong> <span id="display_created_at"></span></p>
                <p><strong>Order Status:</strong> <span id="display_current_status"></span></p>
                
                <h5>Shipping Details</h5>
                <p><strong>Name:</strong> <span id="display_shipping_name"></span></p>
                <p><strong>Phone:</strong> <span id="display_shipping_phone"></span></p>
                <p><strong>Email:</strong> <span id="display_email"></span></p>
                <p><strong>City:</strong> <span id="display_shipping_city"></span></p>
                
                <h5>Delivery Details</h5>
                <p><strong>Courier (Country):</strong> <span id="display_courier_name"></span></p>
                
                <h5>Payment Summary</h5>
                <p><strong>Payment Status:</strong> <span id="display_payment_status"></span></p>
                <p><strong>Subtotal:</strong> Rs. <span id="display_subtotal"></span></p>
                <h4 style="margin-top: 10px; color: #111;">Total Amount: Rs. <span id="display_total"></span></h4>
            </div>
        </div>
    </div>


    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-item");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }

        function openReviewModal(orderId, productName) {
            document.getElementById('modalOrderId').innerText = "Order: " + orderId;
            document.getElementById('formOrderId').value = orderId;
            document.getElementById('formItemTitle').value = productName;
            document.getElementById('modalProductName').innerText = productName;
            document.getElementById('reviewModal').style.display = "block";
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = "none";
        }

        /* ===== ORDER DETAILS MODAL FUNCTIONS ===== */
        function handleOrderModalClick(button) {
            document.getElementById('display_order_id').innerText = button.getAttribute('data-order-id');
            document.getElementById('display_created_at').innerText = button.getAttribute('data-created-at');
            document.getElementById('display_current_status').innerText = button.getAttribute('data-current-status');
            document.getElementById('display_shipping_name').innerText = button.getAttribute('data-name') || 'N/A';
            document.getElementById('display_shipping_phone').innerText = button.getAttribute('data-phone');
            document.getElementById('display_email').innerText = button.getAttribute('data-email');
            document.getElementById('display_shipping_city').innerText = button.getAttribute('data-city');
            document.getElementById('display_courier_name').innerText = button.getAttribute('data-country');
            document.getElementById('display_payment_status').innerText = button.getAttribute('data-status');
            document.getElementById('display_subtotal').innerText = button.getAttribute('data-total');
            document.getElementById('display_total').innerText = button.getAttribute('data-total');
            
            document.getElementById('orderModal').style.display = 'block';
        }

        function closeOrderModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById('reviewModal')) {
                closeReviewModal();
            }
            if (event.target == document.getElementById('orderModal')) {
                closeOrderModal();
            }
        }
    </script>
@endsection