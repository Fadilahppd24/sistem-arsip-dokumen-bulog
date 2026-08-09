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
     * Warna dipilih otomatis dari 12 warna yang tersedia.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:kategoris,nama',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ]);

        // 12 warna kategori
        $warnaTersedia = [
            'primary',
            'warning',
            'info',
            'secondary',
            'success',
            'danger',
            'purple',
            'pink',
            'teal',
            'orange',
            'indigo',
            'cyan',
        ];

        // Ambil warna yang sedang dipakai
        // hanya dari kategori aktif
        $warnaTerpakai = Kategori::whereNull('deleted_at')
            ->pluck('warna')
            ->filter()
            ->unique()
            ->toArray();

        // Cari warna pertama yang belum dipakai
        $warna = collect($warnaTersedia)
            ->first(function ($item) use ($warnaTerpakai) {
                return !in_array($item, $warnaTerpakai);
            });

        // Kalau semua 12 warna sudah dipakai
        if (!$warna) {
            return redirect()
                ->route('kategori.index')
                ->with(
                    'error',
                    'Semua 12 warna sudah digunakan. Silakan ubah warna kategori yang sudah ada terlebih dahulu.'
                );
        }

        // Masukkan warna otomatis
        $validated['warna'] = $warna;

        // Simpan kategori
        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan dengan warna ' . ucfirst($warna) . '.'
            );
    }

    /**
     * Mengubah kategori.
     */
    public function update(
        Request $request,
        Kategori $kategori
    ): RedirectResponse {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:kategoris,nama,' . $kategori->id,
            ],
            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],
            'warna' => [
                'required',
                'in:primary,warning,info,secondary,success,danger,purple,pink,teal,orange,indigo,cyan',
            ],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'warna.in' => 'Warna kategori tidak valid.',
        ]);

        // Cek apakah warna sudah dipakai kategori lain
        $warnaDipakai = Kategori::where('id', '!=', $kategori->id)
            ->where('warna', $validated['warna'])
            ->exists();

        if ($warnaDipakai) {
            return redirect()
                ->route('kategori.index')
                ->with(
                    'error',
                    'Warna tersebut sudah digunakan oleh kategori lain. Silakan pilih warna lain.'
                );
        }

        // Update kategori
        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil diperbarui.'
            );
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
            ->with(
                'success',
                'Kategori berhasil dinonaktifkan.'
            );
    }

    /**
     * Mengembalikan kategori yang sudah dinonaktifkan.
     */
    public function restore($id): RedirectResponse
    {
        $kategori = Kategori::onlyTrashed()
            ->findOrFail($id);

        $kategori->restore();

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil dipulihkan.'
            );
    }

    /**
     * Menghapus kategori secara permanen.
     */
    public function forceDelete($id): RedirectResponse
    {
        $kategori = Kategori::onlyTrashed()
            ->findOrFail($id);

        // Tidak boleh hapus permanen kalau masih punya dokumen
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
            ->with(
                'success',
                'Kategori berhasil dihapus permanen.'
            );
    }
}