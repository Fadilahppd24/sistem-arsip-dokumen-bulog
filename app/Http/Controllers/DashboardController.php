<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::withCount('dokumens')->get();

      $warnaIkon = [
    'primary'   => 'kategori-primary',
    'warning'   => 'kategori-warning',
    'info'      => 'kategori-info',
    'secondary' => 'kategori-secondary',
    'success'   => 'kategori-success',
    'danger'    => 'kategori-danger',
    'purple'    => 'kategori-purple',
    'pink'      => 'kategori-pink',
    'teal'      => 'kategori-teal',
    'orange'    => 'kategori-orange',
    'indigo'    => 'kategori-indigo',
    'cyan'      => 'kategori-cyan',
];

        $totalDokumen = Dokumen::count();

        $dokumenTerbaru = Dokumen::with(['kategori', 'uploader'])
            ->latest()
            ->take(5)
            ->get();

        $statistikBulanIni = Dokumen::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $diskTotal = disk_total_space(base_path());
        $diskFree  = disk_free_space(base_path());
        $diskUsed  = $diskTotal - $diskFree;

        $storageTotalGB = round($diskTotal / 1073741824, 1);
        $storageUsedGB  = round($diskUsed / 1073741824, 1);
        $storagePercent = $diskTotal > 0 ? round(($diskUsed / $diskTotal) * 100, 1) : 0;

        $storageStatus = match(true) {
            $storagePercent < 80 => 'Aman',
            $storagePercent < 95 => 'Perhatian',
            default => 'Penuh',
        };

        $view = Auth::user()->isAdmin() ? 'dashboard.admin' : 'dashboard.user';

        return view($view, compact(
    'kategoris',
    'totalDokumen',
    'dokumenTerbaru',
    'statistikBulanIni',
    'storageTotalGB',
    'storageUsedGB',
    'storagePercent',
    'storageStatus',
    'warnaIkon'
));