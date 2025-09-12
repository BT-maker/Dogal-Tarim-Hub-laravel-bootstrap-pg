@extends('layouts.app')

@section('title','Yazılar')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Yazılar</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">Yeni Yazı</a>
  </div>

  <div class="list-group mb-3">
    @forelse($posts as $post)
      <a class="list-group-item list-group-item-action" href="{{ route('post.show',$post) }}">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">{{ $post->title }}</h5>
          @if($post->published_at)
            <small class="text-muted">{{ $post->published_at->format('d.m.Y') }}</small>
          @endif
        </div>
        @if($post->excerpt)
          <p class="mb-1 text-muted">{{ $post->excerpt }}</p>
        @endif
      </a>
    @empty
      <div class="alert alert-info">Henüz yazı yok.</div>
    @endforelse
  </div>

  {{ $posts->links() }}
@endsection