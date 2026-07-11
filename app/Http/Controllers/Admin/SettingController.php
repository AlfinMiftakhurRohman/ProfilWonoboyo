<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Daftar key yang boleh diedit dari panel. Menjadi allowlist saat menyimpan
     * (key di luar daftar ini diabaikan) sekaligus acuan agar view & controller
     * tidak lepas sinkron dengan SettingsSeeder.
     */
    public const KEYS = [
        // Konten
        'sambutan_teks', 'sejarah', 'visi', 'misi',
        // Geografis
        'geo_ketinggian', 'geo_luas', 'geo_topografi',
        'geo_batas_utara', 'geo_batas_selatan', 'geo_batas_timur', 'geo_batas_barat',
        'geo_jarak_kota',
        // Statistik
        'stat_penduduk', 'stat_kk', 'stat_laki', 'stat_perempuan', 'stat_dusun',
        // Kontak
        'kontak_alamat', 'kontak_kodepos', 'kontak_telepon', 'kontak_wa',
        'kontak_email', 'kontak_jam_layanan',
        // Sosial media
        'sosmed_instagram', 'sosmed_facebook',
        // Peta
        'peta_center_lat', 'peta_center_lng', 'peta_zoom',
    ];

    public function edit()
    {
        $settings = Setting::map();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sambutan_teks' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'kontak_email' => 'nullable|email',
            'sosmed_instagram' => 'nullable|url',
            'sosmed_facebook' => 'nullable|url',
            'peta_center_lat' => 'nullable|numeric',
            'peta_center_lng' => 'nullable|numeric',
            'peta_zoom' => 'nullable|integer|min:1|max:20',
        ]);

        // Simpan hanya key yang ada di allowlist; kolom kosong tetap disimpan
        // sebagai string kosong agar konsisten dengan konvensi seeder.
        foreach (self::KEYS as $key) {
            Setting::set($key, (string) $request->input($key, ''));
        }

        return back()->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}
