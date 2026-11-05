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



public function uploadBanyakProgress(int $batch)
{
    $uploadBatch = \App\Models\UploadBatch::findOrFail($batch);

    // Pastikan progres hanya bisa dibaca pemilik batch.
    abort_unless(
        (int) $uploadBatch->user_id === (int) Auth::id(),
        403
    );

    $items = $uploadBatch->items()
        ->orderBy('id')
        ->get([
            'id',
            'original_filename',
            'status',
            'message',
        ]);

    return response()->json([
        'batch_id' => $uploadBatch->id,
        'status' => $uploadBatch->status,
        'total_files' => $uploadBatch->total_files,
        'processed_files' => $uploadBatch->processed_files,
        'success_files' => $uploadBatch->success_files,
        'duplicate_files' => $uploadBatch->duplicate_files,
        'failed_files' => $uploadBatch->failed_files,
        'progress_percent' => $uploadBatch->progress_percent,
        'items' => $items,
    ]);
}





    public function storeBanyak(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'min:1'],
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
    
        $files = $request->file('files');
    
        $batch = \App\Models\UploadBatch::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'total_files' => count($files),
            'status' => 'pending',
        ]);
    
        foreach ($files as $file) {
            $path = null;
            $item = null;
    
            try {
                // Simpan PDF sebelum dikirim ke Queue.
                $path = $file->store('dokumen', 'public');
    
                if (!$path) {
                    throw new \RuntimeException('Gagal menyimpan PDF.');
                }
    
                // Buat satu catatan untuk setiap PDF.
                $item = \App\Models\UploadBatchItem::create([
                    'upload_batch_id' => $batch->id,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'status' => 'pending',
                ]);
    
                // Kirim PDF ke antrean OCR.
                \App\Jobs\ProsesOcrDokumenJob::dispatch($item->id);
    
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error(
                    'Gagal menambahkan PDF ke antrean OCR',
                    [
                        'batch_id' => $batch->id,
                        'filename' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                    ]
                );
    
                // Hapus PDF hanya jika belum ada catatan item Queue.
    // Jika item sudah dibuat, file dipertahankan agar tidak
    // terhapus ketika pekerjaan mungkin sudah masuk antrean.
    if ($path && $item === null) {
        \Illuminate\Support\Facades\Storage::disk('public')
            ->delete($path);
    }
    
                // Jangan membuat dua catatan untuk PDF yang sama.
                if ($item !== null) {
                    $item->update([
                        'status' => 'gagal',
                        'message' => 'Gagal menyiapkan PDF untuk OCR.',
                        'file_path' => null,
                    ]);
                } else {
                    \App\Models\UploadBatchItem::create([
                        'upload_batch_id' => $batch->id,
                        'original_filename' => $file->getClientOriginalName(),
                        'status' => 'gagal',
                        'message' => 'Gagal menyiapkan PDF untuk OCR.',
                    ]);
                }
    
                $batch->increment('processed_files');
                $batch->increment('failed_files');
            }
        }
    
        // Perbarui status tanpa menimpa batch yang sudah selesai.
    \App\Models\UploadBatch::query()
        ->whereKey($batch->id)
        ->where('status', 'pending')
        ->update(['status' => 'processing']);
    
    $batch->refresh();
    
    if ($batch->processed_files >= $batch->total_files) {
        \App\Models\UploadBatch::query()
            ->whereKey($batch->id)
            ->update(['status' => 'completed']);
    }
    
        // Kirim ID batch untuk dipantau oleh popup BULOG.
        return response()->json([
            'message' => 'File PDF berhasil diterima untuk diproses.',
            'batch_id' => $batch->id,
            'progress_url' => route(
                'dokumen.upload-banyak.progress',
                ['batch' => $batch->id]
            ),
        ], 202);
    }

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

        // Soft delete â†’ masuk Sampah Dokumen
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
