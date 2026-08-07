<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DBonda | Buyer Central</title>
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

        --primary-hover: #1e3a75;
        --bg-color: #f4f7fe;
        --sidebar-bg: #ffffff;
        --text-sub: #718096;
        --border-color: #edf2f7;
        --sidebar-width: 260px;
        --header-height: 70px;
    }

    body {
        font-family: 'Segoe UI', Roboto, Helvetica, popin, sans-serif;
        background-color: var(--bg-color);
        margin: 0;
        display: flex;
    }

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
        border: 2px solid var(--black);
        border-radius: 25px;
        overflow: hidden;
        background: white;
    }

    .search-input {
        width: 100%;
        padding: 8px 20px;
        border: none;
        outline: none;
        font-size: 14px;
    }

    .search-btn {
        background: var(--black);
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
    }

    .nav-item:hover {
        color: var(--primary-blue);
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
        color: var(--text-sub);
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
        color: white;
        display: flex;
        align-items: center;
        padding: 14px 25px;
        gap: 15px;
        transition: 0.3s;
        border-left: 4px solid transparent;
    }

    .nav-links a:hover {
        background: black;
        color: white;
    }

    .nav-links a.active {
        background: var(--light-highlight);
        color: var(--dark-navy);
        border-left: 4px solid var(--primary-blue);
        font-weight: 600;
    }

    .nav-icon {
        font-size: 18px;
    }

    .content-area {
        margin-top: var(--header-height);
        margin-left: var(--sidebar-width);
        padding: 40px;
        width: calc(100% - var(--sidebar-width));
        box-sizing: border-box;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
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
        background: var(--bg-color);
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

    .close-modal {
        font-size: 24px;
        cursor: pointer;
        color: var(--text-sub);
    }

    .close-modal:hover {
        color: var(--primary-blue);
    }

    .modal-body {
        max-height: 400px;
        overflow-y: auto;
    }

    .alert-item {
        display: flex;
        gap: 15px;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        transition: 0.2s;
        cursor: pointer;
    }

    .alert-item:hover {
        background: #f8fafc;
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
        color: var(--text-sub);
    }

    .modal-footer {
        padding: 12px;
        text-align: center;
        background: #fdfdfd;
    }

    .view-all {
        font-size: 13px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
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

    .logo-img {
        max-height: 145px;
        object-fit: contain;
        display: block;
        transform: rotate(45deg);
        margin-left: 20px;
        margin-top: -7px;
    }

    .nav-text {}

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
    <!-- <div class="nav-actions">
        <a href="/buyercart" class="nav-item">
            <img src="/upload/shopping-cart1.png" alt="Cart" style="width: 20px; height: 20px;">
        </a>
        <a href="#" class="nav-item" id="alertsBtn">
            <i class="far fa-bell"></i>
        </a>
      
        <button onclick="openLoginModal()" class="nav-btn signin-btn">Sign In</button>
    </div> -->
    <div class="nav-actions" id="headerNavActions">
    @if(Auth::check() || session()->has('human_name'))
        @php
           
            $displayName = session('human_name');
            if(!$displayName && Auth::check()) {
                $userFields = DB::table('humans')->where('id', Auth::id())->first();
                $displayName = $userFields ? ($userFields->first_name . ' ' . $userFields->last_name) : 'Buyer';
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
        <a href="/buyerdashboard" class="{{ Request::is('buyerdashboard*') ? 'active' : '' }}">
            <!-- <span class="nav-icon">🏠</span> -->
            <span class="material-symbols-outlined">home</span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="/buyerorders" class="{{ Request::is('buyerorders*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="nav-text">Orders</span>
        </a>
        <a href="/buyerpayment" class="{{ Request::is('buyerpayment*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">payment</span>
            <span class="nav-text">Payment Details</span>
        </a>
        <a href="/buyerprofile" class="{{ Request::is('buyerprofile') ? 'active' : '' }}">
            <span class="material-symbols-outlined">person</span>
            <span class="nav-text">Profile</span>
        </a>
        <a href="/buyersetting" class="{{ Request::is('buyersetting') ? 'active' : '' }}">
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
            <span class="close-modal">&times;</span>
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
                    <p class="alert-text">Your order <strong>#CB12345</strong> has been shipped!</p>
                    <span class="alert-time">2 hours ago</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="view-all">Mark all as read</a>
        </div>
    </div>
</div>

 
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en', 
        includedLanguages: 'en,si,ta', 
        autoDisplay: false
    }, 'google_translate_element');

     
    setTimeout(function() {
        let currentLang = google.translate.TranslateElement.getInstance().a || 'en';
        let customSelect = document.getElementById('custom_language_selector');
        if(customSelect) {
            customSelect.value = currentLang;
        }
    }, 500);
}

function changeLanguage(langCode) {
    var googleSelect = document.querySelector('.goog-te-combo');
    if (googleSelect) {
        googleSelect.value = langCode;
        googleSelect.dispatchEvent(new Event('change'));
    }
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<div id="google_translate_element" style="display: none !important;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertsBtn = document.getElementById('alertsBtn');
        const modal = document.getElementById('alertsModal');
        const closeBtn = document.querySelector('.close-modal');

        alertsBtn.addEventListener('click', function (e) {
            e.preventDefault();
            modal.style.display = 'block';
        });

        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function (e) {
            if (e.target == modal) {
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