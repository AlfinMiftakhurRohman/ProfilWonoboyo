<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * products: katalog produk desa (tanpa transaksi online, hanya link WA).
 * price = integer rupiah polos (mis. 55000), pemformatan di view agar bisa
 * disortir/difilter. seller_wa = format internasional tanpa + (mis. 6281...).
 * Query publik wajib menyaring is_published = true (scope Published di model).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['umkm', 'hasil_tani', 'olahan'])->default('umkm');
            $table->text('description');
            $table->unsignedInteger('price');
            $table->string('unit');
            $table->string('seller_name');
            $table->string('seller_wa');
            $table->enum('availability', ['tersedia', 'habis', 'pre_order'])->default('tersedia');
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
