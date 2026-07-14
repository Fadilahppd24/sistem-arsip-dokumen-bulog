<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class DokumenSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $data = [
            ['kategori' => 'Pengolahan', 'nama' => 'Laporan Pengolahan Juli 2026', 'nomor' => '123/LAP/PGH/VII/2026', 'tanggal' => '2026-07-13'],
            ['kategori' => 'Angkutan', 'nama' => 'BA Pemeriksaan Mesin', 'nomor' => '045/BA/PGH/VII/2026', 'tanggal' => '2026-07-12'],
            ['kategori' => 'Pengolahan', 'nama' => 'Rekap Produksi Harian', 'nomor' => '098/PGH/VII/2026', 'tanggal' => '2026-07-11'],
            ['kategori' => 'Pengolahan', 'nama' => 'Evaluasi Kinerja Bulanan', 'nomor' => '067/EVAL/PGH/VII/2026', 'tanggal' => '2026-07-10'],
            ['kategori' => 'Pengolahan', 'nama' => 'Berita Acara Perawatan', 'nomor' => '032/BA/PGH/VII/2026', 'tanggal' => '2026-07-08'],
            ['kategori' => 'GKP', 'nama' => 'Rekap GKP Mingguan', 'nomor' => '014/GKP/VII/2026', 'tanggal' => '2026-07-10'],
            ['kategori' => 'Angkutan', 'nama' => 'Surat Tugas Pengiriman', 'nomor' => '021/ST/AKT/VII/2026', 'tanggal' => '2026-07-11'],
        ];

        foreach ($data as $item) {
            $kategori = Kategori::where('nama', $item['kategori'])->first();

            Dokumen::firstOrCreate(
                ['nomor_keterangan' => $item['nomor']],
                [
                    'kategori_id' => $kategori->id,
                    'nama_dokumen' => $item['nama'],
                    'tanggal_dokumen' => $item['tanggal'],
                    'deskripsi' => 'Dokumen contoh (seed) untuk keperluan demo aplikasi.',
                    'file_path' => 'dokumen/contoh-dokumen.pdf',
                    'file_size' => 1300000,
                    'user_id' => $admin->id,
                ]
            );
        }
    }
}
