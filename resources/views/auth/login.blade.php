<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giriş Yap - Green Case</title>
    
    @vite(['resources/scss/app.scss', 'resources/scss/pages/login.scss'])
</head>
<body class="login-page">

    <!-- Background Gradient -->
    <div class="login-background"></div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            
            <!-- Logo & Header -->
            <div class="login-header">
                <div class="logo-circle">
                    <i class="bi bi-building-fill-gear"></i>
                </div>
                <h1 class="login-title">GREEN CASE</h1>
                <p class="login-subtitle">Müşteri Yönetim Sistemi</p>
            </div>

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="login-form">
                @csrf

                <!-- Email Input -->
                <div class="form-floating mb-3">
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           placeholder="E-Posta" 
                           required 
                           autofocus
                           value="{{ old('email') }}">
                    <label for="email">
                        <i class="bi bi-envelope-fill me-2"></i>E-Posta Adresi
                    </label>
                </div>

                <!-- Password Input -->
                <div class="form-floating mb-3 password-wrapper">
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           placeholder="Şifre" 
                           required>
                    <label for="password">
                        <i class="bi bi-lock-fill me-2"></i>Şifre
                    </label>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Beni Hatırla
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success btn-lg w-100 login-btn" id="loginButton">
                    <span class="btn-text">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Giriş Yap
                    </span>
                    <span class="btn-loader d-none">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Giriş Yapılıyor...
                    </span>
                </button>
            </form>

            <!-- Test Accounts Info -->
            <div class="test-accounts">
                <p class="text-center text-muted mb-2">
                    <small><i class="bi bi-info-circle me-1"></i>Test Hesapları</small>
                </p>
                <div class="accounts-grid">
                    <div class="account-badge admin">
                        <strong>Admin:</strong> admin@greenholding.com
                    </div>
                    <div class="account-badge manager">
                        <strong>Manager:</strong> manager@greenholding.com
                    </div>
                    <div class="account-badge staff">
                        <strong>Staff:</strong> staff@greenholding.com
                    </div>
                </div>
                <p class="text-center text-muted mt-2">
                    <small>Şifre: <code>password</code></small>
                </p>
            </div>

        </div>

        <!-- Footer -->
        <div class="login-footer">
            <p class="text-white-50 mb-0">
                © 2025 Green Case • Müşteri Yönetim Sistemi
            </p>
        </div>
    </div>

    @vite(['resources/js/app.js', 'resources/js/pages/login.js'])
</body>
</html>
