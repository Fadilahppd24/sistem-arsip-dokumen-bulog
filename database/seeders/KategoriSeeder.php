<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Angkutan', 'icon' => 'bi-truck', 'warna' => 'primary'],
            ['nama' => 'Pengolahan', 'icon' => 'bi-gear-fill', 'warna' => 'warning'],
            ['nama' => 'GKP', 'icon' => 'bi-flower1', 'warna' => 'info'],
            ['nama' => 'Lainnya', 'icon' => 'bi-folder-fill', 'warna' => 'secondary'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(['nama' => $kategori['nama']], $kategori);
        }
    }
}
