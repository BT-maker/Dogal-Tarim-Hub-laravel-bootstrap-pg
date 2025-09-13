@extends('layouts.app')

@section('title', 'Giriş Yap')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Giriş Yap</h4>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div id="error-message" class="alert alert-danger d-none"></div>
                    <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('auth.register') }}">Hesabınız yok mu? Kayıt olun</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
import AuthService from '/js/auth.js';

document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('error-message');
    
    const result = await AuthService.login(email, password);
    
    if (result.success) {
        window.location.href = '/admin/posts';
    } else {
        errorDiv.textContent = result.message || 'Giriş başarısız';
        errorDiv.classList.remove('d-none');
    }
});
</script>
@endsection
