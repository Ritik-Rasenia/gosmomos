<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Admin Login — Control Center</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #0F5132;
            --primary-dark: #072e1c;
            --accent: #D4A017;
            --bg-dark: #05190f;
            --text-muted: #8fa89b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at 10% 20%, var(--primary-dark) 0%, var(--bg-dark) 90%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Abstract background glows */
        .glow-orb {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(15, 81, 50, 0.4) 0%, rgba(5, 25, 15, 0) 70%);
            filter: blur(50px);
            z-index: -1;
            pointer-events: none;
            animation: floating 8s ease-in-out infinite alternate;
        }

        .orb-1 { top: -100px; right: -50px; }
        .orb-2 { bottom: -150px; left: -100px; animation-delay: -3s; }

        @keyframes floating {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(30px) scale(1.1); }
        }

        /* Glassmorphism Card */
        .login-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            z-index: 10;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 25px 60px rgba(15, 81, 50, 0.25);
        }

        /* Typography */
        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .brand-title span {
            color: var(--accent);
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Form Controls */
        .form-label {
            color: #d1e7dd;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .input-group-custom:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(212, 160, 23, 0.15);
            background: rgba(255, 255, 255, 0.08);
        }

        .input-icon {
            padding: 12px 15px;
            color: var(--accent);
            font-size: 18px;
        }

        .form-control-custom {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
            padding: 12px 10px 12px 0;
            font-size: 15px;
            width: 100%;
        }

        .form-control-custom::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .form-control-custom:focus {
            outline: none;
            box-shadow: none;
        }

        .password-toggle-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 12px 15px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #ffffff;
        }

        /* Checkbox */
        .form-check-label {
            color: #d1e7dd;
            font-size: 13.5px;
            cursor: pointer;
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        /* Buttons */
        .btn-login {
            background: linear-gradient(135deg, var(--accent) 0%, #b8860b 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 16px;
            color: #000000;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 160, 23, 0.35);
            background: linear-gradient(135deg, #e3ad1e 0%, #c5910d 100%);
            color: #000000;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Demo login section */
        .demo-panel {
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 18px;
            margin-top: 30px;
            text-align: left;
        }

        .demo-panel-title {
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 11px;
            font-weight: 500;
            padding: 6px 12px;
            transition: all 0.2s ease;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .demo-btn:hover {
            background: rgba(212, 160, 23, 0.1);
            border-color: rgba(212, 160, 23, 0.3);
            color: #ffffff;
        }

        /* Custom Alert */
        .alert-custom {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            color: #f8d7da;
            border-radius: 12px;
            font-size: 13.5px;
            padding: 12px 16px;
        }

        .alert-success-custom {
            background: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.2);
            color: #d1e7dd;
            border-radius: 12px;
            font-size: 13.5px;
            padding: 12px 16px;
        }

        /* Footer link */
        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
            margin-top: 25px;
        }

        .back-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Glow Orbs -->
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>

    <div class="login-card text-center">
        <!-- Logo -->
        <div class="mb-2">
            <h1 class="brand-title">GOS <span>MOMO</span></h1>
            <p class="subtitle">Admin Control Center</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success-custom text-start mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-custom text-start mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}" id="login-form">
            @csrf
            
            <!-- Email -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group-custom">
                    <span class="input-icon"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control-custom" placeholder="admin@gosmomo.com" required value="{{ old('email') }}">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4 text-start">
                <label for="password" class="form-label">Password</label>
                <div class="input-group-custom">
                    <span class="input-icon"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control-custom" placeholder="••••••••" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Keep me logged in
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login" id="submit-btn">
                <span class="btn-text">Authenticate</span>
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
        </form>

        <!-- Quick Demo Accounts -->
        <div class="demo-panel">
            <div class="demo-panel-title">
                <i class="bi bi-shield-lock-fill"></i> Quick Demo Login
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <button type="button" class="demo-btn" onclick="fillCredentials('admin@gosmomo.com', 'admin123')">
                        <span>Super Admin</span>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="demo-btn" onclick="fillCredentials('manager@gosmomo.com', 'manager123')">
                        <span>Store Manager</span>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Back to Website -->
        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left me-2"></i> Back to main website
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // Fill credentials helper
        function fillCredentials(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            // Highlight inputs with a quick transition effect
            emailInput.closest('.input-group-custom').style.borderColor = '#D4A017';
            passwordInput.closest('.input-group-custom').style.borderColor = '#D4A017';
            
            emailInput.value = email;
            passwordInput.value = password;
            
            setTimeout(() => {
                emailInput.closest('.input-group-custom').style.borderColor = '';
                passwordInput.closest('.input-group-custom').style.borderColor = '';
            }, 600);
        }

        // Show loading spinner on form submit
        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            const btnText = btn.querySelector('.btn-text');
            const spinner = btn.querySelector('.spinner-border');
            
            btn.disabled = true;
            btnText.textContent = 'Authenticating...';
            spinner.classList.remove('d-none');
        });
    </script>
</body>
</html>
