<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Gallery: item galeri. ratio (mis. 4/5, 1/1) menentukan bentuk foto pada
 * layout masonry; default 1/1 bila kosong.
 */
class Gallery extends Model
{
    protected $fillable = ['title', 'image', 'caption', 'ratio', 'sort_order'];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
