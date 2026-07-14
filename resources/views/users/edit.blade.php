@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Pengguna</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<h3 class="fw-bold mb-3">Edit Pengguna</h3>

<div class="card-panel p-4" style="max-width: 560px;">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Role</label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Password Baru <span class="text-muted fw-normal">(kosongkan jika tidak diganti)</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-bulog">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
