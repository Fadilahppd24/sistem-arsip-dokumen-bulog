@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="dashboard-header dashboard-header-hero mb-4">

<div class="pet-runner">
    <div class="pet-move">
        <div class="pet-bounce">
            <span class="pet-cargo">🌾</span>
            <span class="pet-emoji">🐦</span>
        </div>
    </div>
</div>

    <div class="hero-sparkles">
    <span class="sparkle s1">✦</span>
    <span class="sparkle s2">✦</span>
    <span class="sparkle s3">✦</span>
    <span class="sparkle s4">✦</span>
</div>

<div class="d-flex align-items-center flex-wrap gap-4">

    <div class="hero-icon-circle">
        <img src="{{ asset('images/dashboard/hero-icon-v2.svg') }}" alt="Ilustrasi Dokumen" class="hero-icon-img">
    </div>

    <div class="flex-grow-1">
        <h2 class="fw-bold mb-2">
            Selamat Datang Kembali <span class="wave-emoji">👋</span><br>
            Di Sistem Arsip Dokumen BULOG
        </h2>

        <p class="text-muted mb-0">
            Kelola dan akses dokumen dengan lebih mudah dan cepat.
        </p>
    </div>

    <div class="hero-logo d-none d-lg-block">
        <img src="{{ asset('images/dashboard/logobulog-color.png') }}" alt="BULOG" class="hero-logo-img hero-logo-light">
        <img src="{{ asset('images/dashboard/logobulog-white-ribbon.png') }}" alt="BULOG" class="hero-logo-img hero-logo-dark">
    </div>

</div>
</div>

<div class="row g-3 mb-4">
    
    @foreach ($kategoris as $kategori)
        <div class="col-6 col-lg-3">
            <a href="{{ route('dokumen.index', ['kategori_id' => $kategori->id]) }}" class="text-decoration-none">
                <div class="stat-card stat-card-{{ $kategori->warna }} d-flex align-items-start justify-content-between h-100">
                    <div class="d-flex gap-3">
                       <div class="stat-icon kategori-icon-{{ $kategori->warna ?? 'secondary' }}">
    <i class="bi {{ $kategori->icon ?? 'bi-folder-fill' }}"></i>
</div>
                        <div>

    <div class="kategori-title">
        {{ $kategori->nama }}
    </div>

    <div class="d-flex align-items-end gap-2 mt-1">

        <div class="stat-number">
            {{ $kategori->dokumens_count }}
        </div>

        <div class="jumlah-dokumen">
            Dokumen
        </div>

    </div>

    <div class="persentase-dokumen">
        {{ $totalDokumen > 0 ? round(($kategori->dokumens_count / $totalDokumen) * 100, 1) : 0 }}%
        dari total
    </div>

</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="storage-card mb-4">
    <div class="d-flex align-items-center gap-4 flex-wrap position-relative" style="z-index:1;">
        <div class="storage-icon">
            <i class="bi bi-hdd-stack-fill"></i>
        </div>
        <div class="flex-grow-1" style="min-width:240px;">
            <h6 class="fw-bold mb-1">Penyimpanan Arsip</h6>
            <p class="text-muted small mb-0">Kapasitas penyimpanan dokumen yang telah digunakan</p>
        </div>
        <div class="text-end">
            <div class="fw-bold storage-usage-text">{{ $storageUsedGB }} GB / {{ $storageTotalGB }} GB</div>
        </div>
        <span class="storage-status storage-status-{{ Str::slug($storageStatus) }}">
            <i class="bi bi-circle-fill"></i> Status : {{ $storageStatus }}
        </span>
    </div>

    <div class="storage-progress mt-3">
        <div class="storage-progress-bar" style="width: {{ min($storagePercent, 100) }}%;"></div>
    </div>
    <div class="text-muted small mt-2">{{ $storagePercent }}% Terpakai</div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-panel p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
    <i class="bi bi-clock-history text-bulog-navy"></i>
    Dokumen Terbaru
</h6>
                <a href="{{ route('dokumen.index') }}" class="small text-decoration-none">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-muted small">
                            <th>Nama Dokumen</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Diupload Oleh</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumenTerbaru as $dokumen)
                            <tr>
                                <td>

