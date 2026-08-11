@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')

<style>

/* =========================================================
   HERO KELOLA KATEGORI
========================================================= */

.kategori-hero {
    position: relative;
    min-height: 138px;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    gap: 24px;
    border: 1px solid #8bbcff;
    border-radius: 20px;
    background: linear-gradient(110deg, #e8f1ff 0%, #dceaff 48%, #edf5ff 100%);
    overflow: hidden;
}

.kategori-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: #f5a800;
    border-radius: 20px 20px 0 0;
    z-index: 20;
    pointer-events: none;
}

.kategori-hero::after {
    content: "";
    position: absolute;
    width: 230px;
    height: 230px;
    right: 70px;
    top: -125px;
    border-radius: 50%;
    background: rgba(255,255,255,.45);
    pointer-events: none;
    z-index: 1;
}

.kategori-sparkle {
    position: absolute;
    color: rgba(255,255,255,.85);
    pointer-events: none;
    z-index: 2;
    animation: kategoriSparkle 3s ease-in-out infinite;
}

.kategori-sparkle-1 { right: 28%; top: 23px; font-size: 14px; animation-delay: 0s; }
.kategori-sparkle-2 { right: 40%; bottom: 25px; font-size: 9px; animation-delay: .8s; }
.kategori-sparkle-3 { right: 54%; top: 38px; font-size: 7px; animation-delay: 1.5s; }
.kategori-sparkle-4 { right: 22%; bottom: 38px; font-size: 10px; animation-delay: 2s; }

@keyframes kategoriSparkle {
    0%, 100% { opacity: .25; transform: scale(.75); }
    50% { opacity: 1; transform: scale(1.25); }
}

.kategori-hero-icon {
    position: relative;
    z-index: 5;
    width: 82px;
    height: 82px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #dbeafe;
    box-shadow: 0 7px 18px rgba(29,78,216,.15);
}

.kategori-hero-icon::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid rgba(37,99,235,.48);
    animation: kategoriRadar 2.8s ease-out infinite;
    pointer-events: none;
}

.kategori-hero-icon::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid rgba(37,99,235,.32);
    animation: kategoriRadar 2.8s ease-out infinite;
    animation-delay: 1.4s;
    pointer-events: none;
}

@keyframes kategoriRadar {
    0% { transform: scale(.85); opacity: .85; }
    60% { transform: scale(1.35); opacity: .28; }
    100% { transform: scale(1.75); opacity: 0; }
}

.kategori-hero-icon-inner {
    position: relative;
    z-index: 6;
    width: 68px;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #1769e8;
    color: white;
    font-size: 30px;
    box-shadow: 0 5px 15px rgba(29,78,216,.25), inset 0 0 0 2px rgba(255,255,255,.18);
}

.kategori-signal-dot {
    position: absolute;
    z-index: 8;
    display: block;
    border-radius: 50%;
    background: white;
    box-shadow: 0 0 8px rgba(255,255,255,.95);
    pointer-events: none;
    animation: kategoriSignalBlink 1.8s ease-in-out infinite;
}

.kategori-signal-dot.dot-1 { width: 7px; height: 7px; top: 3px; right: 15px; animation-delay: 0s; }
.kategori-signal-dot.dot-2 { width: 5px; height: 5px; bottom: 10px; left: 7px; animation-delay: .6s; }
.kategori-signal-dot.dot-3 { width: 4px; height: 4px; top: 19px; left: 1px; animation-delay: 1.1s; }
.kategori-signal-dot.dot-4 { width: 5px; height: 5px; right: 2px; bottom: 22px; animation-delay: 1.5s; }

@keyframes kategoriSignalBlink {
    0%, 100% { opacity: .25; transform: scale(.7); }
    50% { opacity: 1; transform: scale(1.35); }
}

.kategori-hero h2 {
    position: relative;
    z-index: 4;
    margin: 0 0 6px;
    color: #102a56;
    font-size: 29px;
    font-weight: 700;
}

.kategori-hero p {
    position: relative;
    z-index: 4;
    margin: 0;
    color: #526987;
    font-size: 15px;
}

.kategori-hero-stat {
    position: relative;
    z-index: 4;
    min-width: 120px;
    text-align: center;
}

.kategori-hero-number {
    color: #2f6fe4;
    font-size: 40px;
    line-height: 1;
    font-weight: 800;
}

.kategori-hero-label {
    margin-top: 7px;
    color: #687993;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .8px;
}

.kategori-hero-action { position: relative; z-index: 5; }

.kategori-hero-action .btn {
    border-radius: 9px;
    font-weight: 600;
    box-shadow: 0 5px 12px rgba(29,78,216,.15);
}

.kategori-icon-box {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    font-size: 18px;
}

