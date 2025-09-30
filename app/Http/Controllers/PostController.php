<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //Anasayfa - Tüm postlaru listele
    public function index()
    {
        $posts = Post::published()
                    ->orderBy('published_at','desc')
                    ->paginate(6);

        return view('welcome', compact('posts'));
    }

    // Posts listesi sayfası
    public function posts(Request $request)
    {
        $query = Post::published()->with(['user', 'categories']);

        // Arama işlevselliği
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Kategori filtreleme
        if ($request->filled('category')) {
            $categoryId = $request->get('category');
            $query->whereHas('categories', function($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Sıralama
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'popular':
                // Gelecekte view count eklenebilir
                $query->orderBy('published_at', 'desc');
                break;
            default: // newest
                $query->orderBy('published_at', 'desc');
                break;
        }

        $posts = $query->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    // Tekil post görüntüleme
    public function show(Post $post)
    {
        if (!$post->is_published){
            abort(404);
        }
        return view('posts.show', compact('post'));
    }

    // Admin panel için post listesi
    public function admin()
    {
        $posts = Post::with(['user', 'categories'])->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // Yeni post oluşturma formu
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    //Yeni post kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' =>'nullable|string|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'excerpt' => $request->input('excerpt'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'user_id' => auth()->id() ?? 1, // Geçici olarak 1, sonra auth middleware eklenecek
        ]);

        // Kategorileri ekle
        if ($request->has('categories')) {
            $post->categories()->sync($request->input('categories'));
        }

        return redirect()->route('admin.posts.index')
                         ->with('success','Post başarıyla oluşturuldu');
    }

    // Post düzenleme formu
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // Post güncelleme
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'excerpt' => $request->input('excerpt'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$post->is_published ? now() : $post->published_at,
        ]);

        // Kategorileri güncelle
        $post->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.posts.index')
                         ->with('success','Post başarıyla güncellendi');
    }

    // Post silme
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
                         ->with('success','Post başarıyla silindi');
    }
}