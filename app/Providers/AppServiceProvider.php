<?php

namespace App\Providers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Format tanggal berbahasa Indonesia (mis. "10 Juli 2026") lewat
        // Carbon->translatedFormat()/->isoFormat() di seluruh view.
        Carbon::setLocale('id');

        // $settings dibagikan ke semua halaman publik + komponen situs (footer,
        // dsb.) karena Setting::map() dibaca di hampir setiap halaman (kontak,
        // sosmed, statistik). Dipusatkan di sini agar controller tak perlu
        // mengambilnya berulang-ulang. Sudah di-cache lewat Setting::map().
        View::composer(['pages.*', 'components.site.*'], function ($view) {
            $view->with('settings', Setting::map());
        });
    }
}
