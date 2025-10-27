<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yeşil Toprak - Organik Tarım Blog')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/organic-theme.css') }}" rel="stylesheet">
    
    @yield('styles')
    <style>
        :root {
            --primary-green: #2D5016;
            --light-green: #4A7C59;
            --accent-green: #7FB069;
            --warm-beige: #F4E4BC;
            --earth-brown: #8B4513;
            --soft-cream: #FFF8E7;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--soft-cream) 0%, #ffffff 100%);
            min-height: 100vh;
        }
        
        .navbar-organic {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            box-shadow: 0 4px 20px rgba(45, 80, 22, 0.15);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand:hover {
            color: var(--warm-beige) !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-2px);
        }
        
        .hero-section {
            /* Top layer gradient + bottom layer background image */
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .alert {
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }
        
        .main-content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 3rem;
        }
        
        .footer {
            background: var(--primary-green);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .btn-organic {
            background: linear-gradient(135deg, var(--accent-green) 0%, var(--light-green) 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-organic:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(127, 176, 105, 0.4);
            color: white;
        }
        
        .category-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0.2rem;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-organic">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-seedling"></i>
                Yeşil Toprak
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Anasayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">
                            <i class="fas fa-newspaper me-1"></i>Yazılar
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-tags me-1"></i>Kategoriler
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Organik Tarım Teknikleri</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-apple-alt me-2"></i>Sebze & Meyve Yetiştiriciliği</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-award me-2"></i>Organik Sertifikasyon</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Pazarlama & Satış</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-recycle me-2"></i>Sürdürülebilirlik</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Hero Section (only on homepage) -->
    @if(request()->routeIs('home'))
    <section class="hero-section">
        <img src="https://www.fortuneturkey.com/wp-content/uploads/2018/10/organik-tarim-destegi-basvurularinda-son-gun-24-mart-58882-1932017165034.jpg" alt="Hero Background" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; opacity: 0.35;">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-8 col-md-12 text-center text-lg-start">
                    <h1 class="display-4 fw-bold mb-4">
                        Organik Tarımın <span style="color: var(--warm-beige);">Dijital Adresi</span>
                    </h1>
                    <p class="lead mb-4">
                        Sürdürülebilir tarım teknikleri, organik sertifikasyon süreçleri ve doğal yaşam hakkında 
                        uzman görüşleri ve pratik bilgiler.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                        <a href="{{ route('posts.index') }}" class="btn btn-organic">
                            <i class="fas fa-book me-2"></i>Yazıları Keşfet
                        </a>
                        <a href="#categories" class="btn btn-outline-light">
                            <i class="fas fa-arrow-down me-2"></i>Kategoriler
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-center">
                    <i class="fas fa-seedling" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Main Content -->
    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="main-content">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-seedling me-2"></i>Yeşil Toprak
                    </h5>
                    <p class="mb-3">
                        Organik tarım ve sürdürülebilir yaşam konularında güvenilir bilgi kaynağınız.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6 mb-4">
                    <h6 class="fw-bold mb-3">Kategoriler</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Organik Tarım</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Sebze Yetiştirme</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Sertifikasyon</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Pazarlama</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <h6 class="fw-bold mb-3">Hızlı Linkler</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('page.about') }}" class="text-white-50 text-decoration-none">Hakkımızda</a></li>
                        <li class="mb-2"><a href="{{ route('page.contact') }}" class="text-white-50 text-decoration-none">İletişim</a></li>
                        <li class="mb-2"><a href="{{ route('page.privacy') }}" class="text-white-50 text-decoration-none">Gizlilik Politikası</a></li>
                        <li class="mb-2"><a href="{{ route('page.terms') }}" class="text-white-50 text-decoration-none">Kullanım Şartları</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Bülten</h6>
                    <p class="text-white-50 mb-3">Yeni yazılarımızdan haberdar olun</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="E-posta adresiniz">
                        <button class="btn btn-organic" type="button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p class="mb-0 text-white-50">
                    © {{ date('Y') }} Yeşil Toprak. Tüm hakları saklıdır. 
                    <i class="fas fa-heart text-danger"></i> ile yapıldı.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Organic Theme JS -->
    <script src="{{ asset('js/organic-theme.js') }}"></script>
</body>
</html>


