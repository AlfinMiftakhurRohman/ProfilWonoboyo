@extends('layouts.public')

@section('title', 'Pemerintahan')

@section('content')
    {{--
        KERANGKA (Tahap 2) — porting konten dari: design/Pemerintahan.dc.html
        Variabel dari PageController@pemerintahan:
          $head      — Kepala Desa (Official), atau null
          $perangkat — perangkat desa terurut (Collection<Official>)
          $bpd       — anggota BPD terurut (Collection<Official>)
    --}}
    <section class="sec">
        <div class="wrap-x">
            <div class="eyebrow">Kerangka Halaman</div>
            <h1 class="h2">Pemerintahan</h1>
            <p class="lead">Halaman ini masih kerangka. Konten akan diporting dari <code>design/Pemerintahan.dc.html</code>.</p>
            <p class="muted">Cek data: kepala desa {{ $head ? 'terisi' : 'kosong' }}, {{ $perangkat->count() }} perangkat, {{ $bpd->count() }} anggota BPD.</p>
        </div>
    </section>
@endsection
