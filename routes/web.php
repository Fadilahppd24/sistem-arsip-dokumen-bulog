<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');

// ==== Guest (belum login) ====
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// ==== Wajib login (Admin & User) ====
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dokumen: index/search bisa diakses Admin & User
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');

    // ==== Khusus Admin (rute literal /dokumen/create didaftarkan SEBELUM
    // rute berparameter /dokumen/{dokumen} agar tidak bentrok) ====
    Route::middleware('admin')->group(function () {
        Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
        Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
        Route::get('/dokumen/{dokumen}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
        Route::put('/dokumen/{dokumen}', [DokumenController::class, 'update'])->name('dokumen.update');
        Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');


        Route::get('/backup', function () {
    return view('backup.index');
})->name('backup.index');


Route::get('/trash', [TrashController::class, 'index'])
    ->name('trash.index');

Route::patch('/dokumen/{dokumen}/restore', [DokumenController::class, 'restore'])
    ->name('dokumen.restore');

Route::delete('/dokumen/{dokumen}/force-delete', [DokumenController::class, 'forceDelete'])
    ->name('dokumen.forceDelete');

        Route::resource('users', UserController::class)->except(['show']);

        Route::get('/backup/database', [BackupController::class, 'database'])
    ->name('backup.database');
    });

    Route::get('/audit-log', [AuditLogController::class, 'index'])
    ->name('audit-log.index');

    // Dokumen: preview/show/download bisa diakses Admin & User
Route::get('/dokumen/{dokumen}/preview', [DokumenController::class, 'preview'])
    ->name('dokumen.preview');

Route::get('/dokumen/{dokumen}/file', [DokumenController::class, 'file'])
    ->name('dokumen.file');

Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])
    ->name('dokumen.show');

Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])
    ->name('dokumen.download');
});
