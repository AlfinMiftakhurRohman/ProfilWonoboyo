@extends('layouts.public')

@section('title', 'Produk Desa')

@section('content')
    {{--
        KERANGKA (Tahap 2) — porting konten dari: design/Produk-Desa.dc.html
        Variabel dari ProductController@index:
          $products — produk published terpaginasi 9/hal (LengthAwarePaginator<Product>)
          $kategori — filter aktif: 'all' | 'umkm' | 'hasil_tani' | 'olahan'
    --}}
    <section class="sec">
        <div class="wrap-x">
            <div class="eyebrow">Kerangka Halaman</div>
            <h1 class="h2">Produk Desa</h1>
            <p class="lead">Halaman ini masih kerangka. Konten akan diporting dari <code>design/Produk-Desa.dc.html</code>.</p>
            <p class="muted">Cek data: filter "{{ $kategori }}" — {{ $products->total() }} produk ({{ $products->count() }} di halaman ini).</p>
        </div>
    </section>
@endsection
