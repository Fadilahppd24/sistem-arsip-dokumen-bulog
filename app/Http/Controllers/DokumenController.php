<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Helpers\AuditHelper;

class DokumenController extends Controller
{
    /**
     * Daftar dokumen (dipakai Admin & User)
     * dengan filter kategori, tahun, bulan, pencarian.
     */
    public function index(Request $request): View
    {
        $query = Dokumen::with(['kategori', 'uploader'])
            ->cari($request->q);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDay('tanggal_dokumen', $request->tanggal);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_dokumen', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_dokumen', $request->bulan);
        }

        $perPage = (int) $request->get('perPage', 10);

if (!in_array($perPage, [10, 20, 50, 100, 200, 500, 1000])) {
    $perPage = 10;
}

$dokumens = $query
    ->latest('tanggal_dokumen')
    ->paginate($perPage)
    ->withQueryString();

        $kategoris = Kategori::orderBy('nama')->get();

        /*
        |--------------------------------------------------------------------------
        | Kategori yang sedang aktif
        |--------------------------------------------------------------------------
        */
        $kategoriAktif = null;

        if ($request->filled('kategori_id')) {
            $kategoriAktif = Kategori::find($request->kategori_id);
        }

        $view = Auth::user()->isAdmin()
            ? 'dokumen.index'
            : 'dokumen.index-user';

        return view($view, compact(
            'dokumens',
            'kategoris',
            'kategoriAktif'
        ));
    }

    /**
     * Form upload dokumen.
     */
    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('dokumen.create', compact('kategoris'));
    }

    /**
     * Menyimpan dokumen baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validasi($request);

        $cekDokumen = Dokumen::where(
            'nama_dokumen',
            $validated['nama_dokumen']
        )
            ->where(
                'nomor_keterangan',
                $validated['nomor_keterangan'] ?? null
            )
            ->exists();

        if ($cekDokumen) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Dokumen dengan nama dan nomor yang sama sudah ada.'
                );
        }

        $file = $request->file('file');

        $path = $file->store('dokumen', 'public');

        $dokumen = Dokumen::create([
            'kategori_id' => $validated['kategori_id'],
            'nama_dokumen' => $validated['nama_dokumen'],
            'nomor_keterangan' => $validated['nomor_keterangan'] ?? null,
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'user_id' => Auth::id(),
        ]);

        AuditHelper::catat(
            'Upload Dokumen',
            'Dokumen',
            $dokumen->id,
            'Mengunggah dokumen ' . $dokumen->nama_dokumen
        );

        return redirect()
            ->route('dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
 * Form upload banyak dokumen.
 */
public function uploadBanyak(): View
{
    return view('dokumen.upload-banyak');
}


