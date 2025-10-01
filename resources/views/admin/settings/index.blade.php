@extends('layouts.admin')

@section('title', 'Site Ayarları')

@section('content')
<style>
    .settings-container {
        background: linear-gradient(135deg, #f8fffe 0%, #e8f5e8 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .settings-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(76, 175, 80, 0.1);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(76, 175, 80, 0.15);
    }
    
    .settings-header {
        background: linear-gradient(135deg, #81c784 0%, #66bb6a 100%);
        color: white;
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .settings-header::before {
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
    
    .settings-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 1;
    }
    
    .settings-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }
    
    .settings-subtitle {
        opacity: 0.9;
        margin-top: 0.5rem;
        position: relative;
        z-index: 1;
    }
    
    .form-section {
        padding: 2.5rem;
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
    
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .setting-group {
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #c8e6c9;
        transition: all 0.3s ease;
    }
    
    .setting-group:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15);
    }
    
    .modern-form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .modern-label {
        color: #2e7d32;
        font-weight: 600;
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
    
    .modern-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .modern-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e8f5e8;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafffe;
        cursor: pointer;
    }
    
    .modern-select:focus {
        outline: none;
        border-color: #66bb6a;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 187, 106, 0.1);
    }
    
    .switch-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .modern-switch {
        position: relative;
        width: 60px;
        height: 30px;
        background: #ddd;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .modern-switch.active {
        background: #66bb6a;
    }
    
    .switch-handle {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 24px;
        height: 24px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .modern-switch.active .switch-handle {
        transform: translateX(30px);
    }
    
    .switch-label {
        color: #2e7d32;
        font-weight: 500;
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
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
    }
    
    .form-actions {
        background: #fafffe;
        padding: 1.5rem 2rem;
        border-top: 1px solid #e8f5e8;
        display: flex;
        gap: 1rem;
        justify-content: center;
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
    
    .setting-description {
        color: #4a5568;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        line-height: 1.4;
    }
    
    @media (max-width: 768px) {
        .settings-container {
            padding: 1rem 0;
        }
        
        .form-section {
            padding: 1.5rem;
        }
        
        .settings-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-modern-primary {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="settings-container">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="settings-card">
                    <div class="settings-header">
                        <div class="settings-icon">
                            <i class="fas fa-cogs" style="font-size: 2.5rem;"></i>
                        </div>
                        <h1 class="settings-title">Site Ayarları</h1>
                        <p class="settings-subtitle">Web sitenizin genel ayarlarını yönetin</p>
                    </div>
                
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-section">
                            @if(session('success'))
                                <div class="alert-modern-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <h3 class="section-title">
                                <i class="fas fa-globe"></i>
                                Genel Ayarlar
                            </h3>

                            <div class="settings-grid">
                                <div class="setting-group">
                                    <div class="modern-form-group">
                                        <label for="site_name" class="modern-label">
                                            <i class="fas fa-tag me-1"></i>
                                            Site Adı
                                        </label>
                                        <input type="text" class="modern-input" id="site_name" name="site_name" 
                                               value="{{ old('site_name', $settings['site_name']) }}"
                                               placeholder="Web sitenizin adını girin">
                                        <div class="setting-description">
                                            Bu isim tarayıcı başlığında ve site genelinde görünecektir.
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label for="site_description" class="modern-label">
                                            <i class="fas fa-align-left me-1"></i>
                                            Site Açıklaması
                                        </label>
                                        <textarea class="modern-input modern-textarea" id="site_description" name="site_description" 
                                                  placeholder="Sitenizin kısa açıklamasını yazın">{{ old('site_description', $settings['site_description']) }}</textarea>
                                        <div class="setting-description">
                                            SEO için önemli olan site açıklamanız.
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label for="contact_email" class="modern-label">
                                            <i class="fas fa-envelope me-1"></i>
                                            İletişim E-postası
                                        </label>
                                        <input type="email" class="modern-input" id="contact_email" name="contact_email" 
                                               value="{{ old('contact_email', $settings['contact_email']) }}"
                                               placeholder="iletisim@siteniz.com">
                                        <div class="setting-description">
                                            Ziyaretçilerin sizinle iletişim kurabileceği e-posta adresi.
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-group">
                                    <div class="modern-form-group">
                                        <label for="posts_per_page" class="modern-label">
                                            <i class="fas fa-list me-1"></i>
                                            Sayfa Başına Yazı Sayısı
                                        </label>
                                        <select class="modern-select" id="posts_per_page" name="posts_per_page">
                                            <option value="5" {{ old('posts_per_page', $settings['posts_per_page']) == 5 ? 'selected' : '' }}>5 Yazı</option>
                                            <option value="10" {{ old('posts_per_page', $settings['posts_per_page']) == 10 ? 'selected' : '' }}>10 Yazı</option>
                                            <option value="15" {{ old('posts_per_page', $settings['posts_per_page']) == 15 ? 'selected' : '' }}>15 Yazı</option>
                                            <option value="20" {{ old('posts_per_page', $settings['posts_per_page']) == 20 ? 'selected' : '' }}>20 Yazı</option>
                                            <option value="25" {{ old('posts_per_page', $settings['posts_per_page']) == 25 ? 'selected' : '' }}>25 Yazı</option>
                                        </select>
                                        <div class="setting-description">
                                            Ana sayfada ve kategori sayfalarında gösterilecek yazı sayısı.
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label for="site_keywords" class="modern-label">
                                            <i class="fas fa-tags me-1"></i>
                                            Site Anahtar Kelimeleri
                                        </label>
                                        <input type="text" class="modern-input" id="site_keywords" name="site_keywords" 
                                               value="{{ old('site_keywords', $settings['site_keywords']) }}"
                                               placeholder="blog, yazı, makale, teknoloji">
                                        <div class="setting-description">
                                            SEO için anahtar kelimelerinizi virgülle ayırarak yazın.
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label class="modern-label">
                                            <i class="fas fa-comments me-1"></i>
                                            Yorum Ayarları
                                        </label>
                                        <div class="switch-container">
                                            <div class="modern-switch {{ old('allow_comments', $settings['allow_comments']) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this, 'allow_comments')">
                                                <div class="switch-handle"></div>
                                            </div>
                                            <span class="switch-label">Yorumlara İzin Ver</span>
                                        </div>
                                        <input type="hidden" id="allow_comments" name="allow_comments" 
                                               value="{{ old('allow_comments', $settings['allow_comments']) ? '1' : '0' }}">
                                        <div class="setting-description">
                                            Ziyaretçilerin yazılara yorum yapabilmesini sağlar.
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label class="modern-label">
                                            <i class="fas fa-tools me-1"></i>
                                            Bakım Modu
                                        </label>
                                        <div class="switch-container">
                                            <div class="modern-switch {{ old('site_maintenance', $settings['site_maintenance']) ? 'active' : '' }}" 
                                                 onclick="toggleSwitch(this, 'site_maintenance')">
                                                <div class="switch-handle"></div>
                                            </div>
                                            <span class="switch-label">Bakım Modunu Etkinleştir</span>
                                        </div>
                                        <input type="hidden" id="site_maintenance" name="site_maintenance" 
                                               value="{{ old('site_maintenance', $settings['site_maintenance']) ? '1' : '0' }}">
                                        <div class="setting-description">
                                            Aktif olduğunda site ziyaretçilere bakım sayfası gösterir.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-modern-primary">
                                <i class="fas fa-save me-2"></i>
                                Ayarları Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSwitch(element, inputName) {
    element.classList.toggle('active');
    const input = document.getElementById(inputName);
    input.value = element.classList.contains('active') ? '1' : '0';
}
</script>
@endsection