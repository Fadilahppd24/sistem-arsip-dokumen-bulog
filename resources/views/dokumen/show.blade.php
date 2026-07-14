@extends('layouts.app')

@section('title', $dokumen->nama_dokumen)

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}" class="text-decoration-none">Dokumen</a></li>
        <li class="breadcrumb-item active text-truncate" style="max-width:200px;">{{ $dokumen->nama_dokumen }}</li>
    </ol>
</nav>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-panel p-0 overflow-hidden">
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom bg-white">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
                    <span class="fw-semibold text-truncate">{{ $dokumen->nama_dokumen }}</span>
                </div>
                <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-sm btn-bulog">
                    <i class="bi bi-download"></i> Unduh
                </a>
            </div>
            <div style="height: 640px; background: #525659;">
                <iframe src="{{ asset('storage/'.$dokumen->file_path) }}" width="100%" height="100%" style="border:none;"></iframe>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-panel p-4">
            <h6 class="fw-bold mb-3">Informasi Dokumen</h6>
            <dl class="row small mb-0">
                <dt class="col-5 text-muted fw-normal">Kategori</dt>
                <dd class="col-7">
                    <span class="badge bg-light text-dark border badge-kategori">{{ $dokumen->kategori->nama }}</span>
                </dd>

                <dt class="col-5 text-muted fw-normal">Nomor / Ket.</dt>
                <dd class="col-7">{{ $dokumen->nomor_keterangan ?? '-' }}</dd>

                <dt class="col-5 text-muted fw-normal">Tanggal</dt>
                <dd class="col-7">{{ $dokumen->tanggal_dokumen->format('d M Y') }}</dd>

                <dt class="col-5 text-muted fw-normal">Ukuran File</dt>
                <dd class="col-7">{{ $dokumen->ukuran_format }}</dd>

                <dt class="col-5 text-muted fw-normal">Diupload Oleh</dt>
                <dd class="col-7">{{ $dokumen->uploader->name }}</dd>

                <dt class="col-5 text-muted fw-normal">Diunggah Pada</dt>
                <dd class="col-7">{{ $dokumen->created_at->format('d M Y, H:i') }}</dd>

                @if ($dokumen->deskripsi)
                    <dt class="col-12 text-muted fw-normal mt-2">Deskripsi</dt>
                    <dd class="col-12">{{ $dokumen->deskripsi }}</dd>
                @endif
            </dl>

            @if (auth()->user()->isAdmin())
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('dokumen.edit', $dokumen) }}" class="btn btn-light"><i class="bi bi-pencil"></i> Edit Dokumen</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
