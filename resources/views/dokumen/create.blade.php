@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active">Upload Dokumen</li>
    </ol>
</nav>

<h3 class="fw-bold mb-3">Upload Dokumen</h3>

<form method="POST" action="{{ route('dokumen.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card-panel p-4 h-100">
                <h6 class="fw-bold mb-3">Informasi Dokumen</h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Dokumen</label>
                    <input type="text" name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror"
                           placeholder="Contoh: Laporan Pengolahan Juli 2026" value="{{ old('nama_dokumen') }}" required>
                    @error('nama_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor / Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="nomor_keterangan" class="form-control"
                           placeholder="Contoh: 123/LAP/PGH/VII/2026" value="{{ old('nomor_keterangan') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Dokumen</label>
                   <input
    id="tanggal_dokumen"
    type="text"
    name="tanggal_dokumen"
    class="form-control @error('tanggal_dokumen') is-invalid @enderror"
    value="{{ old('tanggal_dokumen') }}"
    placeholder="Pilih tanggal dokumen"
    required
>

                    @error('tanggal_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold">Deskripsi <span class="text-muted fw-normal">(Opsional)</span></label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tulis deskripsi singkat dokumen...">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-panel p-4 h-100 d-flex flex-column">
                <h6 class="fw-bold mb-3">File Dokumen (PDF)</h6>

                <label for="file" class="upload-dropzone mb-3" id="dropzone">
                    <i class="bi bi-cloud-arrow-up fs-1 text-bulog-navy"></i>
                    <div class="fw-semibold mt-2">Klik untuk memilih file</div>
                    <div class="text-muted small">atau drag &amp; drop file di sini</div>
                    <div class="text-muted small">Format: PDF (Maks. 100 MB)</div>
                    <input type="file" name="file" id="file" accept="application/pdf" class="d-none" required>
                </label>
                @error('file') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                <div id="fileInfo" class="d-none border rounded p-2 d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="small fw-semibold text-truncate" id="fileName"></div>
                        <div class="small text-muted" id="fileSize"></div>
                    </div>
                    <i class="bi bi-check-circle-fill text-success"></i>
                </div>

                <div id="previewContainer" class="d-none mt-3">

                    <label class="form-label fw-semibold">
                        Preview Dokumen
                    </label>

                    <div class="border rounded overflow-hidden position-relative" style="isolation: isolate;">

    <iframe
        id="previewFrame"
        width="100%"
        height="420"
        style="border:0; cursor:pointer; display:block;">
    </iframe>

</div>

<div class="text-center mt-4 pt-2">

    <button
        type="button"
        id="btnPreview"
        class="btn btn-outline-primary d-inline-flex align-items-center gap-2">

        <i class="bi bi-arrows-fullscreen"></i>
        <span>Lihat Dokumen Ukuran Penuh</span>

    </button>

</div>

                </div>

                <div class="mt-auto d-flex justify-content-end gap-2 pt-3">
                    <a href="{{ route('dokumen.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-bulog"><i class="bi bi-check-lg"></i> Simpan Dokumen</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="previewModal" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Preview Dokumen
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body p-0">

                <iframe
                    id="previewFrameModal"
                    width="100%"
                    height="700"
                    style="border:0;">
                </iframe>

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
