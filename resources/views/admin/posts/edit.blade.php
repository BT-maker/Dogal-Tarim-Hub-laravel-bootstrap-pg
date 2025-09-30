@extends('layouts.app')

@section('title','Yazıyı Düzenle - Yeşil Toprak')

@section('content')
<!-- Admin Header -->
<div class="admin-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <div class="admin-icon me-3">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="h2 mb-1" style="color: var(--primary-green);">
                        <i class="fas fa-edit me-2"></i>Yazıyı Düzenle
                    </h1>
                    <p class="text-muted mb-0">{{ Str::limit($post->title, 60) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex gap-2 justify-content-md-end">
                <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-info" target="_blank">
                    <i class="fas fa-eye me-2"></i>Önizle
                </a>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Geri Dön
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Form Container -->
<div class="admin-form-container">
    <form method="POST" action="{{ route('admin.posts.update',$post) }}" class="row g-4">
        @csrf
        @method('PUT')
        
        <div class="col-12">
            <label class="form-label fw-semibold">
                <i class="fas fa-heading me-2 text-organic"></i>Başlık
            </label>
            <input name="title" class="form-control form-control-lg" placeholder="Yazı başlığını girin..." value="{{ old('title',$post->title) }}">
            @error('title')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-12">
            <label class="form-label fw-semibold">
                <i class="fas fa-align-left me-2 text-organic"></i>Özet
            </label>
            <input name="excerpt" class="form-control" placeholder="Yazının kısa özetini girin..." value="{{ old('excerpt',$post->excerpt) }}">
            @error('excerpt')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-12">
            <label class="form-label fw-semibold">
                <i class="fas fa-file-alt me-2 text-organic"></i>İçerik
            </label>
            <textarea name="content" class="form-control" rows="12" placeholder="Yazı içeriğini buraya yazın...">{{ old('content',$post->content) }}</textarea>
            @error('content')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                <i class="fas fa-tags me-2 text-organic"></i>Kategoriler
            </label>
            <select name="categories[]" class="form-select" multiple size="5">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text">
                <i class="fas fa-info-circle me-1"></i>Birden fazla kategori seçebilirsiniz (Ctrl+Click)
            </div>
            @error('categories')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                <i class="fas fa-cog me-2 text-organic"></i>Yayın Ayarları
            </label>
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="is_published">
                            <i class="fas fa-eye me-2"></i>Yayında
                        </label>
                    </div>
                    <small class="text-muted">
                        @if($post->is_published)
                            Bu yazı şu anda yayında. İşareti kaldırırsanız taslak olur.
                        @else
                            Bu yazı şu anda taslak. İşaretlerseniz yayınlanır.
                        @endif
                    </small>
                    
                    @if($post->published_at)
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Yayın tarihi: {{ $post->published_at->format('d.m.Y H:i') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <hr class="my-4">
            <div class="d-flex gap-3 justify-content-end">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>İptal
                </a>
                <button type="submit" class="btn btn-organic btn-lg">
                    <i class="fas fa-save me-2"></i>Güncelle
                </button>
            </div>
        </div>
    </form>
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

.admin-form-container {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.form-label {
    color: var(--primary-green);
    margin-bottom: 0.75rem;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--accent-green);
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
}

.form-control-lg {
    padding: 1rem 1.25rem;
    font-size: 1.1rem;
}

.text-organic {
    color: var(--primary-green);
}

.form-check-input:checked {
    background-color: var(--accent-green);
    border-color: var(--accent-green);
}

@media (max-width: 768px) {
    .admin-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .admin-form-container {
        padding: 1.5rem;
    }
    
    .btn-lg {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .admin-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endsection