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
            --primary: #FF7A00;
            --primary-dark: #E26C00;
            --accent: #FF7A00;
            --bg-navy: #0E101A;
            --text-muted: #6C757D;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAF9F6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Split Screen Panes */
        .login-left-pane {
            background: linear-gradient(135deg, rgba(14, 16, 26, 0.93) 0%, rgba(226, 108, 0, 0.8) 100%), url('https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 60px;
            height: 100vh;
        }

        .login-left-pane::before {
            content: '';
            position: absolute; 
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54 48c-2 0-3 1-4 2v4c0 1 1 2 2 2h4c1 0 2-1 2-2v-4c-1-1-2-2-4-2zM6 48c-2 0-3 1-4 2v4c0 1 1 2 2 2h4c1 0 2-1 2-2v-4c-1-1-2-2-4-2z' fill='%23ffffff' fill-opacity='0.02' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: 1;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            max-width: 500px;
            text-align: center;
        }

        .login-right-pane {
            background-color: #FAF9F6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            height: 100vh;
            overflow-y: auto;
        }

        .login-form-container {
            width: 100%;
            max-width: 420px;
            padding: 10px;
        }

        /* Form Controls */
        .form-label {
            color: #0E101A;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            background: #ffffff;
            border: 1.5px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .input-group-custom:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(255, 122, 0, 0.12);
        }

        .input-icon {
            padding: 12px 15px;
            color: var(--accent);
            font-size: 18px;
        }

        .form-control-custom {
            background: transparent !important;
            border: none !important;
            color: #0E101A !important;
            padding: 12px 10px 12px 0;
            font-size: 14.5px;
            width: 100%;
        }

        .form-control-custom::placeholder {
            color: rgba(0, 0, 0, 0.3);
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
            color: #0E101A;
        }

        /* Checkbox */
        .form-check-label {
            color: #333333;
            font-size: 13px;
            cursor: pointer;
        }

        .form-check-input {
            background-color: #ffffff;
            border-color: rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        /* Buttons */
        .btn-login {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-weight: 700;
            font-size: 15px;
            color: #ffffff;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.25);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 122, 0, 0.4);
            background: linear-gradient(135deg, #FF9F43 0%, var(--accent) 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Demo login section */
        .demo-panel {
            background: #ffffff;
            border: 1px dashed rgba(255, 122, 0, 0.3);
            border-radius: 16px;
            padding: 18px;
            margin-top: 30px;
            text-align: left;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        .demo-panel-title {
            color: var(--accent);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-btn {
            background: #F8F9FA;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            color: #333333;
            font-size: 11px;
            font-weight: 600;
            padding: 8px 12px;
            transition: all 0.2s ease;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .demo-btn:hover {
            background: rgba(255, 122, 0, 0.08);
            border-color: rgba(255, 122, 0, 0.3);
            color: var(--accent);
        }

        /* Custom Alert */
        .alert-custom {
            background: rgba(220, 53, 69, 0.08);
            border: 1px solid rgba(220, 53, 69, 0.2);
            color: #842029;
            border-radius: 12px;
            font-size: 13px;
            padding: 12px 16px;
        }

        .alert-success-custom {
            background: rgba(25, 135, 84, 0.08);
            border: 1px solid rgba(25, 135, 84, 0.2);
            color: #0f5132;
            border-radius: 12px;
            font-size: 13px;
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
            color: var(--accent);
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0 vh-100">
            
            <!-- Left Branding Pane (Hidden on mobile/tablet) -->
            <div class="col-lg-6 d-none d-lg-flex login-left-pane">
                <div class="login-left-content">
                    <div class="mb-4">
                        @if(setting('logo_dark'))
                            <img src="{{ asset(setting('logo_dark')) }}" alt="Logo" style="max-height: 120px; object-fit: contain;">
                        @elseif(setting('logo'))
                            <img src="{{ asset(setting('logo')) }}" alt="Logo" style="max-height: 120px; object-fit: contain;">
                        @else
                            <h1 class="text-white fw-bold display-4 mb-0" style="font-family: 'Outfit'; letter-spacing: 1px;">GOS <span style="color:var(--accent);">MOMO</span></h1>
                        @endif
                    </div>
                    
                    <h2 class="fw-bold font-outfit text-white mb-3" style="font-size: 2.2rem; letter-spacing: 0.5px;">Admin Control Center</h2>
                    <p class="text-white-75 mb-4 lh-lg" style="font-size: 14.5px;">Crafting the crunchiest, most delicious, and hygienic street-style momos in India. Manage catalog, orders, event leads, and franchise partners from one unified workspace.</p>
                    
                    <div class="d-flex justify-content-center gap-5 text-white-50 mt-5 pt-3">
                        <div class="text-center">
                            <h4 class="fw-bold text-white mb-0">100%</h4>
                            <span class="small" style="font-size:11px; text-transform: uppercase; letter-spacing: 0.5px;">Secured Gateway</span>
                        </div>
                        <div class="border-end border-white-10" style="height: 35px; width: 1px; background: rgba(255,255,255,0.15);"></div>
                        <div class="text-center">
                            <h4 class="fw-bold text-white mb-0">Unified</h4>
                            <span class="small" style="font-size:11px; text-transform: uppercase; letter-spacing: 0.5px;">Workspace</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Login Form Pane -->
            <div class="col-lg-6 col-12 login-right-pane">
                <div class="login-form-container">
                    
                    <!-- Mobile Logo Branding Header -->
                    <div class="d-lg-none text-center mb-4">
                        @if(setting('logo'))
                            <img src="{{ asset(setting('logo')) }}" alt="Logo" style="max-height: 70px; object-fit: contain;" class="mb-2">
                        @else
                            <h2 class="fw-bold font-outfit text-dark mb-0">GOS <span class="text-orange" style="color:var(--accent);">MOMO</span></h2>
                        @endif
                        <h5 class="fw-bold font-outfit text-muted mt-2" style="font-size: 15px;">Admin Control Center</h5>
                    </div>

                    <!-- Desktop Form Header -->
                    <div class="mb-4 d-none d-lg-block">
                        <h3 class="fw-bold text-dark font-outfit mb-2" style="font-size: 1.8rem;">Access Control</h3>
                        <p class="text-muted small">Please authenticate using your credentials to access the workspace.</p>
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

                    <!-- Authentication Form -->
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

                    <!-- Quick Demo Accounts Panel -->
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
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="back-link">
                            <i class="bi bi-arrow-left me-2"></i> Back to main website
                        </a>
                    </div>
                </div>
            </div>

        </div>
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
            
            emailInput.closest('.input-group-custom').style.borderColor = '#FF7A00';
            passwordInput.closest('.input-group-custom').style.borderColor = '#FF7A00';
            
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