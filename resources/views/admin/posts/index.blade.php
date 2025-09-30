@extends('layouts.app')

@section('title','Admin Panel · Yazı Yönetimi - Yeşil Toprak')

@section('content')
<!-- Admin Header -->
<div class="admin-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <div class="admin-icon me-3">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h1 class="h2 mb-1" style="color: var(--primary-green);">
                        <i class="bi bi-journal-text me-2"></i>Yazı Yönetimi
                    </h1>
                    <p class="text-muted mb-0">Organik tarım blog yazılarınızı yönetin</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-organic">
                <i class="bi bi-plus-circle me-2"></i>Yeni Yazı Ekle
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-3" style="color: var(--accent-green); font-size: 1.2rem;"></i>
            <div>
                <strong>Başarılı!</strong> {{ session('success') }}
            </div>
        </div>
    </div>
@endif

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-journal-text"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $posts->total() }}</h3>
                <p>Toplam Yazı</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: var(--accent-green);">
                <i class="bi bi-eye"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $posts->where('published_at', '!=', null)->count() }}</h3>
                <p>Yayında</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #ffc107;">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $posts->where('published_at', null)->count() }}</h3>
                <p>Taslak</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #6f42c1;">
                <i class="bi bi-tags"></i>
            </div>
            <div class="stats-content">
                <h3>{{ \App\Models\Category::count() }}</h3>
                <p>Kategori</p>
            </div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="admin-table-container">
    <div class="table-header mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0" style="color: var(--primary-green);">
                    <i class="bi bi-list-ul me-2"></i>Yazı Listesi
                </h5>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex gap-2 justify-content-md-end">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-funnel me-1"></i>Filtrele
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-download me-1"></i>Dışa Aktar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-journal me-2"></i>Başlık
                        </div>
                    </th>
                    <th>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person me-2"></i>Yazar
                        </div>
                    </th>
                    <th>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-tags me-2"></i>Kategoriler
                        </div>
                    </th>
                    <th>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-circle me-2"></i>Durum
                        </div>
                    </th>
                    <th>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar me-2"></i>Tarih
                        </div>
                    </th>
                    <th>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-gear me-2"></i>İşlemler
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            <div class="post-title-cell">
                                <h6 class="mb-1">{{ Str::limit($post->title, 50) }}</h6>
                                @if($post->excerpt)
                                    <small class="text-muted">{{ Str::limit($post->excerpt, 80) }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="author-avatar me-2">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $post->user->name ?? 'Bilinmiyor' }}</div>
                                    <small class="text-muted">{{ $post->user ? $post->user->email : '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="categories-cell">
                                @if($post->categories->count() > 0)
                                    @foreach($post->categories->take(2) as $category)
                                        <span class="category-badge-small me-1 mb-1" style="background-color: {{ $category->color }};">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                    @if($post->categories->count() > 2)
                                        <span class="badge bg-light text-dark">+{{ $post->categories->count() - 2 }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($post->is_published)
                                <span class="status-badge status-published">
                                    <i class="bi bi-check-circle me-1"></i>Yayında
                                </span>
                            @else
                                <span class="status-badge status-draft">
                                    <i class="bi bi-pencil me-1"></i>Taslak
                                </span>
                            @endif
                        </td>
                        <td>
                            <div>
                                <div class="fw-medium">{{ optional($post->published_at)->format('d.m.Y') ?? $post->created_at->format('d.m.Y') }}</div>
                                <small class="text-muted">{{ optional($post->published_at)->format('H:i') ?? $post->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('post.show', $post) }}" class="btn btn-outline-info btn-sm" target="_blank" title="Görüntüle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-primary btn-sm" title="Düzenle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')" 
                                            title="Sil">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="bi bi-journal-plus display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">Henüz yazı bulunmuyor</h5>
                                <p class="text-muted mb-3">İlk organik tarım yazınızı oluşturmaya başlayın!</p>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-organic">
                                    <i class="bi bi-plus-circle me-2"></i>İlk Yazıyı Oluştur
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    @endif
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
}

.admin-table-container {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.admin-table {
    margin: 0;
}

.admin-table thead th {
    background: var(--soft-cream);
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: var(--primary-green);
    border-bottom: 2px solid var(--accent-green);
}

.admin-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.admin-table tbody tr:hover {
    background: var(--soft-cream);
}

.post-title-cell h6 {
    color: var(--primary-green);
    font-weight: 600;
}

.author-avatar {
    width: 35px;
    height: 35px;
    background: var(--accent-green);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.category-badge-small {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    color: white;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-published {
    background: #d4edda;
    color: #155724;
}

.status-draft {
    background: #fff3cd;
    color: #856404;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-buttons .btn {
    width: 35px;
    height: 35px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-state {
    padding: 3rem 1rem;
}

.categories-cell {
    max-width: 200px;
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
    
    .admin-table-container {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection