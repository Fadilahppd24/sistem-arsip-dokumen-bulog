@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')

<style>

/* =========================================================
   BREADCRUMB
========================================================= */

.audit-breadcrumb {
    font-size: 14px;
    margin-bottom: 20px;
}

.audit-breadcrumb a {
    color: #1d4ed8;
    text-decoration: none;
}

.audit-breadcrumb a:hover {
    text-decoration: underline;
}


/* =========================================================
   HERO RIWAYAT AKTIVITAS
========================================================= */

.audit-hero {
    position: relative;

    min-height: 150px;

    display: flex;
    align-items: center;

    gap: 22px;

    padding: 24px 32px;

    margin-bottom: 24px;

    border: 1px solid #8bbcff;
    border-radius: 18px;

    background:
        linear-gradient(
            110deg,
            #e8f1ff 0%,
            #dceaff 48%,
            #edf5ff 100%
        );

    overflow: hidden;
}


/* =========================================================
   LINGKARAN BESAR KANAN
========================================================= */

.audit-hero::after {
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
   BUBBLE / SPARKLE
========================================================= */

.audit-bubble {
    position: absolute;

    border-radius: 50%;

    background: rgba(255,255,255,.7);

    pointer-events: none;

    z-index: 1;

    animation: auditBubbleFloat 5s ease-in-out infinite;
}

.audit-bubble-1 {
    width: 8px;
    height: 8px;

    right: 34%;
    top: 35px;

    animation-delay: 0s;
}

.audit-bubble-2 {
    width: 12px;
    height: 12px;

    right: 47%;
    bottom: 28px;

    animation-delay: 1.2s;
}

.audit-bubble-3 {
    width: 6px;
    height: 6px;

    right: 57%;
    top: 48px;

    animation-delay: 2s;
}

.audit-bubble-4 {
    width: 9px;
    height: 9px;

    right: 27%;
    bottom: 30px;

    animation-delay: 3s;
}


@keyframes auditBubbleFloat {

    0%, 100% {
        transform: translateY(0) translateX(0);
        opacity: .45;
    }

    50% {
        transform: translateY(-10px) translateX(4px);
        opacity: .95;
    }

}


/* =========================================================
   ICON + RADAR RING
========================================================= */

.audit-hero-icon-ring {

    position: relative;

    width: 94px;
    height: 94px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    z-index: 3;

    animation: auditRingPulse 2.2s ease-out infinite;
}


/* LINGKARAN RADAR LUAR */

.audit-hero-icon-ring::before {

    content: "";

    position: absolute;

    width: 94px;
    height: 94px;

    border-radius: 50%;

    border: 2px solid rgba(30,79,160,.18);

    animation: auditRadar 2.2s ease-out infinite;
}


/* LINGKARAN RADAR DALAM */

.audit-hero-icon-ring::after {

    content: "";

    position: absolute;

    width: 76px;
    height: 76px;

    border-radius: 50%;

    border: 2px solid rgba(30,79,160,.25);

    animation: auditRadarInner 2.2s ease-out infinite;
}


/* =========================================================
   PULSE
========================================================= */

@keyframes auditRingPulse {

    0% {
        box-shadow:
            0 0 0 0 rgba(30,79,160,.28);
    }

    70% {
        box-shadow:
            0 0 0 13px rgba(30,79,160,0);
    }

    100% {
        box-shadow:
            0 0 0 0 rgba(30,79,160,0);
    }

}


/* =========================================================
   RADAR LUAR
========================================================= */

@keyframes auditRadar {

    0% {
        transform: scale(.82);
        opacity: .9;
    }

    70% {
        transform: scale(1.18);
        opacity: 0;
    }

    100% {
        transform: scale(1.18);
        opacity: 0;
    }

}


/* =========================================================
   RADAR DALAM
========================================================= */

@keyframes auditRadarInner {

    0% {
        transform: scale(.85);
        opacity: .8;
    }

    70% {
        transform: scale(1.12);
        opacity: 0;
    }

    100% {
        transform: scale(1.12);
        opacity: 0;
    }

}


/* =========================================================
   ICON BULAT
========================================================= */

.audit-hero-icon {

    position: relative;

    width: 78px;
    height: 78px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #1769e8;

    color: white;

    font-size: 31px;

    border: 4px solid white;

    box-shadow:
        0 12px 28px rgba(10,46,110,.25),
        inset 0 -4px 10px rgba(0,0,0,.10);

    z-index: 4;

    transition: transform .3s ease;
}


.audit-hero:hover .audit-hero-icon {

    transform:
        scale(1.06)
        rotate(-4deg);

}


/* =========================================================
   HERO CONTENT
========================================================= */

.audit-hero-content {

    position: relative;

    z-index: 3;

    flex: 1;
}


.audit-hero-content h2 {

    margin: 0 0 6px;

    color: #102a56;

    font-size: 27px;

    font-weight: 700;

}


.audit-hero-content p {

    margin: 0;

    color: #526987;

    font-size: 14px;

}


/* =========================================================
   STATISTIK
========================================================= */

.audit-hero-stat {

    position: relative;

    z-index: 3;

    min-width: 145px;

    padding: 8px 24px;

    text-align: center;

}


.audit-hero-number {

    font-size: 38px;

    line-height: 1;

    font-weight: 800;

    background:
        linear-gradient(
            135deg,
            #1e4fa0,
            #60a5fa
        );

    -webkit-background-clip: text;
    background-clip: text;

    color: transparent;

}


.audit-hero-label {

    margin-top: 7px;

    color: #687993;

    font-size: 10px;

    font-weight: 700;

    letter-spacing: .7px;

    text-transform: uppercase;

}


/* =========================================================
   CARD AKTIVITAS
========================================================= */

.audit-card {

    overflow: hidden;

    border: 0;

    border-radius: 18px;

    background: white;

    box-shadow:
        0 8px 30px rgba(15,43,83,.07);
}


/* =========================================================
   CARD HEADER
========================================================= */

.audit-card-header {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 20px 24px;

    border-bottom: 1px solid #edf0f4;

    background: #fbfcfe;
}


.audit-header-icon {

    width: 44px;
    height: 44px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    background: #e8f1ff;

    color: #1769e8;

    font-size: 20px;
}


.audit-header-title {

    color: #183b70;

    font-size: 15px;

    font-weight: 700;
}


.audit-header-text {

    margin-top: 2px;

    color: #718096;

    font-size: 12px;
}


/* =========================================================
   TABLE
========================================================= */

.audit-table {

    margin: 0;
}


.audit-table thead th {

    padding: 16px;

    border-bottom: 1px solid #e8edf3;

    background: #f8fafc;

    color: #596579;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: .5px;

    text-transform: uppercase;

    white-space: nowrap;
}


.audit-table tbody td {

    padding: 17px 16px;

    border-bottom: 1px solid #edf0f4;

    vertical-align: middle;

}


.audit-table tbody tr:last-child td {

    border-bottom: 0;

}


.audit-table tbody tr {

    transition:
        background .2s ease,
        transform .2s ease;
}


.audit-table tbody tr:hover {

    background: #f8fbff;

}


/* =========================================================
   NOMOR
========================================================= */

.audit-number {

    width: 34px;
    height: 34px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f1f5f9;

    color: #526174;

    font-size: 12px;

    font-weight: 700;
}


/* =========================================================
   USER
========================================================= */

.audit-user {

    display: flex;

    align-items: center;

    gap: 11px;
}


.audit-avatar {

    width: 40px;
    height: 40px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 50%;

    background: #1e4fa0;

    color: white;

    font-size: 14px;

    font-weight: 700;

    box-shadow:
        0 4px 10px rgba(30,79,160,.18);
}


.audit-user-name {

    color: #172b4d;

    font-size: 13px;

    font-weight: 700;
}


.audit-user-email {

    margin-top: 2px;

    color: #7b8798;

    font-size: 11px;
}


/* =========================================================
   BADGE AKTIVITAS
========================================================= */

.audit-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 10px;

    border-radius: 7px;

    font-size: 11px;

    font-weight: 700;

    white-space: nowrap;
}


