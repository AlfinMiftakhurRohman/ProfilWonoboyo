@extends('layouts.public')

@section('title', 'Pemerintahan')

@section('content')
    {{--
        Diporting dari design/Pemerintahan.dc.html. Data dari PageController@pemerintahan:
          $head      — Kepala Desa (Official) atau null
          $perangkat — perangkat desa selain kepala desa (Collection<Official>)
          $bpd       — anggota BPD (Collection<Official>)
        Avatar: foto bila ada, jika belum ada tampil inisial nama ($official->initials).
    --}}
    <header class="phero">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto kantor / balai desa · 1920 × 900</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Pemerintahan</span>
            </div>
            <h1 class="phero-title">Pemerintahan Desa</h1>
            <p class="phero-sub">Orang-orang yang menjalankan roda pelayanan dan pembangunan Desa Wonoboyo.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="sec-head stack" style="margin-bottom:48px">
                <div class="eyebrow reveal">Struktur Organisasi</div>
                <h2 class="h2 reveal">Pimpinan &amp; perangkat desa</h2>
            </div>

            @if ($head)
                <div class="reveal" style="max-width:340px;margin:0 auto">
                    <div class="person lead">
                        <div class="avatar lg">
                            @if ($head->photo)
                                <img src="{{ asset('uploads/officials/' . $head->photo) }}" alt="{{ $head->name }}">
                            @else
                                {{ $head->initials }}
                            @endif
                        </div>
                        <div class="badge-sm">Kepala Desa</div>
                        <div class="person-name">{{ $head->name }}</div>
                        <div class="person-role">{{ $head->position }}</div>
                    </div>
                </div>
                <div class="org-line reveal"></div>
            @endif

            <div class="people-grid reveal d1">
                @forelse ($perangkat as $p)
                    <div class="person">
                        <div class="avatar">
                            @if ($p->photo)
                                <img src="{{ asset('uploads/officials/' . $p->photo) }}" alt="{{ $p->name }}">
                            @else
                                {{ $p->initials }}
                            @endif
                        </div>
                        <div class="person-name">{{ $p->name }}</div>
                        <div class="person-role">{{ $p->position }}</div>
                    </div>
                @empty
                    <p class="stats-note">Data perangkat desa belum tersedia.</p>
                @endforelse
            </div>
            <p class="stats-note dark" style="margin-top:34px">* Foto perangkat desa akan ditambahkan menyusul. Untuk saat ini ditampilkan inisial nama.</p>
        </div>
    </section>

    @if ($bpd->isNotEmpty())
        <section class="sec bg-sand">
            <div class="wrap-x">
                <div class="vm-grid" style="grid-template-columns:1fr;max-width:820px;margin:0 auto">
                    <div class="vm-card reveal">
                        <div class="badge-sm">Lembaga</div>
                        <h3 class="h3" style="margin-bottom:14px">Badan Permusyawaratan Desa</h3>
                        <p class="body-lg" style="font-size:15.5px;margin-bottom:22px">BPD adalah lembaga perwakilan warga yang bersama kepala desa menyusun dan menetapkan peraturan desa, menampung aspirasi, serta mengawasi jalannya pemerintahan desa.</p>
                        <div class="people-grid three" style="gap:16px">
                            @foreach ($bpd as $b)
                                <div class="person" style="padding:18px">
                                    <div class="avatar" style="width:64px;height:64px;font-size:24px">
                                        @if ($b->photo)
                                            <img src="{{ asset('uploads/officials/' . $b->photo) }}" alt="{{ $b->name }}">
                                        @else
                                            {{ $b->initials }}
                                        @endif
                                    </div>
                                    <div class="person-name" style="font-size:16px">{{ $b->name }}</div>
                                    <div class="person-role" style="font-size:11px">{{ $b->position }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
