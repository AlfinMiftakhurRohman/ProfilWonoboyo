<?php

namespace Database\Seeders;

use App\Models\Official;
use Illuminate\Database\Seeder;

/**
 * Perangkat desa & BPD — nama PLACEHOLDER, jabatan pakai istilah baku (bukan
 * data karangan). Tepat SATU baris is_head = true agar blok Sambutan Kepala
 * Desa di Beranda punya nama/jabatan/foto untuk ditarik. Foto null → view
 * merender placeholder "Foto", bukan ikon rusak. group memisahkan perangkat
 * desa dari BPD di halaman Pemerintahan. Susunan mengikuti tata letak desain.
 */
class OfficialsSeeder extends Seeder
{
    public function run(): void
    {
        $officials = [
            // Kepala desa (dirender terpisah di atas via is_head)
            ['name' => '[NAMA KEPALA DESA]', 'position' => 'Kepala Desa', 'group' => 'perangkat', 'is_head' => true],
            // Perangkat desa
            ['name' => '[NAMA]', 'position' => 'Sekretaris Desa', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kaur Keuangan', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kaur Umum & TU', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kaur Perencanaan', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kasi Pemerintahan', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kasi Kesejahteraan', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kasi Pelayanan', 'group' => 'perangkat'],
            ['name' => '[NAMA]', 'position' => 'Kepala Dusun', 'group' => 'perangkat'],
            // BPD
            ['name' => '[NAMA]', 'position' => 'Ketua BPD', 'group' => 'bpd'],
            ['name' => '[NAMA]', 'position' => 'Wakil Ketua BPD', 'group' => 'bpd'],
            ['name' => '[NAMA]', 'position' => 'Sekretaris BPD', 'group' => 'bpd'],
        ];

        foreach ($officials as $i => $data) {
            Official::create([
                'name' => $data['name'],
                'position' => $data['position'],
                'group' => $data['group'],
                'photo' => null,
                'sort_order' => $i,
                'is_head' => $data['is_head'] ?? false,
            ]);
        }
    }
}
