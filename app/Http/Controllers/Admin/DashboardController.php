<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Official;
use App\Models\Post;
use App\Models\Product;

class DashboardController extends Controller
{
    /** Ringkasan isi situs untuk landing panel admin. */
    public function index()
    {
        $stats = [
            'posts' => [
                'label' => 'Berita & Pengumuman',
                'total' => Post::count(),
                'sub' => Post::where('is_published', true)->count() . ' terbit',
                'route' => 'admin.posts.index',
            ],
            'products' => [
                'label' => 'Produk Desa',
                'total' => Product::count(),
                'sub' => Product::where('is_published', true)->count() . ' terbit',
                'route' => 'admin.products.index',
            ],
            'officials' => [
                'label' => 'Perangkat Desa',
                'total' => Official::count(),
                'sub' => Official::where('is_head', true)->count() . ' kepala desa',
                'route' => 'admin.officials.index',
            ],
            'gallery' => [
                'label' => 'Foto Galeri',
                'total' => Gallery::count(),
                'sub' => 'item',
                'route' => 'admin.gallery.index',
            ],
        ];

        $recentPosts = Post::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }
}
