@extends('layouts.admin')

@section('title', 'Akun Saya')

@section('content')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-forest mb-5">← Kembali ke dashboard</a>

    <div class="max-w-2xl space-y-6">
        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        {{-- Kartu "Hapus Akun" bawaan Breeze sengaja tidak ditampilkan: situs ini
             satu-admin, jadi menghapus akun satu-satunya akan mengunci panel. --}}
    </div>
@endsection
