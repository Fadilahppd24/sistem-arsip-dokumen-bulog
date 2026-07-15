@extends('layouts.app')

@section('title', 'Sampah Dokumen')

@section('content')

<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                Beranda
            </a>
        </li>
        <li class="breadcrumb-item active">
            Sampah Dokumen
        </li>
    </ol>
</nav>


<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-0">
            <i class="bi bi-trash-fill me-2"></i>
            Sampah Dokumen
        </h3>
        <small class="text-muted">
            Dokumen yang telah dihapus sementara
        </small>
    </div>
</div>


<div class="card-panel p-3">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr class="text-muted small">
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Kategori</th>
                    <th>Diupload Oleh</th>
                    <th>Dihapus Pada</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>


            <tbody>

            @forelse ($dokumens as $i => $dokumen)

                <tr>

                    <td>
                        {{ $dokumens->firstItem() + $i }}
                    </td>


                    <td class="fw-semibold">
                        {{ $dokumen->nama_dokumen }}

                        <br>

                        <small class="text-muted">
                            {{ $dokumen->nomor_keterangan ?? '-' }}
                        </small>
                    </td>


                    <td>
                        {{ $dokumen->kategori->nama ?? '-' }}
                    </td>


                    <td>
                        {{ $dokumen->uploader->name ?? '-' }}
                    </td>


                    <td>
                        {{ $dokumen->deleted_at->format('d M Y H:i') }}
                    </td>


                    <td class="text-end">

                        {{-- Restore --}}
                        <form action="{{ route('dokumen.restore', $dokumen->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-sm btn-success"
                                    title="Restore">

                                <i class="bi bi-arrow-counterclockwise"></i>
                                Restore

                            </button>

                        </form>



                        {{-- Hapus Permanen --}}
                        <form action="{{ route('dokumen.forceDelete', $dokumen->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus permanen dokumen ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-danger">

                                <i class="bi bi-trash-fill"></i>
                                Hapus Permanen

                            </button>

                        </form>


                    </td>

                </tr>


            @empty

                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Tidak ada dokumen di sampah.
                    </td>
                </tr>

            @endforelse


            </tbody>

        </table>

    </div>


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


@endsection