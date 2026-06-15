@extends('layouts.app')

@section('title', 'Register — GOS MOMO')

@section('styles')
<style>
.auth-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0E101A 0%, #FF7A00 50%, #1a6b42 100%);
    display: flex;
    align-items: center;
    padding: 40px 16px;
}
.auth-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 30px 80px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 460px;
    margin: auto;
}
.auth-logo { font-family: 'Outfit',sans-serif; font-weight: 800; font-size: 2rem; color: #FF7A00; }
.auth-logo span { color: #FF7A00; }
.form-control-gos {
    border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px;
    font-family: 'Poppins',sans-serif; font-size: 15px; transition: all 0.3s ease;
}
.form-control-gos:focus {
    border-color: #FF7A00; box-shadow: 0 0 0 3px rgba(15,81,50,0.1); outline: none;
}
.btn-otp {
    background: linear-gradient(135deg, #FF7A00, #E26C00);
    color: white; border: none; border-radius: 8px; padding: 12px;
    font-weight: 700; font-size: 16px; width: 100%; cursor: pointer;
    transition: all 0.3s ease;
}
.btn, .form-control-gos, .btn-outline-secondary {
    border-radius: 8px !important;
}
.btn-otp:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15,81,50,0.3); }
.btn-otp:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="auth-logo text-decoration-none">
                @if(setting('logo'))
                    <img src="{{ asset(setting('logo')) }}" alt="{{ setting('site_name', 'GOS MOMO') }}" style="max-height: 100px; height: 100px; width: auto; object-fit: contain; margin-bottom: 10px;">
                @else
                    GOS <span>MOMO</span>
                @endif
            </a>
            <h4 class="fw-bold mt-2">Create Customer Account</h4>
            <p class="text-muted small">Sign up to place orders, track delivery, and manage wallet.</p>
        </div>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf
            
            @if($errors->any())
                <div class="alert alert-danger rounded-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-person-fill text-muted"></i></span>
                    <input type="text" name="name" class="form-control form-control-gos border-start-0" placeholder="John Doe" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope-fill text-muted"></i></span>
                    <input type="email" name="email" class="form-control form-control-gos border-start-0" placeholder="john.doe@example.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted">Mobile Number (10 digits)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-phone-fill text-muted"></i></span>
                    <input type="tel" name="phone" class="form-control form-control-gos border-start-0" placeholder="9876543210" maxlength="10" value="{{ old('phone') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock-fill text-muted"></i></span>
                    <input type="password" name="password" id="password-field" class="form-control form-control-gos border-start-0" placeholder="Choose a password" required>
                    <button class="btn btn-outline-secondary bg-light" type="button" style="border: 2px solid #e9ecef;" onclick="togglePassword('password-field', 'eye-icon')">
                        <i class="bi bi-eye text-muted" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small text-muted">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock-fill text-muted"></i></span>
                    <input type="password" name="password_confirmation" id="password-confirm-field" class="form-control form-control-gos border-start-0" placeholder="Confirm your password" required>
                    <button class="btn btn-outline-secondary bg-light" type="button" style="border: 2px solid #e9ecef;" onclick="togglePassword('password-confirm-field', 'eye-icon-confirm')">
                        <i class="bi bi-eye text-muted" id="eye-icon-confirm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-otp">
                <i class="bi bi-person-plus-fill me-1"></i> Register Account
            </button>
        </form>

        <div class="text-center mt-3">
            <p class="small text-muted mb-2">Already have an account? <a href="{{ route('login') }}" class="text-orange fw-bold text-decoration-none" style="color:#FF7A00;">Login Here</a></p>
            <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to Home
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    window.togglePassword = function(fieldId, iconId) {
        const field = $('#' + fieldId);
        const icon = $('#' + iconId);
        if (field.attr('type') === 'password') {
            field.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            field.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    };
});
</script>
@endsection
