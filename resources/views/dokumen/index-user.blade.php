@extends('layouts.app')

@section('title', $kategoriAktif->nama ?? 'Daftar Dokumen')

@section('content')

{{-- =========================================================
     BREADCRUMB
========================================================= --}}
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

        {{-- ICON --}}
        <div class="dokumen-hero-icon-ring">

            <div class="dokumen-hero-icon kategori-icon-{{ $warnaKategori }}">

                <i class="bi {{ $kategoriAktif->icon ?? 'bi-folder-fill' }}"></i>

            </div>

        </div>


        {{-- JUDUL --}}
        <div class="flex-grow-1">

            <h2 class="fw-bold mb-2">
                {{ $kategoriAktif->nama ?? 'Daftar Dokumen' }}
            </h2>

            <p class="text-muted mb-0">

                @if($kategoriAktif)

                    Akses dan telusuri dokumen kategori
                    {{ $kategoriAktif->nama }}
                    dengan mudah.

                @else

                    Akses seluruh dokumen yang tersimpan dalam sistem.

                @endif

            </p>

        </div>


        {{-- JUMLAH DOKUMEN --}}
        <div class="dokumen-hero-counter text-center">

            <div
                class="dokumen-hero-counter-number"
                data-count="{{ $jumlahDokumenKategori }}"
            >
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

    <form method="GET">

        @if($kategoriAktif)

            <input
                type="hidden"
                name="kategori_id"
                value="{{ $kategoriAktif->id }}"
            >

        @endif


        <div class="dokumen-filter-grid">


            {{-- =================================================
                 CARI
            ================================================== --}}
            <div class="filter-search">

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>

                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        placeholder="Cari dokumen..."
                        value="{{ request('q') }}"
                    >

                </div>

            </div>


            {{-- =================================================
                 TAHUN
            ================================================== --}}
            <div class="filter-item">

                <select
                    name="tahun"
                    class="form-select"
                >

                    <option value="">
                        Tahun
                    </option>

                    @for ($y = now()->year; $y >= now()->year - 5; $y--)

                        <option
                            value="{{ $y }}"
                            {{ request('tahun') == $y ? 'selected' : '' }}
                        >
                            {{ $y }}
                        </option>

                    @endfor

                </select>

            </div>


            {{-- =================================================
                 BULAN
            ================================================== --}}
            <div class="filter-item">

                <select
                    name="bulan"
                    class="form-select"
                >

                    <option value="">
                        Bulan
                    </option>

                    @foreach ([
                        '01'=>'Januari',
                        '02'=>'Februari',
                        '03'=>'Maret',
                        '04'=>'April',
                        '05'=>'Mei',
                        '06'=>'Juni',
                        '07'=>'Juli',
                        '08'=>'Agustus',
                        '09'=>'September',
                        '10'=>'Oktober',
                        '11'=>'November',
                        '12'=>'Desember'
                    ] as $val => $label)

                        <option
                            value="{{ $val }}"
                            {{ request('bulan') == $val ? 'selected' : '' }}
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =================================================
                 TANGGAL
            ================================================== --}}
            <div class="filter-item">

                <select
                    name="tanggal"
                    class="form-select"
                >

                    <option value="">
                        Tanggal
                    </option>

                    @for ($d = 1; $d <= 31; $d++)

                        <option
                            value="{{ $d }}"
                            {{ request('tanggal') == $d ? 'selected' : '' }}
                        >
                            {{ $d }}
                        </option>

                    @endfor

                </select>

            </div>


            {{-- =================================================
                 BUTTON FILTER
            ================================================== --}}
            <div class="filter-button">

                <button
                    class="btn btn-bulog"
                    type="submit"
                >

                    <i class="bi bi-funnel"></i>

                    Filter

                </button>

            </div>


        </div>

    </form>

</div>



