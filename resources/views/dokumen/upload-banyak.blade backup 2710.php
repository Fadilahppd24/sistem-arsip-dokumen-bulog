@extends('layouts.app')

@section('title', 'Upload Banyak Dokumen')

@section('content')

<div class="upload-page">

    {{-- ================= BREADCRUMB ================= --}}
    <div class="sampah-breadcrumb mb-3">
        <a href="{{ route('dashboard') }}">Beranda</a>
        <span>›</span>
        <span>Upload Banyak Dokumen</span>
    </div>

    {{-- ================= HERO ================= --}}
    <div class="upload-hero upload-many-hero d-flex align-items-center gap-4 mb-4">

        <div class="upload-hero-icon-ring">
            <div class="upload-hero-icon">
                <i class="bi bi-files"></i>
            </div>
        </div>

        <div class="upload-hero-content">
            <h2 class="fw-bold">
                Upload Banyak Dokumen
            </h2>

            <p>
                Pilih beberapa file PDF untuk diarsipkan sekaligus.
                Sistem akan memproses dokumen secara otomatis.
            </p>
        </div>

        <i class="bi bi-stars upload-sparkle s1"></i>
        <i class="bi bi-stars upload-sparkle s2"></i>
        <i class="bi bi-stars upload-sparkle s3"></i>

        <a
            href="{{ route('dokumen.create') }}"
            class="upload-manual-button"
        >
            <i class="bi bi-cloud-arrow-up-fill"></i>
            Upload Manual
        </a>

    </div>

    {{-- ================= ERROR ================= --}}
    @if (session('error'))
        <div class="upload-many-alert alert alert-danger mb-4">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="upload-many-alert alert alert-danger mb-4">
            <div>
                <div class="fw-semibold mb-1">
                    Terjadi kesalahan
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ================= MAIN CARD ================= --}}
    <div class="upload-card upload-many-card">

        {{-- HEADER --}}
        <div class="upload-card-header">

            <div class="upload-card-header-icon">
                <i class="bi bi-files"></i>
            </div>

            <div>
                <h5>
                    Pilih Dokumen
                </h5>

                <p>
                    Pilih beberapa file PDF sekaligus untuk diproses dan diarsipkan.
                </p>
            </div>

        </div>

        {{-- FORM --}}
        <form
            action="{{ route('dokumen.upload-banyak.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="uploadManyForm"
        >
            @csrf

            <div class="upload-form-body">

                {{-- DROPZONE --}}
                <label
                    for="files"
                    class="upload-many-dropzone"
                    id="dropzoneMany"
                >

                    <div class="upload-many-cloud">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>

                    <div class="upload-many-title">
                        Pilih file PDF
                    </div>

                    <div class="upload-many-subtitle">
                        Klik untuk memilih atau tarik &amp; lepas file di sini
                    </div>

                    <div class="upload-many-limit">
                        <span>
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                            PDF
                        </span>

                        <span>•</span>

                        <span>Maks. 100 MB per file</span>

                        <span>•</span>

                        <span>Bisa beberapa file</span>
                    </div>

                    <input
                        type="file"
                        name="files[]"
                        id="files"
                        accept=".pdf,application/pdf"
                        multiple
                        required
                        class="d-none"
                    >

                </label>

                {{-- FILE SUMMARY --}}
                <div
                    id="fileSummary"
                    class="upload-many-summary d-none"
                >
                    <div class="upload-many-summary-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <div class="upload-many-summary-text">
                        <strong id="fileCount">0 file</strong>
                        <span>siap untuk diupload</span>
                    </div>

                    <button
                        type="button"
                        id="btnChooseAgain"
                        class="upload-many-change"
                    >
                        Pilih Lagi
                    </button>
                </div>

                {{-- FILE PREVIEW --}}
                <div
                    id="filePreview"
                    class="upload-many-preview d-none"
                ></div>

            </div>

            {{-- ACTION --}}
            <div class="upload-form-actions upload-many-actions">

                <a
                    href="{{ route('dokumen.index') }}"
                    class="btn btn-light"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="upload-submit"
                    id="btnUpload"
                    disabled
                >
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                    Upload Semua
                </button>

            </div>

        </form>

    </div>

