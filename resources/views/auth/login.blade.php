@extends('layouts.app')

@section('title', 'Login — GOS MOMO')

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
    max-width: 440px;
    margin: auto;
}
.auth-logo { font-family: 'Outfit',sans-serif; font-weight: 800; font-size: 2rem; color: #FF7A00; }
.auth-logo span { color: #FF7A00; }
.phone-input-group .input-group-text {
    background: #FF7A00; color: white; border: none; border-radius: 12px 0 0 12px; font-weight: 600;
}
.form-control-gos {
    border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px;
    font-family: 'Poppins',sans-serif; font-size: 15px; transition: all 0.3s ease;
}
.form-control-gos:focus {
    border-color: #FF7A00; box-shadow: 0 0 0 3px rgba(15,81,50,0.1); outline: none;
}
.otp-input { letter-spacing: 8px; font-size: 24px; font-weight: 700; text-align: center; }
.btn-otp {
    background: linear-gradient(135deg, #FF7A00, #E26C00);
    color: white; border: none; border-radius: 8px; padding: 12px;
    font-weight: 700; font-size: 16px; width: 100%; cursor: pointer;
    transition: all 0.3s ease;
}
.btn, .tab-auth .nav-link, .form-control-gos, .phone-input-group .input-group-text, #phone-input, #password-field, .btn-outline-secondary {
    border-radius: 8px !important;
}
.btn-otp:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15,81,50,0.3); }
.btn-otp:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.tab-auth .nav-link { border-radius: 12px; font-weight: 600; color: #6C757D; padding: 10px 20px; }
.tab-auth .nav-link.active { background: #FF7A00; color: white; }
.divider { display: flex; align-items: center; gap: 12px; color: #adb5bd; font-size: 13px; margin: 20px 0; }
.divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e9ecef; }
.otp-timer { font-size: 13px; color: #6C757D; }
.otp-timer .countdown { color: #FF7A00; font-weight: 700; }
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
            <p class="text-muted mt-1 mb-0">Welcome back! Please login to continue.</p>
        </div>

        {{-- Auth Tabs --}}
        <ul class="nav nav-pills tab-auth mb-4 p-1" style="background: #f8f9fa; border-radius: 14px;" id="authTab">
            <li class="nav-item flex-fill">
                <button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#otp-tab">
                    <i class="bi bi-phone me-1"></i> OTP Login
                </button>
            </li>
            <li class="nav-item flex-fill">
                <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#email-tab">
                    <i class="bi bi-envelope me-1"></i> Email Login
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- OTP LOGIN --}}
            <div class="tab-pane fade show active" id="otp-tab">

                {{-- Step 1: Enter Email --}}
                <div id="step-email">
                    <p class="text-muted small mb-3">Enter your registered email address to receive an OTP.</p>
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-orange text-white" style="border: none; border-radius: 8px 0 0 8px; background-color: #FF7A00;"><i class="bi bi-envelope-fill text-white"></i></span>
                        <input type="email" id="email-input" class="form-control form-control-gos" placeholder="yourname@example.com" style="border-radius: 0 8px 8px 0 !important;">
                    </div>
                    <button class="btn-otp" id="send-otp-btn">
                        <i class="bi bi-shield-lock me-1"></i> Send OTP
                    </button>
                    <p class="text-center text-muted small mt-3">By continuing, you agree to our <a href="#" class="text-success">Terms of Service</a></p>
                </div>

                {{-- Step 2: Enter OTP --}}
                <div id="step-otp" class="d-none">
                    <div class="text-center mb-3">
                        <i class="bi bi-shield-check fs-1 text-success d-block mb-2"></i>
                        <h5 class="fw-bold">Enter OTP</h5>
                        <p class="text-muted small">6-digit OTP sent to <span id="otp-email-display" class="fw-semibold text-dark"></span></p>
                    </div>
                    <input type="tel" id="otp-input" class="form-control form-control-gos otp-input mb-4" placeholder="••••••" maxlength="6">
                    <button class="btn-otp" id="verify-otp-btn">
                        <i class="bi bi-check-circle me-1"></i> Verify & Login
                    </button>
                    <div class="text-center mt-3 otp-timer">
                        <span id="otp-timer-display">Resend OTP in <span class="countdown" id="countdown">60</span>s</span>
                        <a href="#" id="resend-otp-btn" class="text-success fw-bold d-none">Resend OTP</a>
                    </div>
                    <div class="text-center mt-2">
                        <a href="#" id="change-email-btn" class="text-muted small">← Change email</a>
                    </div>
                </div>
            </div>

            {{-- EMAIL LOGIN --}}
            <div class="tab-pane fade" id="email-tab">
                <form method="POST" action="{{ route('login.password') }}">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 small mb-3">{{ $errors->first() }}</div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-gos" placeholder="admin@gosmomo.com" value="{{ old('email') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password-field" class="form-control form-control-gos" placeholder="••••••••" style="border-radius:12px 0 0 12px;">
                            <button class="btn btn-outline-secondary" type="button" style="border-radius:0 12px 12px 0; border: 2px solid #e9ecef;" onclick="togglePassword()">
                                <i class="bi bi-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn-otp">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                    
                    <div class="mt-3 bg-light border p-3 rounded-3">
                        <div class="fw-bold mb-2 small text-muted text-start"><i class="bi bi-shield-lock-fill text-orange"></i> Quick Demo Logins:</div>
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-xs btn-outline-dark w-100 py-1" onclick="fillCustomerCreds('delivery@gosmomo.com', 'delivery123')" style="font-size: 11px; font-weight: 600;">
                                    Delivery Boy
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-xs btn-outline-dark w-100 py-1" onclick="fillCustomerCreds('customer@gosmomo.com', 'customer123')" style="font-size: 11px; font-weight: 600;">
                                    Demo Customer
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-muted small mt-3 mb-0">Admin/staff/partner accounts use email login.</p>
                </form>
            </div>
        </div>



        <div class="text-center mt-3">
            <p class="small text-muted mb-2">Don't have a customer account? <a href="{{ route('register') }}" class="text-orange fw-bold text-decoration-none" style="color:#FF7A00;">Register Here</a></p>
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
    let countdownTimer;
    let currentEmail = '';

    // Send OTP
    $('#send-otp-btn').on('click', function() {
        const email = $('#email-input').val().trim();
        if (email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError('Please enter a valid email address.');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Sending...');

        $.ajax({
            url: "{{ route('login.otp.send') }}",
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", email: email },
            success: function(res) {
                if (res.success) {
                    currentEmail = email;
                    $('#step-email').addClass('d-none');
                    $('#step-otp').removeClass('d-none');
                    $('#otp-email-display').text(email);
                    startCountdown();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bi bi-shield-lock me-1"></i> Send OTP');
                showError(xhr.responseJSON?.message || 'Failed to send OTP. Try again.');
            }
        });
    });

    // Verify OTP
    $('#verify-otp-btn').on('click', function() {
        const otp = $('#otp-input').val().trim();
        if (otp.length !== 6) {
            showError('Please enter the 6-digit OTP.');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Verifying...');

        $.ajax({
            url: "{{ route('login.otp.verify') }}",
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", email: currentEmail, otp: otp },
            success: function(res) {
                if (res.success) {
                    btn.html('<i class="bi bi-check-circle me-1"></i> Login successful!');
                    window.location.href = res.redirect;
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Verify & Login');
                showError(xhr.responseJSON?.message || 'Invalid OTP. Please try again.');
            }
        });
    });

    // Change email
    $('#change-email-btn').on('click', function(e) {
        e.preventDefault();
        clearInterval(countdownTimer);
        $('#step-otp').addClass('d-none');
        $('#step-email').removeClass('d-none');
        $('#send-otp-btn').prop('disabled', false).html('<i class="bi bi-shield-lock me-1"></i> Send OTP');
    });

    // Resend OTP
    $('#resend-otp-btn').on('click', function(e) {
        e.preventDefault();
        $('#send-otp-btn').trigger('click');
        $('#step-otp').addClass('d-none');
        $('#step-email').removeClass('d-none');
    });

    function startCountdown() {
        let seconds = 60;
        $('#countdown').text(seconds);
        $('#otp-timer-display').show();
        $('#resend-otp-btn').addClass('d-none');

        clearInterval(countdownTimer);
        countdownTimer = setInterval(function() {
            seconds--;
            $('#countdown').text(seconds);
            if (seconds <= 0) {
                clearInterval(countdownTimer);
                $('#otp-timer-display').hide();
                $('#resend-otp-btn').removeClass('d-none');
            }
        }, 1000);
    }

    function showError(msg) {
        const alert = $('<div class="alert alert-danger rounded-3 small mb-3 py-2">').text(msg);
        alert.insertBefore('#step-phone, #step-otp').filter(':visible').first();
        setTimeout(() => alert.fadeOut(400, () => alert.remove()), 4000);
    }

    // Password toggle
    window.togglePassword = function() {
        const field = $('#password-field');
        const icon = $('#eye-icon');
        if (field.attr('type') === 'password') {
            field.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            field.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    };

    // Quick Demo helper
    window.fillCustomerCreds = function(email, password) {
        $('#email-tab input[name="email"]').val(email);
        $('#email-tab input[name="password"]').val(password);
        
        // Brief border glow effect
        $('#email-tab input[name="email"]').css('border-color', '#FF7A00');
        $('#email-tab input[name="password"]').css('border-color', '#FF7A00');
        setTimeout(() => {
            $('#email-tab input[name="email"]').css('border-color', '');
            $('#email-tab input[name="password"]').css('border-color', '');
        }, 800);

        // Switch to the email tab
        const emailTab = new bootstrap.Tab(document.querySelector('#authTab li:last-child button'));
        emailTab.show();
    };
});
</script>
@endsection
