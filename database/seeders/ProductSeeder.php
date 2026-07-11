<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Produk PLACEHOLDER (nama/penjual bertanda dummy). Mencakup ketiga kategori,
 * ketiga status availability, satu draf (is_published = false) untuk menguji
 * scope Published, dan tiap produk punya gambar (image null → placeholder) dengan
 * satu is_primary = true. seller_wa kosong; diisi admin dgn format internasional.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => '[PRODUK UMKM CONTOH]', 'category' => 'umkm', 'availability' => 'tersedia', 'price' => 15000, 'unit' => 'per pcs', 'is_published' => true, 'images' => 2],
            ['name' => '[HASIL TANI CONTOH]', 'category' => 'hasil_tani', 'availability' => 'habis', 'price' => 10000, 'unit' => 'per kg', 'is_published' => true, 'images' => 1],
            ['name' => '[OLAHAN CONTOH]', 'category' => 'olahan', 'availability' => 'pre_order', 'price' => 25000, 'unit' => 'per bungkus', 'is_published' => true, 'images' => 1],
            ['name' => '[PRODUK DRAF — BELUM TAYANG]', 'category' => 'umkm', 'availability' => 'tersedia', 'price' => 20000, 'unit' => 'per pcs', 'is_published' => false, 'images' => 1],
        ];

        foreach ($products as $i => $data) {
            $product = Product::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'category' => $data['category'],
                'description' => '[Deskripsi produk akan diisi oleh admin desa. Placeholder ini hanya untuk menata tampilan.]',
                'price' => $data['price'],
                'unit' => $data['unit'],
                'seller_name' => '[NAMA PENJUAL]',
                'seller_wa' => '',
                'availability' => $data['availability'],
                'is_published' => $data['is_published'],
                'sort_order' => $i,
            ]);

            for ($j = 0; $j < $data['images']; $j++) {
                $product->images()->create([
                    'image' => null,
                    'is_primary' => $j === 0,
                    'sort_order' => $j,
                ]);
            }
        }
    }
}
