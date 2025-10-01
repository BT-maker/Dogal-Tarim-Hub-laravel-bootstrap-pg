@extends('layouts.admin')

@section('title','Kullanıcı Yönetimi - Yeşil Toprak')
@section('page-title','Kullanıcı Yönetimi')

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
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h1 class="modern-admin-title">Kullanıcı Yönetimi</h1>
                    <p class="modern-admin-subtitle">Sistem kullanıcılarını kolayca yönetin ve düzenleyin</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex gap-3 justify-content-md-end">
                <a href="{{ route('admin.dashboard') }}" class="modern-btn-outline">
                    <i class="fas fa-arrow-left me-2"></i>Dashboard
                </a>
                <button class="modern-btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fas fa-user-plus me-2"></i>Yeni Kullanıcı
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
            <i class="fas fa-users"></i>
        </div>
        <div class="modern-stats-number">{{ $users->count() }}</div>
        <p class="modern-stats-label">Toplam Kullanıcı</p>
    </div>
    
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #20c997, #17a2b8);">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="modern-stats-number">{{ $users->where('role', 'admin')->count() }}</div>
        <p class="modern-stats-label">Admin</p>
    </div>
    
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
            <i class="fas fa-user-edit"></i>
        </div>
        <div class="modern-stats-number">{{ $users->where('role', 'editor')->count() }}</div>
        <p class="modern-stats-label">Editör</p>
    </div>
    
    <div class="modern-stats-card">
        <div class="modern-stats-icon" style="background: linear-gradient(135deg, #6c757d, #495057);">
            <i class="fas fa-user"></i>
        </div>
        <div class="modern-stats-number">{{ $users->where('role', 'user')->count() }}</div>
        <p class="modern-stats-label">Kullanıcı</p>
    </div>
</div>

<!-- Modern Users Table -->
<div class="modern-table-container">
    <div class="modern-table-header">
        <div class="d-flex align-items-center">
            <div class="modern-table-icon me-3">
                <i class="fas fa-list"></i>
            </div>
            <div>
                <h4 class="modern-table-title">Kullanıcı Listesi</h4>
                <p class="modern-table-subtitle">Tüm sistem kullanıcılarını görüntüleyin ve yönetin</p>
            </div>
        </div>
        <div class="modern-table-actions">
            <div class="dropdown">
                <button class="modern-btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Filtrele
                </button>
                <ul class="dropdown-menu modern-dropdown">
                    <li><a class="dropdown-item" href="?role=admin"><i class="fas fa-user-shield me-2"></i>Admin</a></li>
                    <li><a class="dropdown-item" href="?role=editor"><i class="fas fa-user-edit me-2"></i>Editör</a></li>
                    <li><a class="dropdown-item" href="?role=user"><i class="fas fa-user me-2"></i>Kullanıcı</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?"><i class="fas fa-list me-2"></i>Tümü</a></li>
                </ul>
            </div>
            <button class="modern-btn-export">
                <i class="fas fa-download me-2"></i>Dışa Aktar
            </button>
        </div>
    </div>

    @if($users->count() > 0)
        <div class="modern-table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th>Kullanıcı</th>
                        <th>E-posta</th>
                        <th>Rol</th>
                        <th>Yazı Sayısı</th>
                        <th>Kayıt Tarihi</th>
                        <th>Son Giriş</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <i class="fas fa-check-circle text-success ms-1" title="E-posta doğrulandı"></i>
                                @else
                                    <i class="fas fa-exclamation-circle text-warning ms-1" title="E-posta doğrulanmadı"></i>
                                @endif
                            </td>
                            <td>
                                @switch($user->role ?? 'user')
                                    @case('admin')
                                        <span class="role-badge admin">
                                            <i class="fas fa-user-shield me-1"></i>Admin
                                        </span>
                                        @break
                                    @case('editor')
                                        <span class="role-badge editor">
                                            <i class="fas fa-user-edit me-1"></i>Editör
                                        </span>
                                        @break
                                    @default
                                        <span class="role-badge user">
                                            <i class="fas fa-user me-1"></i>Kullanıcı
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $user->posts->count() ?? 0 }} yazı
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $user->created_at->format('d.m.Y') }}
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Hiç giriş yapmadı' }}
                                </small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline-primary btn-sm" 
                                            onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role ?? 'user' }}')"
                                            data-bs-toggle="modal" data-bs-target="#editUserModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="#" class="d-inline" 
                                              onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled title="Kendi hesabınızı silemezsiniz">
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
                <i class="fas fa-users"></i>
            </div>
            <h4>Henüz kullanıcı yok</h4>
            <p class="text-muted">İlk kullanıcıyı oluşturmak için "Yeni Kullanıcı" butonuna tıklayın.</p>
            <button class="btn btn-organic" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-user-plus me-2"></i>İlk Kullanıcıyı Oluştur
            </button>
        </div>
    @endif
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Yeni Kullanıcı Oluştur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad Soyad *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rol</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user">Kullanıcı</option>
                            <option value="editor">Editör</option>
                            <option value="admin">Admin</option>
                        </select>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>Kullanıcı Düzenle
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#" id="editUserForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Ad Soyad *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">E-posta *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Yeni Şifre (Boş bırakın değiştirmek istemiyorsanız)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Rol</label>
                        <select class="form-select" id="edit_role" name="role">
                            <option value="user">Kullanıcı</option>
                            <option value="editor">Editör</option>
                            <option value="admin">Admin</option>
                        </select>
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

.modern-dropdown {
    border-radius: 15px;
    border: 1px solid #e9ecef;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    padding: 0.5rem 0;
}

.modern-dropdown .dropdown-item {
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    border-radius: 0;
}

.modern-dropdown .dropdown-item:hover {
    background: linear-gradient(135deg, #e8f5e8, #f0f9f0);
    color: #155724;
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

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 40px;
    height: 40px;
    background: var(--primary-green);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.1rem;
}

.role-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.role-badge.admin {
    background-color: #d1ecf1;
    color: #0c5460;
}

.role-badge.editor {
    background-color: #fff3cd;
    color: #856404;
}

.role-badge.user {
    background-color: #e2e3e5;
    color: #383d41;
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
function editUser(id, name, email, role) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('edit_password').value = '';
    document.getElementById('editUserForm').action = `/admin/users/${id}`;
}
</script>
@endsection