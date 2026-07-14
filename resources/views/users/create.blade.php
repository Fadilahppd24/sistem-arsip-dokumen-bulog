@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Pengguna</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>
</nav>

<h3 class="fw-bold mb-3">Tambah Pengguna</h3>

<div class="card-panel p-4" style="max-width: 560px;">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Role</label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-bulog">Simpan Pengguna</button>
        </div>
    </form>
</div>
@endsection
