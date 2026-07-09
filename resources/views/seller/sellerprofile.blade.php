@extends('seller.layouts.master')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
            
            /* Structural mapping for maintaining layout variables */
            --bg-color: var(--gray-bg);
            --card-bg: var(--white);
            --text-sub: var(--text-muted);
            --border-color: var(--gray-border);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05);
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

        /* Common Card Style */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            margin-top: 115px;
        }

        .company-management-container {
            margin-top: 3px;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            background: var(--white);
            padding: 12px 20px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .add-company-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            background: transparent;
            width: auto;
            padding: 0;
            box-shadow: none;
        }

        .add-company-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.3px;
        }

        .btn-open-modal {
            background-color: var(--primary-blue);
            color: var(--white);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(7, 24, 53, 0.2);
        }

        .btn-open-modal:hover {
            transform: translateY(-1px);
            background-color: var(--dark-navy);
            box-shadow: 0 4px 6px rgba(7, 24, 53, 0.3);
        }

        .premium-notice {
            font-size: 13px;
            color: var(--text-sub);
            margin: 0;
            padding-left: 20px;
            border-left: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            min-width: 260px;
            margin-left: 444px;
        }

        .premium-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: color 0.2s;
            background: var(--light-highlight);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .premium-link:hover {
            color: var(--dark-navy);
            background: var(--gray-border);
        }

        /* --- Updated Company List & Cards Grid --- */
        .company-list {
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 25px;
        }

        .company-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: auto;
            width:auto;
        }

        .company-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--light-highlight);
        }

        .company-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--light-highlight));
            opacity: 0.8;
        }

        .company-header {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
        }

        .company-icon-box {
            background: var(--gray-bg);
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.3rem;
            color: var(--primary-blue);
        }

        .company-title-area {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 100%;
        }

        .company-title-area h3 {
            margin: 0;
            font-size: 1.15rem;
            color: var(--text-main);
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.3px;
        }

        .company-details-body {
            border-top: 1px solid var(--gray-border);
            padding-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-row {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .info-row-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-sub);
            font-weight: 600;
        }

        .info-row-value {
            font-size: 0.88rem;
            color: var(--text-main);
            font-weight: 500;
            line-height: 1.4;
        }

        .contacts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 4px;
            border-top: 1px dashed var(--gray-border);
            padding-top: 12px;
        }

        /* --- Actions Footer Style --- */
        .company-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid var(--gray-border);
        }

        .btn-action-edit {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background-color: var(--primary-blue);
            color: var(--white);
            border: 1px solid var(--primary-blue);
            padding: 8px 4px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-action-edit:hover {
            background-color: var(--dark-navy);
            border-color: var(--dark-navy);
            color: var(--white);
        }

        .form-delete-container {
            flex: 1;
            display: flex;
        }

        .btn-action-delete {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background-color: var(--primary-blue);
            color: var(--white);
            border: 1px solid var(--primary-blue);
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 15px;
        }

        .btn-action-delete:hover {
            background-color: var(--dark-navy);
            border-color: var(--dark-navy);
        }

        /* --- Remaining Styles --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(1, 8, 19, 0.4);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background: var(--white);
            padding: 30px;
            border-radius: 16px;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-sub);
            transition: 0.2s;
        }

        .modal-close:hover {
            color: var(--black);
        }

        .modal-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: var(--text-main);
        }

        .company-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .modal-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .modal-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .modal-form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }

        .modal-input {
            width: 100%;
            height: 40px;
            padding: 8px 12px;
            font-size: 13px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--gray-bg);
            outline: none;
            transition: 0.2s;
            box-sizing: border-box;
            color: var(--text-main);
        }

        .modal-input:focus {
            border-color: var(--light-highlight);
            background-color: var(--white);
            box-shadow: 0 0 0 2px rgba(181, 203, 240, 0.2);
        }

        .contact-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .remove-btn {
            color: var(--black);
            font-size: 22px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 5px;
            user-select: none;
        }

        .btn-submit {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: var(--dark-navy);
            transform: translateY(-2px);
        }

        .profile-card {
            text-align: center;
            width: 315px;
            height: auto;
            margin-top: -50px;
        }

        .profile-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0px;
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
            margin-bottom: 8px;
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

        /* Responsive */
        @media (max-width: 992px) {
            body {
                padding: 20px 10px;
            }

            .container {
                grid-template-columns: 1fr;
                margin-top: 0;
                gap: 20px;
            }

            .company-management-container {
               margin-top: -43px;
                padding: 7px;
                width: 253px;
            }

            .premium-notice {
                border-left: none;
                padding-left: 0;
                margin-top: 10px;
                margin-left: 0;
            }

            .profile-sidebar {
                order: -1;
            }

            .profile-card {
                width: 100%;
                height: auto;
                margin-top: 0;
                box-sizing: border-box;
            }

            .profile-sidebar h2 {
                display: none;
            }
            .company-card {
                padding: 16px;
                border-radius: 12px;
                width: 233px;
  }
        }

        @media (max-width: 600px) {
            .modal-box {
                padding: 20px;
                width: 95%;
            }

            .modal-form-grid {
                grid-template-columns: 1fr !important;
            }

            .company-list {
                grid-template-columns: 1fr;
            }
        }

        .main-content{
            width:1072px;
        }
        
        
    </style>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">›</span>
        <span class="active">Profile</span>
    </div>

    <div class="container">
        <!-- Main Left Section -->
        <div class="main-content">
            <!-- Add Company Bar -->
            <div class="company-management-container">
                <div class="add-company-bar">
                    <div class="add-company-title">🏢 Add Company</div>
                    <button class="btn-open-modal" id="openModalBtn">+</button>
                </div>
                <div class="premium-notice">
                    Manage more companies? <a href="/seller/premium/upgrade" class="premium-link">Unlock Premium ✨</a>
                </div>
            </div>

            <!-- Company Cards Grid Content -->
            <div class="company-list" id="companyList">
                @forelse($companies as $company)
                    <div class="company-card">
                        <div>
                            <!-- Header Component -->
                            <div class="company-header">
                                <div class="company-icon-box">🏢</div>
                                <div class="company-title-area">
                                    <h3>{{ $company->company_name }}</h3>
                                </div>
                            </div>

                            <!-- Info Details Splitter -->
                            <div class="company-details-body">
                                <div class="info-row">
                                    <span class="info-row-label">Business Type</span>
                                    <span class="info-row-value">{{ $company->business_type ?? 'N/A' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-row-label">BRC No</span>
                                    <span class="info-row-value">{{ $company->brc_number ?? 'N/A' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-row-label">Location</span>
                                    <span class="info-row-value">
                                        {{ $company->building_no ?? $company->house_no }}, {{ $company->address_lines }},
                                        {{ $company->gn_division }},
                                        {{ $company->district }}, {{ $company->province }} Province.
                                    </span>
                                </div>

                                <!-- Contact Details Group -->
                                <div class="contacts-grid">
                                    <div class="info-row">
                                        <span class="info-row-label" style="color: #94a3b8;">Phone</span>
                                        <span class="info-row-value" style="color: #475569; font-size: 0.85rem;">
                                            @if($company->contacts->isNotEmpty())
                                                @foreach($company->contacts as $contact)
                                                    {{ $contact->country_code }} {{ $contact->contact_no }} <span
                                                        style="font-size: 0.75rem; color: #94a3b8;">({{ $contact->contact_type }})</span>{{ !$loop->last ? '<br>' : '' }}
                                                @endforeach
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-row-label" style="color: #94a3b8;">Email Address</span>
                                        <span class="info-row-value"
                                            style="color: #475569; font-size: 0.85rem; word-break: break-all;">
                                            @if($company->emails->isNotEmpty())
                                                @foreach($company->emails as $email)
                                                    {{ $email->email }}{{ !$loop->last ? '<br>' : '' }}
                                                @endforeach
                                            @else
                                                {{ $company->email ?? 'N/A' }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons Section (Edit & Delete) -->
                        <div class="company-actions">
                            <button type="button" class="btn-action-edit btn-open-update-modal" data-id="{{ $company->id }}"
                                data-name="{{ $company->company_name }}" data-type="{{ $company->business_type }}"
                                data-brc="{{ $company->brc_number }}" data-email="{{ $company->email }}"
                                data-province="{{ $company->province }}" data-district="{{ $company->district }}"
                                data-gndivision="{{ $company->gn_division }}"
                                data-buildingno="{{ $company->building_no ?? $company->house_no }}"
                                data-addressline="{{ $company->address_lines }}"
                                data-contacts='json_encode($company->contacts)'>
                                ✏️ Update
                            </button>

                            <form action="/seller/company/{{ $company->id }}/delete" method="POST" class="form-delete-container"
                                onsubmit="return confirm('Are you sure you want to delete this company?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <!-- Empty State Card -->
                    <div class="company-card"
                        style="background: #fafafa; border: 2px dashed #e2e8f0; border-radius: 16px; text-align: center; color: #94a3b8; grid-column: 1/-1; padding: 60px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                        <span style="font-size: 2rem;">📂</span>
                        <p style="margin: 0; font-size: 16px; font-weight: 500; color: #64748b;">No registered companies found.
                        </p>
                        <p style="margin: 0; font-size: 14px; color: #94a3b8;">Click the "+" button to register your first
                            business.</p>
                    </div>
                @endforelse
            </div>
        </div>

      
    </div>

    <!-- Modal Form Component (Register) -->
    <div class="modal-overlay" id="companyModal">
        <div class="modal-box">
            <span class="modal-close" id="closeModalBtn">&times;</span>
            <div class="modal-title">Register Company</div>

            <form class="company-form" id="addCompanyForm" action="/seller/company/store" method="POST">
                @csrf
                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>Company Name</label>
                        <input type="text" id="compName" name="company_name" class="modal-input"
                            placeholder="e.g. ABC Enterprises" required>
                    </div>
                    <div class="modal-form-group">
                        <label>Business Type</label>
                        <input type="text" id="compType" name="business_type" class="modal-input"
                            placeholder="e.g. Retail / Wholesale" required>
                    </div>
                </div>
                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>BRC Number</label>
                        <input type="text" id="compBrc" name="brc_number" class="modal-input" placeholder="e.g. PV123456"
                            required>
                    </div>
                    <div class="modal-form-group">
                        <label>Email</label>
                        <input type="email" id="compEmail" name="email" class="modal-input"
                            placeholder="e.g. info@company.com" required>
                    </div>
                </div>

                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>Province</label>
                        <select class="modal-input" id="compProvince" name="province">
                            <option value="Western">Western</option>
                            <option value="Central">Central</option>
                            <option value="Southern">Southern</option>
                            <option value="Northern">Northern</option>
                            <option value="Eastern">Eastern</option>
                        </select>
                    </div>
                    <div class="modal-form-group">
                        <label>District</label>
                        <select class="modal-input" id="compDistrict" name="district">
                            <option value="Colombo">Colombo</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Matale">Matale</option>
                            <option value="Galle">Galle</option>
                            <option value="Matara">Matara</option>
                        </select>
                    </div>
                </div>

                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>GN Division</label>
                        <input type="text" id="compGnDivision" name="gn_division" class="modal-input"
                            placeholder="e.g. Fort" required>
                    </div>
                    <div class="modal-form-group">
                        <label>House/Building No</label>
                        <input type="text" id="compBuildingNo" name="building_no" class="modal-input"
                            placeholder="e.g. No 45" required>
                    </div>
                </div>

                <div class="modal-form-group">
                    <div id="modal-address-all">
                        <div class="modal-form-group" id="modal_address_line_div_1">
                            <label>Business Address Line 1</label>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <input type="text" id="modal_address_line_1" name="address_lines[]" class="modal-input"
                                    placeholder="Enter address line 1" required>
                            </div>

                            <div onclick="addModalAddressField()"
                                style="display: flex; align-items: center; cursor: pointer; color: #00534E; font-size: 12px; font-style: italic; margin-top: 8px; width: fit-content;">
                                <span
                                    style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background-color: #00534E; color: #ffffff; border-radius: 50%; margin-right: 8px; font-size: 14px; font-weight: bold; line-height: 1;">+</span>
                                <span>Add Address Line</span>
                            </div>
                        </div>
                        <div id="modal-address-container"></div>
                    </div>
                </div>

                <div class="modal-form-group">
                    <label>Contact Number(s)</label>
                    <div id="modal-contact-container"></div>

                    <div onclick="addModalContactField()"
                        style="display: flex; align-items: center; cursor: pointer; color: #00534E; font-size: 12px; font-style: italic; margin-top: 8px; width: fit-content;">
                        <span
                            style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background-color: #00534E; color: #ffffff; border-radius: 50%; margin-right: 8px; font-size: 14px; font-weight: bold; line-height: 1;">+</span>
                        <span style="border-bottom: 1px solid transparent; transition: border-color 0.2s;"
                            onmouseover="this.style.borderColor='#00534E'"
                            onmouseout="this.style.borderColor='transparent'">Add Contact Number</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Register Company</button>
            </form>
        </div>
    </div>

    <!-- Modal Form Component (Update) -->
    <div class="modal-overlay" id="updateCompanyModal">
        <div class="modal-box">
            <span class="modal-close" id="closeUpdateModalBtn">&times;</span>
            <div class="modal-title">Update Company Details</div>

            <form class="company-form" id="updateCompanyForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>Company Name</label>
                        <input type="text" id="updateCompName" name="company_name" class="modal-input"
                            placeholder="e.g. ABC Enterprises" required>
                    </div>
                    <div class="modal-form-group">
                        <label>Business Type</label>
                        <input type="text" id="updateCompType" name="business_type" class="modal-input"
                            placeholder="e.g. Retail / Wholesale" required>
                    </div>
                </div>
                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>BRC Number</label>
                        <input type="text" id="updateCompBrc" name="brc_number" class="modal-input"
                            placeholder="e.g. PV123456" required>
                    </div>
                    <div class="modal-form-group">
                        <label>Email</label>
                        <input type="email" id="updateCompEmail" name="email" class="modal-input"
                            placeholder="e.g. info@company.com" required>
                    </div>
                </div>

                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>Province</label>
                        <select class="modal-input" id="updateCompProvince" name="province">
                            <option value="Western">Western</option>
                            <option value="Central">Central</option>
                            <option value="Southern">Southern</option>
                            <option value="Northern">Northern</option>
                            <option value="Eastern">Eastern</option>
                        </select>
                    </div>
                    <div class="modal-form-group">
                        <label>District</label>
                        <select class="modal-input" id="updateCompDistrict" name="district">
                            <option value="Colombo">Colombo</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Matale">Matale</option>
                            <option value="Galle">Galle</option>
                            <option value="Matara">Matara</option>
                        </select>
                    </div>
                </div>

                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label>GN Division</label>
                        <input type="text" id="updateCompGnDivision" name="gn_division" class="modal-input"
                            placeholder="e.g. Fort" required>
                    </div>
                    <div class="modal-form-group">
                        <label>House/Building No</label>
                        <input type="text" id="updateCompBuildingNo" name="building_no" class="modal-input"
                            placeholder="e.g. No 45" required>
                    </div>
                </div>

                <div class="modal-form-group">
                    <div id="update-modal-address-all">
                        <div class="modal-form-group" id="update_modal_address_line_div_1">
                            <label>Business Address Line 1</label>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <input type="text" id="update_modal_address_line_1" name="address_lines[]"
                                    class="modal-input" placeholder="Enter address line 1" required>
                            </div>

                            <div onclick="addUpdateModalAddressField()"
                                style="display: flex; align-items: center; cursor: pointer; color: #00534E; font-size: 12px; font-style: italic; margin-top: 8px; width: fit-content;">
                                <span
                                    style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background-color: #00534E; color: #ffffff; border-radius: 50%; margin-right: 8px; font-size: 14px; font-weight: bold; line-height: 1;">+</span>
                                <span>Add Address Line</span>
                            </div>
                        </div>
                        <div id="update-modal-address-container"></div>
                    </div>
                </div>

                <div class="modal-form-group">
                    <label>Contact Number(s)</label>
                    <div id="update-modal-contact-container"></div>

                    <div onclick="addUpdateModalContactField()"
                        style="display: flex; align-items: center; cursor: pointer; color: #00534E; font-size: 12px; font-style: italic; margin-top: 8px; width: fit-content;">
                        <span
                            style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background-color: #00534E; color: #ffffff; border-radius: 50%; margin-right: 8px; font-size: 14px; font-weight: bold; line-height: 1;">+</span>
                        <span style="border-bottom: 1px solid transparent; transition: border-color 0.2s;"
                            onmouseover="this.style.borderColor='#00534E'"
                            onmouseout="this.style.borderColor='transparent'">Add Contact Number</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Update Details</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('companyModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const form = document.getElementById('addCompanyForm');

        const updateModal = document.getElementById('updateCompanyModal');
        const closeUpdateModalBtn = document.getElementById('closeUpdateModalBtn');
        const updateForm = document.getElementById('updateCompanyForm');

        let modalContactCounter = 1;
        let updateModalContactCounter = 1;

        document.addEventListener("DOMContentLoaded", function () {
            addModalContactField(true);

            // Wire up all Update buttons dynamically
            document.querySelectorAll('.btn-open-update-modal').forEach(button => {
                button.addEventListener('click', function () {
                    const companyId = this.getAttribute('data-id');

                    // Form action url set up
                    updateForm.setAttribute('action', '/seller/company/' + companyId + '/update');

                    // Fields automatic mapping mapping
                    document.getElementById('updateCompName').value = this.getAttribute('data-name');
                    document.getElementById('updateCompType').value = this.getAttribute('data-type');
                    document.getElementById('updateCompBrc').value = this.getAttribute('data-brc');
                    document.getElementById('updateCompEmail').value = this.getAttribute('data-email');
                    document.getElementById('updateCompProvince').value = this.getAttribute('data-province');
                    document.getElementById('updateCompDistrict').value = this.getAttribute('data-district');
                    document.getElementById('updateCompGnDivision').value = this.getAttribute('data-gndivision');
                    document.getElementById('updateCompBuildingNo').value = this.getAttribute('data-buildingno');
                    document.getElementById('update_modal_address_line_1').value = this.getAttribute('data-addressline');

                    // Clear previous dynamic contacts logic
                    document.getElementById('update-modal-contact-container').innerHTML = '';
                    updateModalContactCounter = 1;

                    try {
                        const contactsData = JSON.parse(this.getAttribute('data-contacts'));
                        if (contactsData && contactsData.length > 0) {
                            contactsData.forEach((contact, index) => {
                                addUpdateModalContactField(index === 0, contact.contact_type, contact.country_code, contact.contact_no);
                            });
                        } else {
                            addUpdateModalContactField(true);
                        }
                    } catch (e) {
                        addUpdateModalContactField(true);
                    }

                    updateModal.style.display = 'flex';
                });
            });
        });

        openModalBtn.addEventListener('click', () => { modal.style.display = 'flex'; });
        closeModalBtn.addEventListener('click', () => { modal.style.display = 'none'; });
        closeUpdateModalBtn.addEventListener('click', () => { updateModal.style.display = 'none'; });

        window.addEventListener('click', (e) => {
            if (e.target === modal) { modal.style.display = 'none'; }
            if (e.target === updateModal) { updateModal.style.display = 'none'; }
        });

        function addModalContactField(isFirst = false) {
            const container = document.getElementById("modal-contact-container");
            if (modalContactCounter > 5) return alert("Limit reached");

            const div = document.createElement("div");
            div.className = "contact-row";
            div.id = "modal_contact_row_" + modalContactCounter;
            div.innerHTML = `
                    <select class="modal-input modal-contact-type" name="contacts[${modalContactCounter}][type]" style="width: 95px;">
                        <option value="mobile">Mobile</option>
                        <option value="office">Office</option>
                    </select>
                    <select class="modal-input modal-country-code" name="contacts[${modalContactCounter}][code]" style="width: 85px;">
                        <option value="+94">🇱🇰 +94</option>
                    </select>
                    <input type="text" class="modal-input modal-contact-no" name="contacts[${modalContactCounter}][number]" placeholder="712345678" required style="flex:1;">
                    ${isFirst ? '' : `<span class="remove-btn" onclick="removeModalContact(${modalContactCounter})">−</span>`}
                `;
            container.appendChild(div);
            modalContactCounter++;
        }

        function removeModalContact(id) {
            const row = document.getElementById("modal_contact_row_" + id);
            if (row) {
                row.remove();
                modalContactCounter--;
            }
        }

        function addUpdateModalContactField(isFirst = false, type = 'mobile', code = '+94', number = '') {
            const container = document.getElementById("update-modal-contact-container");
            if (updateModalContactCounter > 5) return alert("Limit reached");

            const div = document.createElement("div");
            div.className = "contact-row";
            div.id = "update_modal_contact_row_" + updateModalContactCounter;
            div.innerHTML = `
                    <select class="modal-input modal-contact-type" name="contacts[${updateModalContactCounter}][type]" style="width: 95px;">
                        <option value="mobile" ${type === 'mobile' ? 'selected' : ''}>Mobile</option>
                        <option value="office" ${type === 'office' ? 'selected' : ''}>Office</option>
                    </select>
                    <select class="modal-input modal-country-code" name="contacts[${updateModalContactCounter}][code]" style="width: 85px;">
                        <option value="+94" ${code === '+94' ? 'selected' : ''}>🇱🇰 +94</option>
                    </select>
                    <input type="text" class="modal-input modal-contact-no" name="contacts[${updateModalContactCounter}][number]" value="${number}" placeholder="712345678" required style="flex:1;">
                    ${isFirst ? '' : `<span class="remove-btn" onclick="removeUpdateModalContact(${updateModalContactCounter})">−</span>`}
                `;
            container.appendChild(div);
            updateModalContactCounter++;
        }

        function removeUpdateModalContact(id) {
            const row = document.getElementById("update_modal_contact_row_" + id);
            if (row) {
                row.remove();
                updateModalContactCounter--;
            }
        }
    </script>
@endsection