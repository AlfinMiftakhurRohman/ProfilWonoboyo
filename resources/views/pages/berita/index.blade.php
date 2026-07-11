@extends('layouts.public')

@section('title', 'Berita & Pengumuman')

@section('content')
    {{--
        Diporting dari design/Berita.dc.html. Data dari PostController@index:
          $posts    — post published terpaginasi 9/hal (withQueryString)
          $kategori — filter aktif ('all'|'berita'|'pengumuman')
        Filter server-side lewat ?kategori= (sesuai keputusan controller, BUKAN JS)
        agar berpadu dengan paginasi & hasil filter bisa dibagikan lewat URL.
    --}}
    <header class="phero">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto kegiatan warga desa · 1920 × 900</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Berita &amp; Pengumuman</span>
            </div>
            <h1 class="phero-title">Berita &amp; Pengumuman</h1>
            <p class="phero-sub">Kabar terbaru, kegiatan, dan pengumuman resmi dari Pemerintah Desa Wonoboyo.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="filterbar">
                <a href="{{ route('berita') }}" class="filter {{ $kategori === 'all' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('berita', ['kategori' => 'berita']) }}" class="filter {{ $kategori === 'berita' ? 'active' : '' }}">Berita</a>
                <a href="{{ route('berita', ['kategori' => 'pengumuman']) }}" class="filter {{ $kategori === 'pengumuman' ? 'active' : '' }}">Pengumuman</a>
            </div>

            <div class="news-grid">
                @forelse ($posts as $post)
                    <a href="{{ route('berita.show', $post->slug) }}" class="card reveal">
                        <div class="card-media">
                            <span class="card-img ph">
                                @if ($post->image)
                                    <img src="{{ asset('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}">
                                @else
                                    <span class="ph-lab">{{ $post->category === 'pengumuman' ? 'Foto pengumuman desa' : 'Foto kegiatan warga' }}</span>
                                @endif
                            </span>
                            <span class="tag {{ $post->category === 'pengumuman' ? 'ann' : '' }}">{{ $post->category_label }}</span>
                        </div>
                        <div class="card-body">
                            <div class="card-date">{{ $post->published_at->translatedFormat('d F Y') }}</div>
                            <h3 class="card-title">{{ $post->title }}</h3>
                            <p class="card-ex">{{ $post->excerpt }}</p>
                            <span class="card-more">Baca selengkapnya <span class="arw">→</span></span>
                        </div>
                    </a>
                @empty
                    <div class="empty">
                        <div class="empty-ic">◎</div>
                        <h4>Belum ada kabar di kategori ini</h4>
                        <p>Coba lihat kategori lain atau kembali lagi nanti untuk kabar terbaru.</p>
                    </div>
                @endforelse
            </div>

            {{ $posts->links() }}
        </div>
    </section>
@endsection
