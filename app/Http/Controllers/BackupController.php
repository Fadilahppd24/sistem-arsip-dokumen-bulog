<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function database()
    {
        $filename = 'backup_sistem_arsip_' . date('Y-m-d_H-i-s') . '.sql';

        $path = storage_path('app/' . $filename);

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$path}";

        system($command);
        AuditHelper::catat(
    'Backup Database',
    'Sistem',
    null,
    'Melakukan backup database'
);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}