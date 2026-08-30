@extends('layouts.app')

@section('title', $kategoriAktif->nama ?? 'Kelola Dokumen')

@section('content')

{{-- =========================================================
     BREADCRUMB
========================================================= --}}
<div class="sampah-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Beranda</a>
    <span>›</span>
    <span>{{ $kategoriAktif->nama ?? 'Kelola Dokumen' }}</span>
</div>


@php
    $warnaKategori = $kategoriAktif->warna ?? 'secondary';

    $jumlahDokumenKategori = $kategoriAktif
        ? $kategoriAktif->dokumens()->count()
        : $dokumens->total();

    $dokumenTerbaru = $kategoriAktif
        ? $kategoriAktif->dokumens()
            ->with('uploader')
            ->latest('tanggal_dokumen')
            ->first()
        : null;
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

    <div class="dokumen-hero-content">

        {{-- ICON --}}
        <div class="dokumen-hero-icon-ring">
            <div class="dokumen-hero-icon kategori-icon-{{ $warnaKategori }}">
                <i class="bi {{ $kategoriAktif->icon ?? 'bi-folder-fill' }}"></i>
            </div>
        </div>


        {{-- JUDUL --}}
        <div class="dokumen-hero-text">

            <h2 class="fw-bold mb-2">
                {{ $kategoriAktif->nama ?? 'Kelola Dokumen' }}
            </h2>

            <p class="text-muted mb-0">

                @if($kategoriAktif)

                    Kelola dan akses dokumen kategori
                    {{ $kategoriAktif->nama }} dengan mudah.

                @else

                    Kelola seluruh dokumen yang tersimpan dalam sistem.

                @endif

            </p>

        </div>


        {{-- JUMLAH --}}
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
     INFORMASI DOKUMEN TERBARU
========================================================= --}}
<div class="dokumen-info-card">

    @if($dokumenTerbaru)

        {{-- ICON --}}
        <div class="dokumen-info-icon dokumen-info-icon-document">

            @php
                $ext = strtolower(
                    pathinfo(
                        $dokumenTerbaru->file_path,
                        PATHINFO_EXTENSION
                    )
                );
            @endphp

            @if($ext === 'pdf')

                <i class="bi bi-file-earmark-pdf-fill"></i>

            @elseif(in_array($ext, ['doc', 'docx']))

                <i class="bi bi-file-earmark-word-fill"></i>

            @elseif(in_array($ext, ['xls', 'xlsx']))

                <i class="bi bi-file-earmark-excel-fill"></i>

            @else

                <i class="bi bi-file-earmark-fill"></i>

            @endif

        </div>


        {{-- INFORMASI --}}
        <div class="dokumen-info-content">

            <div class="dokumen-info-label">
                <i class="bi bi-clock-history"></i>
                Dokumen terbaru
            </div>

            <h6 class="dokumen-info-title">
                {{ $dokumenTerbaru->nama_dokumen }}
            </h6>

            <div class="dokumen-info-meta">

                <span>
                    <i class="bi bi-calendar3"></i>

                    {{ $dokumenTerbaru->tanggal_dokumen
                        ? $dokumenTerbaru->tanggal_dokumen->format('d M Y')
                        : '-' }}
                </span>

                <span class="dokumen-info-dot">
                    •
                </span>

                <span>
                    <i class="bi bi-person"></i>

                    {{ $dokumenTerbaru->uploader->name ?? '-' }}
                </span>

            </div>

        </div>

    @else

        {{-- ICON --}}
        <div class="dokumen-info-icon dokumen-info-icon-empty">

            <i class="bi bi-folder-plus"></i>

        </div>


        {{-- INFORMASI --}}
        <div class="dokumen-info-content">

            <div class="dokumen-info-label">
                <i class="bi bi-info-circle"></i>
                Belum ada dokumen
            </div>

            <h6 class="dokumen-info-title">

                Belum ada dokumen di
                {{ $kategoriAktif->nama ?? 'kategori ini' }}

            </h6>

            <div class="dokumen-info-meta">

                Tambahkan dokumen pertama untuk mulai
                mengarsipkan dan mengelola dokumen.

            </div>

        </div>

    @endif


    {{-- UPLOAD --}}
    <div class="dokumen-info-action">

        <a
            href="{{ route('dokumen.create', ['kategori_id' => $kategoriAktif->id ?? null]) }}"
            class="btn btn-upload-quick"
        >

            <i class="bi bi-plus-lg"></i>

            Upload Dokumen

        </a>

    </div>

