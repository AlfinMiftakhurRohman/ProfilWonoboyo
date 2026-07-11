<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * galleries: grid foto dengan lightbox. Kolom ratio menentukan bentuk tiap
 * foto pada layout masonry (mis. 4/5, 1/1); default 1/1 bila kosong.
 * image dibuat nullable agar view merender placeholder, bukan ikon rusak.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('caption')->nullable();
            $table->string('ratio')->default('1/1');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
