<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        $perPage = (int) request('perPage', 10);

if (!in_array($perPage, [10, 20, 50, 100, 500, 1000])) {
    $perPage = 10;
}

$logs = AuditLog::with('user')
    ->latest()
    ->paginate($perPage)
    ->withQueryString();

        return view('audit-log.index', compact('logs'));
    }
}