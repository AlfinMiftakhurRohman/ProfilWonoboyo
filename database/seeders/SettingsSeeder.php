<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Isi tabel settings dengan PLACEHOLDER. Konvensi nilai:
 *  - ''  (kosong)         : datum nyata yang belum diketahui (angka, nomor,
 *                           kode pos, URL sosmed). View publik menyembunyikan
 *                           elemen atau menampilkan placeholder konsisten.
 *  - '[… diisi admin]'    : blok teks naratif, supaya jelas dummy di panel.
 *  - teks generik aman    : sambutan/alamat/jam layanan yang sudah ada di desain
 *                           dan tidak mengandung data karangan.
 *
 * Koordinat peta = PLACEHOLDER kasar wilayah Klabang, hanya agar Leaflet bisa
 * dirender. BUKAN titik kantor desa asli — ganti dengan hasil survei lapangan.
 */
class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Konten
            'sambutan_teks' => 'Terima kasih sudah menyempatkan singgah di laman desa kami. Lewat halaman ini, kami ingin memperkenalkan Wonoboyo apa adanya — sawah dan ladangnya, orang-orangnya, dan kegiatan sehari-hari yang kami jalani bersama.',
            'sejarah' => '[Sejarah Desa Wonoboyo — diisi admin]',
            'visi' => '[Visi Desa Wonoboyo — diisi admin]',
            'misi' => '[Misi Desa Wonoboyo — diisi admin]',

            // Geografis (angka pasti menunggu data survei → kosong)
            'geo_ketinggian' => '',
            'geo_luas' => '',
            'geo_topografi' => '[Topografi wilayah — diisi admin]',
            'geo_batas_utara' => '',
            'geo_batas_selatan' => '',
            'geo_batas_timur' => '',
            'geo_batas_barat' => '',
            'geo_jarak_kota' => '',

            // Statistik kependudukan (menunggu data administrasi desa → kosong)
            'stat_penduduk' => '',
            'stat_kk' => '',
            'stat_laki' => '',
            'stat_perempuan' => '',
            'stat_dusun' => '',

            // Kontak
            'kontak_alamat' => 'Kantor Desa Wonoboyo, Kec. Klabang, Kab. Bondowoso, Jawa Timur',
            'kontak_kodepos' => '',
            'kontak_telepon' => '',
            'kontak_wa' => '',
            'kontak_email' => '',
            'kontak_jam_layanan' => 'Senin–Jumat, jam kerja',

            // Sosial media (URL penuh; kosong = ikon disembunyikan)
            'sosmed_instagram' => '',
            'sosmed_facebook' => '',

            // Peta — PLACEHOLDER kasar Klabang, ganti dgn titik kantor desa
            'peta_center_lat' => '-7.8600',
            'peta_center_lng' => '113.9700',
            'peta_zoom' => '14',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
