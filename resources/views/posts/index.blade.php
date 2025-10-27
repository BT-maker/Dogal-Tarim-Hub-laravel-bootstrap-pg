@extends('layouts.app')

@section('title', 'Tüm Yazılar - Yeşil Toprak')

@section('styles')
<style>
    .post-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #fff;
    }

    .post-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .post-card .card-img-top {
        height: 240px;
        object-fit: cover;
    }
    
    .post-card .card-body {
        padding: 1.75rem;
    }

    .post-card .category-badge {
        font-size: 0.8rem;
        padding: 0.4em 0.9em;
        border-radius: 50px;
        font-weight: 500;
        color: white !important;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .post-card .category-badge:hover {
        opacity: 0.9;
    }

    .post-card .card-title a {
        color: var(--primary-green);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .post-card .card-title a:hover {
        color: var(--accent-green);
    }
    
    .post-card .author-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }

    .filter-bar {
        background: #ffffff;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        margin-bottom: 2.5rem;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(45, 80, 22, 0.25);
        border-color: var(--light-green);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }
    
    .pagination .page-link {
        color: var(--primary-green);
    }
    
    .pagination .page-link:hover {
        color: var(--accent-green);
    }
    
    .empty-state-icon {
        font-size: 6rem;
        color: var(--primary-green);
        opacity: 0.2;
    }

</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold" style="color: var(--primary-green);">Yazı Arşivi</h1>
        <p class="fs-5 text-muted">Organik tarım ve sürdürülebilir yaşam hakkında ilham veren içerikleri keşfedin.</p>
    </div>

    <!-- Filters & Search Bar -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('posts.index') }}">
            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-lg-6">
                    <div class="input-group">
                         <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Yazılarda ara..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="col-lg-2 col-md-4">
                    <select name="category" class="form-select">
                        <option value="">Tüm Kategoriler</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="col-lg-2 col-md-4">
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>En Yeni</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>En Eski</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>En Popüler</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="col-lg-2 col-md-4 d-flex">
                    <button class="btn btn-organic flex-grow-1" type="submit">Filtrele</button>
                    @if(request()->hasAny(['search', 'category', 'sort']))
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary ms-2" title="Filtreleri Temizle">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if($posts->count() > 0)
        <!-- Posts Grid -->
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <article class="post-card h-100">
                        <a href="{{ route('post.show', $post) }}">
                            <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/400x240.png/2D5016/FFF?text=Yeşil+Toprak' }}" 
                                 class="card-img-top" 
                                 alt="{{ $post->title }}">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                @forelse($post->categories->take(2) as $category)
                                    <a href="{{ route('posts.index', ['category' => $category->id]) }}" class="category-badge" style="background-color: {{ $category->color }};">
                                        {{ $category->name }}
                                    </a>
                                @empty
                                    <span class="category-badge" style="background-color: #6c757d;">Kategorisiz</span>
                                @endforelse
                            </div>
                            
                            <h4 class="card-title fw-bold mb-3">
                                <a href="{{ route('post.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h4>
                            
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}
                            </p>
                            
                            <div class="d-flex align-items-center mt-4">
                                @if($post->user)
                                <img src="{{ $post->user->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="{{ $post->user->name }}" class="author-avatar me-2">
                                <div>
                                    <small class="text-muted fw-bold">{{ $post->user->name }}</small>
                                    <br>
                                    <small class="text-muted">{{ $post->published_at->format('d M Y') }} &middot; {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} dk okuma</small>
                                </div>
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
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="my-5">
                <i class="fas fa-search empty-state-icon mb-4"></i>
                <h3 class="fw-bold mb-3" style="color: var(--primary-green);">Sonuç Bulunamadı</h3>
                <p class="text-muted mb-4">Arama kriterlerinize uygun bir yazı bulamadık. <br>Filtreleri temizleyerek tekrar deneyebilirsiniz.</p>
                <a href="{{ route('posts.index') }}" class="btn btn-organic">
                    <i class="fas fa-times me-2"></i>Filtreleri Temizle
                </a>
            </div>
        </div>
    @endif
</div>
@endsection