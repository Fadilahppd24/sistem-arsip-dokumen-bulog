@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')

<div class="container-fluid px-0">

    {{-- ============================= --}}
    {{-- HEADER --}}
    {{-- ============================= --}}

<div class="mb-4">

    {{-- Breadcrumb --}}
    <div class="d-flex align-items-center gap-2 mb-2 small">

        <a href="{{ route('dashboard') }}"
           class="text-decoration-none"
           style="color:#1d4ed8;">
            Beranda
        </a>

        <span class="text-muted">
            >
        </span>

        <span class="text-muted">
            Kelola Kategori
        </span>

    </div>

{{-- Header Halaman --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        {{-- Breadcrumb --}}
        <div class="d-flex align-items-center gap-2 mb-2 small">
            <a href="{{ route('dashboard') }}"
               class="text-decoration-none"
               style="color:#1d4ed8;">
                Beranda
            </a>

            <span class="text-muted">></span>

            <span class="text-muted">
                Kelola Kategori
            </span>
        </div>

        {{-- Judul --}}
        <h2 class="fw-bold mb-0" style="color:#172554;">
            Kelola Kategori
        </h2>
    </div>

    {{-- Tombol Tambah Kategori --}}
    <button type="button"
            class="btn btn-primary px-4"
            data-bs-toggle="modal"
            data-bs-target="#modalTambahKategori">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Kategori
    </button>

</div>

</div>   

    {{-- ============================= --}}
    {{-- ALERT --}}
    {{-- ============================= --}}

    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm"
             role="alert">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if ($errors->any())

        <div class="alert alert-danger border-0 shadow-sm">

            <strong>
                Terdapat kesalahan:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ============================= --}}
    {{-- CARD UTAMA --}}
    {{-- ============================= --}}

    <div class="card border-0 shadow-sm">

        {{-- HEADER CARD --}}

        <div class="card-body p-0">

            


            {{-- ============================= --}}
            {{-- TAB --}}
            {{-- ============================= --}}

            <div class="px-4 pt-3 border-bottom">

                <ul class="nav nav-tabs border-0">

                    <li class="nav-item">

                        <button class="nav-link active fw-semibold"
                                data-bs-toggle="tab"
                                data-bs-target="#kategoriAktif">

                            Kategori Aktif

                            <span class="badge bg-primary ms-1">
                                {{ $kategoris->count() }}
                            </span>

                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link fw-semibold"
                                data-bs-toggle="tab"
                                data-bs-target="#kategoriTerhapus">

                            Kategori Terhapus

                            <span class="badge bg-secondary ms-1">
                                {{ $kategoriTerhapus->count() }}
                            </span>

                        </button>

                    </li>

                </ul>

            </div>


            <div class="tab-content">


                {{-- ================================================= --}}
                {{-- TAB KATEGORI AKTIF --}}
                {{-- ================================================= --}}

                <div class="tab-pane fade show active"
                     id="kategoriAktif">


                    {{-- SEARCH + FILTER --}}

                    <div class="p-4">

                        <div class="row g-2">

                            <div class="col-md-6">

                                <div class="input-group">

                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>

                                    <input type="text"
                                           id="searchKategori"
                                           class="form-control"
                                           placeholder="Cari kategori...">

                                </div>

                            </div>

                            <div class="col-md-3">

                                <select id="filterWarna"
        class="form-select">

    <option value="">
        Semua Warna
    </option>

    <option value="primary">
        Navy
    </option>

    <option value="warning">
        Kuning
    </option>

    <option value="info">
        Biru Muda
    </option>

    <option value="secondary">
        Abu-abu
    </option>

    <option value="success">
        Hijau
    </option>

    <option value="danger">
        Merah
    </option>

    <option value="purple">
        Ungu
    </option>

    <option value="pink">
        Pink
    </option>

    <option value="teal">
        Teal
    </option>

    <option value="orange">
        Orange
    </option>

    <option value="indigo">
        Indigo
    </option>

    <option value="cyan">
        Cyan
    </option>

