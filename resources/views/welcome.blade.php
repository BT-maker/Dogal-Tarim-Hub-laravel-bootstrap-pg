@extends('layouts.app')

@section('title', 'Yeşil Toprak - Organik Tarım Blog')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Organik Tarımın Geleceği Burada</h1>
                <p class="lead mb-4">Sürdürülebilir tarım teknikleri, doğal beslenme ve çevre dostu yaşam hakkında güncel bilgiler.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('posts.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-book-open me-2"></i>Yazıları Keşfet
                    </a>
                    <a href="#categories" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-down me-2"></i>Kategoriler
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-seedling display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories Section -->
<section id="categories" class="container mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-organic mb-3">
            <i class="fas fa-tags me-2"></i>Popüler Kategoriler
        </h2>
        <p class="text-muted fs-5">Organik tarım dünyasında en çok merak edilen konular</p>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow hover-lift category-gradient text-white">
                <div class="card-body text-center p-4">
                    <i class="fas fa-tractor display-4 mb-3 opacity-75"></i>
                    <h5 class="card-title fw-bold text-white">Organik Tarım Teknikleri</h5>
                    <p class="card-text">Doğal yöntemlerle verimli tarım yapmanın sırları</p>
                    <a href="#" class="btn btn-light">Yazıları Gör</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow hover-lift category-gradient text-white">
                <div class="card-body text-center p-4">
                    <i class="fas fa-apple-alt display-4 mb-3 opacity-75"></i>
                    <h5 class="card-title fw-bold text-white">Sebze & Meyve Yetiştiriciliği</h5>
                    <p class="card-text">Organik sebze ve meyve üretim rehberleri</p>
                    <a href="#" class="btn btn-light">Yazıları Gör</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow hover-lift category-gradient text-white">
                <div class="card-body text-center p-4">
                    <i class="fas fa-certificate display-4 mb-3 opacity-75"></i>
                    <h5 class="card-title fw-bold text-white">Organik Sertifikasyon</h5>
                    <p class="card-text">Sertifikasyon süreçleri ve gereklilikler</p>
                    <a href="#" class="btn btn-light">Yazıları Gör</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Posts Section -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold text-organic">
            <i class="fas fa-newspaper me-2"></i>Son Yazılar
        </h2>
        <a href="{{ route('posts.index') }}" class="btn btn-organic">
            Tüm Yazılar <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    @if($posts->count() > 0)
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-lg-6 col-xl-4">
                    <article class="card h-100 border-0 shadow hover-lift">
                        @if($post->featured_image)
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="card-img-top w-100 h-100 hover-scale"
                                     style="object-fit: cover;">
                            </div>
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center category-gradient" 
                                 style="height: 200px;">
                                <i class="fas fa-image text-white display-4 opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @if($post->categories->count() > 0)
                                    @foreach($post->categories->take(2) as $category)
                                        <span class="badge badge-category rounded-pill me-1">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            
                            <h5 class="card-title fw-bold mb-3">
                                <a href="{{ route('post.show', $post) }}" 
                                   class="text-decoration-none text-organic">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($post->excerpt, 120) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $post->created_at->format('d.m.Y') }}
                                </small>
                                @if($post->user)
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $post->user->name }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $posts->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <i class="fas fa-newspaper display-1 text-muted mb-3"></i>
            <h4 class="text-muted">Henüz yazı bulunmuyor</h4>
            <p class="text-muted">İlk organik tarım yazısını yazmak için admin panelini kullanabilirsiniz.</p>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-organic">
                <i class="fas fa-plus me-2"></i>İlk Yazıyı Yaz
            </a>
        </div>
    @endif
</section>

<!-- Newsletter Section -->
<section class="container mb-5">
    <div class="bg-cream rounded-4 p-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-organic mb-3">
                    <i class="fas fa-envelope me-2"></i>Organik Tarım Bültenimize Katılın
                </h3>
                <p class="text-muted mb-0 fs-5">
                    Yeni yazılarımız, organik tarım ipuçları ve özel içeriklerimizden ilk siz haberdar olun.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="email" class="form-control form-control-lg" placeholder="E-posta adresiniz">
                    <button class="btn btn-organic btn-lg" type="button">
                        <i class="fas fa-paper-plane"></i> Abone Ol
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection