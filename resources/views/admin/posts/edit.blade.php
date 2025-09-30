@extends('layouts.app')

@section('title','Yazıyı Düzenle')

@section('content')
  <h1 class="h3 mb-3">Yazıyı Düzenle</h1>
  <form method="POST" action="{{ route('admin.posts.update',$post) }}" class="row g-3">
    @csrf
    @method('PUT')
    <div class="col-12">
      <label class="form-label">Başlık</label>
      <input name="title" class="form-control" value="{{ old('title',$post->title) }}">
    </div>
    <div class="col-12">
      <label class="form-label">Özet</label>
      <input name="excerpt" class="form-control" value="{{ old('excerpt',$post->excerpt) }}">
    </div>
    <div class="col-12">
      <label class="form-label">İçerik</label>
      <textarea name="content" class="form-control" rows="8">{{ old('content',$post->content) }}</textarea>
    </div>
    <div class="col-12">
      <label class="form-label">Kategoriler</label>
      <select name="categories[]" class="form-select" multiple>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" 
            {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
      <div class="form-text">Birden fazla kategori seçebilirsiniz (Ctrl+Click)</div>
    </div>
    <div class="col-12 form-check">
      <input class="form-check-input" type="checkbox" name="is_published" id="is_published" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
      <label class="form-check-label" for="is_published">Yayınla</label>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Güncelle</button>
      <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </form>
@endsection