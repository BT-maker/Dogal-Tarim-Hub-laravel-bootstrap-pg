<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Girişi - Yeşil Toprak</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2E7D32;
            --accent-green: #4CAF50;
            --soft-cream: #F1F8E9;
            --warm-brown: #8D6E63;
            --light-green: #C8E6C9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            min-height: 600px;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--soft-cream) 0%, #f8f9fa 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-right {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-green);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 1rem;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            color: var(--warm-brown);
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            text-align: left;
        }

        .feature-list li {
            padding: 0.5rem 0;
            color: var(--primary-green);
            font-weight: 500;
        }

        .feature-list li i {
            color: var(--accent-green);
            margin-right: 0.5rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6c757d;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .form-floating label {
            color: #6c757d;
        }

        .btn-admin {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.3);
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
        }

        .back-to-site {
            text-align: center;
            margin-top: 2rem;
        }

        .back-to-site a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-to-site a:hover {
            color: var(--accent-green);
        }

        .alert {
            border: none;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 10px;
            }
            
            .login-left {
                padding: 2rem;
            }
            
            .login-right {
                padding: 2rem;
            }
            
            .brand-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <div class="brand-logo">
                <i class="fas fa-leaf"></i>
            </div>
            <h1 class="brand-title">Yeşil Toprak</h1>
            <p class="brand-subtitle">Organik Tarım Blog Yönetimi</p>
            
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i> Yazı Yönetimi</li>
                <li><i class="fas fa-check-circle"></i> Kategori Kontrolü</li>
                <li><i class="fas fa-check-circle"></i> Kullanıcı Yönetimi</li>
                <li><i class="fas fa-check-circle"></i> İstatistikler</li>
                <li><i class="fas fa-check-circle"></i> Güvenli Erişim</li>
            </ul>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-header">
                <h2><i class="fas fa-shield-alt me-2"></i>Admin Girişi</h2>
                <p>Yönetim paneline erişmek için giriş yapın</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Hata!</strong> {{ $errors->first() }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Hata!</strong> {{ session('error') }}
                </div>
            @endif

            <form id="adminLoginForm" method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                
                <div class="form-floating">
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           placeholder="E-posta adresiniz"
                           value="{{ old('email') }}"
                           required>
                    <label for="email">
                        <i class="fas fa-envelope me-2"></i>E-posta Adresi
                    </label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Şifreniz"
                           required>
                    <label for="password">
                        <i class="fas fa-lock me-2"></i>Şifre
                    </label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Beni hatırla
                    </label>
                </div>

                <button type="submit" class="btn btn-admin" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                </button>
            </form>

            <!-- Loading and Error Messages -->
            <div id="loadingMessage" class="alert alert-info mt-3" style="display: none;">
                <i class="fas fa-spinner fa-spin me-2"></i>Giriş yapılıyor...
            </div>
            
            <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span id="errorText"></span>
            </div>

            <div id="successMessage" class="alert alert-success mt-3" style="display: none;">
                <i class="fas fa-check-circle me-2"></i>
                <span id="successText"></span>
            </div>

            <div class="back-to-site">
                <a href="{{ route('home') }}">
                    <i class="fas fa-arrow-left me-2"></i>Ana Siteye Dön
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Crypto Utils -->
    <script src="{{ asset('js/crypto-utils.js') }}"></script>
    
    <script>
        // AdminAuth class will handle everything automatically
    </script>
</body>
</html>