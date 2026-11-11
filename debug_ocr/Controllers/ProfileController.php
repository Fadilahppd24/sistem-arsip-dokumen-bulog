<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Upload / ganti foto profil.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'profile_photo.required' => 'Silakan pilih foto profil.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'profile_photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Hapus foto lama
        |--------------------------------------------------------------------------
        */
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan foto baru
        |--------------------------------------------------------------------------
        */
        $path = $request->file('profile_photo')->store(
            'profile-photos',
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan path ke database
        |--------------------------------------------------------------------------
        */
        $user->profile_photo_path = $path;
        $user->save();

        return back()->with(
            'success',
            'Foto profil berhasil diperbarui.'
        );
    }

    /**
     * Hapus foto profil.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Hapus file foto dari storage
        |--------------------------------------------------------------------------
        */
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete(
                $user->profile_photo_path
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Kosongkan path di database
        |--------------------------------------------------------------------------
        */
        $user->profile_photo_path = null;
        $user->save();

        return back()->with(
            'success',
            'Foto profil berhasil dihapus.'
        );
    }
}