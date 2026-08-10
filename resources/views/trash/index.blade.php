@extends('layouts.app')

@section('title', 'Sampah Dokumen')

@section('content')

{{-- =========================================================
    HERO SAMPAH DOKUMEN
========================================================= --}}

<div class="sampah-hero mb-4">

    <div class="sampah-hero-decoration">
        <span class="sampah-sparkle s1">✦</span>
        <span class="sampah-sparkle s2">✦</span>

        <span class="sampah-circle c1"></span>
        <span class="sampah-circle c2"></span>
    </div>

    <div class="sampah-hero-icon">
        <i class="bi bi-trash3-fill"></i>
    </div>

    <div class="sampah-hero-content">

        <span class="sampah-kicker">
            RECYCLE BIN
        </span>

        <h2>
            Sampah Dokumen
        </h2>

        <p>
            Kelola dokumen yang sudah dihapus dengan aman.
            Pulihkan kembali jika masih dibutuhkan.
        </p>

    </div>

</div>


{{-- =========================================================
    INFO SAMPAH
========================================================= --}}

<div class="sampah-info-card mb-4">

    <div class="sampah-info-icon">
        <i class="bi bi-arrow-repeat"></i>
    </div>

    <div class="sampah-info-content">

        <strong>
            Dokumen masih bisa diselamatkan ✨
        </strong>

        <p>
            Dokumen yang masuk ke sampah belum terhapus permanen.
            Kamu dapat memulihkannya kembali atau menghapusnya selamanya.
        </p>

    </div>

    <div class="sampah-info-status">
        <i class="bi bi-shield-check"></i>
        Aman
    </div>

</div>


{{-- =========================================================
    DOCUMENT CARD
========================================================= --}}

<div class="sampah-card">

    {{-- HEADER --}}
    <div class="sampah-card-header">

        <div class="sampah-card-title">

            <div class="sampah-title-icon">
                <i class="bi bi-archive"></i>
            </div>

            <div>

                <span>
                    RECENTLY DELETED
                </span>

                <h5>
                    Dokumen Terhapus
                </h5>

                <p>
                    Arsip yang menunggu untuk dipulihkan atau
                    dihapus permanen.
                </p>

            </div>

        </div>


        <div class="sampah-total-badge">

            <i class="bi bi-file-earmark"></i>

            {{ $dokumens->total() }} dokumen

        </div>

    </div>


    {{-- =====================================================
        TABLE
    ====================================================== --}}

    <div class="table-responsive">

        <table class="table align-middle mb-0 sampah-table">

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        <i class="bi bi-file-earmark-text me-1"></i>
                        Nama Dokumen
                    </th>

                    <th>
                        <i class="bi bi-folder me-1"></i>
                        Kategori
                    </th>

                    <th>
                        <i class="bi bi-person me-1"></i>
                        Diupload Oleh
                    </th>

                    <th>
                        <i class="bi bi-clock me-1"></i>
                        Dihapus Pada
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

                            <span class="sampah-number">

                                {{ $dokumens->firstItem() + $i }}

                            </span>

                        </td>


                        {{-- NAMA DOKUMEN --}}
                        <td>

                            <div class="sampah-document">

                                <div class="sampah-pdf-icon">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>


                                <div>

                                    <div class="sampah-document-name">

                                        {{ $dokumen->nama_dokumen }}

                                    </div>


                                    <small>

                                        {{ $dokumen->nomor_keterangan ?? '-' }}

                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- KATEGORI --}}
                        <td>

                            <span class="sampah-category">

                                <i class="bi bi-folder-fill"></i>

                                {{ $dokumen->kategori->nama ?? '-' }}

                            </span>

                        </td>


                        {{-- UPLOADER --}}
                        <td>

                            <div class="sampah-user">

                                <span class="sampah-user-icon">

                                    <i class="bi bi-person-fill"></i>

                                </span>

                                <span>
                                    {{ $dokumen->uploader->name ?? '-' }}
                                </span>

                            </div>

                        </td>


                        {{-- TANGGAL DIHAPUS --}}
                        <td>

                            <div class="sampah-date">

                                <i class="bi bi-calendar3"></i>

                                <div>

                                    <strong>
                                        {{ $dokumen->deleted_at->format('d M Y') }}
                                    </strong>

                                    <small>
                                        {{ $dokumen->deleted_at->format('H:i') }}
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- AKSI --}}
                        <td>

                            <div class="sampah-actions">


                                {{-- RESTORE --}}
                                <form
                                    action="{{ route('dokumen.restore', $dokumen->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="sampah-btn sampah-btn-restore"
                                        title="Pulihkan dokumen"
                                    >

                                        <i class="bi bi-arrow-clockwise"></i>

                                        <span>
                                            Pulihkan
                                        </span>

                                    </button>

                                </form>


                                {{-- HAPUS PERMANEN --}}
                                <form
                                    action="{{ route('dokumen.forceDelete', $dokumen->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus permanen dokumen ini?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="sampah-btn sampah-btn-delete"
                                        title="Hapus permanen"
                                    >

                                        <i class="bi bi-trash3-fill"></i>

                                        <span>
                                            Hapus Permanen
                                        </span>

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

                        <td
                            colspan="6"
                            class="sampah-empty"
                        >

                            <div class="sampah-empty-icon">

                                <i class="bi bi-trash3"></i>

                            </div>

                            <h5>
                                Tempat sampah masih kosong
                            </h5>

                            <p>
                                Belum ada dokumen yang dihapus.
                                Dokumen yang kamu hapus nantinya akan muncul di sini.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
        PAGINATION
    ====================================================== --}}

    <div class="sampah-pagination">

        <div>

            Menampilkan

            <strong>
                {{ $dokumens->firstItem() ?? 0 }}
            </strong>

            hingga

            <strong>
                {{ $dokumens->lastItem() ?? 0 }}
            </strong>

            dari

            <strong>
                {{ $dokumens->total() }}
            </strong>

            data

        </div>


        <div>

            {{ $dokumens->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection