@extends('layouts.app')

@section('title', $kategoriAktif->nama ?? 'Daftar Dokumen')

@section('content')

{{-- BREADCRUMB --}}
<div class="sampah-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span>›</span>
    <span>{{ $kategoriAktif->nama ?? 'Daftar Dokumen' }}</span>
</div>

@php
    $warnaKategori = $kategoriAktif->warna ?? 'secondary';
    $jumlahDokumenKategori = $kategoriAktif 
        ? $kategoriAktif->dokumens()->count() 
        : $dokumens->total();
@endphp

{{-- =========================================================
     BANNER HERO
========================================================= --}}
<div class="dashboard-header dashboard-header-hero mb-4">
    <div class="hero-sparkles">
        <span class="sparkle s1">✦</span>
        <span class="sparkle s2">✦</span>
        <span class="sparkle s3">✦</span>
        <span class="sparkle s4">✦</span>
    </div>

    <div class="d-flex align-items-center flex-wrap gap-4 position-relative">
        <div class="dokumen-hero-icon-ring">
            <div class="dokumen-hero-icon kategori-icon-{{ $warnaKategori }}">
                <i class="bi {{ $kategoriAktif->icon ?? 'bi-folder-fill' }}"></i>
            </div>
        </div>

        <div class="flex-grow-1">
            <h2 class="fw-bold mb-2">
                {{ $kategoriAktif->nama ?? 'Daftar Dokumen' }}
            </h2>
            <p class="text-muted mb-0">
                @if($kategoriAktif)
                    Akses dan telusuri dokumen kategori {{ $kategoriAktif->nama }} dengan mudah.
                @else
                    Akses seluruh dokumen yang tersimpan dalam sistem.
                @endif
            </p>
        </div>

        <div class="dokumen-hero-counter text-center">
            <div class="dokumen-hero-counter-number" data-count="{{ $jumlahDokumenKategori }}">
                0
            </div>
            <div class="dokumen-hero-counter-label">
                Dokumen
            </div>
        </div>
    </div>
</div>

{{-- =========================================================
     FILTER DOKUMEN
========================================================= --}}
<div class="card-panel dokumen-filter-card p-3 mb-3">
    <form method="GET" class="row g-2 align-items-center">
        @if($kategoriAktif)
            <input type="hidden" name="kategori_id" value="{{ $kategoriAktif->id }}">
        @endif

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari dokumen..." value="{{ request('q') }}">
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

        <div class="col-md-2">
            <select name="tanggal" class="form-select" onchange="this.form.submit()">
                <option value="">Tanggal</option>
                @for ($d = 1; $d <= 31; $d++)
                    <option value="{{ $d }}" {{ request('tanggal') == $d ? 'selected' : '' }}>{{ $d }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button class="btn btn-bulog" type="submit">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>
</div>

{{-- =========================================================
     TABEL DOKUMEN (Lihat & Unduh Saja)
========================================================= --}}
<div class="card-panel p-3">
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
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="file-icon">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                </div>
                                <span class="fw-semibold">{{ $dokumen->nama_dokumen }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $dokumen->nomor_keterangan ?? '-' }}</td>
                        <td>{{ $dokumen->tanggal_dokumen ? $dokumen->tanggal_dokumen->format('d M Y') : '-' }}</td>
                        <td>{{ $dokumen->uploader->name ?? '-' }}</td>
                        <td class="text-end">
                            {{-- LIHAT --}}
                            <a href="{{ route('dokumen.show', $dokumen) }}" class="btn btn-sm btn-outline-primary" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- UNDUH --}}
                            <a href="{{ route('dokumen.download', $dokumen) }}" target="downloadFrame" class="btn btn-sm btn-outline-success" title="Unduh">
                                <i class="bi bi-download"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size:2.5rem;"></i>
                            <div class="text-muted mt-2">Tidak ada dokumen ditemukan.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            Menampilkan {{ $dokumens->firstItem() ?? 0 }} hingga {{ $dokumens->lastItem() ?? 0 }} dari {{ $dokumens->total() }} data
        </div>
        {{ $dokumens->links('pagination::bootstrap-5') }}
    </div>
</div>

<iframe name="downloadFrame" style="display:none;"></iframe>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const counter = document.querySelector('.dokumen-hero-counter-number');
    if (!counter) return;

    const target = parseInt(counter.dataset.count, 10) || 0;
    const duration = 1000;
    const startTime = performance.now();

    function animate(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);

        counter.textContent = Math.floor(eased * target);

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            counter.textContent = target;
        }
    }

    requestAnimationFrame(animate);
});
</script>
@endpush

@endsection