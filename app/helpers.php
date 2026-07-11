<?php

/**
 * Helper global untuk halaman publik. Diautoload lewat composer.json ("files").
 */

if (! function_exists('wa_link')) {
    /**
     * Bangun tautan wa.me dari nomor (format apa pun) + teks prefill.
     * Nomor dinormalisasi ke digit saja (wa.me hanya menerima format itu),
     * teks di-urlencode. Mengembalikan null bila nomor kosong → pemanggil
     * bisa menyembunyikan tombol dengan aman.
     */
    function wa_link(?string $number, string $text = ''): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $number);
        if ($digits === '') {
            return null;
        }
        $url = 'https://wa.me/' . $digits;
        if ($text !== '') {
            $url .= '?text=' . rawurlencode($text);
        }
        return $url;
    }
}

if (! function_exists('rupiah')) {
    /** Format integer rupiah polos menjadi "Rp 55.000". */
    function rupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (! function_exists('human_filesize')) {
    /** Ukuran byte menjadi "KB"/"MB" yang mudah dibaca. */
    function human_filesize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1, ',', '.') . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0, ',', '.') . ' KB';
        }
        return $bytes . ' B';
    }
}
