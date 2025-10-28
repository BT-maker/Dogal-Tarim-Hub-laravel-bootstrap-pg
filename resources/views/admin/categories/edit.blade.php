@extends('layouts.admin')

@section('title', 'Kategoriyi Düzenle')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Kategoriyi Düzenle: {{ $category->name }}</h1>
    <p class="mb-4">Kategori bilgilerini güncelleyin.</p>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Kategori Adı</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="parent_id">Üst Kategori (İsteğe Bağlı)</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">Ana Kategori Olarak Ayarla</option>
                        @foreach ($categories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Açıklama (İsteğe Bağlı)</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
</div>
@endsection