</div>

    {{-- ================= LOADING BULOG ================= --}}
    <div id="bulogProcessingOverlay" class="bulog-processing-overlay" aria-hidden="true">
        <div class="bulog-processing-card">
            <button type="button" class="bulog-processing-close" id="btnCancelProcessing" aria-label="Tutup" disabled>
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="bulog-scene">
                <div class="bulog-sky-glow"></div>
                <div class="bulog-warehouse">
                    <div class="bulog-building">
                        <div class="bulog-sign">BULOG</div>
                        <div class="bulog-door"></div>
                        <div class="bulog-window"></div>
                        <div class="bulog-window second"></div>
                    </div>
                    <div class="bulog-sack sack-one">🌾</div>
                    <div class="bulog-sack sack-two">🌾</div>
                    <div class="bulog-forklift">▰</div>
                </div>
                <div class="bulog-ground"></div>
            </div>

            <div class="bulog-processing-icon" id="bulogProcessingIcon">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span class="bulog-scan-line"></span>
            </div>

            <h3>Dokumen Sedang Diproses</h3>
            <p class="bulog-processing-desc">
                Sistem sedang memproses dokumen untuk diarsipkan.
            </p>

            <div class="bulog-steps">
                <div class="bulog-step active" data-step="0">
                    <span><i class="bi bi-cloud-arrow-up-fill"></i></span>
                    <small>Mengunggah</small>
                </div>
                <div class="bulog-step" data-step="1">
                    <span><i class="bi bi-file-earmark-text-fill"></i></span>
                    <small>Membaca PDF</small>
                </div>
                <div class="bulog-step" data-step="2">
                    <span><i class="bi bi-search"></i></span>
                    <small>OCR</small>
                </div>
                <div class="bulog-step" data-step="3">
                    <span><i class="bi bi-archive-fill"></i></span>
                    <small>Menyimpan</small>
                </div>
            </div>

            <div class="bulog-progress-wrap">
                <div class="bulog-progress-track">
                    <div class="bulog-progress-bar" id="bulogProgressBar"></div>
                </div>
                <div class="bulog-progress-info">
                    <span id="bulogProcessingText">Menyiapkan dokumen...</span>
                    <strong id="bulogProgressPercent">0%</strong>
                </div>
            </div>

            <div class="bulog-processing-note">
                <i class="bi bi-info-circle-fill"></i>
                <span><strong>Mohon jangan menutup halaman ini.</strong> Proses OCR dapat memerlukan beberapa saat.</span>
            </div>
        </div>
    </div>


<style>

/* =========================================================
   UPLOAD BANYAK
========================================================= */

.upload-many-hero {
    position: relative;
    overflow: hidden;
}

.upload-many-hero .upload-hero-content {
    flex: 1 1 auto;
    min-width: 0;
}

.upload-many-hero .upload-hero-content h2 {
    margin-bottom: 7px;
}

.upload-many-hero .upload-hero-content p {
    margin-bottom: 0;
}

.upload-manual-button {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 0 18px;
    border-radius: 10px;
    background: #ffffff;
    border: 1px solid #d8e4f5;
    color: #123b78;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 5px 18px rgba(24, 73, 135, .08);
    transition: .2s ease;
}

.upload-manual-button:hover {
    color: #0d4da1;
    border-color: #b9cce8;
    transform: translateY(-1px);
    box-shadow: 0 8px 22px rgba(24, 73, 135, .12);
}

.upload-many-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-radius: 12px;
}

/* =========================================================
   MAIN CARD
========================================================= */

.upload-many-card {
    overflow: hidden;
}

.upload-many-card .upload-form-body {
    padding-top: 30px;
    padding-bottom: 30px;
}

/* =========================================================
   DROPZONE
========================================================= */

.upload-many-dropzone {
    min-height: 285px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 34px 24px;
    box-sizing: border-box;
    border: 2px dashed #c6d8f1;
    border-radius: 18px;
    background:
        radial-gradient(circle at 50% 0%, rgba(35, 103, 190, .08), transparent 48%),
        #f8fbff;
    cursor: pointer;
    text-align: center;
    transition: .2s ease;
}

.upload-many-dropzone:hover,
.upload-many-dropzone.dragover {
    border-color: #1769e8;
    background:
        radial-gradient(circle at 50% 0%, rgba(35, 103, 190, .13), transparent 48%),
        #f4f8ff;
    transform: translateY(-1px);
}

