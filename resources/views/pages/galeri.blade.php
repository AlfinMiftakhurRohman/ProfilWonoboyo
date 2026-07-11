@extends('layouts.public')

@section('title', 'Galeri')

@section('content')
    {{--
        KERANGKA (Tahap 2) — porting konten dari: design/Galeri.dc.html
        Variabel dari GalleryController@index:
          $photos — foto galeri terurut, terpaginasi 12/hal (LengthAwarePaginator<Gallery>)
    --}}
    <section class="sec">
        <div class="wrap-x">
            <div class="eyebrow">Kerangka Halaman</div>
            <h1 class="h2">Galeri</h1>
            <p class="lead">Halaman ini masih kerangka. Konten akan diporting dari <code>design/Galeri.dc.html</code>.</p>
            <p class="muted">Cek data: {{ $photos->total() }} foto ({{ $photos->count() }} di halaman ini).</p>
        </div>
    </section>
@endsection
