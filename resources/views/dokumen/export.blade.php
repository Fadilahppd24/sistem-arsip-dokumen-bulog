@extends('layouts.app')

@section('title', 'Ekspor Dokumen')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Ekspor Dokumen</h4>
            <p class="text-muted mb-0">
                Pilih dokumen yang ingin diekspor ke dalam file ZIP.
            </p>
        </div>

        <a href="{{ route('dokumen.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('dokumen.export.process') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Pilih Kategori Dokumen
                    </label>

                    <select name="kategori_id" class="form-select">
                        <option value="">
                            Seluruh Dokumen
                        </option>

                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>

                    <div class="form-text">
                        Pilih kategori tertentu atau "Seluruh Dokumen"
                        untuk mengekspor semua dokumen.
                    </div>
                </div>

                <div class="alert alert-info border-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Dokumen akan dikemas menjadi satu file
                    <strong>ZIP</strong>.
                    File PDF di dalamnya akan dikelompokkan berdasarkan kategori.
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('dokumen.index') }}"
                       class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-file-earmark-zip me-1"></i>
                        Ekspor ke ZIP
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection