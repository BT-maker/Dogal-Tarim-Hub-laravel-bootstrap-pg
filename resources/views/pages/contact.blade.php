@extends('layouts.app')

@section('title', 'İletişim - Yeşil Toprak')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="display-5 fw-bold mb-4">İletişim</h1>
            <p class="lead mb-5">Soru, görüş ve önerileriniz için bizimle iletişime geçmekten çekinmeyin. Size en kısa sürede geri dönüş yapacağız.</p>

            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Adınız Soyadınız</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta Adresiniz</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Konu</label>
                    <input type="text" class="form-control" id="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mesajınız</label>
                    <textarea class="form-control" id="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-organic">
                    <i class="fas fa-paper-plane me-2"></i>Gönder
                </button>
            </form>
        </div>
    </div>
</div>
@endsection