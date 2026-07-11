<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Post: berita + pengumuman (dibedakan kolom category).
 * body = rich text, dirender {!! !!} dan wajib disaring saat disimpan (Tahap 3).
 */
class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'image', 'image_caption',
        'category', 'author', 'is_published', 'published_at',
        'attachment', 'attachment_name',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Hanya post yang benar-benar tayang untuk publik: sudah dipublikasikan
     * DAN tanggal tayangnya sudah lewat. Wajib dipakai di semua query publik
     * agar draft & post terjadwal tidak bocor.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Estimasi baca (menit) dihitung dari jumlah kata body (~200 kata/menit),
     * minimal 1 menit. Sengaja TIDAK disimpan di DB karena bisa dihitung ulang.
     */
    protected function readingTime(): Attribute
    {
        return Attribute::get(function () {
            $words = str_word_count(strip_tags((string) $this->body));

            return max(1, (int) ceil($words / 200));
        });
    }

    /** Label kategori yang enak dibaca (nilai DB: berita|pengumuman). */
    protected function categoryLabel(): Attribute
    {
        return Attribute::get(fn () => match ($this->category) {
            'pengumuman' => 'Pengumuman',
            'berita' => 'Berita',
            default => ucfirst((string) $this->category),
        });
    }

    /**
     * Body siap-render untuk view. Bila admin sudah menulis HTML blok (mis. <p>),
     * dipakai apa adanya. Bila hanya teks polos dari textarea, otomatis dibungkus
     * paragraf per baris kosong (dan <br> untuk baris tunggal) DAN di-escape —
     * sehingga admin cukup mengetik biasa tanpa tahu HTML, sekaligus aman dari
     * injeksi pada konten teks polos. Dipakai di view lewat {!! $post->rendered_body !!}.
     */
    protected function renderedBody(): Attribute
    {
        return Attribute::get(function () {
            $body = trim((string) $this->body);
            if ($body === '') {
                return '';
            }
            // Sudah ada tag blok → anggap HTML yang disusun admin, render apa adanya.
            if (preg_match('/<(p|div|ul|ol|h[1-6]|blockquote|table|figure)\b/i', $body)) {
                return $body;
            }
            // Teks polos → paragraf per baris kosong, sisanya <br>, semua di-escape.
            $paragraphs = preg_split('/\R{2,}/u', $body);

            return collect($paragraphs)
                ->map(fn ($p) => '<p>'.nl2br(e(trim($p))).'</p>')
                ->implode("\n");
        });
    }

    /** Ukuran file lampiran (dari file fisik), atau null bila tak ada. */
    public function attachmentSize(): ?string
    {
        if (! $this->attachment) {
            return null;
        }
        $path = public_path('uploads/posts/'.$this->attachment);
        if (! is_file($path)) {
            return null;
        }

        return human_filesize(filesize($path));
    }
}