{{-- =========================================================
     TABEL DOKUMEN
========================================================= --}}
<div class="card-panel dokumen-table-card p-3">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>

                <tr class="text-muted small">

                    <th>
                        No
                    </th>

                    <th>
                        Nama Dokumen
                    </th>

                    <th>
                        Nomor / Keterangan
                    </th>

                    <th>
                        Tanggal
                    </th>

                    <th>
                        Diupload Oleh
                    </th>

                    <th class="text-end">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($dokumens as $i => $dokumen)

                    <tr>

                        {{-- NO --}}
                        <td>

                            {{ ($dokumens->firstItem() ?? 0) + $i }}

                        </td>


                        {{-- NAMA --}}
                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="file-icon">

                                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i>

                                </div>

                                <span class="fw-semibold">

                                    {{ $dokumen->nama_dokumen }}

                                </span>

                            </div>

                        </td>


                        {{-- NOMOR --}}
                        <td class="text-muted">

                            {{ $dokumen->nomor_keterangan ?? '-' }}

                        </td>


                        {{-- TANGGAL --}}
                        <td>

                            {{
                                $dokumen->tanggal_dokumen
                                    ? $dokumen->tanggal_dokumen->format('d M Y')
                                    : '-'
                            }}

                        </td>


                        {{-- UPLOADER --}}
                        <td>

                            {{ $dokumen->uploader->name ?? '-' }}

                        </td>


                        {{-- AKSI --}}
                        <td class="text-end">

                            {{-- LIHAT --}}
                            <a
                                href="{{ route('dokumen.show', $dokumen) }}"
                                class="btn btn-sm btn-outline-primary"
                                title="Lihat"
                            >

                                <i class="bi bi-eye"></i>

                            </a>


                            {{-- UNDUH --}}
                            <a
                                href="{{ route('dokumen.download', $dokumen) }}"
                                target="downloadFrame"
                                class="btn btn-sm btn-outline-success"
                                title="Unduh"
                            >

                                <i class="bi bi-download"></i>

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5"
                        >

                            <i
                                class="bi bi-inbox text-muted"
                                style="font-size:2.5rem;"
                            ></i>

                            <div class="text-muted mt-2">

                                Tidak ada dokumen ditemukan.

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



    {{-- =========================================================
     PAGINATION
========================================================= --}}
<div class="dokumen-pagination-footer">

    {{-- =====================================================
         KIRI
    ====================================================== --}}
    <div class="dokumen-pagination-left">

        {{-- JUMLAH DATA PER HALAMAN --}}
        <select
            class="dokumen-page-size"
            onchange="ubahPerPageUser(this.value)"
        >

            @foreach ([10, 20, 50, 100, 200, 500, 1000] as $size)

                <option
                    value="{{ $size }}"
                    {{ (int) request('perPage', 10) === $size ? 'selected' : '' }}
                >
                    {{ $size }}
                </option>

            @endforeach

        </select>


        {{-- DARI TOTAL AKTIVITAS --}}
        <div class="dokumen-total-info">

            <span>
                dari
            </span>

            <strong>
                {{ $dokumens->total() }}
            </strong>

            <span>
                aktivitas
            </span>

        </div>


        {{-- SHOWING --}}
        <div class="dokumen-pagination-info">

            Showing

            <strong>
                {{ $dokumens->firstItem() ?? 0 }}
            </strong>

            to

            <strong>
                {{ $dokumens->lastItem() ?? 0 }}
            </strong>

            of

            <strong>
                {{ $dokumens->total() }}
            </strong>

            results

        </div>

    </div>


    {{-- =====================================================
         KANAN
    ====================================================== --}}
    <div class="dokumen-pagination-right">

        {{ $dokumens
            ->appends(request()->query())
            ->links('pagination::bootstrap-5')
        }}

    </div>

</div>

</div>



{{-- =========================================================
     IFRAME DOWNLOAD
========================================================= --}}
<iframe
    name="downloadFrame"
    style="display:none;"
></iframe>



{{-- =========================================================
     CSS
========================================================= --}}
<style>


/* =========================================================
   FILTER UTAMA
========================================================= */

.dokumen-filter-card {

    width: 100%;

    max-width: 100%;

    box-sizing: border-box;

    overflow: hidden;

}


.dokumen-filter-card form {

    width: 100%;

    margin: 0;

}



/* =========================================================
   GRID FILTER
========================================================= */

.dokumen-filter-grid {

    width: 100%;

    display: grid;

    grid-template-columns:
        minmax(0, 2fr)
        minmax(0, 1fr)
        minmax(0, 1fr)
        minmax(0, 1fr)
        minmax(110px, 1fr);

    gap: 10px;

    box-sizing: border-box;

}


.dokumen-filter-grid > div {

    min-width: 0;

}


.dokumen-filter-grid .input-group {

    width: 100%;

}


.dokumen-filter-grid .form-control,
.dokumen-filter-grid .form-select,
.dokumen-filter-grid .btn {

    width: 100%;

    max-width: 100%;

    min-width: 0;

    box-sizing: border-box;

}


.dokumen-filter-grid .input-group-text {

    flex-shrink: 0;

}



/* =========================================================
   PAGINATION
========================================================= */

