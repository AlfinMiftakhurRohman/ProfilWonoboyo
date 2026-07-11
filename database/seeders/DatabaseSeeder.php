<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Semua data di bawah ini adalah PLACEHOLDER bertanda dummy — bukan data
     * asli Desa Wonoboyo. Data lapangan (nama kepala desa, angka penduduk,
     * produk, dsb.) diisi admin lewat panel nanti. Jangan menebak/mengarang.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingsSeeder::class,
            OfficialsSeeder::class,
            PostsSeeder::class,
            GallerySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
