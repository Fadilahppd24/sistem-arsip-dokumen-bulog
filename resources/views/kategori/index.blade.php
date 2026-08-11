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

    background: linear-gradient(
        110deg,
        #e8f1ff 0%,
        #dceaff 48%,
        #edf5ff 100%
    );

    overflow: hidden;
}


/* =========================================================
   GARIS OREN DI PALING ATAS
========================================================= */

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


/* =========================================================
   BULATAN BESAR BACKGROUND KANAN
========================================================= */

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


/* =========================================================
   SPARKLE
========================================================= */

.kategori-sparkle {

    position: absolute;

    color: rgba(255,255,255,.85);

    pointer-events: none;

    z-index: 2;

    animation: kategoriSparkle 3s ease-in-out infinite;
}


.kategori-sparkle-1 {

    right: 28%;

    top: 23px;

    font-size: 14px;

    animation-delay: 0s;
}


.kategori-sparkle-2 {

    right: 40%;

    bottom: 25px;

    font-size: 9px;

    animation-delay: .8s;
}


.kategori-sparkle-3 {

    right: 54%;

    top: 38px;

    font-size: 7px;

    animation-delay: 1.5s;
}


.kategori-sparkle-4 {

    right: 22%;

    bottom: 38px;

    font-size: 10px;

    animation-delay: 2s;
}


@keyframes kategoriSparkle {

    0%,
    100% {

        opacity: .25;

        transform: scale(.75);

    }

    50% {

        opacity: 1;

        transform: scale(1.25);

    }

}


/* =========================================================
   ICON HERO
========================================================= */

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

    box-shadow:
        0 7px 18px rgba(29,78,216,.15);
}


/* =========================================================
   RADAR / GELOMBANG 1
========================================================= */

.kategori-hero-icon::before {

    content: "";

    position: absolute;

    inset: 0;

    border-radius: 50%;

    border: 2px solid rgba(37,99,235,.48);

    animation:
        kategoriRadar 2.8s ease-out infinite;

    pointer-events: none;
}


/* =========================================================
   RADAR / GELOMBANG 2
========================================================= */

.kategori-hero-icon::after {

    content: "";

    position: absolute;

    inset: 0;

    border-radius: 50%;

    border: 2px solid rgba(37,99,235,.32);

    animation:
        kategoriRadar 2.8s ease-out infinite;

    animation-delay: 1.4s;

    pointer-events: none;
}


/* =========================================================
   ANIMASI RADAR
========================================================= */

@keyframes kategoriRadar {

    0% {

        transform: scale(.85);

        opacity: .85;

    }

    60% {

        transform: scale(1.35);

        opacity: .28;

    }

    100% {

        transform: scale(1.75);

        opacity: 0;

    }

}


/* =========================================================
   LINGKARAN ICON DALAM
========================================================= */

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

    box-shadow:
        0 5px 15px rgba(29,78,216,.25),
        inset 0 0 0 2px rgba(255,255,255,.18);
}


/* =========================================================
   TITIK SINYAL / KELAP-KELIP
========================================================= */

.kategori-signal-dot {

    position: absolute;

    z-index: 8;

    display: block;

    border-radius: 50%;

    background: white;

    box-shadow:
        0 0 8px rgba(255,255,255,.95);

    pointer-events: none;

    animation:
        kategoriSignalBlink 1.8s ease-in-out infinite;
}


/* TITIK 1 */

.kategori-signal-dot.dot-1 {

    width: 7px;
    height: 7px;

    top: 3px;
    right: 15px;

    animation-delay: 0s;
}


/* TITIK 2 */

.kategori-signal-dot.dot-2 {

    width: 5px;
    height: 5px;

    bottom: 10px;
    left: 7px;

    animation-delay: .6s;
}


/* TITIK 3 */

.kategori-signal-dot.dot-3 {

    width: 4px;
    height: 4px;

    top: 19px;
    left: 1px;

    animation-delay: 1.1s;
}


/* TITIK 4 */

.kategori-signal-dot.dot-4 {

    width: 5px;
    height: 5px;

    right: 2px;
    bottom: 22px;

    animation-delay: 1.5s;
}


/* =========================================================
   ANIMASI TITIK
========================================================= */

@keyframes kategoriSignalBlink {

    0%,
    100% {

        opacity: .25;

        transform: scale(.7);

    }

    50% {

        opacity: 1;

        transform: scale(1.35);

    }

}


/* =========================================================
   JUDUL HERO
========================================================= */

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


/* =========================================================
   STATISTIK HERO
========================================================= */

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


/* =========================================================
   BUTTON HERO
========================================================= */

.kategori-hero-action {

    position: relative;

    z-index: 5;
}


