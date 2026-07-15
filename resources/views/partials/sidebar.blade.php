@php
    $user = auth()->user();
@endphp
<aside class="sidebar d-flex flex-column">
   <div class="brand">
    <img src="{{ asset('images/logobulog.png') }}"
         alt="Logo BULOG"
         class="sidebar-logo">
</div>

    <nav class="flex-grow-1 overflow-auto pb-3">
        <div class="nav-section-title">Menu</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> Beranda
                </a>
            </li>
        </ul>

        <div class="nav-section-title">Dokumen</div>
        <ul class="nav flex-column">
            @foreach (\App\Models\Kategori::orderBy('nama')->get() as $kategori)
                <li class="nav-item">
                    <a href="{{ route('dokumen.index', ['kategori_id' => $kategori->id]) }}"
                       class="nav-link {{ request()->routeIs('dokumen.index') && request('kategori_id') == $kategori->id ? 'active' : '' }}">
                        <i class="bi {{ $kategori->icon ?? 'bi-folder-fill' }}"></i> {{ $kategori->nama }}
                    </a>
                </li>
            @endforeach
        </ul>

        @if ($user->isAdmin())
            <div class="nav-section-title">Kelola</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dokumen.create') }}" class="nav-link {{ request()->routeIs('dokumen.create') ? 'active' : '' }}">
                        <i class="bi bi-cloud-arrow-up-fill"></i> Upload Dokumen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dokumen.index') }}" class="nav-link {{ request()->routeIs('dokumen.index') && !request('kategori_id') ? 'active' : '' }}">
                        <i class="bi bi-folder2-open"></i> Kelola Dokumen
                    </a>
                </li>

<li class="nav-item">
    <a href="{{ route('trash.index') }}" 
       class="nav-link {{ request()->routeIs('trash.*') ? 'active' : '' }}">
        <i class="bi bi-trash-fill"></i>
        Sampah Dokumen
    </a>
</li>

            </ul>

           <div class="nav-section-title">Pengaturan</div>
<ul class="nav flex-column">

    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Pengguna
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('audit-log.index') }}" class="nav-link {{ request()->routeIs('audit-log.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Aktivitas
        </a>
    </li>

    <li class="nav-item">
    <a href="{{ route('backup.index') }}" 
       class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}">
        <i class="bi bi-database-fill-down"></i>
        Backup Database
    </a>
</li>

</ul>
        @else
            <div class="nav-section-title">Lainnya</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dokumen.index') }}" class="nav-link {{ request()->routeIs('dokumen.index') && !request('kategori_id') ? 'active' : '' }}">
                        <i class="bi bi-search"></i> Cari Semua Dokumen
                    </a>
                </li>
            </ul>
        @endif
    </nav>

    <div class="sidebar-footer d-flex align-items-center gap-2">
        <div class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div class="flex-grow-1" style="min-width: 0;">
            <div class="text-white small fw-semibold text-truncate">{{ $user->name }}</div>
            <div class="small" style="color:#9db3d9;">{{ $user->isAdmin() ? 'Administrator' : 'User' }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm text-white-50 p-0" title="Keluar">
                <i class="bi bi-box-arrow-right fs-5"></i>
            </button>
        </form>
    </div>
</aside>
