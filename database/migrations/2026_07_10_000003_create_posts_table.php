<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * posts: berita + pengumuman dalam satu modul, dibedakan kolom category.
 * body = rich text (dirender {!! !!}, wajib disaring saat simpan di Tahap 3).
 * Query publik wajib menyaring is_published = true DAN published_at <= now()
 * (lihat scope Published di model Post).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('image')->nullable();
            $table->string('image_caption')->nullable();
            $table->enum('category', ['berita', 'pengumuman'])->default('berita');
            $table->string('author')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('attachment')->nullable();
            $table->string('attachment_name')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
