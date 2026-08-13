@extends('layouts.app')

@section('title', $kategoriAktif->nama ?? 'Kelola Dokumen')

@section('content')

<div class="sampah-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Beranda</a>

    <span>›</span>

    <span>
        {{ $kategoriAktif->nama ?? 'Kelola Dokumen' }}
    </span>
</div>

@php
    $warnaKategori = $kategoriAktif->warna ?? 'secondary';

    $jumlahDokumenKategori = $kategoriAktif
        ? $kategoriAktif->dokumens()->count()
        : $dokumens->total();
@endphp


{{-- =========================================================
     BANNER KATEGORI
========================================================= --}}

<div class="dashboard-header dashboard-header-hero mb-4">

    {{-- SPARKLE --}}
    <div class="hero-sparkles">
        <span class="sparkle s1">✦</span>
        <span class="sparkle s2">✦</span>
        <span class="sparkle s3">✦</span>
        <span class="sparkle s4">✦</span>
    </div>


    {{-- ISI BANNER --}}
    <div class="d-flex align-items-center flex-wrap gap-4 position-relative">

        {{-- ICON KATEGORI --}}
        <div class="dokumen-hero-icon-ring">

            <div class="dokumen-hero-icon kategori-icon-{{ $warnaKategori }}">
                <i class="bi {{ $kategoriAktif->icon ?? 'bi-folder-fill' }}"></i>
            </div>

        </div>


        {{-- JUDUL --}}
        <div class="flex-grow-1">

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
     INFORMASI DOKUMEN
========================================================= --}}

@php

    /*
    |--------------------------------------------------------------------------
    | Ambil dokumen terbaru pada kategori aktif
    |--------------------------------------------------------------------------
    */

    $dokumenTerbaru = $kategoriAktif
        ? $kategoriAktif->dokumens()
            ->with('uploader')
            ->latest('tanggal_dokumen')
            ->first()
        : null;

@endphp


<div class="dokumen-info-card">

    {{-- =====================================================
         JIKA ADA DOKUMEN
    ====================================================== --}}

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


    {{-- =====================================================
         JIKA BELUM ADA DOKUMEN
    ====================================================== --}}

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


    {{-- =====================================================
         BUTTON UPLOAD
    ====================================================== --}}

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

    <form method="GET" class="row g-2 align-items-center">

        @if($kategoriAktif)

            <input
                type="hidden"
                name="kategori_id"
                value="{{ $kategoriAktif->id }}"
            >

        @endif


        {{-- SEARCH --}}
        <div class="col-md-4">

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
        <div class="col-md-2">

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
        <div class="col-md-2">

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
        <div class="col-md-2">

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
        <div class="col-md-1 d-grid">

            <button
                class="btn btn-bulog"
                type="submit"
            >
                <i class="bi bi-funnel"></i>
            </button>

        </div>

    </form>

</div>



{{-- =========================================================
     TABEL DOKUMEN
========================================================= --}}

<div class="card-panel p-3">

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

                        {{-- NOMOR --}}
                        <td>
                            {{ $dokumens->firstItem() + $i }}
                        </td>


                        {{-- NAMA DOKUMEN --}}
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


                        {{-- NOMOR / KETERANGAN --}}
                        <td class="text-muted">

                            {{ $dokumen->nomor_keterangan ?? '-' }}

                        </td>


                        {{-- TANGGAL --}}
                        <td>

                            {{ $dokumen->tanggal_dokumen->format('d M Y') }}

                        </td>


                        {{-- UPLOADER --}}
                        <td>

                            {{ $dokumen->uploader->name }}

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

{{-- =========================================================
     MODAL HAPUS DOKUMEN
========================================================= --}}
<div
    class="modal fade modal-hapus-dokumen-wrapper"
    id="hapusModal{{ $dokumen->id }}"
    tabindex="-1"
    aria-labelledby="hapusModalLabel{{ $dokumen->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-hapus-dialog">

        <div class="modal-content modal-hapus-dokumen">

            {{-- ICON --}}
            <div class="modal-hapus-top">

                <div class="modal-hapus-icon">
                    <i class="bi bi-trash3-fill"></i>
                </div>

            </div>


            {{-- ISI --}}
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


                {{-- NAMA DOKUMEN --}}
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


                {{-- INFORMASI --}}
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


            {{-- FOOTER --}}
            <div class="modal-hapus-footer">

                {{-- BATAL --}}
                <button
                    type="button"
                    class="btn-modal-batal"
                    data-bs-dismiss="modal"
                >
                    Batal
                </button>


                {{-- HAPUS --}}
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


    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="text-muted small">

            Menampilkan
            {{ $dokumens->firstItem() ?? 0 }}
            hingga
            {{ $dokumens->lastItem() ?? 0 }}
            dari
            {{ $dokumens->total() }}
            data

        </div>

        {{ $dokumens->links('pagination::bootstrap-5') }}

    </div>

</div>



{{-- IFRAME DOWNLOAD --}}
<iframe
    name="downloadFrame"
    style="display:none;"
></iframe>



@push('scripts')

<script>

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

<style>
/* =========================================================
   MODAL HAPUS DOKUMEN
   MODERN / CLEAN
========================================================= */

/* BACKDROP */
.modal-hapus-dokumen-wrapper {
    z-index: 1060 !important;
}

.modal-hapus-dokumen-wrapper .modal-backdrop {
    opacity: 1;
}


