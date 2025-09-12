@extends('layouts.app')

@section('title','Admin · Yazılar')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Yazılar</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">Yeni Yazı</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Başlık</th>
          <th>Durum</th>
          <th>Tarih</th>
          <th class="text-end">İşlemler</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
          <tr>
            <td>{{ $post->title }}</td>
            <td>
              @if($post->is_published)
                <span class="badge bg-success">Yayında</span>
              @else
                <span class="badge bg-secondary">Taslak</span>
              @endif
            </td>
            <td>{{ optional($post->published_at)->format('d.m.Y H:i') }}</td>
            <td class="text-end">
              <a href="{{ route('admin.posts.edit',$post) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
              <form action="{{ route('admin.posts.destroy',$post) }}" method="POST" class="d-inline" onsubmit="return confirm('Silinsin mi?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Sil</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Kayıt yok</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $posts->links() }}
@endsection