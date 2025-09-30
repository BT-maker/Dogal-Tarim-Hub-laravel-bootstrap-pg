@extends('layouts.app')

@section('title', $post->title . ' - Yeşil Toprak')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-organic">
                    <i class="fas fa-home me-1"></i>Anasayfa
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index') }}" class="text-decoration-none text-organic">
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
                        <span class="badge-category me-2" style="background-color: {{ $category->color }};">
                            <i class="fas fa-tag me-1"></i>{{ $category->name }}
                        </span>
                    @endforeach
                </div>
            @endif
            
            <!-- Title -->
            <h1 class="display-5 fw-bold text-organic mb-4" style="line-height: 1.2;">
                {{ $post->title }}
            </h1>
            
            <!-- Excerpt -->
            @if($post->excerpt)
                <p class="lead text-muted mb-4 fs-4">
                    {{ $post->excerpt }}
                </p>
            @endif
            
            <!-- Meta Information -->
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        @if($post->user)
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 bg-organic" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Yazar</small>
                                    <strong class="text-organic">{{ $post->user->name }}</strong>
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar me-2 text-organic"></i>
                            <div>
                                <small class="text-muted d-block">Yayın Tarihi</small>
                                <strong>{{ $post->created_at->format('d.m.Y') }}</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2 text-organic"></i>
                            <div>
                                <small class="text-muted d-block">Okuma Süresi</small>
                                <strong>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} dakika</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <button class="btn btn-outline-organic btn-sm" onclick="sharePost()">
                            <i class="fas fa-share me-1"></i>Paylaş
                        </button>
                        <button class="btn btn-outline-organic btn-sm" onclick="printPost()">
                            <i class="fas fa-print me-1"></i>Yazdır
                        </button>
                    </div>
                </div>
            </div>
        </header>
    
        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="mb-5">
                <div class="position-relative overflow-hidden rounded-4" style="height: 400px;">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark">
                        <small class="text-white">{{ $post->title }}</small>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Post Content -->
        <div class="post-content mb-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="content-wrapper fs-5 lh-lg text-dark">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Post Footer -->
        <footer class="border-top pt-4">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3 text-organic">
                        <i class="fas fa-tags me-2"></i>Etiketler
                    </h6>
                    @if($post->categories->count() > 0)
                        @foreach($post->categories as $category)
                            <a href="#" class="badge-category me-2 mb-2 text-decoration-none" 
                               style="background-color: {{ $category->color }};">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @else
                        <span class="text-muted">Bu yazıya henüz etiket eklenmemiş.</span>
                    @endif
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="fw-bold mb-3 text-organic">
                        <i class="fas fa-share me-2"></i>Paylaş
                    </h6>
                    <div class="d-flex gap-2 justify-content-md-end">
                        <a href="#" class="btn btn-outline-primary btn-sm" onclick="shareOnFacebook()">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-info btn-sm" onclick="shareOnTwitter()">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-success btn-sm" onclick="shareOnWhatsApp()">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm" onclick="copyLink()">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </article>

    <!-- Related Posts Section -->
    <section class="py-5 mb-4 bg-light rounded-4">
        <h3 class="fw-bold mb-4 text-center text-organic">
            <i class="fas fa-newspaper me-2"></i>İlgili Yazılar
        </h3>
        <div class="row g-4">
            <!-- Bu kısım dinamik olarak ilgili yazıları gösterecek -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Yakında</h6>
                        <p class="text-muted small">İlgili yazılar burada görünecek</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Yakında</h6>
                        <p class="text-muted small">İlgili yazılar burada görünecek</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle display-4 text-muted mb-3"></i>
                        <h6 class="text-muted">Yakında</h6>
                        <p class="text-muted small">İlgili yazılar burada görünecek</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Navigation -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <a href="{{ route('posts.index') }}" class="btn btn-organic">
            <i class="fas fa-arrow-left me-2"></i>Tüm Yazılar
        </a>
        <a href="#" class="btn btn-outline-secondary" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <i class="fas fa-arrow-up me-2"></i>Başa Dön
        </a>
    </div>
</div>

<style>
.post-content h1, .post-content h2, .post-content h3, 
.post-content h4, .post-content h5, .post-content h6 {
    color: var(--primary-green);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.post-content img {
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

.bg-gradient-dark {
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
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