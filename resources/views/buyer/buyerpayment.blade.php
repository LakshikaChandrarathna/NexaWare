@extends('buyer.layouts.master')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Payment Dashboard</title>
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

            /* mapping old variables to your new theme variables */
            --primary-color: var(--primary-blue);
            --bg-color: var(--gray-bg);
            --card-bg: var(--white);
            --border-color: var(--gray-border);
            --shadow: 0 10px 25px rgba(7, 24, 53, 0.05);
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 40px 20px;
            color: var(--text-main);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
        }

        /* Titles */
        .page-title {
            margin-top: 0;
            margin-bottom: 25px;
        }

        /* Common Card Style */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .main-card {
            margin-top: 0px;
            margin-right: -266px;
            margin-left: 0px;
        }

        .icon-box {
            font-size: 45px;
            margin-bottom: 10px;
            text-align: center;
        }

        .add-text {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
        }

        .description {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 25px;
            text-align: center;
        }

        /* Form Styles */
        .payment-form {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            background-color: var(--white);
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
            color: var(--text-main);
        }

        input:focus {
            border-color: var(--primary-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3px rgba(7, 24, 53, 0.1);
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 19px;
            width: 200px;
        }


        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            background-color: var(--dark-navy);
        }

        /* Profile Sidebar Styles */
        .profile-sidebar-wrapper {
            margin-top: 55px;
        }

        .profile-card {
            text-align: center;
            width: 80%;
            margin-top: -81px;
        }

        .profile-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid var(--white);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .seller-name {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
        }

        .seller-role {
            font-size: 14px;
            color: var(--primary-color);
            font-weight: 600;
            margin-top: 5px;
        }

        .divider {
            border: 0;
            border-top: 1px solid var(--border-color);
            margin: 20px 0;
        }

        .info-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-main);
            font-weight: 500;
        }

        .btn-edit {
            width: 200px;
            padding: 12px;
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
            }

            .profile-sidebar-wrapper {
                order: -1;
                margin-top: 0;
            }
        }

        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .main-card {
                margin-right: 0;
                margin-left: -2;
                margin-top: 0;
                padding: 20px;
            }

            .profile-sidebar-wrapper {
                order: -1;
                margin-top: 0;
            }

            .profile-card {
                width: 100%;
                margin-top: 0;
            }
        }

        @media (max-width: 480px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .add-text {
                font-size: 18px;
            }

            .card {
                padding: 20px 15px;
                width: 271px;
                margin-left: -37px;
            }
        }

        @media (max-width: 767px) {
            .breadcrumb {
                font-size: 14px !important;
                margin-top: -20px !important;
                margin-bottom: 10px !important;
                margin-left: -34px;
            }
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 15px;
            margin-top: -41px;
        }

        .breadcrumb span {
            margin-right: 5px;
        }

        .breadcrumb .arrow {
            color: var(--light-highlight);
        }

        .breadcrumb .active {
            color: var(--black);
            font-weight: bold;
        }
    </style>
    
    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow"></span>
        <span class="active">Payment</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-right: -266px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="disabled" data-bs-with-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none';"></button>
        </div>
    @endif

    <div class="container">

        <div class="main-content">

            <div class="card main-card">
                <div class="icon-box">💳</div>
                <div class="add-text">Payment Details</div>
                <p class="description">Configure your bank account information to receive earnings from your sales.</p>

                <form class="payment-form" action="/save-payment-info" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Bank Name</label>
                        <select name="bank_name">
                            <option value="">Select your bank</option>
                            <option value="Bank of Ceylon" {{ (old('bank_name', $paymentInfo->bank_name ?? '') == 'Bank of Ceylon') ? 'selected' : '' }}>Bank of Ceylon</option>
                            <option value="Commercial Bank" {{ (old('bank_name', $paymentInfo->bank_name ?? '') == 'Commercial Bank') ? 'selected' : '' }}>Commercial Bank</option>
                            <option value="Sampath Bank" {{ (old('bank_name', $paymentInfo->bank_name ?? '') == 'Sampath Bank') ? 'selected' : '' }}>Sampath Bank</option>
                            <option value="Hatton National Bank (HNB)" {{ (old('bank_name', $paymentInfo->bank_name ?? '') == 'Hatton National Bank (HNB)') ? 'selected' : '' }}>Hatton National Bank (HNB)</option>
                            <option value="Peoples Bank" {{ (old('bank_name', $paymentInfo->bank_name ?? '') == 'Peoples Bank') ? 'selected' : '' }}>Peoples Bank</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Account Holder Name</label>
                        <input type="text" placeholder="Name as it appears on your passbook" name="account_holder_name" value="{{ old('account_holder_name', $paymentInfo->account_holder_name ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" placeholder="Enter your bank account number" name="card_number" value="{{ old('card_number', $paymentInfo->card_number ?? '') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Expire Date</label>
                            <input type="date" name="expire_date" value="{{ old('expire_date', $paymentInfo->expire_date ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" placeholder="***" name="cvv" value="{{ old('cvv', $paymentInfo->cvv ?? '') }}">
                        </div>
                    </div>

                    <div style="display: flex; margin-left: 568px; gap: 10px;">
                        <button type="submit" class="btn-submit">Save </button>
                        <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#paymentModal">Edit </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                        Update Payment Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="/save-payment-info" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="bank_name" class="form-label text-dark">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', $paymentInfo->bank_name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="account_holder_name" class="form-label text-dark">Account Holder Name</label>
                            <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name', $paymentInfo->account_holder_name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="card_number" class="form-label text-dark">Card Number</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" placeholder="xxxx xxxx xxxx xxxx" value="{{ old('card_number', $paymentInfo->card_number ?? '') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expire_date" class="form-label text-dark">Expiry Date</label>
                                <input type="text" class="form-control" id="expire_date" name="expire_date" placeholder="YYYY-MM-DD" value="{{ old('expire_date', $paymentInfo->expire_date ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label text-dark">CVV</label>
                                <input type="password" class="form-control" id="cvv" name="cvv" placeholder="***" maxlength="4" value="{{ old('cvv', $paymentInfo->cvv ?? '') }}" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const editButton = document.querySelector('.btn-edit');
        const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));

        editButton.addEventListener('click', function () {
            paymentModal.show();
        });
    });
    </script>
@endsection