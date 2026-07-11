@php
    // Active state ditentukan dari nama route (BRIEF baris 59), bukan disalin
    // dari desain. Wildcard '*' agar halaman detail ikut menyalakan menunya
    // (mis. produk.show menyalakan "Produk", berita.show menyalakan "Berita").
    $links = [
        ['route' => 'beranda', 'label' => 'Beranda'],
        ['route' => 'profil', 'label' => 'Profil Desa'],
        ['route' => 'pemerintahan', 'label' => 'Pemerintahan'],
        ['route' => 'potensi', 'label' => 'Potensi'],
        ['route' => 'produk', 'label' => 'Produk'],
        ['route' => 'berita', 'label' => 'Berita'],
        ['route' => 'galeri', 'label' => 'Galeri'],
        ['route' => 'kontak', 'label' => 'Kontak'],
    ];
@endphp
<nav class="nav">
    <div class="wrap-x navrow">
        <a href="{{ route('beranda') }}" class="brandlink">
            <span class="emblem">W</span>
            <span>
                <span class="brand-name">Wonoboyo</span>
                <span class="brand-sub">Desa · Bondowoso</span>
            </span>
        </a>
        <div class="nav-links">
            @foreach ($links as $l)
                <a href="{{ route($l['route']) }}"
                   class="{{ request()->routeIs($l['route'] . '*') ? 'active' : '' }}">{{ $l['label'] }}</a>
            @endforeach
        </div>
        <button class="burger" aria-label="Menu"><span></span><span></span><span></span></button>
    </div>
</nav>