<div class="d-flex align-items-center gap-3">

    <div class="file-icon">

        @php
            $ext = pathinfo($dokumen->file_path, PATHINFO_EXTENSION);
        @endphp

        @if($ext=='pdf')
            <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
        @elseif(in_array($ext,['doc','docx']))
            <i class="bi bi-file-earmark-word-fill text-primary"></i>
        @elseif(in_array($ext,['xls','xlsx']))
            <i class="bi bi-file-earmark-excel-fill text-success"></i>
        @else
            <i class="bi bi-file-earmark-fill"></i>
        @endif

    </div>

    <span class="fw-semibold">
        {{ $dokumen->nama_dokumen }}
    </span>

</div>

                                <td>
    @php
        $badge = match($dokumen->kategori?->warna) {
            'primary'   => 'badge-modern-navy',
            'warning'   => 'badge-modern-yellow',
            'info'      => 'badge-modern-info',
            'success'   => 'badge-modern-green',
            'danger'    => 'badge-modern-red',
            'purple'    => 'badge-modern-purple',
            'pink'      => 'badge-modern-pink',
            'teal'      => 'badge-modern-teal',
            'orange'    => 'badge-modern-orange',
            'indigo'    => 'badge-modern-indigo',
            'cyan'      => 'badge-modern-cyan',
            'secondary' => 'badge-modern-gray',
            default     => 'badge-modern-gray',
        };
    @endphp

    <span class="badge rounded-pill {{ $badge }}">
        {{ $dokumen->kategori?->nama ?? 'Kategori tidak tersedia' }}
    </span>
</td>
                                <td>{{ $dokumen->tanggal_dokumen->format('d M Y') }}</td>
                                <td>{{ $dokumen->uploader->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('dokumen.show', $dokumen) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('dokumen.download', $dokumen) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-download"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada dokumen.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-panel p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
    <i class="bi bi-pie-chart-fill text-bulog-navy"></i>
    Statistik Dokumen
</h6>
            </div>

            <div class="text-center mb-2">

    <div class="chart-wrapper mx-auto">

        <canvas id="kategoriChart"></canvas>

        <div class="chart-center">

            <div class="chart-total">
                {{ $totalDokumen }}
            </div>

            <div class="chart-label">
                Dokumen
            </div>

        </div>

    </div>

</div>

            <ul class="list-unstyled mb-0">
                @foreach ($kategoris as $kategori)
                    <li class="d-flex justify-content-between align-items-center py-2 border-top">
                        <span class="d-flex align-items-center gap-2 small">
                       <span
    class="d-inline-block rounded-circle kategori-dot-{{ $kategori->warna ?? 'secondary' }}"
    style="width:14px;height:14px;">
</span>
                            {{ $kategori->nama }}
                        </span>
                        <span class="fw-semibold small">{{ $kategori->dokumens_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('kategoriChart'),{

type:'doughnut',

data:{

labels: @json($kategoris->pluck('nama')),

datasets:[{

data: @json($kategoris->pluck('dokumens_count')),

backgroundColor: [
    @foreach($kategoris as $k)
        @switch($k->warna)

            @case('primary')
                '#0A2E6E',
                @break

            @case('warning')
                '#F5A623',
                @break

            @case('info')
                '#06B6D4',
                @break

            @case('success')
                '#22C55E',
                @break

            @case('danger')
                '#EF4444',
                @break

            @case('purple')
                '#7C3AED',
                @break

            @case('pink')
                '#EC4899',
                @break

            @case('teal')
                '#0D9488',
                @break

            @case('orange')
                '#F97316',
                @break

            @case('indigo')
                '#6366F1',
                @break

            @case('cyan')
                '#06B6D4',
                @break

            @case('secondary')
                '#6B7280',
                @break

            @default
                '#6B7280',

        @endswitch
    @endforeach
]

}]

},

options: {
    plugins: {
        legend: {
            display: false
        }
    },
    cutout: '76%'
}

});

</script>

@endpush