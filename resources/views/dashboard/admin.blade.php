@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="dashboard-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h2 class="fw-bold mb-2">
                Selamat Datang Kembali
            </h2>

            <p class="text-muted mb-0">
                Kelola dan akses dokumen dengan lebih mudah dan cepat.
            </p>
        </div>

        <div class="date-box">
            <i class="bi bi-calendar-event"></i>
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </div>

    </div>
</div>

<div class="row g-3 mb-4">
    @php
        $warnaIkon = ['primary' => 'bg-bulog-navy', 'warning' => 'bg-bulog-yellow', 'info' => 'bg-info', 'secondary' => 'bg-secondary'];
    @endphp
    @foreach ($kategoris as $kategori)
        <div class="col-6 col-lg-3">
            <a href="{{ route('dokumen.index', ['kategori_id' => $kategori->id]) }}" class="text-decoration-none">
                <div class="stat-card stat-card-{{ $kategori->warna }} d-flex align-items-start justify-content-between h-100">
                    <div class="d-flex gap-3">
                        <div class="stat-icon {{ $warnaIkon[$kategori->warna] ?? 'bg-bulog-navy' }}">
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

                                </td>
                                                                <td>
                                    @php
                                        $badge = match($dokumen->kategori->warna){
                                            'primary' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                            'warning' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                                            'info' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
                                            default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                        };
                                    @endphp

                                    <span class="badge rounded-pill {{ $badge }}">
                                        {{ $dokumen->kategori->nama }}
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
                            <span class="d-inline-block rounded-circle {{ $warnaIkon[$kategori->warna] ?? 'bg-bulog-navy' }}" style="width:10px;height:10px;"></span>
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

labels:[
@foreach($kategoris as $k)
'{{ $k->nama }}',
@endforeach
],

datasets:[{

data:[
@foreach($kategoris as $k)
{{ $k->dokumens_count }},
@endforeach
],

backgroundColor:[
'#1D4ED8',
'#F59E0B',
'#06B6D4',
'#6B7280'
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
