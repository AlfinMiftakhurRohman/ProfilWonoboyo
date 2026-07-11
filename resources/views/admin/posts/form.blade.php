@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Berita' : 'Tulis Berita')

@section('content')
    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-forest mb-5">← Kembali ke daftar</a>

    <form method="POST" enctype="multipart/form-data"
          action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
          class="grid lg:grid-cols-3 gap-6">
        @csrf
        @if ($post->exists) @method('PUT') @endif

        {{-- Kolom utama --}}
        <div class="lg:col-span-2 space-y-6">
            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <x-admin.input name="title" label="Judul" :value="$post->title" required />
                <x-admin.input name="slug" label="Slug (opsional)" :value="$post->slug" hint="Kosongkan untuk dibuat otomatis dari judul." />
                <x-admin.textarea name="excerpt" label="Ringkasan" :value="$post->excerpt" rows="2" hint="Tampil di daftar & pratinjau. Maks 500 karakter." />
                <x-admin.textarea name="body" label="Isi Berita" :value="$post->body" rows="14" hint="Ketik biasa saja — pisahkan paragraf dengan baris kosong. Paham HTML? Tag akan dihormati." required />
            </section>

            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-forest">Lampiran (opsional)</h2>
                @if ($post->attachment)
                    <p class="text-sm text-muted">File saat ini: <span class="text-ink">{{ $post->attachment_name ?? $post->attachment }}</span></p>
                @endif
                <input type="file" name="attachment" class="block w-full text-sm text-muted file:mr-3 file:rounded-lg file:border-0 file:bg-forest file:px-4 file:py-2 file:text-cream file:text-sm hover:file:bg-forest-2">
                <p class="text-xs text-muted">PDF/DOC/XLS, maks 8 MB.</p>
                @error('attachment')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </section>
        </div>

        {{-- Sidebar meta --}}
        <div class="space-y-6">
            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-forest">Publikasi</h2>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published))
                           class="rounded border-ink/25 text-leaf focus:ring-leaf">
                    <span>Terbitkan (tampil di situs)</span>
                </label>
                <x-admin.input name="published_at" type="datetime-local" label="Tanggal Tayang"
                               :value="optional($post->published_at)->format('Y-m-d\TH:i')"
                               hint="Kosong = otomatis saat diterbitkan." />
                <x-admin.select name="category" label="Kategori" :value="$post->category"
                                :options="['berita' => 'Berita', 'pengumuman' => 'Pengumuman']" />
                <x-admin.input name="author" label="Penulis" :value="$post->author" placeholder="mis. Admin Desa" />
            </section>

            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-forest">Gambar Sampul</h2>
                @if ($post->image)
                    <img src="{{ asset('uploads/posts/' . $post->image) }}" class="w-full aspect-video object-cover rounded-lg" alt="">
                    <label class="flex items-center gap-2 text-xs text-red-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-ink/25 text-red-500 focus:ring-red-400">
                        Hapus gambar ini
                    </label>
                @endif
                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-muted file:mr-3 file:rounded-lg file:border-0 file:bg-forest file:px-4 file:py-2 file:text-cream file:text-sm hover:file:bg-forest-2">
                <p class="text-xs text-muted">JPG/PNG, maks 4 MB.</p>
                @error('image')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                <x-admin.input name="image_caption" label="Keterangan gambar" :value="$post->image_caption" />
            </section>

            <div class="flex flex-col gap-2">
                <button type="submit" class="rounded-lg bg-forest px-6 py-2.5 text-sm font-semibold text-cream hover:bg-forest-2 transition">
                    {{ $post->exists ? 'Simpan Perubahan' : 'Simpan Berita' }}
                </button>
                <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-ink/15 px-6 py-2.5 text-sm text-center hover:bg-cream">Batal</a>
            </div>
        </div>
    </form>
@endsection
