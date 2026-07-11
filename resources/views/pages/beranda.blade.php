@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    {{--
        Diporting dari design/Beranda.dc.html. Data dari HomeController@index:
          $posts      — 3 berita/pengumuman published terbaru
          $pengumuman — 1 pengumuman published terbaru, atau null (blok disembunyikan)
          $head       — Kepala Desa (Official), atau null (sign block disembunyikan)
        $settings dibagikan global lewat View::composer (AppServiceProvider).
    --}}

    <header class="hero">
        <div class="hero-media ph ph-dark">
            <span class="ph-lab hero-lab">Foto lanskap desa · perbukitan &amp; persawahan · 1920 × 1200</span>
        </div>
        <div class="hero-scrim"></div>
        <div class="wrap-x hero-inner">
            <div class="hero-loc">Kec. Klabang · Kab. Bondowoso · Jawa Timur</div>
            <h1 class="hero-title">Desa agraris di <em>perbukitan</em> Bondowoso</h1>
            <p class="hero-tag">Wonoboyo, desa perbukitan di Kecamatan Klabang — dengan sawah, saluran irigasi, dan warga yang guyub. Inilah laman resmi kami.</p>
        </div>
        <a href="#sambutan" class="scrollcue">Gulir<i></i></a>
    </header>

    <section class="sec" id="sambutan">
        <div class="wrap-x">
            <div class="welcome">
                <div class="welcome-photo ph reveal">
                    @if ($head?->photo)
                        <img src="{{ asset('uploads/officials/' . $head->photo) }}" alt="Foto {{ $head->name }}">
                    @else
                        <span class="ph-lab">Foto Kepala Desa<br>potret · 4:5</span>
                    @endif
                </div>
                <div class="reveal d1">
                    <div class="eyebrow" style="margin-bottom:20px">Sambutan Kepala Desa</div>
                    <p class="quote">
                        <span class="amark">&ldquo;</span>{{ $settings['sambutan_teks'] ?? 'Terima kasih sudah menyempatkan singgah di laman desa kami.' }}<span class="amark">&rdquo;</span>
                    </p>
                    <div class="sign">
                        <span class="emblem" style="width:46px;height:46px;font-size:22px">W</span>
                        <span>
                            @if ($head)
                                <span class="sign-name">{{ $head->name }}</span>
                            @endif
                            <span class="sign-role">{{ $head->position ?? 'Kepala Desa Wonoboyo' }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($pengumuman)
        <section class="wrap-x">
            <a href="{{ route('berita.show', $pengumuman->slug) }}" class="notice reveal">
                <span class="notice-tag">Pengumuman</span>
                <span class="notice-body">
                    <span class="notice-title">{{ $pengumuman->title }}</span>
                    <span class="notice-date">Diperbarui {{ $pengumuman->published_at->translatedFormat('d F Y') }}</span>
                </span>
                <span class="notice-more">Baca pengumuman <span class="arw">→</span></span>
            </a>
        </section>
    @endif

    <section class="sec">
        <div class="wrap-x">
            <div class="sec-head">
                <div>
                    <div class="eyebrow reveal" style="margin-bottom:18px">Kabar Desa</div>
                    <h2 class="h2 reveal">Yang sedang terjadi<br>di desa kami</h2>
                </div>
                <a href="{{ route('berita') }}" class="btn btn-ghost reveal">Semua berita <span class="arw2">→</span></a>
            </div>
            <div class="news-grid">
                @forelse ($posts as $i => $post)
                    <a href="{{ route('berita.show', $post->slug) }}" class="card reveal d{{ $i + 1 }}">
                        <div class="card-media">
                            <span class="card-img ph">
                                @if ($post->image)
                                    <img src="{{ asset('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}">
                                @else
                                    <span class="ph-lab">{{ $post->title }}</span>
                                @endif
                            </span>
                            <span class="tag {{ $post->category === 'pengumuman' ? 'ann' : '' }}">{{ $post->category === 'pengumuman' ? 'Pengumuman' : 'Berita' }}</span>
                        </div>
                        <div class="card-body">
                            <div class="card-date">{{ $post->published_at->translatedFormat('d F Y') }}</div>
                            <h3 class="card-title">{{ $post->title }}</h3>
                            <p class="card-ex">{{ $post->excerpt }}</p>
                            <span class="card-more">Baca selengkapnya <span class="arw">→</span></span>
                        </div>
                    </a>
                @empty
                    <p class="muted">Belum ada berita yang tayang.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="sec bg-sand">
        <div class="wrap-x">
            <div class="sec-head" style="margin-bottom:64px">
                <div>
                    <div class="eyebrow reveal" style="margin-bottom:18px">Potensi Desa</div>
                    <h2 class="h2 reveal">Bertumpu pada tanah<br>dan warganya</h2>
                </div>
                <p class="lead reveal d1">Wonoboyo adalah desa agraris. Kehidupannya bertumpu pada sawah, ternak, dan gotong royong warga — hal-hal sederhana yang menopang keseharian di perbukitan.</p>
            </div>

            <div class="feature reveal" style="margin-bottom:96px">
                <div class="feature-media ph">
                    <span class="ph-lab">Foto persawahan &amp; saluran irigasi<br>5:4</span>
                </div>
                <div>
                    <div class="feat-idx">01 — Pertanian</div>
                    <h3 class="feat-title">Sawah &amp; Irigasi Warga</h3>
                    <p class="feat-text">Sebagian besar warga bertani di sawah dan ladang yang mengandalkan saluran irigasi desa. Tanah perbukitan yang subur dan udara sejuk menjadi modal utama penghidupan sehari-hari.</p>
                    <div class="chips">
                        <span class="chip">Sawah</span>
                        <span class="chip">Saluran irigasi</span>
                        <span class="chip">Ladang</span>
                    </div>
                    <a href="{{ route('potensi') }}" class="btn btn-solid">Selengkapnya <span class="arw2">→</span></a>
                </div>
            </div>

            <div class="feature rev reveal">
                <div class="feature-media ph">
                    <span class="ph-lab">Foto ternak warga<br>5:4</span>
                </div>
                <div>
                    <div class="feat-idx">02 — Peternakan</div>
                    <h3 class="feat-title">Peternakan Warga</h3>
                    <p class="feat-text">Sapi dan kambing menjadi tumpuan tambahan bagi banyak keluarga, dipelihara secara mandiri berdampingan dengan kegiatan bertani sehari-hari.</p>
                    <div class="chips">
                        <span class="chip">Sapi</span>
                        <span class="chip">Kambing</span>
                    </div>
                    <a href="{{ route('potensi') }}" class="btn btn-ghost">Selengkapnya <span class="arw2">→</span></a>
                </div>
            </div>
        </div>
    </section>

    @php
        $stats = [
            ['val' => $settings['stat_penduduk'] ?? '', 'unit' => 'Jiwa', 'label' => 'Jumlah penduduk'],
            ['val' => $settings['stat_kk'] ?? '', 'unit' => 'KK', 'label' => 'Kepala keluarga'],
            ['val' => $settings['stat_dusun'] ?? '', 'unit' => 'Dusun', 'label' => 'Wilayah administratif'],
            ['val' => $settings['geo_luas'] ?? '', 'unit' => 'Ha', 'label' => 'Luas wilayah desa'],
        ];
    @endphp
    <section class="stats">
        <div class="wrap-x">
            <div class="eyebrow cream reveal" style="color:#e8c79a">Wonoboyo dalam angka</div>
            <h2 class="h2 cream reveal" style="margin-top:18px;max-width:640px">Sekilas desa kami hari ini</h2>
            <div class="stats-grid">
                @foreach ($stats as $s)
                    <div class="stat reveal">
                        @if (is_numeric($s['val']))
                            <div class="stat-num" data-target="{{ $s['val'] }}">{{ number_format((float) $s['val'], 0, ',', '.') }}</div>
                        @else
                            <div class="stat-num">–</div>
                        @endif
                        <div class="stat-unit">{{ $s['unit'] }}</div>
                        <div class="stat-lab">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
            <p class="stats-note">* Angka bersifat ilustratif — akan diperbarui sesuai data administrasi desa terbaru.</p>
        </div>
    </section>

    <section class="sec">
        <div class="wrap-x">
            <div class="cta reveal">
                <div class="ph ph-dark" style="position:absolute;inset:0"></div>
                <div class="cta-scrim"></div>
                <div class="cta-inner">
                    <div class="eyebrow" style="color:#e8c79a;margin-bottom:20px">Masih ada lagi</div>
                    <h2>Kenali Wonoboyo lebih dekat</h2>
                    <p>Pertanian, peternakan, hingga usaha warga yang sedang dirintis — kenali lebih dekat kehidupan sehari-hari Desa Wonoboyo.</p>
                    <div class="cta-btns">
                        <a href="{{ route('potensi') }}" class="btn btn-amber">Lihat potensi desa <span class="arw2">→</span></a>
                        <a href="{{ route('kontak') }}" class="btn btn-ghost-light">Hubungi kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
