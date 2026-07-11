<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * settings: tabel key-value. Satu-satunya sumber kebenaran untuk data kontak
 * dan konten semi-statis (kontak_wa, sambutan_teks, geo_*, stat_*, peta_*, dst).
 * Dibaca hampir di setiap halaman, jadi hasilnya di-cache di model Setting.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
