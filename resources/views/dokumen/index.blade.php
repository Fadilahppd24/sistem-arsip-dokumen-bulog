@extends('layouts.app')

@section('title', 'Pengolahan Dokumen')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active">Kelola Dokumen</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Kelola Dokumen</h3>
    <a href="{{ route('dokumen.create') }}" class="btn btn-bulog">
        <i class="bi bi-plus-lg"></i> Upload Dokumen
    </a>
</div>

<div class="card-panel p-3">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari dokumen pengolahan..." value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-2">
            <select name="tahun" class="form-select" onchange="this.form.submit()">
                <option value="">Tahun</option>
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                <option value="">Bulan</option>
                @foreach (['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                    <option value="{{ $val }}" {{ request('bulan') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="kategori_id" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1 d-grid">
            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-funnel"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="text-muted small">
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Nomor / Keterangan</th>
                    <th>Tanggal</th>
                    <th>Diupload Oleh</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dokumens as $i => $dokumen)
                    <tr>
                        <td>{{ $dokumens->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $dokumen->nama_dokumen }}</td>
                        <td class="text-muted">{{ $dokumen->nomor_keterangan ?? '-' }}</td>
                        <td>{{ $dokumen->tanggal_dokumen->format('d M Y') }}</td>
                        <td>{{ $dokumen->uploader->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('dokumen.show', $dokumen) }}" class="btn btn-sm btn-light" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-sm btn-light" title="Unduh"><i class="bi bi-download"></i></a>
                            <a href="{{ route('dokumen.edit', $dokumen) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-light text-danger" title="Hapus"
                                    data-bs-toggle="modal" data-bs-target="#hapusModal{{ $dokumen->id }}">
                                <i class="bi bi-trash"></i>
                            </button>

                            <div class="modal fade" id="hapusModal{{ $dokumen->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-4">
                                            <h6 class="fw-bold">Hapus dokumen ini?</h6>
                                            <p class="text-muted small mb-0">"{{ $dokumen->nama_dokumen }}" akan dihapus permanen dan tidak dapat dikembalikan.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <form method="POST" action="{{ route('dokumen.destroy', $dokumen) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada dokumen ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            Menampilkan {{ $dokumens->firstItem() ?? 0 }} hingga {{ $dokumens->lastItem() ?? 0 }} dari {{ $dokumens->total() }} data
        </div>
        {{ $dokumens->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
