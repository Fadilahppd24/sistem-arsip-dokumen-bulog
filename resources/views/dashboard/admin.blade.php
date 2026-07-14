@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Beranda</h3>
    <p class="text-muted mb-0">Kelola dan akses dokumen dengan lebih mudah dan cepat.</p>
</div>

<div class="row g-3 mb-4">
    @php
        $warnaIkon = ['primary' => 'bg-bulog-navy', 'warning' => 'bg-bulog-yellow', 'info' => 'bg-info', 'secondary' => 'bg-secondary'];
    @endphp
    @foreach ($kategoris as $kategori)
        <div class="col-6 col-lg-3">
            <a href="{{ route('dokumen.index', ['kategori_id' => $kategori->id]) }}" class="text-decoration-none">
                <div class="stat-card d-flex align-items-start justify-content-between h-100">
                    <div class="d-flex gap-3">
                        <div class="stat-icon {{ $warnaIkon[$kategori->warna] ?? 'bg-bulog-navy' }}">
                            <i class="bi {{ $kategori->icon ?? 'bi-folder-fill' }}"></i>
                        </div>
                        <div>
                            <div class="text-muted small">{{ $kategori->nama }}</div>
                            <div class="fs-4 fw-bold text-dark">{{ $kategori->dokumens_count }}</div>
                            <div class="text-muted small">Dokumen</div>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-panel p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Dokumen Terbaru</h6>
                <a href="{{ route('dokumen.index') }}" class="small text-decoration-none">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-muted small">
                            <th>Nama Dokumen</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Diupload Oleh</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumenTerbaru as $dokumen)
                            <tr>
                                <td class="fw-semibold">{{ $dokumen->nama_dokumen }}</td>
                                <td><span class="badge bg-light text-dark border badge-kategori">{{ $dokumen->kategori->nama }}</span></td>
                                <td>{{ $dokumen->tanggal_dokumen->format('d M Y') }}</td>
                                <td>{{ $dokumen->uploader->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('dokumen.show', $dokumen) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada dokumen.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-panel p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Statistik Dokumen</h6>
            </div>

            <div class="text-center mb-3">
                <div class="fs-3 fw-bold text-bulog-navy">{{ $totalDokumen }}</div>
                <div class="text-muted small">Total Dokumen</div>
            </div>

            <ul class="list-unstyled mb-0">
                @foreach ($kategoris as $kategori)
                    <li class="d-flex justify-content-between align-items-center py-2 border-top">
                        <span class="d-flex align-items-center gap-2 small">
                            <span class="d-inline-block rounded-circle {{ $warnaIkon[$kategori->warna] ?? 'bg-bulog-navy' }}" style="width:10px;height:10px;"></span>
                            {{ $kategori->nama }}
                        </span>
                        <span class="fw-semibold small">{{ $kategori->dokumens_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
