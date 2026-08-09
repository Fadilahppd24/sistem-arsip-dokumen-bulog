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
     * Daftar dokumen (dipakai Admin & User) dengan filter kategori, tahun, bulan, pencarian.
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

        $dokumens = $query->latest('tanggal_dokumen')->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama')->get();

        $view = Auth::user()->isAdmin() ? 'dokumen.index' : 'dokumen.index-user';

        return view($view, compact('dokumens', 'kategoris'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('dokumen.create', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validasi($request);

        $cekDokumen = Dokumen::where('nama_dokumen', $validated['nama_dokumen'])
            ->where('nomor_keterangan', $validated['nomor_keterangan'] ?? null)
            ->exists();

        if ($cekDokumen) {
            return back()
                ->withInput()
                ->with('error', 'Dokumen dengan nama dan nomor yang sama sudah ada.');
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
            'Mengunggah dokumen '.$dokumen->nama_dokumen
        );

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Dokumen $dokumen): View
    {
        $dokumen->load(['kategori', 'uploader']);

        return view('dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen): View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('dokumen.edit', compact('dokumen', 'kategoris'));
    }

    public function update(Request $request, Dokumen $dokumen): RedirectResponse
    {
        $validated = $this->validasi($request, wajibFile: false);

        $dokumen->fill([
            'kategori_id' => $validated['kategori_id'],
            'nama_dokumen' => $validated['nama_dokumen'],
            'nomor_keterangan' => $validated['nomor_keterangan'] ?? null,
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        if ($request->hasFile('file')) {
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            $file = $request->file('file');
            $dokumen->file_path = $file->store('dokumen', 'public');
            $dokumen->file_size = $file->getSize();
        }

        $dokumen->save();

        AuditHelper::catat(
            'Edit Dokumen',
            'Dokumen',
            $dokumen->id,
            'Mengubah dokumen '.$dokumen->nama_dokumen
        );

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen): RedirectResponse
    {
        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        AuditHelper::catat(
            'Hapus Dokumen',
            'Dokumen',
            $dokumen->id,
            'Menghapus dokumen '.$dokumen->nama_dokumen
        );

        $dokumen->delete();

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function restore($id): RedirectResponse
    {
        $dokumen = Dokumen::withTrashed()->findOrFail($id);

        $dokumen->restore();

        AuditHelper::catat(
            'Restore Dokumen',
            'Dokumen',
            $dokumen->id,
            'Mengembalikan dokumen '.$dokumen->nama_dokumen
        );

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil dipulihkan.');
    }

    public function forceDelete($id): RedirectResponse
    {
        $dokumen = Dokumen::withTrashed()->findOrFail($id);

        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->forceDelete();

        AuditHelper::catat(
            'Hapus Permanen Dokumen',
            'Dokumen',
            $id,
            'Menghapus permanen dokumen '.$dokumen->nama_dokumen
        );

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus permanen.');
    }

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
            'Mengunduh dokumen '.$dokumen->nama_dokumen
        );

        return Storage::disk('public')->download(
            $dokumen->file_path,
            $dokumen->nama_dokumen.'.pdf'
        );
    }

/**
 * Menampilkan halaman pilihan ekspor dokumen.
 * Dapat digunakan oleh Admin dan User.
 */
public function exportForm(): View
{
    $kategoris = Kategori::orderBy('nama')->get();

    return view('dokumen.export', compact('kategoris'));
}

    /**
     * Ekspor dokumen menjadi file ZIP.
     * Dapat digunakan oleh Admin dan User.
     */
    public function export(Request $request)
    {
        $request->validate([
            'kategori_id' => ['nullable', 'exists:kategoris,id'],
        ]);

        $query = Dokumen::with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $dokumens = $query->get();

        if ($dokumens->isEmpty()) {
            return back()->with('error', 'Tidak ada dokumen yang dapat diekspor.');
        }

        $zip = new \ZipArchive();

        $namaKategori = 'seluruh-dokumen';

        if ($request->filled('kategori_id')) {
            $kategori = Kategori::find($request->kategori_id);

            if ($kategori) {
                $namaKategori = \Illuminate\Support\Str::slug($kategori->nama);
            }
        }

        $namaFile = 'ekspor-'.$namaKategori.'-'.now()->format('Y-m-d-His').'.zip';

        $pathZip = storage_path('app/temp/'.$namaFile);

        if (! is_dir(dirname($pathZip))) {
            mkdir(dirname($pathZip), 0755, true);
        }

        if ($zip->open($pathZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        foreach ($dokumens as $dokumen) {

            if (! $dokumen->file_path) {
                continue;
            }

            if (! Storage::disk('public')->exists($dokumen->file_path)) {
                continue;
            }

            $filePath = Storage::disk('public')->path($dokumen->file_path);

            $namaFolder = $dokumen->kategori
                ? $dokumen->kategori->nama
                : 'Lainnya';

            $namaFolder = \Illuminate\Support\Str::slug($namaFolder);

            $namaFilePdf = $dokumen->nama_dokumen.'.pdf';

            $zip->addFile(
                $filePath,
                $namaFolder.'/'.$namaFilePdf
            );
        }

        $zip->close();

        if (! file_exists($pathZip)) {
            return back()->with('error', 'File ZIP gagal dibuat.');
        }

        AuditHelper::catat(
            'Ekspor Dokumen',
            'Dokumen',
            null,
            'Mengekspor '.$dokumens->count().' dokumen ke dalam ZIP'
        );

        return response()->download(
            $pathZip,
            $namaFile,
            [
                'Content-Type' => 'application/zip',
            ]
        )->deleteFileAfterSend(true);
    }

    public function preview(Dokumen $dokumen): View
    {
        $dokumen->load(['kategori', 'uploader']);

        return view('dokumen.show', compact('dokumen'));
    }

    public function file(Dokumen $dokumen)
    {
        abort_unless(
            Storage::disk('public')->exists($dokumen->file_path),
            404,
            'File dokumen tidak ditemukan.'
        );

        return response()->file(
            Storage::disk('public')->path($dokumen->file_path),
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }

    private function validasi(Request $request, bool $wajibFile = true): array
    {
        return $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'nomor_keterangan' => ['nullable', 'string', 'max:255'],
            'tanggal_dokumen' => ['required', 'date'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'file' => [$wajibFile ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:102400'],
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'nama_dokumen.required' => 'Nama dokumen wajib diisi.',
            'tanggal_dokumen.required' => 'Tanggal dokumen wajib diisi.',
            'file.required' => 'File PDF wajib diunggah.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 100 MB.',
        ]);
    }
}