.audit-badge-success {

    background: #dff7ea;
    color: #138a54;
}


.audit-badge-warning {

    background: #fff1cf;
    color: #9a6700;
}


.audit-badge-danger {

    background: #ffe2e5;
    color: #c6283d;
}


.audit-badge-primary {

    background: #dbeafe;
    color: #1d5fc4;
}


.audit-badge-dark {

    background: #e5e7eb;
    color: #374151;
}


.audit-badge-secondary {

    background: #eef1f5;
    color: #64748b;
}


/* =========================================================
   MODUL
========================================================= */

.audit-module {

    display: inline-block;

    padding: 6px 10px;

    border-radius: 7px;

    background: #f1f5f9;

    color: #475569;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   DETAIL
========================================================= */

.audit-detail {

    color: #475569;

    font-size: 13px;

    line-height: 1.5;

    max-width: 470px;
}


/* =========================================================
   WAKTU
========================================================= */

.audit-time {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    color: #64748b;

    font-size: 12px;

    white-space: nowrap;
}


.audit-time i {

    color: #3b82f6;

}


/* =========================================================
   EMPTY STATE
========================================================= */

.audit-empty {

    padding: 60px 20px;

    text-align: center;
}


.audit-empty-icon {

    width: 68px;
    height: 68px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #eef4ff;

    color: #1769e8;

    font-size: 29px;
}


.audit-empty-title {

    margin-bottom: 5px;

    color: #334155;

    font-weight: 700;
}


.audit-empty-text {

    color: #7b8798;

    font-size: 13px;
}


/* =========================================================
   FOOTER
========================================================= */

.audit-footer {

    display: flex;

    justify-content: space-between;

    align-items: center;

    min-height: 70px;

    padding: 14px 24px;

    border-top: 1px solid #edf0f4;
}


.audit-footer-text {

    color: #687588;

    font-size: 13px;
}


/* =========================================================
   PAGINATION
========================================================= */

.audit-footer .pagination {

    margin: 0;

    gap: 5px;
}


.audit-footer .pagination .page-link {

    min-width: 36px;
    height: 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 8px !important;

    border: 1px solid #e1e7ef;

    color: #5d6b7d;

    background: white;
}


.audit-footer .pagination .page-item.active .page-link {

    background: #1769e8;

    border-color: #1769e8;

    color: white;
}


.audit-footer .pagination .page-link:hover {

    background: #f3f7fc;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .audit-hero {

        flex-wrap: wrap;

        padding: 24px;

    }


    .audit-hero-stat {

        width: 100%;

        padding-left: 0;

        text-align: left;

    }


    .audit-table {

        min-width: 1000px;

    }


    .audit-footer {

        flex-direction: column;

        align-items: flex-start;

        gap: 14px;

    }

}

