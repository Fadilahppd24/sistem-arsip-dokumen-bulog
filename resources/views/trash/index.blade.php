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


/* =========================================================
   DARK MODE - SAMPAH DOKUMEN
========================================================= */

body.dark-mode .sampah-hero {
    border-color: #385477;

    background: linear-gradient(
        110deg,
        #202d42 0%,
        #25344a 48%,
        #202d42 100%
    );

    box-shadow:
        0 8px 30px rgba(0, 0, 0, .18);
}


/* =========================================================
   BULATAN HERO DARK MODE
========================================================= */

body.dark-mode .sampah-hero::after {
    background: rgba(148, 163, 184, .18);
}


body.dark-mode .sampah-bubble {
    background: rgba(203, 213, 225, .35);
}


/* =========================================================
   ICON HERO DARK MODE
   RING SUDAH DISAMAKAN DENGAN ICON
========================================================= */

body.dark-mode .sampah-hero-icon {

    background: #1769e8;

    box-shadow:
        0 0 0 3px #29476d,
        0 0 0 5px #1769e8,
        0 7px 18px rgba(0, 0, 0, .30);
}


/*
|--------------------------------------------------------------------------
| RING ANIMASI DARK MODE
|--------------------------------------------------------------------------
| Dibuat biru, bukan putih.
*/

body.dark-mode .sampah-hero-icon::before,
body.dark-mode .sampah-hero-icon::after {

    border-color: rgba(96, 165, 250, .35);

    box-shadow:
        0 0 0 1px rgba(23, 105, 232, .15);
}


/* =========================================================
   LINGKARAN DALAM ICON DARK MODE
========================================================= */

body.dark-mode .sampah-hero-icon-inner {

    background: #1769e8;

    color: #ffffff;

    box-shadow:
        0 0 0 2px #4b8ff5,
        inset 0 0 0 2px rgba(255,255,255,.12),
        0 5px 14px rgba(23,105,232,.35);
}


/* =========================================================
   JUDUL HERO
========================================================= */

body.dark-mode .sampah-hero-content h2 {
    color: #f1f5f9;
}


body.dark-mode .sampah-hero-content p {
    color: #94a3b8;
}


/* =========================================================
   STATISTIK
========================================================= */

body.dark-mode .sampah-hero-number {
    color: #60a5fa;
}


body.dark-mode .sampah-hero-label {
    color: #94a3b8;
}


/* =========================================================
   CARD UTAMA
========================================================= */

body.dark-mode .sampah-card {

    background: #202c3f;

    border: 1px solid #34445a;

    box-shadow:
        0 8px 30px rgba(0, 0, 0, .18);
}


/* =========================================================
   INFO BAR
========================================================= */

body.dark-mode .sampah-info {

    background: #253348;

    border-bottom-color: #39495e;
}


body.dark-mode .sampah-info-icon {

    background: #29476d;

    color: #60a5fa;
}


body.dark-mode .sampah-info-title {
    color: #e5edf7;
}


body.dark-mode .sampah-info-text {
    color: #94a3b8;
}


/* =========================================================
   TABLE DARK MODE
========================================================= */

body.dark-mode .sampah-table {

    --bs-table-bg: transparent;
    --bs-table-color: #dbe4ef;
}


body.dark-mode .sampah-table thead th {

    background: #182436;

    border-bottom-color: #3b4b61;

    color: #aebbd0;
}


body.dark-mode .sampah-table tbody td {

    background: #202c3f;

    border-bottom-color: #35465b;

    color: #dbe4ef;
}


body.dark-mode .sampah-table tbody tr:hover td {

    background: #26364b;
}


/* =========================================================
   NOMOR
========================================================= */

body.dark-mode .sampah-table tbody td:first-child {
    color: #d5deea;
}


/* =========================================================
   ICON DOKUMEN
========================================================= */

body.dark-mode .sampah-dokumen-icon {

    background: #3a2930;

    color: #f87171;
}


/* =========================================================
   NAMA DOKUMEN
========================================================= */

