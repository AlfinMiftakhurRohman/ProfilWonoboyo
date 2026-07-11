<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Halaman Pemerintahan menampilkan dua bagian terpisah: perangkat desa & BPD.
 * Kolom group membedakan keduanya secara eksplisit (bukan menebak dari teks
 * jabatan), sehingga admin bisa mengelola anggota BPD dengan benar.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->enum('group', ['perangkat', 'bpd'])->default('perangkat')->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
};
