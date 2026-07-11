<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ProductImage: banyak gambar per produk. Gambar utama = is_primary = true.
 * Penghapusan file fisik saat record dihapus dilakukan lewat model event
 * (Tahap 3); cascade DB sudah menghapus baris saat produk induk dihapus.
 */
class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'is_primary', 'sort_order'];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
