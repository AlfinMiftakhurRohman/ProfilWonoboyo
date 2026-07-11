@extends('layouts.public')

@section('title', 'Kontak')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
    {{--
        Diporting dari design/Kontak.dc.html. Info kontak ditarik dari $settings
        (kosong → "—"); jam layanan & daftar layanan = teks desain statis. Peta =
        Leaflet dengan pusat dari $settings peta_*.
    --}}
    <header class="phero">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto kantor desa · 1920 × 900</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Kontak</span>
            </div>
            <h1 class="phero-title">Hubungi Kami</h1>
            <p class="phero-sub">Kantor Desa Wonoboyo siap membantu warga maupun tamu. Datang langsung atau hubungi kami.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="contact-grid">
                <div class="reveal">
                    <div class="eyebrow" style="margin-bottom:24px">Informasi Kontak</div>

                    <div class="info-row">
                        <span class="info-ic">⌖</span>
                        <div>
                            <div class="info-k">Alamat Kantor</div>
                            <div class="info-v">
                                {{ $settings['kontak_alamat'] ?? 'Kantor Desa Wonoboyo, Kec. Klabang, Kab. Bondowoso, Jawa Timur' }}
                                @if (filled($settings['kontak_kodepos'] ?? null))<br>Kode Pos {{ $settings['kontak_kodepos'] }}@endif
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="info-ic">✆</span>
                        <div>
                            <div class="info-k">Telepon / WhatsApp</div>
                            <div class="info-v">
                                {{ filled($settings['kontak_telepon'] ?? null) ? $settings['kontak_telepon'] : '—' }}<br>
                                @php $wa = wa_link($settings['kontak_wa'] ?? null, 'Halo, saya ingin bertanya kepada Kantor Desa Wonoboyo.'); @endphp
                                @if ($wa)
                                    <a href="{{ $wa }}" target="_blank" rel="noopener">WhatsApp: {{ $settings['kontak_wa'] }}</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="info-ic">✉</span>
                        <div>
                            <div class="info-k">Email</div>
                            <div class="info-v">
                                @if (filled($settings['kontak_email'] ?? null))
                                    <a href="mailto:{{ $settings['kontak_email'] }}">{{ $settings['kontak_email'] }}</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="info-ic">◷</span>
                        <div>
                            <div class="info-k">Jam Layanan</div>
                            <div class="info-v">Senin–Kamis: 08.00 – 15.00<br>Jumat: 08.00 – 11.00<br>Sabtu–Minggu &amp; libur: tutup</div>
                        </div>
                    </div>
                </div>

                <div class="reveal d1">
                    <div class="mapwrap">
                        <div id="map" class="mapel" style="height:520px"></div>
                        <div class="map-note">Titik pin menunjukkan perkiraan lokasi kantor desa.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec-sm bg-sand">
        <div class="wrap-x">
            <div class="sec-head stack" style="margin-bottom:40px">
                <div class="eyebrow reveal">Layanan Kantor Desa</div>
                <h2 class="h2 reveal">Mengurus surat &amp; administrasi</h2>
            </div>
            <div class="svc-grid">
                <div class="svc reveal">
                    <div class="svc-num">01</div>
                    <h4>Surat Pengantar</h4>
                    <ul>
                        <li>KTP &amp; Kartu Keluarga</li>
                        <li>Surat keterangan domisili</li>
                        <li>Surat keterangan usaha</li>
                    </ul>
                </div>
                <div class="svc reveal d1">
                    <div class="svc-num">02</div>
                    <h4>Persyaratan Umum</h4>
                    <ul>
                        <li>Fotokopi KTP &amp; KK</li>
                        <li>Surat pengantar RT/RW</li>
                        <li>Datang pada jam layanan</li>
                    </ul>
                </div>
                <div class="svc reveal d2">
                    <div class="svc-num">03</div>
                    <h4>Bantuan Cepat</h4>
                    <ul>
                        <li>Hubungi WhatsApp desa</li>
                        <li>Konsultasi sebelum datang</li>
                        <li>Layanan prioritas lansia</li>
                    </ul>
                </div>
            </div>
            <p class="stats-note dark" style="margin-top:32px">* Untuk layanan tertentu, sebaiknya hubungi kantor desa terlebih dahulu guna memastikan kelengkapan berkas.</p>
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
                var map = L.map(el, { scrollWheelZoom: false }).setView(center, {{ $settings['peta_zoom'] ?? 15 }});
                el._map = map;
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '© OpenStreetMap' }).addTo(map);
                L.marker(center).addTo(map).bindPopup('<b>Kantor Desa Wonoboyo</b><br>Klabang, Bondowoso').openPopup();
                setTimeout(function () { map.invalidateSize(); }, 300);
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start); else start();
        })();
    </script>
@endpush
