@extends('layouts.public')

@section('title', 'Potensi Desa')

@push('styles')
    {{-- Gaya khusus badge "Sedang dirintis", dari design/Potensi-Desa.dc.html --}}
    <style>
        .dirintis { display: inline-flex; align-items: center; gap: 8px; font-family: 'Space Mono', monospace; font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #b9762b; margin-bottom: 16px; }
        .dirintis::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: #b9762b; }
    </style>
@endpush

@section('content')
    {{-- Diporting dari design/Potensi-Desa.dc.html. Konten naratif statis (teks
         desain), tanpa data dinamis. --}}
    <header class="phero" style="min-height:52vh">
        <div class="phero-media ph ph-dark">
            <span class="ph-lab">Foto persawahan &amp; perbukitan desa · 1920 × 1080</span>
        </div>
        <div class="phero-scrim"></div>
        <div class="wrap-x phero-inner">
            <div class="crumb">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="sep">/</span>
                <span>Potensi Desa</span>
            </div>
            <h1 class="phero-title">Yang menopang<br>Wonoboyo</h1>
            <p class="phero-sub">Wonoboyo adalah desa agraris di perbukitan. Berikut hal-hal yang menopang keseharian warganya — disampaikan apa adanya.</p>
        </div>
    </header>

    <section class="sec">
        <div class="wrap-x">
            <div class="feature reveal" style="margin-bottom:120px">
                <div class="feature-media ph"><span class="ph-lab">Foto persawahan &amp; saluran irigasi<br>5:4</span></div>
                <div>
                    <div class="feat-idx">01 — Pertanian</div>
                    <h3 class="feat-title">Sawah, Ladang &amp; Irigasi</h3>
                    <p class="feat-text">Sebagian besar warga menggarap sawah dan ladang di lereng perbukitan yang sejuk, mengandalkan saluran irigasi desa dan kesuburan tanah. Inilah sumber penghidupan utama sehari-hari di Wonoboyo.</p>
                    <div class="chips">
                        <span class="chip">Sawah</span>
                        <span class="chip">Ladang</span>
                        <span class="chip">Saluran irigasi</span>
                        <span class="chip">Udara sejuk</span>
                    </div>
                </div>
            </div>

            <div class="feature rev reveal" style="margin-bottom:120px">
                <div class="feature-media ph"><span class="ph-lab">Foto ternak warga<br>5:4</span></div>
                <div>
                    <div class="feat-idx">02 — Peternakan</div>
                    <h3 class="feat-title">Peternakan Warga</h3>
                    <p class="feat-text">Selain bertani, banyak keluarga memelihara sapi dan kambing sebagai tabungan sekaligus penghasilan tambahan. Ternak dipelihara secara mandiri, berdampingan dengan kegiatan di sawah dan ladang.</p>
                    <div class="chips">
                        <span class="chip">Sapi</span>
                        <span class="chip">Kambing</span>
                        <span class="chip">Peternakan rakyat</span>
                    </div>
                </div>
            </div>

            <div class="feature reveal">
                <div class="feature-media ph"><span class="ph-lab">Foto usaha rumahan warga<br>5:4</span></div>
                <div>
                    <div class="dirintis">Sedang dirintis</div>
                    <div class="feat-idx">03 — UMKM &amp; Home Industry</div>
                    <h3 class="feat-title">Usaha Warga</h3>
                    <p class="feat-text">Usaha rumahan dan UMKM di Wonoboyo masih dalam tahap dirintis. Sebagian warga mulai mengolah hasil bumi menjadi produk sederhana. Ke depan, produk-produk ini diharapkan dapat ditampilkan pada halaman Produk Desa.</p>
                    <div class="chips">
                        <span class="chip">Olahan hasil bumi</span>
                        <span class="chip">Usaha rumahan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec bg-forest">
        <div class="wrap-x">
            <div class="cta reveal" style="padding:0">
                <div class="cta-inner" style="max-width:720px;margin:0 auto;text-align:center">
                    <div class="eyebrow center" style="color:#e8c79a;margin-bottom:20px;justify-content:center">Selengkapnya</div>
                    <h2 class="h2 cream" style="font-size:clamp(28px,3.8vw,44px);margin-bottom:22px">Ingin tahu lebih banyak?</h2>
                    <p style="color:rgba(246,241,231,.85);font-size:17px;line-height:1.6;margin:0 auto 32px;max-width:520px">Kunjungi profil desa untuk data wilayah dan kependudukan, atau hubungi kantor desa untuk informasi lebih lanjut.</p>
                    <div class="cta-btns" style="justify-content:center">
                        <a href="{{ route('profil') }}" class="btn btn-amber">Profil desa <span class="arw2">→</span></a>
                        <a href="{{ route('kontak') }}" class="btn btn-ghost-light">Hubungi kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
