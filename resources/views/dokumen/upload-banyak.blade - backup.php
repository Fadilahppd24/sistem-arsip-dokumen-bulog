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

    });

});

</script>
@endpush

@endsection
