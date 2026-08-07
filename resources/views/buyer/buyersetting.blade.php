@extends('buyer.layouts.master')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Settings</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #071835;
            --primary-hover: #0b2552;
            --bg-color: #f4f7fe;
            --sidebar-width: 260px;
            --header-height: 70px;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            
            /* 2FA Design Tokens */
            --ink: #10221c;
            --paper: #f6f4ee;
            --accent: #1f6f54;
            --accent-soft: #e3f3ec;
            --line: #d8d3c5;
            --error: #c0392b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
        }

        .breadcrumb {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
            margin-left: 160px;
            margin-top: 40px;
        }

        .breadcrumb span {
            margin-right: 5px;
        }

        .breadcrumb .arrow {
            color: #aaa;
        }

        .breadcrumb .active {
            color: #000;
            font-weight: bold;
        }

        .content-area {
            padding: 40px;
            min-height: calc(100vh - var(--header-height));
            box-sizing: border-box;
            margin-left: 118px;
            margin-top: 24px;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            max-width: 920px;
        }

        .card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            width: 416px;
            min-height: 370px;
            box-sizing: border-box;
            margin-bottom: 24px;
        }

        .card.full-width {
            grid-column: span 2;
            width: 888px;
            min-height: auto;
        }

        .card h3 {
            font-size: 1.1rem;
            margin-top: 0;
            margin-bottom: 20px;
            color: #334155;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
        }

        input[type="password"], input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px 40px 10px 12px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-family: inherit;
            background-color: #fff;
            color: var(--text-main);
        }

        select {
            padding-right: 12px;
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }

        input[type="password"]:focus, input[type="text"]:focus, input[type="email"]:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(7, 24, 53, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 38px;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.2s;
        }
        
        .password-toggle:hover {
            color: var(--text-main);
        }

        .form-helper {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        button {
            width: 100%;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: auto;
            transition: background 0.2s ease;
        }

        button:hover {
            background: var(--primary-hover);
        }

        button.btn-danger {
            background: var(--danger-color);
            width: auto;
            padding: 10px 20px;
        }
        
        button.btn-danger:hover {
            background: var(--danger-hover);
        }

        .toggle-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .toggle-group:last-of-type {
            border-bottom: none;
        }

        .switch {
            position: relative;
            width: 44px;
            height: 22px;
            margin-bottom: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(22px);
        }

        
        .session-list {
            margin-top: 10px;
        }
        
        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        
        .session-item:last-child {
            border-bottom: none;
        }
        
        .session-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .session-info i {
            font-size: 18px;
            color: var(--text-muted);
        }
        
        .session-details .device {
            font-weight: 500;
            color: var(--text-main);
        }
        
        .session-details .location {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .btn-logout-session {
            background: transparent;
            color: var(--danger-color);
            padding: 4px 8px;
            font-size: 12px;
            width: auto;
            margin-top: 0;
            border: 1px solid transparent;
        }
        
        .btn-logout-session:hover {
            background: #fef2f2;
            border-radius: 6px;
        }

        /* Danger Zone Layout */
        .danger-zone-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .danger-zone-text .title {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        
        .danger-zone-text .desc {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

       
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 20, 16, 0.55);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
            animation: fade .2s ease;
        }

        @keyframes fade { from { opacity: 0 } to { opacity: 1 } }

        
        .modal-content {
            position: relative;
            width: min(400px, 90vw);
            background: var(--paper);
            border-radius: 14px;
            padding: 36px 28px 28px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            transform: translateY(10px) scale(.97);
            animation: pop .25s cubic-bezier(.2,.9,.3,1.2) forwards;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        @keyframes pop { to { transform: translateY(0) scale(1) } }

        .close-btn {
            position: absolute;
            top: 14px;
            right: 16px;
            font-size: 20px;
            line-height: 1;
            color: #8a8a78;
            cursor: pointer;
            transition: color .15s;
        }
        
        .close-btn:hover { color: var(--ink); }

        .icon-wrap {
            width: 56px;
            height: 56px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: var(--accent-soft);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .icon-wrap svg { width: 26px; height: 26px; }

        h2 {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.01em;
        }
        
        p {
            margin: 0 0 22px;
            font-size: 14.5px;
            line-height: 1.55;
            color: #52584f;
        }
        
        p .em {
            color: var(--ink);
            font-weight: 600;
        }

        .field-error {
            text-align: left;
            color: var(--error);
            font-size: 12.5px;
            margin: 0 0 14px;
            min-height: 16px;
        }

        
        .otp-row {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-bottom: 8px;
        }
        
        .otp-row input {
            width: 42px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            border: 1px solid var(--line);
            border-radius: 9px;
            background: #fff;
            color: var(--ink);
            padding: 0;
        }
        
        .otp-row input:focus {
            outline: 2px solid var(--accent);
            outline-offset: 1px;
        }

        .resend-row {
            font-size: 13px;
            color: #787f73;
            margin: 0 0 22px;
        }
        
        .resend-row button {
            background: none;
            border: none;
            color: var(--accent);
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-size: 13px;
            width: auto;
            display: inline;
        }
        
        .resend-row button:disabled {
            color: #a8ab9f;
            cursor: default;
        }

        .btn-confirm {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-radius: 9px;
            background: var(--accent);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, transform .1s;
        }
        
        .btn-confirm:hover { background: #185c45; }
        .btn-confirm:active { transform: scale(.98); }

        .step { display: none; }
        .step.active { display: block; }

        .demo-note {
            margin-top: 16px;
            padding: 10px 12px;
            background: #fff7e8;
            border: 1px solid #f0dca5;
            border-radius: 8px;
            font-size: 12.5px;
            color: #7a5d1c;
            text-align: left;
        }

        
        @media (max-width: 992px) {
            .settings-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .card, .card.full-width {
                width: 100%;
                height: auto;
                margin-left: 0;
            }
            .card.full-width {
                grid-column: span 1;
            }
            .content-area {
                margin-left: 56px;
                padding: 20px;
            }
            .breadcrumb {
                margin-left: 76px;
                margin-top: 20px;
            }
        }

        @media (prefers-reduced-motion: reduce){
            .modal.show, .modal-content { animation: none; }
        }
    </style>
</head>
<body>

    <div class="breadcrumb">
        <span>Home</span>
        <span class="arrow">></span>
        <span class="active">Settings</span>
    </div>

    <div class="content-area">
        <div class="settings-grid">

            <div class="card full-width">
                <h3>{{ __('Change Password') }}</h3>

                @if(session('success'))
                    <div style="background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('buyer.password.update') }}" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" id="current_password" placeholder="Enter your current password">
                        <i class="fa-regular fa-eye password-toggle" onclick="togglePassword('current_password', this)"></i>
                        @error('current_password')
                            <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" id="new_password" placeholder="Enter new password">
                        <i class="fa-regular fa-eye password-toggle" onclick="togglePassword('new_password', this)"></i>
                        <div class="form-helper">Must be at least 8 characters long with letters and numbers.</div>
                        @error('new_password')
                            <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat new password">
                        <i class="fa-regular fa-eye password-toggle" onclick="togglePassword('confirm_password', this)"></i>
                        @error('confirm_password')
                            <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit">Update Password</button>
                </form>
            </div>

            <div class="card">
                <h3>Notification Settings</h3>

                @if(session('success_notification'))
                    <div style="background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px; font-weight: 500;">
                        <i class="fa-solid fa-circle-check" style="color: #0f5132;"></i>
                        {{ session('success_notification') }}
                    </div>
                @endif

                <form action="{{ route('buyer.notifications.update') }}" method="POST">
                    @csrf
                    <div class="toggle-group">
                        <span>Email Notifications</span>
                        <label class="switch">
                            <input type="checkbox" name="email_notifications" value="1" 
                                {{ old('email_notifications', $notifications->email_notifications ?? false) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="toggle-group">
                        <span>SMS Alerts</span>
                        <label class="switch">
                            <input type="checkbox" name="sms_alerts" value="1" 
                                {{ old('sms_alerts', $notifications->sms_alerts ?? false) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="toggle-group">
                        <span>Order Updates</span>
                        <label class="switch">
                            <input type="checkbox" name="order_updates" value="1" 
                                {{ old('order_updates', $notifications->order_updates ?? false) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <button type="submit" style="margin-top:61px;">Save Preferences</button>
                </form>
            </div>
            
            <div class="card">
                <h3>{{ __('Language') }}</h3>

                @if(session('success_language'))
                    <div style="background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px; font-weight: 500;">
                        <i class="fa-solid fa-circle-check" style="color: #0f5132;"></i>
                        {{ session('success_language') }}
                    </div>
                @endif

                <div id="google_translate_element" style="display:none;"></div>

                <form action="{{ route('buyer.language.update') }}" method="POST" id="langForm" style="display: flex; flex-direction: column; height: 100%;">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Preferred Language') }}</label>
                        <select id="custom_language_selector" name="locale" onchange="submitLanguageForm(this.value)">
                            <option value="en" {{ session('locale', auth()->user()->language ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="si" {{ session('locale', auth()->user()->language ?? 'si') == 'si' ? 'selected' : '' }}>සිංහල</option>
                            <option value="ta" {{ session('locale', auth()->user()->language ?? 'ta') == 'ta' ? 'selected' : '' }}>தமிழ்</option>
                        </select>
                    </div>

                    <button type="submit" style="margin-bottom:25px;">{{ __('Save Regional Settings') }}</button>
                </form>
            </div>
                
            
            <div class="card full-width">
                <h3>Advanced Security</h3>

                <div class="toggle-group">
                    <div>
                        <div style="font-size: 14px; font-weight: 500;">Two-Factor Authentication (2FA)</div>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Secure your account with a code.</div>
                    </div>
                    

                       <label class="switch">
                        <input type="checkbox" id="twofa-toggle" 
                            @if(Auth::user()->twoFactorVerification && Auth::user()->twoFactorVerification->is_verified)  checked disabled  @endif >
                        <span class="slider"></span>
                    </label>

                </div>

                <div id="twofa-modal" class="modal">
                    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="twofa-title">
                        <span class="close-btn" id="close-modal" role="button" tabindex="0" aria-label="Close">&times;</span>

                        <div class="step active" id="step-email">
                            <div class="icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="#1f6f54" stroke-width="1.5"/>
                                    <path d="M4 7L12 13L20 7" stroke="#1f6f54" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2 id="twofa-title">Verify your email</h2>
                            <p>Enter the email address where you'd like to receive your verification codes.</p>
                            <input type="email" id="email-input" placeholder="you@example.com" autocomplete="email">
                            <p class="field-error" id="email-error"></p>
                            <button type="button" class="btn-confirm" id="btn-send-code">Send code</button>
                        </div>

                        <div class="step" id="step-otp">
                            <div class="icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect x="4" y="10" width="16" height="10" rx="2" stroke="#b6e2d3" stroke-width="1.5"/>
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3" stroke="#344255" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <h2>Enter the code</h2>
                            <p>We sent a 6-digit code to <span class="em" id="email-display"></span>.</p>
                            <div class="otp-row" id="otp-row">
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                            </div>
                            <p class="field-error" id="otp-error"></p>
                            <div class="resend-row">
                                Didn't get it? <button type="button" id="resend-btn">Resend code</button> <span id="resend-timer"></span>
                            </div>
                            <button type="button" class="btn-confirm" id="btn-verify">Verify</button>
                            <div class="demo-note" id="demo-note"></div>
                        </div>

                        <div class="step" id="step-pin">
                            <div class="icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="11" stroke="#1f6f54" stroke-width="1.5"/>
                                    <path d="M7 12.5L10.2 15.5L17 8.5" stroke="#1f6f54" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2>Set a PIN</h2>
                            <p>For added security, please set a 4-digit PIN to confirm your identity.</p>
                            <div class="otp-row" id="pin-row">
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                                <input type="text" inputmode="numeric" maxlength="1" />
                            </div>
                            <p class="field-error" id="pin-error">  </p>

                            <button type="button" class="btn-confirm" id="btn-pin">Done</button>
                        </div>

                         

                        <div class="step" id="step-success">
                            <div class="icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="11" stroke="#1f6f54" stroke-width="1.5"/>
                                    <path d="M7 12.5L10.2 15.5L17 8.5" stroke="#1f6f54" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2>2FA enabled</h2>
                            <p>Email verification is now active. Your account has an extra layer of protection.</p>
                            <button type="button" class="btn-confirm" id="btn-done">Awesome</button>
                        </div>
                    </div>
                </div>

                </div>  

 


             <div class="card full-width">
            <h3 style="color: var(--danger-color);">Danger Zone</h3>
            <div class="danger-zone-content">
                <div class="danger-zone-text">
            <div class="title">Delete Account</div>
            <div class="desc">Once you delete your account, all of your data, orders, and preferences will be permanently removed.</div>
        </div>
        <button type="button" id="deleteBtn" class="btn-danger">Delete Account</button>
    </div>
        </div>
    </div>

<script>

    document.getElementById('deleteBtn').addEventListener('click', function() {
    if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        
      
        const csrfToken = document.querySelector('input[name="_token"]')?.value 
                          || '{{ csrf_token() }}';
        
        
        fetch('{{ url("buyer/delete-account") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken 
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert("Your account has been deleted successfully.");
                

                
                   window.location.href = '{{ url("/logout") }}';
               
            } else {
                alert(data.message || "Something went wrong. Please try again.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred. Please try again.");
        });
    }
});
</script>

    <script type="text/javascript">
         function submitLanguageForm(langCode) {
            let googleSelect = document.querySelector('.goog-te-combo');
            
            if (langCode === 'en') {
                let domain = window.location.hostname;
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + domain;
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + domain;
                
                if (googleSelect) {
                    googleSelect.value = 'en';
                    googleSelect.dispatchEvent(new Event('change'));
                }
            } else {
                if (googleSelect) {
                    googleSelect.value = langCode;
                    googleSelect.dispatchEvent(new Event('change'));
                }
            }
            
            setTimeout(function() {
                let form = document.getElementById('langForm');
                if (form) form.submit();
            }, 400); 
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en', 
                includedLanguages: 'en,si,ta', 
                autoDisplay: false
            }, 'google_translate_element');

            setTimeout(function() {
                let currentLang = "{{ session('locale', auth()->user()->language ?? 'en') }}";
                let googleSelect = document.querySelector('.goog-te-combo');
                
                if (googleSelect && currentLang !== 'en') {
                    googleSelect.value = currentLang;
                    googleSelect.dispatchEvent(new Event('change'));
                }
            }, 1000);
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        function togglePassword(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if($errors->has('current_password'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ $errors->first('current_password') }}",
                    confirmButtonColor: '#071835'  
                });

                const currentPwdInput = document.getElementById('current_password');
                if(currentPwdInput) {
                    currentPwdInput.style.borderColor = '#ef4444';
                    currentPwdInput.style.backgroundColor = '#fef2f2';
                }
            @endif
        });
    </script>

 



<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- 1. Core DOM Declarations ---
    const twofaToggle = document.getElementById('twofa-toggle');
    const twofaModal = document.getElementById('twofa-modal');
    const closeModal = document.getElementById('close-modal');
    
    // Step Containers
    const stepEmail = document.getElementById('step-email');
    const stepOtp = document.getElementById('step-otp');
    const stepPin = document.getElementById('step-pin');
    const stepSuccess = document.getElementById('step-success');

    // Navigational Buttons
    const btnSendCode = document.getElementById('btn-send-code');
    const btnVerify = document.getElementById('btn-verify');
    const btnPinSubmit = document.getElementById('btn-pin'); 
    const btnDone = document.getElementById('btn-done');
    const resendBtn = document.getElementById('resend-btn');

    // Inputs & Error Displays
    const emailInput = document.getElementById('email-input');
    const emailDisplay = document.getElementById('email-display');
    const emailError = document.getElementById('email-error');
    
    const otpError = document.getElementById('otp-error');
    const otpInputs = document.querySelectorAll('#otp-row input');
    
    const pinError = document.getElementById('pin-error');
    const pinInputs = document.querySelectorAll('#pin-row input');
    
    const resendTimer = document.getElementById('resend-timer');

    let timerInterval;

     
    if (twofaToggle) {
        fetch('/check-2fa-status')
            .then(res => res.json())
            .then(data => {
                if (data.enabled) {
                    twofaToggle.checked = true;
                    // twofaToggle.disabled = true;  
                }
            })
            .catch(err => console.error("Error checking 2FA status:", err));
    }

    // --- 2. Navigational Logic Functions ---
    function switchStep(toStep) {
        [stepEmail, stepOtp, stepPin, stepSuccess].forEach(step => {
            if (step) step.classList.remove('active');
        });
        if (toStep) {
            toStep.classList.add('active');
            const firstInput = toStep.querySelector('input');
            if (firstInput) firstInput.focus();
        }
    }

    function closeTwoFAModal() {
       
        if (!twofaToggle.disabled) {
            twofaToggle.checked = false; 
        }
        twofaModal.classList.remove('show');
        clearInterval(timerInterval);
        resetForm();
    }

    function resetForm() {
        emailInput.value = '';
        emailError.textContent = '';
        otpError.textContent = '';
        if (pinError) pinError.textContent = '';
        otpInputs.forEach(input => input.value = '');
        pinInputs.forEach(input => input.value = '');
    }

    // --- 3. Event Listeners (Window / Overlay) ---
    if (twofaToggle) {
        twofaToggle.addEventListener('change', function() {
            if (this.checked) {
                switchStep(stepEmail);
                twofaModal.classList.add('show');
                emailInput.value = "{{ auth()->user()->email ?? '' }}"; 
            }
        });
    }

    if (closeModal) closeModal.addEventListener('click', closeTwoFAModal);

    window.addEventListener('click', function(e) {
        if (e.target === twofaModal) {
            closeTwoFAModal();
        }
    });

    // --- 4. Step 1: Send OTP via AJAX ---
    if (btnSendCode) {
        btnSendCode.addEventListener('click', function() {
            const email = emailInput.value.trim();
            emailError.textContent = '';

            if (!email) {
                emailError.textContent = 'Please enter your email address.';
                return;
            }

            btnSendCode.disabled = true;
            btnSendCode.textContent = 'Sending...';

            fetch('/send-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                btnSendCode.disabled = false;
                btnSendCode.textContent = 'Send code';

                if (data.success) {
                    emailDisplay.textContent = email;
                    switchStep(stepOtp);
                    startResendTimer(60); 
                } else {
                    emailError.textContent = data.message || 'Something went wrong.';
                }
            })
            .catch(error => {
                btnSendCode.disabled = false;
                btnSendCode.textContent = 'Send code';
                emailError.textContent = 'Server error. Please try again later.';
            });
        });
    }

    // --- 5. OTP Matrix Sequence Interactivity ---
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            input.value = input.value.replace(/[^0-9]/g, ''); 
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus(); 
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace') {
                if (input.value.length === 0 && index > 0) {
                    otpInputs[index - 1].focus(); 
                    otpInputs[index - 1].value = '';
                }
            }
        });
    });

    // --- 6. Step 2: Verify OTP via AJAX ---
    if (btnVerify) {
        btnVerify.addEventListener('click', function() {
            otpError.textContent = '';
            let otpCode = '';
            
            otpInputs.forEach(input => otpCode += input.value);

            if (otpCode.length !== 6) {
                otpError.textContent = 'Please enter the full 6-digit code.';
                return;
            }

            btnVerify.disabled = true;
            btnVerify.textContent = 'Verifying...';

            fetch('/verify-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: emailInput.value.trim(),
                    otp: otpCode
                })
            })
            .then(response => response.json())
            .then(data => {
                btnVerify.disabled = false;
                btnVerify.textContent = 'Verify';

                if (data.success) {
                    clearInterval(timerInterval);
                    switchStep(stepPin); 
                } else {
                    otpError.textContent = data.message || 'Invalid verification code.';
                    otpInputs.forEach(input => input.value = '');
                    otpInputs[0].focus();
                }
            })
            .catch(error => {
                btnVerify.disabled = false;
                btnVerify.textContent = 'Verify';
                otpError.textContent = 'Server error. Please try again.';
            });
        });
    }

    // --- 7. Resend Utility System Timer ---
    if (resendBtn) {
        resendBtn.addEventListener('click', function() {
            resendBtn.disabled = true;
            otpError.textContent = '';
            
            fetch('/send-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: emailInput.value.trim() })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    startResendTimer(60);
                    otpInputs.forEach(input => input.value = '');
                    otpInputs[0].focus();
                } else {
                    otpError.textContent = data.message || 'Failed to resend code.';
                    resendBtn.disabled = false;
                }
            });
        });
    }

    function startResendTimer(seconds) {
        resendBtn.disabled = true;
        resendTimer.textContent = `(Resend in ${seconds}s)`;

        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(timerInterval);
                resendTimer.textContent = '';
                resendBtn.disabled = false;
            } else {
                resendTimer.textContent = `(Resend in ${seconds}s)`;
            }
        }, 1000);
    }

    // --- 8. PIN Matrix Sequence Interactivity ---
    pinInputs.forEach((input, index) => {
        input.addEventListener("input", (e) => {
            input.value = input.value.replace(/[^0-9]/g, "");
            if (input.value.length === 1 && index < pinInputs.length - 1) {
                pinInputs[index + 1].focus();  
            }
        });

        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace") {
                if (input.value.length === 0 && index > 0) {
                    pinInputs[index - 1].focus();  
                    pinInputs[index - 1].value = "";  
                }
            }
        });

        input.addEventListener("paste", (e) => {
            e.preventDefault();
            const pastedData = (e.clipboardData || window.clipboardData).getData("text");
            const digits = pastedData.replace(/[^0-9]/g, "").split("").slice(0, 4);

            digits.forEach((digit, i) => {
                if (pinInputs[i]) {
                    pinInputs[i].value = digit;
                    if (i < pinInputs.length - 1) pinInputs[i + 1].focus();
                }
            });
        });
    });

    // --- 9. Step 3: Save PIN Configuration ---
    if (btnPinSubmit) {
        btnPinSubmit.addEventListener("click", function () {
            let pinVal = "";
            if (pinError) pinError.textContent = "";  

            pinInputs.forEach(input => pinVal += input.value);

            if (pinVal.length < 4) {
                if (pinError) {
                    pinError.textContent = "Please enter a valid 4-digit PIN.";
                    pinError.style.color = "red";
                }
                return;
            }

            btnPinSubmit.disabled = true;

            fetch('/buyer-save-pin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pin: pinVal })
            })
            .then(res => res.json())
            .then(data => {
                btnPinSubmit.disabled = false;
                if (data.success) {
                    switchStep(stepSuccess); 
                } else {
                    if (pinError) pinError.textContent = data.message || "Failed to process encryption parameters.";
                }
            })
            .catch(error => {
                btnPinSubmit.disabled = false;
                if (pinError) pinError.textContent = 'Server processing failure. Please retry.';
            });
        });
    }

    // --- 10. Final Step: Success Dismissal Control ---
    if (btnDone) {
        btnDone.addEventListener('click', function() {
            twofaModal.classList.remove('show');
            
            
            if (twofaToggle) {
                twofaToggle.checked = true; 
                twofaToggle.disabled = true; 
            }
        });
    }
});
</script>


</body>
</html>
@endsection