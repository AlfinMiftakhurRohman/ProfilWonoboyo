@extends('layouts.public')

@section('title', $post->title)

@push('styles')
    {{-- Gaya khusus halaman ini, dari design/Berita-Detail.dc.html. Aturan
         dropcap diterapkan ke paragraf pertama body dinamis (bukan class manual). --}}
    <style>
        .art { max-width: 760px; margin: 0 auto; }
        .art-head { max-width: 760px; margin: 0 auto 40px; }
        .art-title { font-family: 'Newsreader', serif; font-weight: 400; font-size: clamp(32px,4.6vw,54px); line-height: 1.06; letter-spacing: -.01em; margin: 0 0 22px; text-wrap: balance; }
        .art-meta { display: flex; align-items: center; gap: 14px; font-family: 'Space Mono', monospace; font-size: 12.5px; color: #6b6455; flex-wrap: wrap; }
        .art-cover { aspect-ratio: 16/9; border-radius: 10px; margin: 0 auto 14px; max-width: 960px; }
        .art-cap { max-width: 960px; margin: 0 auto 44px; font-size: 12.5px; color: #8b8267; font-style: italic; }
        .art-back { display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; color: #20362a; margin-top: 48px; }
        .share { display: flex; gap: 10px; align-items: center; margin-top: 40px; padding-top: 28px; border-top: 1px solid rgba(27,26,21,.12); flex-wrap: wrap; }
        .share-l { font-family: 'Space Mono', monospace; font-size: 11px; letter-spacing: .1em; text-transform: uppercase; color: #8b8267; margin-right: 6px; }
        .att { margin-top: 40px; }
        .att-l { font-family: 'Space Mono', monospace; font-size: 11px; letter-spacing: .1em; text-transform: uppercase; color: #8b8267; margin-bottom: 14px; }
        .att-box { display: flex; align-items: center; gap: 18px; padding: 20px 22px; border: 1px solid rgba(32,54,42,.16); border-radius: 10px; background: #efe7d6; }
        .att-type { flex: none; font-family: 'Space Mono', monospace; font-size: 11px; font-weight: 700; letter-spacing: .06em; color: #20362a; border: 1px solid rgba(32,54,42,.3); border-radius: 5px; padding: 9px 11px; }
        .att-info { flex: 1; min-width: 0; }
        .att-name { font-family: 'Newsreader', serif; font-size: 18px; line-height: 1.3; color: #20362a; word-break: break-word; }
        .att-size { font-family: 'Space Mono', monospace; font-size: 11.5px; color: #8b8267; margin-top: 4px; }
        .att-dl { flex: none; }
        .art.body-lg > p:first-of-type::first-letter { font-family: 'Newsreader', serif; font-size: 4.4em; line-height: .82; float: left; padding: 6px 12px 0 0; color: #20362a; font-weight: 500; }
        @media (max-width: 560px) { .att-box { flex-wrap: wrap; gap: 14px; } .att-dl { width: 100%; } .att-dl .btn { width: 100%; justify-content: center; } }
    </style>
@endpush

@section('content')
    {{-- Diporting dari design/Berita-Detail.dc.html. $post = satu Post published. --}}
    @php $url = route('berita.show', $post->slug); @endphp

    <section class="sec-sm" style="padding-top:56px">
        <div class="wrap-x">
            <div class="art-head reveal">
                <div class="crumb" style="color:#8b8267;margin-bottom:24px">
                    <a href="{{ route('beranda') }}">Beranda</a>
                    <span class="sep">/</span>
                    <a href="{{ route('berita') }}">Berita</a>
                    <span class="sep">/</span>
                    <span>{{ $post->title }}</span>
                </div>
                <span class="tag {{ $post->category === 'pengumuman' ? 'ann' : '' }}" style="position:static;display:inline-block;margin-bottom:18px">{{ $post->category_label }}</span>
                <h1 class="art-title">{{ $post->title }}</h1>
                <div class="art-meta">
                    <span>{{ $post->published_at->translatedFormat('d F Y') }}</span>
                    <span>·</span>
                    <span>{{ $post->author ?? 'Admin Desa' }}</span>
                    <span>·</span>
                    <span>{{ $post->reading_time }} menit baca</span>
                </div>
            </div>

            <div class="art-cover ph reveal">
                @if ($post->image)
                    <img src="{{ asset('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}">
                @else
                    <span class="ph-lab">Foto utama artikel · 16:9</span>
                @endif
            </div>
            @if ($post->image_caption)
                <p class="art-cap reveal">{{ $post->image_caption }}</p>
            @endif

            {{-- body = rich text; penyaringan HTML dilakukan saat disimpan (Tahap 3). --}}
            <div class="art body-lg reveal d1">
                {!! $post->body !!}
            </div>

            @if ($post->attachment)
                <div class="art att reveal">
                    <div class="att-l">Lampiran</div>
                    <div class="att-box">
                        <span class="att-type">{{ strtoupper(pathinfo($post->attachment, PATHINFO_EXTENSION)) ?: 'FILE' }}</span>
                        <div class="att-info">
                            <div class="att-name">{{ $post->attachment_name ?? $post->attachment }}</div>
                            @if ($post->attachmentSize())
                                <div class="att-size">{{ $post->attachmentSize() }}</div>
                            @endif
                        </div>
                        <div class="att-dl">
                            <a href="{{ asset('uploads/posts/' . $post->attachment) }}" download class="btn btn-solid btn-sm">Unduh <span class="arw2">↓</span></a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="art share reveal">
                <span class="share-l">Bagikan</span>
                <a href="https://wa.me/?text={{ rawurlencode($post->title . ' — ' . $url) }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">WhatsApp</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">Facebook</a>
                <button type="button" class="btn btn-ghost btn-sm" data-copy="{{ $url }}">Salin tautan</button>
            </div>

            <a href="{{ route('berita') }}" class="art-back">← Kembali ke daftar berita</a>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Tombol "Salin tautan": menyalin URL artikel ke clipboard.
        document.addEventListener('click', function (e) {
            var b = e.target.closest('[data-copy]');
            if (!b) return;
            e.preventDefault();
            navigator.clipboard.writeText(b.getAttribute('data-copy')).then(function () {
                var t = b.textContent;
                b.textContent = 'Tersalin ✓';
                setTimeout(function () { b.textContent = t; }, 1800);
            });
        });
    </script>
@endpush
