@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-sm text-muted hover:text-forest mb-5">← Kembali ke daftar</a>

    <form method="POST" enctype="multipart/form-data"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
          class="grid lg:grid-cols-3 gap-6">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        {{-- Kolom utama --}}
        <div class="lg:col-span-2 space-y-6">
            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <x-admin.input name="name" label="Nama Produk" :value="$product->name" required />
                <x-admin.input name="slug" label="Slug (opsional)" :value="$product->slug" hint="Kosongkan untuk dibuat otomatis." />
                <x-admin.textarea name="description" label="Deskripsi" :value="$product->description" rows="6" required />
                <div class="grid sm:grid-cols-2 gap-4">
                    <x-admin.input name="price" type="number" min="0" label="Harga (Rp)" :value="$product->price" required />
                    <x-admin.input name="unit" label="Satuan" :value="$product->unit" placeholder="mis. kg, ikat, botol" required />
                </div>
            </section>

            {{-- Gambar produk --}}
            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-forest">Foto Produk</h2>
                @if ($product->exists && $product->images->isNotEmpty())
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach ($product->images as $img)
                            <div class="relative group rounded-lg overflow-hidden border {{ $img->is_primary ? 'border-leaf ring-2 ring-leaf/30' : 'border-ink/10' }}">
                                <img src="{{ asset('uploads/products/' . $img->image) }}" class="w-full aspect-square object-cover" alt="">
                                <div class="absolute inset-x-0 bottom-0 bg-ink/70 text-cream text-[11px] px-2 py-1 flex items-center justify-between">
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" name="primary_image" value="{{ $img->id }}" @checked($img->is_primary) class="text-leaf focus:ring-leaf w-3 h-3">
                                        Utama
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer text-red-300">
                                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="text-red-500 w-3 h-3">
                                        Hapus
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-muted">Pilih "Utama" untuk gambar sampul; centang "Hapus" untuk membuang.</p>
                @endif
                <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-muted file:mr-3 file:rounded-lg file:border-0 file:bg-forest file:px-4 file:py-2 file:text-cream file:text-sm hover:file:bg-forest-2">
                <p class="text-xs text-muted">Bisa pilih beberapa sekaligus. JPG/PNG, maks 4 MB per foto.</p>
                @error('images.*')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </section>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-forest">Publikasi</h2>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $product->is_published))
                           class="rounded border-ink/25 text-leaf focus:ring-leaf">
                    <span>Terbitkan (tampil di situs)</span>
                </label>
                <x-admin.select name="category" label="Kategori" :value="$product->category"
                                :options="['umkm' => 'UMKM', 'hasil_tani' => 'Hasil Tani', 'olahan' => 'Olahan']" />
                <x-admin.select name="availability" label="Ketersediaan" :value="$product->availability"
                                :options="['tersedia' => 'Tersedia', 'habis' => 'Habis', 'pre_order' => 'Pre-order']" />
                <x-admin.input name="sort_order" type="number" label="Urutan" :value="$product->sort_order ?? 0" hint="Makin kecil makin dulu." />
            </section>

            <section class="rounded-xl bg-white border border-ink/10 shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-forest">Penjual</h2>
                <x-admin.input name="seller_name" label="Nama Penjual" :value="$product->seller_name" required />
                <x-admin.input name="seller_wa" label="WhatsApp Penjual" :value="$product->seller_wa" placeholder="6281234567890" hint="Format internasional tanpa +. Kosong = tombol WA jadi 'Lihat'." />
            </section>

            <div class="flex flex-col gap-2">
                <button type="submit" class="rounded-lg bg-forest px-6 py-2.5 text-sm font-semibold text-cream hover:bg-forest-2 transition">
                    {{ $product->exists ? 'Simpan Perubahan' : 'Simpan Produk' }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-ink/15 px-6 py-2.5 text-sm text-center hover:bg-cream">Batal</a>
            </div>
        </div>
    </form>
@endsection
