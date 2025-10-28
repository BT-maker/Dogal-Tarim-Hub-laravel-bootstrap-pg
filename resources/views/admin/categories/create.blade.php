@extends('layouts.admin')

@section('title', 'Yeni Kategori Ekle')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Yeni Kategori Ekle</h1>
    <p class="mb-4">Yeni bir kategori oluşturun.</p>

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

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Kategori Adı</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="parent_id">Üst Kategori (İsteğe Bağlı)</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">Ana Kategori Olarak Ayarla</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Açıklama (İsteğe Bağlı)</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
</div>
@endsection
