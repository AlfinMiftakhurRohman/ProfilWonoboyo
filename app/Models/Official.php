<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Official: perangkat desa & BPD. Kepala desa adalah baris is_head = true.
 * Aturan "hanya satu is_head" ditegakkan di form admin (Tahap 3), bukan di sini.
 */
class Official extends Model
{
    protected $fillable = ['name', 'position', 'group', 'photo', 'sort_order', 'is_head'];

    protected function casts(): array
    {
        return [
            'is_head' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /** Anggota BPD saja (untuk bagian BPD di halaman Pemerintahan). */
    public function scopeBpd(Builder $query): Builder
    {
        return $query->where('group', 'bpd');
    }

    /** Perangkat desa selain kepala desa (kepala desa dirender terpisah). */
    public function scopePerangkat(Builder $query): Builder
    {
        return $query->where('group', 'perangkat')->where('is_head', false);
    }

    /** Kepala desa saat ini, atau null bila belum ditandai. */
    public static function head(): ?self
    {
        return static::where('is_head', true)->first();
    }
}
