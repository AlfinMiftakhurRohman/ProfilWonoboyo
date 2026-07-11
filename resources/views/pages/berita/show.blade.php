@extends('layouts.public')

@section('title', 'Detail Berita')

@section('content')
    {{--
        KERANGKA (Tahap 2) — porting konten dari: design/Berita-Detail.dc.html
        Variabel dari PostController@show:
          $post — satu Post published (404 bila slug tidak tayang/tidak ada)
    --}}
    <section class="sec">
        <div class="wrap-x">
            <div class="eyebrow">Kerangka Halaman</div>
            <h1 class="h2">Detail Berita</h1>
            <p class="lead">Halaman ini masih kerangka. Konten akan diporting dari <code>design/Berita-Detail.dc.html</code>.</p>
            <p class="muted">Cek data: slug "{{ $post->slug }}".</p>
        </div>
    </section>
@endsection