</style>


<div class="container-fluid px-0">


    {{-- =====================================================
         BREADCRUMB
    ====================================================== --}}

    <div class="audit-breadcrumb d-flex align-items-center gap-2">

        <a href="{{ route('dashboard') }}">
            Beranda
        </a>

        <span class="text-muted">
            >
        </span>

        <span class="text-muted">
            Riwayat Aktivitas
        </span>

    </div>


    {{-- =====================================================
         JUMLAH AKTIVITAS
    ====================================================== --}}

    @php

        $jumlahAktivitas = method_exists($logs, 'total')
            ? max(0, (int) $logs->total())
            : max(0, (int) $logs->count());

    @endphp


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="audit-hero">


        {{-- DEKORASI --}}

        <span class="audit-bubble audit-bubble-1"></span>

        <span class="audit-bubble audit-bubble-2"></span>

        <span class="audit-bubble audit-bubble-3"></span>

        <span class="audit-bubble audit-bubble-4"></span>


        {{-- ICON --}}

        <div class="audit-hero-icon-ring">

            <div class="audit-hero-icon">

                <i class="bi bi-clock-history"></i>

            </div>

        </div>


        {{-- CONTENT --}}

        <div class="audit-hero-content">

            <h2>
                Riwayat Aktivitas
            </h2>

            <p>
                Daftar aktivitas pengguna dalam sistem.
            </p>

        </div>


        {{-- JUMLAH --}}

        <div class="audit-hero-stat">

            <div
                class="audit-hero-number"
                data-count="{{ $jumlahAktivitas }}"
            >
                0
            </div>

            <div class="audit-hero-label">
                TOTAL AKTIVITAS
            </div>

        </div>

    </div>


    {{-- =====================================================
         CARD AKTIVITAS
    ====================================================== --}}

    <div class="audit-card">


        {{-- HEADER CARD --}}

        <div class="audit-card-header">

            <div class="audit-header-icon">

                <i class="bi bi-activity"></i>

            </div>

            <div>

                <div class="audit-header-title">
                    Aktivitas Pengguna
                </div>

                <div class="audit-header-text">
                    Catatan aktivitas yang dilakukan pengguna dalam sistem.
                </div>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-responsive">

            <table class="table audit-table align-middle mb-0">

                <thead>

                    <tr>

                        <th style="width:70px;">
                            No
                        </th>

                        <th>
                            User
                        </th>

                        <th>
                            Aktivitas
                        </th>

                        <th>
                            Modul
                        </th>

                        <th>
                            Detail Aktivitas
                        </th>

                        <th>
                            Waktu
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse ($logs as $log)


                    @php

                        $badge = match($log->aktivitas) {

                            'Upload Dokumen' => 'success',

                            'Edit Dokumen' => 'warning',

                            'Hapus Dokumen' => 'danger',

                            'Download Dokumen' => 'primary',

                            'Backup Database' => 'dark',

                            default => 'secondary'

                        };


                        $badgeIcon = match($log->aktivitas) {

                            'Upload Dokumen' => 'bi-cloud-arrow-up',

                            'Edit Dokumen' => 'bi-pencil-square',

                            'Hapus Dokumen' => 'bi-trash',

                            'Download Dokumen' => 'bi-download',

                            'Backup Database' => 'bi-database-check',

                            default => 'bi-activity'

                        };


                        $namaUser = $log->user->name ?? 'System';


                        $initial = strtoupper(
                            substr($namaUser, 0, 1)
                        );

                    @endphp


                    <tr>


                        {{-- NO --}}

                        <td>

                            <div class="audit-number">

                                @if(method_exists($logs, 'currentPage'))

                                    {{ (($logs->currentPage() - 1) * $logs->perPage()) + $loop->iteration }}

                                @else

                                    {{ $loop->iteration }}

                                @endif

                            </div>

                        </td>


                        {{-- USER --}}

                        <td>

                            <div class="audit-user">


                                <div class="audit-avatar">

                                    {{ $initial }}

                                </div>


                                <div>

                                    <div class="audit-user-name">

                                        {{ $namaUser }}

                                    </div>


                                    @if($log->user)

                                        <div class="audit-user-email">

                                            {{ $log->user->email }}

                                        </div>

                                    @else

                                        <div class="audit-user-email">

                                            Aktivitas sistem

                                        </div>

                                    @endif

                                </div>


                            </div>

                        </td>


                        {{-- AKTIVITAS --}}

                        <td>

                            <span class="audit-badge audit-badge-{{ $badge }}">

                                <i class="bi {{ $badgeIcon }}"></i>

                                {{ $log->aktivitas }}

                            </span>

                        </td>


                        {{-- MODUL --}}

                        <td>

                            <span class="audit-module">

                                {{ $log->modul }}

                            </span>

                        </td>


                        {{-- DETAIL --}}

                        <td>

                            <div class="audit-detail">

                                {{ $log->keterangan }}

                            </div>

                        </td>


                        {{-- WAKTU --}}

                        <td>

                            <span class="audit-time">

                                <i class="bi bi-calendar3"></i>

                                {{ $log->created_at?->format('d M Y, H:i') ?? '-' }}

                            </span>

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="6">

                            <div class="audit-empty">

                                <div class="audit-empty-icon">

                                    <i class="bi bi-clock-history"></i>

                                </div>

                                <div class="audit-empty-title">

                                    Belum Ada Aktivitas

                                </div>

                                <div class="audit-empty-text">

                                    Belum terdapat aktivitas pengguna yang tercatat dalam sistem.

                                </div>

                            </div>

                        </td>

                    </tr>


                @endforelse


                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <div class="audit-footer">


            <div class="audit-footer-text">

                Menampilkan

                {{ $logs->firstItem() ?? 0 }}

                hingga

                {{ $logs->lastItem() ?? 0 }}

                dari

                {{ $logs->total() }}

                aktivitas

            </div>


            @if(method_exists($logs, 'links'))

                <div>

                    {{ $logs->links('pagination::bootstrap-5') }}

                </div>

            @endif


        </div>


    </div>


    {{-- =====================================================
         FOOTER WEBSITE
    ====================================================== --}}

    <div class="text-center py-4">

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

    const counter =
        document.querySelector('.audit-hero-number');

    if (!counter) {
        return;
    }


    const target =
        Math.max(0, parseInt(counter.dataset.count, 10) || 0);


    const duration = 1000;

    const startTime = performance.now();


    function animate(currentTime) {

        const elapsed =
            currentTime - startTime;


        const progress =
            Math.min(elapsed / duration, 1);


        const eased =
            1 - Math.pow(1 - progress, 3);


        const currentValue =
            Math.floor(eased * target);


        counter.textContent =
            Math.max(0, currentValue);


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