<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori aktif dan kategori terhapus.
     */
    public function index(): View
    {
        $kategoris = Kategori::withCount('dokumens')
            ->orderBy('nama')
            ->get();

        $kategoriTerhapus = Kategori::onlyTrashed()
            ->withCount('dokumens')
            ->orderBy('nama')
            ->get();

        return view('kategori.index', compact(
            'kategoris',
            'kategoriTerhapus'
        ));
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategoris,nama'],
            'icon' => ['nullable', 'string', 'max:100'],
            'warna' => ['nullable', 'string', 'max:50'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Mengubah kategori.
     */
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:kategoris,nama,' . $kategori->id,
            ],
            'icon' => ['nullable', 'string', 'max:100'],
            'warna' => ['nullable', 'string', 'max:50'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menonaktifkan kategori dengan Soft Delete.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        $jumlahDokumen = $kategori->dokumens()->count();

        $kategori->delete();

        if ($jumlahDokumen > 0) {
            return redirect()
                ->route('kategori.index')
                ->with(
                    'success',
                    'Kategori berhasil dinonaktifkan. ' .
                    $jumlahDokumen .
                    ' dokumen tetap aman dan masih menggunakan kategori tersebut.'
                );
        }

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dinonaktifkan.');
    }

    /**
     * Mengembalikan kategori yang sudah dinonaktifkan.
     */
    public function restore($id): RedirectResponse
    {
        $kategori = Kategori::onlyTrashed()->findOrFail($id);

        $kategori->restore();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dipulihkan.');
    }

    /**
     * Menghapus kategori secara permanen.
     */
    public function forceDelete($id): RedirectResponse
    {
        $kategori = Kategori::onlyTrashed()->findOrFail($id);

        if ($kategori->dokumens()->count() > 0) {
            return redirect()
                ->route('kategori.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus permanen karena masih memiliki dokumen.'
                );
        }

        $kategori->forceDelete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus permanen.');
    }
}