.dokumen-pagination-footer {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding-top: 16px;

    width: 100%;

    min-width: 0;

    flex-wrap: wrap;

}


.dokumen-pagination-left {

    display: flex;

    align-items: center;

    gap: 12px;

    min-width: 0;

    max-width: 100%;

    flex: 1 1 auto;

}


.dokumen-page-size {

    width: 64px;

    height: 42px;

    padding: 0 9px;

    flex: 0 0 64px;

    border: 1px solid #dbe2ea;

    border-radius: 9px;

    background: #ffffff;

    color: #475569;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    outline: none;

    box-sizing: border-box;

}


.dokumen-page-size:focus {

    border-color: #1769e8;

}


/* =========================================================
   DARI TOTAL AKTIVITAS
========================================================= */

.dokumen-total-info {

    display: flex;

    flex-direction: column;

    justify-content: center;

    min-width: 60px;

    line-height: 1.15;

    color: #687588;

    font-size: 13px;

}


.dokumen-total-info span {

    color: #687588;

}


.dokumen-total-info strong {

    color: #687588;

    font-weight: 500;

}


/* =========================================================
   SHOWING
========================================================= */

.dokumen-pagination-info {

    color: #687588;

    font-size: 13px;

    line-height: 1.4;

    white-space: nowrap;

}


.dokumen-pagination-info strong {

    color: #334155;

    font-weight: 500;

}


/* =========================================================
   PAGINATION KANAN
========================================================= */

.dokumen-pagination-right {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    flex: 0 0 auto;

    min-width: 0;

    max-width: 100%;

}


.dokumen-pagination-right .pagination {

    display: flex;

    align-items: center;

    flex-wrap: nowrap;

    gap: 7px;

    margin: 0;

}


/* =========================================================
   TOMBOL PAGINATION
========================================================= */

.dokumen-pagination-right .page-link {

    width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 0;

    border-radius: 9px !important;

    border: 1px solid #dbe2ea;

    background: #ffffff;

    color: #64748b;

    font-size: 15px;

    box-shadow: none;

}


.dokumen-pagination-right .page-link:hover {

    background: #f8fafc;

    color: #1769e8;

    border-color: #b8c9e2;

}


/* =========================================================
   HALAMAN AKTIF
========================================================= */

.dokumen-pagination-right
.page-item.active
.page-link {

    background: #1769e8;

    border-color: #1769e8;

    color: #ffffff;

}


/* =========================================================
   DISABLED
========================================================= */

.dokumen-pagination-right
.page-item.disabled
.page-link {

    background: #ffffff;

    border-color: #e2e8f0;

    color: #94a3b8;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .dokumen-pagination-footer {

        align-items: flex-start;

    }


    .dokumen-pagination-left {

        width: 100%;

        flex-wrap: wrap;

    }


    .dokumen-pagination-right {

        width: 100%;

        justify-content: flex-start;

        overflow-x: auto;

        padding-bottom: 3px;

    }


    .dokumen-pagination-right .pagination {

        flex-wrap: nowrap;

        white-space: nowrap;

    }

}


/* =========================================================
   SPLIT SCREEN / LAYAR SEMPIT
========================================================= */

@media (max-width: 600px) {

    .dokumen-pagination-left {

        display: grid;

        grid-template-columns: auto auto;

        align-items: center;

        gap: 8px 12px;

    }


    .dokumen-page-size {

        grid-row: span 2;

    }


    .dokumen-total-info {

        grid-column: 2;

    }


    .dokumen-pagination-info {

        grid-column: 2;

        white-space: normal;

    }


    .dokumen-pagination-right {

        width: 100%;

        overflow-x: auto;

    }


    .dokumen-pagination-right .pagination {

        flex-wrap: nowrap;

        white-space: nowrap;

    }

}


/* =========================================================
   DARK MODE
========================================================= */

body.dark-mode .dokumen-page-size {

    background: #202c3e;

    border-color: #46566d;

    color: #dbe5f2;

}


body.dark-mode .dokumen-pagination-info {

    color: #91a1b7;

}


body.dark-mode .dokumen-total-info,
body.dark-mode .dokumen-total-info span,
body.dark-mode .dokumen-total-info strong {

    color: #91a1b7;

}


body.dark-mode .dokumen-pagination-right .page-link {

    background: #202c3e;

    border-color: #46566d;

    color: #aebdd0;

}


body.dark-mode .dokumen-pagination-right .page-link:hover {

    background: #2b3b52;

    border-color: #60718a;

    color: white;

}


