@extends('layouts.app')

@section('title', $post->title)

@section('content')
  <article class="mb-4">
    <h1 class="display-6">{{ $post->title }}</h1>
    @if($post->published_at)
      <div class="text-muted mb-3">{{ $post->published_at->format('d.m.Y H:i') }}</div>
    @endif
    <div class="fs-5">
      {!! nl2br(e($post->content)) !!}
    </div>
  </article>

  <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">← Listeye Dön</a>
@endsection