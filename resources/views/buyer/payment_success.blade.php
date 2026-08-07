@extends('buyer.layouts.master')
<style>
    .backtohome-btn {
        display: inline-block;
        background: #071835;
        color: white;
        padding: 12px 25px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.2s;
        
    }

    .orderid-label {
        display: block;
        color: #9ca3af;
        font-size: 12px;
        text-transform: uppercase;
    }

    .orderid {
        color: #111827;
        font-size: 16px;
    }
</style>
@section('content')
    <div
        style="display: flex; justify-content: center; align-items: center; min-height: 70vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div
            style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; max-width: 400px; width: 90%;">
            <div
                style="width: 70px; height: 70px; background: #dcfce7; color: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 35px;">
                ✓
            </div>
            <h2 style="color: #1f2937; margin-bottom: 10px;">Payment Successful!</h2>
            <p style="color: #6b7280; font-size: 14px; line-height: 1.5;">Thank you for your payment. Your order has been
                placed successfully.</p>

            <div style="background: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0; border: 1px solid #f3f4f6;">
                <span class="orderid-label">Order ID</span>
                <strong class="orderid">{{ $order_id }}</strong>
            </div>

            <a href="http://localhost:8000" class="backtohome-btn">
                Back to Home
            </a>
        </div>
    </div>
@endsection