public function storeBanyak(Request $request): RedirectResponse
{
    $request->validate([
        'files' => [
            'required',
            'array',
            'min:1',
        ],
        'files.*' => [
            'required',
            'file',
            'mimes:pdf',
            'max:102400',
        ],
    ], [
        'files.required' => 'Pilih minimal satu file PDF.',
        'files.array' => 'Format file tidak valid.',
        'files.min' => 'Pilih minimal satu file PDF.',
        'files.*.required' => 'File PDF wajib diunggah.',
        'files.*.mimes' => 'Semua file harus berformat PDF.',
        'files.*.max' => 'Ukuran setiap file maksimal 100 MB.',
    ]);

    $jumlahBerhasil = 0;
    $jumlahGagal = 0;

    /*
    |--------------------------------------------------------------------------
    | Lokasi aplikasi OCR
    |--------------------------------------------------------------------------
    */

    $pdftoppm = 'C:\Users\Papad Cantik\AppData\Local\Microsoft\WinGet\Packages\oschwartz10612.Poppler_Microsoft.Winget.Source_8wekyb3d8bbwe\poppler-25.07.0\Library\bin\pdftoppm.exe';

    $tesseract = 'C:\Program Files\Tesseract-OCR\tesseract.exe';

    foreach ($request->file('files') as $file) {

        $ocrFolder = null;

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. Simpan PDF
            |--------------------------------------------------------------------------
            */

            $path = $file->store('dokumen', 'public');

            $pdfPath = storage_path('app/public/' . $path);

            /*
            |--------------------------------------------------------------------------
            | 2. Nama dokumen dari nama file
            |--------------------------------------------------------------------------
            */

            $namaFile = pathinfo(
                $file->getClientOriginalName(),
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
                'file' => $file->getClientOriginalName(),
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
                                    'file' => $file->getClientOriginalName(),
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
                            'file' => $file->getClientOriginalName(),
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
                                    'file' => $file->getClientOriginalName(),
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
                        'file' => $file->getClientOriginalName(),
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
            | 14. Simpan database
            |--------------------------------------------------------------------------
            */

            Dokumen::create([
                'kategori_id' => $kategoriId,
                'nama_dokumen' => $namaDokumen,
                'nomor_keterangan' => $nomorKeterangan,
                'tanggal_dokumen' => $tanggalDokumen,
                'deskripsi' => $deskripsi,
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'user_id' => Auth::id(),
            ]);

            $jumlahBerhasil++;

        } catch (\Throwable $e) {

            $jumlahGagal++;

            \Log::error(
                'Gagal memproses upload dokumen banyak',
                [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage(),
                ]
            );

        } finally {

            /*
            |--------------------------------------------------------------------------
            | Hapus folder sementara OCR
            |--------------------------------------------------------------------------
            */

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

    return redirect()
        ->route('dokumen.index')
        ->with(
            'success',
            "{$jumlahBerhasil} dokumen berhasil diproses."
            . ($jumlahGagal > 0
                ? " {$jumlahGagal} dokumen gagal diproses."
                : '')
        );
}

    /**
     * Menampilkan detail dokumen.
     */
    public function show(Dokumen $dokumen): View
    {
        $dokumen->load(['kategori', 'uploader']);

        return view('dokumen.show', compact('dokumen'));
    }

    /**
     * Form edit dokumen.
     */
    public function edit(Dokumen $dokumen): View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view(
            'dokumen.edit',
            compact('dokumen', 'kategoris')
        );
    }

    /**
     * Memperbarui dokumen.
     */
    public function update(
        Request $request,
        Dokumen $dokumen
    ): RedirectResponse {
        $validated = $this->validasi(
            $request,
            wajibFile: false
        );

        $dokumen->fill([
            'kategori_id' => $validated['kategori_id'],
            'nama_dokumen' => $validated['nama_dokumen'],
            'nomor_keterangan' => $validated['nomor_keterangan'] ?? null,
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        if ($request->hasFile('file')) {

            if (
                $dokumen->file_path &&
                Storage::disk('public')->exists($dokumen->file_path)
            ) {
                Storage::disk('public')->delete(
                    $dokumen->file_path
                );
            }

            $file = $request->file('file');

            $dokumen->file_path = $file->store(
                'dokumen',
                'public'
            );

            $dokumen->file_size = $file->getSize();
        }

        $dokumen->save();

        AuditHelper::catat(
            'Edit Dokumen',
            'Dokumen',
            $dokumen->id,
            'Mengubah dokumen ' . $dokumen->nama_dokumen
        );

        return redirect()
            ->route('dokumen.index')
            ->with(
                'success',
                'Dokumen berhasil diperbarui.'
            );
    }

    /**
     * Menghapus dokumen.
     */
    public function destroy(Dokumen $dokumen): RedirectResponse
    {
        if (
            $dokumen->file_path &&
            Storage::disk('public')->exists($dokumen->file_path)
        ) {
            Storage::disk('public')->delete(
                $dokumen->file_path
            );
        }

        AuditHelper::catat(
            'Hapus Dokumen',
            'Dokumen',
            $dokumen->id,
            'Menghapus dokumen ' . $dokumen->nama_dokumen
        );

        $dokumen->delete();

        return redirect()
            ->route('dokumen.index')
            ->with(
                'success',
                'Dokumen berhasil dihapus.'
            );
    }

    /**
     * Restore dokumen yang sudah dihapus.
     */
    public function restore($id): RedirectResponse
    {
        $dokumen = Dokumen::withTrashed()
            ->findOrFail($id);

        $dokumen->restore();

        AuditHelper::catat(
            'Restore Dokumen',
            'Dokumen',
            $dokumen->id,
            'Mengembalikan dokumen ' . $dokumen->nama_dokumen
        );

        return redirect()
            ->route('dokumen.index')
            ->with(
                'success',
                'Dokumen berhasil dipulihkan.'
            );
    }

    /**
     * Menghapus dokumen secara permanen.
     */
    public function forceDelete($id): RedirectResponse
    {
        $dokumen = Dokumen::withTrashed()
            ->findOrFail($id);

        if (
            $dokumen->file_path &&
            Storage::disk('public')->exists($dokumen->file_path)
        ) {
            Storage::disk('public')->delete(
                $dokumen->file_path
            );
        }

        $dokumen->forceDelete();

        AuditHelper::catat(
            'Hapus Permanen Dokumen',
            'Dokumen',
            $id,
            'Menghapus permanen dokumen ' . $dokumen->nama_dokumen
        );

        return redirect()
            ->route('dokumen.index')
            ->with(
                'success',
                'Dokumen berhasil dihapus permanen.'
            );
    }

    /**
 * Menghapus banyak dokumen ke Sampah.
 */
public function bulkDelete(Request $request): RedirectResponse
{
    $ids = $request->input('ids', []);

    if (empty($ids)) {
        return back()->with(
            'error',
            'Tidak ada dokumen yang dipilih.'
        );
    }

    $dokumens = Dokumen::whereIn('id', $ids)->get();

    foreach ($dokumens as $dokumen) {

        AuditHelper::catat(
            'Hapus Dokumen (Bulk)',
            'Dokumen',
            $dokumen->id,
            'Memindahkan dokumen ke Sampah: ' . $dokumen->nama_dokumen
        );

        // Soft delete → masuk Sampah Dokumen
        $dokumen->delete();
    }

    $jumlah = $dokumens->count();

    return redirect()
        ->route('dokumen.index')
        ->with(
            'success',
            "{$jumlah} dokumen berhasil dipindahkan ke Sampah Dokumen."
        );
}
    
    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with(
                'error',
                'Tidak ada dokumen yang dipilih.'
            );
        }

        $dokumens = Dokumen::withTrashed()
            ->whereIn('id', $ids)
            ->get();

        foreach ($dokumens as $dokumen) {

            if (
                $dokumen->file_path &&
                Storage::disk('public')->exists($dokumen->file_path)
            ) {
                Storage::disk('public')->delete(
                    $dokumen->file_path
                );
            }

            $dokumen->forceDelete();
        }

        $jumlah = $dokumens->count();

        AuditHelper::catat(
            'Hapus Permanen Dokumen (Bulk)',
            'Dokumen',
            null,
            "Menghapus permanen {$jumlah} dokumen sekaligus"
        );

        return redirect()
            ->route('dokumen.index')
            ->with(
                'success',
                "{$jumlah} dokumen berhasil dihapus permanen."
            );
    }

    
    /**
     * Download dokumen.
     */
    public function download(Dokumen $dokumen)
    {
        abort_unless(
            Storage::disk('public')->exists($dokumen->file_path),
            404,
            'File dokumen tidak ditemukan.'
        );

        AuditHelper::catat(
            'Download Dokumen',
            'Dokumen',
            $dokumen->id,
            'Mengunduh dokumen ' . $dokumen->nama_dokumen
        );

        return Storage::disk('public')->download(
            $dokumen->file_path,
            $dokumen->nama_dokumen . '.pdf'
        );
    }

    /**
     * Menampilkan halaman pilihan ekspor dokumen.
     * Dapat digunakan oleh Admin dan User.
     */
    public function exportForm(): View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view(
            'dokumen.export',
            compact('kategoris')
        );
    }

    /**
     * Ekspor dokumen menjadi file ZIP.
     * Dapat digunakan oleh Admin dan User.
     */
    public function export(Request $request)
    {
        $request->validate([
            'kategori_id' => [
                'nullable',
                'exists:kategoris,id'
            ],
            'tahun' => [
                'nullable',
                'integer'
            ],
            'bulan' => [
                'nullable',
                'integer',
                'between:1,12'
            ],
            'tanggal' => [
                'nullable',
                'string'
            ],
        ]);

        $query = Dokumen::with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where(
                'kategori_id',
                $request->kategori_id
            );
        }

        if ($request->filled('tahun')) {
            $query->whereYear(
                'tanggal_dokumen',
                $request->tahun
            );
        }

        if ($request->filled('bulan')) {
            $query->whereMonth(
                'tanggal_dokumen',
                $request->bulan
            );
        }

        if ($request->filled('tanggal')) {
            $tanggalParsed = \Carbon\Carbon::createFromFormat(
                'd/m/Y',
                $request->tanggal
            );

            $query->whereDate(
                'tanggal_dokumen',
                $tanggalParsed->format('Y-m-d')
            );
        }

        $dokumens = $query->get();

        if ($dokumens->isEmpty()) {
            return back()->with(
                'error',
                'Tidak ada dokumen yang dapat diekspor.'
            );
        }

        $zip = new \ZipArchive();

        $namaKategori = 'seluruh-dokumen';

        if ($request->filled('kategori_id')) {

            $kategori = Kategori::find(
                $request->kategori_id
            );

            if ($kategori) {
                $namaKategori = \Illuminate\Support\Str::slug(
                    $kategori->nama
                );
            }
        }

        $namaFile =
            'ekspor-' .
            $namaKategori .
            '-' .
            now()->format('Y-m-d-His') .
            '.zip';

        $pathZip = storage_path(
            'app/temp/' . $namaFile
        );

        if (! is_dir(dirname($pathZip))) {
            mkdir(
                dirname($pathZip),
                0755,
                true
            );
        }

        if (
            $zip->open(
                $pathZip,
                \ZipArchive::CREATE |
                \ZipArchive::OVERWRITE
            ) !== true
        ) {
            return back()->with(
                'error',
                'Gagal membuat file ZIP.'
            );
        }

        foreach ($dokumens as $dokumen) {

            if (! $dokumen->file_path) {
                continue;
            }

            if (
                ! Storage::disk('public')->exists(
                    $dokumen->file_path
                )
            ) {
                continue;
            }

            $filePath = Storage::disk('public')->path(
                $dokumen->file_path
            );

            $namaFolder = $dokumen->kategori
                ? $dokumen->kategori->nama
                : 'Lainnya';

            $namaFolder = \Illuminate\Support\Str::slug(
                $namaFolder
            );

            $namaFilePdf =
                $dokumen->nama_dokumen . '.pdf';

            $zip->addFile(
                $filePath,
                $namaFolder . '/' . $namaFilePdf
            );
        }

        $zip->close();

        if (! file_exists($pathZip)) {
            return back()->with(
                'error',
                'File ZIP gagal dibuat.'
            );
        }

        AuditHelper::catat(
            'Ekspor Dokumen',
            'Dokumen',
            null,
            'Mengekspor ' .
            $dokumens->count() .
            ' dokumen ke dalam ZIP'
        );

        return response()
            ->download(
                $pathZip,
                $namaFile,
                [
                    'Content-Type' => 'application/zip',
                ]
            )
            ->deleteFileAfterSend(true);
    }

    /**
     * Preview dokumen.
     */
    public function preview(Dokumen $dokumen): View
    {
        $dokumen->load(['kategori', 'uploader']);

        return view(
            'dokumen.show',
            compact('dokumen')
        );
    }

    /**
     * Menampilkan file PDF di browser.
     */
    public function file(Dokumen $dokumen)
    {
        abort_unless(
            Storage::disk('public')->exists(
                $dokumen->file_path
            ),
            404,
            'File dokumen tidak ditemukan.'
        );

        return response()->file(
            Storage::disk('public')->path(
                $dokumen->file_path
            ),
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }

    /**
     * Validasi dokumen.
     */
    private function validasi(
        Request $request,
        bool $wajibFile = true
    ): array {
        return $request->validate(
            [
                'kategori_id' => [
                    'required',
                    'exists:kategoris,id'
                ],
                'nama_dokumen' => [
                    'required',
                    'string',
                    'max:255'
                ],
                'nomor_keterangan' => [
                    'nullable',
                    'string',
                    'max:255'
                ],
                'tanggal_dokumen' => [
                    'required',
                    'date'
                ],
                'deskripsi' => [
                    'nullable',
                    'string',
                    'max:1000'
                ],
                'file' => [
                    $wajibFile
                        ? 'required'
                        : 'nullable',
                    'file',
                    'mimes:pdf',
                    'max:102400'
                ],
            ],
            [
                'kategori_id.required' =>
                    'Kategori wajib dipilih.',

                'nama_dokumen.required' =>
                    'Nama dokumen wajib diisi.',

                'tanggal_dokumen.required' =>
                    'Tanggal dokumen wajib diisi.',

                'file.required' =>
                    'File PDF wajib diunggah.',

                'file.mimes' =>
                    'File harus berformat PDF.',

                'file.max' =>
                    'Ukuran file maksimal 100 MB.',
            ]
        );
    }
}