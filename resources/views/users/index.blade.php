@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active">Kelola Pengguna</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Kelola Pengguna</h3>
    <a href="{{ route('users.create') }}" class="btn btn-bulog">
        <i class="bi bi-plus-lg"></i> Tambah Pengguna
    </a>
</div>

<div class="card-panel p-3">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari nama atau email..." value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="text-muted small">
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="fw-semibold d-flex align-items-center gap-2">
                            <div class="avatar-circle bg-bulog-navy">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            {{ $user->name }}
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-bulog-navy' : 'bg-secondary' }}">
                                {{ $user->role === 'admin' ? 'Administrator' : 'User' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                            @if ($user->id !== auth()->id())
                                <button type="button" class="btn btn-sm btn-light text-danger" title="Hapus"
                                        data-bs-toggle="modal" data-bs-target="#hapusUser{{ $user->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <div class="modal fade" id="hapusUser{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <h6 class="fw-bold">Hapus pengguna ini?</h6>
                                                <p class="text-muted small mb-0">Akun "{{ $user->name }}" akan dihapus permanen.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form method="POST" action="{{ route('users.destroy', $user) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
