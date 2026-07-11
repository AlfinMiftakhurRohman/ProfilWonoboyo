@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <p class="text-sm text-muted">Foto kegiatan & panorama desa. Urutan mengikuti kolom "Urutan".</p>
        <a href="{{ route('admin.gallery.create') }}"
           class="ml-auto rounded-lg bg-forest px-4 py-2 text-sm font-semibold text-cream hover:bg-forest-2 transition">+ Tambah Foto</a>
    </div>

    @if ($photos->isEmpty())
        <div class="rounded-xl bg-white border border-ink/10 shadow-sm py-16 text-center text-muted">
            Belum ada foto. <a href="{{ route('admin.gallery.create') }}" class="text-amber hover:underline">Unggah yang pertama →</a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach ($photos as $photo)
                <div class="group relative rounded-xl overflow-hidden border border-ink/10 bg-sand">
                    <div class="aspect-square">
                        @if ($photo->image)
                            <img src="{{ asset('uploads/galleries/' . $photo->image) }}" class="w-full h-full object-cover" alt="{{ $photo->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-muted p-2 text-center">{{ $photo->title }}</div>
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/0 to-ink/0 opacity-0 group-hover:opacity-100 transition flex flex-col justify-end p-3">
                        <div class="text-cream text-xs font-medium truncate mb-2">{{ $photo->title }}</div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.gallery.edit', $photo) }}" class="rounded-md bg-white/90 px-2 py-1 text-xs text-ink hover:bg-white">Edit</a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $photo) }}" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf @method('DELETE')
                                <button class="rounded-md bg-red-500/90 px-2 py-1 text-xs text-white hover:bg-red-500">Hapus</button>
                            </form>
                        </div>
                    </div>
                    <span class="absolute top-2 left-2 rounded bg-ink/60 text-cream text-[10px] px-1.5 py-0.5">#{{ $photo->sort_order }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-5">{{ $photos->links('pagination::tailwind') }}</div>
    @endif
@endsection
