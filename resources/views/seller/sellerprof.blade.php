@extends('seller.layouts.master')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="csrf-meta" name="csrf-token" content="{{ csrf_token() }}">
    <title>Seller Profile Dashboard</title>
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

            --bg-color: var(--gray-bg);
            --card-bg: var(--white);
            --text-sub: var(--text-muted);
            --border-color: var(--gray-border);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', Roboto, sans-serif;
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
            margin-top: -70px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .main-profile-view {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary-blue), #1e3a8a);
            color: var(--white);
            padding: 30px;
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .welcome-card h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .welcome-card p {
            margin: 10px 0 0 0;
            opacity: 0.8;
            font-size: 14px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-block {
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .info-block-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-card {
            text-align: center;
            width: 100%;
            max-width: 350px;
            height: auto;
            margin-top: 25px;
            background: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            box-sizing: border-box;
        }

        .profile-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 4px solid var(--white);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .seller-name {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
            color: var(--text-main);
        }

        .seller-role {
            font-size: 14px;
            color: var(--primary-blue);
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
            margin-bottom: 12px;
        }

        .info-label {
            font-size: 11px;
            color: var(--text-sub);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-main);
            font-weight: 500;
            word-break: break-all;
        }

        .btn-edit {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 7px;
        }

        .btn-edit:hover {
            background: var(--primary-blue);
            color: var(--white);
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: var(--text-sub);
            margin-bottom: 65px;
            margin-top: -42px;
            margin-left: -14px;
            padding-bottom: 12px;
        }

        /* --- ඔයා එවපු IMAGE එකට අනුව විතරක් සකස් කරපු MODAL STYLE --- */
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: var(--white);
            border-radius: 16px;
            width: 90%;
            max-width: 680px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            box-sizing: border-box;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #f1f3f5;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--black);
        }

        .close-btn {
            font-size: 24px;
            cursor: pointer;
            color: #adb5bd;
            transition: 0.2s;
        }

        .close-btn:hover {
            color: #495057;
        }

        #editProfileForm {
            padding: 30px;
        }

        /* පින්තූරයේ පරිදි 2-Column Grid එක */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Mobile number එක විතරක් සම්පූර්ණ පළලින් (Full Width) තියාගන්න */
        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 500;
            color: #8a8a8a;
        }

        .form-group input {
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: var(--black);
            background-color: #fdfdfd;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #cbd5e1;
            background-color: var(--white);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            border-top: 1px solid #f1f3f5;
            padding-top: 20px;
        }

        .btn-cancel {
            padding: 12px 28px;
            background: #f1f3f5;
            color: var(--black);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        .btn-save {
            padding: 12px 28px;
            background: #071835;
            /* Dark blue from image */
            color: var(--white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-save:hover {
            background: #01060e;
        }

        @media (max-width: 992px) {
            body {
                padding: 20px 10px;
            }

            .container {
                grid-template-columns: 1fr;
                margin-top: 0;
                gap: 20px;
            }

            .breadcrumb {
                margin-top: 0;
                margin-left: 0;
                margin-bottom: 20px;
            }

            .main-profile-view {
                margin-top: 0;
                order: 2;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .profile-sidebar {
                order: 1;
                display: flex;
                justify-content: center;
                width: 100%;
            }

            .profile-card {
                width: 100%;
                max-width: 100%;
                margin-top: 0;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }
        }
    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">›</span>
        <span class="active">Profile</span>
    </div>

    <div class="container">
        <div class="main-profile-view">
            <div class="welcome-card">
                <h1>Welcome Back {{ $seller->firstname ?? 'Seller' }}!</h1>
                <p>Manage and view your personal seller account details from this dashboard.</p>
            </div>

            <div class="details-grid">
                <div class="info-block">
                    <div class="info-block-title">Identification Info</div>
                    <div class="info-group">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">
                            {{ $seller->title ?? '' }} {{ $seller->firstname ?? '' }} {{ $seller->surname ?? '' }}
                        </div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Other Name</div>
                        <div class="info-value">{{ $seller->othername ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">NIC / Passport</div>
                        <div class="info-value">{{ $seller->NIC ?? $seller->passport ?? '-' }}</div>
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-title">Account Status</div>
                    <div class="info-group">
                        <div class="info-label">Registered Email</div>
                        <div class="info-value">{{ $seller->registered_email ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Account Status</div>
                        <div class="info-value" style="color: green; font-weight: 700;">● Active Verified</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-sidebar">
            <div class="profile-card">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($seller->firstname ?? 'User') }}+{{ urlencode($seller->surname ?? '') }}&background=071835&color=fff&size=128"
                    alt="Seller Avatar" class="profile-img">

                <h2 class="seller-name">{{ $seller->firstname ?? 'Name' }} {{ $seller->surname ?? '' }}</h2>
                <p class="seller-role">Verified Premium Seller</p>

                <hr class="divider">

                <div class="contact-info-list">
                    <div class="info-group">
                        <div class="info-label">Title</div>
                        <div class="info-value">{{ $seller->title ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">First Name</div>
                        <div class="info-value">{{ $seller->firstname ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Last Name</div>
                        <div class="info-value">{{ $seller->surname ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $seller->registered_email ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Mobile Number</div>
                        <div class="info-value">{{ $seller->mobile_number ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Location</div>
                        <div class="info-value">
                            {{ implode(', ', array_filter([
        $seller->gn_division_name_en ?? '',
        $seller->district_name ?? '',
        $seller->province_name ?? ''
    ])) ?: 'Sri Lanka' }}
                        </div>
                    </div>
                </div>

                <button class="btn-edit" id="edit-profile-btn">Edit Profile</button>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="custom-modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Profile Details</h3>
                <span class="close-btn" id="closeModalBtn">&times;</span>
            </div>
            <form id="editProfileForm" action="/update-profile" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" id="input-title" value="{{ $seller->title ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstname" id="input-fname" value="{{ $seller->firstname ?? '' }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="surname" id="input-lname" value="{{ $seller->surname ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="input-email" value="{{ $seller->registered_email ?? '' }}"
                            required>
                    </div>
                    <div class="form-group full-width">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile_number" id="input-mobile" value="{{ $seller->mobile_number ?? '' }}"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancelModalBtn">Cancel</button>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('editProfileModal');
            const editBtn = document.getElementById('edit-profile-btn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');

            if (editBtn) {
                editBtn.addEventListener('click', function () {
                    modal.style.display = 'flex';
                });
            }

            function closeModal() {
                if (modal) {
                    modal.style.display = 'none';
                }
            }

            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

            window.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
@endsection