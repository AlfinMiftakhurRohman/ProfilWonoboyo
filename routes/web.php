<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik (tanpa login)
|--------------------------------------------------------------------------
| Nama route dipakai Nav untuk active state via request()->routeIs().
*/
Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/profil-desa', [PageController::class, 'profil'])->name('profil');
Route::get('/pemerintahan', [PageController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/potensi-desa', [PageController::class, 'potensi'])->name('potensi');

Route::get('/produk-desa', [ProductController::class, 'index'])->name('produk');
Route::get('/produk-desa/{slug}', [ProductController::class, 'show'])->name('produk.show');

Route::get('/berita', [PostController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('berita.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

/*
|--------------------------------------------------------------------------
| Area admin (Breeze) — panel /admin dibangun di Tahap 3
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