.kategori-primary { background: #e8f0ff; color: #1d4ed8; }
.kategori-warning { background: #fff3d6; color: #f59e0b; }
.kategori-info { background: #e2f3ff; color: #38a5e5; }
.kategori-secondary { background: #edf0f3; color: #6b7280; }
.kategori-success { background: #e3f7eb; color: #198754; }
.kategori-danger { background: #ffe5e8; color: #dc3545; }
.kategori-purple { background: #f0e7ff; color: #7c3aed; }
.kategori-pink { background: #ffe5f0; color: #ec4899; }
.kategori-teal { background: #e1f7f5; color: #0f766e; }
.kategori-orange { background: #fff0df; color: #ea580c; }
.kategori-indigo { background: #e8e9ff; color: #4f46e5; }
.kategori-cyan { background: #dff8ff; color: #0891b2; }

.warna-kategori { display: flex; align-items: center; gap: 8px; }
.warna-dot { width: 10px; height: 10px; display: inline-block; border-radius: 50%; }
.warna-navy { background: #1d4ed8; }
.warna-kuning { background: #f5b400; }
.warna-biru-muda { background: #60b5ee; }
.warna-abu { background: #8b96a3; }
.warna-hijau { background: #22a05a; }
.warna-merah { background: #ef4444; }
.warna-ungu { background: #8b5cf6; }
.warna-pink { background: #ec4899; }
.warna-teal { background: #0f766e; }
.warna-orange { background: #f97316; }
.warna-indigo { background: #4f46e5; }
.warna-cyan { background: #06b6d4; }

/* =========================================================
   ICON PICKER (BULOG NAVY THEME)
========================================================= */

.icon-picker-wrapper {
    position: relative;
}

.icon-picker-panel {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    width: 100%;
    min-width: 320px;
    max-width: 440px;
    background: #ffffff;
    border: 1px solid #dbe4f3;
    border-radius: 14px;
    box-shadow: 0 14px 32px rgba(16,42,86,.18);
    z-index: 1080;
    overflow: hidden;
}

.icon-picker-panel.show {
    display: block;
}

.icon-picker-search {
    padding: 10px;
    border-bottom: 1px solid #eef2f8;
    background: #f8faff;
}

.icon-picker-search input {
    width: 100%;
    border: 1px solid #dbe4f3;
    border-radius: 9px;
    padding: 8px 12px;
    font-size: 13px;
    outline: none;
    background: #fff;
}

.icon-picker-search input:focus {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 3px rgba(29,78,216,.12);
}

.icon-picker-body {
    max-height: 300px;
    overflow-y: auto;
    padding: 12px 12px 14px;
}

.icon-picker-category {
    margin-bottom: 14px;
}

.icon-picker-category:last-child {
    margin-bottom: 0;
}

.icon-picker-category-title {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .7px;
    text-transform: uppercase;
    color: #687993;
    margin-bottom: 7px;
}

.icon-picker-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(36px, 1fr));
    gap: 6px;
}

.icon-picker-option {
    width: 36px;
    height: 36px;
    border: 1px solid transparent;
    border-radius: 9px;
    background: #f5f8fd;
    color: #33445e;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    cursor: pointer;
    transition: all .15s ease;
}

.icon-picker-custom {
    font-size: 22px;
}

.custom-icon {
    font-size: 21px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-picker-option:hover {
    background: #e8f0ff;
    color: #1d4ed8;
    transform: translateY(-1px);
}

.icon-picker-option.active {
    background: #1d4ed8;
    color: #fff;
    border-color: #1d4ed8;
}

.icon-picker-empty {
    text-align: center;
    color: #94a3b8;
    font-size: 13px;
    padding: 20px 0;
}

.icon-picker-body::-webkit-scrollbar {
    width: 7px;
}

.icon-picker-body::-webkit-scrollbar-thumb {
    background: #c6d4e8;
    border-radius: 10px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {
    .kategori-hero { flex-wrap: wrap; padding: 22px; }
    .kategori-hero-stat { text-align: left; }
}

@media (max-width: 576px) {
    .kategori-hero { gap: 15px; }
    .kategori-hero-icon { width: 72px; height: 72px; }
    .kategori-hero-icon-inner { width: 60px; height: 60px; font-size: 26px; }
    .kategori-hero h2 { font-size: 24px; }
}

</style>


<div class="container-fluid px-0">

{{-- BREADCRUMB + HERO --}}
<div class="mb-4">

    <div class="d-flex align-items-center gap-2 mb-3 small">
        <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color:#1d4ed8;">Beranda</a>
        <span class="text-muted">&gt;</span>
        <span class="text-muted">Kelola Kategori</span>
    </div>

    <div class="kategori-hero">

        <span class="kategori-sparkle kategori-sparkle-1">&#10022;</span>
        <span class="kategori-sparkle kategori-sparkle-2">&#10022;</span>
        <span class="kategori-sparkle kategori-sparkle-3">&#10022;</span>
        <span class="kategori-sparkle kategori-sparkle-4">&#10022;</span>

        <div class="kategori-hero-icon">
            <span class="kategori-signal-dot dot-1"></span>
            <span class="kategori-signal-dot dot-2"></span>
            <span class="kategori-signal-dot dot-3"></span>
            <span class="kategori-signal-dot dot-4"></span>

            <div class="kategori-hero-icon-inner">
                <i class="bi bi-folder-fill"></i>
            </div>
        </div>

        <div class="flex-grow-1">
            <h2 class="fw-bold">Kelola Kategori</h2>
            <p>Kelola dan atur kategori dokumen sistem dengan mudah.</p>
        </div>

        <div class="kategori-hero-stat">
            <div class="kategori-hero-number" data-count="{{ $kategoris->count() }}">0</div>
            <div class="kategori-hero-label">KATEGORI AKTIF</div>
        </div>

        <div class="kategori-hero-action">
            <button type="button" class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </button>
        </div>

    </div>
</div>


{{-- ALERT SUCCESS --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ALERT ERROR --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- VALIDATION ERROR --}}
@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
        <strong>Terdapat kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- CARD UTAMA --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="px-4 pt-3 border-bottom">
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#kategoriAktif">
                        Kategori Aktif
                        <span class="badge bg-primary ms-1">{{ $kategoris->count() }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#kategoriTerhapus">
                        Kategori Terhapus
                        <span class="badge bg-secondary ms-1">{{ $kategoriTerhapus->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content">

            {{-- TAB AKTIF --}}
            <div class="tab-pane fade show active" id="kategoriAktif">

                <div class="p-4">
                    <div class="row g-2">

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" id="searchKategori" class="form-control" placeholder="Cari kategori...">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <select id="filterWarna" class="form-select">
                                <option value="">Semua Warna</option>
                                <option value="primary">Navy</option>
                                <option value="warning">Kuning</option>
                                <option value="info">Biru Muda</option>
                                <option value="secondary">Abu-abu</option>
                                <option value="success">Hijau</option>
                                <option value="danger">Merah</option>
                                <option value="purple">Ungu</option>
                                <option value="pink">Pink</option>
                                <option value="teal">Teal</option>
                                <option value="orange">Orange</option>
                                <option value="indigo">Indigo</option>
                                <option value="cyan">Cyan</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tabelKategori">
                        <thead class="table-light">
                            <tr class="small text-muted">
                                <th class="ps-4" style="width:70px;">No</th>
                                <th style="width:90px;">Icon</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Dokumen</th>
                                <th>Dibuat Pada</th>
                                <th>Warna</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse ($kategoris as $i => $kategori)

                            <tr class="kategori-row" data-nama="{{ strtolower($kategori->nama) }}" data-warna="{{ $kategori->warna ?? 'secondary' }}">

                                <td class="ps-4">{{ $i + 1 }}</td>

                                <td>
                                    @php
                                        $warnaIcon = [
                                            'primary' => 'kategori-primary',
                                            'warning' => 'kategori-warning',
                                            'info' => 'kategori-info',
                                            'secondary' => 'kategori-secondary',
                                            'success' => 'kategori-success',
                                            'danger' => 'kategori-danger',
                                            'purple' => 'kategori-purple',
                                            'pink' => 'kategori-pink',
                                            'teal' => 'kategori-teal',
                                            'orange' => 'kategori-orange',
                                            'indigo' => 'kategori-indigo',
                                            'cyan' => 'kategori-cyan',
                                        ];
                                    @endphp

                                   <div class="kategori-icon-box {{ $warnaIcon[$kategori->warna] ?? 'kategori-secondary' }}">
    @if ($kategori->icon && str_starts_with($kategori->icon, 'bi-'))
        <i class="bi {{ $kategori->icon }}"></i>
    @else
        <span style="font-size: 20px; line-height: 1;">
            {{ $kategori->icon ?? '📁' }}
        </span>
    @endif
</div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $kategori->nama }}</div>
                                </td>

                                <td>
                                    @if ($kategori->dokumens_count > 0)
                                        <span class="badge bg-light text-dark border">{{ $kategori->dokumens_count }} dokumen</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border">0 dokumen</span>
                                    @endif
                                </td>

                                <td>
                                    <small class="text-muted">{{ $kategori->created_at?->format('d M Y H:i') }}</small>
                                </td>

                                <td>
                                    @php
                                        $warnaLabel = [
                                            'primary' => 'Navy',
                                            'warning' => 'Kuning',
                                            'info' => 'Biru Muda',
                                            'secondary' => 'Abu-abu',
                                            'success' => 'Hijau',
                                            'danger' => 'Merah',
                                            'purple' => 'Ungu',
                                            'pink' => 'Pink',
                                            'teal' => 'Teal',
                                            'orange' => 'Orange',
                                            'indigo' => 'Indigo',
                                            'cyan' => 'Cyan',
                                        ];

                                        $warnaClass = [
                                            'primary' => 'warna-navy',
                                            'warning' => 'warna-kuning',
                                            'info' => 'warna-biru-muda',
                                            'secondary' => 'warna-abu',
                                            'success' => 'warna-hijau',
                                            'danger' => 'warna-merah',
                                            'purple' => 'warna-ungu',
                                            'pink' => 'warna-pink',
                                            'teal' => 'warna-teal',
                                            'orange' => 'warna-orange',
                                            'indigo' => 'warna-indigo',
                                            'cyan' => 'warna-cyan',
                                        ];
                                    @endphp

                                    <div class="warna-kategori">
                                        <span class="warna-dot {{ $warnaClass[$kategori->warna] ?? 'warna-abu' }}"></span>
                                        <span class="warna-label">{{ $warnaLabel[$kategori->warna] ?? 'Abu-abu' }}</span>
                                    </div>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-inline-flex align-items-center gap-1">

                                        <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $kategori->id }}" title="Edit kategori">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="d-inline form-nonaktifkan" data-nama="{{ $kategori->nama }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border text-danger" title="Nonaktifkan kategori">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                    Belum ada kategori.
                                </td>
                            </tr>

                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-top">
                    <small class="text-muted">Menampilkan {{ $kategoris->count() }} kategori aktif</small>
                </div>
            </div>

            {{-- TAB KATEGORI TERHAPUS --}}
            <div class="tab-pane fade" id="kategoriTerhapus">
                <div class="p-4">

                    <div class="alert alert-info border-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <div>
                                <strong>Kategori yang dinonaktifkan</strong>
                                <div class="small mt-1">
                                    Kategori yang dinonaktifkan tidak dapat digunakan untuk dokumen baru, tetapi
                                    dokumen lama tetap aman. Kategori dapat dipulihkan kapan saja.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="small text-muted">
                                    <th style="width:70px;">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Jumlah Dokumen</th>
                                    <th>Dinonaktifkan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                            @forelse ($kategoriTerhapus as $i => $kategori)

                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><span class="fw-semibold text-muted">{{ $kategori->nama }}</span></td>
                                    <td>{{ $kategori->dokumens_count }} dokumen</td>
                                    <td><small class="text-muted">{{ $kategori->deleted_at?->format('d M Y H:i') }}</small></td>

                                    <td class="text-end">
                                        <div class="d-inline-flex align-items-center gap-1">

                                            <form action="{{ route('kategori.restore', $kategori->id) }}" method="POST" class="d-inline-flex">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Pulihkan kategori">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>

                                            {{-- Sesuaikan nama route 'kategori.forceDelete' dengan route hapus permanen pada routes/web.php Anda --}}
                                            <form action="{{ route('kategori.forceDelete', $kategori->id) }}" method="POST" class="d-inline-flex form-hapus-permanen" data-nama="{{ $kategori->nama }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus permanen">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                                        Tidak ada kategori yang dinonaktifkan.
                                    </td>
                                </tr>

                            @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama kategori" required>
                    </div>

                    {{-- ICON PICKER TAMBAH --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon</label>

                        <input type="hidden" name="icon" id="iconInputTambah" value="bi-folder-fill">

                        <div class="icon-picker-wrapper">
                            <button type="button"
                                    class="form-control d-flex align-items-center gap-2 text-start icon-picker-trigger"
                                    id="btnIconTambah"
                                    data-input="#iconInputTambah"
                                    data-panel="#iconPanelTambah"
                                    data-preview="#iconPreviewTambah"
                                    data-text="#iconTextTambah"
                                    style="height:48px;">
                                <i class="bi bi-folder-fill fs-5" id="iconPreviewTambah"></i>
                                <span id="iconTextTambah">Pilih Icon</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </button>

                            <div class="icon-picker-panel" id="iconPanelTambah"></div>
                        </div>
                    </div>

                    {{-- WARNA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Warna</label>

                        @php
                            $warnaTersedia = [
                                'primary' => 'Navy',
                                'warning' => 'Kuning',
                                'info' => 'Biru Muda',
                                'secondary' => 'Abu-abu',
                                'success' => 'Hijau',
                                'danger' => 'Merah',
                                'purple' => 'Ungu',
                                'pink' => 'Pink',
                                'teal' => 'Teal',
                                'orange' => 'Orange',
                                'indigo' => 'Indigo',
                                'cyan' => 'Cyan',
                            ];

                            $warnaTerpakai = $kategoris->pluck('warna')->filter()->unique()->toArray();
                        @endphp

                        <select name="warna" class="form-select" required>
                            <option value="">-- Pilih Warna --</option>
                            @foreach ($warnaTersedia as $value => $label)
                                <option value="{{ $value }}" {{ in_array($value, $warnaTerpakai) ? 'disabled' : '' }}>
                                    {{ $label }} @if (in_array($value, $warnaTerpakai)) (sudah digunakan) @endif
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">Warna yang sudah digunakan tidak dapat dipilih.</small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- MODAL EDIT KATEGORI --}}
@foreach ($kategoris as $kategori)

<div class="modal fade" id="modalEdit{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control" value="{{ $kategori->nama }}" required>
                    </div>

                    {{-- ICON PICKER EDIT --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon</label>

                        <input type="hidden" name="icon" id="iconInputEdit{{ $kategori->id }}" value="{{ $kategori->icon ?? 'bi-folder-fill' }}">

                        <div class="icon-picker-wrapper">
                            <button type="button"
                                    class="form-control d-flex align-items-center gap-2 text-start icon-picker-trigger"
                                    id="btnIconEdit{{ $kategori->id }}"
                                    data-input="#iconInputEdit{{ $kategori->id }}"
                                    data-panel="#iconPanelEdit{{ $kategori->id }}"
                                    data-preview="#iconPreviewEdit{{ $kategori->id }}"
                                    data-text="#iconTextEdit{{ $kategori->id }}"
                                    style="height:48px;">
@if ($kategori->icon && str_starts_with($kategori->icon, 'bi-'))
    <i class="bi {{ $kategori->icon }} fs-5"
       id="iconPreviewEdit{{ $kategori->id }}"></i>
@else
    <span class="fs-5"
          id="iconPreviewEdit{{ $kategori->id }}">{{ $kategori->icon ?? '📁' }}</span>
@endif
                                <span id="iconTextEdit{{ $kategori->id }}">{{ $kategori->icon ?? 'Pilih Icon' }}</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </button>

                            <div class="icon-picker-panel" id="iconPanelEdit{{ $kategori->id }}"></div>
                        </div>
                    </div>

                    {{-- WARNA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Warna</label>

                        @php
                            $warnaTersedia = [
                                'primary' => 'Navy',
                                'warning' => 'Kuning',
                                'info' => 'Biru Muda',
                                'secondary' => 'Abu-abu',
                                'success' => 'Hijau',
                                'danger' => 'Merah',
                                'purple' => 'Ungu',
                                'pink' => 'Pink',
                                'teal' => 'Teal',
                                'orange' => 'Orange',
                                'indigo' => 'Indigo',
                                'cyan' => 'Cyan',
                            ];

                            $warnaTerpakai = $kategoris->pluck('warna')->filter()->toArray();
                        @endphp

                        <select name="warna" class="form-select" required>
                            <option value="">-- Pilih Warna --</option>
                            @foreach ($warnaTersedia as $value => $label)
                                <option value="{{ $value }}" {{ in_array($value, $warnaTerpakai) ? 'disabled' : '' }}>
                                    {{ $label }} @if (in_array($value, $warnaTerpakai)) (sudah digunakan) @endif
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">Warna yang sudah digunakan oleh kategori lain tidak dapat dipilih.</small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endforeach


{{-- MODAL KONFIRMASI --}}
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-confirm">
        <div class="modal-content confirm-modal">
            <div class="modal-body text-center p-4 p-md-5">

                <div class="confirm-icon" id="confirmIcon">
                    <i class="bi bi-exclamation-lg"></i>
                </div>

                <h4 class="fw-bold mb-2" id="confirmTitle">Konfirmasi</h4>

                <p class="text-muted mb-4" id="confirmMessage">Apakah Anda yakin?</p>

                <div class="confirm-warning" id="confirmWarning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span id="confirmWarningText">Tindakan ini tidak dapat dibatalkan.</span>
                </div>

                <div class="d-flex gap-2 justify-content-center mt-4">
                    <button type="button" class="btn btn-confirm-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-confirm-danger" id="btnConfirmAction">
                        <i class="bi bi-trash3 me-1"></i> Ya, Hapus Permanen
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection


{{-- =========================================================
     JAVASCRIPT (SATU BLOK @push('scripts') SAJA)
========================================================= --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       MODAL KONFIRMASI (Nonaktifkan & Hapus Permanen)
    ===================================================== */

    const modalElement = document.getElementById('modalKonfirmasi');
    const modal = new bootstrap.Modal(modalElement);

    const confirmTitle = document.getElementById('confirmTitle');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmWarningText = document.getElementById('confirmWarningText');
    const confirmIcon = document.getElementById('confirmIcon');
    const confirmButton = document.getElementById('btnConfirmAction');

    let formTarget = null;

    document.querySelectorAll('.form-nonaktifkan').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            formTarget = form;

            const nama = form.dataset.nama;

            confirmTitle.textContent = 'Nonaktifkan kategori?';
            confirmMessage.innerHTML = 'Kategori <strong>' + nama + '</strong> akan dinonaktifkan.';
            confirmWarningText.textContent = 'Kategori tidak dapat digunakan untuk dokumen baru, tetapi dokumen lama tetap aman.';
            confirmIcon.innerHTML = '<i class="bi bi-folder-x"></i>';
            confirmIcon.style.background = '#fff7ed';
            confirmIcon.style.borderColor = '#fed7aa';
            confirmIcon.style.color = '#f97316';
            confirmButton.innerHTML = '<i class="bi bi-folder-x me-1"></i> Ya, Nonaktifkan';
            confirmButton.style.background = '#f97316';

            modal.show();
        });
    });

    document.querySelectorAll('.form-hapus-permanen').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            formTarget = form;

            const nama = form.dataset.nama || '';

            confirmTitle.textContent = 'Hapus kategori secara permanen?';
            confirmMessage.innerHTML = nama
                ? 'Kategori <strong>' + nama + '</strong> akan dihapus permanen dan tidak dapat dikembalikan.'
                : 'Data kategori yang sudah dihapus tidak dapat dikembalikan.';
            confirmWarningText.textContent = 'Tindakan ini akan menghapus kategori secara permanen dari sistem.';
            confirmIcon.innerHTML = '<i class="bi bi-trash3"></i>';
            confirmIcon.style.background = '#fef2f2';
            confirmIcon.style.borderColor = '#fecaca';
            confirmIcon.style.color = '#dc3545';
            confirmButton.innerHTML = '<i class="bi bi-trash3 me-1"></i> Ya, Hapus Permanen';
            confirmButton.style.background = '#dc3545';

            modal.show();
        });
    });

    confirmButton.addEventListener('click', function () {
        if (formTarget) {
            modal.hide();
            formTarget.submit();
        }
    });

    modalElement.addEventListener('hidden.bs.modal', function () {
        formTarget = null;
    });


    /* =====================================================
       ICON PICKER (Bootstrap Icons) - dipakai bersama oleh
       modal Tambah dan setiap modal Edit
    ===================================================== */

 const iconCategories = {
"Pertanian & Pangan": [
    {
        icon: "🌱",
        name: "Tanaman / Pertanian"
    },
    {
        icon: "🧺",
        name: "Hasil Panen"
    },
    {
        icon: "📦",
        name: "Beras / Bahan Pangan"
    },
    {
        icon: "🌾",
        name: "Padi / Gandum"
    },
    {
        icon: "🌽",
        name: "Jagung"
    },
    {
        icon: "🌿",
        name: "Tanaman"
    }
],

    "Dokumen & Arsip": ["bi-file-earmark","bi-file-earmark-fill","bi-file-earmark-text","bi-file-earmark-text-fill","bi-file-earmark-check","bi-file-earmark-check-fill","bi-file-earmark-post","bi-file-earmark-richtext","bi-file-earmark-ruled","bi-file-earmark-ruled-fill","bi-file-earmark-medical","bi-file-earmark-medical-fill","bi-file-earmark-pdf","bi-file-earmark-pdf-fill","bi-file-earmark-word","bi-file-earmark-word-fill","bi-file-earmark-excel","bi-file-earmark-excel-fill","bi-file-earmark-spreadsheet","bi-file-earmark-spreadsheet-fill","bi-file-earmark-bar-graph","bi-file-earmark-bar-graph-fill","bi-file-earmark-lock","bi-file-earmark-lock-fill","bi-file-earmark-person","bi-file-earmark-diff","bi-file-earmark-diff-fill","bi-files","bi-files-alt","bi-folder","bi-folder-fill","bi-folder2","bi-folder2-open","bi-folder-check","bi-folder-plus","bi-folder-minus","bi-folder-symlink","bi-folder-symlink-fill","bi-folder-x","bi-archive","bi-archive-fill","bi-clipboard","bi-clipboard-fill","bi-clipboard-check","bi-clipboard-check-fill","bi-clipboard-data","bi-clipboard-data-fill","bi-clipboard2","bi-clipboard2-fill","bi-clipboard2-check","bi-clipboard2-check-fill","bi-clipboard2-data","bi-clipboard2-data-fill","bi-clipboard2-plus","bi-clipboard2-plus-fill","bi-journal","bi-journal-text","bi-journal-bookmark","bi-journal-bookmark-fill","bi-journals","bi-book","bi-book-fill","bi-book-half","bi-books","bi-envelope","bi-envelope-fill","bi-envelope-open","bi-envelope-open-fill","bi-postcard","bi-postcard-fill","bi-sticky","bi-sticky-fill","bi-award","bi-award-fill","bi-patch-check","bi-patch-check-fill"],

    "Hewan & Peternakan": ["bi-bug","bi-bug-fill","bi-egg","bi-egg-fill","bi-egg-fried","bi-feather","bi-fish"],

    "Tumbuhan & Alam": ["bi-tree","bi-tree-fill","bi-flower1","bi-flower2","bi-flower3","bi-sun","bi-sun-fill","bi-moon","bi-moon-fill","bi-moon-stars","bi-moon-stars-fill","bi-stars","bi-cloud","bi-cloud-fill","bi-droplet","bi-droplet-fill","bi-droplet-half","bi-water","bi-wind","bi-snow","bi-snow2","bi-snow3","bi-rainbow","bi-globe","bi-globe-americas","bi-globe-asia-australia","bi-globe-central-south-asia","bi-globe-europe-africa","bi-brightness-high","bi-brightness-high-fill","bi-brightness-low","bi-brightness-low-fill"],

    "Gudang & Pergudangan BULOG": ["bi-box","bi-box-fill","bi-box2","bi-box2-fill","bi-box2-heart","bi-box2-heart-fill","bi-box-seam","bi-box-seam-fill","bi-boxes","bi-archive","bi-archive-fill","bi-building","bi-building-fill","bi-buildings","bi-buildings-fill","bi-inbox","bi-inbox-fill","bi-inboxes","bi-inboxes-fill","bi-database","bi-database-fill","bi-database-add","bi-database-check","bi-database-gear","bi-hdd","bi-hdd-fill","bi-hdd-stack","bi-hdd-stack-fill","bi-truck-flatbed","bi-basket3","bi-basket3-fill"],

    "Logistik & Distribusi": ["bi-truck","bi-truck-front","bi-truck-front-fill","bi-truck-flatbed","bi-car-front","bi-car-front-fill","bi-bus-front","bi-bus-front-fill","bi-train-front","bi-train-front-fill","bi-train-freight-front","bi-train-freight-front-fill","bi-train-lightrail-front","bi-train-lightrail-front-fill","bi-airplane","bi-airplane-fill","bi-airplane-engines","bi-airplane-engines-fill","bi-geo-alt","bi-geo-alt-fill","bi-pin-map","bi-pin-map-fill","bi-signpost","bi-signpost-fill","bi-signpost-2","bi-signpost-2-fill","bi-signpost-split","bi-signpost-split-fill","bi-send","bi-send-fill","bi-send-check","bi-send-check-fill","bi-send-plus","bi-send-plus-fill","bi-compass","bi-compass-fill","bi-arrow-repeat"],

    "Keuangan & Administrasi": ["bi-cash","bi-cash-coin","bi-cash-stack","bi-currency-dollar","bi-currency-exchange","bi-wallet","bi-wallet2","bi-wallet-fill","bi-credit-card","bi-credit-card-fill","bi-credit-card-2-back","bi-credit-card-2-back-fill","bi-credit-card-2-front","bi-credit-card-2-front-fill","bi-receipt","bi-receipt-cutoff","bi-calculator","bi-calculator-fill","bi-bank","bi-bank2","bi-piggy-bank","bi-piggy-bank-fill","bi-graph-up","bi-graph-up-arrow","bi-graph-down","bi-bar-chart","bi-bar-chart-fill","bi-bar-chart-line","bi-bar-chart-line-fill","bi-pie-chart","bi-pie-chart-fill","bi-percent","bi-coin"],

    "Kantor & Organisasi": ["bi-building","bi-building-fill","bi-buildings","bi-buildings-fill","bi-briefcase","bi-briefcase-fill","bi-person","bi-person-fill","bi-person-badge","bi-person-badge-fill","bi-people","bi-people-fill","bi-person-workspace","bi-diagram-2","bi-diagram-2-fill","bi-diagram-3","bi-diagram-3-fill","bi-kanban","bi-kanban-fill","bi-calendar","bi-calendar-fill","bi-calendar-event","bi-calendar-event-fill","bi-calendar-check","bi-calendar-check-fill","bi-clock","bi-clock-fill","bi-pc-display","bi-pc-display-horizontal","bi-laptop","bi-laptop-fill","bi-printer","bi-printer-fill","bi-display","bi-display-fill","bi-easel","bi-easel-fill","bi-chat-square-text","bi-chat-square-text-fill","bi-person-video","bi-person-video2","bi-person-video3"],

    "Keamanan & Verifikasi": ["bi-lock","bi-lock-fill","bi-unlock","bi-unlock-fill","bi-shield","bi-shield-fill","bi-shield-check","bi-shield-lock","bi-shield-lock-fill","bi-shield-exclamation","bi-shield-x","bi-key","bi-key-fill","bi-fingerprint","bi-patch-check","bi-patch-check-fill","bi-patch-exclamation","bi-patch-exclamation-fill","bi-check-circle","bi-check-circle-fill","bi-exclamation-triangle","bi-exclamation-triangle-fill","bi-exclamation-octagon","bi-exclamation-octagon-fill","bi-eye","bi-eye-fill","bi-eye-slash","bi-eye-slash-fill","bi-incognito"],

    "Lokasi & Wilayah": ["bi-map","bi-map-fill","bi-geo","bi-geo-fill","bi-geo-alt","bi-geo-alt-fill","bi-pin","bi-pin-fill","bi-pin-map","bi-pin-map-fill","bi-pin-angle","bi-pin-angle-fill","bi-compass","bi-compass-fill","bi-signpost","bi-signpost-fill","bi-house","bi-house-fill","bi-house-door","bi-house-door-fill","bi-buildings","bi-buildings-fill","bi-globe","bi-globe-americas","bi-globe-asia-australia","bi-globe-central-south-asia","bi-globe-europe-africa"],

    "Komunikasi": ["bi-telephone","bi-telephone-fill","bi-telephone-plus","bi-telephone-plus-fill","bi-telephone-inbound","bi-telephone-inbound-fill","bi-telephone-outbound","bi-telephone-outbound-fill","bi-envelope","bi-envelope-fill","bi-envelope-open","bi-envelope-open-fill","bi-envelope-check","bi-envelope-check-fill","bi-chat","bi-chat-fill","bi-chat-dots","bi-chat-dots-fill","bi-chat-left-text","bi-chat-left-text-fill","bi-chat-square-text","bi-chat-square-text-fill","bi-megaphone","bi-megaphone-fill","bi-bell","bi-bell-fill","bi-broadcast","bi-broadcast-pin","bi-send","bi-send-fill"],

    "Transportasi": ["bi-truck","bi-truck-front","bi-truck-front-fill","bi-car-front","bi-car-front-fill","bi-bicycle","bi-moped","bi-moped2","bi-scooter","bi-bus-front","bi-bus-front-fill","bi-train-front","bi-train-front-fill","bi-airplane","bi-airplane-fill","bi-fuel-pump","bi-fuel-pump-fill","bi-fuel-pump-diesel","bi-fuel-pump-diesel-fill"],

    "Teknologi & Sistem": ["bi-database","bi-database-fill","bi-database-gear","bi-server","bi-cpu","bi-cpu-fill","bi-cloud","bi-cloud-fill","bi-cloud-upload","bi-cloud-upload-fill","bi-cloud-download","bi-cloud-download-fill","bi-gear","bi-gear-fill","bi-gear-wide","bi-gear-wide-connected","bi-code","bi-code-slash","bi-terminal","bi-terminal-fill","bi-hdd","bi-hdd-fill","bi-hdd-stack","bi-hdd-stack-fill","bi-laptop","bi-laptop-fill","bi-pc-display","bi-speedometer","bi-speedometer2","bi-grid","bi-grid-fill","bi-grid-1x2","bi-grid-1x2-fill","bi-kanban","bi-kanban-fill","bi-printer","bi-printer-fill"],

    "Umum": ["bi-star","bi-star-fill","bi-heart","bi-heart-fill","bi-bookmark","bi-bookmark-fill","bi-bell","bi-bell-fill","bi-tag","bi-tag-fill","bi-tags","bi-tags-fill","bi-calendar","bi-calendar-fill","bi-clock","bi-clock-fill","bi-search","bi-funnel","bi-funnel-fill","bi-bar-chart","bi-bar-chart-fill","bi-pie-chart","bi-pie-chart-fill","bi-graph-up","bi-list-check","bi-grid","bi-grid-fill","bi-check-circle","bi-check-circle-fill","bi-info-circle","bi-info-circle-fill"]
};

    function closeIconPanel(panel) {
        panel.classList.remove('show');
    }

    function closeAllIconPanels() {
        document.querySelectorAll('.icon-picker-panel.show').forEach(closeIconPanel);
    }

    function buildIconPanel(panel, input, preview, text) {

        let html = '<div class="icon-picker-search"><input type="text" placeholder="Cari icon..." autocomplete="off"></div>';
        html += '<div class="icon-picker-body">';

        Object.keys(iconCategories).forEach(function (cat) {
            html += '<div class="icon-picker-category" data-cat="' + cat + '">';
            html += '<div class="icon-picker-category-title">' + cat + '</div>';
            html += '<div class="icon-picker-grid">';

            iconCategories[cat].forEach(function (item) {

    if (typeof item === 'string') {

        html += `
            <button
                type="button"
                class="icon-picker-option"
                data-icon="${item}"
                data-name="${item}"
                title="${item}"
            >
                <i class="bi ${item}"></i>
            </button>
        `;

    } else {

        html += `
            <button
                type="button"
                class="icon-picker-option icon-picker-custom"
                data-icon="${item.icon}"
                data-name="${item.name}"
                title="${item.name}"
            >
                <span class="custom-icon">${item.icon}</span>
            </button>
        `;

    }

});
            html += '</div></div>';
        });

        html += '<div class="icon-picker-empty" style="display:none;">Icon tidak ditemukan.</div>';
        html += '</div>';

        panel.innerHTML = html;
        panel.dataset.built = '1';

        const currentIcon = input.value;
        const activeBtn = panel.querySelector('.icon-picker-option[data-icon="' + currentIcon + '"]');
        if (activeBtn) {
            activeBtn.classList.add('active');
        }

        const searchInput = panel.querySelector('.icon-picker-search input');
        const emptyMsg = panel.querySelector('.icon-picker-empty');

        searchInput.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        searchInput.addEventListener('input', function () {
            const term = this.value.trim().toLowerCase();
            let anyVisible = false;

            panel.querySelectorAll('.icon-picker-category').forEach(function (catEl) {
                let catHasMatch = false;

                catEl.querySelectorAll('.icon-picker-option').forEach(function (opt) {
                   const iconName = (
    (opt.dataset.icon || '') + ' ' +
    (opt.dataset.name || '')
).toLowerCase();

const match = term === '' || iconName.indexOf(term) !== -1;
                   

                    opt.style.display = match ? '' : 'none';

                    if (match) {
                        catHasMatch = true;
                        anyVisible = true;
                    }
                });

                catEl.style.display = catHasMatch ? '' : 'none';
            });

            emptyMsg.style.display = anyVisible ? 'none' : 'block';
        });

        panel.querySelectorAll('.icon-picker-option').forEach(function (opt) {
            opt.addEventListener('click', function (e) {
                e.stopPropagation();


const icon = this.dataset.icon;
const name = this.dataset.name;

input.value = icon;

if (typeof icon === 'string' && icon.startsWith('bi-')) {
    preview.innerHTML = '';
    preview.className = 'bi ' + icon + ' fs-5';
} else {
    preview.className = 'fs-5';
    preview.innerHTML = icon;
}

text.textContent = name;


                panel.querySelectorAll('.icon-picker-option.active').forEach(function (a) {
                    a.classList.remove('active');
                });

                this.classList.add('active');

                closeIconPanel(panel);
            });
        });
    }

    function initIconPicker(trigger) {

        const input = document.querySelector(trigger.dataset.input);
        const panel = document.querySelector(trigger.dataset.panel);
        const preview = document.querySelector(trigger.dataset.preview);
        const text = document.querySelector(trigger.dataset.text);

        if (!input || !panel || !preview || !text) {
            return;
        }

        if (!panel.dataset.built) {
            buildIconPanel(panel, input, preview, text);
        }

        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const isOpen = panel.classList.contains('show');

            closeAllIconPanels();

            if (!isOpen) {
                panel.classList.add('show');

                const searchInput = panel.querySelector('.icon-picker-search input');
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                    setTimeout(function () {
                        searchInput.focus();
                    }, 50);
                }
            }
        });
    }

    document.querySelectorAll('.icon-picker-trigger').forEach(initIconPicker);

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.icon-picker-wrapper')) {
            closeAllIconPanels();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllIconPanels();
        }
    });

});
</script>
@endpush
