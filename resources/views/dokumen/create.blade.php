@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')

<div class="upload-page">

    {{-- ================= BREADCRUMB ================= --}}
    <div class="sampah-breadcrumb mb-3">
    <a href="{{ route('dashboard') }}">Beranda</a>

    <span>›</span>

    <span>Upload Dokumen</span>
</div>


    {{-- ================= HERO ================= --}}
    <div class="upload-hero d-flex align-items-center gap-4 mb-4">

        <div class="upload-hero-icon-ring">

            <div class="upload-hero-icon">
                <i class="bi bi-cloud-arrow-up-fill"></i>
            </div>

        </div>


        <div class="upload-hero-content">

            <h2 class="fw-bold">
                Upload Dokumen
            </h2>

            <p>
                Tambahkan dokumen baru ke dalam sistem arsip
                dengan mudah dan cepat.
            </p>

        </div>


        <i class="bi bi-stars upload-sparkle s1"></i>
        <i class="bi bi-stars upload-sparkle s2"></i>
        <i class="bi bi-stars upload-sparkle s3"></i>

    </div>


    {{-- ================= UPLOAD CARD ================= --}}
    <div class="upload-card">

        {{-- HEADER --}}

        <div class="upload-card-header">

            <div class="upload-card-header-icon">
    <i class="bi bi-info-circle"></i>
</div>

            <div>

                <h5>
    Informasi Dokumen
</h5>

                <p>
                    Lengkapi informasi dokumen dan pilih
                    file PDF yang ingin disimpan.
                </p>

            </div>

        </div>


        {{-- FORM --}}

        <form
            method="POST"
            action="{{ route('dokumen.store') }}"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="upload-form-body">

                <div class="row g-4">


                    {{-- ================= INFORMASI ================= --}}

                    <div class="col-lg-6">

                        <div class="upload-form-label mb-3">
    <i class="bi bi-pencil-square me-1"></i>
    Detail Dokumen
</div>


                        {{-- KATEGORI --}}

                        <div class="mb-3">

                            <label class="upload-form-label">
                                Kategori
                            </label>

                            <select
                                name="kategori_id"
                                class="form-select @error('kategori_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Pilih kategori
                                </option>

                                @foreach ($kategoris as $kategori)

                                    <option
                                        value="{{ $kategori->id }}"
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}
                                    >
                                        {{ $kategori->nama }}
                                    </option>

                                @endforeach

                            </select>

                            @error('kategori_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- NAMA DOKUMEN --}}

                        <div class="mb-3">

                            <label class="upload-form-label">
                                Nama Dokumen
                            </label>

                            <input
                                type="text"
                                name="nama_dokumen"
                                class="form-control @error('nama_dokumen') is-invalid @enderror"
                                placeholder="Contoh: Laporan Pengolahan Juli 2026"
                                value="{{ old('nama_dokumen') }}"
                                required
                            >

                            @error('nama_dokumen')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- NOMOR / KETERANGAN --}}

                        <div class="mb-3">

                            <label class="upload-form-label">

                                Nomor / Keterangan

                                <span class="text-muted fw-normal">
                                    (Opsional)
                                </span>

                            </label>

                            <input
                                type="text"
                                name="nomor_keterangan"
                                class="form-control"
                                placeholder="Contoh: 123/LAP/PGH/VII/2026"
                                value="{{ old('nomor_keterangan') }}"
                            >

                        </div>


                        {{-- TANGGAL --}}

                        <div class="mb-3">

                            <label class="upload-form-label">
                                Tanggal Dokumen
                            </label>

                            <input
                                id="tanggal_dokumen"
                                type="text"
                                name="tanggal_dokumen"
                                class="form-control @error('tanggal_dokumen') is-invalid @enderror"
                                value="{{ old('tanggal_dokumen') }}"
                                placeholder="Pilih tanggal dokumen"
                                required
                            >

                            @error('tanggal_dokumen')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- DESKRIPSI --}}

                        <div>

                            <label class="upload-form-label">

                                Deskripsi

                                <span class="text-muted fw-normal">
                                    (Opsional)
                                </span>

                            </label>

                            <textarea
                                name="deskripsi"
                                class="form-control"
                                rows="3"
                                placeholder="Tulis deskripsi singkat dokumen..."
                            >{{ old('deskripsi') }}</textarea>

                        </div>

                    </div>


                    {{-- ================= FILE ================= --}}

                    <div class="col-lg-6">

                        <div class="upload-form-label mb-3">
                            <i class="bi bi-cloud-arrow-up-fill me-1"></i>
                            File Dokumen
                        </div>


                        {{-- DROPZONE --}}

                        <label
                            for="file"
                            class="upload-dropzone mb-3"
                            id="dropzone"
                        >

                            <i class="bi bi-cloud-arrow-up fs-1 text-bulog-navy"></i>

                            <div class="fw-semibold mt-2">
                                Klik untuk memilih file
                            </div>

                            <div class="text-muted small">
                                atau drag &amp; drop file di sini
                            </div>

                            <div class="text-muted small">
                                Format: PDF (Maks. 100 MB)
                            </div>


                            <input
                                type="file"
                                name="file"
                                id="file"
                                accept="application/pdf"
                                class="d-none"
                                required
                            >

                        </label>


                        {{-- ERROR FILE --}}

                        @error('file')

                            <div class="text-danger small mb-2">
                                {{ $message }}
                            </div>

                        @enderror


                        {{-- FILE INFO --}}

                        <div
                            id="fileInfo"
                            class="upload-file-info d-none d-flex align-items-center gap-2"
                        >

                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>

                            <div
                                class="flex-grow-1"
                                style="min-width:0;"
                            >

                                <div
                                    class="small fw-semibold text-truncate"
                                    id="fileName"
                                ></div>

                                <div
                                    class="small text-muted"
                                    id="fileSize"
                                ></div>

                            </div>

                            <i class="bi bi-check-circle-fill text-success"></i>

                        </div>


                        {{-- PREVIEW --}}

                        <div
                            id="previewContainer"
                            class="upload-preview-card d-none mt-3"
                        >

                            <div class="upload-preview-header">

                                <h6>
                                    <i class="bi bi-file-earmark-pdf me-1"></i>
                                    Preview Dokumen
                                </h6>

                            </div>


                            <div class="upload-preview-body">

                                <iframe
                                    id="previewFrame"
                                    width="100%"
                                    height="420"
                                    style="border:0; cursor:pointer; display:block;"
                                ></iframe>

                            </div>


                            <div class="text-center p-3">

                                <button
                                    type="button"
                                    id="btnPreview"
                                    class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                                >

                                    <i class="bi bi-arrows-fullscreen"></i>

                                    <span>
                                        Lihat Dokumen Ukuran Penuh
                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= ACTION ================= --}}

            <div
    class="upload-form-actions d-flex justify-content-end align-items-center gap-2 p-3 border-top"
