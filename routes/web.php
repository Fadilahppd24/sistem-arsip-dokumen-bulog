<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');


/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
| Hanya bisa diakses ketika belum login.
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');

});


/*
|--------------------------------------------------------------------------
| Wajib Login
|--------------------------------------------------------------------------
| Semua route di dalam group ini hanya bisa diakses
| oleh pengguna yang sudah login.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    | Bisa digunakan Admin maupun User.
    |--------------------------------------------------------------------------
    */

    // Ganti / upload foto profil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo.update');

    // Hapus foto profil
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
        ->name('profile.photo.delete');


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Dokumen
    |--------------------------------------------------------------------------
    | Index, search, export, preview, file, show, dan download
    | dapat diakses Admin maupun User.
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumen', [DokumenController::class, 'index'])
        ->name('dokumen.index');


    /*
    |--------------------------------------------------------------------------
    | Export Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumen/export', [DokumenController::class, 'exportForm'])
        ->name('dokumen.export');

    Route::post('/dokumen/export', [DokumenController::class, 'export'])
        ->name('dokumen.export.process');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dokumen - Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/dokumen/create', [DokumenController::class, 'create'])
            ->name('dokumen.create');

        Route::post('/dokumen', [DokumenController::class, 'store'])
            ->name('dokumen.store');

        Route::get('/dokumen/{dokumen}/edit', [DokumenController::class, 'edit'])
            ->name('dokumen.edit');

        Route::put('/dokumen/{dokumen}', [DokumenController::class, 'update'])
            ->name('dokumen.update');

        Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])
            ->name('dokumen.destroy');


        /*
        |--------------------------------------------------------------------------
        | Kelola Kategori
        |--------------------------------------------------------------------------
        */

        Route::get('/kategori', [KategoriController::class, 'index'])
            ->name('kategori.index');

        Route::post('/kategori', [KategoriController::class, 'store'])
            ->name('kategori.store');

        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])
            ->name('kategori.update');

        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])
            ->name('kategori.destroy');

        Route::patch('/kategori/{id}/restore', [KategoriController::class, 'restore'])
            ->name('kategori.restore');

        Route::delete('/kategori/{id}/force-delete', [KategoriController::class, 'forceDelete'])
            ->name('kategori.forceDelete');


        /*
        |--------------------------------------------------------------------------
        | Backup
        |--------------------------------------------------------------------------
        */

        Route::get('/backup', function () {
            return view('backup.index');
        })->name('backup.index');

        Route::get('/backup/database', [BackupController::class, 'database'])
            ->name('backup.database');


        /*
        |--------------------------------------------------------------------------
        | Sampah Dokumen
        |--------------------------------------------------------------------------
        */

        Route::get('/trash', [TrashController::class, 'index'])
            ->name('trash.index');

        Route::patch('/dokumen/{dokumen}/restore', [DokumenController::class, 'restore'])
            ->name('dokumen.restore');

        Route::delete('/dokumen/{dokumen}/force-delete', [DokumenController::class, 'forceDelete'])
            ->name('dokumen.forceDelete');


        /*
        |--------------------------------------------------------------------------
        | Kelola Pengguna
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class)
            ->except(['show']);

    });


    /*
    |--------------------------------------------------------------------------
    | Riwayat Aktivitas
    |--------------------------------------------------------------------------
    */

    Route::get('/audit-log', [AuditLogController::class, 'index'])
        ->name('audit-log.index');


    /*
    |--------------------------------------------------------------------------
    | Dokumen - Detail / Preview / File / Download
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumen/{dokumen}/preview', [DokumenController::class, 'preview'])
        ->name('dokumen.preview');

    Route::get('/dokumen/{dokumen}/file', [DokumenController::class, 'file'])
        ->name('dokumen.file');

    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])
        ->name('dokumen.show');

    Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])
        ->name('dokumen.download');

});