</div>



{{-- =========================================================
     FILTER DOKUMEN
========================================================= --}}
<div class="card-panel dokumen-filter-card p-3 mb-3">

    <form method="GET" class="dokumen-filter-form">

        @if($kategoriAktif)

            <input
                type="hidden"
                name="kategori_id"
                value="{{ $kategoriAktif->id }}"
            >

        @endif


        {{-- SEARCH --}}
        <div class="dokumen-filter-search">

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


        {{-- TAHUN --}}
        <div class="dokumen-filter-item">

            <select
                name="tahun"
                class="form-select"
                onchange="this.form.submit()"
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


        {{-- BULAN --}}
        <div class="dokumen-filter-item">

            <select
                name="bulan"
                class="form-select"
                onchange="this.form.submit()"
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


        {{-- TANGGAL --}}
        <div class="dokumen-filter-item">

            <select
                name="tanggal"
                class="form-select"
                onchange="this.form.submit()"
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


        {{-- BUTTON FILTER --}}
        <div class="dokumen-filter-button">

            <button
                class="btn btn-bulog"
                type="submit"
            >

                <i class="bi bi-funnel"></i>

                <span>Filter</span>

            </button>

        </div>

    </form>

</div>



{{-- =========================================================
     TABEL DOKUMEN
========================================================= --}}
<div class="card-panel p-3 dokumen-table-card">

    <div class="table-responsive dokumen-table-responsive">

        <table class="table table-hover align-middle mb-0 dokumen-table">

            <thead>

                <tr class="text-muted small">

                    <th>No</th>

                    <th>Nama Dokumen</th>

                    <th>Nomor / Keterangan</th>

                    <th>Tanggal</th>

                    <th>Diupload Oleh</th>

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
                            {{ $dokumens->firstItem() + $i }}
                        </td>


                        {{-- NAMA --}}
                        <td>

                            <div class="d-flex align-items-center gap-3 dokumen-name-cell">

                                <div class="file-icon">

                                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i>

                                </div>

                                <span class="fw-semibold dokumen-name-text">

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

                            {{ $dokumen->tanggal_dokumen
                                ? $dokumen->tanggal_dokumen->format('d M Y')
                                : '-' }}

                        </td>


                        {{-- UPLOADER --}}
                        <td>

                            {{ $dokumen->uploader->name ?? '-' }}

                        </td>


                        {{-- AKSI --}}
                        <td class="text-end">

                            <div class="dokumen-action-buttons">

                                {{-- LIHAT --}}
                                <a
                                    href="{{ route('dokumen.show', $dokumen) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Lihat"
                                >
                                    <i class="bi bi-eye"></i>
                                </a>


                                {{-- DOWNLOAD --}}
                                <a
                                    href="{{ route('dokumen.download', $dokumen) }}"
                                    target="downloadFrame"
                                    onclick="setTimeout(function(){ window.location='{{ route('dashboard') }}'; }, 500)"
                                    class="btn btn-sm btn-outline-success"
                                    title="Unduh"
                                >
                                    <i class="bi bi-download"></i>
                                </a>


                                {{-- EDIT --}}
                                <a
                                    href="{{ route('dokumen.edit', $dokumen) }}"
                                    class="btn btn-sm btn-outline-warning"
                                    title="Edit"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>


                                {{-- HAPUS --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Hapus"
                                    data-bs-toggle="modal"
                                    data-bs-target="#hapusModal{{ $dokumen->id }}"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>


                            {{-- =====================================================
                                 MODAL HAPUS
                            ====================================================== --}}
                            <div
                                class="modal fade modal-hapus-dokumen-wrapper"
                                id="hapusModal{{ $dokumen->id }}"
                                tabindex="-1"
                                aria-labelledby="hapusModalLabel{{ $dokumen->id }}"
                                aria-hidden="true"
                            >

                                <div class="modal-dialog modal-dialog-centered modal-hapus-dialog">

                                    <div class="modal-content modal-hapus-dokumen">

                                        <div class="modal-hapus-top">

                                            <div class="modal-hapus-icon">

                                                <i class="bi bi-trash3-fill"></i>

                                            </div>

                                        </div>


                                        <div class="modal-body modal-hapus-body">

                                            <h5
                                                class="modal-hapus-title"
                                                id="hapusModalLabel{{ $dokumen->id }}"
                                            >
                                                Hapus Dokumen?
                                            </h5>


                                            <p class="modal-hapus-text">

                                                Apakah kamu yakin ingin menghapus dokumen ini?

                                            </p>


                                            <div class="modal-dokumen-name">

                                                <div class="modal-dokumen-name-icon">

                                                    <i class="bi bi-file-earmark-text-fill"></i>

                                                </div>


                                                <div class="modal-dokumen-name-text">

                                                    <span class="modal-dokumen-label">
                                                        Dokumen yang akan dihapus
                                                    </span>

                                                    <strong>
                                                        {{ $dokumen->nama_dokumen }}
                                                    </strong>

                                                </div>

                                            </div>


                                            <div class="modal-hapus-info">

                                                <div class="modal-info-icon">

                                                    <i class="bi bi-info-circle-fill"></i>

                                                </div>


                                                <div class="modal-info-text">

                                                    Dokumen akan dipindahkan ke
                                                    <strong>Sampah Dokumen</strong>
                                                    dan masih dapat dipulihkan kembali.

                                                </div>

                                            </div>

                                        </div>


                                        <div class="modal-hapus-footer">

                                            <button
                                                type="button"
                                                class="btn-modal-batal"
                                                data-bs-dismiss="modal"
                                            >
                                                Batal
                                            </button>


                                            <form
                                                method="POST"
                                                action="{{ route('dokumen.destroy', $dokumen) }}"
                                                class="modal-hapus-form"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-modal-hapus"
                                                >

                                                    <i class="bi bi-trash3-fill"></i>

                                                    Ya, Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

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

        {{-- KIRI --}}
        <div class="dokumen-pagination-left">

            {{-- JUMLAH PER HALAMAN --}}
            <select
                class="dokumen-page-size"
                onchange="ubahPerPage(this.value)"
            >

                @foreach ([10, 20, 50, 100, 200, 500, 1000] as $jumlah)

                    <option
                        value="{{ $jumlah }}"
                        {{ (int) request('perPage', 10) === $jumlah ? 'selected' : '' }}
                    >
                        {{ $jumlah }}
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
                <strong>{{ $dokumens->firstItem() ?? 0 }}</strong>
                to
                <strong>{{ $dokumens->lastItem() ?? 0 }}</strong>
                of
                <strong>{{ $dokumens->total() }}</strong>
                results

            </div>

        </div>


        {{-- KANAN --}}
        <div class="dokumen-pagination-right">

            {{ $dokumens
                ->appends(request()->query())
                ->onEachSide(1)
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



<style>

/* =========================================================
   HERO RESPONSIVE
========================================================= */

.dokumen-hero-content {

    display: flex;
    align-items: center;
    gap: 28px;
    position: relative;
    width: 100%;
    min-width: 0;

}

.dokumen-hero-text {

    flex: 1 1 auto;
    min-width: 0;

}

.dokumen-hero-text h2 {

    overflow-wrap: anywhere;

}

.dokumen-hero-text p {

    overflow-wrap: anywhere;

}

.dokumen-hero-counter {

    flex: 0 0 auto;
    min-width: 100px;

}



/* =========================================================
   FILTER UTAMA
========================================================= */

.dokumen-filter-card {

    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    overflow: hidden;

}

.dokumen-filter-form {

    display: grid;

    grid-template-columns:
        minmax(240px, 2fr)
        minmax(120px, 1fr)
        minmax(120px, 1fr)
        minmax(120px, 1fr)
        minmax(90px, auto);

    gap: 10px;

    width: 100%;
    min-width: 0;

}

.dokumen-filter-search,
.dokumen-filter-item,
.dokumen-filter-button {

    min-width: 0;
    width: 100%;

}

.dokumen-filter-search .input-group {

    width: 100%;
    min-width: 0;

}

.dokumen-filter-search .form-control,
.dokumen-filter-item .form-select {

    width: 100%;
    min-width: 0;
    max-width: 100%;
    box-sizing: border-box;

}

.dokumen-filter-button .btn {

    width: 100%;
    min-width: 0;
    white-space: nowrap;

}



/* =========================================================
   CARD TABEL
========================================================= */

.dokumen-table-card {

    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
    overflow: hidden;

}

.dokumen-table-responsive {

    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;

}

.dokumen-table {

    width: 100%;
    min-width: 900px;

}

.dokumen-table th,
.dokumen-table td {

    white-space: nowrap;

}

.dokumen-name-cell {

    min-width: 220px;
    max-width: 360px;

}

.dokumen-name-text {

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

}

.dokumen-action-buttons {

    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 5px;

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
    box-sizing: border-box;

}


/* =========================================================
   BAGIAN KIRI PAGINATION
========================================================= */

.dokumen-pagination-left {

    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
    max-width: 100%;
    flex: 1 1 auto;

}


/* =========================================================
   SELECT PER PAGE
========================================================= */

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

    min-width: 55px;

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


/* =========================================================
   LIST PAGINATION
========================================================= */

.dokumen-pagination-right .pagination {

    display: flex !important;

    align-items: center;

    flex-wrap: nowrap;

    gap: 7px;

    margin: 0 !important;

    padding: 0;

}


/* =========================================================
   ITEM PAGINATION
========================================================= */

.dokumen-pagination-right .page-item {

    display: flex;

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

    text-decoration: none;

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

    background: #1769e8 !important;
    border-color: #1769e8 !important;
    color: #ffffff !important;

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
   FILTER CONTAINER
========================================================= */

.dokumen-filter-card {

    container-type: inline-size;
    container-name: dokumenFilter;

}


/* =========================================================
   AREA KONTEN MULAI SEMPIT
========================================================= */

@container dokumenFilter (max-width: 950px) {

    .dokumen-filter-form {

        grid-template-columns:
            minmax(0, 2fr)
            minmax(120px, 1fr)
            minmax(120px, 1fr);

    }

    .dokumen-filter-search {

        grid-column: span 2;

    }

}


/* =========================================================
   SPLIT SCREEN FILTER
========================================================= */

@container dokumenFilter (max-width: 700px) {

    .dokumen-filter-form {

        grid-template-columns:
            minmax(0, 1fr)
            minmax(0, 1fr);

        gap: 10px;

    }

    .dokumen-filter-search {

        grid-column: span 2;

    }

    .dokumen-filter-item,
    .dokumen-filter-button {

        width: 100%;

    }

    .dokumen-filter-button .btn {

        width: 100%;

    }

}


/* =========================================================
   LAYAR SANGAT KECIL FILTER
========================================================= */

@container dokumenFilter (max-width: 430px) {

    .dokumen-filter-form {

        grid-template-columns: 1fr;

    }

    .dokumen-filter-search {

        grid-column: span 1;

    }

}



/* =========================================================
   RESPONSIVE PAGINATION
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
   SPLIT SCREEN
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
   HERO LAYAR KECIL
========================================================= */

@media (max-width: 768px) {

    .dokumen-hero-content {

        flex-wrap: wrap;
        gap: 18px;

    }

    .dokumen-hero-text {

        flex: 1 1 calc(100% - 120px);

    }

    .dokumen-hero-counter {

        width: 100%;
        text-align: left !important;
        padding-left: 5px;

    }

}


@media (max-width: 576px) {

    .dokumen-hero-content {

        display: flex;
        flex-direction: column;
        align-items: flex-start;

    }

    .dokumen-hero-text {

        width: 100%;

    }

    .dokumen-hero-counter {

        width: 100%;
        text-align: center !important;

    }

    .dokumen-hero-text h2 {

        font-size: 24px;

    }

    .dokumen-hero-text p {

        font-size: 14px;

    }

}



/* =========================================================
   MODAL HAPUS
========================================================= */

.modal-hapus-dokumen-wrapper {

    z-index: 1060 !important;

}


.modal-hapus-dialog {

    max-width: 480px !important;
    width: calc(100% - 30px);
    margin: 1.75rem auto;

}


.modal-hapus-dokumen {

    position: relative;

    width: 100%;

    border: none !important;

    border-radius: 20px !important;

    overflow: hidden;

    background: #ffffff !important;

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.30) !important;

    opacity: 1 !important;

    color: #1f2937 !important;

}


.modal-hapus-top {

    padding-top: 28px;
    padding-bottom: 4px;

    display: flex;
    justify-content: center;
    align-items: center;

    background: #ffffff !important;

}


.modal-hapus-icon {

    width: 70px;
    height: 70px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #fff1f2 !important;

    border: 1px solid #fecdd3 !important;

    color: #dc3545 !important;

    font-size: 28px;

}


.modal-hapus-icon i {

    color: #dc3545 !important;

}


.modal-hapus-body {

    padding: 18px 34px 24px !important;

    background: #ffffff !important;

    text-align: center;

}


.modal-hapus-title {

    margin: 0 0 9px !important;

    color: #172033 !important;

    font-size: 22px !important;

    font-weight: 700 !important;

}


.modal-hapus-text {

    margin: 0 auto 20px !important;

    max-width: 390px;

    color: #64748b !important;

    font-size: 14px !important;

    line-height: 1.6 !important;

}


.modal-dokumen-name {

    display: flex;
    align-items: center;

    gap: 12px;

    width: 100%;

    padding: 13px 15px;

    margin: 0 auto 14px;

    text-align: left;

    background: #f8fafc !important;

    border: 1px solid #e2e8f0 !important;

    border-radius: 12px !important;

    box-sizing: border-box;

}


.modal-dokumen-name-icon {

    width: 40px;
    height: 40px;

    flex: 0 0 40px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #fff1f2 !important;

    color: #dc3545 !important;

    font-size: 18px;

}


.modal-dokumen-name-text {

    min-width: 0;

    display: flex;
    flex-direction: column;

    gap: 3px;

}


.modal-dokumen-label {

    color: #94a3b8 !important;

    font-size: 11px !important;

    font-weight: 600 !important;

    text-transform: uppercase;

    letter-spacing: .04em;

}


.modal-dokumen-name-text strong {

    display: block;

    max-width: 330px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #1e293b !important;

    font-size: 14px !important;

}


.modal-hapus-info {

    display: flex;
    align-items: flex-start;

    gap: 10px;

    width: 100%;

    padding: 12px 14px;

    box-sizing: border-box;

    text-align: left;

    background: #eff6ff !important;

    border: 1px solid #dbeafe !important;

    border-radius: 11px !important;

}


.modal-info-icon {

    width: 20px;
    height: 20px;

    flex: 0 0 20px;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #2563eb !important;

}


.modal-info-text {

    color: #64748b !important;

    font-size: 12.5px !important;

    line-height: 1.5 !important;

}


.modal-info-text strong {

    color: #334155 !important;

}


.modal-hapus-footer {

    display: flex;

    align-items: center;
    justify-content: flex-end;

    gap: 10px;

    padding: 16px 24px 20px;

    background: #ffffff !important;

    border-top: 1px solid #eef2f7 !important;

}


.modal-hapus-form {

    display: inline-flex;

    margin: 0;

}


.btn-modal-batal {

    height: 42px;

    min-width: 92px;

    padding: 0 18px;

    border: 1px solid #d1d5db !important;

    border-radius: 9px !important;

    background: #ffffff !important;

    color: #475569 !important;

    font-size: 14px !important;

    font-weight: 600 !important;

    cursor: pointer;

}


.btn-modal-hapus {

    height: 42px;

    min-width: 125px;

    padding: 0 20px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    border: none !important;

    border-radius: 9px !important;

    background: #dc3545 !important;

    color: #ffffff !important;

    font-size: 14px !important;

    font-weight: 600 !important;

    cursor: pointer;

}


.btn-modal-hapus i {

    color: #ffffff !important;

}


@media (max-width: 576px) {

    .modal-hapus-dialog {

        width: calc(100% - 20px);
        max-width: none !important;

    }

    .modal-hapus-body {

        padding: 16px 20px 20px !important;

    }

    .modal-hapus-footer {

        padding: 14px 20px 18px;

    }

    .modal-dokumen-name-text strong {

        max-width: 230px;

    }

}



/* =========================================================
   DARK MODE PAGINATION
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

    color: #ffffff;

}


body.dark-mode .dokumen-pagination-right
.page-item.active .page-link {

    background: #1769e8 !important;

    border-color: #1769e8 !important;

    color: #ffffff !important;

}


body.dark-mode .dokumen-pagination-right
.page-item.disabled .page-link {

    background: #182334;

    border-color: #344256;

    color: #5f6d80;

}

</style>



@push('scripts')

<script>

/* =========================================================
   PAGINATION
========================================================= */

function ubahPerPage(value) {

    const url = new URL(window.location.href);

    url.searchParams.set('perPage', value);

    // kembali ke halaman 1
    url.searchParams.set('page', 1);

    window.location.href = url.toString();

}



/* =========================================================
   ANIMASI COUNTER
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const counter =
        document.querySelector('.dokumen-hero-counter-number');

    if (!counter) return;


    const target =
        parseInt(counter.dataset.count, 10) || 0;

    const duration = 1000;

    const startTime = performance.now();


    function animate(currentTime) {

        const elapsed =
            currentTime - startTime;

        const progress =
            Math.min(elapsed / duration, 1);

        const eased =
            1 - Math.pow(1 - progress, 3);


        counter.textContent =
            Math.floor(eased * target);


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