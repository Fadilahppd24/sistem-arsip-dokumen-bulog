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

        $totalDokumen = Dokumen::count();

        $dokumenTerbaru = Dokumen::with(['kategori', 'uploader'])
            ->latest()
            ->take(5)
            ->get();

        $statistikBulanIni = Dokumen::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $view = Auth::user()->isAdmin() ? 'dashboard.admin' : 'dashboard.user';

        return view($view, compact('kategoris', 'totalDokumen', 'dokumenTerbaru', 'statistikBulanIni'));
    }
}
