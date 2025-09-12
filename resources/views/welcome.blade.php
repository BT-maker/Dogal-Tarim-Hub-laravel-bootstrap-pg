<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Blog Sitem</h1>
            <p class="text-gray-600">En güncel yazılarımı burada bulabilirsiniz</p>
        </header>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="{{ route('post.show', $post) }}" class="text-gray-800 hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </h2>
                        @if($post->excerpt)
                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                        @endif
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>{{ $post->published_at->format('d.m.Y') }}</span>
                            <a href="{{ route('post.show', $post) }}" class="text-blue-600 hover:text-blue-800">
                                Devamını Oku →
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 text-lg">Henüz yayınlanmış yazı bulunmuyor.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</body>
</html>