{{-- Paginasi on-brand Wonoboyo (didaftarkan sebagai default di AppServiceProvider).
     Dipakai semua halaman berdaftar: Produk, Berita, Galeri. --}}
@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="Navigasi halaman">
        {{-- Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true" aria-label="Sebelumnya">&larr;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">&larr;</a>
        @endif

        {{-- Nomor halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">&rarr;</a>
        @else
            <span class="disabled" aria-disabled="true" aria-label="Berikutnya">&rarr;</span>
        @endif
    </nav>
@endif
