@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')

<style>
/* =========================================================
   EDIT PENGGUNA
========================================================= */

.edit-user-wrapper {
    max-width: 850px;
    margin: 25px auto 50px;
}

/* Card utama */
.edit-user-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
}

/* Header */
.edit-user-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 24px 28px;
    border-bottom: 1px solid #e5e7eb;
    background: #ffffff;
}

.edit-user-icon {
    width: 58px;
    height: 58px;
    min-width: 58px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e8f0ff;
    color: #0d6efd;
    font-size: 26px;
}

.edit-user-header h4 {
    margin: 0;
    font-size: 21px;
    font-weight: 700;
    color: #172033;
}

.edit-user-header p {
    margin: 4px 0 0;
    font-size: 13px;
    color: #64748b;
}

/* Isi */
.edit-user-body {
    padding: 28px;
}

/* Field */
.user-field {
    margin-bottom: 22px;
}

.user-field label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}

.user-field label i {
    font-size: 16px;
    color: #2563eb;
}

/* Input wrapper */
.user-input-wrapper {
    position: relative;
}

.user-input-wrapper > i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 17px;
    z-index: 2;
    pointer-events: none;
}

/* Input */
.edit-user-card .form-control,
.edit-user-card .form-select {
    min-height: 48px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #1e293b;
    padding-left: 44px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.edit-user-card .form-control:focus,
.edit-user-card .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

/* Select */
.edit-user-card .form-select {
    padding-left: 44px;
    cursor: pointer;
}

/* Password */
.password-wrapper .form-control {
    padding-right: 52px;
}

.password-toggle {
    position: absolute;
    right: 7px;
    top: 7px;
    width: 34px;
    height: 34px;
    border: none;
    border-radius: 7px;
    background: transparent;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.password-toggle:hover {
    background: #f1f5f9;
    color: #2563eb;
}

/* Helper text */
.password-help {
    display: block;
    margin-top: 7px;
    font-size: 12px;
    color: #64748b;
}

/* Tombol */
.edit-user-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 8px;
    margin-top: 5px;
    border-top: 1px solid #e5e7eb;
}

.btn-cancel-user {
    min-height: 44px;
    padding: 0 20px;
    border-radius: 9px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #334155;
    font-weight: 600;
    transition: 0.2s ease;
}

.btn-cancel-user:hover {
    background: #f8fafc;
    border-color: #94a3b8;
}

.btn-save-user {
    min-height: 44px;
    padding: 0 22px;
    border-radius: 9px;
    border: none;
    background: #0d6efd;
    color: #ffffff;
    font-weight: 600;
    transition: 0.2s ease;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.22);
}

.btn-save-user:hover {
    background: #0b5ed7;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.28);
}


/* =========================================================
   MODE GELAP
========================================================= */

body.dark-mode .edit-user-card,
body.dark .edit-user-card,
.dark-mode .edit-user-card {
    background: #1e293b !important;
    border-color: #334155 !important;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
}

body.dark-mode .edit-user-header,
body.dark .edit-user-header,
.dark-mode .edit-user-header {
    background: #1e293b !important;
    border-color: #334155 !important;
}

body.dark-mode .edit-user-icon,
body.dark .edit-user-icon,
.dark-mode .edit-user-icon {
    background: rgba(37, 99, 235, 0.18) !important;
    color: #60a5fa !important;
}

body.dark-mode .edit-user-header h4,
body.dark .edit-user-header h4,
.dark-mode .edit-user-header h4 {
    color: #f8fafc !important;
}

body.dark-mode .edit-user-header p,
body.dark .edit-user-header p,
.dark-mode .edit-user-header p {
    color: #94a3b8 !important;
}

body.dark-mode .user-field label,
body.dark .user-field label,
.dark-mode .user-field label {
    color: #e2e8f0 !important;
}

body.dark-mode .user-field label i,
body.dark .user-field label i,
.dark-mode .user-field label i {
    color: #60a5fa !important;
}

body.dark-mode .edit-user-card .form-control,
body.dark-mode .edit-user-card .form-select,
body.dark .edit-user-card .form-control,
body.dark .edit-user-card .form-select,
.dark-mode .edit-user-card .form-control,
.dark-mode .edit-user-card .form-select {
    background: #0f172a !important;
    color: #f1f5f9 !important;
    border-color: #475569 !important;
}

body.dark-mode .edit-user-card .form-control::placeholder,
body.dark .edit-user-card .form-control::placeholder,
.dark-mode .edit-user-card .form-control::placeholder {
    color: #64748b !important;
}