.kategori-hero-action .btn {

    border-radius: 9px;

    font-weight: 600;

    box-shadow:
        0 5px 12px rgba(29,78,216,.15);
}


/* =========================================================
   ICON TABLE KATEGORI
========================================================= */

.kategori-icon-box {

    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 11px;

    font-size: 18px;
}


/* =========================================================
   WARNA ICON
========================================================= */

.kategori-primary {

    background: #e8f0ff;
    color: #1d4ed8;
}


.kategori-warning {

    background: #fff3d6;
    color: #f59e0b;
}


.kategori-info {

    background: #e2f3ff;
    color: #38a5e5;
}


.kategori-secondary {

    background: #edf0f3;
    color: #6b7280;
}


.kategori-success {

    background: #e3f7eb;
    color: #198754;
}


.kategori-danger {

    background: #ffe5e8;
    color: #dc3545;
}


.kategori-purple {

    background: #f0e7ff;
    color: #7c3aed;
}


.kategori-pink {

    background: #ffe5f0;
    color: #ec4899;
}


.kategori-teal {

    background: #e1f7f5;
    color: #0f766e;
}


.kategori-orange {

    background: #fff0df;
    color: #ea580c;
}


.kategori-indigo {

    background: #e8e9ff;
    color: #4f46e5;
}


.kategori-cyan {

    background: #dff8ff;
    color: #0891b2;
}


/* =========================================================
   WARNA DOT
========================================================= */

.warna-kategori {

    display: flex;

    align-items: center;

    gap: 8px;
}


.warna-dot {

    width: 10px;
    height: 10px;

    display: inline-block;

    border-radius: 50%;
}


.warna-navy {
    background: #1d4ed8;
}


.warna-kuning {
    background: #f5b400;
}


.warna-biru-muda {
    background: #60b5ee;
}


.warna-abu {
    background: #8b96a3;
}


.warna-hijau {
    background: #22a05a;
}


.warna-merah {
    background: #ef4444;
}


.warna-ungu {
    background: #8b5cf6;
}


.warna-pink {
    background: #ec4899;
}


.warna-teal {
    background: #0f766e;
}


.warna-orange {
    background: #f97316;
}


.warna-indigo {
    background: #4f46e5;
}


.warna-cyan {
    background: #06b6d4;
}



/* ================= DARK MODE KATEGORI ================= */

