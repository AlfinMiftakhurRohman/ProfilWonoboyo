@extends('layouts.public')

@section('title', $product->name)

@push('styles')
    {{-- Gaya khusus halaman ini, dari design/Produk-Detail.dc.html --}}
    <style>
        .pd-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }
        .pd-main { aspect-ratio: 1/1; border-radius: 10px; }
        .pd-thumbs { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 12px; }
        .pd-thumb { aspect-ratio: 1/1; border-radius: 6px; overflow: hidden; }
        .pd-price { font-family: 'Newsreader', serif; font-size: clamp(34px,4vw,46px); color: #20362a; letter-spacing: -.02em; margin: 8px 0 4px; }
        .pd-price small { font-family: 'Hanken Grotesk', sans-serif; font-size: 15px; color: #8b8267; }
        .pd-meta { display: flex; flex-direction: column; gap: 14px; margin: 28px 0; padding: 24px 0; border-top: 1px solid rgba(27,26,21,.1); border-bottom: 1px solid rgba(27,26,21,.1); }
        .pd-meta-row { display: flex; gap: 14px; font-size: 14.5px; }
        .pd-meta-k { font-family: 'Space Mono', monospace; font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #8b8267; width: 110px; flex: none; padding-top: 2px; }
        .pd-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; }
        @media (max-width: 900px) { .pd-grid { grid-template-columns: 1fr; gap: 32px; } }
    </style>
@endpush

@section('content')
    {{--
        Diporting dari design/Produk-Detail.dc.html. Data dari ProductController@show:
          $product — Product published (dengan images, primary lebih dulu)
        Tombol "Produk lainnya" mengarah ke katalog (desain tak memakai grid terkait).
    --}}
    @php $main = $product->images->first(); @endphp

    <header class="phero" style="min-height:auto">
        <div class="phero-media ph ph-dark"></div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner" style="padding:34px 0 28px">
            <div class="crumb" style="margin:0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <a href="{{ route('produk') }}">Produk Desa</a>
                <span class="sep">/</span>
                <span>{{ $product->name }}</span>
            </div>
        </div>
    </header>

    <section class="sec-sm">
        <div class="wrap-x">
            <div class="pd-grid">
                <div class="reveal">
                    <div class="pd-main ph">
                        @if ($main && $main->image)
                            <img src="{{ asset('uploads/products/' . $main->image) }}" alt="{{ $product->name }}">
                        @else
                            <span class="ph-lab">Foto produk<br>utama · 1:1</span>
                        @endif
                    </div>

                    @if ($product->images->count() > 1)
                        <div class="pd-thumbs">
                            @foreach ($product->images as $img)
                                <div class="pd-thumb ph">
                                    @if ($img->image)
                                        <img src="{{ asset('uploads/products/' . $img->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <span class="ph-lab" style="font-size:9px">1:1</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="reveal d1">
                    <span class="prod-cat" style="position:static;display:inline-block;margin-bottom:16px">{{ $product->category_label }}</span>
                    <h1 class="h2" style="margin-bottom:8px">{{ $product->name }}</h1>
                    <div class="prod-seller" style="margin-bottom:20px">oleh {{ $product->seller_name }}</div>
                    <div class="pd-price">{{ rupiah($product->price) }} <small>{{ $product->unit }}</small></div>
                    <div class="body-lg" style="font-size:15.5px;margin-top:22px">
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="pd-meta">
                        <div class="pd-meta-row">
                            <span class="pd-meta-k">Penjual</span>
                            <span>{{ $product->seller_name }}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="pd-meta-k">Kontak</span>
                            <span>{{ filled($product->seller_wa) ? $product->seller_wa : '—' }}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="pd-meta-k">Ketersediaan</span>
                            <span>{{ $product->availability_label }}</span>
                        </div>
                    </div>

                    @php $wa = wa_link($product->seller_wa, "Halo, saya tertarik dengan produk {$product->name} di Desa Wonoboyo."); @endphp
                    <div class="pd-actions">
                        @if ($wa)
                            <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn btn-wa">Pesan via WhatsApp <span class="arw2">→</span></a>
                        @else
                            <span class="btn btn-wa" style="opacity:.55;cursor:default" title="Nomor WhatsApp penjual belum tersedia">Pesan via WhatsApp <span class="arw2">→</span></span>
                        @endif
                        <a href="{{ route('produk') }}" class="btn btn-ghost">Produk lainnya</a>
                    </div>

                    <p class="stats-note dark" style="margin-top:24px">* Pemesanan dilakukan langsung ke penjual. Website ini hanya menampilkan katalog, tanpa transaksi online.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
