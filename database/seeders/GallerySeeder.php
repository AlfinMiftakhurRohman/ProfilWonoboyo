<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

/**
 * Item galeri PLACEHOLDER dengan ratio bervariasi untuk menguji layout masonry.
 * image sengaja null → view merender placeholder desain (.ph), bukan ikon rusak.
 */
class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $ratios = ['4/5', '1/1', '3/4', '16/10', '1/1', '4/5'];

        foreach ($ratios as $i => $ratio) {
            Gallery::create([
                'title' => '[FOTO KEGIATAN DESA ' . ($i + 1) . ']',
                'image' => null,
                'caption' => null,
                'ratio' => $ratio,
                'sort_order' => $i,
            ]);
        }
    }
}
