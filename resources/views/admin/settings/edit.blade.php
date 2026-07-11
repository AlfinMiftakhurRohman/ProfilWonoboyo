@extends('layouts.admin')

@section('title', 'Pengaturan Situs')

@section('content')
    <p class="text-sm text-muted mb-6 max-w-2xl">
        Data di sini dipakai bersama oleh banyak halaman publik (footer, kontak, profil, beranda).
        Kolom yang dikosongkan otomatis disembunyikan di situs.
    </p>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Konten naratif --}}
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <h2 class="font-semibold text-forest mb-1">Konten Naratif</h2>
            <p class="text-xs text-muted mb-5">Teks sambutan, sejarah, visi & misi. Boleh beberapa paragraf.</p>
            <div class="space-y-4">
                <x-admin.textarea name="sambutan_teks" label="Sambutan Kepala Desa" :value="$settings['sambutan_teks'] ?? ''" rows="3" />
                <x-admin.textarea name="sejarah" label="Sejarah Desa" :value="$settings['sejarah'] ?? ''" rows="4" />
                <div class="grid sm:grid-cols-2 gap-4">
                    <x-admin.textarea name="visi" label="Visi" :value="$settings['visi'] ?? ''" rows="3" />
                    <x-admin.textarea name="misi" label="Misi" :value="$settings['misi'] ?? ''" rows="3" hint="Satu misi per baris." />
                </div>
            </div>
        </section>

        {{-- Geografis --}}
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <h2 class="font-semibold text-forest mb-5">Kondisi Geografis</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <x-admin.input name="geo_ketinggian" label="Ketinggian" :value="$settings['geo_ketinggian'] ?? ''" placeholder="mis. 450–700" hint="Angka saja (mdpl)" />
                <x-admin.input name="geo_luas" label="Luas Wilayah" :value="$settings['geo_luas'] ?? ''" placeholder="mis. 1.250" hint="Angka saja (hektar)" />
                <x-admin.input name="geo_topografi" label="Topografi" :value="$settings['geo_topografi'] ?? ''" placeholder="mis. Perbukitan berlereng" />
                <x-admin.input name="geo_batas_utara" label="Batas Utara" :value="$settings['geo_batas_utara'] ?? ''" />
                <x-admin.input name="geo_batas_selatan" label="Batas Selatan" :value="$settings['geo_batas_selatan'] ?? ''" />
                <x-admin.input name="geo_batas_timur" label="Batas Timur" :value="$settings['geo_batas_timur'] ?? ''" />
                <x-admin.input name="geo_batas_barat" label="Batas Barat" :value="$settings['geo_batas_barat'] ?? ''" />
                <x-admin.input name="geo_jarak_kota" label="Jarak ke Kota" :value="$settings['geo_jarak_kota'] ?? ''" placeholder="mis. 25" hint="Angka saja (km)" />
            </div>
        </section>

        {{-- Statistik --}}
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <h2 class="font-semibold text-forest mb-5">Statistik Kependudukan</h2>
            <div class="grid sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <x-admin.input name="stat_penduduk" label="Total Penduduk" :value="$settings['stat_penduduk'] ?? ''" />
                <x-admin.input name="stat_kk" label="Kepala Keluarga" :value="$settings['stat_kk'] ?? ''" />
                <x-admin.input name="stat_laki" label="Laki-laki" :value="$settings['stat_laki'] ?? ''" />
                <x-admin.input name="stat_perempuan" label="Perempuan" :value="$settings['stat_perempuan'] ?? ''" />
                <x-admin.input name="stat_dusun" label="Jumlah Dusun" :value="$settings['stat_dusun'] ?? ''" />
            </div>
        </section>

        {{-- Kontak --}}
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <h2 class="font-semibold text-forest mb-5">Kontak</h2>
            <div class="space-y-4">
                <x-admin.textarea name="kontak_alamat" label="Alamat Kantor" :value="$settings['kontak_alamat'] ?? ''" rows="2" />
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <x-admin.input name="kontak_kodepos" label="Kode Pos" :value="$settings['kontak_kodepos'] ?? ''" />
                    <x-admin.input name="kontak_telepon" label="Telepon" :value="$settings['kontak_telepon'] ?? ''" />
                    <x-admin.input name="kontak_wa" label="WhatsApp" :value="$settings['kontak_wa'] ?? ''" placeholder="6281234567890" hint="Format internasional tanpa +" />
                    <x-admin.input name="kontak_email" type="email" label="Email" :value="$settings['kontak_email'] ?? ''" />
                    <x-admin.input name="kontak_jam_layanan" label="Jam Layanan" :value="$settings['kontak_jam_layanan'] ?? ''" class="lg:col-span-2" />
                </div>
            </div>
        </section>

        {{-- Sosial media --}}
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <h2 class="font-semibold text-forest mb-5">Media Sosial</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <x-admin.input name="sosmed_instagram" type="url" label="Instagram (URL)" :value="$settings['sosmed_instagram'] ?? ''" placeholder="https://instagram.com/..." />
                <x-admin.input name="sosmed_facebook" type="url" label="Facebook (URL)" :value="$settings['sosmed_facebook'] ?? ''" placeholder="https://facebook.com/..." />
            </div>
        </section>

        {{-- Peta --}}
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <h2 class="font-semibold text-forest mb-1">Titik Peta</h2>
            <p class="text-xs text-muted mb-5">Koordinat kantor desa untuk peta di halaman Profil & Kontak.</p>
            <div class="grid sm:grid-cols-3 gap-4">
                <x-admin.input name="peta_center_lat" label="Latitude" :value="$settings['peta_center_lat'] ?? ''" placeholder="-7.905" />
                <x-admin.input name="peta_center_lng" label="Longitude" :value="$settings['peta_center_lng'] ?? ''" placeholder="113.905" />
                <x-admin.input name="peta_zoom" label="Zoom" :value="$settings['peta_zoom'] ?? ''" placeholder="14" hint="1–20 (makin besar makin dekat)" />
            </div>
        </section>

        <div class="sticky bottom-0 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-4 bg-cream/90 backdrop-blur border-t border-ink/10 flex justify-end">
            <button type="submit" class="rounded-lg bg-forest px-6 py-2.5 text-sm font-semibold text-cream hover:bg-forest-2 transition">
                Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