>

                <a
                    href="{{ route('dokumen.index') }}"
                    class="btn btn-light"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="upload-submit"
                >

                    <i class="bi bi-check-lg"></i>

                    Simpan Dokumen

                </button>

            </div>

        </form>

    </div>

</div>


{{-- ================= PREVIEW MODAL ================= --}}

<div
    class="modal fade"
    id="previewModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Preview Dokumen
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body p-0">

                <iframe
                    id="previewFrameModal"
                    width="100%"
                    height="700"
                    style="border:0;"
                ></iframe>

            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>

document.addEventListener("DOMContentLoaded", function () {

   const gambarBulan = [
    "{{ asset('images/calendar/Sunrise_Januari.jpg') }}",
    "{{ asset('images/calendar/Bluesky_Februari.jpg') }}",
    "{{ asset('images/calendar/Forest_Maret.jpg') }}",
    "{{ asset('images/calendar/Sakura_April.jpg') }}",
    "{{ asset('images/calendar/Flower_Mei.jpg') }}",
    "{{ asset('images/calendar/TropicalBeach_Juni.jpg') }}",
    "{{ asset('images/calendar/Sunflower_Juli.jpg') }}",
    "{{ asset('images/calendar/Indonesia_Agustus.jpg') }}",
    "{{ asset('images/calendar/RiceField_September.jpg') }}",
    "{{ asset('images/calendar/AutumnForest_Oktober.jpg') }}",
    "{{ asset('images/calendar/GoldenRice_November.jpg') }}",
    "{{ asset('images/calendar/Winter_Desember.jpg') }}"
];

const localeID = {
    days: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
    daysShort: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
    daysMin: ['Mg','Sn','Sl','Rb','Km','Jm','Sb'],

    months: [
        'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    ],

    monthsShort: [
        'Jan','Feb','Mar','Apr','Mei','Jun',
        'Jul','Agu','Sep','Okt','Nov','Des'
    ],

    today: 'Hari Ini',
    clear: 'Bersihkan',
    dateFormat: 'yyyy-MM-dd',
    firstDay: 1
};

const dp = new AirDatepicker('#tanggal_dokumen', {

    locale: localeID,

    autoClose: true,

    dateFormat: 'yyyy-MM-dd',

    buttons: ['today', 'clear'],

    navTitles: {
        days: 'MMMM yyyy'
    },

    onShow() {
    setTimeout(updateHeader,0);
},

onChangeViewDate() {
    setTimeout(updateHeader,0);
}

});

function updateHeader(){

    const header=document.querySelector(".air-datepicker-nav");

    if(!header) return;

    const bulan=dp.viewDate.getMonth();

    header.style.backgroundImage=`url(${gambarBulan[bulan]})`;

}

updateHeader();

    const fileInput = document.getElementById('file');
    const previewContainer = document.getElementById('previewContainer');
    const previewFrame = document.getElementById('previewFrame');
    const btnPreview = document.getElementById('btnPreview');
    const previewFrameModal = document.getElementById('previewFrameModal');
    const dropzone = document.getElementById('dropzone');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    fileInput.addEventListener('change', function () {
        if (this.files.length) {
            const file = this.files[0];
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            fileInfo.classList.remove('d-none');
            const url = URL.createObjectURL(file);

            previewContainer.classList.remove('d-none');

            previewFrame.src = url;

            previewFrameModal.src = url;
                    }
    });

    ['dragover', 'dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, e => e.preventDefault());
    });
    dropzone.addEventListener('dragover', () => dropzone.classList.add('dragover'));
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
    dropzone.addEventListener('drop', e => {
        dropzone.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
    });

   btnPreview.addEventListener('click', function () {

    if (fileInput.files.length) {

        const url = URL.createObjectURL(fileInput.files[0]);

        previewFrameModal.src = url;

    }

    const modal = new bootstrap.Modal(
        document.getElementById('previewModal')
    );

    modal.show();

});
});

</script>

@endpush
@endsection
