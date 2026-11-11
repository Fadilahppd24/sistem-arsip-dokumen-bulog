<?php

namespace App\Services;

use App\Jobs\ArsipkanDokumenJob;
use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class ProsesOcrDokumenService
{
    /**
     * Memproses satu PDF yang sudah tersimpan pada disk public.
     * Mengembalikan status, message, dan dokumen_id.
     */
    public function proses(string $filePath, string $originalFilename, int $userId): array
    {
        $path = $filePath;
        $fileSize = Storage::disk('public')->size($path);

       $pdftoppm = config('ocr.pdftoppm_path');

    $tesseract = config('ocr.tesseract_path');

    if (config('ocr.tessdata_dir')) {
        putenv('TESSDATA_PREFIX=' . config('ocr.tessdata_dir'));
    }

    $ocrFolder = null;

    try {

            /*
            |--------------------------------------------------------------------------
            | 1. Simpan PDF
            |--------------------------------------------------------------------------
            */

            // PDF sudah disimpan oleh controller sebelum Job dijalankan.

            $pdfPath = storage_path('app/public/' . $path);

            /*
            |--------------------------------------------------------------------------
            | 2. Nama dokumen dari nama file
            |--------------------------------------------------------------------------
            */

            $namaFile = pathinfo(
                $originalFilename,
                PATHINFO_FILENAME
            );

            $namaDokumen = $namaFile;

            /*
            |--------------------------------------------------------------------------
            | 3. Folder sementara OCR
            |--------------------------------------------------------------------------
            */

            $ocrFolder = storage_path(
                'app/ocr/' . uniqid('dokumen_', true)
            );

            if (!is_dir($ocrFolder)) {
                mkdir($ocrFolder, 0777, true);
            }

            /*
            |--------------------------------------------------------------------------
            | 4. PDF -> JPG resolusi tinggi
            |--------------------------------------------------------------------------
            |
            | 200 DPI cukup untuk OCR umum.
            | Tanggal TTD akan dibaca ulang pada halaman yang
            | terdeteksi memiliki blok "Mengetahui".
            |--------------------------------------------------------------------------
            */

            $outputPrefix = $ocrFolder . DIRECTORY_SEPARATOR . 'page';

            $commandPdf = '"' . $pdftoppm . '"'
    . ' -jpeg'
    . ' -r 200'
    . ' -f 1'
    . ' -l 2'
    . ' "' . $pdfPath . '"'
    . ' "' . $outputPrefix . '"';

            shell_exec($commandPdf);

            /*
            |--------------------------------------------------------------------------
            | 5. Ambil seluruh halaman
            |--------------------------------------------------------------------------
            */

            $gambar = glob($outputPrefix . '-*.jpg');

            if (empty($gambar)) {
                throw new \Exception(
                    'PDF tidak berhasil dikonversi menjadi gambar.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 6. OCR setiap halaman
            |--------------------------------------------------------------------------
            */

            $hasilOCR = '';
            $ocrPages = [];

            foreach ($gambar as $gambarPath) {

                $namaHalaman = pathinfo(
                    $gambarPath,
                    PATHINFO_FILENAME
                );

                $outputText = $ocrFolder
                    . DIRECTORY_SEPARATOR
                    . 'hasil_' . $namaHalaman;

                $commandOcr = '"' . $tesseract . '"'
                    . ' "' . $gambarPath . '"'
                    . ' "' . $outputText . '"'
                    . ' -l ind'
                    . ' --psm 6';

                shell_exec($commandOcr);

                $textFile = $outputText . '.txt';

                $teksHalaman = '';

                if (file_exists($textFile)) {
                    $teksHalaman = file_get_contents($textFile);
                }

                $ocrPages[] = $teksHalaman;

                $hasilOCR .= "\n\n" . $teksHalaman;
            }

            \Log::info('HASIL OCR DOKUMEN', [
                'file' => $originalFilename,
                'jumlah_halaman' => count($ocrPages),
                'ocr' => $hasilOCR,
            ]);

/*
|--------------------------------------------------------------------------
| 7. Tanggal dokumen = "Waktu : dd-mm-yyyy|hh:mm" di bagian bawah halaman 1
|--------------------------------------------------------------------------
*/

$tanggalDokumen = null;

// Hanya halaman pertama
$teksHalamanPertama = preg_replace('/[ \t]+/', ' ', $ocrPages[0] ?? '');

$tgl = '(\d{1,2})\s*[-\/.]\s*(\d{1,2})\s*[-\/.]\s*(\d{4})';

$polaCoba = [
    // 1. Label "Waktu" (toleran salah baca), lalu tanggal
    '/W[a-z]{1,3}[kx][a-z]{0,2}u\s*[^\d\n]{0,15}' . $tgl . '/iu',

    // 2. Cadangan: tanggal yang diikuti jam, mis. 07-10-2026|15:36
    '/' . $tgl . '\s*[|Il1!\[\]\/\\\\]?\s*\d{1,2}\s*[:.;]\s*\d{2}/u',
];

foreach ($polaCoba as $pola) {

    if (!preg_match_all($pola, $teksHalamanPertama, $semuaMatch, PREG_SET_ORDER)) {
        continue;
    }

    // Ambil match TERAKHIR yang valid, karena posisinya paling bawah halaman
    foreach (array_reverse($semuaMatch) as $match) {

        $hari  = (int) $match[1];
        $bulan = (int) $match[2];
        $tahun = (int) $match[3];

        if ($tahun >= 2000 && $tahun <= 2100 && checkdate($bulan, $hari, $tahun)) {
            $tanggalDokumen = sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
            break 2;
        }
    }
}

if ($tanggalDokumen) {

    \Log::info('Tanggal dokumen ditemukan', [
        'file' => $originalFilename,
        'tanggal_dokumen' => $tanggalDokumen,
    ]);

} else {

    \Log::warning('Tanggal dokumen tidak ditemukan', [
        'file' => $originalFilename,
        // 500 karakter terakhir, karena tanggal ada di bagian bawah halaman
        'potongan_ocr_bawah' => mb_substr($teksHalamanPertama, -500),
    ]);

    throw new \Exception('Tanggal TTD tidak ditemukan dari OCR.');
}
            /*
            |--------------------------------------------------------------------------
            | 10. Ambil Alamat Mitra dari OCR
            |--------------------------------------------------------------------------
            */

            $namaMitra = null;

            if (preg_match(
                '/Alamat\s*Mitra\s*[:\-]?\s*(.+)/i',
                $hasilOCR,
                $match
            )) {

                $namaMitra = trim($match[1]);

                $namaMitra = preg_split(
                    '/\r?\n/',
                    $namaMitra
                )[0];

                $namaMitra = trim($namaMitra);
            }

            /*
            |--------------------------------------------------------------------------
            | 11. Pecah nama file
            |--------------------------------------------------------------------------
            */

            $nomorKeterangan = null;
            $deskripsi = null;

            $kataKategori = [
                'ANGKUTAN',
                'PENGOLAHAN',
                'GKP',
            ];

            $posisiKategori = null;

            foreach ($kataKategori as $kata) {

                $posisi = stripos($namaFile, $kata);

                if ($posisi !== false) {

                    if (
                        $posisiKategori === null ||
                        $posisi < $posisiKategori
                    ) {
                        $posisiKategori = $posisi;
                    }
                }
            }

            if ($posisiKategori !== null) {

                $bagianAwal = trim(
                    substr($namaFile, 0, $posisiKategori)
                );

                $deskripsi = trim(
                    substr($namaFile, $posisiKategori)
                );

                $nomorKeterangan = $bagianAwal;

            } else {

                $nomorKeterangan = $namaFile;
                $deskripsi = null;
            }

            /*
            |--------------------------------------------------------------------------
            | 12. Tentukan kategori
            |--------------------------------------------------------------------------
            */

            $deskripsiUpper = strtoupper($deskripsi ?? '');

            if (str_contains($deskripsiUpper, 'ANGKUTAN')) {

                $namaKategori = 'Angkutan';

            } elseif (str_contains($deskripsiUpper, 'PENGOLAHAN')) {

                $namaKategori = 'Pengolahan';

            } elseif (str_contains($deskripsiUpper, 'GKP')) {

                $namaKategori = 'GKP';

            } else {

                $namaKategori = 'Lainnya';
            }

            $kategoriId = Kategori::where(
                'nama',
                $namaKategori
            )->value('id');

            /*
            |--------------------------------------------------------------------------
            | 13. Tambahkan nama mitra ke Nomor/Keterangan
            |--------------------------------------------------------------------------
            */

            if (
                $namaMitra &&
                !str_contains(
                    strtoupper($nomorKeterangan ?? ''),
                    strtoupper($namaMitra)
                )
            ) {
                $nomorKeterangan = trim(
                    ($nomorKeterangan ?? '') . ' ' . $namaMitra
                );
            }

        /*
|--------------------------------------------------------------------------
| 14. Cek duplikat sebelum simpan
|--------------------------------------------------------------------------
*/

$cekDuplikat = Dokumen::where(
    'nama_dokumen',
    $namaDokumen
)
    ->where(
        'nomor_keterangan',
        $nomorKeterangan
    )
    ->exists();

if ($cekDuplikat) {
    \Log::warning('Dokumen duplikat dilewati', [
        'file' => $originalFilename,
        'nama_dokumen' => $namaDokumen,
        'nomor_keterangan' => $nomorKeterangan,
    ]);

    Storage::disk('public')->delete($path);

    return [
        'status' => 'duplikat',
        'message' => 'Dokumen dengan nama dan nomor/keterangan yang sama sudah ada di arsip.',
        'dokumen_id' => null,
    ];
}

/*
|--------------------------------------------------------------------------
| 15. Simpan database
|--------------------------------------------------------------------------
*/

$dokumen = Dokumen::create([
    'kategori_id' => $kategoriId,
    'nama_dokumen' => $namaDokumen,
    'nomor_keterangan' => $nomorKeterangan,
    'tanggal_dokumen' => $tanggalDokumen,
    'deskripsi' => $deskripsi,
    'file_path' => $path,
    'file_size' => $fileSize,
    'user_id' => $userId,
    'file_hash' => hash_file('sha256', $pdfPath),
    'isi_ocr' => trim($hasilOCR),
    'status_ocr' => 'proses',
]);

ArsipkanDokumenJob::dispatch($dokumen->id);

return [
    'status' => 'berhasil',
    'message' => 'Dokumen berhasil disimpan ke arsip.',
    'dokumen_id' => $dokumen->id,
];


    } catch (\Throwable $e) {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        \Log::error('Gagal memproses upload dokumen banyak', [
            'file' => $originalFilename,
            'error' => $e->getMessage(),
        ]);

        if (str_contains($e->getMessage(), 'Tanggal TTD tidak ditemukan')) {
            $alasan = 'OCR tidak menemukan tanggal tanda tangan pada dokumen.';
        } elseif (str_contains($e->getMessage(), 'PDF tidak berhasil dikonversi')) {
            $alasan = 'Halaman PDF tidak dapat dikonversi menjadi gambar untuk OCR.';
        } else {
            $alasan = 'Terjadi kesalahan ketika memproses atau menyimpan dokumen. Periksa log Laravel.';
        }

        return ['status' => 'gagal', 'message' => $alasan, 'dokumen_id' => null];
    } finally {
        if ($ocrFolder && is_dir($ocrFolder)) {
            foreach (glob($ocrFolder . DIRECTORY_SEPARATOR . '*') as $temporaryFile) {
                if (is_file($temporaryFile)) {
                    @unlink($temporaryFile);
                }
            }
            @rmdir($ocrFolder);
        }
    }
    }
}
