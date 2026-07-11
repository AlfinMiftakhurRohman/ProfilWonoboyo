<?php

namespace App\Http\Controllers;

use App\Models\Official;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // 3 post published terbaru (published_at menurun).
        $posts = Post::published()->latest('published_at')->take(3)->get();

        // 1 pengumuman published terbaru; view menyembunyikan blok jika null.
        $pengumuman = Post::published()->where('category', 'pengumuman')
            ->latest('published_at')->first();

        // Kepala desa untuk blok sambutan; view menyembunyikan blok jika null.
        $head = Official::head();

        return view('pages.beranda', compact('posts', 'pengumuman', 'head'));
    }
}