/* DIALOG */
.modal-hapus-dialog {
    max-width: 480px !important;
    width: calc(100% - 30px);
    margin: 1.75rem auto;
}


/* CONTENT */
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

    transform: translateY(0);

    color: #1f2937 !important;
}


/* =========================================================
   BAGIAN ATAS
========================================================= */

.modal-hapus-top {
    padding-top: 28px;
    padding-bottom: 4px;

    display: flex;
    justify-content: center;
    align-items: center;

    background: #ffffff !important;
}


/* =========================================================
   ICON TRASH
========================================================= */

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

    box-shadow:
        0 5px 15px rgba(220, 53, 69, 0.08);
}

.modal-hapus-icon i {
    color: #dc3545 !important;
}


/* =========================================================
   BODY
========================================================= */

.modal-hapus-body {
    padding: 18px 34px 24px !important;

    background: #ffffff !important;

    text-align: center;

    color: #1f2937 !important;
}


/* =========================================================
   TITLE
========================================================= */

.modal-hapus-title {
    margin: 0 0 9px !important;

    color: #172033 !important;

    font-size: 22px !important;

    font-weight: 700 !important;

    line-height: 1.3 !important;
}


/* =========================================================
   TEXT
========================================================= */

.modal-hapus-text {
    margin: 0 auto 20px !important;

    max-width: 390px;

    color: #64748b !important;

    font-size: 14px !important;

    line-height: 1.6 !important;
}


/* =========================================================
   NAMA DOKUMEN
========================================================= */

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


/* ICON DOKUMEN */

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

.modal-dokumen-name-icon i {
    color: #dc3545 !important;
}


/* TEXT DOKUMEN */

.modal-dokumen-name-text {

    min-width: 0;

    display: flex;

    flex-direction: column;

    gap: 3px;
}


/* LABEL */

.modal-dokumen-label {

    color: #94a3b8 !important;

    font-size: 11px !important;

    font-weight: 600 !important;

    text-transform: uppercase;

    letter-spacing: 0.04em;
}


/* NAMA */

.modal-dokumen-name-text strong {

    display: block;

    max-width: 330px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #1e293b !important;

    font-size: 14px !important;

    font-weight: 700 !important;
}


/* =========================================================
   INFO BOX
========================================================= */

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


/* INFO ICON */

.modal-info-icon {

    width: 20px;
    height: 20px;

    flex: 0 0 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-top: 1px;

    color: #2563eb !important;

    font-size: 14px;
}

.modal-info-icon i {
    color: #2563eb !important;
}


/* INFO TEXT */

.modal-info-text {

    color: #64748b !important;

    font-size: 12.5px !important;

    line-height: 1.5 !important;
}

.modal-info-text strong {

    color: #334155 !important;

    font-weight: 700 !important;
}


/* =========================================================
   FOOTER
========================================================= */

.modal-hapus-footer {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;

    padding: 16px 24px 20px;

    background: #ffffff !important;

    border-top: 1px solid #eef2f7 !important;
}


/* FORM */

.modal-hapus-form {

    display: inline-flex;

    margin: 0;

    padding: 0;
}


/* =========================================================
   BUTTON BATAL
========================================================= */

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

    transition:
        background .2s ease,
        border-color .2s ease,
        color .2s ease,
        transform .2s ease;
}

.btn-modal-batal:hover {

    background: #f8fafc !important;

    border-color: #94a3b8 !important;

    color: #1e293b !important;

    transform: translateY(-1px);
}


/* =========================================================
   BUTTON HAPUS
========================================================= */

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

    box-shadow:
        0 4px 12px rgba(220, 53, 69, 0.18);

    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.btn-modal-hapus i {

    color: #ffffff !important;

    font-size: 14px;
}

.btn-modal-hapus:hover {

    background: #c82333 !important;

    color: #ffffff !important;

    transform: translateY(-1px);

    box-shadow:
        0 7px 18px rgba(220, 53, 69, 0.25);
}


/* =========================================================
   MODAL DARK MODE
   Tetap putih seperti popup hapus permanen
========================================================= */

body.dark-mode .modal-hapus-dokumen {

    background: #ffffff !important;

    color: #1f2937 !important;
}

body.dark-mode .modal-hapus-top {

    background: #ffffff !important;
}

body.dark-mode .modal-hapus-body {

    background: #ffffff !important;

    color: #1f2937 !important;
}

body.dark-mode .modal-hapus-footer {

    background: #ffffff !important;
}

body.dark-mode .modal-hapus-title {

    color: #172033 !important;
}

body.dark-mode .modal-hapus-text {

    color: #64748b !important;
}

body.dark-mode .modal-dokumen-name {

    background: #f8fafc !important;

    border-color: #e2e8f0 !important;
}

body.dark-mode .modal-dokumen-name-text strong {

    color: #1e293b !important;
}

body.dark-mode .modal-hapus-info {

    background: #eff6ff !important;

    border-color: #dbeafe !important;
}

body.dark-mode .modal-info-text {

    color: #64748b !important;
}


/* =========================================================
   ANIMASI
========================================================= */

.modal-hapus-dokumen {

    animation:
        modalHapusMasuk .22s ease-out;
}

@keyframes modalHapusMasuk {

    from {
        opacity: 0;
        transform: translateY(10px) scale(.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

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

    .btn-modal-batal,
    .btn-modal-hapus {

        min-width: 0;

        padding-left: 15px;

        padding-right: 15px;

    }

}
</style>




@endpush

@endsection