@extends('layouts.app')

@section('title', 'Sampah Dokumen')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | JUMLAH DOKUMEN DI SAMPAH
    |--------------------------------------------------------------------------
    */

    $jumlahSampah = method_exists($dokumens, 'total')
        ? $dokumens->total()
        : $dokumens->count();
@endphp


<style>

/* =========================================================
   HERO SAMPAH DOKUMEN
========================================================= */

.sampah-hero {
    position: relative;

    display: flex;
    align-items: center;

    gap: 20px;

    min-height: 120px;

    padding: 20px 28px;

    border: 1px solid #8bbcff;

    border-radius: 18px;

    background: linear-gradient(
        110deg,
        #e8f1ff 0%,
        #dceaff 48%,
        #edf5ff 100%
    );

    overflow: hidden;
}


/* =========================================================
   BULATAN BESAR KANAN
========================================================= */

.sampah-hero::after {
    content: "";

    position: absolute;

    width: 230px;
    height: 230px;

    right: 70px;
    top: -120px;

    border-radius: 50%;

    background: rgba(255,255,255,.42);

    pointer-events: none;
}


/* =========================================================
   DEKORASI BULAT
========================================================= */

.sampah-bubble {
    position: absolute;

    border-radius: 50%;

    background: rgba(255,255,255,.65);

    pointer-events: none;

    z-index: 1;

    animation: sampahBubbleFloat 5s ease-in-out infinite;
}


.sampah-bubble-1 {
    width: 8px;
    height: 8px;

    right: 36%;
    top: 28px;

    animation-delay: 0s;
}


.sampah-bubble-2 {
    width: 12px;
    height: 12px;

    right: 47%;
    bottom: 22px;

    animation-delay: 1.3s;
}


.sampah-bubble-3 {
    width: 6px;
    height: 6px;

    right: 58%;
    top: 42px;

    animation-delay: 2.2s;
}


.sampah-bubble-4 {
    width: 9px;
    height: 9px;

    right: 27%;
    bottom: 25px;

    animation-delay: 3s;
}


@keyframes sampahBubbleFloat {

    0%, 100% {
        transform: translateY(0) translateX(0);
        opacity: .45;
    }

    50% {
        transform: translateY(-10px) translateX(4px);
        opacity: .9;
    }

}


/* =========================================================
   ICON HERO
   TIDAK NAIK TURUN
   ADA EFEK RING / SINYAL
========================================================= */

.sampah-hero-icon {
    position: relative;

    z-index: 3;

    width: 78px;
    height: 78px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #dbeafe;

    box-shadow:
        0 7px 18px rgba(29,78,216,.15);
}


/* =========================================================
   RING SINYAL
========================================================= */

.sampah-hero-icon::before,
.sampah-hero-icon::after {
    content: "";

    position: absolute;

    inset: -7px;

    border-radius: 50%;

    border: 2px solid rgba(37,99,235,.28);

    pointer-events: none;

    animation: sampahPulse 2.4s ease-out infinite;
}


.sampah-hero-icon::after {
    animation-delay: 1.2s;
}


@keyframes sampahPulse {

    0% {
        transform: scale(.82);
        opacity: .75;
    }

    70% {
        transform: scale(1.18);
        opacity: .18;
    }

    100% {
        transform: scale(1.28);
        opacity: 0;
    }

}


/* =========================================================
   LINGKARAN DALAM ICON
========================================================= */

.sampah-hero-icon-inner {
    position: relative;

    z-index: 2;

    width: 66px;
    height: 66px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #1769e8;

    color: white;

    font-size: 28px;

    box-shadow:
        inset 0 0 0 2px rgba(255,255,255,.15),
        0 5px 14px rgba(23,105,232,.25);
}


/* =========================================================
   HERO CONTENT
========================================================= */

.sampah-hero-content {
    position: relative;

    z-index: 3;

    flex: 1;
}


.sampah-hero-content h2 {
    margin: 0 0 5px;

    color: #102a56;

    font-size: 26px;

    font-weight: 700;
}


.sampah-hero-content p {
    margin: 0;

    color: #526987;

    font-size: 14px;
}


/* =========================================================
   STATISTIK
========================================================= */

.sampah-hero-stat {
    position: relative;

    z-index: 3;

    min-width: 120px;

    text-align: center;
}


