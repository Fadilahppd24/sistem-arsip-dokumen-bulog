@extends('layouts.app')

@section('title', $kategoriAktif->nama ?? 'Kelola Dokumen')

@section('content')

<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                Beranda
            </a>
        </li>

        <li class="breadcrumb-item active">
            {{ $kategoriAktif->nama ?? 'Kelola Dokumen' }}
        </li>
    </ol>
</nav>

@php
    $iconBg = match($kategoriAktif->warna ?? null) {
        'primary' => 'bg-bulog-navy',
        'warning' => 'bg-bulog-yellow',
        'info' => 'bg-info',
        'secondary' => 'bg-secondary',
        default => 'bg-bulog-navy',
    };

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

            <div class="dokumen-hero-icon {{ $iconBg }}">
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


                            {{-- MODAL HAPUS --}}
                            <div
                                class="modal fade"
                                id="hapusModal{{ $dokumen->id }}"
                                tabindex="-1"
                            >

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-body p-4">

                                            <h6 class="fw-bold">
                                                Hapus dokumen ini?
                                            </h6>

                                            <p class="text-muted small mb-0">
                                                "{{ $dokumen->nama_dokumen }}"
                                                akan dihapus permanen dan tidak dapat dikembalikan.
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
                                                action="{{ route('dokumen.destroy', $dokumen) }}"
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

@endpush

@endsection