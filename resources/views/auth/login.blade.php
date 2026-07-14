@extends('layouts.guest')

@section('title', 'Masuk - Sistem Arsip Dokumen BULOG')

@section('content')
<div class="login-wrapper">
    <div class="row g-0 w-100">
        <div class="col-lg-6 login-hero d-none d-lg-flex flex-column justify-content-between p-5">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-box-seam-fill brand-icon fs-2"></i>
                <div>
                    <div class="fw-bold fs-4 lh-1">BULOG</div>
                    <div class="small text-white-50">mengantarkan kebaikan</div>
                </div>
            </div>

            <div>
                <h1 class="display-6 fw-bold mb-3">Sistem Arsip<br>Dokumen BULOG</h1>
                <p class="text-white-50 mb-0" style="max-width: 380px;">
                    Kelola, simpan, dan temukan dokumen dengan mudah dan aman.
                </p>
            </div>

            <div class="small text-white-50">&copy; {{ date('Y') }} BULOG. All rights reserved.</div>
        </div>

        <div class="col-lg-6 d-flex align-items-center justify-content-center login-card p-4">
            <div style="max-width: 380px; width: 100%;">
                <div class="d-lg-none text-center mb-4">
                    <i class="bi bi-box-seam-fill text-bulog-navy fs-1"></i>
                    <div class="fw-bold fs-4 text-bulog-navy">BULOG</div>
                </div>

                <h2 class="fw-bold mb-1">Selamat Datang</h2>
                <p class="text-muted mb-4">Silakan masuk untuk melanjutkan</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                               placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                   placeholder="Masukkan password Anda" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label small" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-bulog btn-lg w-100">Masuk</button>
                </form>

                <p class="text-center text-muted small mt-4 mb-0">
                    Sistem hanya dapat diakses oleh<br>pegawai BULOG yang terdaftar.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>
@endsection
