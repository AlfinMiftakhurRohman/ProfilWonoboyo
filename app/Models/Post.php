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

    /** Ukuran file lampiran (dari file fisik), atau null bila tak ada. */
    public function attachmentSize(): ?string
    {
        if (! $this->attachment) {
            return null;
        }
        $path = public_path('uploads/posts/' . $this->attachment);
        if (! is_file($path)) {
            return null;
        }
        return human_filesize(filesize($path));
    }
}
