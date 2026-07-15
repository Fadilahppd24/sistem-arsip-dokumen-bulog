<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;

class TrashController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::onlyTrashed()
            ->with(['kategori', 'uploader'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('trash.index', compact('dokumens'));
    }
}