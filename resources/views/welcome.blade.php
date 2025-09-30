@extends('layouts.app')

@section('title', 'Yeşil Toprak - Organik Tarım Blog')

@section('content')
<!-- Featured Categories Section -->
<section id="categories" class="mb-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold" style="color: var(--primary-green);">
                <i class="bi bi-tags me-2"></i>Popüler Kategoriler
            </h2>
            <p class="text-muted">Organik tarım dünyasında en çok merak edilen konular</p>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm category-card" style="background: linear-gradient(135deg, #4A7C59 0%, #7FB069 100%);">
                <div class="card-body text-white text-center p-4">
                    <i class="bi bi-gear display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Organik Tarım Teknikleri</h5>
                    <p class="card-text">Doğal yöntemlerle verimli tarım yapmanın sırları</p>
                    <a href="#" class="btn btn-light btn-sm">Yazıları Gör</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm category-card" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);">
                <div class="card-body text-white text-center p-4">
                    <i class="bi bi-apple display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Sebze & Meyve Yetiştiriciliği</h5>
                    <p class="card-text">Organik sebze ve meyve üretim rehberleri</p>
                    <a href="#" class="btn btn-light btn-sm">Yazıları Gör</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm category-card" style="background: linear-gradient(135deg, #2D5016 0%, #4A7C59 100%);">
                <div class="card-body text-white text-center p-4">
                    <i class="bi bi-award display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Organik Sertifikasyon</h5>
                    <p class="card-text">Sertifikasyon süreçleri ve gereklilikler</p>
                    <a href="#" class="btn btn-light btn-sm">Yazıları Gör</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Posts Section -->
<section class="mb-5">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold" style="color: var(--primary-green);">
                    <i class="bi bi-journal-text me-2"></i>Son Yazılar
                </h2>
                <a href="{{ route('posts.index') }}" class="btn btn-organic">
                    Tüm Yazılar <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    @if($posts->count() > 0)
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-lg-6 col-xl-4">
                    <article class="card h-100 border-0 shadow-sm post-card">
                        @if($post->featured_image)
                            <div class="card-img-top position-relative overflow-hidden" style="height: 200px;">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-100 h-100 object-fit-cover">
                                <div class="position-absolute top-0 start-0 w-100 h-100" 
                                     style="background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 100%);"></div>
                            </div>
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" 
                                 style="height: 200px; background: linear-gradient(135deg, var(--accent-green) 0%, var(--light-green) 100%);">
                                <i class="bi bi-image text-white" style="font-size: 3rem; opacity: 0.7;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @if($post->categories->count() > 0)
                                    @foreach($post->categories->take(2) as $category)
                                        <span class="category-badge" style="background-color: {{ $category->color }};">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            
                            <h5 class="card-title fw-bold mb-3">
                                <a href="{{ route('post.show', $post) }}" 
                                   class="text-decoration-none" 
                                   style="color: var(--primary-green);">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($post->excerpt, 120) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $post->created_at->format('d.m.Y') }}
                                </small>
                                @if($post->user)
                                    <small class="text-muted">
                                        <i class="bi bi-person me-1"></i>
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
            <i class="bi bi-journal-x display-1 text-muted mb-3"></i>
            <h4 class="text-muted">Henüz yazı bulunmuyor</h4>
            <p class="text-muted">İlk organik tarım yazısını yazmak için admin panelini kullanabilirsiniz.</p>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-organic">
                <i class="bi bi-plus-circle me-2"></i>İlk Yazıyı Yaz
            </a>
        </div>
    @endif
</section>

<!-- Newsletter Section -->
<section class="py-5 mb-4" style="background: linear-gradient(135deg, var(--warm-beige) 0%, #ffffff 100%); border-radius: 20px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2" style="color: var(--primary-green);">
                    <i class="bi bi-envelope-heart me-2"></i>Organik Tarım Bültenimize Katılın
                </h3>
                <p class="text-muted mb-0">
                    Yeni yazılarımız, organik tarım ipuçları ve özel içeriklerimizden ilk siz haberdar olun.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="E-posta adresiniz">
                    <button class="btn btn-organic" type="button">
                        <i class="bi bi-send"></i> Abone Ol
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
}

.post-card {
    transition: all 0.3s ease;
}

.post-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

.object-fit-cover {
    object-fit: cover;
}
</style>
@endsection