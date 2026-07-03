@extends('seller.layouts.master')

@section('content')
    <style>
        :root {
            --primary-blue: #071835;
            --light-highlight: #b5cbf0;
            --dark-navy: #071835;
            --deep-background: #010813;
            --text-main: #01060e;
            --white: #ffffff;
            --black: #000000;
            --gray-bg: #f3f4f6;
            --gray-border: #e5e7eb;
            --text-muted: #6b7280;
        }

        .welcome-section {
            margin-bottom: 30px;
            color: var(--text-main);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-border);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            margin: 10px 0;
            color: var(--text-main);
        }

        .stat-trend {
            font-size: 13px;
            font-weight: 700;
        }

        .trend-up {
            color: var(--primary-blue);
        }

        /* low stock alert banner එක සඳහා පමණක් එකතු කල CSS */
        .alert-banner {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: Arial, sans-serif;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.05);
        }

        .alert-link {
            color: #991b1b;
            font-weight: 700;
            text-decoration: underline;
            transition: color 0.2s;
        }

        .alert-link:hover {
            color: #7f1d1d;
        }

        .table-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            border: 1px solid var(--gray-border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            text-align: left;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            padding: 15px;
            background: var(--gray-bg);
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--gray-border);
            font-size: 14px;
            color: var(--text-main);
            vertical-align: top;
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
        }

        /* Dynamic Status Colors */
        .status-new { background: #e0f2fe; color: #0369a1; }
        .status-ongoing { background: #fef3c7; color: #d97706; }
        .status-completed { background: #dcfce7; color: #15803d; }
        .status-return { background: #fee2e2; color: #b91c1c; }
        .status-default { background: var(--gray-bg); color: var(--text-muted); }

        /* Mobile Responsiveness Updated for Table View */
        @media (max-width: 768px) {
            .welcome-section h1 {
                font-size: 22px;
            }

            .stats-grid {
                gap: 15px;
                margin-bottom: 25px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 24px;
            }

            .table-card {
                padding: 15px;
            }

            /* Table එක Mobile වලට ගැලපෙන ලෙස Responsive කිරීම */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid var(--gray-border);
                border-radius: 12px;
                margin-bottom: 15px;
                background: var(--white);
                padding: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            }

            td {
                border: none;
                border-bottom: 1px dashed var(--gray-border);
                position: relative;
                padding-left: 45%;
                text-align: right;
                font-size: 13px;
            }

            td:last-child {
                border-bottom: none;
            }

            /* එක් එක් තීරුවට අදාළ Label එක වම්පසින් පෙන්වීම */
            td:nth-of-type(1):before { content: "Order ID"; }
            td:nth-of-type(2):before { content: "Customer"; }
            td:nth-of-type(3):before { content: "Product"; }
            td:nth-of-type(4):before { content: "Amount"; }
            td:nth-of-type(5):before { content: "Status"; }

            td:before {
                position: absolute;
                top: 15px;
                left: 15px;
                width: 40%;
                text-align: left;
                font-weight: 700;
                color: var(--text-muted);
                font-size: 12px;
                text-transform: uppercase;
            }
            
            td div {
                text-align: right;
            }
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 15px;
        }

        .breadcrumb span {
            margin-right: 5px;
        }

        .breadcrumb .arrow {
            color: var(--gray-border);
        }

        .breadcrumb .active {
            color: var(--black);
            font-weight: bold;
        }
        .lowstockalert{
            display: flex;
            align-items: center;
            gap : 8px;
        }
        .tableheading{
            margin-top:0px;
            color: var(--primary-blue);
        }
        
    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">›</span>
        <span class="active">Dashboard</span>
    </div>
    <div class="welcome-section">
        <p style="color: #718096;">Here's what's happening with your store today.</p>
    </div>

    <!-- Low Stock Alert Banner -->
    @if(isset($counts['low_stock']) && $counts['low_stock'] > 0)
        <div class="alert-banner">
            <div class="lowstockalert" >
                <span>⚠️</span>
                <span><b>Inventory Warning:</b> You have <b>{{ $counts['low_stock'] }}</b> product(s) running critically low on stock.</span>
            </div>
            <a href="/sellerstock" class="alert-link">
                Restock Items →
            </a>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">LKR {{ number_format(floatval(str_replace(',', '', $counts['revenue'])), 2) }}</div>
            <div class="stat-trend trend-up">↑ Dynamic total amount</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Orders</div>
            <div class="stat-value">{{ $counts['active'] }}</div>
            <div class="stat-trend trend-up">↑ {{ $counts['new'] }} new today</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Completed Orders</div>
            <div class="stat-value">{{ $counts['completed'] }}</div>
            <div class="stat-trend" style="color: #718096;">Successfully delivered</div>
        </div>
    </div>

    <div class="table-card">
        <h3 class="tableheading" >Recent Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                @forelse($recentOrders as $orderId => $items)
                    @php 
                        $firstItem = $items->first(); 
                        $totalAmount = $items->sum('price'); 

                        $status = strtolower($firstItem->current_status);
                        if ($status === 'new') {
                            $statusClass = 'status-new';
                        } elseif (in_array($status, ['processing', 'shipped', 'in_transit'])) {
                            $statusClass = 'status-ongoing';
                        } elseif ($status === 'delivered') {
                            $statusClass = 'status-completed';
                        } elseif (in_array($status, ['return_requested', 'pending_return', 'refunded'])) {
                            $statusClass = 'status-return';
                        } else {
                            $statusClass = 'status-default';
                        }
                    @endphp
                    <tr>
                        <td><b>#{{ $orderId }}</b></td>
                        <td><b>{{ $firstItem->fullname }}</b></td>
                        <td>
                            @foreach($items as $item)
                                <div style="margin-bottom: 4px;">
                                    {{ $item->item_name ?? 'Product ID: '.$item->id }} 
                                    <small style="color: var(--text-muted); font-weight: bold;">(x{{ $item->quantity ?? 1 }})</small>
                                </div>
                            @endforeach
                        </td>
                        <td>Rs. {{ number_format($items->sum('total_price'), 2) }}</td>
                        <td>
                            <span class="status {{ $statusClass }}">{{ $firstItem->current_status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">
                            No recent orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection