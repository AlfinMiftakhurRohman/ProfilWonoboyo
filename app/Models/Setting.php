<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Setting: key-value, SATU-SATUNYA sumber kebenaran untuk data kontak & konten
 * semi-statis (kontak_wa, sambutan_teks, geo_*, stat_*, peta_*, sosmed_*, dst).
 *
 * Dibaca hampir di setiap halaman, jadi seluruh baris di-cache sebagai satu map
 * key=>value. Cache otomatis dibersihkan setiap kali ada baris disimpan/dihapus
 * (lewat event booted), sehingga admin mengganti nomor di satu tempat dan semua
 * halaman langsung ikut berubah.
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public const CACHE_KEY = 'settings.map';

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }

    /** Seluruh setting sebagai array [key => value], di-cache. */
    public static function map(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    /** Ambil satu nilai setting; kembalikan $default bila key tidak ada/null. */
    public static function get(string $key, $default = null)
    {
        return self::map()[$key] ?? $default;
    }

    /** Simpan satu setting; event booted membersihkan cache. */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
