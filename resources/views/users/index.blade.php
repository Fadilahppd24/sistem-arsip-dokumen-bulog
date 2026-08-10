@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | JUMLAH PENGGUNA AKTIF
    |--------------------------------------------------------------------------
    */

    $jumlahPengguna = method_exists($users, 'total')
        ? (int) $users->total()
        : (int) $users->count();
@endphp


<style>

/* =========================================================
   HERO KELOLA PENGGUNA
========================================================= */

.pengguna-hero {
    position: relative;
    min-height: 155px;
    padding: 28px 32px;

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
   BULATAN BESAR KANAN
========================================================= */

.pengguna-hero::after {
    content: "";

    position: absolute;

    width: 230px;
    height: 230px;

    right: 70px;
    top: -125px;

    border-radius: 50%;

    background: rgba(255,255,255,.45);

    pointer-events: none;
}


/* =========================================================
   SPARKLE
========================================================= */

.pengguna-sparkles {
    position: absolute;

    inset: 0;

    pointer-events: none;

    z-index: 1;
}


.pengguna-sparkle {
    position: absolute;

    color: rgba(255,255,255,.9);

    font-size: 14px;

    animation: sparkleFloat 4s ease-in-out infinite;
}


.pengguna-sparkle.s1 {
    left: 38%;
    top: 35px;

    animation-delay: 0s;
}


.pengguna-sparkle.s2 {
    left: 52%;
    bottom: 28px;

    font-size: 10px;

    animation-delay: 1s;
}


.pengguna-sparkle.s3 {
    right: 34%;
    top: 30px;

    font-size: 9px;

    animation-delay: 2s;
}


.pengguna-sparkle.s4 {
    right: 25%;
    bottom: 35px;

    font-size: 12px;

    animation-delay: 1.5s;
}


@keyframes sparkleFloat {

    0%, 100% {
        transform: translateY(0);
        opacity: .45;
    }

    50% {
        transform: translateY(-8px);
        opacity: 1;
    }

}


/* =========================================================
   ISI HERO
========================================================= */

.pengguna-hero-content {
    position: relative;

    z-index: 3;

    display: flex;

    align-items: center;

    gap: 24px;
}


/* =========================================================
   ICON RING
   EFEK RADAR / SINYAL
========================================================= */

.pengguna-hero-icon-ring {
    position: relative;

    width: 82px;
    height: 82px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #dbeafe;

    box-shadow:
        0 8px 20px rgba(29,78,216,.16);
}


/* =========================================================
   RADAR 1
========================================================= */

.pengguna-hero-icon-ring::before {

    content: "";

    position: absolute;

    width: 82px;
    height: 82px;

    top: 0;
    left: 0;

    border-radius: 50%;

    border: 2px solid rgba(37,99,235,.45);

    pointer-events: none;

    animation: penggunaRadar 2.8s ease-out infinite;
}


/* =========================================================
   RADAR 2
========================================================= */

.pengguna-hero-icon-ring::after {

    content: "";

    position: absolute;

    width: 82px;
    height: 82px;

    top: 0;
    left: 0;

    border-radius: 50%;

    border: 2px solid rgba(37,99,235,.32);

    pointer-events: none;

    animation: penggunaRadar 2.8s ease-out infinite;

    animation-delay: 1.4s;
}


/* =========================================================
   ANIMASI RADAR
========================================================= */

@keyframes penggunaRadar {

    0% {
        transform: scale(.85);
        opacity: .8;
    }

    65% {
        transform: scale(1.45);
        opacity: .22;
    }

    100% {
        transform: scale(1.8);
        opacity: 0;
    }

}


/* =========================================================
   ICON UTAMA
   TIDAK NAIK TURUN
========================================================= */

.pengguna-hero-icon {

    position: relative;

    z-index: 5;

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
   TITIK SINYAL
========================================================= */

.pengguna-hero-icon-ring .signal-dot {

    position: absolute;

    z-index: 7;

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: white;

    pointer-events: none;

    box-shadow:
        0 0 8px rgba(255,255,255,.95);

    animation: signalBlink 1.8s ease-in-out infinite;
}


.pengguna-hero-icon-ring .signal-dot.dot-1 {

    top: 4px;
    right: 15px;

    animation-delay: 0s;
}


.pengguna-hero-icon-ring .signal-dot.dot-2 {

    bottom: 10px;
    left: 7px;

    width: 5px;
    height: 5px;

    animation-delay: .6s;
}


.pengguna-hero-icon-ring .signal-dot.dot-3 {

    top: 20px;
    left: 1px;

    width: 4px;
    height: 4px;

    animation-delay: 1.1s;
}


/* =========================================================
   ANIMASI TITIK
========================================================= */

@keyframes signalBlink {

    0%, 100% {
        opacity: .25;
        transform: scale(.7);
    }

    50% {
        opacity: 1;
        transform: scale(1.3);
    }

}


/* =========================================================
   JUDUL HERO
========================================================= */

.pengguna-hero-text {
    flex: 1;

    position: relative;

    z-index: 3;
}


.pengguna-hero-text h2 {

    margin: 0 0 6px;

    color: #102a56;

    font-size: 29px;

    font-weight: 700;
}


.pengguna-hero-text p {

    margin: 0;

    color: #526987;

    font-size: 15px;
}


/* =========================================================
   COUNTER
========================================================= */

.pengguna-hero-counter {

    position: relative;

    z-index: 3;

    min-width: 130px;

    text-align: center;
}


.pengguna-hero-counter-number {

    color: #2f6fe4;

    font-size: 40px;

    line-height: 1;

    font-weight: 800;
}


.pengguna-hero-counter-label {

    margin-top: 7px;

    color: #687993;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: .8px;

    text-transform: uppercase;
}


/* =========================================================
   CARD PENGGUNA
========================================================= */

.pengguna-card {

    margin-top: 24px;

    overflow: hidden;

    border: 0;

    border-radius: 20px;

    background: white;

    box-shadow:
        0 8px 30px rgba(15,43,83,.07);
}


/* =========================================================
   FILTER
========================================================= */

.pengguna-filter {

    padding: 20px 24px;

    border-bottom: 1px solid #edf0f4;
}


.pengguna-filter .input-group {

    height: 48px;
}


.pengguna-filter .input-group-text {

    width: 48px;

    justify-content: center;

    border-color: #dfe5ec;

    background: white;
}


.pengguna-filter .form-control,
.pengguna-filter .form-select {

    height: 48px;

    border-color: #dfe5ec;

    box-shadow: none;
}


.pengguna-filter .form-control:focus,
.pengguna-filter .form-select:focus {

    border-color: #7da9e8;

    box-shadow:
        0 0 0 .15rem rgba(37,99,235,.08);
}


.btn-cari-pengguna {

    height: 48px;

    border: 1px solid #aeb9c8;

    background: white;

    color: #536174;

    font-weight: 500;
}


.btn-cari-pengguna:hover {

    background: #f5f8fc;

    border-color: #8796aa;
}


/* =========================================================
   TABLE
========================================================= */

.pengguna-table {

    margin: 0;
}


.pengguna-table thead th {

    padding: 16px;

    border-bottom: 1px solid #e8edf3;

    background: #fbfcfe;

    color: #596579;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: .3px;

    text-transform: uppercase;

    white-space: nowrap;
}


.pengguna-table tbody td {

    padding: 18px 16px;

    border-bottom: 1px solid #edf0f4;

    vertical-align: middle;
}


.pengguna-table tbody tr:last-child td {

    border-bottom: 0;
}


.pengguna-table tbody tr:hover {

    background: #fafcff;
}


/* =========================================================
   NOMOR
========================================================= */

.nomor-pengguna {

    color: #536174;

    font-size: 14px;
}


/* =========================================================
   AVATAR
========================================================= */

.avatar-circle-pengguna {

    width: 44px;
    height: 44px;

    min-width: 44px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #16458f;

    color: white;

    font-size: 16px;

    font-weight: 700;

    box-shadow:
        0 4px 10px rgba(16,64,130,.18);

    transition: .25s;
}


.pengguna-table tbody tr:hover
.avatar-circle-pengguna {

    transform: translateY(-2px);

    box-shadow:
        0 7px 15px rgba(16,64,130,.22);
}


/* =========================================================
   NAMA
========================================================= */

.nama-pengguna {

    color: #111827;

    font-weight: 650;
}


.email-pengguna {

    color: #687588;
}


/* =========================================================
   ROLE
========================================================= */

.badge-role-admin {

    display: inline-block;

    padding: 5px 10px;

    border-radius: 6px;

    background: #123d7c;

    color: white;

    font-size: 11px;

    font-weight: 600;
}


.badge-role-user {

    display: inline-block;

    padding: 5px 10px;

    border-radius: 6px;

    background: #6b7280;

    color: white;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   BADGE ANDA
========================================================= */

.badge-anda {

    margin-left: 6px;

    padding: 4px 8px;

    border-radius: 5px;

    background: #d9f5e5;

    color: #198754;

    font-size: 10px;

    font-weight: 700;
}


/* =========================================================
   TOMBOL AKSI
========================================================= */

.btn-aksi-pengguna {

    width: 38px;
    height: 38px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border: 1px solid #e0e6ed;

    border-radius: 9px;

    background: white;

    color: #26384f;

    transition: .2s;
}


.btn-aksi-pengguna:hover {

    background: #f5f8fc;

    border-color: #c9d3df;

    transform: translateY(-1px);
}


.btn-aksi-hapus {

    color: #ef4444;
}


.btn-aksi-hapus:hover {

    color: #dc2626;

    background: #fff5f5;

    border-color: #fecaca;
}


/* =========================================================
   FOOTER TABLE
========================================================= */

.pengguna-table-footer {

    min-height: 70px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 14px 24px;

    border-top: 1px solid #edf0f4;
}


/* =========================================================
   PAGINATION
========================================================= */

.pengguna-table-footer .pagination {

    margin: 0;

    gap: 5px;
}


.pengguna-table-footer .page-link {

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


.pengguna-table-footer .page-item.active .page-link {

    background: #1769e8;

    border-color: #1769e8;

    color: white;
}


.pengguna-table-footer .page-link:hover {

    background: #f3f7fc;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .pengguna-hero {

        padding: 22px;

    }


    .pengguna-hero-content {

        flex-wrap: wrap;

    }


    .pengguna-hero-counter {

        width: 100%;

        text-align: left;

    }


    .pengguna-table {

        min-width: 900px;

    }


    .pengguna-table-footer {

        flex-direction: column;

        gap: 15px;

        align-items: flex-start;

    }

}

</style>


<div class="container-fluid px-0">


    {{-- =====================================================
         BREADCRUMB + TOMBOL
         JUDUL BESAR DI ATAS HERO SUDAH DIHAPUS
    ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-3">

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb small mb-0">

                <li class="breadcrumb-item">

                    <a
                        href="{{ route('dashboard') }}"
                        class="text-decoration-none"
                        style="color:#1d4ed8;"
                    >

                        Beranda

                    </a>

                </li>


                <li class="breadcrumb-item active">

                    Kelola Pengguna

                </li>

            </ol>

        </nav>


        {{-- TAMBAH PENGGUNA --}}

        <a
            href="{{ route('users.create') }}"
            class="btn btn-primary px-4 py-2 fw-semibold"
            style="
                border-radius:9px;
                font-size:14px;
            "
        >

            <i class="bi bi-plus-lg me-1"></i>

            Tambah Pengguna

        </a>

    </div>



    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="pengguna-hero mb-4">


        {{-- SPARKLES --}}

        <div class="pengguna-sparkles">

            <span class="pengguna-sparkle s1">
                ✦
            </span>

            <span class="pengguna-sparkle s2">
                ✦
            </span>

            <span class="pengguna-sparkle s3">
                ✦
            </span>

            <span class="pengguna-sparkle s4">
                ✦
            </span>

        </div>



        <div class="pengguna-hero-content">


            {{-- =================================================
                 ICON + EFEK RADAR
            ================================================== --}}

            <div class="pengguna-hero-icon-ring">

                <span class="signal-dot dot-1"></span>

                <span class="signal-dot dot-2"></span>

                <span class="signal-dot dot-3"></span>


                <div class="pengguna-hero-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

            </div>



            {{-- =================================================
                 JUDUL HERO
            ================================================== --}}

            <div class="pengguna-hero-text">

                <h2>
                    Kelola Pengguna
                </h2>


                <p>
                    Kelola dan atur akun pengguna sistem dengan mudah.
                </p>

            </div>



            {{-- =================================================
                 COUNTER
            ================================================== --}}

            <div class="pengguna-hero-counter">

                <div
                    class="pengguna-hero-counter-number"
                    data-count="{{ $jumlahPengguna }}"
                >
                    0
                </div>


                <div class="pengguna-hero-counter-label">
                    Pengguna Aktif
                </div>

            </div>


        </div>

    </div>



    {{-- =====================================================
         CARD TABEL
    ====================================================== --}}

    <div class="pengguna-card">


        {{-- =================================================
             SEARCH + FILTER
        ================================================== --}}

        <div class="pengguna-filter">

            <div class="row g-2 align-items-center">


                {{-- SEARCH --}}

                <div class="col-md-4">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-search"></i>

                        </span>


                        <input
                            type="text"
                            id="searchPengguna"
                            class="form-control"
                            placeholder="Cari nama atau email..."
                        >

                    </div>

                </div>



                {{-- BUTTON CARI --}}

                <div class="col-md-2">

                    <button
                        type="button"
                        id="btnCariPengguna"
                        class="btn btn-cari-pengguna w-100"
                    >

                        Cari

                    </button>

                </div>



                {{-- FILTER ROLE --}}

                <div class="col-md-3 ms-md-auto">

                    <select
                        id="filterRole"
                        class="form-select"
                    >

                        <option value="">
                            Semua Role
                        </option>

                        <option value="admin">
                            Administrator
                        </option>

                        <option value="user">
                            User
                        </option>

                    </select>

                </div>

            </div>

        </div>



        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-responsive">

            <table
                class="table pengguna-table align-middle mb-0"
                id="tabelPengguna"
            >

                <thead>

                    <tr>

                        <th style="width:70px;">
                            No
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Dibuat Pada
                        </th>

                        <th class="text-end pe-4">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse ($users as $index => $user)

                    <tr
                        class="pengguna-row"
                        data-search="{{ strtolower($user->name . ' ' . $user->email) }}"
                        data-role="{{ $user->role }}"
                    >


                        {{-- NO --}}

                        <td class="nomor-pengguna">

                            {{ method_exists($users, 'firstItem')
                                ? $users->firstItem() + $index
                                : $index + 1 }}

                        </td>



                        {{-- NAMA --}}

                        <td>

                            <div class="d-flex align-items-center">

                                <div class="avatar-circle-pengguna me-3">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>


                                <div>

                                    <div class="nama-pengguna">

                                        {{ $user->name }}


                                        @if ($user->id === auth()->id())

                                            <span class="badge-anda">
                                                Anda
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </td>



                        {{-- EMAIL --}}

                        <td>

                            <span class="email-pengguna">

                                {{ $user->email }}

                            </span>

                        </td>



                        {{-- ROLE --}}

                        <td>

                            @if ($user->role === 'admin')

                                <span class="badge-role-admin">

                                    Administrator

                                </span>

                            @else

                                <span class="badge-role-user">

                                    User

                                </span>

                            @endif

                        </td>



                        {{-- DIBUAT PADA --}}

                        <td>

                            <span class="email-pengguna">

                                {{ $user->created_at
                                    ? $user->created_at->format('d M Y H:i')
                                    : '-' }}

                            </span>

                        </td>



                        {{-- AKSI --}}

                        <td class="text-end pe-4">

                            <div class="d-inline-flex gap-2">


                                {{-- EDIT --}}

                                <a
                                    href="{{ route('users.edit', $user) }}"
                                    class="btn-aksi-pengguna"
                                    title="Edit"
                                >

                                    <i class="bi bi-pencil"></i>

                                </a>



                                {{-- HAPUS --}}

                                @if ($user->id !== auth()->id())

                                    <button
                                        type="button"
                                        class="btn-aksi-pengguna btn-aksi-hapus"
                                        title="Hapus"
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapusUser{{ $user->id }}"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>

                                @endif

                            </div>



                            {{-- MODAL HAPUS --}}

                            @if ($user->id !== auth()->id())

                                <div
                                    class="modal fade"
                                    id="hapusUser{{ $user->id }}"
                                    tabindex="-1"
                                    aria-hidden="true"
                                >

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content border-0 shadow">


                                            <div class="modal-header">

                                                <h5 class="modal-title fw-bold">

                                                    Hapus Pengguna

                                                </h5>


                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                ></button>

                                            </div>



                                            <div class="modal-body">

                                                <p class="mb-1">

                                                    Apakah kamu yakin ingin
                                                    menghapus pengguna ini?

                                                </p>


                                                <p class="text-muted small mb-0">

                                                    Akun

                                                    <strong>
                                                        {{ $user->name }}
                                                    </strong>

                                                    akan dihapus.

                                                </p>

                                            </div>



                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-light"
                                                    data-bs-dismiss="modal"
                                                >

                                                    Batal

                                                </button>


                                                <form
                                                    method="POST"
                                                    action="{{ route('users.destroy', $user) }}"
                                                >

                                                    @csrf

                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger"
                                                    >

                                                        Ya, Hapus

                                                    </button>

                                                </form>

                                            </div>


                                        </div>

                                    </div>

                                </div>

                            @endif

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center text-muted py-5"
                        >

                            <i
                                class="bi bi-people fs-1 d-block mb-2"
                            ></i>


                            Belum ada pengguna.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>



        {{-- =================================================
             FOOTER TABLE
        ================================================== --}}

        <div class="pengguna-table-footer">

            <small
                class="text-muted"
                id="jumlahTampil"
            >

                Menampilkan

                {{ $users->count() }}

                dari

                {{ $jumlahPengguna }}

                pengguna

            </small>


            @if (method_exists($users, 'links'))

                <div>

                    {{ $users->links('pagination::bootstrap-5') }}

                </div>

            @endif

        </div>


    </div>



    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="text-center py-4 mt-3">

        <small class="text-muted">

            © 2026 BULOG. All rights reserved.

        </small>

    </div>


</div>



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       COUNTER ANIMATION
       0 → JUMLAH PENGGUNA
    ===================================================== */

    const counter =
        document.querySelector(
            '.pengguna-hero-counter-number'
        );


    if (counter) {

        const target =
            Math.max(
                0,
                parseInt(
                    counter.dataset.count,
                    10
                ) || 0
            );


        const duration = 900;

        const startTime = performance.now();


        function animateCounter(currentTime) {

            const elapsed =
                currentTime - startTime;


            const progress =
                Math.min(
                    Math.max(
                        elapsed / duration,
                        0
                    ),
                    1
                );


            const eased =
                1 - Math.pow(
                    1 - progress,
                    3
                );


            const currentValue =
                Math.floor(
                    eased * target
                );


            counter.textContent =
                currentValue;


            if (progress < 1) {

                requestAnimationFrame(
                    animateCounter
                );

            } else {

                counter.textContent =
                    target;

            }

        }


        /*
         * Pastikan angka awal selalu 0.
         * Jadi tidak akan muncul -1.
         */

        counter.textContent = '0';


        requestAnimationFrame(
            animateCounter
        );

    }



    /* =====================================================
       SEARCH + FILTER ROLE
    ===================================================== */

    const searchInput =
        document.getElementById(
            'searchPengguna'
        );


    const filterRole =
        document.getElementById(
            'filterRole'
        );


    const btnCari =
        document.getElementById(
            'btnCariPengguna'
        );


    const rows =
        document.querySelectorAll(
            '.pengguna-row'
        );


    const jumlahTampil =
        document.getElementById(
            'jumlahTampil'
        );



    function filterPengguna() {

        const search =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : '';


        const role =
            filterRole
                ? filterRole.value
                : '';


        let jumlah = 0;


        rows.forEach(function (row) {

            const dataSearch =
                row.dataset.search || '';


            const dataRole =
                row.dataset.role || '';


            const cocokSearch =
                dataSearch.includes(
                    search
                );


            const cocokRole =
                !role ||
                dataRole === role;


            const tampil =
                cocokSearch &&
                cocokRole;


            row.style.display =
                tampil ? '' : 'none';


            if (tampil) {

                jumlah++;

            }

        });


        if (jumlahTampil) {

            jumlahTampil.textContent =
                `Menampilkan ${jumlah} pengguna`;

        }

    }



    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterPengguna
        );

    }


    if (filterRole) {

        filterRole.addEventListener(
            'change',
            filterPengguna
        );

    }


    if (btnCari) {

        btnCari.addEventListener(
            'click',
            filterPengguna
        );

    }

});

</script>


@endsection