.upload-many-cloud {
    width: 78px;
    height: 78px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    border-radius: 22px;
    background: #e7f0ff;
    color: #1655a8;
    font-size: 38px;
    box-shadow: 0 10px 25px rgba(30, 85, 160, .10);
}

.upload-many-title {
    color: #172f57;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 6px;
}

.upload-many-subtitle {
    color: #718096;
    font-size: 13px;
    margin-bottom: 16px;
}

.upload-many-limit {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 8px;
    color: #8795a8;
    font-size: 12px;
}

.upload-many-limit span:first-child {
    color: #d9363e;
    font-weight: 600;
}

/* =========================================================
   SUMMARY
========================================================= */

.upload-many-summary {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 18px;
    padding: 13px 15px;
    border: 1px solid #d9e6f7;
    border-radius: 12px;
    background: #f8fbff;
}

.upload-many-summary-icon {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #e9f7ef;
    color: #198754;
    font-size: 20px;
}

.upload-many-summary-text {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.upload-many-summary-text strong {
    color: #263b5b;
    font-size: 14px;
}

.upload-many-summary-text span {
    color: #8795a8;
    font-size: 12px;
}

.upload-many-change {
    border: none;
    background: transparent;
    color: #1769e8;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    padding: 7px 9px;
}

/* =========================================================
   FILE LIST
========================================================= */

.upload-many-preview {
    margin-top: 18px;
}

.upload-many-preview-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
    color: #334155;
    font-size: 13px;
    font-weight: 700;
}

.upload-many-file {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 15px;
    margin-bottom: 8px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
}

.upload-many-file-icon {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #fff1f2;
    color: #dc3545;
    font-size: 19px;
}

.upload-many-file-info {
    min-width: 0;
    flex: 1;
}

.upload-many-file-name {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #27364d;
    font-size: 13px;
    font-weight: 600;
}

.upload-many-file-size {
    display: block;
    margin-top: 3px;
    color: #94a3b8;
    font-size: 11px;
}

.upload-many-file-number {
    width: 28px;
    height: 28px;
    flex: 0 0 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
}

/* =========================================================
   ACTION
========================================================= */

.upload-many-actions {
    justify-content: flex-end;
}

.upload-many-actions #btnUpload:disabled {
    opacity: .55;
    cursor: not-allowed;
}

/* =========================================================
   DARK MODE
========================================================= */

body.dark-mode .upload-manual-button {
    background: #202c3e;
    border-color: #46566d;
    color: #dbe5f2;
}

body.dark-mode .upload-many-dropzone {
    border-color: #46566d;
    background: #182334;
}

body.dark-mode .upload-many-dropzone:hover,
body.dark-mode .upload-many-dropzone.dragover {
    border-color: #6c9ee8;
    background: #1d2c42;
}

body.dark-mode .upload-many-cloud {
    background: #253b5b;
    color: #9fc2f5;
}

body.dark-mode .upload-many-title,
body.dark-mode .upload-many-preview-title {
    color: #e3ebf7;
}

body.dark-mode .upload-many-subtitle,
body.dark-mode .upload-many-limit {
    color: #91a1b7;
}

body.dark-mode .upload-many-summary {
    background: #182334;
    border-color: #344256;
}

body.dark-mode .upload-many-summary-text strong {
    color: #dbe5f2;
}

body.dark-mode .upload-many-file {
    background: #202c3e;
    border-color: #46566d;
}

body.dark-mode .upload-many-file-name {
    color: #dbe5f2;
}

body.dark-mode .upload-many-file-size {
    color: #91a1b7;
}

body.dark-mode .upload-many-file-number {
    background: #2b3b52;
    color: #aebdd0;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .upload-many-hero {
        flex-wrap: wrap;
    }

    .upload-many-hero .upload-hero-content {
        flex: 1 1 calc(100% - 120px);
    }

    .upload-manual-button {
        width: 100%;
    }

}

@media (max-width: 576px) {

    .upload-many-dropzone {
        min-height: 250px;
        padding: 28px 16px;
    }

    .upload-many-cloud {
        width: 68px;
        height: 68px;
        font-size: 32px;
    }

    .upload-many-title {
        font-size: 16px;
    }

    .upload-many-limit {
        flex-direction: column;
        gap: 3px;
    }

    .upload-many-summary {
        align-items: flex-start;
    }

    .upload-many-file {
        padding: 11px;
    }

}



