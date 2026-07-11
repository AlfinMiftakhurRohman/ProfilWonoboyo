<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Berita & pengumuman PLACEHOLDER. Sengaja mencakup kasus uji untuk scope
 * Published: satu draft (is_published = false) dan satu terjadwal ke masa depan
 * (published_at > now) yang keduanya HARUS tersaring dari query publik.
 */
class PostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => '[JUDUL PENGUMUMAN CONTOH]',
                'category' => 'pengumuman',
                'author' => 'Admin Desa',
                'is_published' => true,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => '[JUDUL BERITA CONTOH 1]',
                'category' => 'berita',
                'author' => 'Admin Desa',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => '[JUDUL BERITA CONTOH 2]',
                'category' => 'berita',
                'author' => null, // menguji fallback penulis "Admin Desa" di view
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => '[BERITA DRAF — BELUM TAYANG]',
                'category' => 'berita',
                'author' => 'Admin Desa',
                'is_published' => false, // harus tersaring scope Published
                'published_at' => null,
            ],
            [
                'title' => '[BERITA TERJADWAL — TAYANG NANTI]',
                'category' => 'berita',
                'author' => 'Admin Desa',
                'is_published' => true,
                'published_at' => now()->addDays(5), // harus tersaring scope Published
            ],
        ];

        foreach ($posts as $data) {
            Post::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => '[Ringkasan singkat akan tampil di sini — diisi oleh admin desa.]',
                'body' => '<p>[Isi lengkap tulisan akan ditulis oleh admin desa. Placeholder ini hanya untuk menata tampilan.]</p>',
                'image' => null,
                'image_caption' => null,
                'category' => $data['category'],
                'author' => $data['author'],
                'is_published' => $data['is_published'],
                'published_at' => $data['published_at'],
                'attachment' => null,
                'attachment_name' => null,
            ]);
        }
    }
}
