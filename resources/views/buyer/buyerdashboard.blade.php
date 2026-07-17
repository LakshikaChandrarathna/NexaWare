@extends('buyer.layouts.master')

@section('content')

    <link rel="stylesheet" href="{{ asset('src/css/buyer.css') }}">
    <style>
        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }

        .breadcrumb span {
            margin-right: 5px;
        }

        .breadcrumb .arrow {
            color: #aaa;
        }

        .breadcrumb .active {
            color: #000;
            font-weight: bold;
        }
        
        /* Dynamic badge colors based on order statuses */
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-processing { background-color: #fef3c7; color: #d97706; }
        .badge-shipped { background-color: #e0f2fe; color: #0284c7; }
        .badge-delivered { background-color: #dcfce7; color: #15803d; }
        .badge-pending { background-color: #f3f4f6; color: #4b5563; }

        @media screen and (max-width: 768px) {
            /* Table Responsive Card Style */
            thead {
                display: none;
            }

            tbody tr {
                display: block;
                background: #fff;
                margin-bottom: 15px;
                padding: 6px;
                border-radius: 12px;
                border: 1px solid #edf2f7;
            }

            tbody td {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #f0f0f0;
            }

            tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #718096;
            }
        }
       
    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">&gt;</span>
        <span class="active">Dashboard</span>
    </div>

    <div class="dashboard-wrapper">

        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Active Orders</span>
                <div class="stat-value">{{ sprintf('%02d', $activeOrdersCount) }}</div>
            </div>
            <div class="stat-card">
                <span class="stat-label">Cost Per Orders</span>
                <div class="stat-value">LKR {{ number_format($totalCost, 2) }}</div>
            </div>
            <div class="stat-card">
                <span class="stat-label">Points Earned</span>
                <div class="stat-value">{{ $pointsEarned }}</div>
            </div>
        </div>

        <div class="orders-section">
            <div class="section-header">
                <h3>Recent Orders</h3>
                <a href="#" class="view-all-btn">View All Orders</a>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $item)
                            <tr>
                                <td data-label="Order ID" class="order-id">#{{ $item->order_id ?? 'N/A' }}</td>
                                <td data-label="Product">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        @if($item->image_url)
                                            <img src="{{ asset($item->image_url) }}" alt="{{ $item->title }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                                        @endif
                                        <span>{{ $item->title }}</span>
                                    </div>
                                </td>
                                <td data-label="Quantity">{{ $item->quantity }}</td>
                                <td data-label="Price">Rs. {{ number_format($item->unit_price, 2) }}</td>
                                <td data-label="Date">{{ $item->created_at->format('F d, Y') }}</td>
                                <td data-label="Total">Rs. {{ number_format($item->total_price, 2) }}</td>
                                <td data-label="Status">
                                   
                                    <span class="badge badge-{{ strtolower($item->current_status ?? 'pending') }}">
                                        {{ ucfirst($item->current_status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px; color: #777;">
                                    No recent orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection