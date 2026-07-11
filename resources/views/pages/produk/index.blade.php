@extends('layouts.public')

@section('title', 'Produk Desa')

@push('styles')
    {{-- Gaya khusus halaman ini, dari design/Produk-Desa.dc.html --}}
    <style>
        .soon { display: flex; gap: 20px; align-items: flex-start; padding: 24px 28px; border: 1px solid rgba(32,54,42,.16); border-radius: 12px; background: #efe7d6; margin-bottom: 44px; }
        .soon-b { font-family: 'Space Mono', monospace; font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #b9762b; flex: none; padding-top: 2px; }
        .soon p { margin: 0; font-size: 15px; line-height: 1.65; color: #4a463a; }
        .prod-empty { grid-column: 1 / -1; text-align: center; color: #8b8267; padding: 40px 0; }
        @media (max-width: 560px) { .soon { flex-direction: column; gap: 10px; } }
    </style>
@endpush

@section('content')
    {{--
        Diporting dari design/Produk-Desa.dc.html. Data dari ProductController@index:
          $products — produk published terpaginasi 9/hal (primaryImage di-eager-load)
          $kategori — filter aktif ('all'|'umkm'|'hasil_tani'|'olahan'); desain tak
                      punya UI filter, jadi tidak dirender (server tetap dukung ?kategori=).
    --}}
    <header class="phero">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto hasil bumi &amp; olahan warga · 1920 × 900</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Produk Desa</span>
            </div>
            <h1 class="phero-title">Produk Warga Wonoboyo</h1>
            <p class="phero-sub">Halaman ini menampilkan produk hasil bumi dan olahan warga. Pemesanan dilakukan langsung ke penjual — website hanya menampilkan katalog, tanpa transaksi online.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="soon reveal">
                <span class="soon-b">Segera hadir</span>
                <p>Katalog produk warga masih dalam tahap disiapkan bersama pelaku usaha desa. Data produk, penjual, harga, dan nomor WhatsApp diisi oleh admin desa.</p>
            </div>

            <div class="prod-grid">
                @forelse ($products as $p)
                    <div class="prod reveal">
                        <a href="{{ route('produk.show', $p->slug) }}" class="prod-media">
                            <span class="card-img ph">
                                @if ($p->primaryImage && $p->primaryImage->image)
                                    <img src="{{ asset('uploads/products/' . $p->primaryImage->image) }}" alt="{{ $p->name }}">
                                @else
                                    <span class="ph-lab">Foto produk</span>
                                @endif
                            </span>
                            <span class="prod-cat">{{ $p->category_label }}</span>
                        </a>
                        <div class="prod-body">
                            <h3 class="prod-name"><a href="{{ route('produk.show', $p->slug) }}">{{ $p->name }}</a></h3>
                            <div class="prod-seller">oleh {{ $p->seller_name }}</div>
                            <div class="prod-foot">
                                <span class="prod-price">{{ rupiah($p->price) }} <small>{{ $p->unit }}</small></span>
                                @php $wa = wa_link($p->seller_wa, "Halo, saya tertarik dengan produk {$p->name} di Desa Wonoboyo."); @endphp
                                @if ($wa)
                                    <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn btn-wa btn-sm">WhatsApp</a>
                                @else
                                    <a href="{{ route('produk.show', $p->slug) }}" class="btn btn-ghost btn-sm">Lihat</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="prod-empty">Belum ada produk yang tayang.</p>
                @endforelse
            </div>

            {{ $products->links() }}
        </div>
    </section>
@endsection