body.dark-mode .kategori-hero {
    border-color:#334155;
    background:linear-gradient(110deg,#202b3d 0%,#263449 48%,#202b3d 100%);
}
body.dark-mode .kategori-hero::after { background:rgba(148,163,184,.16); }
body.dark-mode .kategori-hero h2 { color:#f8fafc !important; }
body.dark-mode .kategori-hero p { color:#9fb0c7 !important; }
body.dark-mode .kategori-hero-number { color:#60a5fa; }
body.dark-mode .kategori-hero-label { color:#91a1b7; }

body.dark-mode .kategori-hero-icon {
    background:#243b5b;
    box-shadow:0 7px 18px rgba(0,0,0,.25);
}

body.dark-mode .card,
body.dark-mode .card-body {
    background:#1f2b3d;
    color:#e5edf7;
    border-color:#334155;
}

body.dark-mode .nav-tabs { border-color:#334155 !important; }
body.dark-mode .nav-tabs .nav-link {
    color:#9fb0c7;
    background:transparent;
    border-color:transparent;
}
body.dark-mode .nav-tabs .nav-link.active {
    color:#f8fafc;
    background:#1f2b3d;
    border-color:#334155 #334155 #1f2b3d;
}

body.dark-mode .input-group-text,
body.dark-mode .form-control,
body.dark-mode .form-select {
    background:#111827 !important;
    border-color:#334155 !important;
    color:#e5edf7 !important;
}
body.dark-mode .form-control::placeholder { color:#718096 !important; }
body.dark-mode .form-select { color-scheme:dark; }
body.dark-mode .form-select option {
    background:#111827;
    color:#e5edf7;
}

body.dark-mode .table {
    --bs-table-bg:#1f2b3d;
    --bs-table-color:#e5edf7;
    --bs-table-border-color:#334155;
    color:#e5edf7;
    background:#1f2b3d;
}
body.dark-mode .table > :not(caption) > * > * {
    background:#1f2b3d;
    color:#e5edf7;
    border-bottom-color:#334155;
}
body.dark-mode .table thead,
body.dark-mode .table-light,
body.dark-mode .table-light > * {
    background:#111827 !important;
    color:#aebed2 !important;
}
body.dark-mode .table-hover > tbody > tr:hover > * {
    background:#263449 !important;
    color:#f8fafc;
}
body.dark-mode .table .text-muted,
body.dark-mode .table small.text-muted {
    color:#91a1b7 !important;
}

body.dark-mode .fw-semibold { color:#f1f5f9; }
body.dark-mode .warna-label { color:#e5edf7; }

body.dark-mode .badge.bg-light {
    background:#334155 !important;
    color:#e5edf7 !important;
    border-color:#475569 !important;
}
body.dark-mode .badge.bg-success-subtle {
    background:rgba(34,160,90,.18) !important;
    color:#6ee7a0 !important;
    border-color:rgba(34,160,90,.35) !important;
}

body.dark-mode .btn-light {
    background:#263449 !important;
    border-color:#475569 !important;
    color:#e5edf7 !important;
}
body.dark-mode .btn-light:hover {
    background:#334155 !important;
    color:#fff !important;
}

body.dark-mode .btn-outline-success { color:#4ade80; border-color:#22c55e; }
body.dark-mode .btn-outline-success:hover { background:#22c55e; color:#0f172a; }
body.dark-mode .btn-outline-danger { color:#f87171; border-color:#ef4444; }
body.dark-mode .btn-outline-danger:hover { background:#ef4444; color:#fff; }

body.dark-mode .border-top,
body.dark-mode .border-bottom { border-color:#334155 !important; }

body.dark-mode .alert-info {
    background:rgba(37,99,235,.14) !important;
    color:#bfdbfe !important;
    border:1px solid rgba(96,165,250,.22) !important;
}
body.dark-mode .alert-info .small { color:#9fb0c7 !important; }

body.dark-mode .alert-success {
    background:rgba(34,160,90,.15) !important;
    color:#86efac !important;
}
body.dark-mode .alert-danger {
    background:rgba(220,53,69,.15) !important;
    color:#fca5a5 !important;
}

body.dark-mode .modal-content,
body.dark-mode .confirm-modal {
    background:#1f2b3d;
    color:#e5edf7;
    border:1px solid #334155 !important;
}
body.dark-mode .modal-header,
body.dark-mode .modal-footer { border-color:#334155; }
body.dark-mode .modal-title,
body.dark-mode .modal-content .form-label { color:#f8fafc; }
body.dark-mode .modal-content .text-muted { color:#94a3b8 !important; }
body.dark-mode .modal-content .bg-light {
    background:#111827 !important;
    color:#94a3b8 !important;
    border-color:#334155 !important;
}
body.dark-mode .modal-content .btn-close {
    filter:invert(1) grayscale(100%) brightness(200%);
}

body.dark-mode .confirm-warning {
    background:#2b3342 !important;
    color:#cbd5e1;
    border-color:#475569 !important;
}

body.dark-mode .container-fluid > .mb-4 .text-muted {
    color:#94a3b8 !important;
}
body.dark-mode .container-fluid > .mb-4 a {
    color:#60a5fa !important;
}

body.dark-mode .text-center.py-5.text-muted {
    color:#94a3b8 !important;
}

body.dark-mode .kategori-icon-box.kategori-primary { background:rgba(29,78,216,.18); }
body.dark-mode .kategori-icon-box.kategori-warning { background:rgba(245,158,11,.16); }
body.dark-mode .kategori-icon-box.kategori-info { background:rgba(56,165,229,.16); }
body.dark-mode .kategori-icon-box.kategori-secondary { background:rgba(107,114,128,.18); }
body.dark-mode .kategori-icon-box.kategori-success { background:rgba(25,135,84,.18); }
body.dark-mode .kategori-icon-box.kategori-danger { background:rgba(220,53,69,.18); }
body.dark-mode .kategori-icon-box.kategori-purple { background:rgba(124,58,237,.18); }
body.dark-mode .kategori-icon-box.kategori-pink { background:rgba(236,72,153,.18); }
body.dark-mode .kategori-icon-box.kategori-teal { background:rgba(15,118,110,.18); }
body.dark-mode .kategori-icon-box.kategori-orange { background:rgba(234,88,12,.18); }
body.dark-mode .kategori-icon-box.kategori-indigo { background:rgba(79,70,229,.18); }
body.dark-mode .kategori-icon-box.kategori-cyan { background:rgba(8,145,178,.18); }

body.dark-mode .d-inline-flex .btn.btn-light.border {
    background:#263449 !important;
    border-color:#475569 !important;
}
body.dark-mode .d-inline-flex .btn.btn-light.border i { color:#dbeafe; }
body.dark-mode .d-inline-flex .btn.btn-light.border.text-danger i { color:#f87171; }


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .kategori-hero {

        flex-wrap: wrap;

        padding: 22px;

    }


    .kategori-hero-stat {

        text-align: left;

    }

}


@media (max-width: 576px) {

    .kategori-hero {

        gap: 15px;

    }


    .kategori-hero-icon {

        width: 72px;
        height: 72px;

    }


    .kategori-hero-icon-inner {

        width: 60px;
        height: 60px;

        font-size: 26px;

    }


    .kategori-hero h2 {

        font-size: 24px;

    }

}

</style>



<div class="container-fluid px-0">


{{-- =========================================================
     BREADCRUMB + HERO
========================================================= --}}

<div class="mb-4">


    {{-- BREADCRUMB --}}

    <div class="d-flex align-items-center gap-2 mb-3 small">

        <a
            href="{{ route('dashboard') }}"
            class="text-decoration-none"
            style="color:#1d4ed8;"
        >

            Beranda

        </a>


        <span class="text-muted">
            >
        </span>


        <span class="text-muted">

            Kelola Kategori

        </span>

    </div>



    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="kategori-hero">


        {{-- SPARKLE --}}

        <span class="kategori-sparkle kategori-sparkle-1">
            ✦
        </span>

        <span class="kategori-sparkle kategori-sparkle-2">
            ✦
        </span>

        <span class="kategori-sparkle kategori-sparkle-3">
            ✦
        </span>

        <span class="kategori-sparkle kategori-sparkle-4">
            ✦
        </span>



        {{-- =================================================
             ICON DENGAN RADAR
        ================================================== --}}

        <div class="kategori-hero-icon">


            {{-- TITIK KELAP-KELIP --}}

            <span
                class="kategori-signal-dot dot-1"
            ></span>

            <span
                class="kategori-signal-dot dot-2"
            ></span>

            <span
                class="kategori-signal-dot dot-3"
            ></span>

            <span
                class="kategori-signal-dot dot-4"
            ></span>



            {{-- ICON --}}

            <div class="kategori-hero-icon-inner">

                <i class="bi bi-folder-fill"></i>

            </div>

        </div>



        {{-- =================================================
             JUDUL + DESKRIPSI
        ================================================== --}}

        <div class="flex-grow-1">


            <h2 class="fw-bold">

                Kelola Kategori

            </h2>


            <p>

                Kelola dan atur kategori dokumen sistem dengan mudah.

            </p>

        </div>



        {{-- =================================================
             JUMLAH KATEGORI
        ================================================== --}}

        <div class="kategori-hero-stat">


           <div
    class="kategori-hero-number"
    data-count="{{ $kategoris->count() }}"
>
    0
</div>


            <div class="kategori-hero-label">

                KATEGORI AKTIF

            </div>

        </div>



        {{-- =================================================
             TOMBOL TAMBAH
        ================================================== --}}

        <div class="kategori-hero-action">

            <button
                type="button"
                class="btn btn-primary px-4 py-2"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahKategori"
            >

                <i class="bi bi-plus-lg me-1"></i>

                Tambah Kategori

            </button>

        </div>


    </div>

</div>



{{-- =========================================================
     ALERT SUCCESS
========================================================= --}}

@if (session('success'))

    <div
        class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
        role="alert"
    >

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif



{{-- =========================================================
     ALERT ERROR
========================================================= --}}

@if (session('error'))

    <div
        class="alert alert-danger alert-dismissible fade show border-0 shadow-sm"
        role="alert"
    >

        <i class="bi bi-exclamation-circle-fill me-2"></i>

        {{ session('error') }}


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif



{{-- =========================================================
     VALIDATION ERROR
========================================================= --}}

@if ($errors->any())

    <div class="alert alert-danger border-0 shadow-sm">

        <strong>
            Terdapat kesalahan:
        </strong>


        <ul class="mb-0 mt-2">

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



{{-- =========================================================
     CARD UTAMA
========================================================= --}}

<div class="card border-0 shadow-sm">

    <div class="card-body p-0">


        {{-- =================================================
             TAB
        ================================================== --}}

        <div class="px-4 pt-3 border-bottom">

            <ul class="nav nav-tabs border-0">


                {{-- KATEGORI AKTIF --}}

                <li class="nav-item">

                    <button
                        class="nav-link active fw-semibold"
                        data-bs-toggle="tab"
                        data-bs-target="#kategoriAktif"
                    >

                        Kategori Aktif


                        <span class="badge bg-primary ms-1">

                            {{ $kategoris->count() }}

                        </span>

                    </button>

                </li>



                {{-- KATEGORI TERHAPUS --}}

                <li class="nav-item">

                    <button
                        class="nav-link fw-semibold"
                        data-bs-toggle="tab"
                        data-bs-target="#kategoriTerhapus"
                    >

                        Kategori Terhapus


                        <span class="badge bg-secondary ms-1">

                            {{ $kategoriTerhapus->count() }}

                        </span>

                    </button>

                </li>

            </ul>

        </div>



        <div class="tab-content">


            {{-- =================================================
                 TAB AKTIF
            ================================================== --}}

            <div
                class="tab-pane fade show active"
                id="kategoriAktif"
            >


                {{-- SEARCH + FILTER --}}

                <div class="p-4">

                    <div class="row g-2">


                        {{-- SEARCH --}}

                        <div class="col-md-6">

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="bi bi-search text-muted"></i>

                                </span>


                                <input
                                    type="text"
                                    id="searchKategori"
                                    class="form-control"
                                    placeholder="Cari kategori..."
                                >

                            </div>

                        </div>



                        {{-- FILTER WARNA --}}

                        <div class="col-md-3">

                            <select
                                id="filterWarna"
                                class="form-select"
                            >

                                <option value="">
                                    Semua Warna
                                </option>

                                <option value="primary">
                                    Navy
                                </option>

                                <option value="warning">
                                    Kuning
                                </option>

                                <option value="info">
                                    Biru Muda
                                </option>

                                <option value="secondary">
                                    Abu-abu
                                </option>

                                <option value="success">
                                    Hijau
                                </option>

                                <option value="danger">
                                    Merah
                                </option>

                                <option value="purple">
                                    Ungu
                                </option>

                                <option value="pink">
                                    Pink
                                </option>

                                <option value="teal">
                                    Teal
                                </option>

                                <option value="orange">
                                    Orange
                                </option>

                                <option value="indigo">
                                    Indigo
                                </option>

                                <option value="cyan">
                                    Cyan
                                </option>

                            </select>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                     TABLE KATEGORI
                ================================================== --}}

                <div class="table-responsive">

                    <table
                        class="table table-hover align-middle mb-0"
                        id="tabelKategori"
                    >

                        <thead class="table-light">

                            <tr class="small text-muted">


                                <th
                                    class="ps-4"
                                    style="width:70px;"
                                >
                                    No
                                </th>


                                <th style="width:90px;">
                                    Icon
                                </th>


                                <th>
                                    Nama Kategori
                                </th>


                                <th>
                                    Jumlah Dokumen
                                </th>


                                <th>
                                    Dibuat Pada
                                </th>


                                <th>
                                    Warna
                                </th>


                                <th class="text-end pe-4">
                                    Aksi
                                </th>

                            </tr>

                        </thead>



                        <tbody>


                        @forelse ($kategoris as $i => $kategori)


                            <tr
                                class="kategori-row"
                                data-nama="{{ strtolower($kategori->nama) }}"
                                data-warna="{{ $kategori->warna ?? 'secondary' }}"
                            >


                                {{-- NO --}}

                                <td class="ps-4">

                                    {{ $i + 1 }}

                                </td>



                                {{-- ICON --}}

                                <td>

                                    @php

                                        $warnaIcon = [

                                            'primary' =>
                                                'kategori-primary',

                                            'warning' =>
                                                'kategori-warning',

                                            'info' =>
                                                'kategori-info',

                                            'secondary' =>
                                                'kategori-secondary',

                                            'success' =>
                                                'kategori-success',

                                            'danger' =>
                                                'kategori-danger',

                                            'purple' =>
                                                'kategori-purple',

                                            'pink' =>
                                                'kategori-pink',

                                            'teal' =>
                                                'kategori-teal',

                                            'orange' =>
                                                'kategori-orange',

                                            'indigo' =>
                                                'kategori-indigo',

                                            'cyan' =>
                                                'kategori-cyan',

                                        ];

                                    @endphp


                                    <div
                                        class="kategori-icon-box {{ $warnaIcon[$kategori->warna] ?? 'kategori-secondary' }}"
                                    >

                                        <i
                                            class="bi {{ $kategori->icon ?? 'bi-folder-fill' }}"
                                        ></i>

                                    </div>

                                </td>



                                {{-- NAMA KATEGORI --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $kategori->nama }}

                                    </div>

                                </td>



                                {{-- JUMLAH DOKUMEN --}}

                                <td>

                                    @if ($kategori->dokumens_count > 0)

                                        <span class="badge bg-light text-dark border">

                                            {{ $kategori->dokumens_count }}

                                            dokumen

                                        </span>

                                    @else

                                        <span
                                            class="badge bg-success-subtle text-success border"
                                        >

                                            0 dokumen

                                        </span>

                                    @endif

                                </td>



                                {{-- DIBUAT PADA --}}

                                <td>

                                    <small class="text-muted">

                                        {{ $kategori->created_at?->format('d M Y H:i') }}

                                    </small>

                                </td>



                                {{-- WARNA --}}

                                <td>

                                    @php

                                        $warnaLabel = [

                                            'primary' =>
                                                'Navy',

                                            'warning' =>
                                                'Kuning',

                                            'info' =>
                                                'Biru Muda',

                                            'secondary' =>
                                                'Abu-abu',

                                            'success' =>
                                                'Hijau',

                                            'danger' =>
                                                'Merah',

                                            'purple' =>
                                                'Ungu',

                                            'pink' =>
                                                'Pink',

                                            'teal' =>
                                                'Teal',

                                            'orange' =>
                                                'Orange',

                                            'indigo' =>
                                                'Indigo',

                                            'cyan' =>
                                                'Cyan',

                                        ];


                                        $warnaClass = [

                                            'primary' =>
                                                'warna-navy',

                                            'warning' =>
                                                'warna-kuning',

                                            'info' =>
                                                'warna-biru-muda',

                                            'secondary' =>
                                                'warna-abu',

                                            'success' =>
                                                'warna-hijau',

                                            'danger' =>
                                                'warna-merah',

                                            'purple' =>
                                                'warna-ungu',

                                            'pink' =>
                                                'warna-pink',

                                            'teal' =>
                                                'warna-teal',

                                            'orange' =>
                                                'warna-orange',

                                            'indigo' =>
                                                'warna-indigo',

                                            'cyan' =>
                                                'warna-cyan',

                                        ];

                                    @endphp


                                    <div class="warna-kategori">

                                        <span
                                            class="warna-dot {{ $warnaClass[$kategori->warna] ?? 'warna-abu' }}"
                                        ></span>


                                        <span class="warna-label">

                                            {{ $warnaLabel[$kategori->warna] ?? 'Abu-abu' }}

                                        </span>

                                    </div>

                                </td>



{{-- AKSI --}}
<td class="text-end pe-4">

    <div class="d-inline-flex align-items-center gap-1">

        {{-- EDIT --}}
        <button type="button"
                class="btn btn-sm btn-light border"
                data-bs-toggle="modal"
                data-bs-target="#modalEdit{{ $kategori->id }}"
                title="Edit kategori">

            <i class="bi bi-pencil"></i>

        </button>


        {{-- NONAKTIFKAN --}}
        <form action="{{ route('kategori.destroy', $kategori) }}"
              method="POST"
              class="d-inline form-nonaktifkan"
              data-nama="{{ $kategori->nama }}">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-sm btn-light border text-danger"
                    title="Nonaktifkan kategori">

                <i class="bi bi-trash"></i>

            </button>

        </form>

    </div>

</td>

                            </tr>


                        @empty


                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5 text-muted"
                                >

                                    <i
                                        class="bi bi-folder-x fs-1 d-block mb-2"
                                    ></i>

                                    Belum ada kategori.

                                </td>

                            </tr>


                        @endforelse


                        </tbody>

                    </table>

                </div>



                {{-- FOOTER TABLE --}}

                <div class="px-4 py-3 border-top">

                    <small class="text-muted">

                        Menampilkan

                        {{ $kategoris->count() }}

                        kategori aktif

                    </small>

                </div>

            </div>



            {{-- =================================================
                 TAB KATEGORI TERHAPUS
            ================================================== --}}

            <div
                class="tab-pane fade"
                id="kategoriTerhapus"
            >

                <div class="p-4">


                    <div class="alert alert-info border-0">

                        <div class="d-flex align-items-start">

                            <i
                                class="bi bi-info-circle-fill me-2 mt-1"
                            ></i>


                            <div>

                                <strong>
                                    Kategori yang dinonaktifkan
                                </strong>


                                <div class="small mt-1">

                                    Kategori yang dinonaktifkan tidak dapat
                                    digunakan untuk dokumen baru, tetapi
                                    dokumen lama tetap aman.

                                    Kategori dapat dipulihkan kapan saja.

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr class="small text-muted">

                                    <th style="width:70px;">
                                        No
                                    </th>

                                    <th>
                                        Nama Kategori
                                    </th>

                                    <th>
                                        Jumlah Dokumen
                                    </th>

                                    <th>
                                        Dinonaktifkan
                                    </th>

                                    <th class="text-end">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>



                            <tbody>


                            @forelse ($kategoriTerhapus as $i => $kategori)


                                <tr>


                                    <td>

                                        {{ $i + 1 }}

                                    </td>


                                    <td>

                                        <span
                                            class="fw-semibold text-muted"
                                        >

                                            {{ $kategori->nama }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $kategori->dokumens_count }}

                                        dokumen

                                    </td>


                                    <td>

                                        <small class="text-muted">

                                            {{ $kategori->deleted_at?->format('d M Y H:i') }}

                                        </small>

                                    </td>


                                    <td class="text-end">


{{-- RESTORE --}}
<form action="{{ route('kategori.restore', $kategori->id) }}"
      method="POST"
      class="d-inline-flex">

    @csrf
    @method('PATCH')

    <button type="submit"
            class="btn btn-sm btn-outline-success action-icon-btn"
            title="Pulihkan kategori">

        <i class="bi bi-arrow-counterclockwise"></i>

    </button>

</form>

{{-- HAPUS PERMANEN --}}
<form action="{{ route('kategori.forceDelete', $kategori->id) }}"
      method="POST"
      class="d-inline form-hapus-permanen"
      data-nama="{{ $kategori->nama }}">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-outline-danger"
            title="Hapus permanen">

        <i class="bi bi-trash3"></i>

    </button>

</form>

                                    </td>

                                </tr>


                            @empty


                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center py-5 text-muted"
                                    >

                                        <i
                                            class="bi bi-check-circle fs-1 d-block mb-2"
                                        ></i>

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






   


{{-- =========================================================
     MODAL EDIT KATEGORI
========================================================= --}}

@foreach ($kategoris as $kategori)


<div
    class="modal fade"
    id="modalEdit{{ $kategori->id }}"
    tabindex="-1"
    aria-hidden="true"
>


    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Edit Kategori

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            <form
                action="{{ route('kategori.update', $kategori) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="modal-body">


                    {{-- NAMA --}}

                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >

                            Nama Kategori

                        </label>


                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="{{ $kategori->nama }}"
                            required
                        >

                    </div>



                    {{-- ICON --}}

                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >

                            Icon

                        </label>


                        <input
                            type="text"
                            name="icon"
                            class="form-control"
                            value="{{ $kategori->icon }}"
                            placeholder="Contoh: bi-folder-fill"
                        >

                    </div>



                    {{-- WARNA --}}

                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >

                            Warna

                        </label>


                        @php

                            $warnaTersedia = [

                                'primary' =>
                                    'Navy',

                                'warning' =>
                                    'Kuning',

                                'info' =>
                                    'Biru Muda',

                                'secondary' =>
                                    'Abu-abu',

                                'success' =>
                                    'Hijau',

                                'danger' =>
                                    'Merah',

                                'purple' =>
                                    'Ungu',

                                'pink' =>
                                    'Pink',

                                'teal' =>
                                    'Teal',

                                'orange' =>
                                    'Orange',

                                'indigo' =>
                                    'Indigo',

                                'cyan' =>
                                    'Cyan',

                            ];


                            $warnaTerpakai = $kategoris

                                ->where(
                                    'id',
                                    '!=',
                                    $kategori->id
                                )

                                ->pluck('warna')

                                ->filter()

                                ->toArray();

                        @endphp


                        <select
                            name="warna"
                            class="form-select"
                        >

                            @foreach (
                                $warnaTersedia
                                as $value => $label
                            )

                                <option
                                    value="{{ $value }}"
                                    {{ $kategori->warna === $value ? 'selected' : '' }}
                                    {{ in_array($value, $warnaTerpakai) ? 'disabled' : '' }}
                                >

                                    {{ $label }}


                                    @if (
                                        in_array(
                                            $value,
                                            $warnaTerpakai
                                        )
                                    )

                                        (sudah digunakan)

                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>



                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >

                        Batal

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i
                            class="bi bi-check-lg me-1"
                        ></i>

                        Simpan Perubahan

                    </button>


                </div>

            </form>

        </div>

    </div>

</div>


@endforeach



{{-- =========================================================
     MODAL TAMBAH KATEGORI
========================================================= --}}

<div
    class="modal fade"
    id="modalTambahKategori"
    tabindex="-1"
    aria-labelledby="modalTambahKategoriLabel"
    aria-hidden="true"
>


    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            <div class="modal-header">


                <h5
                    class="modal-title fw-bold"
                    id="modalTambahKategoriLabel"
                >

                    Tambah Kategori

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>


            </div>



            <form
                action="{{ route('kategori.store') }}"
                method="POST"
            >

                @csrf


                <div class="modal-body">


                    {{-- NAMA --}}

                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >

                            Nama Kategori

                        </label>


                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Masukkan nama kategori"
                            required
                        >

                    </div>



                    {{-- ICON --}}

                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >

                            Icon

                        </label>


                        <input
                            type="text"
                            name="icon"
                            class="form-control"
                            placeholder="Contoh: bi-folder-fill"
                        >

                    </div>



                    {{-- WARNA --}}

                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >

                            Warna

                        </label>


                        <div
                            class="form-control bg-light text-muted"
                        >

                            <i
                                class="bi bi-magic me-1"
                            ></i>

                            Warna akan dipilih otomatis oleh sistem

                        </div>

                    </div>

                </div>



                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >

                        Batal

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i
                            class="bi bi-check-lg me-1"
                        ></i>

                        Simpan Kategori

                    </button>


                </div>

            </form>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- MODAL KONFIRMASI --}}
{{-- ================================================= --}}

<div class="modal fade"
     id="modalKonfirmasi"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-confirm">

        <div class="modal-content confirm-modal">

            <div class="modal-body text-center p-4 p-md-5">

                {{-- ICON --}}
                <div class="confirm-icon" id="confirmIcon">
                    <i class="bi bi-exclamation-lg"></i>
                </div>

                {{-- JUDUL --}}
                <h4 class="fw-bold mb-2"
                    id="confirmTitle">
                    Konfirmasi
                </h4>

                {{-- PESAN --}}
                <p class="text-muted mb-4"
                   id="confirmMessage">
                    Apakah Anda yakin?
                </p>

                {{-- PERINGATAN --}}
                <div class="confirm-warning"
                     id="confirmWarning">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                    <span id="confirmWarningText">
                        Tindakan ini tidak dapat dibatalkan.
                    </span>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex gap-2 justify-content-center mt-4">

                    <button type="button"
                            class="btn btn-confirm-cancel"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="button"
                            class="btn btn-confirm-danger"
                            id="btnConfirmAction">

                        <i class="bi bi-trash3 me-1"></i>

                        Ya, Hapus Permanen

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



{{-- =========================================================
     JAVASCRIPT SEARCH + FILTER
========================================================= --}}

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       ANIMASI JUMLAH KATEGORI
       0 → 1 → 2 → 3 → 4
    ===================================================== */

    const kategoriCounter =
        document.querySelector('.kategori-hero-number');

    if (kategoriCounter) {

        const target = parseInt(
            kategoriCounter.dataset.count || 0,
            10
        );

        let current = 0;

        kategoriCounter.textContent = current;

        if (target > 0) {

            function countUp() {

                current++;

                kategoriCounter.textContent = current;

                if (current < target) {

                    setTimeout(countUp, 150);

                }

            }

            setTimeout(countUp, 150);
        }
    }


    /* =====================================================
       MODAL KONFIRMASI
    ===================================================== */

    const modalElement =
        document.getElementById('modalKonfirmasi');

    const modal =
        new bootstrap.Modal(modalElement);

    const confirmTitle =
        document.getElementById('confirmTitle');

    const confirmMessage =
        document.getElementById('confirmMessage');

    const confirmWarningText =
        document.getElementById('confirmWarningText');

    const confirmIcon =
        document.getElementById('confirmIcon');

    const confirmButton =
        document.getElementById('btnConfirmAction');

    let formTarget = null;


    /* NONAKTIFKAN KATEGORI */

    document.querySelectorAll('.form-nonaktifkan')
        .forEach(function (form) {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                formTarget = form;

                const nama =
                    form.dataset.nama;

                confirmTitle.textContent =
                    'Nonaktifkan kategori?';

                confirmMessage.innerHTML =
                    'Kategori <strong>' +
                    nama +
                    '</strong> akan dinonaktifkan.';

                confirmWarningText.textContent =
                    'Kategori tidak dapat digunakan untuk dokumen baru, tetapi dokumen lama tetap aman.';

                confirmIcon.innerHTML =
                    '<i class="bi bi-folder-x"></i>';

                confirmIcon.style.background =
                    '#fff7ed';

                confirmIcon.style.borderColor =
                    '#fed7aa';

                confirmIcon.style.color =
                    '#f97316';

                confirmButton.innerHTML =
                    '<i class="bi bi-folder-x me-1"></i> Ya, Nonaktifkan';

                confirmButton.style.background =
                    '#f97316';

                modal.show();

            });

        });


    /* HAPUS PERMANEN */

    document.querySelectorAll('.form-hapus-permanen')
        .forEach(function (form) {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                formTarget = form;

                confirmTitle.textContent =
                    'Hapus kategori secara permanen?';

                confirmMessage.textContent =
                    'Data kategori yang sudah dihapus tidak dapat dikembalikan.';

                confirmWarningText.textContent =
                    'Tindakan ini akan menghapus kategori secara permanen dari sistem.';

                confirmIcon.innerHTML =
                    '<i class="bi bi-trash3"></i>';

                confirmIcon.style.background =
                    '#fef2f2';

                confirmIcon.style.borderColor =
                    '#fecaca';

                confirmIcon.style.color =
                    '#dc3545';

                confirmButton.innerHTML =
                    '<i class="bi bi-trash3 me-1"></i> Ya, Hapus Permanen';

                confirmButton.style.background =
                    '#dc3545';

                modal.show();

            });

        });


    /* TOMBOL KONFIRMASI */

    confirmButton.addEventListener('click', function () {

        if (formTarget) {

            modal.hide();

            formTarget.submit();

        }

    });


    /* RESET */

    modalElement.addEventListener(
        'hidden.bs.modal',
        function () {

            formTarget = null;

        }
    );

});
</script>

@endpush