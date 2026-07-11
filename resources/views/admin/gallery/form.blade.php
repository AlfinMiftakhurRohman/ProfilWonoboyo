@extends('layouts.admin')

@section('title', $photo->exists ? 'Edit Foto' : 'Tambah Foto')

@section('content')
    <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-forest mb-5">← Kembali ke galeri</a>

    <form method="POST" enctype="multipart/form-data"
          action="{{ $photo->exists ? route('admin.gallery.update', $photo) : route('admin.gallery.store') }}"
          class="max-w-2xl">
        @csrf
        @if ($photo->exists) @method('PUT') @endif

        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
            <x-admin.input name="title" label="Judul / Alt Foto" :value="$photo->title" required hint="Dipakai sebagai teks alternatif gambar." />
            <x-admin.input name="caption" label="Keterangan (opsional)" :value="$photo->caption" />
            <div class="grid sm:grid-cols-2 gap-4">
                <x-admin.select name="ratio" label="Rasio Tampilan" :value="$photo->ratio"
                                :options="['1/1' => 'Kotak (1:1)', '4/3' => 'Lanskap (4:3)', '3/2' => 'Lanskap (3:2)', '16/9' => 'Lebar (16:9)', '3/4' => 'Potret (3:4)', '2/3' => 'Potret (2:3)']" />
                <x-admin.input name="sort_order" type="number" label="Urutan" :value="$photo->sort_order ?? 0" hint="Makin kecil makin dulu." />
            </div>

            <div>
                <label class="block text-sm font-medium text-forest mb-1.5">Foto {{ $photo->exists ? '(biarkan kosong bila tak ganti)' : '' }}</label>
                @if ($photo->image)
                    <img src="{{ asset('uploads/galleries/' . $photo->image) }}" class="w-40 rounded-lg mb-2" style="aspect-ratio: {{ $photo->ratio ?: '1/1' }}; object-fit: cover" alt="">
                @endif
                <input type="file" name="image" accept="image/*" {{ $photo->exists ? '' : 'required' }}
                       class="block w-full text-sm text-muted file:mr-3 file:rounded-lg file:border-0 file:bg-forest file:px-4 file:py-2 file:text-cream file:text-sm hover:file:bg-forest-2">
                <p class="text-xs text-muted mt-1">JPG/PNG, maks 4 MB.</p>
                @error('image')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </section>

        <div class="flex items-center gap-2 mt-6">
            <button type="submit" class="rounded-lg bg-forest px-6 py-2.5 text-sm font-semibold text-cream hover:bg-forest-2 transition">
                {{ $photo->exists ? 'Simpan Perubahan' : 'Unggah Foto' }}
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="rounded-lg border border-ink/15 px-6 py-2.5 text-sm hover:bg-cream">Batal</a>
        </div>
    </form>
@endsection