/* =========================================================
   LOADING ANIMASI BULOG - TAMBAHAN, TIDAK MENGUBAH UPLOAD LAMA
========================================================= */
.bulog-processing-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(8, 25, 52, .72);
    backdrop-filter: blur(7px);
}

.bulog-processing-overlay.show {
    display: flex;
}

.bulog-processing-card {
    position: relative;
    width: min(720px, 100%);
    max-height: calc(100vh - 40px);
    overflow: auto;
    padding: 26px 30px 24px;
    border: 1px solid rgba(255,255,255,.75);
    border-radius: 24px;
    background: #fff;
    box-shadow: 0 25px 80px rgba(0,0,0,.25);
    text-align: center;
}

.bulog-processing-close {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 34px;
    height: 34px;
    border: 0;
    border-radius: 50%;
    background: #eef3f9;
    color: #9aa8b9;
    cursor: not-allowed;
}

.bulog-scene {
    position: relative;
    height: 150px;
    margin: 0 auto 18px;
    overflow: hidden;
    border-radius: 18px;
    background: linear-gradient(180deg, #edf6ff 0%, #f9fcff 72%, #e8eef5 72%, #e8eef5 100%);
}

.bulog-sky-glow {
    position: absolute;
    width: 180px;
    height: 180px;
    top: -100px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 50%;
    background: rgba(255, 178, 58, .22);
}

.bulog-warehouse {
    position: absolute;
    left: 50%;
    bottom: 17px;
    width: 390px;
    max-width: 78%;
    height: 92px;
    transform: translateX(-50%);
}

.bulog-building {
    position: absolute;
    left: 50%;
    bottom: 0;
    width: 250px;
    height: 78px;
    transform: translateX(-50%);
    border: 3px solid #123b78;
    border-bottom-width: 5px;
    border-radius: 8px 8px 2px 2px;
    background: #fff;
    box-shadow: 0 7px 0 rgba(18,59,120,.08);
}

.bulog-building:before {
    content: '';
    position: absolute;
    left: -12px;
    right: -12px;
    top: -16px;
    height: 20px;
    border-radius: 7px 7px 2px 2px;
    background: #123b78;
    transform: skewX(-25deg);
}

.bulog-sign {
    position: absolute;
    top: 9px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 18px;
    font-weight: 900;
    letter-spacing: 1px;
    color: #123b78;
}

.bulog-sign:before {
    content: '✦';
    margin-right: 5px;
    color: #f28c28;
}

.bulog-door {
    position: absolute;
    left: 50%;
    bottom: 0;
    width: 55px;
    height: 43px;
    transform: translateX(-50%);
    border-radius: 4px 4px 0 0;
    background: #dce8f6;
    border: 2px solid #9bb5d4;
}

.bulog-window {
    position: absolute;
    left: 18px;
    bottom: 18px;
    width: 42px;
    height: 22px;
    border: 2px solid #9bb5d4;
    background: #eaf5ff;
}

.bulog-window.second {
    left: auto;
    right: 18px;
}

.bulog-sack {
    position: absolute;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 47px;
    height: 43px;
    border-radius: 9px 9px 12px 12px;
    background: #f4d7a5;
    border: 2px solid #d5ad70;
    font-size: 20px;
    animation: bulogSackBounce 1.7s ease-in-out infinite;
}

.sack-one { left: 0; animation-delay: .15s; }
.sack-two { right: 0; animation-delay: .55s; }

.bulog-forklift {
    position: absolute;
    left: -65px;
    bottom: 2px;
    width: 48px;
    height: 27px;
    border-radius: 5px;
    background: #f28c28;
    color: #123b78;
    font-size: 0;
    animation: bulogForklift 4s ease-in-out infinite;
}

.bulog-forklift:before, .bulog-forklift:after {
    content: '';
    position: absolute;
    bottom: -7px;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background: #25354b;
}

.bulog-forklift:before { left: 6px; }
.bulog-forklift:after { right: 5px; }

.bulog-ground {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 10px;
    height: 3px;
    background: #cbd7e4;
}

.bulog-processing-icon {
    position: relative;
    width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: -48px auto 12px;
    border-radius: 20px;
    border: 5px solid #fff;
    background: #e8f1ff;
    color: #1458ad;
    font-size: 31px;
    box-shadow: 0 8px 25px rgba(18,59,120,.14);
    animation: bulogFloat 1.8s ease-in-out infinite;
}

.bulog-scan-line {
    position: absolute;
    left: 10px;
    right: 10px;
    top: 10px;
    height: 3px;
    border-radius: 10px;
    background: #f28c28;
    box-shadow: 0 0 9px rgba(242,140,40,.65);
    animation: bulogScan 1.3s linear infinite;
}

.bulog-processing-card h3 {
    margin: 0 0 5px;
    color: #123b78;
    font-size: 23px;
    font-weight: 800;
}

.bulog-processing-desc {
    margin: 0 auto 20px;
    color: #718096;
    font-size: 13px;
}

.bulog-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin: 0 auto 20px;
}

