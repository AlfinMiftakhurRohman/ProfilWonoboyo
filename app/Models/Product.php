<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Product: katalog produk desa (tanpa transaksi online, hanya link WA).
 * price = integer rupiah polos; seller_wa = format internasional tanpa '+'.
 */
class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'description', 'price', 'unit',
        'seller_name', 'seller_wa', 'availability', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'price' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /** Semua gambar produk, gambar utama diprioritaskan lalu urut sort_order. */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /** Gambar utama (is_primary = true) untuk thumbnail/kartu. */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /** Hanya produk yang dipublikasikan. Wajib dipakai di semua query publik. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /** Label kategori yang enak dibaca (nilai DB: umkm|hasil_tani|olahan). */
    protected function categoryLabel(): Attribute
    {
        return Attribute::get(fn () => match ($this->category) {
            'umkm' => 'UMKM',
            'hasil_tani' => 'Hasil Tani',
            'olahan' => 'Olahan',
            default => ucfirst((string) $this->category),
        });
    }

    /** Label ketersediaan (nilai DB: tersedia|habis|pre_order). */
    protected function availabilityLabel(): Attribute
    {
        return Attribute::get(fn () => match ($this->availability) {
            'tersedia' => 'Tersedia',
            'habis' => 'Habis',
            'pre_order' => 'Pre-order',
            default => (string) $this->availability,
        });
    }
}
