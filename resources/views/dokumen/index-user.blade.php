@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active">Dokumen</li>
    </ol>
</nav>

<h3 class="fw-bold mb-3">Daftar Dokumen</h3>

<div class="card-panel p-3">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari dokumen..." value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="kategori_id" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="urutkan" class="form-select" onchange="this.form.submit()">
                <option value="">Urutkan</option>
                <option value="terbaru" {{ request('urutkan') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-funnel"></i> Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="text-muted small">
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Ukuran</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dokumens as $i => $dokumen)
                    <tr>
                        <td>{{ $dokumens->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $dokumen->nama_dokumen }}</td>
                        <td><span class="badge bg-light text-dark border badge-kategori">{{ $dokumen->kategori->nama }}</span></td>
                        <td>{{ $dokumen->tanggal_dokumen->format('d M Y') }}</td>
                        <td class="text-muted">{{ $dokumen->ukuran_format }}</td>
                        <td class="text-end">
                            <a href="{{ route('dokumen.show', $dokumen) }}" class="btn btn-sm btn-light" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-sm btn-light" title="Unduh"><i class="bi bi-download"></i></a>
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
