@extends('layouts.public')

@section('title', 'Detail Produk')

@section('content')
    {{--
        KERANGKA (Tahap 2) — porting konten dari: design/Produk-Detail.dc.html
        Variabel dari ProductController@show:
          $product — satu Product published dengan images (404 bila slug tidak ada)
          $others  — s.d. 3 produk lain kategori sama (Collection<Product>)
    --}}
    <section class="sec">
        <div class="wrap-x">
            <div class="eyebrow">Kerangka Halaman</div>
            <h1 class="h2">Detail Produk</h1>
            <p class="lead">Halaman ini masih kerangka. Konten akan diporting dari <code>design/Produk-Detail.dc.html</code>.</p>
            <p class="muted">Cek data: slug "{{ $product->slug }}", {{ $others->count() }} produk lainnya.</p>
        </div>
    </section>
@endsection