body.dark-mode .sampah-nama-dokumen {
    color: #f1f5f9;
}


body.dark-mode .sampah-keterangan {
    color: #8fa0b5;
}


/* =========================================================
   KATEGORI
========================================================= */

body.dark-mode .sampah-kategori {

    background: #293e5d;

    color: #9bc3ff;
}


/* =========================================================
   TEXT
========================================================= */

body.dark-mode .sampah-text {
    color: #a8b6c8;
}


/* =========================================================
   TOMBOL RESTORE
========================================================= */

body.dark-mode .btn-restore {

    background: #202c3f;

    border-color: #35b779;

    color: #4ade80;
}


body.dark-mode .btn-restore:hover {

    background: #198754;

    border-color: #198754;

    color: #ffffff;
}


/* =========================================================
   TOMBOL HAPUS PERMANEN
========================================================= */

body.dark-mode .btn-hapus-permanen {

    background: #202c3f;

    border-color: #f05260;

    color: #ff6b78;
}


body.dark-mode .btn-hapus-permanen:hover {

    background: #dc3545;

    border-color: #dc3545;

    color: #ffffff;
}


/* =========================================================
   EMPTY STATE
========================================================= */

body.dark-mode .sampah-empty-icon {

    background: #293e5d;

    color: #60a5fa;
}


body.dark-mode .sampah-empty-title {
    color: #e5edf7;
}


body.dark-mode .sampah-empty-text {
    color: #8fa0b5;
}


/* =========================================================
   FOOTER TABLE
========================================================= */

body.dark-mode .sampah-table-footer {

    background: #202c3f;

    border-top-color: #35465b;
}


body.dark-mode .sampah-table-footer-text {
    color: #8fa0b5;
}


/* =========================================================
   PAGINATION
========================================================= */

body.dark-mode .pagination .page-link {

    background: #26364b;

    border-color: #43546a;

    color: #b7c4d5;
}


body.dark-mode .pagination .page-link:hover {

    background: #30435b;

    color: #ffffff;
}


body.dark-mode .pagination .page-item.active .page-link {

    background: #1769e8;

    border-color: #1769e8;

    color: #ffffff;
}


body.dark-mode .pagination .page-item.disabled .page-link {

    background: #1d293a;

    border-color: #34445a;

    color: #59687c;
}


/* =========================================================
   SWEETALERT - HAPUS PERMANEN DOKUMEN
========================================================= */

.swal-hapus-permanen {
    width: 410px !important;
    max-width: calc(100% - 28px) !important;

    border-radius: 24px !important;

    padding: 36px 32px 30px !important;

    background: #ffffff !important;

    box-shadow:
        0 30px 80px rgba(15, 23, 42, 0.28),
        0 0 0 1px rgba(15, 23, 42, 0.04) !important;

    animation: swalPopupIn .28s cubic-bezier(.34,1.56,.64,1) !important;
}


@keyframes swalPopupIn {

    from {
        opacity: 0;
        transform: scale(.92) translateY(8px);
    }

    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }

}


/* ICON WARNING */

.swal-hapus-permanen .swal2-icon.swal2-warning {

    width: 82px !important;
    height: 82px !important;

    margin: 2px auto 22px !important;

    border-width: 3px !important;
    border-color: #F5A623 !important;

    background: radial-gradient(
        circle at 35% 30%,
        #FEF6E7,
        #FCE4B8 75%
    ) !important;

    box-shadow:
        0 12px 26px rgba(245, 166, 35, .25),
        inset 0 -3px 8px rgba(224, 148, 15, .12) !important;

    animation: swalIconPop .35s cubic-bezier(.34,1.56,.64,1) .05s both !important;

}


.swal-hapus-permanen .swal2-icon.swal2-warning .swal2-icon-content {

    color: #E0940F !important;
    font-size: 44px !important;
    font-weight: 800 !important;

}


@keyframes swalIconPop {

    from {
        opacity: 0;
        transform: scale(.5);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }

}


/* JUDUL */

