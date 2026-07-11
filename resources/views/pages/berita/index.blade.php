@extends('layouts.public')

@section('title', 'Berita & Pengumuman')

@section('content')
    {{--
        KERANGKA (Tahap 2) — porting konten dari: design/Berita.dc.html
        Variabel dari PostController@index:
          $posts    — berita published terpaginasi 9/hal (LengthAwarePaginator<Post>)
          $kategori — filter aktif: 'all' | 'berita' | 'pengumuman'
    --}}
    <section class="sec">
        <div class="wrap-x">
            <div class="eyebrow">Kerangka Halaman</div>
            <h1 class="h2">Berita &amp; Pengumuman</h1>
            <p class="lead">Halaman ini masih kerangka. Konten akan diporting dari <code>design/Berita.dc.html</code>.</p>
            <p class="muted">Cek data: filter "{{ $kategori }}" — {{ $posts->total() }} entri ({{ $posts->count() }} di halaman ini).</p>
        </div>
    </section>
@endsection
