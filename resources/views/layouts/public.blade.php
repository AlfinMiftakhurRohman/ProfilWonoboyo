<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Laman resmi profil Desa Wonoboyo, Kecamatan Klabang, Kabupaten Bondowoso, Jawa Timur.')">
    <title>@yield('title', 'Beranda') · Desa Wonoboyo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;1,6..72,400;1,6..72,500&family=Hanken+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    {{-- CSS + JS desain final dipakai apa adanya (keputusan strategi CSS) --}}
    @vite(['design/styles.css', 'design/site.js'])

    {{-- Utilitas kecil yang TIDAK diubah di styles.css (keputusan strategi CSS):
         (1) foto asli mengisi penuh kotak placeholder .ph, (2) gaya paginasi
         on-brand untuk view resources/views/pagination/wonoboyo.blade.php. --}}
    <style>
        .ph > img, .avatar > img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        .pager { display: flex; gap: 8px; justify-content: center; align-items: center; flex-wrap: wrap; margin-top: 56px; font-family: 'Space Mono', monospace; font-size: 13px; }
        .pager a, .pager span { min-width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 0 12px; border-radius: 8px; border: 1px solid rgba(27,26,21,.14); color: #20362a; transition: background .2s, color .2s, border-color .2s; }
        .pager a:hover { background: #20362a; color: #f6f1e7; border-color: #20362a; }
        .pager .active { background: #20362a; color: #f6f1e7; border-color: #20362a; }
        .pager .disabled { opacity: .38; }
    </style>

    {{-- Tambahan per-halaman: Leaflet, <style> inline, dsb. --}}
    @stack('styles')
</head>
<body>
    <x-site.nav />

    @yield('content')

    <x-site.footer />

    {{-- Script per-halaman: inisialisasi peta (Tahap 4), dll. --}}
    @stack('scripts')
</body>
</html>