.swal-hapus-title {

    margin-top: 0 !important;
    margin-bottom: 11px !important;

    font-size: 22px !important;
    font-weight: 800 !important;
    letter-spacing: -.3px;

    color: #0f172a !important;
}


/* DESKRIPSI */

.swal-hapus-text {

    margin: 0 auto !important;

    max-width: 300px;

    font-size: 14px !important;
    line-height: 1.65 !important;

    color: #64748b !important;
}


/* TOMBOL */

.swal-hapus-permanen .swal2-actions {

    width: 100%;

    display: flex !important;

    justify-content: center !important;

    gap: 12px !important;

    margin-top: 28px !important;
}


/* BATAL */

.swal-hapus-permanen .swal2-cancel {

    min-width: 110px !important;
    height: 46px !important;

    margin: 0 !important;

    padding: 0 20px !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 12px !important;

    background: #f1f5f9 !important;

    border: 1px solid #e2e8f0 !important;

    color: #475569 !important;

    font-size: 14.5px !important;
    font-weight: 600 !important;

    box-shadow: none !important;

    transition: all .18s ease !important;
}


.swal-hapus-permanen .swal2-cancel:hover {

    background: #e2e8f0 !important;

    border-color: #cbd5e1 !important;

    color: #334155 !important;
}


/* HAPUS */