</select>

                            </div>

                        </div>

                    </div>


                    {{-- TABLE --}}

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0"
                               id="tabelKategori">

                            <thead class="table-light">

                                <tr class="small text-muted">

                                    <th class="ps-4" style="width:70px;">
                                        No
                                    </th>

                                    <th style="width:90px;">
                                        Icon
                                    </th>

                                    <th>
                                        Nama Kategori
                                    </th>

                                    <th>
                                        Jumlah Dokumen
                                    </th>

                                    <th>
                                        Dibuat Pada
                                    </th>

                                    <th>
                                        Warna
                                    </th>

                                    <th class="text-end pe-4">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                            @forelse ($kategoris as $i => $kategori)

                                <tr class="kategori-row"
                                    data-nama="{{ strtolower($kategori->nama) }}"
                                    data-warna="{{ $kategori->warna ?? 'secondary' }}">


                                    {{-- NO --}}

                                    <td class="ps-4">
                                        {{ $i + 1 }}
                                    </td>


                                    {{-- ICON --}}

                                    <td>

                                        @php
    $warnaIcon = [
        'primary'   => 'kategori-primary',
        'warning'   => 'kategori-warning',
        'info'      => 'kategori-info',
        'secondary' => 'kategori-secondary',
        'success'   => 'kategori-success',
        'danger'    => 'kategori-danger',
        'purple'    => 'kategori-purple',
        'pink'      => 'kategori-pink',
        'teal'      => 'kategori-teal',
        'orange'    => 'kategori-orange',
        'indigo'    => 'kategori-indigo',
        'cyan'      => 'kategori-cyan',
    ];
@endphp

<div class="kategori-icon-box {{ $warnaIcon[$kategori->warna] ?? 'kategori-secondary' }}">
    <i class="bi {{ $kategori->icon ?? 'bi-folder-fill' }}"></i>
</div>

                                    </td>


                                    {{-- NAMA --}}

                                    <td>

                                        <div class="fw-semibold">

                                            {{ $kategori->nama }}

                                        </div>

                                    </td>


                                    {{-- JUMLAH DOKUMEN --}}

                                    <td>

                                        @if ($kategori->dokumens_count > 0)

                                            <span class="badge bg-light text-dark border">

                                                {{ $kategori->dokumens_count }}
                                                dokumen

                                            </span>

                                        @else

                                            <span class="badge bg-success-subtle text-success border">

                                                0 dokumen

                                            </span>

                                        @endif

                                    </td>


                                    {{-- DIBUAT --}}

                                    <td>

                                        <small class="text-muted">

                                            {{ $kategori->created_at?->format('d M Y H:i') }}

                                        </small>

                                    </td>

                                    {{-- WARNA --}}
<td>
    @php
        $warnaLabel = [
            'primary'   => 'Navy',
            'warning'   => 'Kuning',
            'info'      => 'Biru Muda',
            'secondary' => 'Abu-abu',
            'success'   => 'Hijau',
            'danger'    => 'Merah',
            'purple'    => 'Ungu',
            'pink'      => 'Pink',
            'teal'      => 'Teal',
            'orange'    => 'Orange',
            'indigo'    => 'Indigo',
            'cyan'      => 'Cyan',
        ];

        $warnaClass = [
            'primary'   => 'warna-navy',
            'warning'   => 'warna-kuning',
            'info'      => 'warna-biru-muda',
            'secondary' => 'warna-abu',
            'success'   => 'warna-hijau',
            'danger'    => 'warna-merah',
            'purple'    => 'warna-ungu',
            'pink'      => 'warna-pink',
            'teal'      => 'warna-teal',
            'orange'    => 'warna-orange',
            'indigo'    => 'warna-indigo',
            'cyan'      => 'warna-cyan',
        ];
    @endphp

    <div class="warna-kategori">
        <span class="warna-dot {{ $warnaClass[$kategori->warna] ?? 'warna-abu' }}"></span>

        <span class="warna-label">
            {{ $warnaLabel[$kategori->warna] ?? 'Abu-abu' }}
        </span>
    </div>
