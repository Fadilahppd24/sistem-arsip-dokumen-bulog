<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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

        $file = $request->file('file');
        $path = $file->store('dokumen', 'public');

        Dokumen::create([
            'kategori_id' => $validated['kategori_id'],
            'nama_dokumen' => $validated['nama_dokumen'],
            'nomor_keterangan' => $validated['nomor_keterangan'] ?? null,
            'tanggal_dokumen' => $validated['tanggal_dokumen'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'user_id' => Auth::id(),
        ]);

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

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen): RedirectResponse
    {
        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(Dokumen $dokumen)
    {
        abort_unless(Storage::disk('public')->exists($dokumen->file_path), 404, 'File dokumen tidak ditemukan.');

        return Storage::disk('public')->download(
            $dokumen->file_path,
            $dokumen->nama_dokumen.'.pdf'
        );
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
            'file' => [$wajibFile ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:20480'],
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'nama_dokumen.required' => 'Nama dokumen wajib diisi.',
            'tanggal_dokumen.required' => 'Tanggal dokumen wajib diisi.',
            'file.required' => 'File PDF wajib diunggah.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 20 MB.',
        ]);
    }
}