.sampah-hero-number {
    color: #2f6fe4;

    font-size: 34px;

    line-height: 1;

    font-weight: 800;
}


.sampah-hero-label {
    margin-top: 6px;

    color: #687993;

    font-size: 10px;

    font-weight: 700;

    letter-spacing: .7px;
}


/* =========================================================
   CARD TABEL
========================================================= */

.sampah-card {
    margin-top: 24px;

    overflow: hidden;

    border: 0;

    border-radius: 18px;

    background: white;

    box-shadow:
        0 8px 30px rgba(15, 43, 83, .07);
}


/* =========================================================
   INFO BAR
========================================================= */

.sampah-info {
    display: flex;

    align-items: center;

    gap: 14px;

    padding: 18px 24px;

    border-bottom: 1px solid #edf0f4;

    background: #fbfcfe;
}


.sampah-info-icon {
    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    background: #e8f1ff;

    color: #1769e8;

    font-size: 20px;
}


.sampah-info-title {
    color: #23395d;

    font-size: 14px;

    font-weight: 700;
}


.sampah-info-text {
    margin-top: 2px;

    color: #718096;

    font-size: 12px;
}


/* =========================================================
   TABLE
========================================================= */

.sampah-table {
    margin: 0;
}


.sampah-table thead th {
    padding: 17px 16px;

    border-bottom: 1px solid #e8edf3;

    background: #fbfcfe;

    color: #596579;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: .3px;

    text-transform: uppercase;

    white-space: nowrap;
}


.sampah-table tbody td {
    padding: 18px 16px;

    border-bottom: 1px solid #edf0f4;

    vertical-align: middle;
}


.sampah-table tbody tr:last-child td {
    border-bottom: 0;
}


.sampah-table tbody tr:hover {
    background: #fafcff;
}


/* =========================================================
   ICON DOKUMEN
========================================================= */

.sampah-dokumen-icon {
    width: 42px;
    height: 42px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 11px;

    background: #fff0f0;

    color: #dc3545;

    font-size: 19px;
}


/* =========================================================
   NAMA DOKUMEN
========================================================= */

.sampah-nama-dokumen {
    color: #111827;

    font-weight: 650;

    line-height: 1.35;
}


.sampah-keterangan {
    display: block;

    margin-top: 4px;

    color: #687588;

    font-size: 12px;
}


/* =========================================================
   KATEGORI
========================================================= */