</td>


                                    {{-- AKSI --}}

                                    <td class="text-end pe-4">

                                        <div class="d-inline-flex gap-1">


                                            {{-- EDIT --}}

                                            <button type="button"
                                                    class="btn btn-sm btn-light border"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit{{ $kategori->id }}"
                                                    title="Edit kategori">

                                                <i class="bi bi-pencil"></i>

                                            </button>


                                            {{-- NONAKTIFKAN --}}

                                            <form action="{{ route('kategori.destroy', $kategori) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Nonaktifkan kategori {{ $kategori->nama }}?')">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-light border text-danger"
                                                        title="Nonaktifkan kategori">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="text-center py-5 text-muted">

                                        <i class="bi bi-folder-x fs-1 d-block mb-2"></i>

                                        Belum ada kategori.

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- FOOTER TABLE --}}

                    <div class="px-4 py-3 border-top">

                        <small class="text-muted">

                            Menampilkan
                            {{ $kategoris->count() }}
                            kategori aktif

                        </small>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TAB KATEGORI TERHAPUS --}}
                {{-- ================================================= --}}

                <div class="tab-pane fade"
                     id="kategoriTerhapus">


                    <div class="p-4">

                        <div class="alert alert-info border-0">

                            <div class="d-flex align-items-start">

                                <i class="bi bi-info-circle-fill me-2 mt-1"></i>

                                <div>

                                    <strong>Kategori yang dinonaktifkan</strong>

                                    <div class="small mt-1">

                                        Kategori yang dinonaktifkan tidak dapat digunakan
                                        untuk dokumen baru, tetapi dokumen lama tetap aman.

                                        Kategori dapat dipulihkan kapan saja.

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr class="small text-muted">

                                        <th style="width:70px;">
                                            No
                                        </th>

                                        <th>
                                            Nama Kategori
                                        </th>

                                        <th>
                                            Jumlah Dokumen
                                        </th>

                                        <th>
                                            Dinonaktifkan
                                        </th>

                                        <th class="text-end">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                @forelse ($kategoriTerhapus as $i => $kategori)

                                    <tr>

                                        <td>
                                            {{ $i + 1 }}
                                        </td>

                                        <td>

                                            <span class="fw-semibold text-muted">

                                                {{ $kategori->nama }}

                                            </span>

                                        </td>

                                        <td>

                                            {{ $kategori->dokumens_count }}
                                            dokumen

                                        </td>

                                        <td>

                                            <small class="text-muted">

                                                {{ $kategori->deleted_at?->format('d M Y H:i') }}

                                            </small>

                                        </td>

                                        <td class="text-end">


                                            {{-- RESTORE --}}

                                            <form action="{{ route('kategori.restore', $kategori->id) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf

                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success">

                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>

                                                    Pulihkan

                                                </button>

                                            </form>


                                            {{-- FORCE DELETE --}}

                                            <form action="{{ route('kategori.forceDelete', $kategori->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus kategori ini secara permanen? Data yang sudah dihapus tidak dapat dikembalikan.')">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">

                                                    <i class="bi bi-trash3"></i>

                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5"
                                            class="text-center py-5 text-muted">

                                            <i class="bi bi-check-circle fs-1 d-block mb-2"></i>

                                            Tidak ada kategori yang dinonaktifkan.

                                        </td>

                                    </tr>

                                @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- INFORMASI --}}
    {{-- ============================= --}}

    <div class="row g-3 mt-3">

        <div class="col-md-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-diagram-3 me-2 text-primary"></i>
                        Alur Kelola Kategori
                    </h5>


                    <div class="row g-3">


                        {{-- TAMBAH --}}

                        <div class="col-md-3">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="d-flex align-items-center mb-3">

                                    <span class="badge rounded-pill bg-primary me-2">
                                        1
                                    </span>

                                    <strong class="small">
                                        Tambah
                                    </strong>

                                </div>

                                <p class="small text-muted mb-0">

                                    Tambahkan kategori dokumen baru
                                    melalui tombol <strong>Tambah Kategori</strong>.

                                </p>

                            </div>

                        </div>


                        {{-- EDIT --}}

                        <div class="col-md-3">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="d-flex align-items-center mb-3">

                                    <span class="badge rounded-pill bg-primary me-2">
                                        2
                                    </span>

                                    <strong class="small">
                                        Edit
                                    </strong>

                                </div>

                                <p class="small text-muted mb-0">

                                    Ubah nama, icon, atau warna
                                    kategori yang sudah tersedia.

                                </p>

                            </div>

                        </div>


                        {{-- NONAKTIFKAN --}}

                        <div class="col-md-3">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="d-flex align-items-center mb-3">

                                    <span class="badge rounded-pill bg-warning text-dark me-2">
                                        3
                                    </span>

                                    <strong class="small">
                                        Nonaktifkan
                                    </strong>

                                </div>

                                <p class="small text-muted mb-0">

                                    Kategori tidak digunakan untuk
                                    dokumen baru, tetapi data tetap aman.

                                </p>

                            </div>

                        </div>


                        {{-- RESTORE --}}

                        <div class="col-md-3">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="d-flex align-items-center mb-3">

                                    <span class="badge rounded-pill bg-success me-2">
                                        4
                                    </span>

                                    <strong class="small">
                                        Pulihkan
                                    </strong>

                                </div>

                                <p class="small text-muted mb-0">

                                    Kategori yang dinonaktifkan
                                    dapat dipulihkan kembali.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- INFO --}}

        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h6 class="fw-bold text-primary mb-3">

                        <i class="bi bi-info-circle me-2"></i>

                        Informasi

                    </h6>

                    <p class="small text-muted mb-0">

                        Kategori yang dinonaktifkan tidak dapat digunakan
                        pada dokumen baru.

                        Namun dokumen lama tetap aman dan masih menggunakan
                        kategori tersebut.

                        Kategori juga dapat dikembalikan melalui menu
                        <strong>Kategori Terhapus</strong>.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- MODAL EDIT KATEGORI --}}
{{-- ================================================= --}}

