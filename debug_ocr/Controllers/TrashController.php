<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $pilihan = [10, 20, 50, 100, 200, 500, 1000];

        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($perPage, $pilihan, true)) {
            $perPage = 10;
        }

        $dokumens = Dokumen::onlyTrashed()
            ->with(['kategori', 'uploader'])
            ->latest('deleted_at')
            ->paginate($perPage)
            ->withQueryString();

        return view('trash.index', compact('dokumens', 'perPage'));
    }
}