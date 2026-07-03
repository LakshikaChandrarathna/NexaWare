<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lakmaa Header with Modal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* CSS Variables mapped strictly to the palette including White and Black */
        :root {
            --primary-blue: #071835;
            --light-highlight: #b5cbf0;
            --dark-navy: #071835;
            --deep-background: #010813;
            --text-main: #01060e;
            --white: #ffffff;
            --black: #000000;
        }

        /* --- Header Styles --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', system-ui, -apple-system, sans-serif;
            color: var(--text-main);
            background-color: white;
            min-height: 2000px;
        }

        .header-main {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: fixed;
            width: 100%;
            top: 0;
            background: transparent;
            z-index: 100;
            transition: all 0.4s ease-in-out;
        }

        .header-top-row {
            height: 61px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            width: 100%;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Dropdowns bar */
        .header-bottom-bar {
            display: flex;
            align-items: center;
            gap: 30px !important;
            padding: 0px 40px;
            background: transparent;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
        }

        .header-main.scrolled {
            background: var(--black);
            border-bottom: 1px solid #222;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Scroll */
        .header-main.scrolled .header-bottom-bar {
            background: transparent;
            border-top: 1px solid #222;
        }

        .header-left-nav {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 500;
            flex: 1;
        }

        .header-left-nav a.ecom-nav-link {
            text-decoration: none;
            color: white;
            padding: 8px 0;
            display: inline-block;
            white-space: nowrap;
            transition: color 0.3s;
        }

        .header-main.scrolled .header-left-nav a.ecom-nav-link {
            color: var(--white);
        }

        .header-left-nav a.ecom-nav-link.active {
            color: white;
            border-bottom: 2px solid #ffffff;
        }

        .header-main.scrolled .header-left-nav a.ecom-nav-link.active {
            color: var(--light-highlight);
            border-bottom: 2px solid var(--light-highlight);
        }

        .header-left-nav a.ecom-nav-link:hover {
            color: #b5cbf0;
        }

        .header-main.scrolled .header-left-nav a.ecom-nav-link:hover {
            color: var(--light-highlight);
        }

        .header-center-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .logo-img {
            max-height: 170px;
            object-fit: contain;
            display: block;
            transform: rotate(90deg);
        }

        .header-right-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            justify-content: flex-end;
            flex: 1;
        }

        .search-container {
            display: flex;
            border: 1px solid var(--light-highlight);
            border-radius: 25px;
            overflow: hidden;
            width: 100%;
            max-width: 220px;
            background: var(--white);
            margin-right: 31px;
        }

        .search-input {
            width: 100%;
            padding: 8px 15px;
            border: none;
            outline: none;
            background: var(--black);
            color: var(--white);
            font-size: 13px;
        }

        .search-btn {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 0 15px;
            cursor: pointer;
            font-size: 13px;
        }

        .header-main.scrolled .search-btn {
            background: #222;
            border-left: 1px solid #444;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
        }

        .nav-btn {
            padding: 6px 14px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            display: flex;
            align-items: center;
            white-space: nowrap;
            transition: all 0.3s;
        }

        .register-btn {
            background: var(--white);
            color: var(--black);
            border: 1px solid var(--white);
        }

        .signin-btn {
            background: transparent;
            color: var(--white);
            border: 1px solid var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .header-main.scrolled .register-btn {
            background: var(--white);
            color: var(--black);
            border: 1px solid var(--white);
        }

        .header-main.scrolled .signin-btn {
            background: transparent;
            color: var(--white);
            border: 1px solid var(--white);
        }

        /* --- Dropdown & Mega Menu Styles --- */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--white);
            min-width: 250px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
            z-index: 105;
            border: 1px solid var(--light-highlight);
            border-radius: 4px;
            padding: 15px;
            top: 100%;
            left: 0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* --- Modals Styles --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(1, 8, 19, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background: var(--white);
            color: var(--black);
            border-radius: 15px;
            width: 400px;
            position: relative;
            box-shadow: 0 10px 30px rgba(7, 24, 53, 0.15);
            border: 1px solid var(--light-highlight);
            padding: 35px;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
            background: var(--white);
            color: var(--black);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(7, 24, 53, 0.15);
            border: 1px solid var(--light-highlight);
            position: relative;
        }

        .login-right {
            padding: 35px;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-main);
        }

        .input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid var(--light-highlight);
            background: var(--white);
            color: var(--black);
            border-radius: 8px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .tab-container {
            display: flex;
            gap: 40px;
            justify-content: center;
            margin-bottom: 25px;
        }

        .tab-btn {
            padding: 5px 0;
            border: none;
            background: transparent;
            cursor: pointer;
            font-weight: 600;
            color: var(--light-highlight);
            position: relative;
        }

        .tab-btn.active {
            color: var(--primary-blue);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 100%;
            height: 2px;
            background: var(--primary-blue);
        }

        .relative {
            position: relative;
        }

        .toggle {
            position: absolute;
            right: 12px;
            top: 12px;
            font-size: 12px;
            color: var(--primary-blue);
            cursor: pointer;
        }

        .link {
            color: var(--primary-blue);
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .center-text {
            text-align: center;
            font-size: 13px;
            margin-top: 15px;
            color: var(--text-main);
        }

        .back-btn {
            display: inline-block;
            cursor: pointer;
            color: var(--primary-blue);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .small-text {
            color: var(--primary-blue);
            font-size: 12px;
            margin-bottom: 20px;
        }

        .google-btn,
        .apple-btn {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: var(--white);
            color: var(--black);
            border: 1px solid var(--light-highlight);
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        select.input {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%235d81bd%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 10px;
        }

        /* --- Mobile Specific Scaled Styles --- */
        @media (max-width: 992px) {
            .header-top-row {
                padding: 0 10px;
                gap: 0px;
            }


            .header-bottom-bar {
                padding: 10px;
                gap: 15px !important;
                justify-content: flex-start;
                flex-wrap: wrap;
                overflow: visible !important;
            }

            .dropdown {
                position: static !important;
            }

            .dropdown-content.mega-menu {
                display: none !important;
                position: absolute !important;
                left: 10px !important;
                right: 10px !important;
                width: calc(100% - 20px) !important;
                z-index: 9999 !important;
                background-color: var(--white) !important;
            }

            .dropdown-content.mega-menu.show-menu {
                display: block !important;
            }

            .header-bottom-bar {
                flex-wrap: wrap !important;
                overflow: visible !important;
            }

            .header-left-nav {
                font-size: 9px;
                gap: 0px;
            }

            .logo-img {
                max-height: 80px;
            }

            .search-container {
                max-width: 110px;
                margin-right: 5px;
            }

            .search-input,
            .search-btn,
            .nav-btn {
                padding: 4px 8px;
                font-size: 10px;
            }

            .nav-actions {
                gap: 5px;
                margin-right: auto;
            }
        }

        .divider {
            font-size: 12px;
            color: darkblue;
            margin-left: 161px;
        }

        .user-profile-trigger {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-right: auto;
            user-select: none;
        }
    </style>
</head>

<body>

    <header class="header-main" id="mainHeader">
        <!-- Main row for standard navigation, logo, and actions -->
        <div class="header-top-row">
            <div class="header-left-nav">
                <a href="/" class="ecom-nav-link {{ request()->is('/') ? 'active' : '' }}">HOME</a>
                <span style="color: white; margin-left: 10px; margin-right: 5px;">|</span>
                <a href="/shop"
                    class="ecom-nav-link {{ request()->is('shop') || request()->is('shop/*') ? 'active' : '' }}">SHOP
                </a>
                <span style="color: white; margin-left: 10px; margin-right: 5px;">|</span>

                <a href="{{ url('/sellerdetails') }}#about-content"
                    class="ecom-nav-link {{ request()->is('about') ? 'active' : '' }}">ABOUT US</a>
            </div>

            <div class="header-center-logo">
                <a href="/">
                    <img src="" alt="D" class="logo-img">
                </a>
            </div>

            <div class="header-right-actions">
                <!-- <div class="search-container">
                    <input type="text" placeholder="Search..." class="search-input">
                    <button class="search-btn">Search</button>
                </div> -->
                <div class="nav-actions" id="headerNavActions">
                    @if(session()->has('human_name'))
                        <div class="user-dropdown" style="position: relative; display: inline-block;">
                            <div onclick="toggleUserDropdown(event)" class="user-profile-trigger">

                                <i class="fa fa-user-circle" style="color: var(--white); font-size: 25px;"></i>
                                <span class="user-profile-name"
                                    style="color: var(--white); font-weight: bold; font-size: 11px; margin-top: 3px; max-width: 80px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ session('human_name') }}
                                </span>
                            </div>

                            <div id="userDropdownContent"
                                style="display: none; position: absolute; right: 15px; top: 110%; background-color: var(--white); min-width: 130px; box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); z-index: 150; border: 1px solid var(--light-highlight); border-radius: 8px; padding: 8px; text-align: center;">
                                @if(auth()->check() && auth()->user()->role_id == 2)

                                    <a href="/sellerprof" class="nav-btn register-btn"
                                        style="text-decoration: none; padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center; margin-bottom: 6px; border-color: var(--primary-blue); background: var(--primary-blue); color: var(--white); display: flex; align-items: center;">
                                        Profile
                                    </a>
                                @else

                                    <a href="/buyerprofile" class="nav-btn register-btn"
                                        style="text-decoration: none; padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center; margin-bottom: 6px; border-color: var(--primary-blue); background: var(--primary-blue); color: var(--white); display: flex; align-items: center;">
                                        Profile
                                    </a>
                                @endif
                                <button onclick="submitLogout()" class="nav-btn signin-btn"
                                    style="border-color: var(--primary-blue); color:  var(--primary-blue); padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center;backgroundcolor: var(--primary-blue); background: transparent;">
                                    Logout
                                </button>
                            </div>
                        </div>
                    @else
                        <button onclick="openRegisterModal()" class="nav-btn register-btn">Register</button>
                        <button onclick="openLoginModal()" class="nav-btn signin-btn">Sign In</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Separate bar strictly for the dropdown elements -->
        <div class="header-bottom-bar header-left-nav">
            <div class="dropdown">
                <a href="javascript:void(0)" class="ecom-nav-link dropbtn category-filter-link"
                    data-category="sand-papers" data-level="category">
                    Sand Papers <i class="fa fa-chevron-down"></i>
                </a>
                <div class="dropdown-content mega-menu">
                    <div class="side-menu">
                        <div class="menu-group">
                            <a href="javascript:void(0)" class="side-link active category-filter-link"
                                data-category="sheet" data-level="subcategory"
                                style="color: #071835; font-weight: bold;">Sheet</a>
                            <div class="sub-menu">
                                <a href="javascript:void(0)" class="sub-link category-filter-link"
                                    data-category="aluminum-oxide" data-level="group"
                                    style="color: #010048; font-weight:600">Aluminum Oxide</a>
                            </div>
                        </div>

                        <hr class="menu-divider">

                        <div class="menu-group">
                            <a href="javascript:void(0)" class="side-link category-filter-link" data-category="disc"
                                data-level="subcategory" style="color: #071835; font-weight: bold;">Disc</a>
                            <div class="sub-menu">
                                <a href="javascript:void(0)" class="sub-link category-filter-link"
                                    data-category="purple" data-level="group"
                                    style="color: #010048; font-weight: 600;">Purple(Silicon Carbide)</a>

                                <a href="javascript:void(0)" class="sub-link category-filter-link"
                                    data-category="yellow" data-level="group"
                                    style="color: #010048; font-weight: 600;">Yellow(Aluminium Oxide)</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <a href="javascript:void(0)" class="ecom-nav-link dropbtn category-filter-link" data-category="sealent"
                    data-level="category">
                    Sealent <i class="fa fa-chevron-down"></i>
                </a>
                <div class="dropdown-content mega-menu">
                    <div class="side-menu">
                        <div class="menu-group">
                            <a href="javascript:void(0)" class="side-link active category-filter-link"
                                data-category="automotive" data-level="subcategory"
                                style="color: #071835; font-weight: bold;">Automotive</a>
                            <div class="sub-menu">
                                <a href="javascript:void(0)" class="sub-link category-filter-link"
                                    data-category="sealent" data-level="subcategory"
                                    style="color: #010048; font-weight: 600;">Sealent</a>
                                <div class="sub-sub-menu">
                                    <a href="javascript:void(0)" class="sub-sub-link category-filter-link"
                                        data-category="sprayable" data-level="group"
                                        style="color: #777777;">Sprayable</a>
                                    <a href="javascript:void(0)" class="sub-sub-link category-filter-link"
                                        data-category="body" data-level="group" style="color: #777777;">Body</a>
                                    <a href="javascript:void(0)" class="sub-sub-link category-filter-link"
                                        data-category="windscreen" data-level="group"
                                        style="color: #777777;">Windscreen</a>
                                </div>
                            </div>
                        </div>

                        <hr class="menu-divider">

                        <div class="menu-group">
                            <a href="javascript:void(0)" class="side-link category-filter-link"
                                data-category="construction" data-level="subcategory"
                                style="color: #071835; font-weight: bold;">Construction</a>
                            <div class="sub-menu">
                                <a href="javascript:void(0)" class="sub-link category-filter-link"
                                    data-category="silicon" data-level="group"
                                    style="color: #010048; font-weight: 600;">Silicon</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="registerModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" onclick="closeRegisterModal()">&times;</span>

            <div id="step1">
                <h2>Create Account</h2>

                <div id="country-selection-part">
                    <p class="small-text">Select your country to proceed</p>
                    <select class="input" id="reg-country-code">
                        <option value="">Select Country</option>
                        <option value="+94">Sri Lanka (+94)</option>
                        <option value="+91">India (+91)</option>
                    </select>
                    <button class="btn" type="button" onclick="goToPhoneAndSocialPart()">Next</button>
                </div>

                <div id="phone-social-part" style="display: none;">
                    <p class="small-text">Enter your phone number or continue with social accounts</p>

                    <input type="hidden" id="reg-country-name" value="">
                    <input type="text" id="reg-phone" placeholder="Register with Phone Number" class="input">

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <div class="social-login-container">
                        <button type="button" class="social-btn google-btn" onclick="handleGoogleSignIn(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.5 24c0-1.61-.15-3.16-.42-4.69H24v9h12.75c-.55 2.94-2.21 5.43-4.7 7.1l7.3 5.66C43.6 37.14 46.5 31.13 46.5 24z" />
                                <path fill="#FBBC05"
                                    d="M10.54 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.98-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.3-5.66c-2.03 1.36-4.63 2.17-8.59 2.17-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                            Continue with Google
                        </button>
                        <!-- 
            <button type="button" class="social-btn apple-btn" onclick="handleAppleSignIn()">
                <svg viewBox="0 0 170 170" width="18" height="18" fill="currentColor">
                    <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.38.13-9.13-1.84-14.25-5.92-3.46-2.75-7.37-7.41-11.72-13.97-12.2-18.43-18.3-37.59-18.3-57.47 0-14.26 3.73-25.7 11.18-34.34 7.46-8.64 16.53-13.01 27.22-13.13 5.4 0 10.98 1.54 16.74 4.63 5.75 3.09 10 4.63 12.74 4.63 2.33 0 6.13-1.42 11.41-4.26 5.28-2.84 10.32-4.2 15.11-4.11 15.11.87 26.68 6.33 34.71 16.4-12.87 7.74-19.16 18.41-18.86 31.98.3 10.23 4.16 18.73 11.57 25.5 7.42 6.77 15.93 10.41 25.53 10.92-.12 2.87-.75 6.14-1.89 9.81zM119.22 28.74c0-7.84 2.8-15.11 8.42-21.8 1.62-1.93 3.65-3.8 6.09-5.61 1.76 1.84 3.12 3.99 4.06 6.45.94 2.45 1.42 5.08 1.44 7.89 0 7.22-2.71 14.21-8.13 20.98-2.43 3.01-5.32 5.35-8.67 7.03-1.07-.94-2.26-2.22-3.56-3.86-2.43-2.91-3.65-6.55-3.65-11.08z" />
                </svg>
                Continue with Apple
            </button> -->
                    </div>

                    <button class="btn" type="button" onclick="showStep2()" style="margin-top: 15px;">Next</button>
                </div>
            </div>

            <div id="step2" style="display: none;">
                <div class="back-btn" onclick="showStep1()">&#8592; Back</div>
                <h2>Complete Details</h2>

                <!-- <div class="role-selection"
                    style="display: flex; gap: 20px; margin-bottom: 15px; justify-content: center; font-weight: 500;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <input type="radio" name="user_role" value="buyer" checked
                            style="accent-color: #000; width: 18px; height: 18px;"> Buyer
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <input type="radio" name="user_role" value="seller"
                            style="accent-color: #000; width: 18px; height: 18px;"> Seller
                    </label>
                </div> -->

                <input type="text" id="reg-firstname" placeholder="First Name" class="input">
                <input type="text" id="reg-lastname" placeholder="Last Name" class="input">
                <input type="email" id="reg-email" placeholder="Email" class="input">

                <div class="relative">
                    <input id="password-reg" type="password" placeholder="Password" class="input">
                    <span class="toggle" onclick="togglePassword('password-reg')">Show</span>
                </div>

                <button class="btn" onclick="submitRegister()">Create Account</button>
            </div>
        </div>
    </div>

    <div id="loginModal" class="modal-overlay">
        <div class="modal-content">
            <div class="login-right">
                <span class="close-modal" onclick="closeLoginModal()">&times;</span>
                <h2>Login</h2>
                <div class="tab-container">
                    <button class="tab-btn active" id="email-tab" onclick="switchTab('email')">Email</button>
                    <button class="tab-btn" id="phone-tab" onclick="switchTab('phone')">Phone</button>
                </div>
                <input type="email" id="login-field" placeholder="Enter your Email" class="input">
                <div class="relative">
                    <input id="password" type="password" placeholder="Password" class="input">
                    <span class="toggle" onclick="togglePassword('password')">Show</span>
                </div>
                <button class="btn" onclick="submitLogin()" style="background: var(--primary-blue);">Login</button>
                <p class="center-text">Don't have an account? <span onclick="closeLoginModal(); openRegisterModal();"
                        class="link">Register</span></p>
                <a href="/ecomforgetpassword" class="center-text" style="margin-left:80px;">Forget Password</a>
            </div>
        </div>
    </div>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";

        // Public Firebase Configuration
        const firebaseConfig = {
            apiKey: "AIzaSyDenu3Ov6gBystRqu8psLz5ry3L9Wikjkg",
            authDomain: "dbonda-d04a6.firebaseapp.com",
            projectId: "dbonda-d04a6",
            storageBucket: "dbonda-d04a6.firebasestorage.app",
            messagingSenderId: "76632803393",
            appId: "1:76632803393:web:9d34b77242b324a43fdec0"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);

        // Expose function globally for the button onclick trigger
        window.handleGoogleSignIn = function (e) {
            if (e && typeof e.preventDefault === 'function') {
                e.preventDefault();
            }

            const provider = new GoogleAuthProvider();

            signInWithPopup(auth, provider)
                .then(async (result) => {
                    const user = result.user;
                    const idToken = await user.getIdToken();

                    // Send token to Laravel backend
                    fetch('/google-login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                        },
                        body: JSON.stringify({ token: idToken })
                    })
                        .then(async (response) => {
                            const data = await response.json();

                            if (!response.ok) {
                                console.error("Server Error Payload:", data);
                                alert("Server Error Encountered: " + (data.message || "Internal server error. Check laravel.log"));
                                return;
                            }

                            if (data.success) {
                                console.log("Backend Verification Successful!", data.user);
                                window.location.reload();

                            } else {
                                alert("Authentication failed at server: " + (data.message || "Unknown context."));
                            }
                        })
                        .catch(err => {
                            console.error("Network Communication Error:", err);
                            alert("Failed to communicate with the application server.");
                        });

                })
                .catch((error) => {
                    console.error("Firebase Sign-In Popup Error:", error);
                    alert("Login Failed: " + error.message);
                });
        };
    </script>

    <script>
        // Header Scroll
        window.addEventListener('scroll', function () {
            const header = document.getElementById('mainHeader');
            if (window.scrollY > 50) { header.classList.add('scrolled'); }
            else { header.classList.remove('scrolled'); }
        });

        // Modal Control
        const regModal = document.getElementById('registerModal');
        const loginModal = document.getElementById('loginModal');

        function openRegisterModal() { regModal.style.display = 'flex'; }
        function closeRegisterModal() { regModal.style.display = 'none'; }
        function openLoginModal() { loginModal.style.display = 'flex'; }
        function closeLoginModal() { loginModal.style.display = 'none'; }

        window.onclick = function (event) {
            if (event.target == regModal) { closeRegisterModal(); }
            if (event.target == loginModal) { closeLoginModal(); }
        }
        function goToPhoneAndSocialPart() {
            const countryCode = document.getElementById('reg-country-code').value;

            if (countryCode === "") {
                alert("Please select a country first!");
                return;
            }

            //
            document.getElementById('country-selection-part').style.display = 'none';
            document.getElementById('phone-social-part').style.display = 'block';
        }

        function showStep2() {

            const countrySelect = document.getElementById('reg-country-code');
            if (countrySelect.selectedIndex > 0) {
                const selectedText = countrySelect.options[countrySelect.selectedIndex].text;
                document.getElementById('reg-country-name').value = selectedText.split(' (')[0];
            }
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        }
        function showStep1() { document.getElementById('step2').style.display = 'none'; document.getElementById('step1').style.display = 'block'; }

        function switchTab(type) {
            const emailTab = document.getElementById('email-tab');
            const phoneTab = document.getElementById('phone-tab');
            const inputField = document.getElementById('login-field');
            if (type === 'email') {
                emailTab.classList.add('active'); phoneTab.classList.remove('active');
                inputField.type = "email"; inputField.placeholder = "Enter your Email";
            } else {
                phoneTab.classList.add('active'); emailTab.classList.remove('active');
                inputField.type = "tel"; inputField.placeholder = "Enter your Phone Number";
            }
        }

        function togglePassword(id) {
            const input = document.getElementById(id);
            const toggleSpan = input.nextElementSibling;
            if (input.type === "password") { input.type = "text"; toggleSpan.textContent = "Hide"; }
            else { input.type = "password"; toggleSpan.textContent = "Show"; }
        }

        function submitRegister() {
            const countryCode = document.getElementById('reg-country-code').value;
            const phoneNumber = document.getElementById('reg-phone').value;
            const countryName = document.getElementById('reg-country-name').value;
            // let selectedRole = document.querySelector('input[name="user_role"]:checked').value;

            const firstName = document.getElementById('reg-firstname').value;
            const lastName = document.getElementById('reg-lastname').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('password-reg').value;

            const payload = {
                first_name: firstName,
                last_name: lastName,
                country: countryName,
                country_code: countryCode,
                phone_number: phoneNumber,
                email: email,
                password: password,
                user_role: 'buyer'
            };

            const tokenEl = document.querySelector('meta[name="csrf-token"]');
            if (!tokenEl) {
                alert('CSRF token not found. Please refresh page.');
                return;
            }

            fetch('/custom-register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': tokenEl.getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
                .then(res => {
                    if (!res.ok && res.status !== 422) {
                        return res.text().then(text => { throw new Error(text) });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {

                        alert('Account created successfully and welcome email sent!');
                        window.location.reload();
                    } else {
                        let errorMsg = '';
                        for (const key in data.errors) {
                            errorMsg += `${data.errors[key].join(', ')}\n`;
                        }
                        alert('Validation Error:\n' + errorMsg);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Server side error occurred. Check browser console.');
                });
        }


        function submitLogin() {
            const loginField = document.getElementById('login-field').value;
            const password = document.getElementById('password').value;

            const payload = {
                login_field: loginField,
                password: password
            };

            const tokenEl = document.querySelector('meta[name="csrf-token"]');

            fetch('/custom-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': tokenEl ? tokenEl.getAttribute('content') : ''
                },
                body: JSON.stringify(payload)
            })
                .then(res => {
                    if (!res.ok && res.status !== 422 && res.status !== 401) {
                        return res.text().then(text => { throw new Error(text) });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Login Successful!');
                        window.location.reload();
                    } else {
                        let errorMsg = '';
                        for (const key in data.errors) {
                            errorMsg += `${data.errors[key].join(', ')}\n`;
                        }
                        alert('Login Failed:\n' + errorMsg);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Server side error occurred. Check browser console.');
                });
        }

        // 3. LOGOUT SUBMIT FUNCTION
        function submitLogout() {
            const tokenEl = document.querySelector('meta[name="csrf-token"]');

            fetch('/custom-logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': tokenEl ? tokenEl.getAttribute('content') : ''
                }
            })
                .then(res => {
                    if (!res.ok) {
                        return res.text().then(text => { throw new Error(text) });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Logged out successfully!');
                        window.location.reload();
                    } else {
                        alert('Logout failed. Please try again.');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Server side error occurred during logout.');
                });
        }
        function toggleUserDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('userDropdownContent');
            if (dropdown) {
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            }
        }

        window.addEventListener('click', function () {
            const dropdown = document.getElementById('userDropdownContent');
            if (dropdown) { dropdown.style.display = 'none'; }
        });

        function updateHeaderUI(humanName) {
            const navActions = document.getElementById('headerNavActions');
            if (navActions) {
                navActions.innerHTML = `
                    <div class="user-dropdown" style="position: relative; display: inline-block;">
                        <div onclick="toggleUserDropdown(event)" class="user-profile-trigger" >
                            <i class="fa fa-user-circle" style="color: var(--white); font-size: 25px;"></i>
                            <span class="user-profile-name" style="color: var(--white); font-weight: bold; font-size: 11px; margin-top: 3px; max-width: 80px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                ${humanName}
                            </span>
                        </div>
                        <div id="userDropdownContent" style="display: none; position: absolute; right: 15px; top: 110%; background-color: var(--white); min-width: 140px; box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); z-index: 150; border: 1px solid var(--light-highlight); border-radius: 8px; padding: 8px; text-align: center;">
                            <a href="/sellerprof" class="nav-btn register-btn" style="text-decoration: none; padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center; margin-bottom: 6px; border-color: var(--primary-blue); background: var(--primary-blue); color: var(--white); display: flex; align-items: center;">
                                Profile
                            </a>
                            <button onclick="submitLogout()" class="nav-btn signin-btn" style="border-color: #ff4d4d; color: #ff4d4d; padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center; background: transparent;">
                                Logout
                            </button>
                        </div>
                    </div>
                `;
            }
        }

       document.addEventListener('DOMContentLoaded', () => {

    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const dropBtn = dropdown.querySelector('.dropbtn');
        const megaMenu = dropdown.querySelector('.mega-menu');

        if (dropBtn && megaMenu) {
            dropBtn.addEventListener('click', (e) => {
                // මොබයිල් විව් එකේදී (තිරය 992px හෝ අඩු නම්) පමණක් ක්ලික් එකෙන් ටොගල් කරන්න
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // වෙනත් ඇරිලා තියෙන මෙනු ඇත්නම් ඒවා වසා දැමීම
                    document.querySelectorAll('.mega-menu').forEach(menu => {
                        if (menu !== megaMenu) menu.classList.remove('show-menu');
                    });
                    
                    megaMenu.classList.toggle('show-menu');
                }
            });
        }
    });

    document.addEventListener('click', (e) => {
        document.querySelectorAll('.mega-menu').forEach(menu => {
            if (!menu.contains(e.target)) {
                menu.classList.remove('show-menu');
            }
        });
    });

    const filterLinks = document.querySelectorAll('.category-filter-link');

    filterLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const levelValue = this.getAttribute('data-level') || 'category';
            
            
            if (window.innerWidth <= 992 && levelValue === 'category') {
                return; 
            }

            e.preventDefault();
            e.stopPropagation();

            const categoryValue = this.getAttribute('data-category');
            if (!categoryValue) return;

            const gridContainer = document.getElementById('filtered-products-grid');

            // Shop page එකේ නැත්නම් redirect කිරීම
            if (!gridContainer || window.location.pathname !== '/shop') {
                window.location.href = '/shop?categories=' + encodeURIComponent(categoryValue) + '&level=' + encodeURIComponent(levelValue);
                return;
            }

            let url = new URL(window.location.origin + '/shop');
            url.searchParams.set('categories', categoryValue);
            url.searchParams.set('level', levelValue);

            gridContainer.style.opacity = '0.5';

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                gridContainer.style.opacity = '1';
                if (data.html) {
                    gridContainer.innerHTML = data.html;
                } else {
                    gridContainer.innerHTML = '<div style="color: #ffffff; grid-column: 1/-1; text-align:center; padding: 40px; font-size: 1.1rem;">No products found matching your filter selections.</div>';
                }

                window.history.pushState({}, '', url);

                document.querySelectorAll('.mega-menu').forEach(menu => {
                    menu.classList.remove('show-menu');
                });
            })
            .catch(error => {
                console.error('Error filtering products:', error);
                gridContainer.style.opacity = '1';
                window.location.href = url.href;
            });
        });
    });
});
    </script>
</body>

</html>