.swal-hapus-permanen .swal2-confirm {

    min-width: 160px !important;
    height: 46px !important;

    margin: 0 !important;

    padding: 0 20px !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 7px !important;

    border-radius: 12px !important;

    background: linear-gradient(135deg, #ef4444, #dc2626) !important;

    color: #ffffff !important;

    font-size: 14.5px !important;
    font-weight: 700 !important;

    box-shadow: 0 8px 20px rgba(220, 38, 38, .28) !important;

    transition: all .18s ease !important;
}


.swal-hapus-permanen .swal2-confirm:hover {

    background: linear-gradient(135deg, #dc2626, #b91c1c) !important;

    transform: translateY(-1px);

    box-shadow: 0 12px 26px rgba(220, 38, 38, .35) !important;
}


.swal-hapus-permanen .swal2-confirm:active {

    transform: translateY(0);
}


/* =========================================================
   BULK ACTION BAR
========================================================= */

.bulk-action-bar {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 14px;
    padding: 14px 20px;
    margin-bottom: 18px;
}

body.dark-mode .bulk-action-bar {
    background: #1e3a5f;
    border-color: #2d5a8f;
}

.bulk-action-bar .bulk-count {
    color: #1d4ed8;
    font-weight: 700;
}

body.dark-mode .bulk-action-bar .bulk-count {
    color: #93c5fd;
}


/* =========================================================
   DARK MODE POPUP
========================================================= */

body.dark-mode .swal-hapus-permanen {

    background: #1d2939 !important;

    box-shadow:
        0 30px 80px rgba(0, 0, 0, .5),
        0 0 0 1px rgba(255, 255, 255, .05) !important;

}


body.dark-mode .swal-hapus-permanen .swal2-icon.swal2-warning {

    border-color: #f5a623 !important;

    background: radial-gradient(
        circle at 35% 30%,
        #3a2f1a,
        #2a2314 75%
    ) !important;

    box-shadow:
        0 12px 26px rgba(0, 0, 0, .35),
        inset 0 -3px 8px rgba(0, 0, 0, .2) !important;

}


body.dark-mode .swal-hapus-permanen .swal2-icon.swal2-warning .swal2-icon-content {

    color: #fbbf24 !important;

}


body.dark-mode .swal-hapus-title {

    color: #f1f5f9 !important;

}


body.dark-mode .swal-hapus-text {

    color: #94a3b8 !important;

}


body.dark-mode .swal-hapus-permanen .swal2-cancel {

    background: #26364b !important;

    border-color: #3a4b61 !important;

    color: #dbe4ef !important;
}


body.dark-mode .swal-hapus-permanen .swal2-cancel:hover {

    background: #30435b !important;

    border-color: #46586e !important;

}


body.dark-mode .swal-hapus-permanen .swal2-confirm {

    box-shadow: 0 8px 20px rgba(220, 38, 38, .4) !important;

}


body.dark-mode .swal-hapus-permanen .swal2-confirm:hover {

    box-shadow: 0 12px 26px rgba(220, 38, 38, .5) !important;

}

</style>



<div class="container-fluid px-0">


    {{-- =====================================================
         BREADCRUMB
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


        {{-- DEKORASI --}}

        <span class="sampah-bubble sampah-bubble-1"></span>

        <span class="sampah-bubble sampah-bubble-2"></span>

        <span class="sampah-bubble sampah-bubble-3"></span>

        <span class="sampah-bubble sampah-bubble-4"></span>



        {{-- ICON --}}

        <div class="sampah-hero-icon">

            <div class="sampah-hero-icon-inner">

                <i class="bi bi-trash-fill"></i>

            </div>

        </div>



        {{-- CONTENT --}}

        <div class="sampah-hero-content">

            <h2>
                Sampah Dokumen
            </h2>

            <p>
                Dokumen yang telah dihapus sementara dari sistem.
            </p>

        </div>



        {{-- JUMLAH --}}

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
         BULK ACTION BAR (muncul saat ada checkbox dicentang)
    ====================================================== --}}

    <div
        id="bulkActionBar"
        class="bulk-action-bar d-none align-items-center justify-content-between"
    >

        <div class="bulk-count">
            <span id="bulkSelectedCount">0</span> dokumen dipilih
        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                id="btnBulkCancel"
                class="btn btn-sm btn-light"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnBulkForceDelete"
                class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1"
            >
                <i class="bi bi-trash3-fill"></i>
                Hapus Permanen
            </button>

        </div>

    </div>


    {{-- FORM TERSEMBUNYI UNTUK BULK DELETE --}}

    <form
        id="formBulkForceDelete"
        action="{{ route('dokumen.bulkForceDelete') }}"
        method="POST"
        class="d-none"
    >
        @csrf
        @method('DELETE')

        <div id="bulkIdsContainer"></div>

    </form>



    {{-- =====================================================
         CARD TABEL
    ====================================================== --}}

    <div class="sampah-card">


        {{-- INFO BAR --}}

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



        {{-- TABLE --}}

        <div class="table-responsive">

            <table class="table sampah-table align-middle mb-0">

                <thead>

                    <tr>

                        <th style="width:40px;">
                            <input type="checkbox" id="checkAllDokumen" class="form-check-input">
                        </th>

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


                        {{-- CHECKBOX --}}

                        <td>

                            <input
                                type="checkbox"
                                class="form-check-input dokumen-checkbox"
                                value="{{ $dokumen->id }}"
                            >

                        </td>


                        {{-- NO --}}

                        <td>

                            {{ $dokumens->firstItem() + $i }}

                        </td>



                        {{-- NAMA DOKUMEN --}}

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



                        {{-- KATEGORI --}}

                        <td>

                            <span class="sampah-kategori">

                                {{ $dokumen->kategori->nama ?? '-' }}

                            </span>

                        </td>



                        {{-- UPLOADER --}}

                        <td>

                            <span class="sampah-text">

                                {{ $dokumen->uploader->name ?? '-' }}

                            </span>

                        </td>



                        {{-- DIHAPUS PADA --}}

                        <td>

                            <span class="sampah-text">

                                {{ $dokumen->deleted_at?->format('d M Y H:i') ?? '-' }}

                            </span>

                        </td>



                        {{-- AKSI --}}

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
                                    class="d-inline form-hapus-permanen"
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

                    {{-- EMPTY STATE --}}

                    <tr>

                        <td colspan="7">

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


<script>
document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('.form-hapus-permanen')
        .forEach(function (form) {

            form.addEventListener('submit', function (event) {

                event.preventDefault();

                Swal.fire({

                    icon: 'warning',

                    backdrop: 'rgba(15, 23, 42, 0.55)',

                    title: 'Hapus dokumen ini?',

                    html: `
                        <div>
                            Dokumen akan dihapus
                            <strong>secara permanen</strong>
                            dan tidak dapat dikembalikan.
                        </div>
                    `,

                    showCancelButton: true,

                    confirmButtonText:
                        '<i class="bi bi-trash3-fill me-1"></i> Ya, Hapus Permanen',

                    cancelButtonText:
                        'Batal',

                    reverseButtons: true,

                    focusCancel: true,

                    buttonsStyling: true,

                    customClass: {

                        popup:
                            'swal-hapus-permanen',

                        title:
                            'swal-hapus-title',

                        htmlContainer:
                            'swal-hapus-text',

                        confirmButton:
                            'swal2-confirm',

                        cancelButton:
                            'swal2-cancel'

                    }

                }).then(function (result) {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });

});
</script>


{{-- =========================================================
     BULK DELETE - CENTANG BANYAK DOKUMEN SEKALIGUS
========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkAll = document.getElementById('checkAllDokumen');
    const checkboxes = () => document.querySelectorAll('.dokumen-checkbox');
    const bulkBar = document.getElementById('bulkActionBar');
    const bulkCount = document.getElementById('bulkSelectedCount');
    const btnBulkCancel = document.getElementById('btnBulkCancel');
    const btnBulkForceDelete = document.getElementById('btnBulkForceDelete');
    const formBulk = document.getElementById('formBulkForceDelete');
    const bulkIdsContainer = document.getElementById('bulkIdsContainer');

    function updateBulkBar() {

        const checked = document.querySelectorAll('.dokumen-checkbox:checked');

        if (checked.length > 0) {
            bulkBar.classList.remove('d-none');
            bulkBar.classList.add('d-flex');
            bulkCount.textContent = checked.length;
        } else {
            bulkBar.classList.add('d-none');
            bulkBar.classList.remove('d-flex');
        }

        // Sinkronkan checkbox "pilih semua"
        if (checkAll) {
            checkAll.checked =
                checked.length > 0 &&
                checked.length === checkboxes().length;
        }
    }

    // Checkbox "pilih semua"
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            checkboxes().forEach(cb => {
                cb.checked = checkAll.checked;
            });
            updateBulkBar();
        });
    }

    // Delegasi event untuk checkbox per baris
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('dokumen-checkbox')) {
            updateBulkBar();
        }
    });

    // Tombol Batal -> uncheck semua
    if (btnBulkCancel) {
        btnBulkCancel.addEventListener('click', function () {
            checkboxes().forEach(cb => cb.checked = false);
            if (checkAll) checkAll.checked = false;
            updateBulkBar();
        });
    }

    // Tombol Hapus Permanen (bulk)
    if (btnBulkForceDelete) {
        btnBulkForceDelete.addEventListener('click', function () {

            const checked = Array.from(
                document.querySelectorAll('.dokumen-checkbox:checked')
            );

            if (checked.length === 0) {
                return;
            }

            Swal.fire({

                icon: 'warning',

                backdrop: 'rgba(15, 23, 42, 0.55)',

                title: `Hapus ${checked.length} dokumen ini?`,

                html: `
                    <div>
                        ${checked.length} dokumen akan dihapus
                        <strong>secara permanen</strong>
                        dan tidak dapat dikembalikan.
                    </div>
                `,

                showCancelButton: true,

                confirmButtonText:
                    '<i class="bi bi-trash3-fill me-1"></i> Ya, Hapus Semua',

                cancelButtonText: 'Batal',

                reverseButtons: true,

                focusCancel: true,

                customClass: {
                    popup: 'swal-hapus-permanen',
                    title: 'swal-hapus-title',
                    htmlContainer: 'swal-hapus-text',
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }

            }).then(function (result) {

                if (result.isConfirmed) {

                    // Bersihkan input id lama, isi ulang sesuai checkbox terpilih
                    bulkIdsContainer.innerHTML = '';

                    checked.forEach(function (cb) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.value;
                        bulkIdsContainer.appendChild(input);
                    });

                    formBulk.submit();
                }

            });

        });
    }

});
</script>

@endpush
@endsection