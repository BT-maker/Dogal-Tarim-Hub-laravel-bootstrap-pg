@extends('layouts.admin')

@section('title','Kategori Yönetimi - Yeşil Toprak')
@section('page-title','Kategori Yönetimi')

@section('content')
<style>
    .modern-admin-header {
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f9f0 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #d4edda;
        box-shadow: 0 4px 20px rgba(40, 167, 69, 0.1);
    }

    .modern-admin-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .modern-admin-title {
        color: #155724;
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
    }

    .modern-admin-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        margin: 0;
    }

    .modern-btn-primary {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .modern-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #218838, #1e7e34);
    }

    .modern-btn-outline {
        border: 2px solid #28a745;
        border-radius: 12px;
        padding: 10px 20px;
        color: #28a745;
        background: transparent;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .modern-btn-outline:hover {
        background: #28a745;
        color: white;
        transform: translateY(-1px);
    }

    .modern-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .modern-stats-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .modern-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .modern-stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .modern-stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .modern-stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #155724;
        margin-bottom: 0.5rem;
    }

    .modern-stats-label {
        color: #6c757d;
        font-size: 1rem;
        font-weight: 500;
        margin: 0;
    }

    .modern-alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border: 1px solid #b8dabc;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        color: #155724;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
    }

    .modern-alert-success i {
        font-size: 1.2rem;
        margin-right: 0.75rem;
        color: #28a745;
    }
</style>

<!-- Modern Admin Header -->
<div class="modern-admin-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="modern-admin-icon me-4">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h1 class="modern-admin-title">Kategori Yönetimi</h1>
                    <p class="modern-admin-subtitle">Blog kategorilerini kolayca yönetin ve düzenleyin</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex gap-3 justify-content-md-end">
                <a href="{{ route('admin.dashboard') }}" class="modern-btn-outline">
                    <i class="fas fa-arrow-left me-2"></i>Dashboard
                </a>
                <button class="modern-btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="fas fa-plus-circle me-2"></i>Yeni Kategori
                </button>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="modern-alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<!-- Modern Stats Cards -->
<div class="modern-stats-grid">
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
            <i class="fas fa-tags"></i>
        </div>
        <div class="modern-stats-number">{{ $categories->count() }}</div>
        <p class="modern-stats-label">Toplam Kategori</p>
    </div>
    
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #20c997, #17a2b8);">
            <i class="fas fa-eye"></i>
        </div>
        <div class="modern-stats-number">{{ $categories->where('is_active', true)->count() }}</div>
        <p class="modern-stats-label">Aktif Kategori</p>
    </div>
    
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
            <i class="fas fa-edit"></i>
        </div>
        <div class="modern-stats-number">{{ $categories->sum('posts_count') }}</div>
        <p class="modern-stats-label">Toplam Yazı</p>
    </div>
    
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #dc3545, #e83e8c);">
            <i class="fas fa-eye-slash"></i>
        </div>
        <div class="modern-stats-number">{{ $categories->where('is_active', false)->count() }}</div>
        <p class="modern-stats-label">Pasif Kategori</p>
    </div>
</div>