@foreach ($kategoris as $kategori)

<div class="modal fade"
     id="modalEdit{{ $kategori->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Edit Kategori
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <form action="{{ route('kategori.update', $kategori) }}"
                  method="POST">

                @csrf

                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Nama Kategori
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               value="{{ $kategori->nama }}"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Icon
                        </label>

                        <input type="text"
                               name="icon"
                               class="form-control"
                               value="{{ $kategori->icon }}">

                    </div>


                    <div>

                        <label class="form-label fw-semibold">
                            Warna
                        </label>

 
@php
    $warnaTersedia = [
        'primary'   => 'Navy',
        'warning'   => 'Kuning',
        'info'      => 'Biru Muda',
        'secondary' => 'Abu-abu',
        'success'   => 'Hijau',
        'danger'    => 'Merah',
        'purple'    => 'Ungu',
        'pink'      => 'Pink',
        'teal'      => 'Teal',
        'orange'    => 'Orange',
        'indigo'    => 'Indigo',
        'cyan'      => 'Cyan',
    ];

    $warnaTerpakai = $kategoris
        ->where('id', '!=', $kategori->id)
        ->pluck('warna')
        ->filter()
        ->toArray();
@endphp

<select name="warna" class="form-select">

    @foreach ($warnaTersedia as $value => $label)

        <option value="{{ $value }}"
            {{ $kategori->warna === $value ? 'selected' : '' }}
            {{ in_array($value, $warnaTerpakai) ? 'disabled' : '' }}>

            {{ $label }}

            @if (in_array($value, $warnaTerpakai))
                (sudah digunakan)
            @endif

        </option>

    @endforeach

</select>

        <option value="{{ $value }}"
            {{ $kategori->warna === $value ? 'selected' : '' }}>

            {{ $label }}

        </option>

    @endforeach

</select>


                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-lg me-1"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</div>

{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Tambah Kategori
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Kategori
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Masukkan nama kategori"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Icon
                        </label>

                        <input type="text"
                               name="icon"
                               class="form-control"
                               placeholder="Contoh: bi-folder-fill">
                    </div>

                    <div class="mb-3">
    <label class="form-label fw-semibold">
        Warna
    </label>

    <div class="form-control bg-light text-muted">
        <i class="bi bi-magic me-1"></i>
        Warna akan dipilih otomatis oleh sistem
    </div>
</div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Simpan Kategori
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


@endsection


{{-- ================================================= --}}
{{-- JAVASCRIPT SEARCH + FILTER --}}
{{-- ================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchKategori');
    const filterWarna = document.getElementById('filterWarna');
    const rows = document.querySelectorAll('.kategori-row');


    function filterKategori() {

        const search = searchInput.value.toLowerCase();
        const warna = filterWarna.value;


        rows.forEach(function (row) {

            const nama = row.dataset.nama;
            const rowWarna = row.dataset.warna;


            const cocokNama =
                nama.includes(search);

            const cocokWarna =
                !warna || rowWarna === warna;


            row.style.display =
                cocokNama && cocokWarna
                    ? ''
                    : 'none';

        });

    }


    searchInput.addEventListener(
        'input',
        filterKategori
    );


    filterWarna.addEventListener(
        'change',
        filterKategori
    );

});

</script>

@endpush