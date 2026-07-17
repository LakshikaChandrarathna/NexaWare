@extends('buyer.layouts.master')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            /* Mapping old template variables to new theme variables */
            --primary-color: var(--primary-blue);
            --bg-color: var(--gray-bg);
            --card-bg: var(--white);
            --text-sub: var(--text-muted);
            --border-color: var(--gray-border);
            --shadow: 0 10px 25px rgba(7, 24, 53, 0.05);
            --input-bg: var(--gray-bg);
            --accent-green: var(--light-highlight);
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 40px 20px;
            color: var(--text-main);
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Titles */
        .page-title {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .main-card {
            margin-top: -26px;
        }

        .add-text {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: left;
            color: var(--text-main);
        }

        /* Form Styles */
        .payment-form {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            background-color: var(--input-bg);
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
            color: var(--text-main);
        }

        input::placeholder {
            color: var(--text-muted);
        }

        input:focus,
        select:focus {
            border-color: var(--primary-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3px rgba(7, 24, 53, 0.1);
        }

        /* Action Buttons Wrapper */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 15px;
        }

        .btn-update,
        .btn-submit {
            width: 160px;
            height: 48px;
            padding: 0;
            font-size: 16px;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .btn-update {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-submit {
            border: 2px solid var(--primary-color);
            background-color: var(--primary-color);
            color: var(--white);
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
            width: 100%;
            box-sizing: border-box;
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
            margin-top: -14px;
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
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: -4px;
        }

        .btn-edit:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 50px;
            margin-top: -40px;
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

        /* Modal Styles */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease;
            box-sizing: border-box;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: var(--text-main, #071835);
        }

        .close-btn {
            font-size: 24px;
            cursor: pointer;
            color: #aaa;
        }

        .close-btn:hover {
            color: #000;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .modal-footer {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .btn-cancel {
            background: #eee;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-save {
            background: #071835;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RESPONSIVE MEDIA QUERIES */
        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .profile-sidebar-wrapper {
                order: -1;
                margin-top: 40px;
            }

            .profile-card {
                margin-top: 0;
            }

            .main-card {
                margin-top: 0;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .form-row, .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .breadcrumb {
                margin-top: -10px !important;
                margin-bottom: 25px !important;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-update, .btn-submit {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px 15px;
            }

            .add-text {
                font-size: 20px;
                margin-bottom: 15px;
            }
        }
    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow"></span>
        <span class="active">Profile</span>
    </div>

    <div class="container">
        <div class="main-content">
            <div class="card main-card">
                <div class="add-text">Shipping Details</div>

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div
                        style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div
                        style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                        {{ session('error') }}
                    </div>
                @endif

                <form class="payment-form" action="/submit-profile" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="province">Province</label>
                            <select name="province" id="province">
                                <option value="">Select Province</option>
                                @foreach(($provinces ?? []) as $province)
                                    <option value="{{ $province->id }}" {{ (old('province', $buyer->province ?? '') == $province->id) ? 'selected' : '' }}>
                                        {{ $province->p_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district">District</label>
                            <select name="district" id="district">
                                <option value="">Select District</option>

                            </select>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group">
                            <label for="gn_division">GN Division</label>
                            <select name="gn_division" id="gn_division">
                                <option value="">Select GN Division</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label>House/Building No</label>
                            <input type="text" placeholder="e.g. No 45" name="house_no"
                                value="{{ old('house_no', $buyer->house_no ?? '') }}">
                        </div>
                    </div>

                    {{-- Address Line 1 --}}
                    <div class="form-group">
                        <label>Business Address Line 1</label>
                        <input type="text" placeholder="Enter address line 1" name="address_line_1"
                            value="{{ old('address_line_1', $buyer->addressone ?? '') }}">
                    </div>

                    {{-- Address Line 2 --}}
                    <div class="form-group">
                        <label>Business Address Line 2</label>
                        <input type="text" placeholder="Enter address line 2" name="address_line_2"
                            value="{{ old('address_line_2', $buyer->addresstwo ?? '') }}">
                    </div>

                    <div style="display: flex; gap:10px;">
                        <button type="submit" class="btn-submit">Save</button>
                        <button type="button" class="btn-update" id="openShippingModal">Edit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="profile-sidebar-wrapper">
            <div class="card profile-card">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($buyer->firstname ?? 'User') }}+{{ urlencode($buyer->surname ?? '') }}&background=071835&color=fff&size=128"
                    alt="Seller Avatar" class="profile-img">

                <h2 class="seller-name">{{ $buyer->firstname ?? 'Name' }} {{ $buyer->surname ?? '' }}</h2>
                <p class="seller-role">Verified Premium Seller</p>

                <hr class="divider">

                <div class="contact-info-list">
                    <div class="info-group">
                        <div class="info-label">Title</div>
                        <div class="info-value">{{ $buyer->title ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">First Name</div>
                        <div class="info-value">{{ $buyer->firstname ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Last Name</div>
                        <div class="info-value">{{ $buyer->surname ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $buyer->registered_email ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Mobile Number</div>
                        <div class="info-value">{{ $buyer->mobile_number ?? '-' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Location</div>
                        <div class="info-value">
                            {{ implode(', ', array_filter([
        $buyer->gn_division_name_en ?? '',
        $buyer->district_name ?? '',
        $buyer->province_name ?? ''
    ])) ?: 'Sri Lanka' }}
                        </div>
                    </div>
                </div>

                <button class="btn-edit" id="edit-profile-btn">Edit Profile</button>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="custom-modal">
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
                        <input type="text" name="title" id="input-title" value="{{ $buyer->title ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstname" id="input-fname" value="{{ $buyer->firstname ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="surname" id="input-lname" value="{{ $buyer->surname ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="input-email" value="{{ $buyer->registered_email ?? '' }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile_number" id="input-mobile" value="{{ $buyer->mobile_number ?? '' }}"
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

    <div id="editShippingModal" class="custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Shipping Address</h3>
                <span class="close-btn" id="closeShippingModal">&times;</span>
            </div>
            <form action="/update-shipping-address" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" id="modal_province">
                            <option value="">Select Province</option>
                            @foreach(($provinces ?? []) as $province)
                                <option value="{{ $province->id }}" {{ (old('province', $buyer->province ?? '') == $province->id) ? 'selected' : '' }}>
                                    {{ $province->p_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>District</label>
                        <select name="district" id="modal_district">
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>GN Division</label>
                        <select name="gn_division" id="modal_gn_division">
                            <option value="">Select GN Division</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>House No</label>
                        <input type="text" name="house_no" value="{{ old('house_no', $buyer->house_no ?? '') }}">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line_1"
                            value="{{ old('address_line_1', $buyer->addressone ?? '') }}">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Address Line 2</label>
                        <input type="text" name="address_line_2"
                            value="{{ old('address_line_2', $buyer->addresstwo ?? '') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancelShippingModal">Cancel</button>
                    <button type="submit" class="btn-save">Update Address</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.getElementById('province').addEventListener('change', function () {
            let provinceId = this.value;
            let districtSelect = document.getElementById('district');

            districtSelect.innerHTML = '<option value="">Select District</option>';
            document.getElementById('gn_division').innerHTML = '<option value="">Select GN Division</option>';

            if (!provinceId) return;

            fetch('/get-districts/' + provinceId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        let name = item.d_name;
                        districtSelect.innerHTML += `<option value="${item.id}">${name}</option>`;
                    });
                })
                .catch(error => console.error('Error:', error));
        });

        const districtSelect = document.getElementById('district');
        const gndivisionSelect = document.getElementById('gn_division');

        districtSelect.addEventListener('change', function () {
            const selectedDistrictId = this.value;

            gndivisionSelect.innerHTML = '<option value="">Select GN Division</option>';

            if (!selectedDistrictId) return;

            fetch(`/get-gn-divisions/${selectedDistrictId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(gndivision => {
                        const option = document.createElement('option');
                        option.value = gndivision.id;
                        option.textContent = gndivision.name_in_english;
                        gndivisionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching GN Divisions:', error));
        });

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


        const shippingModal = document.getElementById('editShippingModal');
        const openShippingBtn = document.getElementById('openShippingModal');
        const closeShippingBtn = document.getElementById('closeShippingModal');
        const cancelShippingBtn = document.getElementById('cancelShippingModal');

        if (openShippingBtn) {

            openShippingBtn.addEventListener('click', (e) => {
                e.preventDefault();
                shippingModal.style.display = 'flex';
            });
        }

        const closeSModal = () => shippingModal.style.display = 'none';
        if (closeShippingBtn) closeShippingBtn.addEventListener('click', closeSModal);
        if (cancelShippingBtn) cancelShippingBtn.addEventListener('click', closeSModal);


        document.getElementById('modal_province').addEventListener('change', function () {
            let provinceId = this.value;
            let districtSelect = document.getElementById('modal_district');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (!provinceId) return;

            fetch('/get-districts/' + provinceId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        districtSelect.innerHTML += `<option value="${item.id}">${item.d_name}</option>`;
                    });
                });
        });

        document.getElementById('modal_district').addEventListener('change', function () {
            let districtId = this.value;
            let gnSelect = document.getElementById('modal_gn_division');
            gnSelect.innerHTML = '<option value="">Select GN Division</option>';

            if (!districtId) return;

            fetch(`/get-gn-divisions/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(gn => {
                        gnSelect.innerHTML += `<option value="${gn.id}">${gn.name_in_english}</option>`;
                    });
                });
        });
    </script>
@endsection