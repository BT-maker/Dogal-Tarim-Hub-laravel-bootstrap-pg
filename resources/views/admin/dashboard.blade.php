@extends('layouts.admin')

@section('title','Admin Dashboard - Yeşil Toprak')
@section('page-title','Dashboard')

@section('content')
<!-- Admin Header -->
<div class="admin-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <div class="admin-icon me-3">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <div>
                    <h1 class="h2 mb-1" style="color: var(--primary-green);">
                        <i class="fas fa-shield-alt me-2"></i>Admin Dashboard
                    </h1>
                    <p class="text-muted mb-0">Organik tarım blog yönetim paneli</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex gap-2 justify-content-md-end">
                <a href="{{ route('home') }}" class="btn btn-outline-organic">
                    <i class="fas fa-home me-2"></i>Siteyi Görüntüle
                </a>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-organic">
                    <i class="fas fa-plus-circle me-2"></i>Yeni Yazı
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="stats-content">
                <h3>{{ \App\Models\Post::count() }}</h3>
                <p>Toplam Yazı</p>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">+12%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: var(--accent-green);">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stats-content">
                <h3>{{ \App\Models\Post::where('is_published', true)->count() }}</h3>
                <p>Yayında</p>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">+8%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: #ffc107;">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stats-content">
                <h3>{{ \App\Models\Category::count() }}</h3>
                <p>Kategori</p>
                <div class="stats-trend">
                    <i class="fas fa-minus text-muted"></i>
                    <span class="text-muted">0%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: #6f42c1;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-content">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Kullanıcı</p>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">+5%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row g-4">
    <!-- Recent Posts -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Son Yazılar
                    </h5>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-organic btn-sm">
                        Tümünü Gör
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Başlık</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Post::with('categories')->latest()->take(5)->get() as $post)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ Str::limit($post->title, 40) }}</h6>
                                            @if($post->categories->count() > 0)
                                                <div class="d-flex gap-1">
                                                    @foreach($post->categories->take(2) as $category)
                                                        <span class="badge" style="background-color: {{ $category->color }}; font-size: 0.7rem;">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($post->is_published)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Yayında
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-edit me-1"></i>Taslak
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $post->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($post->is_published)
                                                <a href="{{ route('post.show', $post) }}" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Hızlı İşlemler
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-organic">
                        <i class="fas fa-plus-circle me-2"></i>Yeni Yazı Ekle
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tags me-2"></i>Kategori Yönet
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-users me-2"></i>Kullanıcı Yönet
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-globe me-2"></i>Blog Sayfası
                    </a>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Sistem Bilgisi
                </h5>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Laravel Sürümü:</span>
                        <span class="fw-medium">{{ app()->version() }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">PHP Sürümü:</span>
                        <span class="fw-medium">{{ PHP_VERSION }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Toplam Yazı:</span>
                        <span class="fw-medium">{{ \App\Models\Post::count() }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Son Güncelleme:</span>
                        <span class="fw-medium">{{ now()->format('d.m.Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-header {
    background: linear-gradient(135deg, var(--soft-cream) 0%, #f8f9fa 100%);
    padding: 2rem;
    border-radius: 20px;
    border: 1px solid #e9ecef;
}

.admin-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-green);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stats-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-green);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.stats-content h3 {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-green);
    margin-bottom: 0.5rem;
}

.stats-content p {
    color: #6c757d;
    margin: 0;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stats-trend {
    font-size: 0.85rem;
}

.admin-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.admin-card .card-header {
    background: var(--soft-cream);
    border-bottom: 1px solid #e9ecef;
    padding: 1.25rem;
}

.admin-card .card-header h5 {
    color: var(--primary-green);
    font-weight: 600;
}

.admin-card .card-body {
    padding: 1.25rem;
}

.info-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.info-item:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .admin-header {
        padding: 1.5rem;
    }
    
    .admin-header .row {
        text-align: center;
    }
    
    .admin-header .col-md-4 {
        margin-top: 1rem;
    }
    
    .stats-card {
        margin-bottom: 1rem;
    }
    
    .admin-card .card-body {
        padding: 1rem;
    }
}
</style>
@endsection