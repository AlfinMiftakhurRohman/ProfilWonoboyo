@extends('layouts.public')

@section('title', 'Profil Desa')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    {{-- Dropcap paragraf pertama sejarah (body dinamis pola sama seperti berita). --}}
    <style>
        .body-lg.wrap-narrow > p.dropcap::first-letter { font-family: 'Newsreader', serif; font-size: 4.4em; line-height: .82; float: left; padding: 6px 12px 0 0; color: #20362a; font-weight: 500; }
    </style>
@endpush

@section('content')
    {{--
        Diporting dari design/Profil-Desa.dc.html. Prosa naratif (sejarah, visi,
        misi, topografi) = teks desain statis. Angka geografis & statistik ditarik
        dari $settings (kosong → "—"), tidak pernah dikarang. Peta = Leaflet dgn
        pusat dari $settings peta_*. Editing prosa lewat panel = Tahap 3.
    --}}
    @php
        $fact = fn ($key, $suffix = '') => filled($settings[$key] ?? null) ? $settings[$key] . $suffix : '—';
        // Prosa dari Pengaturan dipakai bila sudah diisi admin (bukan placeholder
        // '[...]'); selain itu tampilkan teks bawaan desain di bawah ini.
        $hasProse = fn ($key) => filled($settings[$key] ?? null) && ! str_starts_with(trim($settings[$key]), '[');
    @endphp

    <header class="phero">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto lanskap perbukitan desa · 1920 × 900</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Profil Desa</span>
            </div>
            <h1 class="phero-title">Mengenal Wonoboyo</h1>
            <p class="phero-sub">Dari sejarah yang membentuknya hingga tanah dan warga yang menghidupinya hari ini.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="sec-head stack" style="margin-bottom:40px">
                <div class="eyebrow reveal">Sejarah Desa</div>
                <h2 class="h2 reveal">Bermula dari sebidang<br>tanah subur di lereng</h2>
            </div>
            <div class="body-lg wrap-narrow reveal d1">
                @if ($hasProse('sejarah'))
                    @foreach (preg_split('/\R+/u', trim($settings['sejarah'])) as $i => $par)
                        <p @class(['dropcap' => $i === 0])>{{ $par }}</p>
                    @endforeach
                @else
                    <p class="dropcap">Konon nama Wonoboyo berasal dari kata "wono" (hutan) dan "boyo" (bahaya) — sebutan bagi kawasan hutan lebat di lereng yang dulu ditakuti pendatang. Seiring waktu, rombongan perintis membuka lahan, menetap, dan menjadikan tanah di perbukitan ini ladang yang subur.</p>
                    <p>Sejak dulu warga Wonoboyo hidup dari bertani. Sawah dan ladang di lereng-lereng bukit digarap turun-temurun, mengandalkan kesuburan tanah dan air yang mengalir dari perbukitan.</p>
                    <p>Seiring waktu desa terus berbenah — memperbaiki jalan, saluran irigasi, dan pelayanan bagi warga. Sebuah cafe di ketinggian sempat dirintis sebagai daya tarik, namun kini tidak lagi beroperasi. Wonoboyo tetap menjadi desa agraris yang tenang, khas kampung perbukitan.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="sec-sm bg-sand">
        <div class="wrap-x">
            <div class="vm-grid">
                <div class="vm-card vm-visi reveal">
                    <div class="vm-label">Visi</div>
                    @if ($hasProse('visi'))
                        <p>{{ $settings['visi'] }}</p>
                    @else
                        <p>Terwujudnya Desa Wonoboyo yang mandiri, sejahtera, dan lestari — bertumpu pada pertanian, pelayanan publik yang baik, dan kegotongroyongan warganya.</p>
                    @endif
                </div>
                <div class="vm-card reveal d1">
                    <div class="vm-label">Misi</div>
                    <ol class="misi-list">
                        @if ($hasProse('misi'))
                            @foreach (preg_split('/\R+/u', trim($settings['misi'])) as $poin)
                                <li>{{ $poin }}</li>
                            @endforeach
                        @else
                            <li>Meningkatkan hasil dan kesejahteraan petani serta peternak desa.</li>
                            <li>Menumbuhkan UMKM dan usaha warga sebagai penghasilan tambahan.</li>
                            <li>Meningkatkan kualitas layanan publik dan infrastruktur dasar desa.</li>
                            <li>Menjaga kelestarian lingkungan dan sumber air desa.</li>
                            <li>Memperkuat kegotongroyongan dan kehidupan sosial warga.</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="sec">
        <div class="wrap-x">
            <div class="sec-head stack" style="margin-bottom:36px">
                <div class="eyebrow reveal">Kondisi Geografis</div>
                <h2 class="h2 reveal">Desa perbukitan di<br>ketinggian sejuk</h2>
            </div>
            <div class="facts reveal d1">
                <div class="fact">
                    <div class="fact-k">Ketinggian</div>
                    <div class="fact-v">{{ $fact('geo_ketinggian', ' mdpl') }}</div>
                </div>
                <div class="fact">
                    <div class="fact-k">Luas Wilayah</div>
                    <div class="fact-v">{{ $fact('geo_luas', ' hektar') }}</div>
                </div>
                <div class="fact">
                    <div class="fact-k">Topografi</div>
                    <div class="fact-v">{{ filled($settings['geo_topografi'] ?? null) && ! str_starts_with($settings['geo_topografi'], '[') ? $settings['geo_topografi'] : 'Perbukitan berlereng' }}</div>
                </div>
                <div class="fact">
                    <div class="fact-k">Batas Utara</div>
                    <div class="fact-v">{{ $fact('geo_batas_utara') }}</div>
                </div>
                <div class="fact">
                    <div class="fact-k">Batas Selatan</div>
                    <div class="fact-v">{{ $fact('geo_batas_selatan') }}</div>
                </div>
                <div class="fact">
                    <div class="fact-k">Jarak ke Kota</div>
                    <div class="fact-v">{{ filled($settings['geo_jarak_kota'] ?? null) ? $settings['geo_jarak_kota'] . ' km dari Bondowoso' : '—' }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec-sm">
        <div class="wrap-x">
            <div class="sec-head stack" style="margin-bottom:36px">
                <div class="eyebrow reveal">Peta Wilayah</div>
                <h2 class="h2 reveal">Letak &amp; batas desa</h2>
            </div>
            <div class="mapwrap reveal d1">
                <div id="map" class="mapel"></div>
                <div class="map-note">Batas wilayah pada peta bersifat <strong>ilustratif</strong> dan bukan acuan hukum administrasi.</div>
            </div>
        </div>
    </section>

    <section class="sec bg-forest">
        <div class="wrap-x">
            <div class="eyebrow reveal" style="color:#e8c79a">Statistik Kependudukan</div>
            <h2 class="h2 cream reveal" style="margin-top:18px;margin-bottom:56px;max-width:640px">Potret warga Wonoboyo</h2>
            <div class="demo-grid">
                <div class="bignums reveal">
                    <div class="bignum"><div class="n">{{ $fact('stat_penduduk') }}</div><div class="u">Jiwa</div><div class="l" style="color:rgba(246,241,231,.7)">Total penduduk</div></div>
                    <div class="bignum"><div class="n">{{ $fact('stat_kk') }}</div><div class="u">KK</div><div class="l" style="color:rgba(246,241,231,.7)">Kepala keluarga</div></div>
                    <div class="bignum"><div class="n">{{ $fact('stat_laki') }}</div><div class="u">Jiwa</div><div class="l" style="color:rgba(246,241,231,.7)">Laki-laki</div></div>
                    <div class="bignum"><div class="n">{{ $fact('stat_perempuan') }}</div><div class="u">Jiwa</div><div class="l" style="color:rgba(246,241,231,.7)">Perempuan</div></div>
                </div>
                <div class="reveal d1">
                    <div style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#e8c79a;margin-bottom:22px">Komposisi Mata Pencaharian</div>
                    <p style="color:rgba(246,241,231,.82);font-size:15.5px;line-height:1.75;max-width:440px;margin:0">Rincian komposisi mata pencaharian warga sedang dihimpun dari hasil pendataan desa dan akan ditampilkan di bagian ini.</p>
                </div>
            </div>
            <p class="stats-note">* Angka bersifat ilustratif — akan diperbarui sesuai data administrasi desa terbaru.</p>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function () {
            function start() {
                if (!window.L) { setTimeout(start, 200); return; }
                var el = document.getElementById('map');
                if (!el || el._map) return;
                var center = [{{ $settings['peta_center_lat'] ?? -7.905 }}, {{ $settings['peta_center_lng'] ?? 113.905 }}];
                var map = L.map(el, { scrollWheelZoom: false }).setView(center, {{ $settings['peta_zoom'] ?? 13 }});
                el._map = map;
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '© OpenStreetMap' }).addTo(map);
                // Poligon batas bersifat ILUSTRATIF (dari desain), bukan acuan hukum.
                var poly = [[-7.882,113.878],[-7.876,113.912],[-7.888,113.938],[-7.912,113.945],[-7.931,113.930],[-7.935,113.900],[-7.922,113.872],[-7.899,113.865]];
                var shape = L.polygon(poly, { color: '#20362a', weight: 2, fillColor: '#5f7d48', fillOpacity: 0.22 }).addTo(map);
                map.fitBounds(shape.getBounds(), { padding: [30, 30] });
                L.marker(center).addTo(map).bindPopup('<b>Kantor Desa Wonoboyo</b><br>Klabang, Bondowoso');
                setTimeout(function () { map.invalidateSize(); }, 300);
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start); else start();
        })();
    </script>
@endpush
