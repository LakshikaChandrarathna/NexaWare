@extends('buyer.layouts.master')

@section('content')
    <style>
        .cancel-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .cancel-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .cancel-icon {
            width: 70px;
            height: 70px;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 35px;
        }

        .cancel-title {
            color: #1f2937;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .cancel-message {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .action-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-retry {
            display: inline-block;
            background: #EB7400;
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn-retry:hover {
            background: #EB7400;
        }

        .btn-return {
            display: inline-block;
            background: transparent;
            color: #4b5563;
            padding: 10px;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .btn-return:hover {
            color: #111827;
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {
            .cancel-card {
                width: 95%;
                padding: 20px;
                margin-top: -190px;
            }

            .cancel-icon {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }

            .cancel-title {
                color: #1f2937;
                margin-bottom: 10px;
                font-size: 20px;
            }

            .btn-retry {
                display: inline-block;
                background: #EB7400;
                color: white;
                padding: 8px 25px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: 600;
                transition: background 0.3s ease;
            }

            .btn-return {
                display: inline-block;
                background: transparent;
                color: #4b5563;
                padding: 10px;
                text-decoration: none;
                font-size: 12.7px;
                transition: color 0.3s ease;
            }

        }
    </style>

    <div class="cancel-wrapper">
        <div class="cancel-card">
            <div class="cancel-icon">✕</div>

            <h2 class="cancel-title">Payment Cancelled</h2>

            <p class="cancel-message">
                It looks like you cancelled the payment process.
                No money has been deducted from your account.
            </p>

            <div class="action-group">
                <a href="http://localhost:8000/payhere" class="btn-retry">
                    Try Again
                </a>
                <a href="http://localhost:8000/shop" class="btn-return">
                    Return to Shop
                </a>
            </div>
        </div>
    </div>

@endsection