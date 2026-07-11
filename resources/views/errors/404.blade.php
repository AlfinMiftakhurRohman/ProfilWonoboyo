@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <section class="sec" style="min-height:70vh;display:flex;align-items:center">
        <div class="wrap-x" style="text-align:center;max-width:640px;margin:0 auto">
            <div class="eyebrow center" style="justify-content:center;margin-bottom:20px">Error 404</div>
            <h1 class="h2" style="margin-bottom:18px">Halaman tidak ditemukan</h1>
            <p class="lead" style="margin:0 auto 32px;max-width:480px">
                Maaf, halaman yang Anda cari tidak ada atau sudah dipindahkan.
                Mari kembali menjelajah Desa Wonoboyo.
            </p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('beranda') }}" class="btn btn-solid">Kembali ke Beranda <span class="arw2">→</span></a>
                <a href="{{ route('berita') }}" class="btn btn-ghost">Lihat Berita</a>
            </div>
        </div>
    </section>
@endsection
