<?php

namespace App\Services;

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

    $pdftoppm = 'C:\Users\Papad Cantik\AppData\Local\Microsoft\WinGet\Packages\oschwartz10612.Poppler_Microsoft.Winget.Source_8wekyb3d8bbwe\poppler-25.07.0\Library\bin\pdftoppm.exe';

    $tesseract = 'C:\Program Files\Tesseract-OCR\tesseract.exe';

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
            | 7. Cari tanggal TTD
            |--------------------------------------------------------------------------
            |
            | Tanggal yang dicari adalah tanggal pada blok tanda tangan,
            | bukan tanggal invoice, printed date, tanggal pemeriksaan,
            | atau tanggal dokumen pendukung.
            |
            | Contoh:
            |
            | Indramayu, 29-05-2026
            | Mengetahui,
            | Pimpinan Cabang
            |
            |--------------------------------------------------------------------------
            */

            $tanggalDokumen = null;

            foreach ($ocrPages as $nomorHalaman => $teksHalaman) {

                if (trim($teksHalaman) === '') {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Bersihkan spasi OCR tanpa menghilangkan newline.
                |--------------------------------------------------------------------------
                */

                $teksNormal = preg_replace(
                    '/[ \t]+/',
                    ' ',
                    $teksHalaman
                );

                /*
                |--------------------------------------------------------------------------
                | Prioritas 1:
                | tanggal + Mengetahui + Pimpinan
                |--------------------------------------------------------------------------
                */

                $polaTTD = [
                    '/(\d{1,2})\s*[-\/\.]\s*(\d{1,2})\s*[-\/\.]\s*(\d{4}).{0,400}\bMengetahui\b.{0,300}\bPimpinan\b/is',

                    '/(?:Indramayu|Cirebon|Subang|Karawang|Majalengka|Sumedang)\s*,?\s*(\d{1,2})\s*[-\/\.]\s*(\d{1,2})\s*[-\/\.]\s*(\d{4}).{0,400}\bMengetahui\b/is',

                    '/(\d{1,2})\s*[-\/\.]\s*(\d{1,2})\s*[-\/\.]\s*(\d{4}).{0,250}\bMengetahui\b/is',
                ];

                foreach ($polaTTD as $pola) {

                    if (preg_match($pola, $teksNormal, $match)) {

                        $hari  = (int) $match[1];
                        $bulan = (int) $match[2];
                        $tahun = (int) $match[3];

                        if (checkdate($bulan, $hari, $tahun)) {

                            $tanggalDokumen = sprintf(
                                '%04d-%02d-%02d',
                                $tahun,
                                $bulan,
                                $hari
                            );

                            \Log::info(
                                'Tanggal TTD berhasil ditemukan',
                                [
                                    'file' => $originalFilename,
                                    'halaman' => $nomorHalaman + 1,
                                    'tanggal_ttd' => $tanggalDokumen,
                                    'sumber' => 'OCR halaman TTD',
                                ]
                            );

                            break 2;
                        }
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Fallback khusus: jika "Mengetahui" tertutup tanda tangan,
            | cari tanggal dengan format "Indramayu, DD-MM-YYYY".
            | Tidak mengambil tanggal lain (misalnya "Paid on").
            | Jika ada beberapa tanggal Indramayu, utamakan kandidat yang
            | diikuti konteks "Pemimpin Cabang"; jika ambigu, jangan menebak.
            |--------------------------------------------------------------------------
            */
            if (!$tanggalDokumen) {
                $kandidatTanggal = [];

                foreach ($ocrPages as $nomorHalaman => $teksHalaman) {
                    $teksNormal = preg_replace('/[ \t]+/', ' ', $teksHalaman);
                    $polaIndramayu = '/\bIndramayu\s*,?\s*(\d{1,2})\s*[-\/.]\s*(\d{1,2})\s*[-\/.]\s*(\d{4})\b/iu';

                    if (!preg_match_all($polaIndramayu, $teksNormal, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
                        continue;
                    }

                    foreach ($matches as $match) {
                        $hari = (int) $match[1][0];
                        $bulan = (int) $match[2][0];
                        $tahun = (int) $match[3][0];

                        if (!checkdate($bulan, $hari, $tahun)) {
                            continue;
                        }

                        $akhir = $match[0][1] + strlen($match[0][0]);
                        $konteks = substr($teksNormal, $akhir, 450);
                        $kandidatTanggal[] = [
                            'tanggal' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari),
                            'halaman' => $nomorHalaman + 1,
                            'dekat_pemimpin_cabang' => (bool) preg_match('/\b(?:PEMIMPIN|PIMPINAN)\s+CABANG\b/iu', $konteks),
                        ];
                    }
                }

                $kandidatUtama = array_values(array_filter(
                    $kandidatTanggal,
                    fn ($kandidat) => $kandidat['dekat_pemimpin_cabang']
                ));
                $pilihan = count($kandidatUtama) === 1
                    ? $kandidatUtama[0]
                    : (count($kandidatTanggal) === 1 ? $kandidatTanggal[0] : null);

                if ($pilihan) {
                    $tanggalDokumen = $pilihan['tanggal'];
                    \Log::info('Tanggal TTD ditemukan via fallback Indramayu', [
                        'file' => $originalFilename,
                        'halaman' => $pilihan['halaman'],
                        'tanggal_ttd' => $tanggalDokumen,
                        'pola' => 'Indramayu, DD-MM-YYYY',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Fallback OCR: coretan TTD menambahkan angka 4 di depan hari.
            | Contoh: "Indramayu 402-05-2026" seharusnya "02-05-2026".
            | Koreksi hanya jika ada tanggal yang sama pada label "Paid on"
            | sebagai bukti pendukung; jangan menebak dari 3 digit saja.
            |--------------------------------------------------------------------------
            */
            if (!$tanggalDokumen) {
                $kandidatTerkonfirmasi = [];

                foreach ($ocrPages as $nomorHalaman => $teksHalaman) {
                    $teksNormal = preg_replace('/[ \t]+/', ' ', $teksHalaman);

                    if (!preg_match_all(
                        '/\bIndramayu\s*,?\s*4(\d{2})\s*[-\/.]\s*(\d{1,2})\s*[-\/.]\s*(\d{4})\b/iu',
                        $teksNormal,
                        $matches,
                        PREG_SET_ORDER
                    )) {
                        continue;
                    }

                    foreach ($matches as $match) {
                        $hari = (int) $match[1];
                        $bulan = (int) $match[2];
                        $tahun = (int) $match[3];

                        if (!checkdate($bulan, $hari, $tahun)) {
                            continue;
                        }

                        // Konfirmasi terhadap tanggal pembayaran yang terbaca
                        // jelas pada halaman yang sama, bukan sembarang tanggal.
                        $polaKonfirmasi = '/\bPaid\s*on\s*0?' . $hari
                            . '\s*[-\/.]\s*0?' . $bulan
                            . '\s*[-\/.]\s*' . $tahun . '\b/i';

                        if (!preg_match($polaKonfirmasi, $teksNormal)) {
                            \Log::warning('Koreksi tanggal OCR memerlukan verifikasi', [
                                'file' => $originalFilename,
                                'halaman' => $nomorHalaman + 1,
                                'hasil_ocr' => $match[0],
                            ]);
                            continue;
                        }

                        $kandidatTerkonfirmasi[] = [
                            'tanggal' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari),
                            'halaman' => $nomorHalaman + 1,
                            'hasil_ocr' => $match[0],
                        ];
                    }
                }

                // Pilih hanya jika seluruh kandidat terkonfirmasi sama.
                $tanggalUnik = array_unique(array_column($kandidatTerkonfirmasi, 'tanggal'));
                if (count($tanggalUnik) === 1) {
                    $pilihan = $kandidatTerkonfirmasi[0];
                    $tanggalDokumen = $pilihan['tanggal'];
                    \Log::info('Tanggal TTD terkoreksi dari noise tanda tangan', [
                        'file' => $originalFilename,
                        'halaman' => $pilihan['halaman'],
                        'hasil_ocr' => $pilihan['hasil_ocr'],
                        'tanggal_ttd' => $tanggalDokumen,
                        'konfirmasi' => 'Paid on pada halaman yang sama',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 8. Kalau tanggal TTD belum ketemu,
            |    lakukan OCR ulang pada halaman yang mengandung
            |    "Mengetahui" dengan PSM berbeda.
            |--------------------------------------------------------------------------
            */

            if (!$tanggalDokumen) {

                foreach ($ocrPages as $nomorHalaman => $teksHalaman) {

                    if (
                        stripos($teksHalaman, 'Mengetahui') === false &&
                        stripos($teksHalaman, 'Mengetahu') === false
                    ) {
                        continue;
                    }

                    $gambarPath = $gambar[$nomorHalaman] ?? null;

                    if (!$gambarPath) {
                        continue;
                    }

                    $namaHalaman = pathinfo(
                        $gambarPath,
                        PATHINFO_FILENAME
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | OCR ulang halaman TTD dengan PSM 11.
                    |--------------------------------------------------------------------------
                    */

                    $outputTextTTD = $ocrFolder
                        . DIRECTORY_SEPARATOR
                        . 'ttd_' . $namaHalaman;

                    $commandOcrTTD = '"' . $tesseract . '"'
                        . ' "' . $gambarPath . '"'
                        . ' "' . $outputTextTTD . '"'
                        . ' -l ind'
                        . ' --psm 11';

                    shell_exec($commandOcrTTD);

                    $textFileTTD = $outputTextTTD . '.txt';

                    if (!file_exists($textFileTTD)) {
                        continue;
                    }

                    $teksTTD = file_get_contents($textFileTTD);

                    \Log::info(
                        'HASIL OCR ULANG HALAMAN TTD',
                        [
                            'file' => $originalFilename,
                            'halaman' => $nomorHalaman + 1,
                            'ocr_ttd' => $teksTTD,
                        ]
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Normalisasi kesalahan OCR umum pada tanggal.
                    |--------------------------------------------------------------------------
                    */

                    $teksTTD = preg_replace(
                        '/[ \t]+/',
                        ' ',
                        $teksTTD
                    );

                    if (preg_match(
                        '/(\d{1,2})\s*[-\/\.]\s*(\d{1,2})\s*[-\/\.]\s*(\d{4}).{0,400}\bMengetahui\b/is',
                        $teksTTD,
                        $match
                    )) {

                        $hari  = (int) $match[1];
                        $bulan = (int) $match[2];
                        $tahun = (int) $match[3];

                        if (checkdate($bulan, $hari, $tahun)) {

                            $tanggalDokumen = sprintf(
                                '%04d-%02d-%02d',
                                $tahun,
                                $bulan,
                                $hari
                            );

                            \Log::info(
                                'Tanggal TTD berhasil ditemukan dari OCR ulang',
                                [
                                    'file' => $originalFilename,
                                    'halaman' => $nomorHalaman + 1,
                                    'tanggal_ttd' => $tanggalDokumen,
                                ]
                            );

                            break;
                        }
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 9. Jangan pernah menggunakan tanggal hari ini.
            |--------------------------------------------------------------------------
            */

            if (!$tanggalDokumen) {

                \Log::warning(
                    'Tanggal TTD tidak ditemukan',
                    [
                        'file' => $originalFilename,
                        'keterangan' =>
                            'Dokumen tidak disimpan karena tanggal TTD tidak berhasil dibaca.',
                    ]
                );

                throw new \Exception(
                    'Tanggal TTD tidak ditemukan dari OCR.'
                );
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
]);

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
