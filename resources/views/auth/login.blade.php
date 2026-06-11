@extends('layouts.app')

@section('title', 'Login — GOS MOMO')

@section('styles')
<style>
.auth-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0a3620 0%, #0F5132 50%, #1a6b42 100%);
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
.auth-logo { font-family: 'Outfit',sans-serif; font-weight: 800; font-size: 2rem; color: #0F5132; }
.auth-logo span { color: #D4A017; }
.phone-input-group .input-group-text {
    background: #0F5132; color: white; border: none; border-radius: 12px 0 0 12px; font-weight: 600;
}
.form-control-gos {
    border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px;
    font-family: 'Poppins',sans-serif; font-size: 15px; transition: all 0.3s ease;
}
.form-control-gos:focus {
    border-color: #0F5132; box-shadow: 0 0 0 3px rgba(15,81,50,0.1); outline: none;
}
.otp-input { letter-spacing: 8px; font-size: 24px; font-weight: 700; text-align: center; }
.btn-otp {
    background: linear-gradient(135deg, #0F5132, #157347);
    color: white; border: none; border-radius: 12px; padding: 12px;
    font-weight: 700; font-size: 16px; width: 100%; cursor: pointer;
    transition: all 0.3s ease;
}
.btn-otp:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15,81,50,0.3); }
.btn-otp:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.tab-auth .nav-link { border-radius: 12px; font-weight: 600; color: #6C757D; padding: 10px 20px; }
.tab-auth .nav-link.active { background: #0F5132; color: white; }
.divider { display: flex; align-items: center; gap: 12px; color: #adb5bd; font-size: 13px; margin: 20px 0; }
.divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e9ecef; }
.otp-timer { font-size: 13px; color: #6C757D; }
.otp-timer .countdown { color: #0F5132; font-weight: 700; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="auth-logo text-decoration-none">GOS <span>MOMO</span></a>
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

                {{-- Step 1: Enter Phone --}}
                <div id="step-phone">
                    <p class="text-muted small mb-3">Enter your 10-digit mobile number to receive an OTP.</p>
                    <div class="input-group mb-4 phone-input-group">
                        <span class="input-group-text"><i class="bi bi-phone-fill me-1"></i> +91</span>
                        <input type="tel" id="phone-input" class="form-control form-control-gos" placeholder="98765 43210" maxlength="10" style="border-radius: 0 12px 12px 0;">
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
                        <p class="text-muted small">6-digit OTP sent to +91 <span id="otp-phone-display"></span><br><small class="text-warning">(For testing, use: <strong>123456</strong>)</small></p>
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
                        <a href="#" id="change-phone-btn" class="text-muted small">← Change number</a>
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
                    <p class="text-center text-muted small mt-3">Admin/staff accounts use email login.</p>
                </form>
            </div>
        </div>

        <div class="divider">or continue with</div>

        <div class="row g-3">
            <div class="col-6">
                <a href="#" class="btn btn-outline-secondary w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 14px;">
                    <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.79-.07-1.54-.19-2.27h-11.3v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z"/><path fill="#34A853" d="M12.255 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96h-3.98v3.09C3.515 21.3 7.615 24 12.255 24z"/><path fill="#FBBC05" d="M5.525 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.62h-3.98a11.86 11.86 0 000 10.76l3.98-3.09z"/><path fill="#EA4335" d="M12.255 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C18.205 1.19 15.495 0 12.255 0c-4.64 0-8.74 2.7-10.71 6.62l3.98 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/></svg>
                    Google
                </a>
            </div>
            <div class="col-6">
                <a href="#" class="btn btn-outline-secondary w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 14px;">
                    <i class="bi bi-facebook text-primary fs-5"></i> Facebook
                </a>
            </div>
        </div>

        <div class="text-center mt-4">
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
    let currentPhone = '';

    // Send OTP
    $('#send-otp-btn').on('click', function() {
        const phone = $('#phone-input').val().trim();
        if (phone.length !== 10 || !/^\d+$/.test(phone)) {
            showError('Please enter a valid 10-digit mobile number.');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Sending...');

        $.ajax({
            url: "{{ route('login.otp.send') }}",
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", phone: phone },
            success: function(res) {
                if (res.success) {
                    currentPhone = phone;
                    $('#step-phone').addClass('d-none');
                    $('#step-otp').removeClass('d-none');
                    $('#otp-phone-display').text(phone);
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
            data: { _token: "{{ csrf_token() }}", phone: currentPhone, otp: otp },
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

    // Change phone
    $('#change-phone-btn').on('click', function(e) {
        e.preventDefault();
        clearInterval(countdownTimer);
        $('#step-otp').addClass('d-none');
        $('#step-phone').removeClass('d-none');
        $('#send-otp-btn').prop('disabled', false).html('<i class="bi bi-shield-lock me-1"></i> Send OTP');
    });

    // Resend OTP
    $('#resend-otp-btn').on('click', function(e) {
        e.preventDefault();
        $('#send-otp-btn').trigger('click');
        $('#step-otp').addClass('d-none');
        $('#step-phone').removeClass('d-none');
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
});
</script>
@endsection