body.dark-mode .dokumen-pagination-right
.page-item.active .page-link {

    background: #1769e8;

    border-color: #1769e8;

    color: white;

}


body.dark-mode .dokumen-pagination-right
.page-item.disabled .page-link {

    background: #182334;

    border-color: #344256;

    color: #5f6d80;

}



/* =========================================================
   TABLE
========================================================= */

.dokumen-table-card {

    width: 100%;

    max-width: 100%;

    overflow: hidden;

}


.dokumen-table-card .table-responsive {

    width: 100%;

    max-width: 100%;

    overflow-x: auto;

    overflow-y: hidden;

}


.dokumen-table-card table {

    min-width: 900px;

}



/* =========================================================
   TABLE RESPONSIVE
========================================================= */

@media (max-width: 991.98px) {

    .dokumen-filter-grid {

        grid-template-columns:
            minmax(0, 1fr)
            minmax(0, 1fr);

    }


    /* CARI FULL BARIS */

    .filter-search {

        grid-column: 1 / -1;

    }

}



/* =========================================================
   HP
========================================================= */

@media (max-width: 575.98px) {

    .dokumen-filter-grid {

        grid-template-columns:
            minmax(0, 1fr)
            minmax(0, 1fr);

        gap: 8px;

    }


    /* CARI FULL */

    .filter-search {

        grid-column: 1 / -1;

    }


    /* TAHUN */

    .filter-item:nth-of-type(2) {

        grid-column: span 1;

    }


    /* PAGINATION */

    .dokumen-pagination-footer {

        flex-direction: column;

        align-items: flex-start;

        gap: 14px;

    }


    .dokumen-pagination-left {

        width: 100%;

        flex-wrap: wrap;

    }


    .dokumen-pagination-info {

        font-size: 12px;

        white-space: normal;

    }


    .dokumen-pagination-right {

        width: 100%;

        overflow-x: auto;

    }


    .dokumen-pagination-right .pagination {

        flex-wrap: nowrap;

        width: max-content;

    }

}



/* =========================================================
   LAYAR SANGAT KECIL
========================================================= */

@media (max-width: 400px) {

    .dokumen-filter-grid {

        grid-template-columns: 1fr;

    }


    .filter-search {

        grid-column: auto;

    }


    .dokumen-pagination-info {

        width: 100%;

    }

}



/* =========================================================
   DARK MODE
========================================================= */

body.dark-mode .dokumen-page-size {

    background: #202c3e;

    border-color: #46566d;

    color: #dbe5f2;

}


body.dark-mode .dokumen-pagination-info {

    color: #91a1b7;

}


body.dark-mode .dokumen-filter-card {

    background: #202c3e;

}



/* =========================================================
   PAGINATION DARK MODE
========================================================= */

body.dark-mode .dokumen-pagination-right .page-link {

    background: #202c3e;

    border-color: #46566d;

    color: #aebdd0;

}


body.dark-mode .dokumen-pagination-right .page-link:hover {

    background: #2b3b52;

    border-color: #60718a;

    color: white;

}


body.dark-mode .dokumen-pagination-right
.page-item.active .page-link {

    background: #1769e8;

    border-color: #1769e8;

    color: white;

}


body.dark-mode .dokumen-pagination-right
.page-item.disabled .page-link {

    background: #182334;

    border-color: #344256;

    color: #5f6d80;

}

</style>



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
@push('scripts')

<script>


/* =========================================================
   UBAH JUMLAH DATA PER HALAMAN
========================================================= */

function ubahPerPageUser(value) {

    const url = new URL(window.location.href);

    url.searchParams.set(
        'perPage',
        value
    );

    url.searchParams.set(
        'page',
        '1'
    );

    window.location.href =
        url.toString();

}



/* =========================================================
   ANIMASI COUNTER
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const counter =
            document.querySelector(
                '.dokumen-hero-counter-number'
            );


        if (!counter) {

            return;

        }


        const target =
            parseInt(
                counter.dataset.count,
                10
            ) || 0;


        const duration = 1000;

        const startTime =
            performance.now();


        function animate(currentTime) {

            const elapsed =
                currentTime -
                startTime;


            const progress =
                Math.min(
                    elapsed / duration,
                    1
                );


            const eased =
                1 -
                Math.pow(
                    1 - progress,
                    3
                );


            counter.textContent =
                Math.floor(
                    eased * target
                );


            if (progress < 1) {

                requestAnimationFrame(
                    animate
                );

            } else {

                counter.textContent =
                    target;

            }

        }


        requestAnimationFrame(
            animate
        );

    }
);

</script>

@endpush


@endsection