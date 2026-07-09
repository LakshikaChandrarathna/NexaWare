@extends('seller.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@push('css')
<style>
   
    .content-area {
        padding: 2.5rem 1.5rem;
        background-color: #f8f9fc;
        min-height: 100vh;
    }
    
    
    .settings-card {
        background: #ffffff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
        padding: 2.25rem;
        height: 100%;
       
    }

    .settings-card h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #3a3b45;
        margin-bottom: 1.75rem;
        border-bottom: 1px solid #e3e6f0;
        padding-bottom: 0.85rem;
    }

    .settings-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
    }

    
    .form-label-custom {
        font-weight: 600;
        color: #4e73df;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

   
    .custom-input-group {
        position: relative;
        display: flex;
        align-items: stretch;
        width: 100%;
    }

    .form-control-custom {
        border-radius: 8px 0 0 8px !important;
        border: 1px solid #d1d3e2;
        border-right: none;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        background-color: #ffffff;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    
    .custom-input-group:focus-within .form-control-custom {
        border-color: #bac8f3;
        box-shadow: -0.2rem 0.2rem 0.2rem 0 rgba(78, 115, 223, 0.08);
    }
    
    .custom-input-group:focus-within .password-toggle-btn {
        border-color: #bac8f3;
        box-shadow: 0.2rem 0.2rem 0.2rem 0 rgba(78, 115, 223, 0.08);
    }

    
    .password-toggle-btn {
        background-color: #ffffff;
        border: 1px solid #d1d3e2;
        border-left: none;
        border-radius: 0 8px 8px 0 !important;
        padding: 0 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #858796;
        cursor: pointer;
        transition: color 0.2s ease, border-color 0.15s ease-in-out;
    }

    .password-toggle-btn:hover {
        color: #4e73df;
        background-color: #f8f9fc;
    }

    .form-helper {
        font-size: 0.75rem;
        color: #858796;
        margin-top: 6px;
    }

   
    .btn-update {
        background-color: #4e73df;
        border: none;
        color: white;
        border-radius: 8px;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        transition: background-color 0.2s ease;
    }

    .btn-update:hover {
        background-color: #2e59d9;
    }

    
    .status-card {
        border-left: 5px solid #1cc88a !important;
    }
    
    .status-badge {
        font-size: 0.85rem;
        padding: 0.5em 1.2em;
        border-radius: 30px;
    }
    .card  {
            grid-column: span 2;
            width: 550px;
            min-height: auto;
        }
</style>
@endpush

@section('content')
<div class="content-area">
    <div class="container-fluid">
        <div class="row g-4 justify-content-center">
            
            <div class="card" >
                <div class="settings-card" style="background-color:white; padding:20px;">
                    <h3>{{ __('Change Password') }}</h3>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('seller.password.update') }}" method="POST">
                        @csrf 
                        
                        <div class="mb-4">
                            <label class="form-label form-label-custom">Current Password</label>
                            <div class="custom-input-group">
                                <input type="password" name="current_password" id="current_password" class="form-control form-control-custom" placeholder="Enter your current password">
                                <span class="password-toggle-btn">
                                    <i class="fa-regular fa-eye" style="margin-left: 95%; margin-top: -46px;"></i>
                                </span>
                            
                                       
                            </div>
                             @error('current_password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label form-label-custom">New Password</label>
                            <div class="custom-input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control form-control-custom" placeholder="Enter new password">
                                <span class="password-toggle-btn">
                                    <i class="fa-regular fa-eye" style="margin-left: 95% ;margin-top: -46px;"></i>
                                </span>
                            </div>
                           
                        </div>
                         <div class="form-helper"><i class="fa-solid fa-circle-info me-1"></i> Must be at least 8 characters long with letters and numbers.</div>
                            @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror





                        <div class="mb-4">
                            <label class="form-label form-label-custom">Confirm Password</label>
                            <div class="custom-input-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-custom" placeholder="Repeat new password">
                                <span class="password-toggle-btn">
                                    <i class="fa-regular fa-eye" style="margin-left:95%;margin-top: -46px;"></i>
                                </span>
                            </div>

                           
                        </div>
                            @error('confirm_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror


div class="mt-4">
                            <button type="submit" class="btn-update w-100 shadow-sm" style="background-color: #191c31;
                                     color: white;height: 40px;">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" >
                <div class="settings-card status-card" style="background-color:white; padding:20px;" >
                    <h5 class="text-success">Store Status</h5>
                    <p class="text-muted small mb-4">Your store is currently verified and visible to customers.</p>
                    <span class="badge bg-success text-white status-badge shadow-sm">Active</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButtons = document.querySelectorAll('.password-toggle-btn');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const container = this.closest('.custom-input-group');
                const passwordInput = container.querySelector('input');
                const iconElement = this.querySelector('i');

                if (passwordInput && iconElement) {
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        iconElement.className = 'fa-regular fa-eye-slash';  
                    } else {
                        passwordInput.type = "password";
                        iconElement.className = 'fa-regular fa-eye';
                    }
                }
            });
        });

        @if($errors->has('current_password'))
            const currentPwdInput = document.getElementById('current_password');
            if(currentPwdInput) {
                currentPwdInput.style.borderColor = '#ef4444';
                currentPwdInput.style.backgroundColor = '#fef2f2';
            }
        @endif
    });
</script>

