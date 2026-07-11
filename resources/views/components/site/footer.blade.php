{{--
    Footer global situs publik. Diporting dari design/Footer.dc.html:
    struktur & class dipertahankan apa adanya (keputusan strategi CSS),
    href diarahkan ke route bernama. Kontak & sosmed ditarik dari $settings
    (dibagikan lewat View::composer di AppServiceProvider) — elemen yang
    nilainya masih kosong disembunyikan, bukan ditampilkan sebagai placeholder.
--}}
<footer class="footer">
    <div class="wrap-x">
        <div class="foot-grid">
            <div class="foot-brand">
                <div class="brandlink">
                    <span class="emblem">W</span>
                    <span class="brand-name">Desa Wonoboyo</span>
                </div>
                <p class="foot-desc">
                    Laman resmi profil Desa Wonoboyo, Kecamatan Klabang,
                    Kabupaten Bondowoso, Provinsi Jawa Timur.
                </p>
            </div>

            <div>
                <div class="foot-h">Jelajahi</div>
                <div class="foot-links">
                    <a href="{{ route('profil') }}">Profil Desa</a>
                    <a href="{{ route('pemerintahan') }}">Pemerintahan</a>
                    <a href="{{ route('potensi') }}">Potensi Desa</a>
                    <a href="{{ route('produk') }}">Produk Desa</a>
                    <a href="{{ route('berita') }}">Berita &amp; Pengumuman</a>
                    <a href="{{ route('galeri') }}">Galeri</a>
                </div>
            </div>

            <div>
                <div class="foot-h">Kontak</div>
                <div class="foot-links">
                    <span>{{ $settings['kontak_alamat'] ?? 'Kantor Desa Wonoboyo, Kec. Klabang, Kab. Bondowoso, Jawa Timur' }}</span>
                    @if (! empty($settings['kontak_wa']))
                        <a href="{{ wa_link($settings['kontak_wa']) }}" target="_blank" rel="noopener">{{ $settings['kontak_wa'] }}</a>
                    @elseif (! empty($settings['kontak_telepon']))
                        <span>{{ $settings['kontak_telepon'] }}</span>
                    @endif
                    <a href="{{ route('kontak') }}">Halaman Kontak</a>
                    <span style="color:rgba(246,241,231,.55)">Layanan: {{ $settings['kontak_jam_layanan'] ?? 'Sen–Jum, jam kerja' }}</span>
                </div>
            </div>
        </div>

        <div class="foot-bottom">
            <span>© {{ date('Y') }} Pemerintah Desa Wonoboyo · Klabang, Bondowoso</span>
            @if (! empty($settings['sosmed_instagram']) || ! empty($settings['sosmed_facebook']))
                <span class="fx ac gap16">
                    @if (! empty($settings['sosmed_instagram']))
                        <a href="{{ $settings['sosmed_instagram'] }}" target="_blank" rel="noopener">Instagram</a>
                    @endif
                    @if (! empty($settings['sosmed_facebook']))
                        <a href="{{ $settings['sosmed_facebook'] }}" target="_blank" rel="noopener">Facebook</a>
                    @endif
                </span>
            @endif
        </div>
    </div>
</footer>
