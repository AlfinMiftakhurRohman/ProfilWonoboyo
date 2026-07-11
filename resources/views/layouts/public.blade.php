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
