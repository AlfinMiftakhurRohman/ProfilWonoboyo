<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Filter kategori lewat query string (?kategori=), bukan JS — supaya
        // bisa dipadukan paginasi & link hasil filter bisa dibagikan.
        $kategori = $request->query('kategori');
        $query = Post::published()->latest('published_at');

        if (in_array($kategori, ['berita', 'pengumuman'], true)) {
            $query->where('category', $kategori);
        } else {
            $kategori = 'all';
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('pages.berita.index', compact('posts', 'kategori'));
    }

    public function show(string $slug)
    {
        // Slug tak tayang/tak ada → 404 rapi (scope Published menyaring draft).
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return view('pages.berita.show', compact('post'));
    }
}
