@extends('layouts.admin')

@section('title', $official->exists ? 'Edit Perangkat' : 'Tambah Perangkat')

@section('content')
    <a href="{{ route('admin.officials.index') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-forest mb-5">← Kembali ke daftar</a>

    <form method="POST" enctype="multipart/form-data"
          action="{{ $official->exists ? route('admin.officials.update', $official) : route('admin.officials.store') }}"
          class="max-w-2xl">
        @csrf
        @if ($official->exists) @method('PUT') @endif

        <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <x-admin.input name="name" label="Nama Lengkap" :value="$official->name" required />
                <x-admin.input name="position" label="Jabatan" :value="$official->position" placeholder="mis. Sekretaris Desa" required />
                <x-admin.select name="group" label="Kelompok" :value="$official->group"
                                :options="['perangkat' => 'Perangkat Desa', 'bpd' => 'Anggota BPD']" />
                <x-admin.input name="sort_order" type="number" label="Urutan" :value="$official->sort_order ?? 0" hint="Makin kecil makin dulu." />
            </div>

            <label class="flex items-center gap-3 text-sm pt-1">
                <input type="checkbox" name="is_head" value="1" @checked(old('is_head', $official->is_head))
                       class="rounded border-ink/25 text-amber focus:ring-amber">
                <span>Tandai sebagai <strong>Kepala Desa</strong> <span class="text-muted">(hanya satu; menandai di sini otomatis melepas yang lama)</span></span>
            </label>

            <div>
                <label class="block text-sm font-medium text-forest mb-1.5">Foto (opsional)</label>
                @if ($official->photo)
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('uploads/officials/' . $official->photo) }}" class="w-16 h-16 rounded-full object-cover" alt="">
                        <label class="flex items-center gap-2 text-xs text-red-600">
                            <input type="checkbox" name="remove_photo" value="1" class="rounded border-ink/25 text-red-500 focus:ring-red-400">
                            Hapus foto
                        </label>
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-muted file:mr-3 file:rounded-lg file:border-0 file:bg-forest file:px-4 file:py-2 file:text-cream file:text-sm hover:file:bg-forest-2">
                <p class="text-xs text-muted mt-1">JPG/PNG, maks 4 MB. Kosong = tampil inisial nama.</p>
                @error('photo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </section>

        <div class="flex items-center gap-2 mt-6">
            <button type="submit" class="rounded-lg bg-forest px-6 py-2.5 text-sm font-semibold text-cream hover:bg-forest-2 transition">
                {{ $official->exists ? 'Simpan Perubahan' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.officials.index') }}" class="rounded-lg border border-ink/15 px-6 py-2.5 text-sm hover:bg-cream">Batal</a>
        </div>
    </form>
@endsection