.bulog-step {
    position: relative;
    color: #a1afbf;
    transition: .3s ease;
}

.bulog-step:not(:last-child):after {
    content: '';
    position: absolute;
    top: 18px;
    left: calc(50% + 23px);
    width: calc(100% - 46px);
    height: 2px;
    background: #e1e8f1;
}

.bulog-step span {
    position: relative;
    z-index: 1;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 7px;
    border-radius: 50%;
    background: #edf2f8;
    font-size: 15px;
}

.bulog-step small {
    display: block;
    font-size: 10px;
    font-weight: 700;
}

.bulog-step.active { color: #1458ad; }
.bulog-step.active span { background: #dcecff; box-shadow: 0 0 0 5px #f2f7ff; }
.bulog-step.done { color: #198754; }
.bulog-step.done span { background: #e7f7ef; }
.bulog-step.done:not(:last-child):after { background: #9bd6b6; }

.bulog-progress-wrap { margin-bottom: 18px; }

.bulog-progress-track {
    width: 100%;
    height: 10px;
    overflow: hidden;
    border-radius: 20px;
    background: #e7edf5;
}

.bulog-progress-bar {
    width: 0%;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #1458ad, #2f80ed, #f28c28);
    transition: width .35s ease;
}

.bulog-progress-info {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 7px;
    color: #718096;
    font-size: 11px;
}

.bulog-progress-info strong { color: #123b78; }

.bulog-processing-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 11px 14px;
    border-radius: 12px;
    background: #f1f7ff;
    color: #55708f;
    font-size: 11px;
    text-align: left;
}

.bulog-processing-note > i { color: #1769e8; font-size: 16px; }

@keyframes bulogFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
@keyframes bulogScan { 0% { top: 10px; opacity: .5; } 50% { opacity: 1; } 100% { top: 57px; opacity: .5; } }
@keyframes bulogSackBounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
@keyframes bulogForklift { 0% { transform: translateX(0); } 45%,60% { transform: translateX(125px); } 100% { transform: translateX(0); } }

@media (max-width: 576px) {
    .bulog-processing-card { padding: 22px 16px 18px; border-radius: 18px; }
    .bulog-scene { height: 125px; }
    .bulog-warehouse { transform: translateX(-50%) scale(.82); transform-origin: bottom center; }
    .bulog-processing-icon { margin-top: -42px; }
    .bulog-processing-card h3 { font-size: 19px; }
    .bulog-steps { gap: 2px; }
    .bulog-step small { font-size: 9px; }
    .bulog-step:not(:last-child):after { left: calc(50% + 20px); width: calc(100% - 40px); }
    .bulog-processing-note { align-items: flex-start; }
}

</style>

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('files');
    const preview = document.getElementById('filePreview');
    const summary = document.getElementById('fileSummary');
    const fileCount = document.getElementById('fileCount');
    const btnUpload = document.getElementById('btnUpload');
    const btnChooseAgain = document.getElementById('btnChooseAgain');
    const dropzone = document.getElementById('dropzoneMany');
    const form = document.getElementById('uploadManyForm');

    function formatSize(bytes) {
        return (bytes / 1024 / 1024).toFixed(2) + ' MB';
    }

    function renderFiles() {

        preview.innerHTML = '';

        if (!fileInput.files.length) {
            preview.classList.add('d-none');
            summary.classList.add('d-none');
            btnUpload.disabled = true;
            return;
        }

        const files = Array.from(fileInput.files);

        summary.classList.remove('d-none');
        preview.classList.remove('d-none');
        btnUpload.disabled = false;

        fileCount.textContent =
            files.length + (files.length === 1 ? ' file' : ' file') +
            ' siap untuk diupload';

        const title = document.createElement('div');
        title.className = 'upload-many-preview-title';

        const titleText = document.createElement('span');
        titleText.textContent = 'Daftar file yang dipilih';

        const total = document.createElement('span');
        total.className = 'text-muted fw-normal';
        total.textContent = files.length + ' file';

        title.appendChild(titleText);
        title.appendChild(total);
        preview.appendChild(title);

        files.forEach(function (file, index) {

            const item = document.createElement('div');
            item.className = 'upload-many-file';

            const icon = document.createElement('div');
            icon.className = 'upload-many-file-icon';
            icon.innerHTML =
                '<i class="bi bi-file-earmark-pdf-fill"></i>';

            const info = document.createElement('div');
            info.className = 'upload-many-file-info';

            const name = document.createElement('span');
            name.className = 'upload-many-file-name';
            name.title = file.name;
            name.textContent = file.name;

            const size = document.createElement('span');
            size.className = 'upload-many-file-size';
            size.textContent = formatSize(file.size);

            info.appendChild(name);
            info.appendChild(size);

            const number = document.createElement('div');
            number.className = 'upload-many-file-number';
            number.textContent = index + 1;

            item.appendChild(icon);
            item.appendChild(info);
            item.appendChild(number);

            preview.appendChild(item);
        });
    }

    fileInput.addEventListener('change', renderFiles);

    btnChooseAgain.addEventListener('click', function () {
        fileInput.click();
    });

    ['dragover', 'dragleave', 'drop'].forEach(function (eventName) {
        dropzone.addEventListener(eventName, function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
    });

    dropzone.addEventListener('dragover', function () {
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', function () {
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', function (event) {

        dropzone.classList.remove('dragover');

        if (event.dataTransfer.files.length) {
            fileInput.files = event.dataTransfer.files;
            renderFiles();
        }
    });

    form.addEventListener('submit', function () {

        btnUpload.disabled = true;

        btnUpload.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
            'Memproses Dokumen...';

        const overlay = document.getElementById('bulogProcessingOverlay');
        const progressBar = document.getElementById('bulogProgressBar');
        const progressPercent = document.getElementById('bulogProgressPercent');
        const processingText = document.getElementById('bulogProcessingText');
        const steps = document.querySelectorAll('.bulog-step');

        overlay.classList.add('show');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        const jumlahFile = fileInput.files.length || 1;
        const stages = [
            { percent: 18, text: 'Mengunggah dokumen...', step: 0 },
            { percent: 42, text: 'Membaca file PDF...', step: 1 },
            { percent: 72, text: 'Menjalankan OCR dan membaca informasi...', step: 2 },
            { percent: 90, text: 'Menyimpan dokumen ke arsip BULOG...', step: 3 }
        ];

        let stageIndex = 0;
        let progress = 0;

        function updateProcessingStage() {
            if (stageIndex >= stages.length) return;

            const stage = stages[stageIndex];
            progress = stage.percent;
            progressBar.style.width = progress + '%';
            progressPercent.textContent = progress + '%';
            processingText.textContent = stage.text;

            steps.forEach(function (step, index) {
                step.classList.remove('active', 'done');
                if (index < stage.step) step.classList.add('done');
                if (index === stage.step) step.classList.add('active');
            });

            stageIndex++;
        }

        updateProcessingStage();

        // Animasi hanya sebagai indikator visual selama request Laravel berjalan.
        // Progress nyata tetap ditentukan oleh proses upload/OCR di server.
        const stageTimer = setInterval(function () {
            if (stageIndex < stages.length) {
                updateProcessingStage();
            } else {
                clearInterval(stageTimer);
                progressBar.style.width = '96%';
                progressPercent.textContent = '96%';
                processingText.textContent = 'Menunggu proses selesai...';
            }
        }, Math.max(900, Math.min(1800, 700 + (jumlahFile * 80))));

    });

});

</script>
@endpush

@endsection
