@extends('layouts.app')

@section('title', $post->title . ' - Yeşil Toprak')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--accent-green);">
                <i class="bi bi-house-door me-1"></i>Anasayfa
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('posts.index') }}" class="text-decoration-none" style="color: var(--accent-green);">
                Yazılar
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
    </ol>
</nav>

<article class="mb-5">
    <!-- Post Header -->
    <header class="mb-5">
        <!-- Categories -->
        @if($post->categories->count() > 0)
            <div class="mb-3">
                @foreach($post->categories as $category)
                    <span class="category-badge me-2" style="background-color: {{ $category->color }};">
                        <i class="bi bi-tag me-1"></i>{{ $category->name }}
                    </span>
                @endforeach
            </div>
        @endif
        
        <!-- Title -->
        <h1 class="display-5 fw-bold mb-4" style="color: var(--primary-green); line-height: 1.2;">
            {{ $post->title }}
        </h1>
        
        <!-- Excerpt -->
        @if($post->excerpt)
            <p class="lead text-muted mb-4" style="font-size: 1.1rem;">
                {{ $post->excerpt }}
            </p>
        @endif
        
        <!-- Meta Information -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    @if($post->user)
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 40px; height: 40px; background: var(--accent-green);">
                                <i class="bi bi-person text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Yazar</small>
                                <strong style="color: var(--primary-green);">{{ $post->user->name }}</strong>
                            </div>
                        </div>
                    @endif
                    
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar3 me-2" style="color: var(--accent-green);"></i>
                        <div>
                            <small class="text-muted d-block">Yayın Tarihi</small>
                            <strong>{{ $post->created_at->format('d.m.Y') }}</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock me-2" style="color: var(--accent-green);"></i>
                        <div>
                            <small class="text-muted d-block">Okuma Süresi</small>
                            <strong>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} dakika</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex gap-2 justify-content-md-end">
                    <button class="btn btn-outline-secondary btn-sm" onclick="sharePost()">
                        <i class="bi bi-share me-1"></i>Paylaş
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="printPost()">
                        <i class="bi bi-printer me-1"></i>Yazdır
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="mb-5">
            <div class="position-relative overflow-hidden rounded-3 shadow-lg">
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-100" 
                     style="height: 400px; object-fit: cover;">
                <div class="position-absolute bottom-0 start-0 end-0 p-3" 
                     style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                    <small class="text-white">{{ $post->title }}</small>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Post Content -->
    <div class="post-content mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="content-wrapper" style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Post Footer -->
    <footer class="border-top pt-4">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3" style="color: var(--primary-green);">
                    <i class="bi bi-tags me-2"></i>Etiketler
                </h6>
                @if($post->categories->count() > 0)
                    @foreach($post->categories as $category)
                        <a href="#" class="category-badge me-2 mb-2 text-decoration-none" 
                           style="background-color: {{ $category->color }};">
                            {{ $category->name }}
                        </a>
                    @endforeach
                @else
                    <span class="text-muted">Bu yazıya henüz etiket eklenmemiş.</span>
                @endif
            </div>
            <div class="col-md-6 text-md-end">
                <h6 class="fw-bold mb-3" style="color: var(--primary-green);">
                    <i class="bi bi-share me-2"></i>Paylaş
                </h6>
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="shareOnFacebook()">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm" onclick="shareOnTwitter()">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm" onclick="shareOnWhatsApp()">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm" onclick="copyLink()">
                        <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</article>

<!-- Related Posts Section -->
<section class="py-5 mb-4" style="background: var(--soft-cream); border-radius: 20px;">
    <div class="container">
        <h3 class="fw-bold mb-4 text-center" style="color: var(--primary-green);">
            <i class="bi bi-journal-text me-2"></i>İlgili Yazılar
        </h3>
        <div class="row g-4">
            <!-- Bu kısım dinamik olarak ilgili yazıları gösterecek -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-plus display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Yakında</h6>
                        <p class="text-muted small">İlgili yazılar burada görünecek</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-plus display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Yakında</h6>
                        <p class="text-muted small">İlgili yazılar burada görünecek</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-plus display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Yakında</h6>
                        <p class="text-muted small">İlgili yazılar burada görünecek</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation -->
<div class="d-flex justify-content-between align-items-center py-4">
    <a href="{{ route('posts.index') }}" class="btn btn-organic">
        <i class="bi bi-arrow-left me-2"></i>Tüm Yazılar
    </a>
    <a href="#" class="btn btn-outline-secondary" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="bi bi-arrow-up me-2"></i>Başa Dön
    </a>
</div>

<style>
.category-badge {
    display: inline-block;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    color: white;
    text-decoration: none;
}

.category-badge:hover {
    opacity: 0.8;
    color: white;
}

.post-content h1, .post-content h2, .post-content h3, 
.post-content h4, .post-content h5, .post-content h6 {
    color: var(--primary-green);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.post-content p {
    margin-bottom: 1.5rem;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin: 2rem 0;
}

.post-content blockquote {
    border-left: 4px solid var(--accent-green);
    background: var(--soft-cream);
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 0 10px 10px 0;
    font-style: italic;
}

.post-content ul, .post-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.post-content li {
    margin-bottom: 0.5rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: var(--accent-green);
}
</style>

<script>
function sharePost() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $post->title }}',
            text: '{{ $post->excerpt }}',
            url: window.location.href
        });
    } else {
        copyLink();
    }
}

function shareOnFacebook() {
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`, '_blank');
}

function shareOnTwitter() {
    const text = '{{ $post->title }} - {{ $post->excerpt }}';
    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(window.location.href)}`, '_blank');
}

function shareOnWhatsApp() {
    const text = '{{ $post->title }} - {{ $post->excerpt }}';
    window.open(`https://wa.me/?text=${encodeURIComponent(text + ' ' + window.location.href)}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link kopyalandı!');
    });
}

function printPost() {
    window.print();
}
</script>
@endsection