@php
    $user = auth()->user();
@endphp
<header class="topbar d-flex align-items-center justify-content-between">
    <div>
        <button class="btn btn-sm btn-light d-lg-none"><i class="bi bi-list fs-5"></i></button>
    </div>

    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-light position-relative">
            <i class="bi bi-bell-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.5rem;">
                &nbsp;<span class="visually-hidden">notifikasi baru</span>
            </span>
        </button>
        <button class="btn btn-sm btn-light"><i class="bi bi-moon-fill"></i></button>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                <div class="avatar-circle bg-bulog-navy">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="d-none d-md-block text-start">
                    <div class="small fw-semibold lh-1">{{ $user->name }}</div>
                    <div class="small text-muted" style="font-size:.72rem;">{{ $user->isAdmin() ? 'Administrator' : 'User' }}</div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
