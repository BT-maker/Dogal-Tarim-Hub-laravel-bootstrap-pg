<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //Anasayfa - Tüm postlaru listele
    public function index()
    {
        $posts = Post::published()
                    ->orderBy('published_at','desc')
                    ->paginate(6);

        return view('posts.index', compact('posts'));
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
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // Yeni post oluşturma formu
    public function create()
    {
        return view('admin.posts.create');
    }

    //Yeni post kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' =>'nullable|string|max:500',
        ]);

        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'excerpt' => $request->input('excerpt'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        return redirect()->route('admin.posts.index')
                         ->with('success','Post başarıyla oluşturuldu');
    }

    // Post düzenleme formu
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // Post güncelleme
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
        ]);

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'excerpt' => $request->input('excerpt'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$post->is_published ? now() : $post->published_at,
        ]);

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