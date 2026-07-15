@extends('layouts.app')

@section('title', 'Edit Dokumen')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}" class="text-decoration-none">Dokumen</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<h3 class="fw-bold mb-3">Edit Dokumen</h3>

<form method="POST" action="{{ route('dokumen.update', $dokumen) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card-panel p-4 h-100">
                <h6 class="fw-bold mb-3">Informasi Dokumen</h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $dokumen->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Dokumen</label>
                    <input type="text" name="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror"
                           value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" required>
                    @error('nama_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor / Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="nomor_keterangan" class="form-control" value="{{ old('nomor_keterangan', $dokumen->nomor_keterangan) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Dokumen</label>
                    <input type="date" name="tanggal_dokumen" class="form-control @error('tanggal_dokumen') is-invalid @enderror"
                           value="{{ old('tanggal_dokumen', $dokumen->tanggal_dokumen->format('Y-m-d')) }}" required>
                    @error('tanggal_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold">Deskripsi <span class="text-muted fw-normal">(Opsional)</span></label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-panel p-4 h-100 d-flex flex-column">
                <h6 class="fw-bold mb-3">File Dokumen (PDF)</h6>

                <div class="border rounded p-2 d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="small fw-semibold text-truncate">{{ basename($dokumen->file_path) }}</div>
                        <div class="small text-muted">{{ $dokumen->ukuran_format }} &middot; file saat ini</div>
                    </div>
                    <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a>
                </div>

                <label for="file" class="upload-dropzone mb-3" id="dropzone">
                    <i class="bi bi-cloud-arrow-up fs-1 text-bulog-navy"></i>
                    <div class="fw-semibold mt-2">Klik untuk mengganti file</div>
                    <div class="text-muted small">atau drag &amp; drop file baru di sini</div>
                    <div class="text-muted small">Format: PDF (Maks. 50 MB) — kosongkan jika tidak ingin mengganti</div>
                    <input type="file" name="file" id="file" accept="application/pdf" class="d-none">
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

                <div class="mt-auto d-flex justify-content-end gap-2 pt-3">
                    <a href="{{ route('dokumen.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-bulog"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    const fileInput = document.getElementById('file');
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
</script>
@endpush
@endsection
