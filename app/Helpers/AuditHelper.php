<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    /**
     * Mencatat aktivitas pengguna ke tabel audit_logs.
     */
    public static function catat(
        string $aktivitas,
        string $modul,
        ?int $referensiId = null,
        ?string $keterangan = null
    ): void {

        if (!Auth::check()) {
            return;
        }

        AuditLog::create([
            'user_id'       => Auth::id(),
            'aktivitas'     => $aktivitas,
            'modul'         => $modul,
            'referensi_id'  => $referensiId,
            'keterangan'    => $keterangan,
        ]);
    }
}