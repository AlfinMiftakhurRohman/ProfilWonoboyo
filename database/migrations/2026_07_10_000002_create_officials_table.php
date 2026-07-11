<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * officials: perangkat desa & BPD. Kepala desa = baris is_head = true
 * (hanya boleh satu; aturan tunggal ditegakkan di form admin, Tahap 3).
 * Nama/jabatan/foto kepala desa hidup di sini, bukan di settings.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('photo')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_head')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
