<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GalleryController as AdminGallery;
use App\Http\Controllers\Admin\OfficialController as AdminOfficial;
use App\Http\Controllers\Admin\PostController as AdminPost;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
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
| Area admin (login wajib) — panel /admin
|--------------------------------------------------------------------------
| Semua CRUD isi situs: pengaturan, berita, produk, perangkat, galeri.
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('settings', [AdminSetting::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSetting::class, 'update'])->name('settings.update');

    Route::resource('posts', AdminPost::class)->except('show');
    Route::resource('products', AdminProduct::class)->except('show');
    Route::resource('officials', AdminOfficial::class)->except('show');
    Route::resource('gallery', AdminGallery::class)->except('show')->parameters(['gallery' => 'gallery']);
});

// Breeze mengarahkan ke 'dashboard' setelah login → teruskan ke panel admin.
// Route::redirect (bukan closure) supaya route:cache tetap jalan saat deploy.
Route::redirect('/dashboard', '/admin')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