body.dark-mode .user-input-wrapper > i,
body.dark .user-input-wrapper > i,
.dark-mode .user-input-wrapper > i {
    color: #94a3b8 !important;
}

body.dark-mode .edit-user-card .form-control:focus,
body.dark-mode .edit-user-card .form-select:focus,
body.dark .edit-user-card .form-control:focus,
body.dark .edit-user-card .form-select:focus,
.dark-mode .edit-user-card .form-control:focus,
.dark-mode .edit-user-card .form-select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
}

body.dark-mode .password-help,
body.dark .password-help,
.dark-mode .password-help {
    color: #94a3b8 !important;
}

body.dark-mode .edit-user-footer,
body.dark .edit-user-footer,
.dark-mode .edit-user-footer {
    border-color: #334155 !important;
}

body.dark-mode .btn-cancel-user,
body.dark .btn-cancel-user,
.dark-mode .btn-cancel-user {
    background: #334155 !important;
    border-color: #475569 !important;
    color: #e2e8f0 !important;
}

body.dark-mode .btn-cancel-user:hover,
body.dark .btn-cancel-user:hover,
.dark-mode .btn-cancel-user:hover {
    background: #475569 !important;
}

body.dark-mode .password-toggle:hover,
body.dark .password-toggle:hover,
.dark-mode .password-toggle:hover {
    background: #334155 !important;
    color: #60a5fa !important;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {
    .edit-user-wrapper {
        margin: 15px auto 30px;
    }

    .edit-user-header {
        padding: 20px;
    }

    .edit-user-body {
        padding: 20px;
    }

    .edit-user-footer {
        flex-direction: column-reverse;
    }

    .btn-cancel-user,
    .btn-save-user {
        width: 100%;
    }
}
</style>


<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                Beranda
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                Pengguna
            </a>
        </li>

        <li class="breadcrumb-item active">
            Edit
        </li>
    </ol>
</nav>


<div class="edit-user-wrapper">

    <div class="edit-user-card">

        {{-- HEADER --}}
        <div class="edit-user-header">

            <div class="edit-user-icon">
                <i class="bi bi-person"></i>
            </div>

            <div>
                <h4>Edit Pengguna</h4>
                <p>Perbarui informasi akun pengguna</p>
            </div>

        </div>


        {{-- FORM --}}
        <div class="edit-user-body">

            <form method="POST" action="{{ route('users.update', $user) }}">

                @csrf
                @method('PUT')


                {{-- NAMA --}}
                <div class="user-field">

                    <label>
                        <i class="bi bi-person"></i>
                        Nama Lengkap
                    </label>

                    <div class="user-input-wrapper">

                        <i class="bi bi-person"></i>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            required
                        >

                    </div>

                    @error('name')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div class="user-field">

                    <label>
                        <i class="bi bi-envelope"></i>
                        Email
                    </label>

                    <div class="user-input-wrapper">

                        <i class="bi bi-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}"
                            required
                        >

                    </div>

                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- ROLE --}}
                <div class="user-field">

                    <label>
                        <i class="bi bi-shield-check"></i>
                        Role
                    </label>

                    <div class="user-input-wrapper">

                        <i class="bi bi-shield-check"></i>

                        <select
                            name="role"
                            class="form-select @error('role') is-invalid @enderror"
                            required
                        >
                            <option value="user"
                                {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                User
                            </option>

                            <option value="admin"
                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>

                    </div>

                    @error('role')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div class="user-field mb-4">

                    <label>
                        <i class="bi bi-lock"></i>
                        Password Baru
                    </label>

                    <div class="user-input-wrapper password-wrapper">

                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="new-password"
                            placeholder="Masukkan password baru"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            tabindex="-1"
                            aria-label="Tampilkan password"
                        >
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>

                    </div>

                    <span class="password-help">
                        Kosongkan jika tidak ingin mengubah password
                    </span>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- BUTTON --}}
                <div class="edit-user-footer">

                    <a
                        href="{{ route('users.index') }}"
                        class="btn-cancel-user text-decoration-none d-flex align-items-center justify-content-center gap-2"
                    >
                        <i class="bi bi-x-lg"></i>
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-save-user d-flex align-items-center justify-content-center gap-2"
                    >
                        <i class="bi bi-check2"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (togglePassword && password && passwordIcon) {

        togglePassword.addEventListener('click', function () {

            if (password.type === 'password') {

                password.type = 'text';

                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');

            } else {

                password.type = 'password';

                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');

            }

        });

    }

});
</script>

@endsection