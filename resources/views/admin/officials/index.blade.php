@extends('layouts.admin')

@section('title', 'Perangkat Desa')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <p class="text-sm text-muted">Kepala desa, perangkat, dan anggota BPD. Foto opsional — bila kosong tampil inisial nama.</p>
        <a href="{{ route('admin.officials.create') }}"
           class="ml-auto rounded-lg bg-forest px-4 py-2 text-sm font-semibold text-cream hover:bg-forest-2 transition">+ Tambah</a>
    </div>

    @php
        $groups = ['perangkat' => 'Perangkat Desa', 'bpd' => 'Badan Permusyawaratan Desa (BPD)'];
    @endphp

    @foreach ($groups as $key => $label)
        <section class="mb-8">
            <h2 class="font-semibold text-forest mb-3">{{ $label }}
                <span class="text-xs font-normal text-muted">({{ optional($officials->get($key))->count() ?? 0 }})</span>
            </h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse ($officials->get($key) ?? [] as $o)
                    <div class="rounded-xl bg-white border {{ $o->is_head ? 'border-amber/40 ring-1 ring-amber/20' : 'border-ink/10' }} shadow-sm p-4 flex items-center gap-3">
                        <span class="w-12 h-12 rounded-full bg-forest/10 text-forest font-serif text-lg flex items-center justify-center overflow-hidden shrink-0">
                            @if ($o->photo)
                                <img src="{{ asset('uploads/officials/' . $o->photo) }}" class="w-full h-full object-cover" alt="">
                            @else
                                {{ $o->initials }}
                            @endif
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5">
                                <span class="font-medium text-ink truncate">{{ $o->name }}</span>
                                @if ($o->is_head)<span class="rounded-full bg-amber/15 text-amber text-[10px] font-medium px-1.5 py-0.5">Kepala Desa</span>@endif
                            </div>
                            <div class="text-xs text-muted truncate">{{ $o->position }}</div>
                            <div class="mt-2 flex items-center gap-2">
                                <a href="{{ route('admin.officials.edit', $o) }}" class="rounded-md border border-ink/15 px-2 py-0.5 text-xs hover:bg-cream">Edit</a>
                                <form method="POST" action="{{ route('admin.officials.destroy', $o) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-md border border-red-200 px-2 py-0.5 text-xs text-red-600 hover:bg-red-50">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-muted col-span-full py-4">Belum ada data.</p>
                @endforelse
            </div>
        </section>
    @endforeach
@endsection
