@extends('layouts.admin')

@section('title', 'Profil Düzenle')

@section('content')
<style>
    .profile-edit-container {
        background: linear-gradient(135deg, #f8fffe 0%, #e8f5e8 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(76, 175, 80, 0.1);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(76, 175, 80, 0.15);
    }
    
    .profile-header {
        background: linear-gradient(135deg, #81c784 0%, #66bb6a 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }
    
    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255, 255, 255, 0.3);
    }
    
    .profile-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .profile-subtitle {
        opacity: 0.9;
        margin-top: 0.5rem;
    }
    
    .form-section {
        padding: 2rem;
    }
    
    .section-title {
        color: #4caf50;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title i {
        background: linear-gradient(135deg, #81c784, #66bb6a);
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    
    .modern-form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .modern-label {
        color: #2e7d32;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }
    
    .modern-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e8f5e8;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafffe;
    }
    
    .modern-input:focus {
        outline: none;
        border-color: #66bb6a;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 187, 106, 0.1);
        transform: translateY(-1px);
    }
    
    .modern-input.is-invalid {
        border-color: #f44336;
        background: #fff5f5;
    }
    
    .modern-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .password-section {
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
        border: 1px solid #c8e6c9;
    }
    
    .password-info {
        background: rgba(76, 175, 80, 0.1);
        border: 1px solid rgba(76, 175, 80, 0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        color: #2e7d32;
        font-size: 0.9rem;
    }
    
    .btn-modern-primary {
        background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
    }
    
    .btn-modern-secondary {
        background: white;
        border: 2px solid #c8e6c9;
        color: #4caf50;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-modern-secondary:hover {
        background: #f1f8e9;
        border-color: #66bb6a;
        color: #2e7d32;
        transform: translateY(-1px);
    }
    
    .alert-modern-success {
        background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
        border: none;
        border-radius: 12px;
        color: #1b5e20;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #4caf50;
    }
    
    .invalid-feedback {
        color: #d32f2f;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .form-actions {
        background: #fafffe;
        padding: 1.5rem 2rem;
        border-top: 1px solid #e8f5e8;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    
    @media (max-width: 768px) {
        .profile-edit-container {
            padding: 1rem 0;
        }
        
        .form-section {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-modern-primary,
        .btn-modern-secondary {
            width: 100%;
        }
    }
</style>

<div class="profile-edit-container">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-user-edit" style="font-size: 2.5rem;"></i>
                        </div>
                        <h2 class="profile-title">Profil Düzenle</h2>
                        <p class="profile-subtitle">Hesap bilgilerinizi güncelleyin</p>
                    </div>
                
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if(session('success'))
                            <div class="alert-modern-success">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-user"></i>
                                Genel Bilgiler
                            </h4>
                            
                            <div class="modern-form-group">
                                <label for="name" class="modern-label">
                                    <i class="fas fa-user me-1"></i>
                                    Ad Soyad
                                </label>
                                <input type="text" class="modern-input @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $admin->name) }}" 
                                       required placeholder="Adınızı ve soyadınızı girin">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modern-form-group">
                                <label for="email" class="modern-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    E-posta Adresi
                                </label>
                                <input type="email" class="modern-input @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $admin->email) }}" 
                                       required placeholder="E-posta adresinizi girin">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-lock"></i>
                                Şifre Değiştir
                            </h4>
                            
                            <div class="password-section">
                                <div class="password-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Şifrenizi değiştirmek istemiyorsanız bu alanları boş bırakın. Güvenlik için mevcut şifrenizi girmeniz gereklidir.
                                </div>
                                
                                <div class="modern-form-group">
                                    <label for="current_password" class="modern-label">
                                        <i class="fas fa-key me-1"></i>
                                        Mevcut Şifre
                                    </label>
                                    <input type="password" class="modern-input @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" 
                                           placeholder="Mevcut şifrenizi girin">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="modern-form-group">
                                    <label for="password" class="modern-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Yeni Şifre
                                    </label>
                                    <input type="password" class="modern-input @error('password') is-invalid @enderror" 
                                           id="password" name="password" minlength="8"
                                           placeholder="Yeni şifrenizi girin (en az 8 karakter)">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="modern-form-group">
                                    <label for="password_confirmation" class="modern-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Yeni Şifre (Tekrar)
                                    </label>
                                    <input type="password" class="modern-input" 
                                           id="password_confirmation" name="password_confirmation" minlength="8"
                                           placeholder="Yeni şifrenizi tekrar girin">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.profile.show') }}" class="btn-modern-secondary">
                                <i class="fas fa-times me-2"></i>
                                İptal
                            </a>
                            <button type="submit" class="btn-modern-primary">
                                <i class="fas fa-save me-2"></i>
                                Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const currentPasswordField = document.getElementById('current_password');
    
    passwordField.addEventListener('input', function() {
        if (this.value.length > 0) {
            currentPasswordField.setAttribute('required', 'required');
        } else {
            currentPasswordField.removeAttribute('required');
        }
    });
});
</script>
@endsection