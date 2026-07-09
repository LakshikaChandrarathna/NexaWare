<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>DBONDA | Seller Central</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<head>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<style>
        .material-symbols-outlined {
        font-size: 24px;
        color: #ffffff;
       
        transition: color 0.3s ease;
    }
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
        --sidebar-bg: var(--white);
        --border-color: var(--gray-border);
        --sidebar-width: 260px;
        --header-height: 70px;
    }

    body {
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: var(--bg-color);
        margin: 0;
        display: flex;
        color: var(--text-main);
    }

    /* --- Header Styling --- */
    .header-main {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        height: var(--header-height);
        background: black;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        z-index: 1000;
    }

    .logo {
        background: var(--primary-blue);
        color: var(--white);
        font-weight: 900;
        font-size: 24px;
        padding: 2px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
    }


    .search-container {
        flex: 0 1 500px;
        display: flex;
        border: 2px solid var(--primary-blue);
        border-radius: 25px;
        overflow: hidden;
        background: var(--white);
    }

    .search-input {
        width: 100%;
        padding: 8px 20px;
        border: none;
        outline: none;
        font-size: 14px;
        background: var(--white);
        color: var(--text-main);
    }

    .search-btn {
        background: var(--primary-blue);
        color: var(--white);
        border: none;
        padding: 0 20px;
        cursor: pointer;
        font-weight: 600;
    }

    .nav-actions {
        display: flex;
        gap: 25px;
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 11px;
        font-weight: bold;
        color: var(--text-main);
        cursor: pointer;
        text-decoration: none;
    }

    .nav-item i {
        font-size: 18px;
        margin-bottom: 2px;
        color:white;
    }

    .nav-item:hover {
        color: var(--primary-blue);
    }

    /* --- Sidebar Styling --- */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background: black;
        border-right: 1px solid var(--border-color);
        position: fixed;
        left: 0;
        top: 0;
        padding-top: var(--header-height);
        display: flex;
        flex-direction: column;
        z-index: 900;
    }

    .sidebar .menu-label {
        padding: 25px 25px 10px;
        font-size: 11px;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .nav-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--text-main);
        display: flex;
        align-items: center;
        padding: 14px 25px;
        gap: 15px;
        transition: 0.3s;
        border-left: 4px solid transparent;
    }

    .nav-links a:hover {
        /* background: var(--light-highlight); */
        color: var(--primary-blue);
    }

    /* Active State */
    .nav-links a.active {
        background: var(--light-highlight);
        color: var(--primary-blue);
        border-left: 4px solid var(--primary-blue);
        font-weight: 600;
    }

    .nav-icon {
        font-size: 18px;
    }

    /* --- Content Area --- */
    .content-area {
        margin-top: var(--header-height);
        margin-left: var(--sidebar-width);
        padding: 40px;
        width: calc(100% - var(--sidebar-width));
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 70px;
        }

        .nav-text,
        .menu-label {
            display: none;
        }

        .search-container {
            display: none;
        }

        .content-area {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        .nav-links a {
            justify-content: center;
            padding: 20px 0;
            border-left: none;
        }
    }

    .modal-overlay {
        display: none;
        position: absolute;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(1, 8, 19, 0.5);
        backdrop-filter: blur(3px);
    }


    .modalcontent {
        background-color: var(--white);
        margin: 80px auto;
        padding: 0;
        border-radius: 12px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.3s ease-out;
        overflow: hidden;
        margin-left: 1133px;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 15px 20px;
        background: var(--gray-bg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
    }

    .modal-header h3 {
        margin: 0;
        font-size: 16px;
        color: var(--text-main);
    }

    .closemodal {
        font-size: 24px;
        cursor: pointer;
        color: var(--text-muted);
    }

    .closemodal:hover {
        color: var(--primary-blue);
    }

    .modal-body {
        max-height: 400px;
        overflow-y: auto;
        background: var(--white);
    }

    /* Alert Item Style */
    .alert-item {
        display: flex;
        gap: 15px;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        transition: 0.2s;
        cursor: pointer;
    }

    .alert-item:hover {
        background: var(--gray-bg);
    }

    .alert-item.unread {
        background: var(--light-highlight);
    }

    .alert-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stock-low {
        background: #fee2e2;
        color: #ef4444;
    }

    .order-success {
        background: #dcfce7;
        color: #22c55e;
    }

    .alert-info .alert-text {
        margin: 0;
        font-size: 13px;
        color: var(--text-main);
        line-height: 1.4;
    }

    .alert-info .alert-time {
        font-size: 11px;
        color: var(--text-muted);
    }

    .modal-footer {
        padding: 12px;
        text-align: center;
        background: var(--white);
        border-top: 1px solid var(--border-color);
    }

    .view-all {
        font-size: 13px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
    }

    .nav-item1 {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 11px;
        font-weight: bold;
        color: var(--text-main);
        cursor: pointer;
        text-decoration: none;
        margin-top: -6px;
    }

    @media (max-width: 768px) {
        .modal-overlay {
            display: none;
            position: absolute;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(1, 8, 19, 0.5);
            backdrop-filter: blur(3px);
        }


        .modalcontent {
            background-color: var(--white);
            margin: 80px auto;
            padding: 0;
            border-radius: 12px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.3s ease-out;
            overflow: hidden;
            margin-left: 20px;
        }
    }
    
    .logo-img {
        max-height: 145px;
        object-fit: contain;
        display: block;
        transform: rotate(45deg);
        margin-left: 20px;
        margin-top: -7px;
    }

    .nav-text{
        color:white;
    }

        .signin-btn {
            background: transparent;
            color: var(--white);
            border: 1px solid var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 6px 10px;
        }
</style>

<header class="header-main">
            <div class="logo-img">
            <a href="/">
                <img src="upload/DBonda-Pallet-L-MS-2443-TAN.png" alt="D" class="logo-img">
            </a>
        </div>


<div class="nav-actions" id="headerNavActions">
    @if(Auth::check() || session()->has('human_name'))
        @php
           
            $displayName = session('human_name');
            if(!$displayName && Auth::check()) {
                $userFields = DB::table('humans')->where('id', Auth::id())->first();
                $displayName = $userFields ? ($userFields->first_name . ' ' . $userFields->last_name) : 'Seller';
            }
        @endphp

        <div class="user-dropdown" style="position: relative; display: inline-block;">
            <div onclick="toggleUserDropdown(event)" class="user-profile-trigger" style="display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; user-select: none;">
                <i class="fa fa-user-circle" style="color: var(--white); font-size: 22px;"></i>
                <span class="user-profile-name" style="color: var(--white); font-weight: bold; font-size: 11px; margin-top: 3px; max-width: 90px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $displayName }}
                </span>
            </div>
            
            <div id="userDropdownContent" style="display: none; position: absolute; right: 0; top: 110%; background-color: var(--white); min-width: 130px; box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); z-index: 150; border: 1px solid var(--light-highlight); border-radius: 8px; padding: 8px; text-align: center;">
                <a href="/" style="text-decoration: none; padding: 6px 0px; font-size: 12px; width: 100%; justify-content: center; margin-bottom: 6px; background: var(--primary-blue); color: var(--white); display: flex; align-items: center; border-radius: 5px; font-weight: bold;">
                    Home
                </a>
                <button onclick="submitLogout()" style="border: 1px solid #071835; color: var(--primary-blue); padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center; background: transparent; border-radius: 5px; font-weight: bold; cursor: pointer;">
                    Logout
                </button>
            </div>
        </div>
    @else
      <button onclick="openLoginModal()" class="nav-btn signin-btn">Sign In</button>
    @endif
</div>
</header>

<nav class="sidebar">
    <div class="menu-label"></div>
    <ul class="nav-links">
        <a href="/sellerdashboard" class="{{ Request::is('sellerdashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined">home</span>
            <span class="nav-text">Dashboard</span>
        </a>

        <a href="/selleraddproduct" class="{{ Request::is('selleraddproduct') ? 'active' : '' }}">
            <span class="material-symbols-outlined">grid_view</span>
            <span class="nav-text">Products</span>
        </a>

        <a href="/sellerorders" class="{{ Request::is('orders*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="nav-text">Orders</span>
        </a>

        <a href="/sellerstock" class="{{ Request::is('sellerstock*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="nav-text">Stock</span>
        </a>

        <a href="/sellerprofile" class="{{ Request::is('sellerprofile') ? 'active' : '' }}">
            <span class="material-symbols-outlined">badge</span>
            <span class="nav-text">Business Profile</span>
        </a>

        <a href="/sellerprof" class="{{ Request::is('sellerprof') ? 'active' : '' }}">
            <span class="material-symbols-outlined">person</span>
            <span class="nav-text">Profile</span>
        </a>

        <a href="/selleroffers" class="{{ Request::is('selleroffers') ? 'active' : '' }}">
           <span class="material-symbols-outlined">shopping_bag</span>
            <span class="nav-text">Offers</span>
        </a>

        <a href="/seller/sellersettings" class="{{ Request::is('seller/sellersettings') ? 'active' : '' }}" >
            <span class="material-symbols-outlined">settings</span>
            <span class="nav-text">Settings</span>
        </a>
    </ul>
</nav>

<main class="content-area">
    @yield('content')
</main>

<div id="alertsModal" class="modal-overlay">
    <div class="modalcontent">
        <div class="modal-header">
            <h3><i class="fa fa-bell"></i> Notifications</h3>
            <span class="closemodal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="alert-item unread">
                <div class="alert-icon stock-low">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="alert-info">
                    <p class="alert-text"><strong>Low Stock Alert:</strong> "Ceylon Cinnamon Pack" is running low (Only
                        3 left).</p>
                    <span class="alert-time">Just now</span>
                </div>
            </div>

            <div class="alert-item">
                <div class="alert-icon order-success">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="alert-info">
                    <p class="alert-text">Order <strong>#CB67890</strong> has been shipped!</p>
                    <span class="alert-time">2 hours ago</span>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <a href="#" class="view-all">Mark all as read</a>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alertsBtn = document.querySelector('a[href="#"].nav-item');
    const modal = document.getElementById('alertsModal');
    const closeBtn = document.querySelector('.closemodal');

    
    if (alertsBtn) {
        alertsBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (modal) modal.style.display = 'block';
        });
    }

    if (closeBtn && modal) {
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', function (e) {
        if (modal && e.target == modal) {
            modal.style.display = 'none';
        }
    });
});


   
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('userDropdownContent');
        if (dropdown) {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    }

   
    window.addEventListener('click', function() {
        const dropdown = document.getElementById('userDropdownContent');
        if (dropdown) { dropdown.style.display = 'none'; }
    });

    
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
            if(data.success) {
                alert('Logged out successfully!');
                window.location.href = '/';
            } else {
                alert('Logout failed. Please try again.');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Server side error occurred during logout.');
        });
    }

</script>