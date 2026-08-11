<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'profile_photo.required' =>
                'Silakan pilih foto terlebih dahulu.',

            'profile_photo.image' =>
                'File yang dipilih harus berupa gambar.',

            'profile_photo.mimes' =>
                'Foto harus berformat JPG, JPEG, atau PNG.',

            'profile_photo.max' =>
                'Ukuran foto maksimal 2 MB.',
        ]);

        $user = auth()->user();

        // Hapus foto lama jika ada
        if (
            $user->profile_photo_path &&
            Storage::disk('public')->exists(
                $user->profile_photo_path
            )
        ) {
            Storage::disk('public')->delete(
                $user->profile_photo_path
            );
        }

        // Simpan foto baru
        $path = $request
            ->file('profile_photo')
            ->store('profile-photos', 'public');

        // Simpan lokasi foto ke database
        $user->profile_photo_path = $path;
        $user->save();

        return back()->with(
            'success',
            'Foto profil berhasil diperbarui.'
        );
    }
}