.sampah-kategori {
    display: inline-block;

    padding: 5px 10px;

    border-radius: 6px;

    background: #eef4ff;

    color: #315b9b;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   TEXT
========================================================= */

.sampah-text {
    color: #687588;

    font-size: 13px;
}


/* =========================================================
   AKSI
========================================================= */

.sampah-aksi {
    display: inline-flex;

    align-items: center;

    gap: 7px;
}


/* =========================================================
   RESTORE
========================================================= */

.btn-restore {
    height: 38px;

    padding: 0 13px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 5px;

    border: 1px solid #198754;

    border-radius: 9px;

    background: white;

    color: #198754;

    font-size: 12px;

    font-weight: 600;

    transition: .2s;
}


.btn-restore:hover {
    background: #198754;

    color: white;
}


/* =========================================================
   HAPUS PERMANEN
========================================================= */

.btn-hapus-permanen {
    height: 38px;

    padding: 0 13px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 5px;

    border: 1px solid #dc3545;

    border-radius: 9px;

    background: white;

    color: #dc3545;

    font-size: 12px;

    font-weight: 600;

    transition: .2s;
}


.btn-hapus-permanen:hover {
    background: #dc3545;

    color: white;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.sampah-empty {
    padding: 55px 20px;

    text-align: center;
}


.sampah-empty-icon {
    width: 64px;
    height: 64px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #eef4ff;

    color: #1769e8;

    font-size: 28px;
}


.sampah-empty-title {
    margin-bottom: 5px;

    color: #334155;

    font-weight: 700;
}


.sampah-empty-text {
    color: #7b8798;

    font-size: 13px;
}


/* =========================================================
   FOOTER TABLE
========================================================= */

.sampah-table-footer {
    min-height: 70px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 14px 24px;

    border-top: 1px solid #edf0f4;
}


.sampah-table-footer-text {
    color: #687588;

    font-size: 13px;
}


/* =========================================================
   PAGINATION
========================================================= */

.pagination {
    margin: 0;

    gap: 5px;
}


.pagination .page-link {
    min-width: 38px;
    height: 38px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px !important;

    border: 1px solid #e1e7ef;

    color: #5d6b7d;

    background: white;
}


.pagination .page-item.active .page-link {
    background: #1769e8;

    border-color: #1769e8;

    color: white;
}


.pagination .page-link:hover {
    background: #f3f7fc;
}


.pagination .page-item.disabled .page-link {
    color: #c4ccd6;

    background: white;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .sampah-hero {
        flex-wrap: wrap;

        padding: 22px;
    }


    .sampah-hero-stat {
        width: 100%;

        text-align: left;
    }


    .sampah-table {
        min-width: 950px;
    }


    .sampah-table-footer {
        flex-direction: column;

        gap: 15px;

        align-items: flex-start;
    }

}

</style>



<div class="container-fluid px-0">


    {{-- =====================================================
         BREADCRUMB
         JUDUL BESAR DI ATAS SUDAH DIHAPUS
    ====================================================== --}}

    <div class="d-flex align-items-center gap-2 mb-3 small">

        <a href="{{ route('dashboard') }}"
           class="text-decoration-none"
           style="color:#1d4ed8;">

            Beranda

        </a>


        <span class="text-muted">
            >
        </span>


        <span class="text-muted">

            Sampah Dokumen

        </span>

    </div>



    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="sampah-hero">


        {{-- =================================================
             DEKORASI BULAT
        ================================================== --}}

        <span class="sampah-bubble sampah-bubble-1"></span>

        <span class="sampah-bubble sampah-bubble-2"></span>

        <span class="sampah-bubble sampah-bubble-3"></span>

        <span class="sampah-bubble sampah-bubble-4"></span>



        {{-- =================================================
             ICON
        ================================================== --}}

        <div class="sampah-hero-icon">

            <div class="sampah-hero-icon-inner">

                <i class="bi bi-trash-fill"></i>

            </div>

        </div>



        {{-- =================================================
             CONTENT
        ================================================== --}}

        <div class="sampah-hero-content">

            <h2>
                Sampah Dokumen
            </h2>

            <p>
                Dokumen yang telah dihapus sementara dari sistem.
            </p>

        </div>



        {{-- =================================================
             JUMLAH
        ================================================== --}}

        <div class="sampah-hero-stat">

            <div
                class="sampah-hero-number"
                data-count="{{ $jumlahSampah }}"
            >
                0
            </div>


            <div class="sampah-hero-label">

                DOKUMEN DI SAMPAH

            </div>

        </div>

    </div>



    {{-- =====================================================
         CARD TABEL
    ====================================================== --}}

    <div class="sampah-card">


        {{-- =================================================
             INFO BAR
        ================================================== --}}

        <div class="sampah-info">

            <div class="sampah-info-icon">

                <i class="bi bi-info-circle-fill"></i>

            </div>


            <div>

                <div class="sampah-info-title">

                    Dokumen yang dihapus sementara

                </div>


                <div class="sampah-info-text">

                    Dokumen dapat dipulihkan kembali atau
                    dihapus secara permanen.

                </div>

            </div>

        </div>



        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-responsive">

            <table class="table sampah-table align-middle mb-0">

                <thead>

                    <tr>

                        <th style="width:70px;">
                            No
                        </th>


                        <th>
                            Nama Dokumen
                        </th>


                        <th>
                            Kategori
                        </th>


                        <th>
                            Diupload Oleh
                        </th>


                        <th>
                            Dihapus Pada
                        </th>


                        <th class="text-end pe-4">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse ($dokumens as $i => $dokumen)


                    <tr>


                        {{-- =================================================
                             NO
                        ================================================== --}}

                        <td>

                            {{ $dokumens->firstItem() + $i }}

                        </td>



                        {{-- =================================================
                             NAMA DOKUMEN
                        ================================================== --}}

                        <td>

                            <div class="d-flex align-items-center">


                                <div class="sampah-dokumen-icon me-3">

                                    <i class="bi bi-file-earmark-pdf-fill"></i>

                                </div>


                                <div>

                                    <div class="sampah-nama-dokumen">

                                        {{ $dokumen->nama_dokumen }}

                                    </div>


                                    <span class="sampah-keterangan">

                                        {{ $dokumen->nomor_keterangan ?? '-' }}

                                    </span>

                                </div>

                            </div>

                        </td>



                        {{-- =================================================
                             KATEGORI
                        ================================================== --}}

                        <td>

                            <span class="sampah-kategori">

                                {{ $dokumen->kategori->nama ?? '-' }}

                            </span>

                        </td>



                        {{-- =================================================
                             UPLOADER
                        ================================================== --}}

                        <td>

                            <span class="sampah-text">

                                {{ $dokumen->uploader->name ?? '-' }}

                            </span>

                        </td>



                        {{-- =================================================
                             DIHAPUS PADA
                        ================================================== --}}

                        <td>

                            <span class="sampah-text">

                                {{ $dokumen->deleted_at?->format('d M Y H:i') ?? '-' }}

                            </span>

                        </td>



                        {{-- =================================================
                             AKSI
                        ================================================== --}}

                        <td class="text-end pe-4">

                            <div class="sampah-aksi">


                                {{-- RESTORE --}}

                                <form
                                    action="{{ route('dokumen.restore', $dokumen->id) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="btn-restore"
                                        title="Pulihkan dokumen"
                                    >

                                        <i class="bi bi-arrow-counterclockwise"></i>

                                        Restore

                                    </button>

                                </form>



                                {{-- HAPUS PERMANEN --}}

                                <form
                                    action="{{ route('dokumen.forceDelete', $dokumen->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus permanen dokumen ini? Data tidak dapat dikembalikan.')"
                                >

                                    @csrf

                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn-hapus-permanen"
                                        title="Hapus permanen"
                                    >

                                        <i class="bi bi-trash-fill"></i>

                                        Hapus Permanen

                                    </button>

                                </form>


                            </div>

                        </td>

                    </tr>


                @empty


                    {{-- =================================================
                         EMPTY STATE
                    ================================================== --}}

                    <tr>

                        <td colspan="6">

                            <div class="sampah-empty">

                                <div class="sampah-empty-icon">

                                    <i class="bi bi-trash"></i>

                                </div>


                                <div class="sampah-empty-title">

                                    Sampah Dokumen Kosong

                                </div>


                                <div class="sampah-empty-text">

                                    Tidak ada dokumen yang sedang berada di sampah.

                                </div>

                            </div>

                        </td>

                    </tr>


                @endforelse


                </tbody>

            </table>

        </div>



        {{-- =================================================
             FOOTER TABLE
        ================================================== --}}

        <div class="sampah-table-footer">


            <div class="sampah-table-footer-text">

                Menampilkan

                {{ $dokumens->firstItem() ?? 0 }}

                hingga

                {{ $dokumens->lastItem() ?? 0 }}

                dari

                {{ $dokumens->total() }}

                data

            </div>



            @if (method_exists($dokumens, 'links'))

                <div>

                    {{ $dokumens->links('pagination::bootstrap-5') }}

                </div>

            @endif


        </div>

    </div>



    {{-- =====================================================
         FOOTER WEBSITE
    ====================================================== --}}

    <div class="text-center py-4 mt-3">

        <small class="text-muted">

            © 2026 BULOG. All rights reserved.

        </small>

    </div>

</div>



{{-- =========================================================
     ANIMASI ANGKA
========================================================= --}}

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const counter = document.querySelector('.sampah-hero-number');

    if (!counter) {
        return;
    }

    // Ambil jumlah sebenarnya
    const target = Math.max(
        0,
        parseInt(counter.dataset.count, 10) || 0
    );

    // Selalu mulai dari 0
    counter.textContent = '0';

    const duration = 1000;
    const startTime = performance.now();

    function animateCounter(currentTime) {

        const elapsed = currentTime - startTime;

        const progress = Math.min(
            elapsed / duration,
            1
        );

        // Easing halus
        const eased =
            1 - Math.pow(1 - progress, 3);

        // Pastikan tidak pernah kurang dari 0
        const currentValue = Math.max(
            0,
            Math.floor(eased * target)
        );

        counter.textContent = currentValue;

        if (progress < 1) {

            requestAnimationFrame(animateCounter);

        } else {

            // Pastikan hasil akhir tepat
            counter.textContent = target;
        }
    }

    requestAnimationFrame(animateCounter);

});
</script>

@endpush

@endsection