<!-- Modern Categories Table -->
<div class="modern-table-container">
    <div class="modern-table-header">
        <div class="d-flex align-items-center">
            <div class="modern-table-icon me-3">
                <i class="fas fa-list"></i>
            </div>
            <div>
                <h4 class="modern-table-title">Kategori Listesi</h4>
                <p class="modern-table-subtitle">Tüm blog kategorilerini görüntüleyin ve yönetin</p>
            </div>
        </div>
        <div class="modern-table-actions">
            <button class="modern-btn-filter">
                <i class="fas fa-filter me-2"></i>Filtrele
            </button>
            <button class="modern-btn-export">
                <i class="fas fa-download me-2"></i>Dışa Aktar
            </button>
        </div>
    </div>

    @if($categories->count() > 0)
        <div class="modern-table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Açıklama</th>
                        <th>Yazı Sayısı</th>
                        <th>Durum</th>
                        <th>Oluşturulma</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="category-color me-3" style="background-color: {{ $category->color }}"></div>
                                    <div>
                                        <h6 class="mb-1">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ Str::limit($category->description ?? 'Açıklama yok', 50) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $category->posts->count() }} yazı
                                </span>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="status-badge published">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="status-badge draft">
                                        <i class="fas fa-times-circle me-1"></i>Pasif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $category->created_at->format('d.m.Y') }}
                                </small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline-primary btn-sm" 
                                            onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}', '{{ $category->color }}', {{ $category->is_active ? 'true' : 'false' }})"
                                            data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($category->posts->count() == 0)
                                        <form method="POST" action="#" class="d-inline" 
                                              onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled title="Bu kategoride yazı bulunduğu için silinemez">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-tags"></i>
            </div>
            <h4>Henüz kategori yok</h4>
            <p class="text-muted">İlk kategorinizi oluşturmak için "Yeni Kategori" butonuna tıklayın.</p>
            <button class="btn btn-organic" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="fas fa-plus-circle me-2"></i>İlk Kategoriyi Oluştur
            </button>
        </div>
    @endif
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Yeni Kategori Oluştur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Kategori Adı *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Renk</label>
                        <input type="color" class="form-control form-control-color" id="color" name="color" value="#28a745">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Aktif kategori
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-organic">
                        <i class="fas fa-save me-2"></i>Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Kategori Düzenle
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#" id="editCategoryForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Kategori Adı *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_color" class="form-label">Renk</label>
                        <input type="color" class="form-control form-control-color" id="edit_color" name="color">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                            <label class="form-check-label" for="edit_is_active">
                                Aktif kategori
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-organic">
                        <i class="fas fa-save me-2"></i>Güncelle
                    </button>
                </div>
            </form>
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
}

.modern-table-container {
    background: white;
    border-radius: 20px;
    padding: 0;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.modern-table-header {
    background: linear-gradient(135deg, #e8f5e8 0%, #f0f9f0 100%);
    padding: 2rem;
    border-bottom: 1px solid #d4edda;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.modern-table-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.modern-table-title {
    color: #155724;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}

.modern-table-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.modern-table-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.modern-btn-filter {
    background: white;
    border: 2px solid #28a745;
    border-radius: 10px;
    padding: 8px 16px;
    color: #28a745;
    font-weight: 600;
    transition: all 0.3s ease;
}

.modern-btn-filter:hover {
    background: #28a745;
    color: white;
    transform: translateY(-1px);
}

.modern-btn-export {
    background: linear-gradient(135deg, #20c997, #17a2b8);
    border: none;
    border-radius: 10px;
    padding: 8px 16px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(32, 201, 151, 0.3);
}

.modern-btn-export:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(32, 201, 151, 0.4);
}

.modern-table-responsive {
    padding: 2rem;
}

.modern-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table th {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #155724;
    font-weight: 700;
    border: none;
    padding: 1.25rem 1rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
}

.modern-table th:first-child {
    border-top-left-radius: 15px;
}

.modern-table th:last-child {
    border-top-right-radius: 15px;
}

.modern-table td {
    padding: 1.25rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
    background: white;
    transition: all 0.3s ease;
}

.modern-table tbody tr:hover td {
    background: linear-gradient(135deg, #f8fffe, #f0f9f0);
    transform: scale(1.01);
}

.modern-table tbody tr:last-child td:first-child {
    border-bottom-left-radius: 15px;
}

.modern-table tbody tr:last-child td:last-child {
    border-bottom-right-radius: 15px;
}

.category-color {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.status-badge.published {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.draft {
    background-color: #f8d7da;
    color: #721c24;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-buttons .btn {
    padding: 0.375rem 0.5rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: var(--soft-cream);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: var(--primary-green);
    font-size: 2rem;
}

.empty-state h4 {
    color: var(--primary-green);
    margin-bottom: 1rem;
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
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<script>
function editCategory(id, name, description, color, isActive) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('edit_color').value = color;
    document.getElementById('edit_is_active').checked = isActive;
    document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
}
</script>
@endsection