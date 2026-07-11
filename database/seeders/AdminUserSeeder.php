<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Satu akun admin (satu-satunya role). Register publik Breeze dimatikan di
 * Tahap 3, jadi akun ini adalah cara masuk ke panel /admin.
 *
 * Kredensial TIDAK ditaruh di kode (agar tidak bocor ke repo). Diambil dari
 * .env: ADMIN_EMAIL & ADMIN_PASSWORD. Bila ADMIN_PASSWORD kosong, dibuat
 * password acak yang ditampilkan sekali di terminal saat seeding.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@wonoboyo.test');

        // Admin yang sudah ada tidak di-reset password-nya saat seed ulang.
        if (User::where('email', $email)->exists()) {
            $this->command?->info("Admin {$email} sudah ada — dilewati.");

            return;
        }

        $password = env('ADMIN_PASSWORD');
        $generated = false;

        if (blank($password)) {
            $password = Str::password(16);
            $generated = true;
        }

        User::create([
            'name' => 'Admin Desa',
            'email' => $email,
            // Cast 'hashed' pada model User meng-hash otomatis saat disimpan.
            'password' => $password,
            'email_verified_at' => now(),
        ]);

        if ($generated) {
            $this->command?->warn("Admin dibuat: {$email}");
            $this->command?->warn("Password ACAK: {$password}");
            $this->command?->warn('Simpan sekarang — tidak akan ditampilkan lagi. Set ADMIN_PASSWORD di .env untuk mengontrolnya.');
        }
    }
}
