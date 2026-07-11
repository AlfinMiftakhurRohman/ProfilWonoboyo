@extends('layouts.public')

@section('title', 'Galeri')

@section('content')
    {{--
        Diporting dari design/Galeri.dc.html. Data dari GalleryController@index:
          $photos — item galeri terurut, terpaginasi 12/hal.
        Lightbox digerakkan oleh site.js ([data-lightbox] → .lightbox). ratio
        menentukan bentuk kartu pada layout masonry (columns).
    --}}
    <header class="phero">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto kolase desa · 1920 × 900</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Galeri</span>
            </div>
            <h1 class="phero-title">Galeri Desa</h1>
            <p class="phero-sub">Potret keseharian, panorama, dan kegiatan warga Wonoboyo. Klik foto untuk memperbesar.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="gallery reveal">
                @forelse ($photos as $p)
                    @php $cap = $p->caption ?? $p->title; @endphp
                    <div class="gitem" data-lightbox data-cap="{{ $cap }}">
                        <span class="card-img ph" style="position:relative;aspect-ratio:{{ $p->ratio ?: '1/1' }};display:block">
                            @if ($p->image)
                                <img src="{{ asset('uploads/galleries/' . $p->image) }}" alt="{{ $cap }}">
                            @else
                                <span class="ph-lab">{{ $cap }}</span>
                            @endif
                        </span>
                        <span class="gitem-scrim"><span class="gitem-cap">{{ $cap }}</span></span>
                    </div>
                @empty
                    <p class="stats-note">Belum ada foto di galeri.</p>
                @endforelse
            </div>

            {{ $photos->links() }}
        </div>
    </section>

    {{-- Modal lightbox (diisi & dibuka oleh site.js) --}}
    <div class="lightbox">
        <button class="lb-close" data-lb-close aria-label="Tutup">✕</button>
        <div class="lightbox-inner">
            <div class="lb-content" style="position:absolute;inset:0"></div>
            <div class="lightbox-cap"></div>
        </div>
    </div>
@endsection
