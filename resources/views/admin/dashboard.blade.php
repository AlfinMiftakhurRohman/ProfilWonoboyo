@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <p class="text-sm text-muted mb-6">Selamat datang, {{ Auth::user()->name }}. Ringkasan isi situs desa.</p>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ($stats as $s)
            <a href="{{ route($s['route']) }}"
               class="group rounded-xl bg-white border border-ink/10 p-5 shadow-sm hover:shadow-md hover:border-leaf/40 transition">
                <div class="text-3xl font-serif text-forest">{{ $s['total'] }}</div>
                <div class="mt-1 text-sm font-medium text-ink">{{ $s['label'] }}</div>
                <div class="text-xs text-muted mt-0.5">{{ $s['sub'] }}</div>
                <div class="mt-3 text-xs font-mono uppercase tracking-wider text-leaf opacity-0 group-hover:opacity-100 transition">Kelola →</div>
            </a>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Berita terbaru --}}
        <div class="rounded-xl bg-white border border-ink/10 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-ink/10 flex items-center justify-between">
                <h2 class="font-semibold text-forest">Berita Terbaru</h2>
                <a href="{{ route('admin.posts.create') }}" class="text-xs font-medium text-amber hover:underline">+ Tulis baru</a>
            </div>
            <ul class="divide-y divide-ink/5">
                @forelse ($recentPosts as $post)
                    <li>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-cream/60 transition">
                            <span class="w-2 h-2 rounded-full shrink-0 {{ $post->is_published ? 'bg-leaf' : 'bg-ink/25' }}"></span>
                            <span class="flex-1 min-w-0">
                                <span class="block text-sm text-ink truncate">{{ $post->title }}</span>
                                <span class="block text-xs text-muted">{{ $post->category_label }} · {{ $post->created_at->diffForHumans() }}</span>
                            </span>
                        </a>
                    </li>
                @empty
                    <li class="px-5 py-6 text-sm text-muted text-center">Belum ada berita.</li>
                @endforelse
            </ul>
        </div>

        {{-- Aksi cepat --}}
        <div class="rounded-xl bg-white border border-ink/10 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-ink/10">
                <h2 class="font-semibold text-forest">Aksi Cepat</h2>
            </div>
            <div class="p-5 grid grid-cols-2 gap-3">
                <a href="{{ route('admin.posts.create') }}" class="rounded-lg border border-ink/10 px-4 py-3 text-sm hover:border-leaf/40 hover:bg-cream/60 transition">+ Berita</a>
                <a href="{{ route('admin.products.create') }}" class="rounded-lg border border-ink/10 px-4 py-3 text-sm hover:border-leaf/40 hover:bg-cream/60 transition">+ Produk</a>
                <a href="{{ route('admin.officials.create') }}" class="rounded-lg border border-ink/10 px-4 py-3 text-sm hover:border-leaf/40 hover:bg-cream/60 transition">+ Perangkat</a>
                <a href="{{ route('admin.gallery.create') }}" class="rounded-lg border border-ink/10 px-4 py-3 text-sm hover:border-leaf/40 hover:bg-cream/60 transition">+ Foto galeri</a>
                <a href="{{ route('admin.settings.edit') }}" class="col-span-2 rounded-lg border border-ink/10 px-4 py-3 text-sm hover:border-leaf/40 hover:bg-cream/60 transition">⚙ Ubah pengaturan situs</a>
            </div>
        </div>
    </div>
@endsection
