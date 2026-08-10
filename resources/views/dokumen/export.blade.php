@extends('layouts.app')

@section('title', 'Ekspor Dokumen')

@section('content')

{{-- =========================================================
    BREADCRUMB
========================================================= --}}

<div class="breadcrumb mb-3">
    <a href="{{ route('dashboard') }}" class="text-decoration-none">
        Beranda
    </a>

    <span class="mx-2">›</span>

    <span>Ekspor Dokumen</span>
</div>


{{-- =========================================================
    HERO EKSPOR
========================================================= --}}

<div class="export-hero">

    <div class="ekspor-hero-icon-ring">
        <div class="ekspor-hero-icon">
            <i class="bi bi-file-earmark-zip-fill"></i>
        </div>
    </div>

    <div class="ekspor-hero-content">
        <h2 class="fw-bold mb-2">
            Ekspor Dokumen
        </h2>

        <p class="mb-0">
            Pilih kategori dokumen dan kemas arsip menjadi satu file ZIP
            dengan mudah.
        </p>
    </div>

    <div class="ekspor-hero-decoration">
        <i class="bi bi-stars"></i>
    </div>

</div>


{{-- =========================================================
    EXPORT CENTER
========================================================= --}}

<div class="export-center mt-4">

    {{-- =====================================================
        LEFT : FORM EKSPOR
    ====================================================== --}}

    <div class="export-main">

        <div class="export-heading">

            <div class="export-heading-icon">
                <i class="bi bi-folder2-open"></i>
            </div>

            <div>

                <span class="export-kicker">
                    EXPORT CENTER
                </span>

                <h4>
                    Pilih dokumen yang akan diekspor
                </h4>

                <p>
                    Tentukan kategori dokumen yang ingin kamu
                    kemas menjadi satu file ZIP.
                </p>

            </div>

        </div>


        <form
            action="{{ route('dokumen.export.process') }}"
            method="POST"
        >

            @csrf


            {{-- KATEGORI --}}

            <div class="export-form">

                <label for="kategori_id">
                    Kategori Dokumen
                </label>

                <select
                    name="kategori_id"
                    id="kategori_id"
                    class="form-select export-select"
                >

                    <option value="">
                        Seluruh Dokumen
                    </option>

                    @foreach ($kategoris as $kategori)

                        <option value="{{ $kategori->id }}">
                            {{ $kategori->nama }}
                        </option>

                    @endforeach

                </select>

                <small>
                    Pilih kategori tertentu atau
                    <strong>Seluruh Dokumen</strong>
                    untuk mengekspor semua dokumen.
                </small>

            </div>


            {{-- INFORMASI --}}

            <div class="export-info">

                <i class="bi bi-info-circle-fill"></i>

                <span>
                    Dokumen akan dikemas menjadi satu file
                    <strong>ZIP</strong> dan file PDF akan
                    dikelompokkan berdasarkan kategori.
                </span>

            </div>


            {{-- TOMBOL --}}

            <div class="export-actions">

                <a
                    href="{{ route('dokumen.index') }}"
                    class="export-cancel"
                >
                    <i class="bi bi-arrow-left"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    class="export-submit"
                >
                    <i class="bi bi-file-earmark-zip-fill"></i>
                    Ekspor ke ZIP
                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
        RIGHT : PREVIEW
    ====================================================== --}}

    <div class="export-preview">

        <div class="export-orbit export-orbit-1"></div>

        <div class="export-orbit export-orbit-2"></div>


        <div class="export-preview-icon">
            <i class="bi bi-file-earmark-zip-fill"></i>
        </div>


        <div class="export-preview-title">
            EXPORT
        </div>


        <div class="export-preview-subtitle">
            ZIP ARCHIVE
        </div>


        <div class="export-preview-badge">

            <i class="bi bi-check-circle-fill"></i>

            Siap diekspor

        </div>

    </div>

</div>

@endsection