@extends('layouts.admin')

@section('title', 'Produk Desa')

@section('content')
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk…"
                   class="rounded-lg border-ink/15 bg-white text-sm shadow-sm focus:border-leaf focus:ring-leaf w-48">
            <select name="kategori" onchange="this.form.submit()"
                    class="rounded-lg border-ink/15 bg-white text-sm shadow-sm focus:border-leaf focus:ring-leaf">
                <option value="">Semua kategori</option>
                <option value="umkm" @selected(request('kategori')==='umkm')>UMKM</option>
                <option value="hasil_tani" @selected(request('kategori')==='hasil_tani')>Hasil Tani</option>
                <option value="olahan" @selected(request('kategori')==='olahan')>Olahan</option>
            </select>
            <button class="rounded-lg border border-ink/15 bg-white px-3 py-2 text-sm hover:bg-cream">Cari</button>
        </form>
        <a href="{{ route('admin.products.create') }}"
           class="ml-auto rounded-lg bg-forest px-4 py-2 text-sm font-semibold text-cream hover:bg-forest-2 transition">+ Tambah Produk</a>
    </div>

    <div class="rounded-xl bg-white border border-ink/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-cream/70 text-left text-xs uppercase tracking-wider text-muted">
                    <tr>
                        <th class="px-4 py-3 font-medium">Produk</th>
                        <th class="px-4 py-3 font-medium">Kategori</th>
                        <th class="px-4 py-3 font-medium">Harga</th>
                        <th class="px-4 py-3 font-medium">Ketersediaan</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink/5">
                    @forelse ($products as $product)
                        <tr class="hover:bg-cream/40">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-11 h-11 rounded-lg bg-sand overflow-hidden shrink-0">
                                        @if ($product->primaryImage)
                                            <img src="{{ asset('uploads/products/' . $product->primaryImage->image) }}" class="w-full h-full object-cover" alt="">
                                        @endif
                                    </span>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-ink hover:text-leaf">{{ $product->name }}</a>
                                </div>
                            </td>
                            <td class="px-4 py-3"><span class="inline-flex rounded-full bg-leaf/15 text-forest px-2.5 py-0.5 text-xs font-medium">{{ $product->category_label }}</span></td>
                            <td class="px-4 py-3 text-ink">Rp {{ number_format($product->price, 0, ',', '.') }}<span class="text-muted text-xs"> / {{ $product->unit }}</span></td>
                            <td class="px-4 py-3 text-muted">{{ $product->availability_label }}</td>
                            <td class="px-4 py-3">
                                @if ($product->is_published)
                                    <span class="inline-flex items-center gap-1.5 text-xs text-forest"><span class="w-1.5 h-1.5 rounded-full bg-leaf"></span>Terbit</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs text-muted"><span class="w-1.5 h-1.5 rounded-full bg-ink/25"></span>Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-md border border-ink/15 px-2.5 py-1 text-xs hover:bg-cream">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-md border border-red-200 px-2.5 py-1 text-xs text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-10 text-center text-muted">Belum ada produk. <a href="{{ route('admin.products.create') }}" class="text-amber hover:underline">Tambah yang pertama →</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $products->links('pagination::tailwind') }}</div>
@endsection
