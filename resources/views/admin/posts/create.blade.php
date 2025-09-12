@extends('layouts.app')

@section('title','Yeni Yazı')

@section('content')
  <h1 class="h3 mb-3">Yeni Yazı</h1>
  <form method="POST" action="{{ route('admin.posts.store') }}" class="row g-3">
    @csrf
    <div class="col-12">
      <label class="form-label">Başlık</label>
      <input name="title" class="form-control" placeholder="Başlık" value="{{ old('title') }}">
    </div>
    <div class="col-12">
      <label class="form-label">Özet</label>
      <input name="excerpt" class="form-control" placeholder="Kısa özet" value="{{ old('excerpt') }}">
    </div>
    <div class="col-12">
      <label class="form-label">İçerik</label>
      <textarea name="content" class="form-control" rows="8" placeholder="İçerik">{{ old('content') }}</textarea>
    </div>
    <div class="col-12 form-check">
      <input class="form-check-input" type="checkbox" name="is_published" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
      <label class="form-check-label" for="is_published">Yayınla</label>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Kaydet</button>
      <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </form>
@endsection