@extends('layouts.app')

@section('title', 'Tüm Yazılar - Yeşil Toprak')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="fw-bold text-organic mb-2">
                        <i class="fas fa-newspaper me-2"></i>Tüm Yazılar
                    </h1>
                    <p class="text-muted mb-0 fs-5">Organik tarım dünyasından en güncel yazılar</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-organic dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i>Filtrele
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>En Yeni</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-check me-2"></i>En Eski</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>En Popüler</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-organic dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-tags me-1"></i>Kategori
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Tüm Kategoriler</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-tractor me-2"></i>Organik Tarım Teknikleri</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-apple-alt me-2"></i>Sebze & Meyve Yetiştiriciliği</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-certificate me-2"></i>Organik Sertifikasyon</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Pazarlama & Satış</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-recycle me-2"></i>Sürdürülebilirlik</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Yazılarda ara..." id="searchInput">
                <button class="btn btn-organic" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    @if($posts->count() > 0)
        <!-- Posts Grid -->
        <div class="row g-4 mb-5">
            @foreach($posts as $post)
                <div class="col-lg-6 col-xl-4">
                    <article class="card h-100 border-0 shadow-sm hover-lift">
                        @if($post->featured_image)
                            <div class="card-img-top position-relative overflow-hidden rounded-top" style="height: 220px;">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-100 h-100 object-fit-cover hover-scale">
                                <div class="position-absolute top-0 start-0 w-100 h-100" 
                                     style="background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.4) 100%);"></div>
                                @if($post->is_published)
                                    <span class="position-absolute top-3 end-3 badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Yayında
                                    </span>
                                @else
                                    <span class="position-absolute top-3 end-3 badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Taslak
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center position-relative rounded-top category-gradient" 
                                 style="height: 220px;">
                                <i class="fas fa-image text-white" style="font-size: 4rem; opacity: 0.7;"></i>
                                @if($post->is_published)
                                    <span class="position-absolute top-3 end-3 badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Yayında
                                    </span>
                                @else
                                    <span class="position-absolute top-3 end-3 badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Taslak
                                    </span>
                                @endif
                            </div>
                        @endif
                    
                        <div class="card-body d-flex flex-column">
                            <!-- Categories -->
                            <div class="mb-3">
                                @if($post->categories->count() > 0)
                                    @foreach($post->categories->take(3) as $category)
                                        <span class="badge-category me-1" style="background-color: {{ $category->color }};">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                    @if($post->categories->count() > 3)
                                        <span class="badge-category" style="background-color: #6c757d;">
                                            +{{ $post->categories->count() - 3 }}
                                        </span>
                                    @endif
                                @else
                                    <span class="badge-category" style="background-color: #6c757d;">
                                        Kategorisiz
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <h5 class="card-title fw-bold mb-3">
                                <a href="{{ route('post.show', $post) }}" 
                                   class="text-decoration-none stretched-link text-organic">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            
                            <!-- Excerpt -->
                            <p class="card-text text-muted flex-grow-1 mb-3">
                                {{ Str::limit($post->excerpt ?: strip_tags($post->content), 150) }}
                            </p>
                            
                            <!-- Meta Info -->
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-3">
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
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} dk okuma
                                </small>
                            </div>
                        </div>
                </article>
            </div>
        @endforeach
    </div>
    
        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="d-flex justify-content-center">
                <nav aria-label="Sayfa navigasyonu">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-newspaper display-1 text-muted"></i>
            </div>
            <h3 class="text-muted mb-3">Henüz yazı bulunmuyor</h3>
            <p class="text-muted mb-4">
                Organik tarım dünyasından ilk yazıyı yazmaya ne dersiniz?
            </p>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-organic btn-lg">
                <i class="fas fa-plus-circle me-2"></i>İlk Yazıyı Yaz
            </a>
        </div>
    @endif

    <!-- Back to Top Button -->
    <button type="button" class="btn btn-organic position-fixed bottom-0 end-0 m-4 rounded-circle" 
            id="backToTop" style="display: none; width: 50px; height: 50px;">
        <i class="fas fa-arrow-up"></i>
    </button>
</div>



<script>
// Back to top button functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Search functionality (basic)
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        // Here you would implement search functionality
        console.log('Searching for:', this.value);
    }
});
</script>
@endsection