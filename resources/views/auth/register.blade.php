@extends('layouts.app')

@section('title', 'Kayıt Ol')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Kayıt Ol</h4>
            </div>
            <div class="card-body">
                <form id="registerForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div id="error-message" class="alert alert-danger d-none"></div>
                    <button type="submit" class="btn btn-primary w-100">Kayıt Ol</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('auth.login') }}">Zaten hesabınız var mı? Giriş yapın</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/auth.js"></script>
<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('error-message');
    
    if (password.length < 6) {
        errorDiv.textContent = 'Şifre en az 6 karakter olmalıdır';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    const result = await window.AuthService.register(name, email, password);
    
    if (result.success) {
        window.location.href = '/admin/posts';
    } else {
        errorDiv.textContent = result.message || 'Kayıt başarısız';
        errorDiv.classList.remove('d-none');
    }
});
</script>

@endsection
