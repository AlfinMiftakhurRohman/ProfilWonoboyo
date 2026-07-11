@extends('layouts.admin')

@section('title', 'Berita & Pengumuman')

@section('content')
    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul…"
                   class="rounded-lg border-ink/15 bg-white text-sm shadow-sm focus:border-leaf focus:ring-leaf w-48">
            <select name="kategori" onchange="this.form.submit()"
                    class="rounded-lg border-ink/15 bg-white text-sm shadow-sm focus:border-leaf focus:ring-leaf">
                <option value="">Semua kategori</option>
                <option value="berita" @selected(request('kategori')==='berita')>Berita</option>
                <option value="pengumuman" @selected(request('kategori')==='pengumuman')>Pengumuman</option>
            </select>
            <button class="rounded-lg border border-ink/15 bg-white px-3 py-2 text-sm hover:bg-cream">Cari</button>
        </form>
        <a href="{{ route('admin.posts.create') }}"
           class="ml-auto rounded-lg bg-forest px-4 py-2 text-sm font-semibold text-cream hover:bg-forest-2 transition">+ Tulis Berita</a>
    </div>

    <div class="rounded-xl bg-white border border-ink/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-cream/70 text-left text-xs uppercase tracking-wider text-muted">
                    <tr>
                        <th class="px-4 py-3 font-medium">Judul</th>
                        <th class="px-4 py-3 font-medium">Kategori</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink/5">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-cream/40">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-12 h-9 rounded bg-sand overflow-hidden shrink-0">
                                        @if ($post->image)
                                            <img src="{{ asset('uploads/posts/' . $post->image) }}" class="w-full h-full object-cover" alt="">
                                        @endif
                                    </span>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-ink hover:text-leaf line-clamp-2">{{ $post->title }}</a>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $post->category === 'pengumuman' ? 'bg-amber/15 text-amber' : 'bg-leaf/15 text-forest' }}">{{ $post->category_label }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($post->is_published)
                                    <span class="inline-flex items-center gap-1.5 text-xs text-forest"><span class="w-1.5 h-1.5 rounded-full bg-leaf"></span>Terbit</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs text-muted"><span class="w-1.5 h-1.5 rounded-full bg-ink/25"></span>Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-muted">{{ optional($post->published_at ?? $post->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-md border border-ink/15 px-2.5 py-1 text-xs hover:bg-cream">Edit</a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-md border border-red-200 px-2.5 py-1 text-xs text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-muted">Belum ada berita. <a href="{{ route('admin.posts.create') }}" class="text-amber hover:underline">Tulis yang pertama →</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $posts->links('pagination::tailwind') }}</div>
@endsection
