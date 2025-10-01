@extends('layouts.admin')

@section('title', 'Profil')

@section('content')
<style>
    .profile-container {
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
        padding: 3rem 2rem;
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
        animation: shimmer 4s ease-in-out infinite;
    }
    
    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        backdrop-filter: blur(10px);
        border: 4px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 1;
    }
    
    .profile-name {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }
    
    .profile-role {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }
    
    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-item {
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 0.25rem;
    }
    
    .profile-content {
        padding: 2.5rem;
    }
    
    .info-section {
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #4caf50;
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        background: linear-gradient(135deg, #81c784, #66bb6a);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #c8e6c9;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15);
    }
    
    .info-label {
        color: #2e7d32;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-value {
        color: #1b5e20;
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .profile-picture-section {
        text-align: center;
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid #c8e6c9;
        margin-bottom: 2rem;
    }
    
    .profile-picture-placeholder {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #81c784, #66bb6a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 3rem;
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
        text-decoration: none;
    }
    
    .btn-modern-secondary {
        background: white;
        border: 2px solid #c8e6c9;
        color: #4caf50;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-modern-secondary:hover {
        background: #f1f8e9;
        border-color: #66bb6a;
        color: #2e7d32;
        transform: translateY(-1px);
        text-decoration: none;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        flex-wrap: wrap;
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
    
    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem 0;
        }
        
        .profile-content {
            padding: 1.5rem;
        }
        
        .profile-stats {
            flex-direction: column;
            gap: 1rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .profile-name {
            font-size: 1.8rem;
        }
    }
</style>

<div class="profile-container">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-user-shield" style="font-size: 3rem;"></i>
                        </div>
                        <h1 class="profile-name">{{ $admin->name }}</h1>
                        <p class="profile-role">
                            <i class="fas fa-crown me-2"></i>
                            Sistem Yöneticisi
                        </p>
                        <div class="profile-stats">
                            <div class="stat-item">
                                <span class="stat-number">{{ \Carbon\Carbon::parse($admin->created_at)->diffInDays() }}</span>
                                <span class="stat-label">Gün Aktif</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ \Carbon\Carbon::parse($admin->updated_at)->diffInDays() }}</span>
                                <span class="stat-label">Son Güncelleme</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-content">
                        @if(session('success'))
                            <div class="alert-modern-success">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Kişisel Bilgiler
                            </h3>
                            
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i>
                                        Ad Soyad
                                    </div>
                                    <div class="info-value">{{ $admin->name }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i>
                                        E-posta Adresi
                                    </div>
                                    <div class="info-value">{{ $admin->email }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus"></i>
                                        Kayıt Tarihi
                                    </div>
                                    <div class="info-value">{{ $admin->created_at->format('d.m.Y H:i') }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-clock"></i>
                                        Son Güncelleme
                                    </div>
                                    <div class="info-value">{{ $admin->updated_at->format('d.m.Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="{{ route('admin.profile.edit') }}" class="btn-modern-primary">
                                <i class="fas fa-edit"></i>
                                Profili Düzenle
                            </a>
                            
                            <a href="{{ route('admin.dashboard') }}" class="btn-modern-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Dashboard'a Dön
                            </a>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection